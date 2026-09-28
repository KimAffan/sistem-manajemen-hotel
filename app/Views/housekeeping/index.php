<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Housekeeping</h1>
            <p class="page-sub">Kelola tugas kebersihan kamar</p>
        </div>
        <div class="header-actions">
            <mdui-button-icon onclick="openSearchModal()" title="Cari Tugas" class="icon-btn">
                <mdui-icon name="search"></mdui-icon>
                <?php if (! empty($q)): ?>
                    <span class="filter-badge" style="display: flex;">1</span>
                <?php endif; ?>
            </mdui-button-icon>

            <mdui-button-icon onclick="openFilterModal()" title="Filter" class="icon-btn" id="filter-btn">
                <mdui-icon name="tune"></mdui-icon>
                <?php if ($status !== 'all'): ?>
                    <span class="filter-badge" style="display: flex;">1</span>
                <?php endif; ?>
            </mdui-button-icon>

            <mdui-button onclick="openDialog('dialog-create')" variant="filled" class="btn-primary">
                <mdui-icon slot="icon" name="add"></mdui-icon>
                Tugas Baru
            </mdui-button>
        </div>
    </div>

    <!-- ACTIVE FILTERS -->
    <?php if (! empty($q) || $status !== 'all'): 
        $statusLabels = [
            'pending'     => 'Pending',
            'in_progress' => 'In Progress',
            'done'        => 'Done',
            'verified'    => 'Verified',
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
                        <th>Kamar</th>
                        <th>Tipe Tugas</th>
                        <th>Ditugaskan Ke</th>
                        <th>Status</th>
                        <th style="width: 80px;">Foto</th>
                        <th style="width: 140px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tasks)): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <mdui-icon name="cleaning_services" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
                                    <p>Belum ada tugas</p>
                                    <span>
                                        <?php if (! empty($q) || $status !== 'all'): ?>
                                            Coba ubah kata kunci atau filter Anda
                                        <?php else: ?>
                                            Klik "Tugas Baru" untuk memulai
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $startNo = ($pager->getCurrentPage() - 1) * $perPage;
                        foreach ($tasks as $i => $t): 
                        ?>
                            <tr>
                                <td><span class="row-index"><?= $startNo + $i + 1 ?></span></td>
                                <td>
                                    <div class="cell-primary">
                                        <div class="room-icon"><mdui-icon name="bed"></mdui-icon></div>
                                        <div>
                                            <div class="cell-title">Kamar <?= esc($t['room_number']) ?></div>
                                            <div class="cell-sub">Lt. <?= esc($t['floor']) ?> — <?= esc($t['room_type_name'] ?? '-') ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-neutral">
                                        <mdui-icon name="assignment" style="font-size: 14px;"></mdui-icon>
                                        <?= task_type_label($t['task_type']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (! empty($t['staff_name'])): ?>
                                        <div class="cell-primary">
                                            <div class="guest-avatar" style="width: 28px; height: 28px; font-size: 11px;">
                                                <?= strtoupper(substr($t['staff_name'], 0, 1)) ?>
                                            </div>
                                            <div class="cell-title" style="font-size: 12px;"><?= esc($t['staff_name']) ?></div>
                                        </div>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted); font-size: 12px;">- Belum ditugaskan -</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= hk_badge($t['status']) ?></td>
                                <td>
                                    <?php if (! empty($t['photo'])): ?>
                                        <img
                                            src="<?= base_url('uploads/housekeeping/' . $t['photo']) ?>"
                                            alt="Foto kamar"
                                            onclick="openPhotoDialog('<?= base_url('uploads/housekeeping/' . $t['photo']) ?>')"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 1px solid var(--border); transition: all 0.15s;"
                                            onmouseover="this.style.transform='scale(1.08)'; this.style.borderColor='var(--primary)';"
                                            onmouseout="this.style.transform='scale(1)'; this.style.borderColor='var(--border)';"
                                        >
                                    <?php else: ?>
                                        <span style="color: #CBD5E1; font-size: 12px;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-group">
                                        <mdui-button-icon
                                            data-id="<?= $t['id'] ?>"
                                            data-room_id="<?= $t['room_id'] ?>"
                                            data-assigned_to="<?= $t['assigned_to'] ?>"
                                            data-task_type="<?= $t['task_type'] ?>"
                                            data-status="<?= $t['status'] ?>"
                                            data-notes="<?= esc($t['notes'] ?? '') ?>"
                                            onclick="openDetailDialog(this)"
                                            title="Detail & Ubah Status">
                                            <mdui-icon name="visibility"></mdui-icon>
                                        </mdui-button-icon>

                                        <mdui-button-icon
                                            data-id="<?= $t['id'] ?>"
                                            data-room_id="<?= $t['room_id'] ?>"
                                            data-assigned_to="<?= $t['assigned_to'] ?>"
                                            data-task_type="<?= $t['task_type'] ?>"
                                            data-notes="<?= esc($t['notes'] ?? '') ?>"
                                            onclick="openEditDialog(this)"
                                            title="Edit">
                                            <mdui-icon name="edit"></mdui-icon>
                                        </mdui-button-icon>

                                        <mdui-button-icon
                                            data-id="<?= $t['id'] ?>"
                                            data-room="<?= esc($t['room_number']) ?>"
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
            'baseUrl'     => base_url('housekeeping'),
            'queryParams' => ['q' => $q, 'status' => $status],
        ]) ?>
    </div>
