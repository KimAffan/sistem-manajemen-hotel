<?php

namespace App\Controllers;

use App\Models\HousekeepingTaskModel;
use App\Models\RoomModel;
use CodeIgniter\Controller;

class Housekeeping extends Controller
{
    protected $model;
    protected $roomModel;

    public function __construct()
    {
        $this->model     = new HousekeepingTaskModel();
        $this->roomModel = new RoomModel();
        helper(['form', 'url', 'status']);
    }

    // ======================================================
    // LIST TUGAS
    // ======================================================
   public function index()
{
    $perPage = (int) ($this->request->getGet('per_page') ?? 10);
    if (! in_array($perPage, [10, 20, 50, 100])) {
        $perPage = 10;
    }

    $q      = trim((string) $this->request->getGet('q'));
    $status = $this->request->getGet('status') ?? 'all';

    $this->model
        ->select('housekeeping_tasks.*, rooms.room_number, rooms.floor, room_types.name AS room_type_name, users.username AS staff_name')
        ->join('rooms', 'rooms.id = housekeeping_tasks.room_id', 'left')
        ->join('room_types', 'room_types.id = rooms.room_type_id', 'left')
        ->join('users', 'users.id = housekeeping_tasks.assigned_to', 'left');

    if ($q !== '') {
        $this->model->groupStart()
            ->like('rooms.room_number', $q)
            ->orLike('users.username', $q)
            ->groupEnd();
    }

    if ($status !== 'all') {
        $this->model->where('housekeeping_tasks.status', $status);
    }

    $tasks = $this->model->orderBy('housekeeping_tasks.created_at', 'DESC')->paginate($perPage);

    $db = \Config\Database::connect();
    $staffs = $db->table('users u')
        ->select('u.id, u.username, GROUP_CONCAT(g.`group` SEPARATOR ", ") AS role_names')
        ->join('auth_groups_users g', 'g.user_id = u.id', 'left')
        ->whereIn('g.`group`', ['housekeeping', 'admin', 'superadmin', 'manager'])
        ->groupBy('u.id')
        ->orderBy('u.username', 'ASC')
        ->get()->getResultArray();

    return view('housekeeping/index', [
        'title'   => 'Housekeeping - Sistem Hotel',
        'tasks'   => $tasks,
        'pager'   => $this->model->pager,
        'perPage' => $perPage,
        'q'       => $q,
        'status'  => $status,
        'rooms'   => $this->roomModel
            ->select('rooms.*, room_types.name AS type_name')
            ->join('room_types', 'room_types.id = rooms.room_type_id', 'left')
            ->orderBy('rooms.floor', 'ASC')
            ->orderBy('rooms.room_number', 'ASC')
            ->findAll(),
        'staffs'  => $staffs,
    ]);
}
    // ======================================================
    // SIMPAN TUGAS BARU
    // ======================================================
    public function store()
    {
        $data = [
            'room_id'     => (int) $this->request->getPost('room_id'),
            'assigned_to' => (int) $this->request->getPost('assigned_to') ?: null,
            'task_type'   => $this->request->getPost('task_type'),
            'status'      => 'pending',
            'notes'       => $this->request->getPost('notes'),
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-create');
        }

        return redirect()->to('/housekeeping')->with('success', 'Tugas housekeeping berhasil dibuat.');
    }

    // ======================================================
    // UPDATE TUGAS
    // ======================================================
    public function update($id = null)
    {
        $task = $this->model->find($id);
        if (! $task) {
            return redirect()->to('/housekeeping')->with('error', 'Tugas tidak ditemukan.');
        }

        $data = [
            'id'          => $id,
            'room_id'     => (int) $this->request->getPost('room_id'),
            'assigned_to' => (int) $this->request->getPost('assigned_to') ?: null,
            'task_type'   => $this->request->getPost('task_type'),
            'notes'       => $this->request->getPost('notes'),
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-edit');
        }

        return redirect()->to('/housekeeping')->with('success', 'Tugas berhasil diperbarui.');
    }

    // ======================================================
    // UPDATE STATUS (workflow)
    // ======================================================
    public function updateStatus($id = null)
    {
        $task = $this->model->find($id);
        if (! $task) {
            return redirect()->to('/housekeeping')->with('error', 'Tugas tidak ditemukan.');
        }

        $newStatus = $this->request->getPost('status');
        $allowed   = ['pending', 'in_progress', 'done', 'verified'];

        if (! in_array($newStatus, $allowed)) {
            return redirect()->to('/housekeeping')->with('error', 'Status tidak valid.');
        }

        $update = ['status' => $newStatus];

        // Log waktu
        if ($newStatus === 'in_progress' && empty($task['started_at'])) {
            $update['started_at'] = date('Y-m-d H:i:s');
        }
        if ($newStatus === 'done' && empty($task['completed_at'])) {
            $update['completed_at'] = date('Y-m-d H:i:s');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->model->update($id, $update);

        // Sinkronisasi: kalau tugas selesai & tipe checkout_clean, ubah kamar jadi vacant_clean
        if ($newStatus === 'done' && $task['task_type'] === 'checkout_clean') {
            $this->roomModel->update($task['room_id'], ['status' => 'vacant_clean']);
        }

        $db->transComplete();

        return redirect()->to('/housekeeping')->with('success', 'Status tugas berhasil diubah.');
    }

    // ======================================================
    // UPLOAD FOTO KONDISI KAMAR
    // ======================================================
    public function uploadPhoto($id = null)
    {
        $task = $this->model->find($id);
        if (! $task) {
            return redirect()->to('/housekeeping')->with('error', 'Tugas tidak ditemukan.');
        }

        $file = $this->request->getFile('photo');
        if (! $file || ! $file->isValid()) {
            return redirect()->to('/housekeeping')->with('error', 'File tidak valid.');
        }

        // Validasi: hanya gambar, max 2MB
        if (! in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
            return redirect()->to('/housekeeping')->with('error', 'Hanya file JPG, PNG, atau WEBP yang diizinkan.');
        }
        if ($file->getSize() > 2 * 1024 * 1024) {
            return redirect()->to('/housekeeping')->with('error', 'Ukuran file maksimal 2MB.');
        }

        // Simpan file
        $newName = 'hk_' . $id . '_' . time() . '.' . $file->getExtension();
        $file->move(FCPATH . 'uploads/housekeeping', $newName);

        // Hapus foto lama kalau ada
        if (! empty($task['photo']) && file_exists(FCPATH . 'uploads/housekeeping/' . $task['photo'])) {
            @unlink(FCPATH . 'uploads/housekeeping/' . $task['photo']);
        }

        // Update database
        $this->model->update($id, ['photo' => $newName]);

        return redirect()->to('/housekeeping')->with('success', 'Foto kondisi kamar berhasil diupload.');
    }

    // ======================================================
    // HAPUS TUGAS
    // ======================================================
    public function delete($id = null)
    {
        $task = $this->model->find($id);
        if (! $task) {
            return redirect()->to('/housekeeping')->with('error', 'Tugas tidak ditemukan.');
        }

        // Hapus file foto kalau ada
        if (! empty($task['photo']) && file_exists(FCPATH . 'uploads/housekeeping/' . $task['photo'])) {
            @unlink(FCPATH . 'uploads/housekeeping/' . $task['photo']);
        }

        $this->model->delete($id);
        return redirect()->to('/housekeeping')->with('success', 'Tugas berhasil dihapus.');
    }
}