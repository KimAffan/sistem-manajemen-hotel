<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Kamar</h1>
            <p class="page-sub">Kelola data kamar dan statusnya</p>
        </div>
        <div class="header-actions">
            <!-- Search Icon -->
            <mdui-button-icon onclick="openSearchModal()" title="Cari Kamar" class="icon-btn">
                <mdui-icon name="search"></mdui-icon>
            </mdui-button-icon>

            <!-- Filter Icon (dengan badge) -->
            <mdui-button-icon onclick="openFilterModal()" title="Filter" class="icon-btn" id="filter-btn">
                <mdui-icon name="tune"></mdui-icon>
                <span class="filter-badge" id="filter-badge" style="display: none;">1</span>
            </mdui-button-icon>

            <mdui-button onclick="openDialog('dialog-create')" variant="filled" class="btn-primary">
                <mdui-icon slot="icon" name="add"></mdui-icon>
                Tambah Kamar
            </mdui-button>
        </div>
    </div>

    <!-- Active Filter Chips -->
    <div id="active-filters" class="active-filters" style="display: none;">
        <span class="chip-label">Filter aktif:</span>
        <span id="filter-chip-status" class="chip" style="display: none;">
            Status: <strong id="chip-status-value"></strong>
            <button onclick="clearStatusFilter()" class="chip-close">×</button>
        </span>
        <span id="filter-chip-search" class="chip" style="display: none;">
            Pencarian: "<strong id="chip-search-value"></strong>"
            <button onclick="clearSearchFilter()" class="chip-close">×</button>
        </span>
        <button onclick="clearAllFilters()" class="chip-clear">Hapus semua</button>
    </div>

    <div class="modern-card">
        <div class="table-wrapper">
            <table class="modern-table" id="rooms-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Kamar</th>
                        <th>Tipe</th>
                        <th>Lantai</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th style="width: 120px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rooms)): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <mdui-icon name="bed" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
                                    <p>Belum ada kamar</p>
                                    <span>Klik "Tambah Kamar" untuk memulai</span>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rooms as $i => $r): ?>
                            <tr class="room-row"
                                data-room_number="<?= strtolower(esc($r['room_number'])) ?>"
                                data-status="<?= esc($r['status']) ?>">
                                <td><span class="row-index"><?= $i + 1 ?></span></td>
                                <td>
                                    <div class="cell-primary">
                                        <div class="room-icon">
                                            <mdui-icon name="bed"></mdui-icon>
                                        </div>
                                        <div>
                                            <div class="cell-title">Kamar <?= esc($r['room_number']) ?></div>
                                            <div class="cell-sub">Lt. <?= esc($r['floor']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= esc($r['type_name'] ?? '-') ?></td>
                                <td>
                                    <span class="badge badge-neutral">
                                        <mdui-icon name="layers" style="font-size: 14px;"></mdui-icon>
                                        Lantai <?= esc($r['floor']) ?>
                                    </span>
                                </td>
                                <td><?= status_badge($r['status']) ?></td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="<?= esc($r['notes']) ?>">
                                        <?= esc($r['notes'] ?: '-') ?>
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-group">
                                        <mdui-button-icon
                                            data-id="<?= $r['id'] ?>"
                                            data-room_number="<?= esc($r['room_number']) ?>"
                                            data-room_type_id="<?= $r['room_type_id'] ?>"
                                            data-floor="<?= esc($r['floor']) ?>"
                                            data-status="<?= esc($r['status']) ?>"
                                            data-notes="<?= esc($r['notes'] ?? '') ?>"
                                            onclick="openEditDialog(this)"
                                            title="Edit">
                                            <mdui-icon name="edit"></mdui-icon>
                                        </mdui-button-icon>

                                        <mdui-button-icon
                                            data-id="<?= $r['id'] ?>"
                                            data-room_number="<?= esc($r['room_number']) ?>"
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

        <!-- No Result Info -->
        <div id="no-result" style="display: none; padding: 48px 20px; text-align: center;">
            <mdui-icon name="search_off" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
            <p style="font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 12px 0 4px 0;">
                Tidak ada hasil
            </p>
            <span style="font-size: 13px; color: var(--text-muted);">
                Coba ubah kata kunci atau filter Anda
            </span>
        </div>
    </div>
</div>

<!-- ============ MODAL: SEARCH ============ -->
<mdui-dialog id="dialog-search" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Cari Kamar</span>
    <div style="padding: 4px 0;">
        <mdui-text-field
            id="search-input"
            placeholder="Ketik nomor kamar..."
            variant="outlined"
            clearable
            autofocus
            style="width: 100%;">
            <mdui-icon slot="icon" name="search"></mdui-icon>
        </mdui-text-field>
        <p style="font-size: 12px; color: var(--text-muted); margin: 12px 0 0 0;">
            Contoh: <strong>101</strong>, <strong>2</strong> (untuk lantai 2)
        </p>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearSearchFilter()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applySearch()">Terapkan</mdui-button>
</mdui-dialog>

<!-- ============ MODAL: FILTER ============ -->
<mdui-dialog id="dialog-filter" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Filter Kamar</span>
    <div style="padding: 4px 0;">
        <div style="font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
            Status Kamar
        </div>

        <div class="filter-options">
            <label class="filter-option">
                <input type="radio" name="filter_status" value="all" checked onchange="selectFilterStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="done_all"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Semua Status</div>
                        <div class="filter-option-sub">Tampilkan semua kamar</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="vacant_clean" onchange="selectFilterStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="check_circle" style="color: #10B981;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Vacant Clean</div>
                        <div class="filter-option-sub">Kosong & siap huni</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="vacant_dirty" onchange="selectFilterStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="cleaning_services" style="color: #F59E0B;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Vacant Dirty</div>
                        <div class="filter-option-sub">Kosong, perlu dibersihkan</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="occupied" onchange="selectFilterStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="person" style="color: #EF4444;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Occupied</div>
                        <div class="filter-option-sub">Sedang dihuni tamu</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="on_change" onchange="selectFilterStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="sync" style="color: #3B82F6;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">On Change</div>
                        <div class="filter-option-sub">Tamu sedang check-out</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="out_of_order" onchange="selectFilterStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="warning" style="color: #E65100;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Out of Order</div>
                        <div class="filter-option-sub">Kamar dalam perbaikan</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="out_of_service" onchange="selectFilterStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="block" style="color: #757575;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Out of Service</div>
                        <div class="filter-option-sub">Kamar diblokir sementara</div>
                    </div>
                </div>
            </label>
        </div>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearStatusFilter()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applyFilter()">Terapkan</mdui-button>
</mdui-dialog>

<!-- DIALOG: TAMBAH -->
<mdui-dialog id="dialog-create" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Tambah Kamar</span>
    <form id="form-create" action="<?= base_url('rooms/store') ?>" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Nomor Kamar" name="room_number" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-select name="room_type_id" label="Tipe Kamar" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <?php foreach ($roomTypes as $rt): ?>
                <mdui-menu-item value="<?= $rt['id'] ?>"><?= esc($rt['name']) ?></mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>
        <mdui-text-field label="Lantai" name="floor" type="number" variant="outlined" min="1" value="1" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-select name="status" label="Status Kamar" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <mdui-menu-item value="vacant_clean">Vacant Clean</mdui-menu-item>
            <mdui-menu-item value="vacant_dirty">Vacant Dirty</mdui-menu-item>
            <mdui-menu-item value="occupied">Occupied</mdui-menu-item>
            <mdui-menu-item value="on_change">On Change</mdui-menu-item>
            <mdui-menu-item value="out_of_order">Out of Order</mdui-menu-item>
            <mdui-menu-item value="out_of_service">Out of Service</mdui-menu-item>
        </mdui-select>
        <mdui-text-field label="Catatan" name="notes" variant="outlined" rows="2" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-create')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-create').submit()">Simpan</mdui-button>
