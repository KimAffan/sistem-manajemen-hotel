<?php

namespace App\Controllers;

use App\Models\RoomModel;
use CodeIgniter\Controller;

class RoomMap extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new RoomModel();
        helper(['form', 'url', 'status']);
    }

    public function index()
    {
        return view('room_map/index', [
            'title' => 'Denah Kamar - Sistem Hotel',
        ]);
    }

    // Endpoint AJAX: kembalikan data semua kamar dalam JSON
    public function data()
    {
        $rooms = $this->model
            ->select('rooms.*, room_types.name AS type_name, room_types.base_price')
            ->join('room_types', 'room_types.id = rooms.room_type_id', 'left')
            ->orderBy('rooms.floor', 'ASC')
            ->orderBy('rooms.room_number', 'ASC')
            ->findAll();

        // Kelompokkan per lantai
        $floors = [];
        foreach ($rooms as $r) {
            $floors[$r['floor']][] = $r;
        }
        ksort($floors);

        return $this->response->setJSON([
            'success' => true,
            'floors'  => $floors,
        ]);
    }

    // Endpoint AJAX: ubah status kamar
    public function updateStatus($id = null)
    {
        $room = $this->model->find($id);

        if (! $room) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kamar tidak ditemukan.',
            ])->setStatusCode(404);
        }

        $newStatus = $this->request->getPost('status');
        $allowed = ['vacant_clean', 'vacant_dirty', 'occupied', 'on_change', 'out_of_order', 'out_of_service'];

        if (! in_array($newStatus, $allowed)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status tidak valid.',
            ])->setStatusCode(400);
        }

        $this->model->update($id, ['status' => $newStatus]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status kamar berhasil diperbarui.',
            'new_status' => $newStatus,
        ]);
    }
}