<?php

namespace App\Controllers;

use App\Models\GuestModel;
use CodeIgniter\Controller;

class Guest extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new GuestModel();
        helper(['form', 'url']);
    }

   public function index()
{
    $perPage = (int) ($this->request->getGet('per_page') ?? 10);
    if (! in_array($perPage, [10, 20, 50, 100])) {
        $perPage = 10;
    }

    $q = trim((string) $this->request->getGet('q'));

    if ($q !== '') {
        $this->model
            ->groupStart()
                ->like('full_name', $q)
                ->orLike('phone', $q)
                ->orLike('email', $q)
                ->orLike('id_number', $q)
            ->groupEnd();
    }

    $guests = $this->model->orderBy('full_name', 'ASC')->paginate($perPage);

    return view('guests/index', [
        'title'   => 'Tamu - Sistem Hotel',
        'guests'  => $guests,
        'pager'   => $this->model->pager,
        'perPage' => $perPage,
        'q'       => $q,
    ]);
}

    public function store()
    {
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'id_number' => $this->request->getPost('id_number'),
            'phone'     => $this->request->getPost('phone'),
            'email'     => $this->request->getPost('email'),
            'address'   => $this->request->getPost('address'),
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-create');
        }

        return redirect()->to('/guests')->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function update($id = null)
    {
        $guest = $this->model->find($id);

        if (! $guest) {
            return redirect()->to('/guests')->with('error', 'Tamu tidak ditemukan.');
        }

        $data = [
            'id'        => $id,
            'full_name' => $this->request->getPost('full_name'),
            'id_number' => $this->request->getPost('id_number'),
            'phone'     => $this->request->getPost('phone'),
            'email'     => $this->request->getPost('email'),
            'address'   => $this->request->getPost('address'),
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-edit');
        }

        return redirect()->to('/guests')->with('success', 'Data tamu berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $guest = $this->model->find($id);

        if (! $guest) {
            return redirect()->to('/guests')->with('error', 'Tamu tidak ditemukan.');
        }

        // Cek apakah tamu masih punya reservasi aktif
        $db = \Config\Database::connect();
        $activeReservations = $db->table('reservations')
            ->where('guest_id', $id)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->countAllResults();

        if ($activeReservations > 0) {
            return redirect()->to('/guests')
                ->with('error', "Tidak bisa dihapus. Tamu ini punya {$activeReservations} reservasi aktif.");
        }

        $this->model->delete($id);
        return redirect()->to('/guests')->with('success', 'Tamu berhasil dihapus.');
    }
}