<?php

namespace App\Controllers;

use App\Models\RoomModel;
use App\Models\RoomTypeModel;
use CodeIgniter\Controller;

class Room extends Controller
{
    protected $model;
    protected $roomTypeModel;

    public function __construct()
{
    $this->model         = new RoomModel();
    $this->roomTypeModel = new RoomTypeModel();
    helper(['form', 'url', 'status']); // <-- Tambahkan 'status' di sini
}

    public function index()
    {
        $data = [
            'title'     => 'Kamar - Sistem Hotel',
            'rooms'     => $this->model
                ->select('rooms.*, room_types.name AS type_name')
                ->join('room_types', 'room_types.id = rooms.room_type_id', 'left')
                ->orderBy('rooms.floor', 'ASC')
                ->orderBy('rooms.room_number', 'ASC')
                ->findAll(),
            'roomTypes' => $this->roomTypeModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('rooms/index', $data);
    }

    public function store()
    {
        $data = [
            'room_number'  => $this->request->getPost('room_number'),
            'room_type_id' => $this->request->getPost('room_type_id'),
            'floor'        => $this->request->getPost('floor'),
            'status'       => $this->request->getPost('status'),
            'notes'        => $this->request->getPost('notes'),
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-create');
        }

        return redirect()->to('/rooms')
            ->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function update($id = null)
    {
        $room = $this->model->find($id);

        if (! $room) {
            return redirect()->to('/rooms')
                ->with('error', 'Kamar tidak ditemukan.');
        }

        $data = [
            'id'           => $id,
            'room_number'  => $this->request->getPost('room_number'),
            'room_type_id' => $this->request->getPost('room_type_id'),
            'floor'        => $this->request->getPost('floor'),
            'status'       => $this->request->getPost('status'),
            'notes'        => $this->request->getPost('notes'),
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-edit');
        }

        return redirect()->to('/rooms')
            ->with('success', 'Kamar berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $room = $this->model->find($id);

        if (! $room) {
            return redirect()->to('/rooms')
                ->with('error', 'Kamar tidak ditemukan.');
        }

        $this->model->delete($id);
        return redirect()->to('/rooms')
            ->with('success', 'Kamar berhasil dihapus.');
    }
}