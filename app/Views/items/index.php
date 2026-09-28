<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Barang</h1>
            <p class="page-sub">Kelola stok dan kategori barang hotel</p>
        </div>
        <div class="header-actions">
            <mdui-button-icon onclick="openSearchModal()" title="Cari Barang" class="icon-btn">
                <mdui-icon name="search"></mdui-icon>
                <?php if (! empty($q)): ?>
                    <span class="filter-badge" style="display: flex;">1</span>
                <?php endif; ?>
            </mdui-button-icon>

            <mdui-button-icon onclick="openFilterModal()" title="Filter" class="icon-btn" id="filter-btn">
                <mdui-icon name="tune"></mdui-icon>
                <?php 
                $filterCount = 0;
                if ($category !== 'all') $filterCount++;
                if ($stock !== 'all')    $filterCount++;
                if ($filterCount > 0): ?>
                    <span class="filter-badge" style="display: flex;"><?= $filterCount ?></span>
                <?php endif; ?>
            </mdui-button-icon>

            <mdui-button onclick="openDialog('dialog-category-create')" variant="outlined">
                <mdui-icon slot="icon" name="category"></mdui-icon>
                Kategori
            </mdui-button>

            <mdui-button onclick="openDialog('dialog-create')" variant="filled" class="btn-primary">
                <mdui-icon slot="icon" name="add"></mdui-icon>
                Tambah Barang
            </mdui-button>
        </div>
    </div>

    <!-- ACTIVE FILTERS -->
    <?php if (! empty($q) || $category !== 'all' || $stock !== 'all'): 
        $stockLabels = ['critical' => 'Stok Menipis', 'empty' => 'Habis'];
        $categoryName = '-';
        foreach ($categories as $c) {
            if ((string) $c['id'] === (string) $category) { $categoryName = $c['name']; break; }
        }
    ?>
        <div class="active-filters">
            <span class="chip-label">Filter aktif:</span>
            <?php if ($category !== 'all'): ?>
                <span class="chip">
                    Kategori: <strong><?= esc($categoryName) ?></strong>
                    <button onclick="clearCategory()" class="chip-close">×</button>
                </span>
            <?php endif; ?>
            <?php if ($stock !== 'all'): ?>
                <span class="chip">
                    Stok: <strong><?= $stockLabels[$stock] ?? $stock ?></strong>
                    <button onclick="clearStock()" class="chip-close">×</button>
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
                        <th>Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Harga Terakhir</th>
                        <th>Expiry</th>
                        <th style="width: 120px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <mdui-icon name="inventory_2" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
                                    <p>Belum ada barang</p>
                                    <span>
                                        <?php if (! empty($q) || $category !== 'all' || $stock !== 'all'): ?>
                                            Coba ubah kata kunci atau filter Anda
                                        <?php else: ?>
                                            Klik "Tambah Barang" untuk memulai
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $startNo = ($pager->getCurrentPage() - 1) * $perPage;
                        foreach ($items as $i => $it): 
                        ?>
                            <tr>
                                <td><span class="row-index"><?= $startNo + $i + 1 ?></span></td>
                                <td>
                                    <div class="cell-primary">
                                        <div class="item-icon"><mdui-icon name="inventory_2"></mdui-icon></div>
                                        <div>
                                            <div class="cell-title"><?= esc($it['name']) ?></div>
                                            <div class="cell-sub"><?= esc($it['code']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-neutral"><?= esc($it['category_name'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <div class="stock-cell">
                                        <div>
                                            <strong style="font-size: 15px; color: var(--text-primary);"><?= $it['current_stock'] ?></strong>
                                            <span style="color: var(--text-muted); font-size: 11px;"> <?= esc($it['unit']) ?></span>
                                        </div>
                                        <div style="margin-top: 2px;">
                                            <?= stock_badge((int) $it['current_stock'], (int) $it['minimum_stock']) ?>
                                        </div>
                                        <div style="color: var(--text-muted); font-size: 10px; margin-top: 2px;">min: <?= $it['minimum_stock'] ?></div>
                                    </div>
                                </td>
                                <td><?= esc($it['unit']) ?></td>
                                <td><div class="price-text">Rp <?= number_format($it['last_price'], 0, ',', '.') ?></div></td>
                                <td>
                                    <?php if ($it['expiry_date']): ?>
                                        <div style="font-size: 12px;"><?= date('d M Y', strtotime($it['expiry_date'])) ?></div>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">-</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-group">
                                        <mdui-button-icon
                                            data-id="<?= $it['id'] ?>"
                                            data-category_id="<?= $it['category_id'] ?>"
                                            data-code="<?= esc($it['code']) ?>"
                                            data-name="<?= esc($it['name']) ?>"
                                            data-unit="<?= esc($it['unit']) ?>"
                                            data-current_stock="<?= $it['current_stock'] ?>"
                                            data-minimum_stock="<?= $it['minimum_stock'] ?>"
                                            data-last_price="<?= $it['last_price'] ?>"
                                            data-expiry_date="<?= $it['expiry_date'] ?>"
                                            onclick="openEditDialog(this)"
                                            title="Edit">
                                            <mdui-icon name="edit"></mdui-icon>
                                        </mdui-button-icon>

                                        <mdui-button-icon
                                            data-id="<?= $it['id'] ?>"
                                            data-name="<?= esc($it['name']) ?>"
                                            onclick="openDeleteDialog(this)"
                                            style="color: #EF4444;"
                                            title="Hapus">
                                            <mdui-icon name="delete"></mdui-icon>
                                        </mdui-button-icon>
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
            'baseUrl'     => base_url('items'),
            'queryParams' => ['q' => $q, 'category' => $category, 'stock' => $stock],
        ]) ?>
    </div>