</div>

<!-- MODAL: SEARCH -->
<mdui-dialog id="dialog-search" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Cari Tugas</span>
    <div style="padding: 4px 0;">
        <mdui-text-field
            id="search-input"
            value="<?= esc($q) ?>"
            placeholder="Ketik nomor kamar atau nama staff..."
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
    <span slot="headline">Filter Tugas</span>
    <div style="padding: 4px 0;">
        <div class="filter-section-title">
            <mdui-icon name="tune"></mdui-icon>
            Status Tugas
        </div>
        <div class="filter-options">
            <label class="filter-option">
                <input type="radio" name="filter_status" value="all" <?= $status === 'all' ? 'checked' : '' ?>>
                <div class="filter-option-content">
                    <mdui-icon name="done_all"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Semua Status</div>
                        <div class="filter-option-sub">Tampilkan semua tugas</div>
                    </div>
                </div>
            </label>
            <label class="filter-option">
                <input type="radio" name="filter_status" value="pending" <?= $status === 'pending' ? 'checked' : '' ?>>
                <div class="filter-option-content">
                    <mdui-icon name="hourglass_empty" style="color: #F59E0B;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Pending</div>
                        <div class="filter-option-sub">Belum dikerjakan</div>
                    </div>
                </div>
            </label>
            <label class="filter-option">
                <input type="radio" name="filter_status" value="in_progress" <?= $status === 'in_progress' ? 'checked' : '' ?>>
                <div class="filter-option-content">
                    <mdui-icon name="sync" style="color: #3B82F6;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">In Progress</div>
                        <div class="filter-option-sub">Sedang dikerjakan</div>
                    </div>
                </div>
            </label>
            <label class="filter-option">
                <input type="radio" name="filter_status" value="done" <?= $status === 'done' ? 'checked' : '' ?>>
                <div class="filter-option-content">
                    <mdui-icon name="check_circle" style="color: #10B981;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Done</div>
                        <div class="filter-option-sub">Selesai dikerjakan</div>
                    </div>
                </div>
            </label>
            <label class="filter-option">
                <input type="radio" name="filter_status" value="verified" <?= $status === 'verified' ? 'checked' : '' ?>>
                <div class="filter-option-content">
                    <mdui-icon name="verified" style="color: #7C3AED;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Verified</div>
                        <div class="filter-option-sub">Sudah diverifikasi</div>
                    </div>
                </div>
            </label>
        </div>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearStatus()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applyFilter()">Terapkan</mdui-button>
</mdui-dialog>