</mdui-dialog>

<!-- DIALOG: EDIT -->
<mdui-dialog id="dialog-edit" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Edit Kamar</span>
    <form id="form-edit" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Nomor Kamar" name="room_number" id="edit-room_number" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-select name="room_type_id" id="edit-room_type_id" label="Tipe Kamar" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <?php foreach ($roomTypes as $rt): ?>
                <mdui-menu-item value="<?= $rt['id'] ?>"><?= esc($rt['name']) ?></mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>
        <mdui-text-field label="Lantai" name="floor" id="edit-floor" type="number" variant="outlined" min="1" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-select name="status" id="edit-status" label="Status Kamar" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <mdui-menu-item value="vacant_clean">Vacant Clean</mdui-menu-item>
            <mdui-menu-item value="vacant_dirty">Vacant Dirty</mdui-menu-item>
            <mdui-menu-item value="occupied">Occupied</mdui-menu-item>
            <mdui-menu-item value="on_change">On Change</mdui-menu-item>
            <mdui-menu-item value="out_of_order">Out of Order</mdui-menu-item>
            <mdui-menu-item value="out_of_service">Out of Service</mdui-menu-item>
        </mdui-select>
        <mdui-text-field label="Catatan" name="notes" id="edit-notes" variant="outlined" rows="2" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-edit')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-edit').submit()">Update</mdui-button>