</div>

<!-- MODAL: SEARCH -->
<mdui-dialog id="dialog-search" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Cari Barang</span>
    <div style="padding: 4px 0;">
        <mdui-text-field
            id="search-input"
            value="<?= esc($q) ?>"
            placeholder="Ketik nama atau kode barang..."
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
    <span slot="headline">Filter Barang</span>
    <div style="padding: 4px 0;">
        <div class="filter-section-title">
            <mdui-icon name="category"></mdui-icon>
            Kategori
        </div>
        <div class="filter-options" style="max-height: 200px;">
            <label class="filter-option">
                <input type="radio" name="filter_category" value="all" <?= $category === 'all' ? 'checked' : '' ?>>
                <div class="filter-option-content">
                    <mdui-icon name="done_all"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Semua Kategori</div>
                        <div class="filter-option-sub">Tampilkan semua barang</div>
                    </div>
                </div>
            </label>
            <?php foreach ($categories as $c): ?>
                <label class="filter-option">
                    <input type="radio" name="filter_category" value="<?= $c['id'] ?>" <?= (string) $category === (string) $c['id'] ? 'checked' : '' ?>>
                    <div class="filter-option-content">
                        <mdui-icon name="label" style="color: var(--primary);"></mdui-icon>
                        <div>
                            <div class="filter-option-title"><?= esc($c['name']) ?></div>
                            <div class="filter-option-sub"><?= esc($c['description'] ?: 'Kategori barang') ?></div>
                        </div>
                    </div>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="filter-section-title" style="margin-top: 20px;">
            <mdui-icon name="inventory"></mdui-icon>
            Status Stok
        </div>
        <div class="filter-options">
            <label class="filter-option">
                <input type="radio" name="filter_stock" value="all" <?= $stock === 'all' ? 'checked' : '' ?>>
                <div class="filter-option-content">
                    <mdui-icon name="done_all"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Semua Stok</div>
                        <div class="filter-option-sub">Tampilkan semua barang</div>
                    </div>
                </div>
            </label>
            <label class="filter-option">
                <input type="radio" name="filter_stock" value="critical" <?= $stock === 'critical' ? 'checked' : '' ?>>
                <div class="filter-option-content">
                    <mdui-icon name="warning" style="color: #F59E0B;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Stok Menipis</div>
                        <div class="filter-option-sub">Di bawah stok minimum</div>
                    </div>
                </div>
            </label>
            <label class="filter-option">
                <input type="radio" name="filter_stock" value="empty" <?= $stock === 'empty' ? 'checked' : '' ?>>
                <div class="filter-option-content">
                    <mdui-icon name="error" style="color: #EF4444;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Habis</div>
                        <div class="filter-option-sub">Stok sudah habis</div>
                    </div>
                </div>
            </label>
        </div>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearAllFilters()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applyFilter()">Terapkan</mdui-button>
</mdui-dialog>

<!-- DIALOG: TAMBAH BARANG -->
<mdui-dialog id="dialog-create" style="--mdui-dialog-width: 520px;">
    <span slot="headline">Tambah Barang</span>
    <form id="form-create" action="<?= base_url('items/store') ?>" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Kode Barang (otomatis jika kosong)" name="code" variant="outlined" helper="Format: ITM-XXXX" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Nama Barang" name="name" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-select name="category_id" label="Kategori" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <?php foreach ($categories as $c): ?>
                <mdui-menu-item value="<?= $c['id'] ?>"><?= esc($c['name']) ?></mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
            <mdui-text-field label="Stok Saat Ini" name="current_stock" type="number" variant="outlined" min="0" value="0" style="flex: 1;"></mdui-text-field>
            <mdui-text-field label="Stok Minimum" name="minimum_stock" type="number" variant="outlined" min="0" value="5" style="flex: 1;"></mdui-text-field>
        </div>
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
            <mdui-text-field label="Satuan" name="unit" variant="outlined" placeholder="pcs, kg, liter" required style="flex: 1;"></mdui-text-field>
            <mdui-text-field label="Harga Terakhir (Rp)" name="last_price" type="number" variant="outlined" min="0" value="0" style="flex: 1;"></mdui-text-field>
        </div>
        <mdui-text-field label="Expiry Date (opsional)" name="expiry_date" type="date" variant="outlined" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-create')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-create').submit()">Simpan</mdui-button>
</mdui-dialog>

