<?php

namespace App\Controllers;

use App\Models\AppSettingModel;
use CodeIgniter\Controller;

class Settings extends Controller
{
    protected $settingModel;

   public function __construct()
{
    $this->settingModel = new AppSettingModel();
    helper(['form', 'url', 'setting']);
}

    // ======================================================
    // HALAMAN PENGATURAN
    // ======================================================
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil users beserta role mereka
        $users = $db->table('users u')
            ->select('u.*, GROUP_CONCAT(g.`group` SEPARATOR ", ") AS role_names')
            ->join('auth_groups_users g', 'g.user_id = u.id', 'left')
            ->groupBy('u.id')
            ->orderBy('u.username', 'ASC')
            ->get()->getResultArray();

        return view('settings/index', [
            'title'    => 'Pengaturan - Sistem Hotel',
            'settings' => $this->settingModel->getAllKeyed(),
            'users'    => $users,
            'groups'   => ['admin', 'manager', 'front_office', 'housekeeping', 'purchasing'],
        ]);
    }

    // ======================================================
    // SIMPAN IDENTITAS HOTEL
    // ======================================================
    public function saveHotel()
    {
        $data = [
            'hotel_name'    => $this->request->getPost('hotel_name'),
            'hotel_address' => $this->request->getPost('hotel_address'),
            'hotel_phone'   => $this->request->getPost('hotel_phone'),
            'hotel_email'   => $this->request->getPost('hotel_email'),
        ];

        // Upload logo kalau ada
        $file = $this->request->getFile('hotel_logo');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $allowed = ['image/jpeg', 'image/png', 'image/svg+xml'];
            if (! in_array($file->getMimeType(), $allowed)) {
                return redirect()->back()->with('error', 'Logo harus JPG, PNG, atau SVG.');
            }
            if ($file->getSize() > 1024 * 1024) {
                return redirect()->back()->with('error', 'Ukuran logo maksimal 1MB.');
            }

            $newName = 'logo_' . time() . '.' . $file->getExtension();
            $file->move(FCPATH . 'uploads/logo', $newName);

            // Hapus logo lama
            $oldLogo = $this->settingModel->getValue('hotel_logo');
            if ($oldLogo && file_exists(FCPATH . 'uploads/logo/' . $oldLogo)) {
                @unlink(FCPATH . 'uploads/logo/' . $oldLogo);
            }

            $data['hotel_logo'] = $newName;
        }

        $this->settingModel->setMany($data);

        return redirect()->to('/settings')->with('success', 'Identitas hotel berhasil disimpan.');
    }

    // ======================================================
    // SIMPAN PAJAK & SERVICE
    // ======================================================
    public function saveTax()
    {
        $data = [
            'tax_percentage'     => (float) $this->request->getPost('tax_percentage'),
            'service_percentage' => (float) $this->request->getPost('service_percentage'),
            'currency'           => $this->request->getPost('currency') ?: 'IDR',
        ];

        $this->settingModel->setMany($data);

        return redirect()->to('/settings')->with('success', 'Konfigurasi pajak berhasil disimpan.');
    }

    // ======================================================
    // USER MANAGEMENT
    // ======================================================
    public function userStore()
    {
        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');

        if (! $username || ! $email || ! $password || ! $role) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.');
        }

        $userModel = auth()->getProvider();

        try {
            $user = new \CodeIgniter\Shield\Entities\User([
                'username' => $username,
                'email'    => $email,
                'password' => $password,
            ]);
            $userModel->save($user);

            $userId = $userModel->getInsertID();
            $userModel->addToDefaultGroup($userModel->findById($userId));
            $userModel->findById($userId)->addGroup($role);
            $userModel->findById($userId)->activate();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambah user: ' . $e->getMessage());
        }

        return redirect()->to('/settings')->with('success', 'User berhasil ditambahkan.');
    }

    public function userUpdate($id = null)
    {
        $userModel = auth()->getProvider();
        $user      = $userModel->findById($id);

        if (! $user) {
            return redirect()->to('/settings')->with('error', 'User tidak ditemukan.');
        }

        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $role     = $this->request->getPost('role');

        $user->username = $username;
        $user->email    = $email;
        $userModel->save($user);

        // Reset group
        if ($role) {
            $user->syncGroups($role);
        }

        return redirect()->to('/settings')->with('success', 'User berhasil diperbarui.');
    }

    public function userResetPassword($id = null)
    {
        $userModel = auth()->getProvider();
        $user      = $userModel->findById($id);

        if (! $user) {
            return redirect()->to('/settings')->with('error', 'User tidak ditemukan.');
        }

        $newPassword = $this->request->getPost('new_password');
        if (! $newPassword || strlen($newPassword) < 8) {
            return redirect()->to('/settings')->with('error', 'Password minimal 8 karakter.');
        }

        $user->password = $newPassword;
        $userModel->save($user);

        return redirect()->to('/settings')->with('success', 'Password berhasil direset.');
    }

    public function userDelete($id = null)
    {
        // Tidak boleh hapus diri sendiri
        if ((int) $id === auth()->id()) {
            return redirect()->to('/settings')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $userModel = auth()->getProvider();
        $user      = $userModel->findById($id);

        if (! $user) {
            return redirect()->to('/settings')->with('error', 'User tidak ditemukan.');
        }

        $userModel->delete($id);

        return redirect()->to('/settings')->with('success', 'User berhasil dihapus.');
    }
}