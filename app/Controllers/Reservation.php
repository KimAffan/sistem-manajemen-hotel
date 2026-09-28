<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use App\Models\ReservationRoomModel;
use App\Models\GuestModel;
use App\Models\RoomModel;
use CodeIgniter\Controller;

class Reservation extends Controller
{
    protected $model;
    protected $roomModel;
    protected $guestModel;
    protected $roomModelForReservation;

    public function __construct()
    {
        $this->model                = new ReservationModel();
        $this->roomModelForReservation = new ReservationRoomModel();
        $this->guestModel           = new GuestModel();
        $this->roomModel            = new RoomModel();
        helper(['form', 'url', 'status']);
    }

    // ================================================
    // LIST RESERVASI
    // ================================================
    public function index()
{
    $perPage = (int) ($this->request->getGet('per_page') ?? 10);
    if (! in_array($perPage, [10, 20, 50, 100])) {
        $perPage = 10;
    }

    $q      = trim((string) $this->request->getGet('q'));
    $status = $this->request->getGet('status') ?? 'all';

    // Pakai Model langsung — paginate() hanya ada di Model
    $this->model
        ->select('reservations.*, guests.full_name AS guest_name, reservation_rooms.room_id, rooms.room_number, rooms.floor')
        ->join('guests', 'guests.id = reservations.guest_id', 'left')
        ->join('reservation_rooms', 'reservation_rooms.reservation_id = reservations.id', 'left')
        ->join('rooms', 'rooms.id = reservation_rooms.room_id', 'left');

    if ($q !== '') {
        $this->model->groupStart()
            ->like('reservations.reservation_code', $q)
            ->orLike('guests.full_name', $q)
            ->groupEnd();
    }

    if ($status !== 'all') {
        $this->model->where('reservations.status', $status);
    }

    $reservations = $this->model
        ->orderBy('reservations.created_at', 'DESC')
        ->paginate($perPage);

    $pager = $this->model->pager;

    return view('reservations/index', [
        'title'        => 'Reservasi - Sistem Hotel',
        'reservations' => $reservations,
        'pager'        => $pager,
        'perPage'      => $perPage,
        'q'            => $q,
        'status'       => $status,
        'guests'       => $this->guestModel->orderBy('full_name', 'ASC')->findAll(),
        'rooms'        => $this->roomModel
            ->select('rooms.*, room_types.name AS type_name, room_types.base_price')
            ->join('room_types', 'room_types.id = rooms.room_type_id', 'left')
            ->orderBy('rooms.room_number', 'ASC')
            ->findAll(),
    ]);
}

