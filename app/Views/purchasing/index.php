<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Store Requisition</h1>
            <p class="page-sub">Permintaan barang dari departemen</p>
        </div>
        <div class="header-actions">
            <mdui-button-icon onclick="openSearchModal()" title="Cari SR" class="icon-btn">
                <mdui-icon name="search"></mdui-icon>
                <?php if (! empty($q)): ?>
                    <span class="filter-badge" style="display: flex;">1</span>
                <?php endif; ?>
            </mdui-button-icon>

            <mdui-button-icon onclick="openFilterModal()" title="Filter" class="icon-btn" id="filter-btn">
                <mdui-icon name="tune"></mdui-icon>
                <?php 
                $filterCount = 0;
                if ($status !== 'all') $filterCount++;
                if ($dept !== 'all')   $filterCount++;
                if ($filterCount > 0): ?>
                    <span class="filter-badge" style="display: flex;"><?= $filterCount ?></span>
                <?php endif; ?>
            </mdui-button-icon>

            <mdui-button onclick="openCreateDialog()" variant="filled" class="btn-primary">
                <mdui-icon slot="icon" name="add"></mdui-icon>
                Buat SR Baru
            </mdui-button>
        </div>
    </div>

    <!-- ACTIVE FILTERS -->
    <?php if (! empty($q) || $status !== 'all' || $dept !== 'all'): 
        $statusLabels = [
            'pending'   => 'Pending',
            'approved'  => 'Approved',
            'delivered' => 'Delivered',
            'rejected'  => 'Rejected',
        ];
        $deptLabels = [
            'housekeeping' => 'Housekeeping',
            'kitchen'      => 'Kitchen',
            'fb'           => 'Food & Beverage',
            'engineering'  => 'Engineering',
            'front_office' => 'Front Office',
        ];
    ?>
        <div class="active-filters">
            <span class="chip-label">Filter aktif:</span>
            <?php if ($status !== 'all'): ?>
                <span class="chip">
                    Status: <strong><?= $statusLabels[$status] ?? $status ?></strong>
                    <button onclick="clearStatus()" class="chip-close">×</button>
                </span>
            <?php endif; ?>
            <?php if ($dept !== 'all'): ?>
                <span class="chip">
                    Departemen: <strong><?= $deptLabels[$dept] ?? $dept ?></strong>
                    <button onclick="clearDept()" class="chip-close">×</button>
                </span>
            <?php endif; ?>
            <?php if (! empty($q)): ?>
                <span class="chip">
                    Cari: "<strong><?= esc($q) ?></strong>"
                    <button onclick="clearSearch()" class="chip-close">×</button>
                </span>
            <?php endif; ?>
            <button onclick="clearAll()" class="chip-clear">Hapus semua</button>
        </div>
    <?php endif; ?>

    <div class="modern-card">
        <div class="table-wrapper">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>No. SR</th>
                        <th>Departemen</th>
                        <th>Diminta Oleh</th>
                        <th>Tgl Permintaan</th>
                        <th>Item</th>
                        <th>Status</th>
                        <th style="width: 150px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($srs)): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <mdui-icon name="assignment" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
                                    <p>Belum ada Store Requisition</p>
                                    <span>
                                        <?php if (! empty($q) || $status !== 'all' || $dept !== 'all'): ?>
                                            Coba ubah kata kunci atau filter Anda
                                        <?php else: ?>
                                            Klik "Buat SR Baru" untuk memulai
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $currentPage = $pager->getCurrentPage();
                        $startNo = ($currentPage - 1) * $perPage;
                        foreach ($srs as $i => $s): 
                        ?>
                            <tr>
                                <td><span class="row-index"><?= $startNo + $i + 1 ?></span></td>
                                <td><div class="cell-title" style="color: var(--primary);"><?= esc($s['sr_number']) ?></div></td>
                                <td>
                                    <span class="badge badge-neutral"><?= department_label($s['department']) ?></span>
                                </td>
                                <td>
                                    <div class="cell-primary">
                                        <div class="guest-avatar" style="width: 28px; height: 28px; font-size: 11px;">
                                            <?= strtoupper(substr($s['requester_name'] ?? '?', 0, 1)) ?>
                                        </div>
                                        <div class="cell-title" style="font-size: 12px;"><?= esc($s['requester_name'] ?? '-') ?></div>
                                    </div>
                                </td>
                                <td><div style="font-size: 13px;"><?= date('d M Y', strtotime($s['requested_date'])) ?></div></td>
                                <td>
                                    <span class="badge badge-neutral">
                                        <mdui-icon name="inventory_2" style="font-size: 14px;"></mdui-icon>
                                        <?= $s['total_items'] ?> item
                                    </span>
                                </td>
                                <td><?= sr_badge($s['status']) ?></td>
                                <td style="text-align: right;">
                                    <div class="action-group">
                                        <mdui-button-icon onclick="openDetail(<?= $s['id'] ?>)" title="Lihat Detail">
                                            <mdui-icon name="visibility"></mdui-icon>
                                        </mdui-button-icon>

                                        <?php if ($s['status'] === 'pending'): ?>
                                            <mdui-button-icon onclick="openApproveDialog(<?= $s['id'] ?>, '<?= esc($s['sr_number']) ?>')" title="Approve/Reject" style="color: #3B82F6;">
                                                <mdui-icon name="check_circle"></mdui-icon>
                                            </mdui-button-icon>
                                        <?php endif; ?>

                                        <?php if ($s['status'] === 'approved'): ?>
                                            <mdui-button-icon onclick="openDeliverDialog(<?= $s['id'] ?>, '<?= esc($s['sr_number']) ?>')" title="Deliver" style="color: #10B981;">
                                                <mdui-icon name="local_shipping"></mdui-icon>
                                            </mdui-button-icon>
                                        <?php endif; ?>

                                        <?php if (in_array($s['status'], ['pending', 'rejected'])): ?>
                                            <mdui-button-icon
                                                data-id="<?= $s['id'] ?>"
                                                data-name="<?= esc($s['sr_number']) ?>"
                                                onclick="openDeleteDialog(this)"
                                                style="color: #EF4444;"
                                                title="Hapus">
                                                <mdui-icon name="delete"></mdui-icon>
                                            </mdui-button-icon>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= view('components/pagination', [
            'pager'       => $pager,
            'perPage'     => $perPage,
            'baseUrl'     => base_url('purchasing'),
            'queryParams' => ['q' => $q, 'status' => $status, 'dept' => $dept],
        ]) ?>
    </div>
