<?php

namespace App\Controllers;

use App\Models\ItemModel;
use App\Models\ItemCategoryModel;
use CodeIgniter\Controller;

class Item extends Controller
{
    protected $model;
    protected $categoryModel;

    public function __construct()
    {
        $this->model         = new ItemModel();
        $this->categoryModel = new ItemCategoryModel();
        helper(['form', 'url', 'status']);
    }

    // ======================================================
    // LIST BARANG + KATEGORI
    // ======================================================
   public function index()
{
    $perPage = (int) ($this->request->getGet('per_page') ?? 10);
    if (! in_array($perPage, [10, 20, 50, 100])) {
        $perPage = 10;
    }

    $q        = trim((string) $this->request->getGet('q'));
    $category = $this->request->getGet('category') ?? 'all';
    $stock    = $this->request->getGet('stock') ?? 'all';

    $this->model
        ->select('items.*, item_categories.name AS category_name')
        ->join('item_categories', 'item_categories.id = items.category_id', 'left');

    if ($q !== '') {
        $this->model->groupStart()
            ->like('items.name', $q)
            ->orLike('items.code', $q)
            ->groupEnd();
    }

    if ($category !== 'all') {
        $this->model->where('items.category_id', $category);
    }

    if ($stock === 'critical') {
        $this->model->where('items.current_stock >', 0)
                    ->where('items.current_stock <= items.minimum_stock', null, false);
    } elseif ($stock === 'empty') {
        $this->model->where('items.current_stock', 0);
    }

    $items = $this->model->orderBy('items.name', 'ASC')->paginate($perPage);

    return view('items/index', [
        'title'      => 'Barang - Sistem Hotel',
        'items'      => $items,
        'pager'      => $this->model->pager,
        'perPage'    => $perPage,
        'q'          => $q,
        'category'   => $category,
        'stock'      => $stock,
        'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
    ]);
}

    // ======================================================
    // CRUD BARANG
    // ======================================================
    public function store()
    {
        $data = [
            'category_id'   => (int) $this->request->getPost('category_id'),
            'code'          => $this->request->getPost('code') ?: $this->model->generateCode(),
            'name'          => $this->request->getPost('name'),
            'unit'          => $this->request->getPost('unit'),
            'current_stock' => (int) $this->request->getPost('current_stock'),
            'minimum_stock' => (int) $this->request->getPost('minimum_stock'),
            'last_price'    => (float) $this->request->getPost('last_price'),
            'expiry_date'   => $this->request->getPost('expiry_date') ?: null,
        ];

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->model->errors())
                ->with('open_dialog', 'dialog-create');
        }

        return redirect()->to('/items')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update($id = null)
{
    $item = $this->model->find($id);
    if (! $item) {
        return redirect()->to('/items')->with('error', 'Barang tidak ditemukan.');
    }

    $data = [
        'id'            => $id,
        'category_id'   => (int) $this->request->getPost('category_id'),
        'code'          => $this->request->getPost('code'),
        'name'          => $this->request->getPost('name'),
        'unit'          => $this->request->getPost('unit'),
        'current_stock' => (int) $this->request->getPost('current_stock'),
        'minimum_stock' => (int) $this->request->getPost('minimum_stock'),
        'last_price'    => (float) $this->request->getPost('last_price'),
        'expiry_date'   => $this->request->getPost('expiry_date') ?: null,
    ];

    // Validasi unique kode (kecuali untuk item ini sendiri)
    if (! empty($data['code'])) {
        $exists = $this->model
            ->where('code', $data['code'])
            ->where('id !=', $id)
            ->countAllResults();
        if ($exists > 0) {
            return redirect()->back()->withInput()
                ->with('errors', ['Kode barang sudah dipakai.'])
                ->with('open_dialog', 'dialog-edit');
        }
    }

    if (! $this->model->save($data)) {
        return redirect()->back()->withInput()
            ->with('errors', $this->model->errors())
            ->with('open_dialog', 'dialog-edit');
    }

    return redirect()->to('/items')->with('success', 'Barang berhasil diperbarui.');
}

    public function delete($id = null)
    {
        $item = $this->model->find($id);
        if (! $item) {
            return redirect()->to('/items')->with('error', 'Barang tidak ditemukan.');
        }

        // Cek apakah masih dipakai di SR/PO (kalau modul purchasing sudah ada)
        $this->model->delete($id);
        return redirect()->to('/items')->with('success', 'Barang berhasil dihapus.');
    }

    // ======================================================
    // CRUD KATEGORI
    // ======================================================
    public function categoryStore()
    {
        $data = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if (! $this->categoryModel->save($data)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->categoryModel->errors())
                ->with('open_dialog', 'dialog-category-create');
        }

        return redirect()->to('/items')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function categoryUpdate($id = null)
    {
        $category = $this->categoryModel->find($id);
        if (! $category) {
            return redirect()->to('/items')->with('error', 'Kategori tidak ditemukan.');
        }

        $data = [
            'id'          => $id,
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ];

        if (! $this->categoryModel->save($data)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->categoryModel->errors())
                ->with('open_dialog', 'dialog-category-edit');
        }

        return redirect()->to('/items')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function categoryDelete($id = null)
    {
        $category = $this->categoryModel->find($id);
        if (! $category) {
            return redirect()->to('/items')->with('error', 'Kategori tidak ditemukan.');
        }

        // Cek apakah masih ada barang di kategori ini
        $usedCount = $this->model->where('category_id', $id)->countAllResults();
        if ($usedCount > 0) {
            return redirect()->to('/items')
                ->with('error', "Tidak bisa dihapus. Ada {$usedCount} barang di kategori ini.");
        }

        $this->categoryModel->delete($id);
        return redirect()->to('/items')->with('success', 'Kategori berhasil dihapus.');
    }
}