<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Pengaturan Sistem</h1>
            <p class="page-sub">Konfigurasi identitas, pajak, dan manajemen user</p>
        </div>
    </div>

    <!-- TAB NAVIGASI -->
    <div class="tab-nav">
        <button type="button" class="tab-btn active" data-tab="tab-hotel" onclick="switchTab('tab-hotel')">
            <mdui-icon name="business"></mdui-icon>
            <span>Identitas Hotel</span>
        </button>
        <button type="button" class="tab-btn" data-tab="tab-tax" onclick="switchTab('tab-tax')">
            <mdui-icon name="percent"></mdui-icon>
            <span>Pajak & Service</span>
        </button>
        <button type="button" class="tab-btn" data-tab="tab-users" onclick="switchTab('tab-users')">
            <mdui-icon name="people"></mdui-icon>
            <span>Manajemen User</span>
        </button>
    </div>

    <!-- PANEL: IDENTITAS HOTEL -->
    <div id="panel-tab-hotel" class="tab-panel" style="display: block;">
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-icon"><mdui-icon name="business"></mdui-icon></div>
                <div>
                    <div class="form-card-title">Identitas Hotel</div>
                    <div class="form-card-sub">Informasi ini akan muncul di invoice dan laporan</div>
                </div>
            </div>

            <form action="<?= base_url('settings/save-hotel') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-grid">
                    <mdui-text-field label="Nama Hotel" name="hotel_name" variant="outlined" value="<?= esc($settings['hotel_name'] ?? '') ?>" required style="grid-column: 1 / -1;"></mdui-text-field>

                    <mdui-text-field label="Alamat" name="hotel_address" variant="outlined" value="<?= esc($settings['hotel_address'] ?? '') ?>" rows="2" style="grid-column: 1 / -1;"></mdui-text-field>

                    <mdui-text-field label="Telepon" name="hotel_phone" variant="outlined" value="<?= esc($settings['hotel_phone'] ?? '') ?>"></mdui-text-field>
                    <mdui-text-field label="Email" name="hotel_email" type="email" variant="outlined" value="<?= esc($settings['hotel_email'] ?? '') ?>"></mdui-text-field>
                </div>

                <?php if (! empty($settings['hotel_logo'])): ?>
                    <div class="logo-preview">
                        <div class="logo-label">Logo Saat Ini</div>
                        <img src="<?= base_url('uploads/logo/' . $settings['hotel_logo']) ?>" alt="Logo Hotel">
                    </div>
                <?php endif; ?>

                <div class="upload-area">
                    <div class="upload-label">
                        <mdui-icon name="cloud_upload"></mdui-icon>
                        Upload Logo Baru
                    </div>
                    <div class="upload-hint">Format JPG, PNG, atau SVG. Maksimal 1MB.</div>
                    <input type="file" name="hotel_logo" accept="image/*" class="file-input">
                </div>

                <div class="form-actions">
                    <mdui-button type="submit" variant="filled" class="btn-primary">
                        <mdui-icon slot="icon" name="save"></mdui-icon>
                        Simpan Identitas
                    </mdui-button>
                </div>
            </form>
        </div>
    </div>

    <!-- PANEL: PAJAK & SERVICE -->
    <div id="panel-tab-tax" class="tab-panel" style="display: none;">
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-icon" style="background: #FEF3C7; color: #F59E0B;"><mdui-icon name="percent"></mdui-icon></div>
                <div>
                    <div class="form-card-title">Pajak & Service Charge</div>
                    <div class="form-card-sub">Nilai ini akan dipakai saat generate Invoice PDF</div>
                </div>
            </div>

            <form action="<?= base_url('settings/save-tax') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-grid-2">
                    <mdui-text-field label="Pajak (%)" name="tax_percentage" type="number" step="0.01" min="0" max="100" variant="outlined" value="<?= esc($settings['tax_percentage'] ?? '10') ?>" required></mdui-text-field>
                    <mdui-text-field label="Service Charge (%)" name="service_percentage" type="number" step="0.01" min="0" max="100" variant="outlined" value="<?= esc($settings['service_percentage'] ?? '5') ?>" required></mdui-text-field>
                </div>

                <mdui-select name="currency" label="Mata Uang" variant="outlined" style="width: 100%; margin-top: 16px;">
                    <mdui-menu-item value="IDR" <?= ($settings['currency'] ?? '') === 'IDR' ? 'selected' : '' ?>>IDR — Rupiah</mdui-menu-item>
                    <mdui-menu-item value="USD" <?= ($settings['currency'] ?? '') === 'USD' ? 'selected' : '' ?>>USD — US Dollar</mdui-menu-item>
                    <mdui-menu-item value="MYR" <?= ($settings['currency'] ?? '') === 'MYR' ? 'selected' : '' ?>>MYR — Ringgit Malaysia</mdui-menu-item>
                </mdui-select>

                <div class="form-actions">
                    <mdui-button type="submit" variant="filled" class="btn-primary">
                        <mdui-icon slot="icon" name="save"></mdui-icon>
                        Simpan Konfigurasi
                    </mdui-button>
                </div>
            </form>
        </div>
    </div>

    <!-- PANEL: MANAJEMEN USER -->
    <div id="panel-tab-users" class="tab-panel" style="display: none;">
        <div class="modern-card">
            <div class="table-header">
                <div>
                    <div class="table-title">Daftar User</div>
                    <div class="table-sub"><?= count($users) ?> user terdaftar dalam sistem</div>
                </div>
                <mdui-button onclick="openDialog('dialog-user-create')" variant="filled" class="btn-primary">
                    <mdui-icon slot="icon" name="person_add"></mdui-icon>
                    Tambah User
                </mdui-button>
            </div>

            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="width: 140px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <mdui-icon name="people" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
                                    <p>Belum ada user</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $i => $u): ?>
                            <tr>
                                <td><span class="row-index"><?= $i + 1 ?></span></td>
                                <td>
                                    <div class="cell-primary">
                                        <div class="user-avatar"><?= strtoupper(substr($u['username'], 0, 1)) ?></div>
                                        <div>
                                            <div class="cell-title"><?= esc($u['username']) ?></div>
                                            <div class="cell-sub">ID: #<?= str_pad($u['id'], 4, '0', STR_PAD_LEFT) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= esc($u['email'] ?? '-') ?></td>
                                <td>
                                    <div class="role-chips">
                                        <?php foreach (explode(', ', $u['role_names'] ?? '') as $role): ?>
                                            <span class="role-chip"><?= esc($role) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($u['active']): ?>
                                        <span class="status-badge status-active">
                                            <span class="dot"></span> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge status-inactive">
                                            <span class="dot"></span> Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: right;">
                                    <div class="action-group">
                                        <mdui-button-icon
                                            data-id="<?= $u['id'] ?>"
                                            data-username="<?= esc($u['username']) ?>"
                                            data-email="<?= esc($u['email'] ?? '') ?>"
                                            data-role="<?= esc(explode(', ', $u['role_names'] ?? '')[0] ?? '') ?>"
                                            onclick="openEditUserDialog(this)"
                                            title="Edit">
                                            <mdui-icon name="edit"></mdui-icon>
                                        </mdui-button-icon>

                                        <mdui-button-icon
                                            data-id="<?= $u['id'] ?>"
                                            data-username="<?= esc($u['username']) ?>"
                                            onclick="openResetPasswordDialog(this)"
                                            title="Reset Password"
                                            style="color: #F59E0B;">
                                            <mdui-icon name="lock_reset"></mdui-icon>
                                        </mdui-button-icon>

                                        <?php if ((int) $u['id'] !== auth()->id()): ?>
                                            <mdui-button-icon
                                                data-id="<?= $u['id'] ?>"
                                                data-username="<?= esc($u['username']) ?>"
                                                onclick="openDeleteUserDialog(this)"
                                                title="Hapus"
                                                style="color: #EF4444;">
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
    </div>