<!-- DIALOG: EDIT BARANG -->
<mdui-dialog id="dialog-edit" style="--mdui-dialog-width: 520px;">
    <span slot="headline">Edit Barang</span>
    <form id="form-edit" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Kode Barang" name="code" id="edit-code" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Nama Barang" name="name" id="edit-name" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-select name="category_id" id="edit-category_id" label="Kategori" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <?php foreach ($categories as $c): ?>
                <mdui-menu-item value="<?= $c['id'] ?>"><?= esc($c['name']) ?></mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
            <mdui-text-field label="Stok Saat Ini" name="current_stock" id="edit-current_stock" type="number" variant="outlined" min="0" style="flex: 1;"></mdui-text-field>
            <mdui-text-field label="Stok Minimum" name="minimum_stock" id="edit-minimum_stock" type="number" variant="outlined" min="0" style="flex: 1;"></mdui-text-field>
        </div>
        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
            <mdui-text-field label="Satuan" name="unit" id="edit-unit" variant="outlined" required style="flex: 1;"></mdui-text-field>
            <mdui-text-field label="Harga Terakhir (Rp)" name="last_price" id="edit-last_price" type="number" variant="outlined" min="0" style="flex: 1;"></mdui-text-field>
        </div>
        <mdui-text-field label="Expiry Date" name="expiry_date" id="edit-expiry_date" type="date" variant="outlined" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-edit')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-edit').submit()">Update</mdui-button>
</mdui-dialog>

<!-- DIALOG: HAPUS BARANG -->
<mdui-dialog id="dialog-delete" style="--mdui-dialog-width: 400px;">
    <div style="text-align: center; padding: 8px;">
        <mdui-icon name="delete_forever" style="font-size: 56px; color: #EF4444;"></mdui-icon>
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Hapus Barang?</h3>
        <p style="color: #666; margin: 0;">Yakin ingin menghapus <strong id="delete-name"></strong>?</p>
        <p style="color: #EF4444; font-size: 12px; margin-top: 8px;">Tindakan ini tidak dapat dibatalkan.</p>
    </div>
    <form id="form-delete" method="post"><?= csrf_field() ?></form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-delete')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" style="background: #EF4444;" onclick="document.getElementById('form-delete').submit()">Hapus</mdui-button>
</mdui-dialog>

<!-- DIALOG: TAMBAH KATEGORI -->
<mdui-dialog id="dialog-category-create" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Tambah Kategori</span>
    <form id="form-category-create" action="<?= base_url('items/category/store') ?>" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Nama Kategori" name="name" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Deskripsi" name="description" variant="outlined" rows="2" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-category-create')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-category-create').submit()">Simpan</mdui-button>
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
    .item-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: #EEF0FF; color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .item-icon mdui-icon { font-size: 18px; }
    .cell-title { font-weight: 600; color: var(--text-primary); font-size: 13px; }
    .cell-sub { color: var(--text-muted); font-size: 11px; margin-top: 2px; }

    .stock-cell { min-width: 80px; }
    .price-text { font-weight: 700; color: var(--text-primary); font-size: 13px; }

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
        max-height: 300px; overflow-y: auto; padding-right: 6px;
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
    .filter-option-sub { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
    .filter-option:hover .filter-option-content { border-color: var(--primary-light); background: #FAFBFF; }
    .filter-option input[type="radio"]:checked + .filter-option-content {
        border-color: var(--primary); background: var(--primary-soft);
    }
    .filter-option input[type="radio"]:checked + .filter-option-content .filter-option-title {
        color: var(--primary);
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
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
        const cat = document.querySelector('input[name="filter_category"]:checked');
        const stk = document.querySelector('input[name="filter_stock"]:checked');
        const url = new URL(window.location.href);
        url.searchParams.set('category', cat ? cat.value : 'all');
        url.searchParams.set('stock',    stk ? stk.value : 'all');
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }
    function clearCategory() { updateQueryParam('category', 'all'); }
    function clearStock()    { updateQueryParam('stock', 'all'); }
    function clearAllFilters() {
        const url = new URL(window.location.href);
        url.searchParams.delete('category');
        url.searchParams.delete('stock');
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }

    function clearAll() {
        const url = new URL(window.location.href);
        url.searchParams.delete('q');
        url.searchParams.delete('category');
        url.searchParams.delete('stock');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    // ===== CRUD =====
    function openEditDialog(el) {
        const d = el.dataset;
        document.getElementById('edit-code').value          = d.code;
        document.getElementById('edit-name').value          = d.name;
        document.getElementById('edit-category_id').value   = d.category_id;
        document.getElementById('edit-current_stock').value = d.current_stock;
        document.getElementById('edit-minimum_stock').value = d.minimum_stock;
        document.getElementById('edit-unit').value          = d.unit;
        document.getElementById('edit-last_price').value    = d.last_price;
        document.getElementById('edit-expiry_date').value   = d.expiry_date || '';
        document.getElementById('form-edit').action         = '<?= base_url('items/update') ?>/' + d.id;
        openDialog('dialog-edit');
    }

    function openDeleteDialog(el) {
        const d = el.dataset;
        document.getElementById('delete-name').textContent = d.name;
        document.getElementById('form-delete').action      = '<?= base_url('items/delete') ?>/' + d.id;
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