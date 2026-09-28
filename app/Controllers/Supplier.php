<?php

namespace App\Controllers;

use App\Models\SupplierModel;
use CodeIgniter\Controller;

class Supplier extends Controller
{
    protected $model;

    public function __construct()
    {
        $this->model = new SupplierModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        return view('suppliers/index', [
            'title'     => 'Supplier - Sistem Hotel',
            'suppliers' => $this->model->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $data = [
            'name'           => $this->request->getPost('name'),
            'contact_person' => $this->request->getPost('contact_person'),
            'phone'          => $this->request->getPost('phone'),
            'email'          => $this->request->getPost('email'),
            'address'        => $this->request->getPost('address'),
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-create');
        }

        return redirect()->to('/suppliers')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function update($id = null)
    {
        $supplier = $this->model->find($id);
        if (! $supplier) {
            return redirect()->to('/suppliers')->with('error', 'Supplier tidak ditemukan.');
        }

        $data = [
            'id'             => $id,
            'name'           => $this->request->getPost('name'),
            'contact_person' => $this->request->getPost('contact_person'),
            'phone'          => $this->request->getPost('phone'),
            'email'          => $this->request->getPost('email'),
            'address'        => $this->request->getPost('address'),
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-edit');
        }

        return redirect()->to('/suppliers')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function delete($id = null)
    {
        $supplier = $this->model->find($id);
        if (! $supplier) {
            return redirect()->to('/suppliers')->with('error', 'Supplier tidak ditemukan.');
        }

        // Cek apakah masih dipakai di PO
        $db = \Config\Database::connect();
        $usedCount = $db->table('purchase_orders')->where('supplier_id', $id)->countAllResults();
        if ($usedCount > 0) {
            return redirect()->to('/suppliers')
                ->with('error', "Tidak bisa dihapus. Ada {$usedCount} Purchase Order yang terkait.");
        }

        $this->model->delete($id);
        return redirect()->to('/suppliers')->with('success', 'Supplier berhasil dihapus.');
    }
}