</div>

<!-- ================== DIALOG: TAMBAH USER ================== -->
<mdui-dialog id="dialog-user-create" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Tambah User</span>
    <form id="form-user-create" action="<?= base_url('settings/user/store') ?>" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Username" name="username" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Email" name="email" type="email" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Password (min 8 karakter)" name="password" type="password" toggle-password variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-select name="role" label="Role" variant="outlined" required style="width: 100%;">
            <?php foreach ($groups as $g): ?>
                <mdui-menu-item value="<?= $g ?>"><?= ucfirst(str_replace('_', ' ', $g)) ?></mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-user-create')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-user-create').submit()">Simpan</mdui-button>
</mdui-dialog>

<!-- ================== DIALOG: EDIT USER ================== -->
<mdui-dialog id="dialog-user-edit" style="--mdui-dialog-width: 500px;">
    <span slot="headline">Edit User</span>
    <form id="form-user-edit" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Username" name="username" id="edit-user-username" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-text-field label="Email" name="email" id="edit-user-email" type="email" variant="outlined" required style="width: 100%; margin-bottom: 12px;"></mdui-text-field>
        <mdui-select name="role" id="edit-user-role" label="Role" variant="outlined" required style="width: 100%;">
            <?php foreach ($groups as $g): ?>
                <mdui-menu-item value="<?= $g ?>"><?= ucfirst(str_replace('_', ' ', $g)) ?></mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-user-edit')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-user-edit').submit()">Update</mdui-button>