</div>

<!-- MODAL: SEARCH -->
<mdui-dialog id="dialog-search" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Cari Store Requisition</span>
    <div style="padding: 4px 0;">
        <mdui-text-field
            id="search-input"
            value="<?= esc($q) ?>"
            placeholder="Ketik nomor SR atau nama peminta..."
            variant="outlined"
            clearable
            style="width: 100%;">
            <mdui-icon slot="icon" name="search"></mdui-icon>
        </mdui-text-field>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearSearch()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applySearch()">Terapkan</mdui-button>
</mdui-dialog>

<!-- MODAL: FILTER -->
<mdui-dialog id="dialog-filter" style="--mdui-dialog-width: 460px;">
    <span slot="headline">Filter SR</span>
    <div style="padding: 4px 0;">
        <div class="filter-section-title"><mdui-icon name="business"></mdui-icon>Departemen</div>
        <div class="filter-options" style="max-height: 220px;">
            <label class="filter-option">
                <input type="radio" name="filter_dept" value="all" <?= $dept === 'all' ? 'checked' : '' ?>>
                <div class="filter-option-content">
                    <mdui-icon name="done_all"></mdui-icon>
                    <div><div class="filter-option-title">Semua Departemen</div></div>
                </div>
            </label>
            <?php foreach (['housekeeping' => 'Housekeeping', 'kitchen' => 'Kitchen', 'fb' => 'Food & Beverage', 'engineering' => 'Engineering', 'front_office' => 'Front Office'] as $key => $label): ?>
                <label class="filter-option">
                    <input type="radio" name="filter_dept" value="<?= $key ?>" <?= $dept === $key ? 'checked' : '' ?>>
                    <div class="filter-option-content">
                        <mdui-icon name="business" style="color: var(--primary);"></mdui-icon>
                        <div><div class="filter-option-title"><?= $label ?></div></div>
                    </div>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="filter-section-title" style="margin-top: 20px;"><mdui-icon name="bookmark"></mdui-icon>Status</div>
        <div class="filter-options">
            <?php foreach (['all' => 'Semua Status', 'pending' => 'Pending', 'approved' => 'Approved', 'delivered' => 'Delivered', 'rejected' => 'Rejected'] as $key => $label): ?>
                <label class="filter-option">
                    <input type="radio" name="filter_status" value="<?= $key ?>" <?= $status === $key ? 'checked' : '' ?>>
                    <div class="filter-option-content">
                        <mdui-icon name="circle" style="color: var(--primary);"></mdui-icon>
                        <div><div class="filter-option-title"><?= $label ?></div></div>
                    </div>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearAllFilters()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applyFilter()">Terapkan</mdui-button>
