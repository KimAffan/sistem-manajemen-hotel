<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Supplier</h1>
            <p class="page-sub">Daftar supplier dan kontak person</p>
        </div>
        <div class="header-actions">
            <mdui-button-icon onclick="openSearchModal()" title="Cari Supplier" class="icon-btn">
                <mdui-icon name="search"></mdui-icon>
            </mdui-button-icon>

            <mdui-button onclick="openDialog('dialog-create')" variant="filled" class="btn-primary">
                <mdui-icon slot="icon" name="add_business"></mdui-icon>
                Tambah Supplier
            </mdui-button>
        </div>
    </div>

    <!-- ACTIVE FILTERS -->
    <div id="active-filters" class="active-filters" style="display: none;">
        <span class="chip-label">Filter aktif:</span>
        <span id="filter-chip-search" class="chip" style="display: none;">
            Cari: "<strong id="chip-search-value"></strong>"
            <button onclick="clearSearchFilter()" class="chip-close">×</button>
        </span>
        <button onclick="clearAllFilters()" class="chip-clear">Hapus semua</button>
    </div>

    <div class="modern-card">
        <div class="table-wrapper">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Supplier</th>
                        <th>Kontak Person</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th style="width: 120px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($suppliers)): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <mdui-icon name="local_shipping" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
                                    <p>Belum ada supplier</p>
                                    <span>Klik "Tambah Supplier" untuk memulai</span>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($suppliers as $i => $s): ?>
                            <tr class="sup-row" data-search="<?= strtolower(esc($s['name'] . ' ' . ($s['contact_person'] ?? '') . ' ' . ($s['phone'] ?? '') . ' ' . ($s['email'] ?? ''))) ?>">
                                <td><span class="row-index"><?= $i + 1 ?></span></td>
                                <td>
                                    <div class="cell-primary">
                                        <div class="sup-icon">
                                            <mdui-icon name="local_shipping"></mdui-icon>
                                        </div>
                                        <div>
                                            <div class="cell-title"><?= esc($s['name']) ?></div>
                                            <div class="cell-sub">ID: #<?= str_pad($s['id'], 3, '0', STR_PAD_LEFT) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= esc($s['contact_person'] ?: '-') ?></td>
                                <td>
                                    <?php if (! empty($s['phone'])): ?>
                                        <div class="contact-row">
                                            <mdui-icon name="phone" style="font-size: 14px; color: var(--text-muted);"></mdui-icon>
                                            <span><?= esc($s['phone']) ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (! empty($s['email'])): ?>
                                        <div class="contact-row">
                                            <mdui-icon name="mail" style="font-size: 14px; color: var(--text-muted);"></mdui-icon>
                                            <span class="text-truncate" style="max-width: 180px;"><?= esc($s['email']) ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 220px;" title="<?= esc($s['address']) ?>">
                                        <?= esc($s['address'] ?: '-') ?>
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-group">
                                        <mdui-button-icon
                                            data-id="<?= $s['id'] ?>"
                                            data-name="<?= esc($s['name']) ?>"
                                            data-contact_person="<?= esc($s['contact_person'] ?? '') ?>"
                                            data-phone="<?= esc($s['phone'] ?? '') ?>"
                                            data-email="<?= esc($s['email'] ?? '') ?>"
                                            data-address="<?= esc($s['address'] ?? '') ?>"
                                            onclick="openEditDialog(this)"
                                            title="Edit">
                                            <mdui-icon name="edit"></mdui-icon>
                                        </mdui-button-icon>

                                        <mdui-button-icon
                                            data-id="<?= $s['id'] ?>"
                                            data-name="<?= esc($s['name']) ?>"
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

        <div id="no-result" style="display: none; padding: 48px 20px; text-align: center;">
            <mdui-icon name="search_off" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
            <p style="font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 12px 0 4px 0;">
                Tidak ada hasil
            </p>
            <span style="font-size: 13px; color: var(--text-muted);">
                Coba ubah kata kunci pencarian Anda
            </span>
        </div>
    </div>
</div>

<!-- ============ MODAL: SEARCH ============ -->
<mdui-dialog id="dialog-search" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Cari Supplier</span>
    <div style="padding: 4px 0;">
        <mdui-text-field
            id="search-input"
            placeholder="Ketik nama, kontak, atau telepon..."
            variant="outlined"
            clearable
            style="width: 100%;">
            <mdui-icon slot="icon" name="search"></mdui-icon>
        </mdui-text-field>
        <p style="font-size: 12px; color: var(--text-muted); margin: 12px 0 0 0;">
            Pencarian mencakup nama, kontak person, telepon, dan email.
        </p>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearSearchFilter()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applySearch()">Terapkan</mdui-button>