</mdui-dialog>

<!-- ================== DIALOG: RESET PASSWORD ================== -->
<mdui-dialog id="dialog-reset-password" style="--mdui-dialog-width: 480px;">
    <div style="text-align: center; padding: 8px 0;">
        <mdui-icon name="lock_reset" style="font-size: 56px; color: #F59E0B;"></mdui-icon>
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Reset Password</h3>
        <p style="color: var(--text-muted); margin: 0;">Reset password untuk user <strong id="reset-username" style="color: var(--text-primary);"></strong></p>
    </div>
    <form id="form-reset-password" method="post">
        <?= csrf_field() ?>
        <mdui-text-field label="Password Baru (min 8 karakter)" name="new_password" type="password" toggle-password variant="outlined" required style="width: 100%; margin-top: 8px;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-reset-password')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" style="background: #F59E0B;" onclick="document.getElementById('form-reset-password').submit()">Reset Password</mdui-button>
</mdui-dialog>

<!-- ================== DIALOG: HAPUS USER ================== -->
<mdui-dialog id="dialog-delete-user" style="--mdui-dialog-width: 400px;">
    <div style="text-align: center; padding: 8px;">
        <mdui-icon name="delete_forever" style="font-size: 56px; color: #EF4444;"></mdui-icon>
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Hapus User?</h3>
        <p style="color: #666; margin: 0;">Yakin ingin menghapus user <strong id="delete-username"></strong>?</p>
        <p style="color: #EF4444; font-size: 12px; margin-top: 8px;">Tindakan ini tidak dapat dibatalkan.</p>
    </div>
    <form id="form-delete-user" method="post"><?= csrf_field() ?></form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-delete-user')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" style="background: #EF4444;" onclick="document.getElementById('form-delete-user').submit()">Hapus</mdui-button>
</mdui-dialog>

