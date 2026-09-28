<?php

namespace App\Controllers;

use App\Models\StoreRequisitionModel;
use App\Models\SrDetailModel;
use App\Models\ItemModel;
use CodeIgniter\Controller;

class Purchasing extends Controller
{
    protected $model;
    protected $detailModel;
    protected $itemModel;

    public function __construct()
    {
        $this->model       = new StoreRequisitionModel();
        $this->detailModel = new SrDetailModel();
        $this->itemModel   = new ItemModel();
        helper(['form', 'url', 'status']);
    }

    // ======================================================
    // LIST STORE REQUISITION
    // ======================================================
public function index()
{
    $perPage = (int) ($this->request->getGet('per_page') ?? 10);
    if (! in_array($perPage, [10, 20, 50, 100])) {
        $perPage = 10;
    }

    $q      = trim((string) $this->request->getGet('q'));
    $status = $this->request->getGet('status') ?? 'all';
    $dept   = $this->request->getGet('dept') ?? 'all';

    $db = \Config\Database::connect();

    // =====================================================
    // STEP 1: Hitung TOTAL dengan query TERPISAH (tanpa subquery)
    // =====================================================
    $countBuilder = $db->table('store_requisitions sr')
        ->join('users u', 'u.id = sr.requested_by', 'left');

    if ($q !== '') {
        $countBuilder->groupStart()
            ->like('sr.sr_number', $q)
            ->orLike('u.username', $q)
            ->groupEnd();
    }
    if ($status !== 'all') {
        $countBuilder->where('sr.status', $status);
    }
    if ($dept !== 'all') {
        $countBuilder->where('sr.department', $dept);
    }

    $total = $countBuilder->countAllResults();

    // =====================================================
    // STEP 2: Fetch data dengan query UTAMA (dengan subquery)
    // =====================================================
    $builder = $db->table('store_requisitions sr')
        ->select('sr.*, u.username AS requester_name,
                  (SELECT COUNT(*) FROM sr_details WHERE sr_id = sr.id) AS total_items')
        ->join('users u', 'u.id = sr.requested_by', 'left');

    if ($q !== '') {
        $builder->groupStart()
            ->like('sr.sr_number', $q)
            ->orLike('u.username', $q)
            ->groupEnd();
    }
    if ($status !== 'all') {
        $builder->where('sr.status', $status);
    }
    if ($dept !== 'all') {
        $builder->where('sr.department', $dept);
    }

    $builder->orderBy('sr.created_at', 'DESC');

    $page   = (int) ($this->request->getGet('page') ?? 1);
    $offset = ($page - 1) * $perPage;

    $srs = $builder->limit($perPage, $offset)->get()->getResultArray();

    // =====================================================
    // STEP 3: Setup pager manual
    // =====================================================
    $pager = \Config\Services::pager();
    $pager->store('default', $page, $perPage, $total);

    return view('purchasing/index', [
        'title'   => 'Purchasing - Sistem Hotel',
        'srs'     => $srs,
        'pager'   => $pager,
        'perPage' => $perPage,
        'q'       => $q,
        'status'  => $status,
        'dept'    => $dept,
        'items'   => $this->itemModel
            ->select('items.*, item_categories.name AS category_name')
            ->join('item_categories', 'item_categories.id = items.category_id', 'left')
            ->orderBy('items.name', 'ASC')
            ->findAll(),
    ]);
}

    // ======================================================
    // SIMPAN SR BARU (dengan detail items)
    // ======================================================
    public function store()
    {
        $department = $this->request->getPost('department');
        $notes      = $this->request->getPost('notes');
        $itemIds    = $this->request->getPost('item_id') ?? [];
        $quantities = $this->request->getPost('quantity') ?? [];

        if (! $department || empty($itemIds)) {
            return redirect()->back()->withInput()
                ->with('errors', ['Pilih departemen dan minimal 1 barang.'])
                ->with('open_dialog', 'dialog-create');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Insert SR
        $srId = $this->model->insert([
            'sr_number'      => $this->model->generateNumber(),
            'department'     => $department,
            'requested_by'   => auth()->id(),
            'status'         => 'pending',
            'requested_date' => date('Y-m-d'),
            'notes'          => $notes,
        ]);

        // Insert detail items
        foreach ($itemIds as $i => $itemId) {
    $qty = (int) ($quantities[$i] ?? 0);
    if ($itemId && $qty > 0) {
        $this->detailModel->insert([
            'sr_id'              => $srId,
            'item_id'            => (int) $itemId,
            'quantity_requested' => $qty,
            'quantity_approved'  => 0,
            'created_at'         => date('Y-m-d H:i:s'),
        ]);
    }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()
                ->with('errors', ['Gagal menyimpan SR.'])
                ->with('open_dialog', 'dialog-create');
        }

        return redirect()->to('/purchasing')->with('success', 'Store Requisition berhasil dibuat.');
    }

    // ======================================================
    // APPROVE / REJECT SR
    // ======================================================
    public function approve($id = null)
    {
        $sr = $this->model->find($id);
        if (! $sr) {
            return redirect()->to('/purchasing')->with('error', 'SR tidak ditemukan.');
        }

        if ($sr['status'] !== 'pending') {
            return redirect()->to('/purchasing')->with('error', 'SR ini sudah diproses sebelumnya.');
        }

        $action     = $this->request->getPost('action'); // approve / reject
        $approvedQtys = $this->request->getPost('approved_qty') ?? [];

        if ($action === 'reject') {
            $this->model->update($id, [
                'status'        => 'rejected',
                'approved_by'   => auth()->id(),
                'approved_date' => date('Y-m-d'),
            ]);
            return redirect()->to('/purchasing')->with('success', 'SR berhasil ditolak.');
        }

        // Approve: update quantity_approved untuk tiap detail
        $db = \Config\Database::connect();
        $db->transStart();

        $this->model->update($id, [
            'status'        => 'approved',
            'approved_by'   => auth()->id(),
            'approved_date' => date('Y-m-d'),
        ]);

        $details = $this->detailModel->where('sr_id', $id)->findAll();
        foreach ($details as $d) {
            $approved = (int) ($approvedQtys[$d['id']] ?? 0);
            $this->detailModel->update($d['id'], ['quantity_approved' => $approved]);
        }

        $db->transComplete();

        return redirect()->to('/purchasing')->with('success', 'SR berhasil disetujui.');
    }

    // ======================================================
    // DELIVER (barang diserahkan ke departemen)
    // ======================================================
    public function deliver($id = null)
    {
        $sr = $this->model->find($id);
        if (! $sr) {
            return redirect()->to('/purchasing')->with('error', 'SR tidak ditemukan.');
        }

        if ($sr['status'] !== 'approved') {
            return redirect()->to('/purchasing')->with('error', 'Hanya SR yang sudah di-approve bisa di-deliver.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Update status SR
        $this->model->update($id, ['status' => 'delivered']);

        // Kurangi stok item + catat stock movement
        $details = $this->detailModel->where('sr_id', $id)->findAll();
        foreach ($details as $d) {
            if ($d['quantity_approved'] <= 0) continue;

            $item = $this->itemModel->find($d['item_id']);
            if (! $item) continue;

            $newStock = max(0, (int) $item['current_stock'] - (int) $d['quantity_approved']);
            $this->itemModel->update($d['item_id'], ['current_stock' => $newStock]);

            // Catat stock movement
            $db->table('stock_movements')->insert([
                'item_id'        => $d['item_id'],
                'type'           => 'out',
                'quantity'       => $d['quantity_approved'],
                'reference_type' => 'SR',
                'reference_id'   => $id,
                'notes'          => 'Delivered to ' . department_label($sr['department']),
                'created_by'     => auth()->id(),
                'created_at'     => date('Y-m-d H:i:s'),
            ]);
        }

        $db->transComplete();

        return redirect()->to('/purchasing')->with('success', 'SR berhasil di-deliver. Stok barang telah dikurangi.');
    }

    // ======================================================
    // DETAIL SR (untuk modal)
    // ======================================================
    public function detail($id = null)
    {
        $sr = $this->model->find($id);
        if (! $sr) {
            return $this->response->setJSON(['success' => false, 'message' => 'SR tidak ditemukan.']);
        }

        $db = \Config\Database::connect();
        $details = $db->table('sr_details sd')
            ->select('sd.*, items.name AS item_name, items.unit, items.code AS item_code')
            ->join('items', 'items.id = sd.item_id', 'left')
            ->where('sd.sr_id', $id)
            ->get()->getResultArray();

        return $this->response->setJSON([
            'success'     => true,
            'sr'          => $sr,
            'details'     => $details,
            'department'  => department_label($sr['department']),
        ]);
    }

    // ======================================================
    // HAPUS SR
    // ======================================================
    public function delete($id = null)
    {
        $sr = $this->model->find($id);
        if (! $sr) {
            return redirect()->to('/purchasing')->with('error', 'SR tidak ditemukan.');
        }

        if (! in_array($sr['status'], ['pending', 'rejected'])) {
            return redirect()->to('/purchasing')
                ->with('error', 'SR yang sudah di-approve/deliver tidak bisa dihapus.');
        }

        $this->model->delete($id);
        return redirect()->to('/purchasing')->with('success', 'SR berhasil dihapus.');
    }
}