<!-- DIALOG: TAMBAH -->
<mdui-dialog id="dialog-create" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Buat Tugas Housekeeping</span>
    <form id="form-create" action="<?= base_url('housekeeping/store') ?>" method="post">
        <?= csrf_field() ?>
        <mdui-select name="room_id" label="Kamar" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <?php foreach ($rooms as $rm): ?>
                <mdui-menu-item value="<?= $rm['id'] ?>">
                    <?= esc($rm['room_number']) ?> — Lantai <?= esc($rm['floor']) ?> (<?= esc($rm['type_name']) ?>)
                </mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>
        <mdui-select name="task_type" label="Tipe Tugas" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <mdui-menu-item value="daily_clean">Daily Clean</mdui-menu-item>
            <mdui-menu-item value="checkout_clean">Checkout Clean</mdui-menu-item>
            <mdui-menu-item value="deep_clean">Deep Clean</mdui-menu-item>
            <mdui-menu-item value="inspection">Inspection</mdui-menu-item>
        </mdui-select>
        <mdui-select name="assigned_to" label="Ditugaskan Ke (opsional)" variant="outlined" style="width: 100%; margin-bottom: 12px;">
            <mdui-menu-item value="">- Tidak ditugaskan -</mdui-menu-item>
            <?php foreach ($staffs as $s): ?>
                <mdui-menu-item value="<?= $s['id'] ?>"><?= esc($s['username']) ?> (<?= esc($s['role_names']) ?>)</mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>
        <mdui-text-field label="Catatan" name="notes" variant="outlined" rows="2" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-create')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-create').submit()">Simpan</mdui-button>
</mdui-dialog>

<!-- DIALOG: EDIT -->
<mdui-dialog id="dialog-edit" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Edit Tugas</span>
    <form id="form-edit" method="post">
        <?= csrf_field() ?>
        <mdui-select name="room_id" id="edit-room_id" label="Kamar" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <?php foreach ($rooms as $rm): ?>
                <mdui-menu-item value="<?= $rm['id'] ?>"><?= esc($rm['room_number']) ?> — Lt. <?= esc($rm['floor']) ?></mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>
        <mdui-select name="task_type" id="edit-task_type" label="Tipe Tugas" variant="outlined" required style="width: 100%; margin-bottom: 12px;">
            <mdui-menu-item value="daily_clean">Daily Clean</mdui-menu-item>
            <mdui-menu-item value="checkout_clean">Checkout Clean</mdui-menu-item>
            <mdui-menu-item value="deep_clean">Deep Clean</mdui-menu-item>
            <mdui-menu-item value="inspection">Inspection</mdui-menu-item>
        </mdui-select>
        <mdui-select name="assigned_to" id="edit-assigned_to" label="Ditugaskan Ke" variant="outlined" style="width: 100%; margin-bottom: 12px;">
            <mdui-menu-item value="">- Tidak ditugaskan -</mdui-menu-item>
            <?php foreach ($staffs as $s): ?>
                <mdui-menu-item value="<?= $s['id'] ?>"><?= esc($s['username']) ?></mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>
        <mdui-text-field label="Catatan" name="notes" id="edit-notes" variant="outlined" rows="2" style="width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-edit')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-edit').submit()">Update</mdui-button>
</mdui-dialog>

<!-- DIALOG: DETAIL -->
<mdui-dialog id="dialog-detail" style="--mdui-dialog-width: 520px;">
    <span slot="headline">Detail Tugas</span>
    <div style="min-width: 420px; padding: 4px 0;">
        <div style="padding: 16px; background: var(--primary-soft); border-radius: 12px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px;">
                <span style="color: var(--text-secondary);">Kamar:</span><strong id="detail-room" style="color: var(--text-primary);">-</strong>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px;">
                <span style="color: var(--text-secondary);">Tipe Tugas:</span><strong id="detail-type" style="color: var(--text-primary);">-</strong>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 13px; align-items: center;">
                <span style="color: var(--text-secondary);">Status:</span><span id="detail-status">-</span>
            </div>
        </div>

        <mdui-divider></mdui-divider>

        <h4 style="margin: 20px 0 12px 0; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted);">
            Ubah Status
        </h4>
        <form id="form-status" method="post">
            <?= csrf_field() ?>
            <mdui-select name="status" id="detail-status-select" variant="outlined" required style="width: 100%;">
                <mdui-menu-item value="pending">Pending</mdui-menu-item>
                <mdui-menu-item value="in_progress">In Progress</mdui-menu-item>
                <mdui-menu-item value="done">Done</mdui-menu-item>
                <mdui-menu-item value="verified">Verified</mdui-menu-item>
            </mdui-select>
            <mdui-button variant="filled" style="margin-top: 12px; width: 100%;" onclick="document.getElementById('form-status').submit()">
                Simpan Status
            </mdui-button>
        </form>

        <mdui-divider style="margin: 24px 0;"></mdui-divider>

        <h4 style="margin: 0 0 12px 0; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted);">
            Upload Foto Kondisi Kamar
        </h4>
        <form id="form-photo" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="file" name="photo" accept="image/*" required style="width: 100%; padding: 10px; border: 1px dashed var(--border); border-radius: 8px; font-size: 13px; background: #FAFBFF;">
            <mdui-button variant="outlined" style="margin-top: 12px; width: 100%;" onclick="document.getElementById('form-photo').submit()">
                Upload Foto
            </mdui-button>
        </form>
    </div>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-detail')">Tutup</mdui-button>