</mdui-dialog>

<!-- DIALOG: BUAT SR -->
<mdui-dialog id="dialog-create" style="--mdui-dialog-width: 640px;">
    <span slot="headline">Buat Store Requisition</span>
    <form id="form-create" action="<?= base_url('purchasing/store') ?>" method="post">
        <?= csrf_field() ?>
        <mdui-select name="department" label="Departemen Peminta" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <mdui-menu-item value="housekeeping">Housekeeping</mdui-menu-item>
            <mdui-menu-item value="kitchen">Kitchen</mdui-menu-item>
            <mdui-menu-item value="fb">Food & Beverage</mdui-menu-item>
            <mdui-menu-item value="engineering">Engineering</mdui-menu-item>
            <mdui-menu-item value="front_office">Front Office</mdui-menu-item>
        </mdui-select>
        <mdui-text-field label="Catatan" name="notes" variant="outlined" rows="2" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <div style="margin: 20px 0 8px 0;"><strong style="font-size: 13px;">Daftar Barang yang Diminta:</strong></div>
        <div id="items-container" style="max-height: 300px; overflow-y: auto; padding-right: 8px;"></div>
        <mdui-button variant="outlined" onclick="addItemRow()" style="margin-top: 12px; width: 100%;">
            <mdui-icon slot="icon" name="add"></mdui-icon>
            Tambah Baris Barang
        </mdui-button>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-create')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-create').submit()">Simpan SR</mdui-button>
</mdui-dialog>

<!-- DIALOG: DETAIL SR -->
<mdui-dialog id="dialog-detail" style="--mdui-dialog-width: 640px;">
    <span slot="headline">Detail SR</span>
    <div id="detail-content">Memuat...</div>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-detail')">Tutup</mdui-button>
</mdui-dialog>

<!-- DIALOG: APPROVE -->
<mdui-dialog id="dialog-approve" style="--mdui-dialog-width: 640px;">
    <span slot="headline">Approve / Reject SR</span>
    <p style="color: var(--text-muted); margin-bottom: 12px;">SR: <strong id="approve-sr-number" style="color: var(--primary);"></strong></p>
    <form id="form-approve" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="action" id="approve-action" value="approve">
        <div style="margin: 16px 0 8px 0;"><strong style="font-size: 13px;">Tentukan Jumlah yang Disetujui:</strong></div>
        <div id="approve-items-container" style="max-height: 320px; overflow-y: auto; padding-right: 6px;"></div>
        <div style="display: flex; gap: 8px; margin-top: 20px;">
            <mdui-button variant="filled" style="background: #10B981; flex: 1;" onclick="submitApprove('approve')">Approve</mdui-button>
            <mdui-button variant="filled" style="background: #EF4444; flex: 1;" onclick="submitApprove('reject')">Reject</mdui-button>
        </div>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-approve')">Batal</mdui-button>
</mdui-dialog>