    // ================================================
    // SIMPAN RESERVASI BARU
    // ================================================
    public function store()
    {
        $guestId     = (int) $this->request->getPost('guest_id');
        $roomId      = (int) $this->request->getPost('room_id');
        $checkIn     = $this->request->getPost('check_in_date');
        $checkOut    = $this->request->getPost('check_out_date');
        $notes       = $this->request->getPost('notes');
        $totalPrice  = (float) $this->request->getPost('total_price');

        // Validasi dasar
        if ($guestId <= 0 || $roomId <= 0 || ! $checkIn || ! $checkOut) {
            return redirect()->back()->withInput()
                ->with('errors', ['Data tidak lengkap.'])
                ->with('open_dialog', 'dialog-create');
        }

        if (strtotime($checkOut) <= strtotime($checkIn)) {
            return redirect()->back()->withInput()
                ->with('errors', ['Tanggal check-out harus setelah check-in.'])
                ->with('open_dialog', 'dialog-create');
        }

        // Cek ketersediaan kamar
        if (! $this->model->isRoomAvailable($roomId, $checkIn, $checkOut)) {
            return redirect()->back()->withInput()
                ->with('errors', ['Kamar sudah dipesan pada tanggal tersebut. Pilih kamar atau tanggal lain.'])
                ->with('open_dialog', 'dialog-create');
        }

        // Ambil harga kamar
        $room = $this->roomModel
            ->select('rooms.*, room_types.base_price')
            ->join('room_types', 'room_types.id = rooms.room_type_id', 'left')
            ->find($roomId);

        if (! $room || ! $room['base_price']) {
            return redirect()->back()->withInput()
                ->with('errors', ['Tipe kamar tidak valid.'])
                ->with('open_dialog', 'dialog-create');
        }

        $pricePerNight = (float) $room['base_price'];
        $nights        = (int) ((strtotime($checkOut) - strtotime($checkIn)) / 86400);

        // Jika total dari frontend berbeda jauh, gunakan kalkulasi backend (aman)
        $calculatedTotal = $nights * $pricePerNight;
        if ($totalPrice <= 0) {
            $totalPrice = $calculatedTotal;
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Insert reservasi
        $reservationId = $this->model->insert([
            'reservation_code' => $this->model->generateCode(),
            'guest_id'         => $guestId,
            'check_in_date'    => $checkIn,
            'check_out_date'   => $checkOut,
            'total_price'      => $totalPrice,
            'status'           => 'pending',
            'notes'            => $notes,
            'created_by'       => auth()->id(),
        ]);

        // Insert relasi kamar
     // Insert relasi kamar
$this->roomModelForReservation->insert([
    'reservation_id'  => $reservationId,
    'room_id'         => $roomId,
    'price_per_night' => $pricePerNight,
    'created_at'      => date('Y-m-d H:i:s'),
]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()
                ->with('errors', ['Gagal menyimpan reservasi.'])
                ->with('open_dialog', 'dialog-create');
        }

        return redirect()->to('/reservations')->with('success', 'Reservasi berhasil dibuat.');
    }

    // ================================================
    // UPDATE RESERVASI (data dasar)
    // ================================================
    public function update($id = null)
    {
        $reservation = $this->model->find($id);
        if (! $reservation) {
            return redirect()->to('/reservations')->with('error', 'Reservasi tidak ditemukan.');
        }

        // Hanya reservasi pending/confirmed yang bisa diubah
        if (! in_array($reservation['status'], ['pending', 'confirmed'])) {
            return redirect()->to('/reservations')
                ->with('error', 'Reservasi dengan status ini tidak bisa diubah.');
        }

        $guestId  = (int) $this->request->getPost('guest_id');
        $roomId   = (int) $this->request->getPost('room_id');
        $checkIn  = $this->request->getPost('check_in_date');
        $checkOut = $this->request->getPost('check_out_date');
        $notes    = $this->request->getPost('notes');

        if (strtotime($checkOut) <= strtotime($checkIn)) {
            return redirect()->back()->withInput()
                ->with('errors', ['Tanggal check-out harus setelah check-in.'])
                ->with('open_dialog', 'dialog-edit');
        }

        if (! $this->model->isRoomAvailable($roomId, $checkIn, $checkOut, (int) $id)) {
            return redirect()->back()->withInput()
                ->with('errors', ['Kamar sudah dipesan pada tanggal tersebut.'])
                ->with('open_dialog', 'dialog-edit');
        }

        $room = $this->roomModel
            ->select('rooms.*, room_types.base_price')
            ->join('room_types', 'room_types.id = rooms.room_type_id', 'left')
            ->find($roomId);

        if (! $room || ! $room['base_price']) {
            return redirect()->back()->withInput()
                ->with('errors', ['Tipe kamar tidak valid.'])
                ->with('open_dialog', 'dialog-edit');
        }

        $pricePerNight = (float) $room['base_price'];
        $nights        = (int) ((strtotime($checkOut) - strtotime($checkIn)) / 86400);
        $totalPrice    = $nights * $pricePerNight;

        $db = \Config\Database::connect();
        $db->transStart();

        // Update reservasi
        $this->model->update($id, [
            'guest_id'        => $guestId,
            'check_in_date'   => $checkIn,
            'check_out_date'  => $checkOut,
            'total_price'     => $totalPrice,
            'notes'           => $notes,
        ]);

        // Update / insert relasi kamar
        $existing = $this->roomModelForReservation->where('reservation_id', $id)->first();
        if ($existing) {
            $this->roomModelForReservation->update($existing['id'], [
                'room_id'         => $roomId,
                'price_per_night' => $pricePerNight,
            ]);
        } else {
            $this->roomModelForReservation->insert([
                'reservation_id'  => $id,
                'room_id'         => $roomId,
                'price_per_night' => $pricePerNight,
            ]);
        }

        $db->transComplete();

        return redirect()->to('/reservations')->with('success', 'Reservasi berhasil diperbarui.');
    }

    // ================================================
    // UPDATE STATUS (workflow)
    // ================================================
    public function updateStatus($id = null)
    {
        $reservation = $this->model->find($id);
        if (! $reservation) {
            return redirect()->to('/reservations')->with('error', 'Reservasi tidak ditemukan.');
        }

        $newStatus = $this->request->getPost('status');
        $allowed   = ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'];

        if (! in_array($newStatus, $allowed)) {
            return redirect()->to('/reservations')->with('error', 'Status tidak valid.');
        }

        // Ambil kamar terkait
        $resRoom = $this->roomModelForReservation->where('reservation_id', $id)->first();
        $db = \Config\Database::connect();

        $db->transStart();

        // Update status reservasi
        $this->model->update($id, ['status' => $newStatus]);

        // Sinkronisasi status kamar
        if ($resRoom) {
            if ($newStatus === 'checked_in') {
                // Kamar jadi occupied
                $this->roomModel->update($resRoom['room_id'], ['status' => 'occupied']);
            } elseif ($newStatus === 'checked_out') {
                // Kamar jadi vacant_dirty (perlu dibersihkan)
                $this->roomModel->update($resRoom['room_id'], ['status' => 'vacant_dirty']);
            } elseif ($newStatus === 'cancelled') {
                // Kamar jadi vacant_clean kembali
                $this->roomModel->update($resRoom['room_id'], ['status' => 'vacant_clean']);
            }
        }

        $db->transComplete();

        return redirect()->to('/reservations')->with('success', 'Status reservasi berhasil diubah.');
    }

    // ================================================
    // HAPUS RESERVASI
    // ================================================
    public function delete($id = null)
    {
        $reservation = $this->model->find($id);
        if (! $reservation) {
            return redirect()->to('/reservations')->with('error', 'Reservasi tidak ditemukan.');
        }

        // Hanya boleh hapus jika pending/cancelled
        if (! in_array($reservation['status'], ['pending', 'cancelled'])) {
            return redirect()->to('/reservations')
                ->with('error', 'Reservasi yang sudah dikonfirmasi/check-in tidak bisa dihapus. Batalkan dulu.');
        }

        $this->model->delete($id);
        return redirect()->to('/reservations')->with('success', 'Reservasi berhasil dihapus.');
    }

    // ================================================
// GENERATE INVOICE PDF
// ================================================
public function invoice($id = null)
{
    $reservation = $this->model->find($id);
    if (! $reservation) {
        return redirect()->to('/reservations')->with('error', 'Reservasi tidak ditemukan.');
    }

    // Ambil data tamu
    $guest = $this->guestModel->find($reservation['guest_id']);
    if (! $guest) {
        return redirect()->to('/reservations')->with('error', 'Data tamu tidak ditemukan.');
    }

    // Ambil data kamar via relasi
    $db = \Config\Database::connect();
    $roomData = $db->table('reservation_rooms rr')
        ->select('rr.price_per_night, ro.room_number, ro.floor, rt.name AS type_name')
        ->join('rooms ro', 'ro.id = rr.room_id', 'left')
        ->join('room_types rt', 'rt.id = ro.room_type_id', 'left')
        ->where('rr.reservation_id', $id)
        ->get()->getRowArray();

    if (! $roomData) {
        return redirect()->to('/reservations')->with('error', 'Data kamar tidak ditemukan.');
    }

    // Perhitungan
    $checkIn  = strtotime($reservation['check_in_date']);
    $checkOut = strtotime($reservation['check_out_date']);
    $nights   = max(1, (int) (($checkOut - $checkIn) / 86400));

    $pricePerNight = (float) $roomData['price_per_night'];
    $subtotal      = $nights * $pricePerNight;
    $taxPct  = (float) app_setting('tax_percentage', 10) / 100;
$svcPct  = (float) app_setting('service_percentage', 5) / 100;
$tax     = $subtotal * $taxPct;
$service = $subtotal * $svcPct;
    $grandTotal    = $subtotal + $tax + $service;

    // Siapkan data untuk view
    $data = [
        'reservation'    => $reservation,
        'guest'          => $guest,
        'room'           => $roomData,
        'nights'         => $nights,
        'pricePerNight'  => $pricePerNight,
        'subtotal'       => $subtotal,
        'tax'            => $tax,
        'service'        => $service,
        'grandTotal'     => $grandTotal,
    ];

    // Render HTML view dulu
    $html = view('reservations/invoice', $data);

    // Load Dompdf
    $dompdf = new \Dompdf\Dompdf([
        'isRemoteEnabled' => false,
        'isHtml5ParserEnabled' => true,
    ]);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Nama file
    $filename = 'Invoice-' . $reservation['reservation_code'] . '.pdf';

    // Output PDF ke browser (attachment = langsung download)
    $dompdf->stream($filename, ['Attachment' => true]);
    exit;
}
    // ================================================
    // AJAX: Cek ketersediaan kamar
    // ================================================
    public function checkAvailability()
    {
        $roomId   = (int) $this->request->getPost('room_id');
        $checkIn  = $this->request->getPost('check_in_date');
        $checkOut = $this->request->getPost('check_out_date');
        $exclude  = (int) $this->request->getPost('exclude_id') ?: 0;

        if ($roomId <= 0 || ! $checkIn || ! $checkOut) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak lengkap.']);
        }

        $available = $this->model->isRoomAvailable($roomId, $checkIn, $checkOut, $exclude);

        return $this->response->setJSON([
            'success'   => true,
            'available' => $available,
            'message'   => $available ? 'Kamar tersedia.' : 'Kamar sudah dipesan di tanggal tersebut.',
        ]);
    }
}