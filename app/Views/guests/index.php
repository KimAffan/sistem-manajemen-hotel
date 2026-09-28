<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Daftar Tamu</h1>
            <p class="page-sub">Kelola data tamu hotel</p>
        </div>
        <div class="header-actions">
            <mdui-button-icon onclick="openSearchModal()" title="Cari Tamu" class="icon-btn">
                <mdui-icon name="search"></mdui-icon>
                <?php if (! empty($q)): ?>
                    <span class="filter-badge" style="display: flex;">1</span>
                <?php endif; ?>
            </mdui-button-icon>

            <mdui-button onclick="openDialog('dialog-create')" variant="filled" class="btn-primary">
                <mdui-icon slot="icon" name="person_add"></mdui-icon>
                Tambah Tamu
            </mdui-button>
        </div>
    </div>

    <!-- ACTIVE FILTERS -->
    <?php if (! empty($q)): ?>
        <div class="active-filters">
            <span class="chip-label">Filter aktif:</span>
            <span class="chip">
                Cari: "<strong><?= esc($q) ?></strong>"
                <button onclick="clearSearch()" class="chip-close">×</button>
            </span>
            <button onclick="clearAll()" class="chip-clear">Hapus semua</button>
        </div>
    <?php endif; ?>

    <div class="modern-card">
        <div class="table-wrapper">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Lengkap</th>
                        <th>Kontak</th>
                        <th>No. Identitas</th>
                        <th>Alamat</th>
                        <th style="width: 120px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($guests)): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <mdui-icon name="people" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
                                    <p>Belum ada data tamu</p>
                                    <span>
                                        <?php if (! empty($q)): ?>
                                            Coba ubah kata kunci pencarian Anda
                                        <?php else: ?>
                                            Klik "Tambah Tamu" untuk memulai
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $startNo = ($pager->getCurrentPage() - 1) * $perPage;
                        foreach ($guests as $i => $g): 
                        ?>
                            <tr>
                                <td><span class="row-index"><?= $startNo + $i + 1 ?></span></td>
                                <td>
                                    <div class="cell-primary">
                                        <div class="guest-avatar">
                                            <?= strtoupper(substr($g['full_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="cell-title"><?= esc($g['full_name']) ?></div>
                                            <div class="cell-sub">ID: #<?= str_pad($g['id'], 4, '0', STR_PAD_LEFT) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (! empty($g['phone'])): ?>
                                        <div class="contact-row">
                                            <mdui-icon name="phone" style="font-size: 14px; color: var(--text-muted);"></mdui-icon>
                                            <span><?= esc($g['phone']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (! empty($g['email'])): ?>
                                        <div class="contact-row">
                                            <mdui-icon name="mail" style="font-size: 14px; color: var(--text-muted);"></mdui-icon>
                                            <span class="text-truncate" style="max-width: 180px;"><?= esc($g['email']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (empty($g['phone']) && empty($g['email'])): ?>
                                        <span style="color: var(--text-muted);">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($g['id_number'] ?: '-') ?></td>
                                <td>
                                    <div class="text-truncate" style="max-width: 220px;" title="<?= esc($g['address']) ?>">
                                        <?= esc($g['address'] ?: '-') ?>
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-group">
                                        <mdui-button-icon
                                            data-id="<?= $g['id'] ?>"
                                            data-full_name="<?= esc($g['full_name']) ?>"
                                            data-id_number="<?= esc($g['id_number'] ?? '') ?>"
                                            data-phone="<?= esc($g['phone'] ?? '') ?>"
                                            data-email="<?= esc($g['email'] ?? '') ?>"
                                            data-address="<?= esc($g['address'] ?? '') ?>"
                                            onclick="openEditDialog(this)"
                                            title="Edit">
                                            <mdui-icon name="edit"></mdui-icon>
                                        </mdui-button-icon>

                                        <mdui-button-icon
                                            data-id="<?= $g['id'] ?>"
                                            data-name="<?= esc($g['full_name']) ?>"
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

        <!-- PAGINATION -->
        <?= view('components/pagination', [
    'pager'       => $pager,
    'perPage'     => $perPage,
    'baseUrl'     => base_url('guests'),
    'queryParams' => ['q' => $q],
]) ?>
    </div>
</div>

<!-- MODAL: SEARCH -->
<mdui-dialog id="dialog-search" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Cari Tamu</span>
    <div style="padding: 4px 0;">
        <mdui-text-field
            id="search-input"
            value="<?= esc($q) ?>"
            placeholder="Ketik nama, telepon, atau email..."
            variant="outlined"
            clearable
            style="width: 100%;">
            <mdui-icon slot="icon" name="search"></mdui-icon>
        </mdui-text-field>
        <p style="font-size: 12px; color: var(--text-muted); margin: 12px 0 0 0;">
            Pencarian mencakup nama, nomor telepon, dan email.
        </p>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearSearch()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applySearch()">Terapkan</mdui-button>
</mdui-dialog>

<!-- DIALOG: TAMBAH -->
<mdui-dialog id="dialog-create" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Tambah Tamu</span>
    <form id="form-create" action="<?= base_url('guests/store') ?>" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Nama Lengkap" name="full_name" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="No. Identitas (KTP/Paspor)" name="id_number" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Nomor Telepon" name="phone" type="tel" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Email" name="email" type="email" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Alamat" name="address" variant="outlined" rows="2" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-create')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-create').submit()">Simpan</mdui-button>
</mdui-dialog>

<!-- DIALOG: EDIT -->
<mdui-dialog id="dialog-edit" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Edit Tamu</span>
    <form id="form-edit" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Nama Lengkap" name="full_name" id="edit-full_name" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="No. Identitas (KTP/Paspor)" name="id_number" id="edit-id_number" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Nomor Telepon" name="phone" id="edit-phone" type="tel" variant="outlined" style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
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
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Hapus Tamu?</h3>
        <p style="color: #666; margin: 0;">Yakin ingin menghapus tamu <strong id="delete-name"></strong>?</p>
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
    .guest-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white; font-weight: 700; font-size: 15px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .cell-title { font-weight: 600; color: var(--text-primary); font-size: 13px; }
    .cell-sub { color: var(--text-muted); font-size: 11px; margin-top: 2px; }

    .contact-row {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; color: var(--text-secondary);
        margin-bottom: 2px;
    }

    .text-truncate { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .action-group { display: inline-flex; gap: 4px; }

    .empty-state { padding: 48px 20px; text-align: center; }
    .empty-state p { font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 12px 0 4px 0; }
    .empty-state span { font-size: 13px; color: var(--text-muted); }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function openDialog(id)  { document.getElementById(id).open = true; }
    function closeDialog(id) { document.getElementById(id).open = false; }

    // ===== SEARCH (server-side via URL) =====
    function openSearchModal() {
        openDialog('dialog-search');
    }

    function applySearch() {
        const q = (document.getElementById('search-input').value || '').trim();
        updateQueryParam('q', q);
    }

    function clearSearch() {
        removeQueryParam('q');
    }

    function clearAll() {
        const url = new URL(window.location.href);
        url.searchParams.delete('q');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    // ===== CRUD =====
    function openEditDialog(el) {
        const d = el.dataset;
        document.getElementById('edit-full_name').value = d.full_name;
        document.getElementById('edit-id_number').value = d.id_number;
        document.getElementById('edit-phone').value     = d.phone;
        document.getElementById('edit-email').value     = d.email;
        document.getElementById('edit-address').value   = d.address;
        document.getElementById('form-edit').action     = '<?= base_url('guests/update') ?>/' + d.id;
        openDialog('dialog-edit');
    }

    function openDeleteDialog(el) {
        const d = el.dataset;
        document.getElementById('delete-name').textContent = d.name;
        document.getElementById('form-delete').action      = '<?= base_url('guests/delete') ?>/' + d.id;
        openDialog('dialog-delete');
    }

    // Enter di search input
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    applySearch();
                }
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