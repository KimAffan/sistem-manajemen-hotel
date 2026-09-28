<?php

namespace App\Controllers;

use App\Models\RoomModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        // Cek login
        if (! auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        $roomModel = new RoomModel();

        // Statistik Kamar
        $totalRooms    = $roomModel->countAllResults();
        $occupiedRooms = $roomModel->where('status', 'occupied')->countAllResults();
        
        // Hitung okupansi (%)
        $occupancyRate = $totalRooms > 0 
            ? round(($occupiedRooms / $totalRooms) * 100) 
            : 0;

      // Pendapatan hari ini — dihitung dari reservasi yang check-in hari ini
$db = \Config\Database::connect();
$todayRevenue = 0;
try {
    $row = $db->table('reservations')
        ->selectSum('total_price')
        ->where('DATE(check_in_date)', date('Y-m-d'))
        ->where('status !=', 'cancelled')
        ->get()
        ->getRow();
    $todayRevenue = $row->total_price ?? 0;
}
 catch (\Exception $e) {
    $todayRevenue = 0;
}

        // Status kamar untuk ringkasan
        $roomStatus = [
            'vacant_clean'  => $roomModel->where('status', 'vacant_clean')->countAllResults(),
            'occupied'      => $occupiedRooms,
            'vacant_dirty'  => $roomModel->where('status', 'vacant_dirty')->countAllResults(),
            'out_of_order'  => $roomModel->where('status', 'out_of_order')->countAllResults(),
        ];

        return view('dashboard/index', [
            'title'          => 'Dashboard - Sistem Hotel',
            'user'           => auth()->user(),
            'totalRooms'     => $totalRooms,
            'occupiedRooms'  => $occupiedRooms,
            'occupancyRate'  => $occupancyRate,
            'todayRevenue'   => $todayRevenue,
            'roomStatus'     => $roomStatus,
        ]);
    }
}