<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .page-title { font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px 0; }
    .page-sub { color: var(--text-muted); font-size: 13px; margin: 0; }

    /* TAB NAV */
    .tab-nav {
        display: flex;
        gap: 4px;
        border-bottom: 2px solid var(--border);
        margin-bottom: 24px;
        overflow-x: auto;
    }
    .tab-btn {
        padding: 12px 20px;
        border: none;
        background: transparent;
        color: var(--text-secondary);
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        transition: all 0.2s;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    .tab-btn mdui-icon { font-size: 20px; }
    .tab-btn:hover {
        color: var(--primary);
        background: var(--primary-soft);
        border-radius: 8px 8px 0 0;
    }
    .tab-btn.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
        font-weight: 600;
    }

    /* FORM CARD */
    .form-card {
        background: #fff;
        border-radius: 14px;
        padding: 28px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        max-width: 720px;
    }
    .form-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border);
    }
    .form-icon {
        width: 48px; height: 48px; border-radius: 12px;
        background: #EEF0FF; color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .form-icon mdui-icon { font-size: 24px; }
    .form-card-title { font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 2px; }
    .form-card-sub { font-size: 12px; color: var(--text-muted); }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

    .logo-preview { margin-top: 20px; padding: 16px; background: #F9FAFB; border-radius: 10px; }
    .logo-label { font-size: 12px; font-weight: 600; color: var(--text-muted); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
    .logo-preview img { max-height: 80px; border-radius: 8px; }

    .upload-area { margin-top: 20px; padding: 20px; border: 2px dashed var(--border); border-radius: 12px; text-align: center; transition: all 0.15s; }
    .upload-area:hover { border-color: var(--primary); background: var(--primary-soft); }
    .upload-label { display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px; }
    .upload-label mdui-icon { color: var(--primary); }
    .upload-hint { font-size: 12px; color: var(--text-muted); margin-bottom: 12px; }
    .file-input { width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 8px; background: white; font-size: 13px; }

    .form-actions { margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border); }

    /* MODERN CARD */
    .modern-card {
        background: #fff; border-radius: 14px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm); overflow: hidden;
    }
    .table-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 20px 24px; border-bottom: 1px solid var(--border);
        flex-wrap: wrap; gap: 12px;
    }
    .table-title { font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px 0; }
    .table-sub { font-size: 12px; color: var(--text-muted); margin: 0; }

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
    .user-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white; font-weight: 700; font-size: 15px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .cell-title { font-weight: 600; color: var(--text-primary); font-size: 13px; }
    .cell-sub { color: var(--text-muted); font-size: 11px; margin-top: 2px; }

    .role-chips { display: flex; flex-wrap: wrap; gap: 4px; }
    .role-chip {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        background: var(--primary-soft);
        color: var(--primary);
    }

    .status-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 10px; border-radius: 8px;
        font-size: 12px; font-weight: 600;
    }
    .status-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .status-active { background: #ECFDF5; color: #10B981; }
    .status-inactive { background: #FEF2F2; color: #EF4444; }

    .action-group { display: inline-flex; gap: 2px; }

    .empty-state { padding: 48px 20px; text-align: center; }
    .empty-state p { font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 12px 0 4px 0; }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('panel-' + tabId).style.display = 'block';
        document.querySelector(`.tab-btn[data-tab="${tabId}"]`).classList.add('active');
    }

    function openDialog(id)  { document.getElementById(id).open = true; }
    function closeDialog(id) { document.getElementById(id).open = false; }

    function openEditUserDialog(el) {
        const d = el.dataset;
        document.getElementById('edit-user-username').value = d.username;
        document.getElementById('edit-user-email').value    = d.email;
        document.getElementById('edit-user-role').value     = d.role;
        document.getElementById('form-user-edit').action    = '<?= base_url('settings/user/update') ?>/' + d.id;
        openDialog('dialog-user-edit');
    }

    function openResetPasswordDialog(el) {
        const d = el.dataset;
        document.getElementById('reset-username').textContent = d.username;
        document.getElementById('form-reset-password').action = '<?= base_url('settings/user/reset-password') ?>/' + d.id;
        openDialog('dialog-reset-password');
    }

    function openDeleteUserDialog(el) {
        const d = el.dataset;
        document.getElementById('delete-username').textContent = d.username;
        document.getElementById('form-delete-user').action     = '<?= base_url('settings/user/delete') ?>/' + d.id;
        openDialog('dialog-delete-user');
    }

    <?php if (session()->getFlashdata('success')): ?>
        showAlert(<?= json_encode(session()->getFlashdata('success')) ?>, 'success', 2000);
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        showAlert(<?= json_encode(session()->getFlashdata('error')) ?>, 'error');
    <?php endif; ?>
</script>
<?= $this->endSection() ?>