<!-- DIALOG: DELIVER -->
<mdui-dialog id="dialog-deliver" style="--mdui-dialog-width: 440px;">
    <div style="text-align: center; padding: 8px;">
        <mdui-icon name="local_shipping" style="font-size: 56px; color: #10B981;"></mdui-icon>
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Konfirmasi Deliver</h3>
        <p style="color: #666; margin: 0;">Yakin barang untuk SR <strong id="deliver-sr-number"></strong> sudah diserahkan?</p>
        <p style="color: var(--text-muted); font-size: 12px; margin-top: 8px;">Stok barang akan otomatis dikurangi dari gudang.</p>
    </div>
    <form id="form-deliver" method="post"><?= csrf_field() ?></form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-deliver')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" style="background: #10B981;" onclick="document.getElementById('form-deliver').submit()">Ya, Deliver</mdui-button>
</mdui-dialog>

<!-- DIALOG: HAPUS -->
<mdui-dialog id="dialog-delete" style="--mdui-dialog-width: 400px;">
    <div style="text-align: center; padding: 8px;">
        <mdui-icon name="delete_forever" style="font-size: 56px; color: #EF4444;"></mdui-icon>
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Hapus SR?</h3>
        <p style="color: #666; margin: 0;">Yakin ingin menghapus SR <strong id="delete-name"></strong>?</p>
    </div>
    <form id="form-delete" method="post"><?= csrf_field() ?></form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-delete')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" style="background: #EF4444;" onclick="document.getElementById('form-delete').submit()">Hapus</mdui-button>
</mdui-dialog>

