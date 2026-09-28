<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Report extends Controller
{
    public function __construct()
    {
        helper(['form', 'url', 'status']);
    }
    // ======================================================
// EXPORT PDF (dengan chart image)
// ======================================================
public function pdf()
{
    $dataJson   = $this->request->getPost('data');
    $chartsJson = $this->request->getPost('charts');

    $data        = json_decode($dataJson, true);
    $chartImages = json_decode($chartsJson, true);

    if (! $data) {
        return redirect()->to('/reports')->with('error', 'Data laporan tidak ditemukan.');
    }

    $html = view('reports/pdf', [
        'data'        => $data,
        'charts'      => $chartImages,
        'generatedAt' => date('d F Y H:i'),
    ]);

    $dompdf = new \Dompdf\Dompdf([
        'isRemoteEnabled'      => false,
        'isHtml5ParserEnabled' => true,
    ]);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $filename = 'Laporan-' . date('Ymd-His') . '.pdf';
    $dompdf->stream($filename, ['Attachment' => true]);
    exit;
}

    // ======================================================
    // HALAMAN UTAMA LAPORAN
    // ======================================================
    public function index()
    {
        return view('reports/index', [
            'title' => 'Laporan - Sistem Hotel',
        ]);
    }

    // ======================================================
    // AJAX: Ambil data statistik untuk grafik
    // ======================================================
    public function data()
    {
        $period = $this->request->getGet('period') ?? '30days';
        $db     = \Config\Database::connect();

        // Tentukan rentang tanggal
        [$startDate, $endDate] = $this->getDateRange($period);

        // ============ 1. RINGKASAN UMUM ============
        $totalRevenue = $db->table('reservations')
            ->selectSum('total_price')
            ->where('check_in_date >=', $startDate)
            ->where('check_in_date <=', $endDate)
            ->where('status !=', 'cancelled')
            ->get()->getRow()->total_price ?? 0;

        $totalReservations = $db->table('reservations')
            ->where('check_in_date >=', $startDate)
            ->where('check_in_date <=', $endDate)
            ->where('status !=', 'cancelled')
            ->countAllResults();

      $totalRooms    = $db->table('rooms')->countAllResults();
$occupiedRooms = $db->table('rooms')->where('status', 'occupied')->countAllResults();

// =====================================================
// OKUPANSI PERIODE (bukan snapshot hari ini)
// Rumus: (total room-nights terpakai) / (total room-nights tersedia) * 100
// =====================================================
$nightsData = $db->query("
    SELECT SUM(DATEDIFF(check_out_date, check_in_date)) AS total_nights
    FROM reservations
    WHERE status != 'cancelled'
        AND check_in_date <= ?
        AND check_out_date >= ?
", [$endDate, $startDate])->getRow();

$totalRoomNightsUsed = (int) ($nightsData->total_nights ?? 0);

$periodDays           = (int) ((strtotime($endDate) - strtotime($startDate)) / 86400) + 1;
$totalRoomNightsAvail = $totalRooms * $periodDays;

$occupancyRate = $totalRoomNightsAvail > 0
    ? round(($totalRoomNightsUsed / $totalRoomNightsAvail) * 100, 1)
    : 0;
        $totalItems = $db->table('sr_details')
            ->selectSum('quantity_approved')
            ->whereIn('sr_id', function ($builder) use ($startDate, $endDate) {
                $builder->select('id')->from('store_requisitions')
                    ->where('status', 'delivered')
                    ->where('requested_date >=', $startDate)
                    ->where('requested_date <=', $endDate);
            })
            ->get()->getRow()->quantity_approved ?? 0;

        // ============ 2. GRAFIK PENDAPATAN PER HARI ============
        $revenueData = $db->query("
            SELECT DATE(check_in_date) AS tanggal, SUM(total_price) AS total
            FROM reservations
            WHERE check_in_date >= ? AND check_in_date <= ?
                AND status != 'cancelled'
            GROUP BY DATE(check_in_date)
            ORDER BY tanggal ASC
        ", [$startDate, $endDate])->getResultArray();

        // Fill missing dates dengan 0
        $revenueChart = $this->fillMissingDates($revenueData, $startDate, $endDate, 'tanggal', 'total');

        // ============ 3. GRAFIK OKUPANSI PER HARI ============
        // Okupansi = (jumlah kamar yang di-check-in hari itu) / total kamar * 100
        $occupancyData = $db->query("
            SELECT DATE(check_in_date) AS tanggal, COUNT(*) AS jumlah_reservasi
            FROM reservations
            WHERE check_in_date >= ? AND check_in_date <= ?
                AND status != 'cancelled'
            GROUP BY DATE(check_in_date)
            ORDER BY tanggal ASC
        ", [$startDate, $endDate])->getResultArray();

        $occupancyChart = $this->fillMissingDates($occupancyData, $startDate, $endDate, 'tanggal', 'jumlah_reservasi');
        // Convert ke persentase
        foreach ($occupancyChart['values'] as &$v) {
            $v = $totalRooms > 0 ? round(($v / $totalRooms) * 100, 1) : 0;
        }
        unset($v);

        // ============ 4. PIE CHART STATUS KAMAR ============
        $roomStatusData = $db->query("
            SELECT status, COUNT(*) AS jumlah
            FROM rooms
            GROUP BY status
        ")->getResultArray();

        $roomStatusChart = [
            'labels' => [],
            'values' => [],
            'colors' => [],
        ];
        $colorMap = [
            'vacant_clean'   => '#146C2E',
            'vacant_dirty'   => '#F0B100',
            'occupied'       => '#BA1A1A',
            'on_change'      => '#1A56DB',
            'out_of_order'   => '#E65100',
            'out_of_service' => '#757575',
        ];
        foreach ($roomStatusData as $r) {
            $roomStatusChart['labels'][] = ucwords(str_replace('_', ' ', $r['status']));
            $roomStatusChart['values'][] = (int) $r['jumlah'];
            $roomStatusChart['colors'][] = $colorMap[$r['status']] ?? '#ccc';
        }

        // ============ 5. TOP 5 KAMAR PALING SERING DIPESAN ============
        $topRooms = $db->query("
            SELECT ro.room_number, ro.floor, rt.name AS type_name, COUNT(rr.id) AS total_bookings
            FROM reservation_rooms rr
            JOIN reservations r ON r.id = rr.reservation_id
            JOIN rooms ro ON ro.id = rr.room_id
            LEFT JOIN room_types rt ON rt.id = ro.room_type_id
            WHERE r.check_in_date >= ? AND r.check_in_date <= ?
                AND r.status != 'cancelled'
            GROUP BY rr.room_id
            ORDER BY total_bookings DESC
            LIMIT 5
        ", [$startDate, $endDate])->getResultArray();

        // ============ 6. TOP 5 BARANG PALING BANYAK DIMINTA (via SR) ============
        $topItems = $db->query("
            SELECT i.name, i.unit, SUM(sd.quantity_approved) AS total_qty
            FROM sr_details sd
            JOIN items i ON i.id = sd.item_id
            JOIN store_requisitions sr ON sr.id = sd.sr_id
            WHERE sr.requested_date >= ? AND sr.requested_date <= ?
                AND sr.status = 'delivered'
            GROUP BY sd.item_id
            ORDER BY total_qty DESC
            LIMIT 5
        ", [$startDate, $endDate])->getResultArray();

        // ============ 7. TOP DEPARTEMEN PEMINTA ============
        $topDepartments = $db->query("
            SELECT department, COUNT(*) AS total_sr
            FROM store_requisitions
            WHERE requested_date >= ? AND requested_date <= ?
            GROUP BY department
            ORDER BY total_sr DESC
        ", [$startDate, $endDate])->getResultArray();

        $deptLabels = [];
        $deptValues = [];
        foreach ($topDepartments as $d) {
            $deptLabels[] = department_label($d['department']);
            $deptValues[] = (int) $d['total_sr'];
        }

        return $this->response->setJSON([
            'success' => true,
            'period'  => [
                'start' => $startDate,
                'end'   => $endDate,
                'label' => $this->getPeriodLabel($period),
            ],
            'summary' => [
                'total_revenue'      => (float) $totalRevenue,
                'total_reservations' => (int) $totalReservations,
                'total_rooms'        => (int) $totalRooms,
                'occupied_rooms'     => (int) $occupiedRooms,
                'occupancy_rate'     => $occupancyRate,
                'total_items'        => (int) $totalItems,
            ],
            'revenue_chart' => [
                'labels' => $revenueChart['labels'],
                'values' => $revenueChart['values'],
            ],
            'occupancy_chart' => [
                'labels' => $occupancyChart['labels'],
                'values' => $occupancyChart['values'],
            ],
            'room_status_chart' => $roomStatusChart,
            'top_rooms'         => $topRooms,
            'top_items'         => $topItems,
            'department_chart'  => [
                'labels' => $deptLabels,
                'values' => $deptValues,
            ],
        ]);
    }

    // ======================================================
    // Helper: Tentukan rentang tanggal
    // ======================================================
    private function getDateRange(string $period): array
    {
        $today = date('Y-m-d');

        switch ($period) {
            case '7days':
                return [date('Y-m-d', strtotime('-6 days')), $today];
            case '30days':
                return [date('Y-m-d', strtotime('-29 days')), $today];
            case 'this_month':
                return [date('Y-m-01'), $today];
            case 'last_month':
                return [
                    date('Y-m-01', strtotime('first day of last month')),
                    date('Y-m-t', strtotime('last day of last month')),
                ];
            case 'this_year':
                return [date('Y-01-01'), $today];
            default:
                return [date('Y-m-d', strtotime('-29 days')), $today];
        }
    }

    private function getPeriodLabel(string $period): string
    {
        return match ($period) {
            '7days'      => '7 Hari Terakhir',
            '30days'     => '30 Hari Terakhir',
            'this_month' => 'Bulan Ini',
            'last_month' => 'Bulan Lalu',
            'this_year'  => 'Tahun Ini',
            default      => 'Periode',
        };
    }

    // ======================================================
    // Helper: Isi tanggal yang kosong dengan 0
    // ======================================================
    private function fillMissingDates(array $data, string $start, string $end, string $dateKey, string $valueKey): array
    {
        $indexed = [];
        foreach ($data as $row) {
            $indexed[$row[$dateKey]] = $row[$valueKey];
        }

        $labels = [];
        $values = [];
        $current = strtotime($start);
        $endTime = strtotime($end);

        while ($current <= $endTime) {
            $date = date('Y-m-d', $current);
            $labels[] = date('d M', $current);
            $values[] = (float) ($indexed[$date] ?? 0);
            $current = strtotime('+1 day', $current);
        }

        return ['labels' => $labels, 'values' => $values];
    }
}