</mdui-dialog>

<!-- DIALOG: TAMBAH -->
<mdui-dialog id="dialog-create" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Tambah Supplier</span>
    <form id="form-create" action="<?= base_url('suppliers/store') ?>" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Nama Supplier" name="name" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Nama Kontak Person" name="contact_person" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Telepon" name="phone" type="tel" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Email" name="email" type="email" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Alamat" name="address" variant="outlined" rows="2" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-create')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-create').submit()">Simpan</mdui-button>
</mdui-dialog>

<!-- DIALOG: EDIT -->
<mdui-dialog id="dialog-edit" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Edit Supplier</span>
    <form id="form-edit" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Nama Supplier" name="name" id="edit-name" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Nama Kontak Person" name="contact_person" id="edit-contact_person" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Telepon" name="phone" id="edit-phone" type="tel" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Email" name="email" id="edit-email" type="email" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Alamat" name="address" id="edit-address" variant="outlined" rows="2" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-edit')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-edit').submit()">Update</mdui-button>
</mdui-dialog>

<!-- DIALOG: HAPUS -->
<mdui-dialog id="dialog-delete" style="--mdui-dialog-width: 400px;">
    <div style="text-align: center; padding: 8px;">
        <mdui-icon name="delete_forever" style="font-size: 56px; color: #EF4444;"></mdui-icon>
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Hapus Supplier?</h3>
        <p style="color: #666; margin: 0;">Yakin ingin menghapus <strong id="delete-name"></strong>?</p>
        <p style="color: #EF4444; font-size: 12px; margin-top: 8px;">Tindakan ini tidak dapat dibatalkan.</p>
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
    }
    .icon-btn:hover {
        background: var(--primary-soft) !important;
        color: var(--primary) !important;
        border-color: var(--primary) !important;
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
    .sup-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: #EEF0FF; color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .sup-icon mdui-icon { font-size: 20px; }
    .cell-title { font-weight: 600; color: var(--text-primary); font-size: 13px; }
    .cell-sub { color: var(--text-muted); font-size: 11px; margin-top: 2px; }

    .contact-row {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; color: var(--text-secondary);
    }

    .text-truncate { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .action-group { display: inline-flex; gap: 2px; }

    .empty-state { padding: 48px 20px; text-align: center; }
    .empty-state p { font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 12px 0 4px 0; }
    .empty-state span { font-size: 13px; color: var(--text-muted); }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let activeSearch = '';

    function openDialog(id)  { document.getElementById(id).open = true; }
    function closeDialog(id) { document.getElementById(id).open = false; }

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
    function clearAllFilters() {
        activeSearch = '';
        document.getElementById('search-input').value = '';
        updateUI();
        filterTable();
    }

    function updateUI() {
        const activeFilters = document.getElementById('active-filters');
        const chipSearch = document.getElementById('filter-chip-search');

        if (activeSearch) {
            chipSearch.style.display = 'inline-flex';
            document.getElementById('chip-search-value').textContent = activeSearch;
            activeFilters.style.display = 'flex';
        } else {
            chipSearch.style.display = 'none';
            activeFilters.style.display = 'none';
        }
    }

    function filterTable() {
        let visibleCount = 0;
        document.querySelectorAll('.sup-row').forEach(row => {
            const match = ! activeSearch || row.dataset.search.includes(activeSearch);
            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });

        const noResult = document.getElementById('no-result');
        const totalRows = document.querySelectorAll('.sup-row').length;
        noResult.style.display = (visibleCount === 0 && totalRows > 0) ? 'block' : 'none';
    }

    function openEditDialog(el) {
        const d = el.dataset;
        document.getElementById('edit-name').value           = d.name;
        document.getElementById('edit-contact_person').value = d.contact_person;
        document.getElementById('edit-phone').value          = d.phone;
        document.getElementById('edit-email').value          = d.email;
        document.getElementById('edit-address').value        = d.address;
        document.getElementById('form-edit').action          = '<?= base_url('suppliers/update') ?>/' + d.id;
        openDialog('dialog-edit');
    }

    function openDeleteDialog(el) {
        const d = el.dataset;
        document.getElementById('delete-name').textContent = d.name;
        document.getElementById('form-delete').action      = '<?= base_url('suppliers/delete') ?>/' + d.id;
        openDialog('dialog-delete');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') applySearch();
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
    <?php if (session()->getFlashdata('open_dialog')): ?>
        openDialog(<?= json_encode(session()->getFlashdata('open_dialog')) ?>);
    <?php endif; ?>
</script>
<?= $this->endSection() ?>