<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .page-title { font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px 0; }
    .page-sub { color: var(--text-muted); font-size: 13px; margin: 0; }
    .header-actions { display: flex; align-items: center; gap: 8px; }

    .icon-btn {
        width: 40px !important; height: 40px !important;
        border-radius: 10px !important;
        background: #fff !important;
        border: 1px solid var(--border) !important;
        color: var(--text-secondary) !important;
        position: relative;
    }
    .icon-btn:hover {
        background: var(--primary-soft) !important;
        color: var(--primary) !important;
        border-color: var(--primary) !important;
    }
    .filter-badge {
        position: absolute; top: -4px; right: -4px;
        background: var(--primary); color: white;
        font-size: 10px; font-weight: 700;
        min-width: 18px; height: 18px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        padding: 0 5px; border: 2px solid #fff;
    }

    .active-filters {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 16px; padding: 10px 14px;
        background: #fff; border-radius: 12px;
        border: 1px solid var(--border); flex-wrap: wrap;
    }
    .chip-label { font-size: 12px; color: var(--text-muted); font-weight: 600; }
    .chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 10px; border-radius: 20px;
        background: var(--primary-soft); color: var(--primary);
        font-size: 12px; font-weight: 500;
    }
    .chip strong { color: var(--primary-dark); }
    .chip-close {
        background: none; border: none; color: var(--primary);
        font-size: 16px; line-height: 1; cursor: pointer;
        padding: 0; margin-left: 2px;
    }
    .chip-close:hover { color: #EF4444; }
    .chip-clear {
        background: none; border: none; color: #EF4444;
        font-size: 12px; font-weight: 600; cursor: pointer;
        padding: 4px 8px; margin-left: auto;
    }
    .chip-clear:hover { text-decoration: underline; }

    .modern-card {
        background: #fff; border-radius: 14px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm); overflow: hidden;
    }
    .table-wrapper { overflow-x: auto; }

    .modern-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .modern-table thead th {
        background: #F9FAFB; padding: 12px 16px; text-align: left;
        font-size: 11px; font-weight: 600; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border); white-space: nowrap;
    }
    .modern-table tbody td {
        padding: 12px 16px; border-bottom: 1px solid #F3F4F6; vertical-align: middle;
    }
    .modern-table tbody tr:last-child td { border-bottom: none; }
    .modern-table tbody tr:hover { background: #FAFBFF; }

    .row-index {
        display: inline-block; width: 24px; height: 24px;
        background: #F3F4F6; border-radius: 6px; text-align: center;
        line-height: 24px; font-size: 11px; font-weight: 600;
        color: var(--text-secondary);
    }
    .cell-primary { display: flex; align-items: center; gap: 10px; }
    .guest-avatar {
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .cell-title { font-weight: 600; color: var(--text-primary); font-size: 13px; }
    .cell-sub { color: var(--text-muted); font-size: 11px; margin-top: 2px; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 10px; border-radius: 8px;
        font-size: 12px; font-weight: 600;
    }
    .badge-neutral { background: #F3F4F6; color: #4B5563; }

    .action-group { display: inline-flex; gap: 2px; }

    .empty-state { padding: 48px 20px; text-align: center; }
    .empty-state p { font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 12px 0 4px 0; }
    .empty-state span { font-size: 13px; color: var(--text-muted); }

    .filter-section-title {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; font-weight: 600; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .filter-section-title mdui-icon { font-size: 18px; }

    .filter-options {
        display: flex; flex-direction: column; gap: 8px;
        max-height: 320px; overflow-y: auto; padding-right: 6px;
    }
    .filter-option { display: block; cursor: pointer; position: relative; }
    .filter-option input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }
    .filter-option-content {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 14px; border-radius: 10px;
        border: 1px solid var(--border); background: #fff;
        transition: all 0.15s ease;
    }
    .filter-option-content mdui-icon { font-size: 22px; color: var(--text-muted); flex-shrink: 0; }
    .filter-option-content > div { flex: 1; }
    .filter-option-title { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .filter-option:hover .filter-option-content { border-color: var(--primary-light); background: #FAFBFF; }
    .filter-option input[type="radio"]:checked + .filter-option-content {
        border-color: var(--primary); background: var(--primary-soft);
    }
    .filter-option input[type="radio"]:checked + .filter-option-content .filter-option-title {
        color: var(--primary);
    }

    .item-row-sr { display: flex; gap: 8px; align-items: center; margin-bottom: 8px; padding: 10px; border: 1px solid var(--border); border-radius: 10px; background: #FAFBFF; }
    .item-row-sr select { flex: 2; padding: 8px 10px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; background: white; }
    .item-row-sr input { flex: 1; padding: 8px 10px; border: 1px solid var(--border); border-radius: 8px; font-size: 13px; }
    .item-row-sr .btn-remove { padding: 8px 12px; background: #EF4444; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const ITEMS = <?= json_encode($items) ?>;

    function openDialog(id)  { document.getElementById(id).open = true; }
    function closeDialog(id) { document.getElementById(id).open = false; }

    // ===== SEARCH =====
    function openSearchModal() { openDialog('dialog-search'); }
    function applySearch() {
        const q = (document.getElementById('search-input').value || '').trim();
        updateQueryParam('q', q);
    }
    function clearSearch() { removeQueryParam('q'); }

    // ===== FILTER =====
    function openFilterModal() { openDialog('dialog-filter'); }
    function applyFilter() {
        const sts = document.querySelector('input[name="filter_status"]:checked');
        const dep = document.querySelector('input[name="filter_dept"]:checked');
        const url = new URL(window.location.href);
        url.searchParams.set('status', sts ? sts.value : 'all');
        url.searchParams.set('dept',   dep ? dep.value : 'all');
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }
    function clearStatus() { updateQueryParam('status', 'all'); }
    function clearDept()   { updateQueryParam('dept', 'all'); }
    function clearAllFilters() {
        const url = new URL(window.location.href);
        url.searchParams.delete('status');
        url.searchParams.delete('dept');
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }
    function clearAll() {
        const url = new URL(window.location.href);
        url.searchParams.delete('q');
        url.searchParams.delete('status');
        url.searchParams.delete('dept');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    // ===== BUAT SR =====
    function addItemRow() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.className = 'item-row-sr';
        let opts = '<option value="">-- Pilih Barang --</option>';
        ITEMS.forEach(it => {
            opts += `<option value="${it.id}">${it.code} — ${it.name} (${it.unit}) [stok: ${it.current_stock}]</option>`;
        });
        row.innerHTML = `
            <select name="item_id[]" required>${opts}</select>
            <input type="number" name="quantity[]" min="1" placeholder="Qty" required>
            <button type="button" class="btn-remove" onclick="this.parentElement.remove()">×</button>
        `;
        container.appendChild(row);
    }

    function openCreateDialog() {
        document.getElementById('items-container').innerHTML = '';
        addItemRow();
        openDialog('dialog-create');
    }

    // ===== DETAIL =====
    async function openDetail(id) {
        const container = document.getElementById('detail-content');
        container.innerHTML = 'Memuat...';
        openDialog('dialog-detail');
        const res = await fetch('<?= base_url('purchasing/detail') ?>/' + id);
        const json = await res.json();
        if (! json.success) {
            container.innerHTML = '<p style="color: #EF4444;">Gagal memuat detail.</p>';
            return;
        }
        let html = `
            <div style="padding: 16px; background: var(--primary-soft); border-radius: 12px; margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px;">
                    <span style="color: var(--text-secondary);">No. SR:</span><strong style="color: var(--primary);">${json.sr.sr_number}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px;">
                    <span style="color: var(--text-secondary);">Departemen:</span><span>${json.department}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 13px;">
                    <span style="color: var(--text-secondary);">Tanggal:</span><span>${json.sr.requested_date}</span>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr style="background: #F9FAFB;">
                        <th style="padding: 10px; text-align: left; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Barang</th>
                        <th style="padding: 10px; text-align: right; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Diminta</th>
                        <th style="padding: 10px; text-align: right; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Disetujui</th>
                    </tr>
                </thead>
                <tbody>`;
        json.details.forEach(d => {
            html += `
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 10px;"><strong>${d.item_name}</strong> <span style="color: var(--text-muted);">(${d.unit})</span></td>
                    <td style="padding: 10px; text-align: right;">${d.quantity_requested}</td>
                    <td style="padding: 10px; text-align: right; font-weight: 600; color: var(--primary);">${d.quantity_approved}</td>
                </tr>`;
        });
        html += '</tbody></table>';
        container.innerHTML = html;
    }

    // ===== APPROVE =====
    async function openApproveDialog(id, srNumber) {
        document.getElementById('approve-sr-number').textContent = srNumber;
        document.getElementById('form-approve').action = '<?= base_url('purchasing/approve') ?>/' + id;
        document.getElementById('approve-action').value = 'approve';
        const container = document.getElementById('approve-items-container');
        container.innerHTML = 'Memuat...';
        openDialog('dialog-approve');
        const res = await fetch('<?= base_url('purchasing/detail') ?>/' + id);
        const json = await res.json();
        container.innerHTML = '';
        if (json.success) {
            json.details.forEach(d => {
                const row = document.createElement('div');
                row.className = 'item-row-sr';
                row.innerHTML = `
                    <div style="flex: 2; padding: 4px 0;">
                        <strong style="font-size: 13px;">${d.item_name}</strong>
                        <div style="color: var(--text-muted); font-size: 11px;">Diminta: ${d.quantity_requested} ${d.unit}</div>
                    </div>
                    <input type="number" name="approved_qty[${d.id}]" min="0" max="${d.quantity_requested}" value="${d.quantity_requested}" placeholder="Qty Approve">
                `;
                container.appendChild(row);
            });
        }
    }
    function submitApprove(action) {
        document.getElementById('approve-action').value = action;
        document.getElementById('form-approve').submit();
    }

    // ===== DELIVER =====
    function openDeliverDialog(id, srNumber) {
        document.getElementById('deliver-sr-number').textContent = srNumber;
        document.getElementById('form-deliver').action = '<?= base_url('purchasing/deliver') ?>/' + id;
        openDialog('dialog-deliver');
    }

    // ===== HAPUS =====
    function openDeleteDialog(el) {
        const d = el.dataset;
        document.getElementById('delete-name').textContent = d.name;
        document.getElementById('form-delete').action      = '<?= base_url('purchasing/delete') ?>/' + d.id;
        openDialog('dialog-delete');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') { e.preventDefault(); applySearch(); }
            });
        }
    });

    <?php if (session()->getFlashdata('success')): ?>
        showAlert(<?= json_encode(session()->getFlashdata('success')) ?>, 'success', 2000);
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        showAlert(<?= json_encode(session()->getFlashdata('error')) ?>, 'error');
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        showAlert(<?= json_encode(implode(' ', session()->getFlashdata('errors'))) ?>, 'error');
    <?php endif; ?>
</script>
<?= $this->endSection() ?>