</mdui-dialog>

<!-- DIALOG: PREVIEW FOTO -->
<mdui-dialog id="dialog-photo" style="--mdui-dialog-width: 600px;">
    <span slot="headline">Foto Kondisi Kamar</span>
    <img id="photo-preview" src="" style="width: 100%; border-radius: 12px;">
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-photo')">Tutup</mdui-button>
</mdui-dialog>

<!-- DIALOG: HAPUS -->
<mdui-dialog id="dialog-delete" style="--mdui-dialog-width: 400px;">
    <div style="text-align: center; padding: 8px;">
        <mdui-icon name="delete_forever" style="font-size: 56px; color: #EF4444;"></mdui-icon>
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Hapus Tugas?</h3>
        <p style="color: #666; margin: 0;">Yakin ingin menghapus tugas untuk kamar <strong id="delete-room"></strong>?</p>
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
    .room-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: #EEF0FF; color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .room-icon mdui-icon { font-size: 18px; }
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
        max-height: 380px; overflow-y: auto; padding-right: 6px;
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
        const selected = document.querySelector('input[name="filter_status"]:checked');
        updateQueryParam('status', selected ? selected.value : 'all');
    }
    function clearStatus() { removeQueryParam('status'); }

    function clearAll() {
        const url = new URL(window.location.href);
        url.searchParams.delete('q');
        url.searchParams.delete('status');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    // ===== CRUD =====
    function openEditDialog(el) {
        const d = el.dataset;
        document.getElementById('edit-room_id').value     = d.room_id;
        document.getElementById('edit-task_type').value   = d.task_type;
        document.getElementById('edit-assigned_to').value = d.assigned_to || '';
        document.getElementById('edit-notes').value       = d.notes || '';
        document.getElementById('form-edit').action       = '<?= base_url('housekeeping/update') ?>/' + d.id;
        openDialog('dialog-edit');
    }

    function openDetailDialog(el) {
        const d = el.dataset;
        const row = el.closest('tr');
        const roomNumber = row.querySelector('td:nth-child(2) strong')?.textContent.trim() || '-';

        const statusLabels = {
            'pending':     'Pending',
            'in_progress': 'In Progress',
            'done':        'Done',
            'verified':    'Verified',
        };

        document.getElementById('detail-room').textContent    = roomNumber;
        document.getElementById('detail-type').textContent    = d.task_type.replace(/_/g, ' ');
        document.getElementById('detail-status').innerHTML    = '<span style="padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; background: var(--primary-soft); color: var(--primary);">' + (statusLabels[d.status] || d.status) + '</span>';
        document.getElementById('detail-status-select').value = d.status;

        document.getElementById('form-status').action = '<?= base_url('housekeeping/update-status') ?>/' + d.id;
        document.getElementById('form-photo').action  = '<?= base_url('housekeeping/upload-photo') ?>/' + d.id;

        openDialog('dialog-detail');
    }

    function openPhotoDialog(url) {
        document.getElementById('photo-preview').src = url;
        openDialog('dialog-photo');
    }

    function openDeleteDialog(el) {
        const d = el.dataset;
        document.getElementById('delete-room').textContent = d.room;
        document.getElementById('form-delete').action      = '<?= base_url('housekeeping/delete') ?>/' + d.id;
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
</script>
<?= $this->endSection() ?>