</mdui-dialog>

<!-- DIALOG: HAPUS -->
<mdui-dialog id="dialog-delete" style="--mdui-dialog-width: 400px;">
    <div style="text-align: center; padding: 8px;">
        <mdui-icon name="delete_forever" style="font-size: 56px; color: #EF4444;"></mdui-icon>
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Hapus Kamar?</h3>
        <p style="color: #666; margin: 0;">Yakin ingin menghapus kamar <strong id="delete-name"></strong>?</p>
        <p style="color: #EF4444; font-size: 12px; margin-top: 8px;">Tindakan ini tidak dapat dibatalkan.</p>
    </div>
    <form id="form-delete" method="post"><?= csrf_field() ?></form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-delete')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" style="background: #EF4444;" onclick="document.getElementById('form-delete').submit()">Hapus</mdui-button>
</mdui-dialog>

<style>
    .page-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 20px; flex-wrap: wrap; gap: 12px;
    }
    .page-title { font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px 0; }
    .page-sub { color: var(--text-muted); font-size: 13px; margin: 0; }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .icon-btn {
        width: 40px !important;
        height: 40px !important;
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
        position: absolute;
        top: -4px;
        right: -4px;
        background: var(--primary);
        color: white;
        font-size: 10px;
        font-weight: 700;
        min-width: 18px;
        height: 18px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
        border: 2px solid #fff;
    }

    /* Active Filters Chips */
    .active-filters {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        padding: 10px 14px;
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--border);
        flex-wrap: wrap;
    }
    .chip-label {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
    }
    .chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        background: var(--primary-soft);
        color: var(--primary);
        font-size: 12px;
        font-weight: 500;
    }
    .chip strong { color: var(--primary-dark); }
    .chip-close {
        background: none;
        border: none;
        color: var(--primary);
        font-size: 16px;
        line-height: 1;
        cursor: pointer;
        padding: 0;
        margin-left: 2px;
    }
    .chip-close:hover { color: #EF4444; }
    .chip-clear {
        background: none;
        border: none;
        color: #EF4444;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        padding: 4px 8px;
        margin-left: auto;
    }
    .chip-clear:hover { text-decoration: underline; }

    .modern-card {
        background: #fff; border-radius: 14px; border: 1px solid var(--border);
        box-shadow: var(--shadow-sm); overflow: hidden;
    }
    .table-wrapper { overflow-x: auto; }

    .modern-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .modern-table thead th {
        background: #F9FAFB; padding: 12px 20px; text-align: left;
        font-size: 11px; font-weight: 600; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border); white-space: nowrap;
    }
    .modern-table tbody td {
        padding: 14px 20px; border-bottom: 1px solid #F3F4F6; vertical-align: middle;
    }
    .modern-table tbody tr:last-child td { border-bottom: none; }
    .modern-table tbody tr:hover { background: #FAFBFF; }

    .row-index {
        display: inline-block; width: 24px; height: 24px;
        background: #F3F4F6; border-radius: 6px; text-align: center;
        line-height: 24px; font-size: 11px; font-weight: 600;
        color: var(--text-secondary);
    }

    .cell-primary { display: flex; align-items: center; gap: 12px; }
    .room-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: #EEF0FF; color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .room-icon mdui-icon { font-size: 20px; }
    .cell-title { font-weight: 600; color: var(--text-primary); font-size: 13px; }
    .cell-sub { color: var(--text-muted); font-size: 11px; margin-top: 2px; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 4px 10px; border-radius: 8px;
        font-size: 12px; font-weight: 600;
    }
    .badge-neutral { background: #F3F4F6; color: #4B5563; }

    .text-truncate { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .action-group { display: inline-flex; gap: 4px; }

    .empty-state { padding: 48px 20px; text-align: center; }
    .empty-state p { font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 12px 0 4px 0; }
    .empty-state span { font-size: 13px; color: var(--text-muted); }

    /* Filter Options */
    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .filter-option {
        display: block;
        cursor: pointer;
        position: relative;
    }
    .filter-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }
    .filter-option-content {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: #fff;
        transition: all 0.15s ease;
    }
    .filter-option-content mdui-icon {
        font-size: 22px;
        color: var(--text-muted);
        flex-shrink: 0;
    }
    .filter-option-content > div { flex: 1; }
    .filter-option-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-primary);
    }
    .filter-option-sub {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
    }
    .filter-option:hover .filter-option-content {
        border-color: var(--primary-light);
        background: #FAFBFF;
    }
    .filter-option input[type="radio"]:checked + .filter-option-content {
        border-color: var(--primary);
        background: var(--primary-soft);
    }
    .filter-option input[type="radio"]:checked + .filter-option-content .filter-option-title {
        color: var(--primary);
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let activeStatus = 'all';
    let activeSearch = '';

    function openDialog(id)  { document.getElementById(id).open = true; }
    function closeDialog(id) { document.getElementById(id).open = false; }

    // =====================
    // SEARCH
    // =====================
    function openSearchModal() {
        document.getElementById('search-input').value = activeSearch;
        openDialog('dialog-search');
    }

    function applySearch() {
        activeSearch = (document.getElementById('search-input').value || '').toLowerCase().trim();
        closeDialog('dialog-search');
        updateUI();
        filterTable();
    }

    function clearSearchFilter() {
        activeSearch = '';
        document.getElementById('search-input').value = '';
        closeDialog('dialog-search');
        updateUI();
        filterTable();
    }

    // =====================
    // FILTER
    // =====================
    function openFilterModal() {
        // Set radio sesuai filter aktif
        const radios = document.querySelectorAll('input[name="filter_status"]');
        radios.forEach(r => {
            r.checked = (r.value === activeStatus);
        });
        openDialog('dialog-filter');
    }

    function selectFilterStatus(el) {
        activeStatus = el.value;
    }

    function applyFilter() {
        closeDialog('dialog-filter');
        updateUI();
        filterTable();
    }

    function clearStatusFilter() {
        activeStatus = 'all';
        const radios = document.querySelectorAll('input[name="filter_status"]');
        radios.forEach(r => {
            r.checked = (r.value === 'all');
        });
        closeDialog('dialog-filter');
        updateUI();
        filterTable();
    }

    function clearAllFilters() {
        activeStatus = 'all';
        activeSearch = '';
        document.getElementById('search-input').value = '';
        updateUI();
        filterTable();
    }

    // =====================
    // UI UPDATE (Chips & Badge)
    // =====================
    function updateUI() {
        const badge = document.getElementById('filter-badge');
        const activeFilters = document.getElementById('active-filters');
        const chipStatus = document.getElementById('filter-chip-status');
        const chipSearch = document.getElementById('filter-chip-search');

        let activeCount = 0;

        // Status chip
        if (activeStatus !== 'all') {
            activeCount++;
            chipStatus.style.display = 'inline-flex';
            const labels = {
                'vacant_clean':   'Vacant Clean',
                'vacant_dirty':   'Vacant Dirty',
                'occupied':       'Occupied',
                'on_change':      'On Change',
                'out_of_order':   'Out of Order',
                'out_of_service': 'Out of Service',
            };
            document.getElementById('chip-status-value').textContent = labels[activeStatus] || activeStatus;
        } else {
            chipStatus.style.display = 'none';
        }

        // Search chip
        if (activeSearch) {
            activeCount++;
            chipSearch.style.display = 'inline-flex';
            document.getElementById('chip-search-value').textContent = activeSearch;
        } else {
            chipSearch.style.display = 'none';
        }

        // Filter badge (hanya status)
        if (activeStatus !== 'all') {
            badge.style.display = 'flex';
            badge.textContent = '1';
        } else {
            badge.style.display = 'none';
        }

        // Show/hide active filters bar
        activeFilters.style.display = activeCount > 0 ? 'flex' : 'none';
    }

    // =====================
    // FILTER TABLE
    // =====================
    function filterTable() {
        let visibleCount = 0;

        document.querySelectorAll('.room-row').forEach(row => {
            const matchSearch = ! activeSearch || row.dataset.room_number.includes(activeSearch);
            const matchStatus = activeStatus === 'all' || row.dataset.status === activeStatus;
            const show = matchSearch && matchStatus;
            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        // Show/hide "no result" message
        const noResult = document.getElementById('no-result');
        if (visibleCount === 0 && document.querySelectorAll('.room-row').length > 0) {
            noResult.style.display = 'block';
        } else {
            noResult.style.display = 'none';
        }
    }

    // =====================
    // CRUD DIALOGS
    // =====================
    function openEditDialog(el) {
        const d = el.dataset;
        document.getElementById('edit-room_number').value   = d.room_number;
        document.getElementById('edit-floor').value         = d.floor;
        document.getElementById('edit-notes').value         = d.notes || '';
        document.getElementById('edit-room_type_id').value  = d.room_type_id;
        document.getElementById('edit-status').value        = d.status;
        document.getElementById('form-edit').action         = '<?= base_url('rooms/update') ?>/' + d.id;
        openDialog('dialog-edit');
    }

    function openDeleteDialog(el) {
        const d = el.dataset;
        document.getElementById('delete-name').textContent = d.room_number;
        document.getElementById('form-delete').action      = '<?= base_url('rooms/delete') ?>/' + d.id;
        openDialog('dialog-delete');
    }

    // Enter di search input → apply
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') applySearch();
            });
        }
    });

    // Flash messages
    <?php if (session()->getFlashdata('success')): ?>
        showAlert(<?= json_encode(session()->getFlashdata('success')) ?>, 'success', 2000);
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        showAlert(<?= json_encode(session()->getFlashdata('error')) ?>, 'error');
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        showAlert(<?= json_encode(implode(' ', session()->getFlashdata('errors'))) ?>, 'error');
    <?php endif; ?>
    <?php if (session()->getFlashdata('open_dialog')): ?>
        openDialog(<?= json_encode(session()->getFlashdata('open_dialog')) ?>);
    <?php endif; ?>
</script>
<?= $this->endSection() ?>