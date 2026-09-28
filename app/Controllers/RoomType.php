<?php

namespace App\Controllers;

use App\Models\RoomTypeModel;
use CodeIgniter\Controller;

class RoomType extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new RoomTypeModel();
        helper(['form', 'url']);
    }

    // ========================================================
    // Tampilkan daftar tipe kamar + semua dialog (create, edit, delete)
    // ========================================================
    public function index()
    {
        $data = [
            'title'     => 'Tipe Kamar - Sistem Hotel',
            'roomTypes' => $this->model->orderBy('name', 'ASC')->findAll(),
        ];

        return view('room_types/index', $data);
    }

    // ========================================================
    // Simpan data baru (dipanggil dari dialog Create)
    // ========================================================
    public function store()
    {
        $data = [
            'name'        => $this->request->getPost('name'),
            'base_price'  => $this->request->getPost('base_price'),
            'capacity'    => $this->request->getPost('capacity'),
            'description' => $this->request->getPost('description'),
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-create'); // buka kembali dialog Create
        }

        return redirect()->to('/room-types')
            ->with('success', 'Tipe kamar berhasil ditambahkan.');
    }

    // ========================================================
    // Update data (dipanggil dari dialog Edit)
    // ========================================================
    public function update($id = null)
    {
        // Pastikan data yang akan diupdate ada
        $roomType = $this->model->find($id);

        if (! $roomType) {
            return redirect()->to('/room-types')
                ->with('error', 'Tipe kamar tidak ditemukan.');
        }

        $data = [
            'id'          => $id,
            'name'        => $this->request->getPost('name'),
            'base_price'  => $this->request->getPost('base_price'),
            'capacity'    => $this->request->getPost('capacity'),
            'description' => $this->request->getPost('description'),
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-edit'); // buka kembali dialog Edit
        }

        return redirect()->to('/room-types')
            ->with('success', 'Tipe kamar berhasil diperbarui.');
    }

    // ========================================================
    // Hapus data (dipanggil dari dialog Delete)
    // ========================================================
    public function delete($id = null)
    {
        $roomType = $this->model->find($id);

        if (! $roomType) {
            return redirect()->to('/room-types')
                ->with('error', 'Tipe kamar tidak ditemukan.');
        }

        // Cek apakah tipe kamar masih dipakai oleh kamar lain
        $roomModel = new \App\Models\RoomModel();
        $usedCount = $roomModel->where('room_type_id', $id)->countAllResults();

        if ($usedCount > 0) {
            return redirect()->to('/room-types')
                ->with('error', "Tidak bisa dihapus. Ada {$usedCount} kamar yang masih memakai tipe ini.");
        }

        $this->model->delete($id);

        return redirect()->to('/room-types')
            ->with('success', 'Tipe kamar berhasil dihapus.');
    }
}