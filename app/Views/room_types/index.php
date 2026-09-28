<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Tipe Kamar</h1>
            <p class="page-sub">Kelola kategori kamar dan harga dasar</p>
        </div>
        <mdui-button onclick="openDialog('dialog-create')" variant="filled" class="btn-primary">
            <mdui-icon slot="icon" name="add"></mdui-icon>
            Tambah Tipe
        </mdui-button>
    </div>

    <div class="modern-card">
        <div class="table-wrapper">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Tipe</th>
                        <th>Kapasitas</th>
                        <th>Harga Dasar</th>
                        <th>Deskripsi</th>
                        <th style="width: 120px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($roomTypes)): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <mdui-icon name="meeting_room" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
                                    <p>Belum ada tipe kamar</p>
                                    <span>Klik "Tambah Tipe" untuk memulai</span>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($roomTypes as $i => $rt): ?>
                            <tr>
                                <td><span class="row-index"><?= $i + 1 ?></span></td>
                                <td>
                                    <div class="cell-primary">
                                        <div class="type-icon">
                                            <mdui-icon name="meeting_room"></mdui-icon>
                                        </div>
                                        <div>
                                            <div class="cell-title"><?= esc($rt['name']) ?></div>
                                            <div class="cell-sub">ID: #<?= str_pad($rt['id'], 3, '0', STR_PAD_LEFT) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        <mdui-icon name="people" style="font-size: 14px;"></mdui-icon>
                                        <?= esc($rt['capacity']) ?> orang
                                    </span>
                                </td>
                                <td>
                                    <div class="price-text">Rp <?= number_format($rt['base_price'], 0, ',', '.') ?></div>
                                    <div class="cell-sub">per malam</div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 240px;" title="<?= esc($rt['description']) ?>">
                                        <?= esc($rt['description'] ?: '-') ?>
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-group">
                                        <mdui-button-icon
                                            data-id="<?= $rt['id'] ?>"
                                            data-name="<?= esc($rt['name']) ?>"
                                            data-capacity="<?= $rt['capacity'] ?>"
                                            data-base_price="<?= $rt['base_price'] ?>"
                                            data-description="<?= esc($rt['description'] ?? '') ?>"
                                            onclick="openEditDialog(this)"
                                            title="Edit">
                                            <mdui-icon name="edit"></mdui-icon>
                                        </mdui-button-icon>

                                        <mdui-button-icon
                                            data-id="<?= $rt['id'] ?>"
                                            data-name="<?= esc($rt['name']) ?>"
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
    </div>
</div>

<!-- DIALOG: TAMBAH -->
<mdui-dialog id="dialog-create" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Tambah Tipe Kamar</span>
    <form id="form-create" action="<?= base_url('room-types/store') ?>" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Nama Tipe" name="name" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Kapasitas (orang)" name="capacity" type="number" variant="outlined" min="1" max="10" value="2" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Harga Dasar (Rp)" name="base_price" type="number" variant="outlined" min="0" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Deskripsi" name="description" variant="outlined" rows="3" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-create')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-create').submit()">Simpan</mdui-button>
</mdui-dialog>

<!-- DIALOG: EDIT -->
<mdui-dialog id="dialog-edit" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Edit Tipe Kamar</span>
    <form id="form-edit" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Nama Tipe" name="name" id="edit-name" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Kapasitas (orang)" name="capacity" id="edit-capacity" type="number" variant="outlined" min="1" max="10" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Harga Dasar (Rp)" name="base_price" id="edit-base_price" type="number" variant="outlined" min="0" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Deskripsi" name="description" id="edit-description" variant="outlined" rows="3" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-edit')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-edit').submit()">Update</mdui-button>
</mdui-dialog>

<!-- DIALOG: HAPUS -->
<mdui-dialog id="dialog-delete" style="--mdui-dialog-width: 400px;">
    <div style="text-align: center; padding: 8px;">
        <mdui-icon name="delete_forever" style="font-size: 56px; color: #EF4444;"></mdui-icon>
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Hapus Tipe Kamar?</h3>
        <p style="color: #666; margin: 0;">Yakin ingin menghapus <strong id="delete-name"></strong>?</p>
        <p style="color: #EF4444; font-size: 12px; margin-top: 8px;">Tindakan ini tidak dapat dibatalkan.</p>
    </div>
    <form id="form-delete" method="post"><?= csrf_field() ?></form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-delete')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" style="background: #EF4444;" onclick="document.getElementById('form-delete').submit()">Hapus</mdui-button>
</mdui-dialog>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 4px 0;
    }
    .page-sub { color: var(--text-muted); font-size: 13px; margin: 0; }

    .modern-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .table-wrapper { overflow-x: auto; }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .modern-table thead th {
        background: #F9FAFB;
        padding: 12px 20px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    .modern-table tbody td {
        padding: 14px 20px;
        border-bottom: 1px solid #F3F4F6;
        vertical-align: middle;
    }
    .modern-table tbody tr:last-child td { border-bottom: none; }
    .modern-table tbody tr { transition: background 0.15s; }
    .modern-table tbody tr:hover { background: #FAFBFF; }

    .row-index {
        display: inline-block;
        width: 24px; height: 24px;
        background: #F3F4F6;
        border-radius: 6px;
        text-align: center;
        line-height: 24px;
        font-size: 11px;
        font-weight: 600;
        color: var(--text-secondary);
    }

    .cell-primary { display: flex; align-items: center; gap: 12px; }
    .type-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: #EEF0FF;
        color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .type-icon mdui-icon { font-size: 20px; }
    .cell-title { font-weight: 600; color: var(--text-primary); font-size: 13px; }
    .cell-sub { color: var(--text-muted); font-size: 11px; margin-top: 2px; }

    .price-text { font-weight: 700; color: var(--text-primary); font-size: 14px; }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-info { background: #EFF6FF; color: #3B82F6; }

    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .action-group { display: inline-flex; gap: 4px; }

    .empty-state {
        padding: 48px 20px;
        text-align: center;
    }
    .empty-state p {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-secondary);
        margin: 12px 0 4px 0;
    }
    .empty-state span { font-size: 13px; color: var(--text-muted); }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function openDialog(id)  { document.getElementById(id).open = true; }
    function closeDialog(id) { document.getElementById(id).open = false; }

    function openEditDialog(el) {
        const d = el.dataset;
        document.getElementById('edit-name').value        = d.name;
        document.getElementById('edit-capacity').value    = d.capacity;
        document.getElementById('edit-base_price').value  = d.base_price;
        document.getElementById('edit-description').value = d.description || '';
        document.getElementById('form-edit').action       = '<?= base_url('room-types/update') ?>/' + d.id;
        openDialog('dialog-edit');
    }

    function openDeleteDialog(el) {
        const d = el.dataset;
        document.getElementById('delete-name').textContent = d.name;
        document.getElementById('form-delete').action      = '<?= base_url('room-types/delete') ?>/' + d.id;
        openDialog('dialog-delete');
    }

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