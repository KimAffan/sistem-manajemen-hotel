<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="animate__animated animate__fadeIn">
    <div class="page-header">
        <div>
            <h1 class="page-title">Reservasi</h1>
            <p class="page-sub">Kelola booking dan status tamu</p>
        </div>
        <div class="header-actions">
            <mdui-button-icon onclick="openSearchModal()" title="Cari Reservasi" class="icon-btn">
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
                Buat Reservasi
            </mdui-button>
        </div>
    </div>

    <!-- ACTIVE FILTERS -->
    <?php if (! empty($q) || $status !== 'all'): ?>
        <div class="active-filters">
            <span class="chip-label">Filter aktif:</span>

            <?php if ($status !== 'all'): 
                $statusLabels = [
                    'pending'     => 'Pending',
                    'confirmed'   => 'Confirmed',
                    'checked_in'  => 'Checked In',
                    'checked_out' => 'Checked Out',
                    'cancelled'   => 'Cancelled',
                ];
            ?>
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
                        <th>Kode</th>
                        <th>Tamu</th>
                        <th>Kamar</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th style="width: 150px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reservations)): ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <mdui-icon name="book_online" style="font-size: 48px; color: #CBD5E1;"></mdui-icon>
                                    <p>Belum ada reservasi</p>
                                    <span>
                                        <?php if (! empty($q) || $status !== 'all'): ?>
                                            Coba ubah kata kunci atau filter Anda
                                        <?php else: ?>
                                            Klik "Buat Reservasi" untuk memulai
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $startNo = ($pager->getCurrentPage() - 1) * $perPage;
                        foreach ($reservations as $i => $r): 
                        ?>
                            <tr>
                                <td><span class="row-index"><?= $startNo + $i + 1 ?></span></td>
                                <td><div class="cell-title" style="color: var(--primary);"><?= esc($r['reservation_code']) ?></div></td>
                                <td>
                                    <div class="cell-primary">
                                        <div class="guest-avatar" style="width: 32px; height: 32px; font-size: 13px;">
                                            <?= strtoupper(substr($r['guest_name'] ?? '?', 0, 1)) ?>
                                        </div>
                                        <div class="cell-title"><?= esc($r['guest_name'] ?? '-') ?></div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($r['room_number']): ?>
                                        <div class="cell-title"><?= esc($r['room_number']) ?></div>
                                        <div class="cell-sub">Lantai <?= esc($r['floor']) ?></div>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><div style="font-size: 13px;"><?= date('d M Y', strtotime($r['check_in_date'])) ?></div></td>
                                <td><div style="font-size: 13px;"><?= date('d M Y', strtotime($r['check_out_date'])) ?></div></td>
                                <td><div class="price-text">Rp <?= number_format($r['total_price'], 0, ',', '.') ?></div></td>
                                <td><?= reservation_badge($r['status']) ?></td>
                                <td style="text-align: right;">
                                    <div class="action-group">
                                        <mdui-button-icon
                                            onclick="window.open('<?= base_url('reservations/invoice/' . $r['id']) ?>', '_blank')"
                                            title="Cetak Invoice PDF"
                                            style="color: #3B82F6;">
                                            <mdui-icon name="picture_as_pdf"></mdui-icon>
                                        </mdui-button-icon>

                                        <mdui-button-icon
                                            data-id="<?= $r['id'] ?>"
                                            data-code="<?= esc($r['reservation_code']) ?>"
                                            data-status="<?= $r['status'] ?>"
                                            onclick="openStatusDialog(this)"
                                            title="Ubah Status">
                                            <mdui-icon name="swap_horiz"></mdui-icon>
                                        </mdui-button-icon>

                                        <?php if (in_array($r['status'], ['pending', 'confirmed'])): ?>
                                            <mdui-button-icon
                                                data-id="<?= $r['id'] ?>"
                                                data-guest_id="<?= $r['guest_id'] ?>"
                                                data-room_id="<?= $r['room_id'] ?>"
                                                data-check_in="<?= $r['check_in_date'] ?>"
                                                data-check_out="<?= $r['check_out_date'] ?>"
                                                data-notes="<?= esc($r['notes'] ?? '') ?>"
                                                onclick="openEditDialog(this)"
                                                title="Edit">
                                                <mdui-icon name="edit"></mdui-icon>
                                            </mdui-button-icon>
                                        <?php endif; ?>

                                        <?php if (in_array($r['status'], ['pending', 'cancelled'])): ?>
                                            <mdui-button-icon
                                                data-id="<?= $r['id'] ?>"
                                                data-code="<?= esc($r['reservation_code']) ?>"
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

        <!-- PAGINATION -->
       <?= view('components/pagination', [
    'pager'       => $pager,
    'perPage'     => $perPage,
    'baseUrl'     => base_url('reservations'),
    'queryParams' => ['q' => $q, 'status' => $status],
]) ?>
    </div>
</div>

<!-- ============ MODAL: SEARCH ============ -->
<mdui-dialog id="dialog-search" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Cari Reservasi</span>
    <div style="padding: 4px 0;">
        <mdui-text-field
            id="search-input"
            value="<?= esc($q) ?>"
            placeholder="Ketik kode atau nama tamu..."
            variant="outlined"
            clearable
            style="width: 100%;">
            <mdui-icon slot="icon" name="search"></mdui-icon>
        </mdui-text-field>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearSearch()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applySearch()">Terapkan</mdui-button>
</mdui-dialog>

<!-- ============ MODAL: FILTER ============ -->
<mdui-dialog id="dialog-filter" style="--mdui-dialog-width: 460px;">
    <span slot="headline">Filter Reservasi</span>
    <div style="padding: 4px 0;">
        <div class="filter-section-title">
            <mdui-icon name="bookmark"></mdui-icon>
            Status Reservasi
        </div>

        <div class="filter-options">
            <label class="filter-option">
                <input type="radio" name="filter_status" value="all" checked onchange="selectStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="done_all"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Semua Status</div>
                        <div class="filter-option-sub">Tampilkan semua reservasi</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="pending" onchange="selectStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="hourglass_empty" style="color: #F59E0B;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Pending</div>
                        <div class="filter-option-sub">Menunggu konfirmasi</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="confirmed" onchange="selectStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="check_circle" style="color: #3B82F6;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Confirmed</div>
                        <div class="filter-option-sub">Sudah dikonfirmasi</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="checked_in" onchange="selectStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="login" style="color: #10B981;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Checked In</div>
                        <div class="filter-option-sub">Tamu sedang menginap</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="checked_out" onchange="selectStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="logout" style="color: #757575;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Checked Out</div>
                        <div class="filter-option-sub">Tamu sudah check-out</div>
                    </div>
                </div>
            </label>

            <label class="filter-option">
                <input type="radio" name="filter_status" value="cancelled" onchange="selectStatus(this)">
                <div class="filter-option-content">
                    <mdui-icon name="cancel" style="color: #EF4444;"></mdui-icon>
                    <div>
                        <div class="filter-option-title">Cancelled</div>
                        <div class="filter-option-sub">Reservasi dibatalkan</div>
                    </div>
                </div>
            </label>
        </div>
    </div>
    <mdui-button slot="action" variant="text" onclick="clearStatusFilter()">Reset</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="applyFilter()">Terapkan</mdui-button>
</mdui-dialog>

<!-- ================== DIALOG: BUAT RESERVASI ================== -->
<mdui-dialog id="dialog-create" style="--mdui-dialog-width: 520px;">
    <span slot="headline">Buat Reservasi</span>
    <form id="form-create" action="<?= base_url('reservations/store') ?>" method="post">
        <?= csrf_field() ?>

        <mdui-select name="guest_id" label="Tamu" variant="outlined" required style="width: 100%;">
            <?php foreach ($guests as $g): ?>
                <mdui-menu-item value="<?= $g['id'] ?>"><?= esc($g['full_name']) ?> (<?= esc($g['phone'] ?: $g['email'] ?: '-') ?>)</mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>

        <mdui-select name="room_id" id="create-room" label="Kamar" variant="outlined" required style="width: 100%; margin-top: 12px;" onchange="onRoomChange('create')">
            <?php foreach ($rooms as $rm): ?>
                <mdui-menu-item value="<?= $rm['id'] ?>" data-price="<?= $rm['base_price'] ?>">
                    <?= esc($rm['room_number']) ?> — <?= esc($rm['type_name']) ?> (Rp <?= number_format($rm['base_price'], 0, ',', '.') ?>/malam)
                </mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>

        <div style="display: flex; gap: 12px; margin-top: 12px;">
            <mdui-text-field id="create-checkin" label="Check-in" name="check_in_date" variant="outlined" required style="flex: 1;" onchange="recalc('create')"></mdui-text-field>
            <mdui-text-field id="create-checkout" label="Check-out" name="check_out_date" variant="outlined" required style="flex: 1;" onchange="recalc('create')"></mdui-text-field>
        </div>

        <div id="create-summary" style="margin-top: 16px; padding: 14px; background: var(--primary-soft); border-radius: 10px; display: none;">
            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px;">
                <span style="color: var(--text-secondary);">Jumlah Malam:</span>
                <strong id="create-nights" style="color: var(--text-primary);">0</strong>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 14px;">
                <span style="color: var(--text-secondary);">Total:</span>
                <strong id="create-total" style="color: var(--primary);">Rp 0</strong>
            </div>
        </div>

        <input type="hidden" name="total_price" id="create-total-input">

        <mdui-text-field label="Catatan" name="notes" variant="outlined" rows="2" style="margin-top: 12px; width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-create')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-create').submit()">Simpan</mdui-button>
</mdui-dialog>

<!-- ================== DIALOG: EDIT ================== -->
<mdui-dialog id="dialog-edit" style="--mdui-dialog-width: 520px;">
    <span slot="headline">Edit Reservasi</span>
    <form id="form-edit" method="post">
        <?= csrf_field() ?>

        <mdui-select name="guest_id" id="edit-guest_id" label="Tamu" variant="outlined" required style="width: 100%;">
            <?php foreach ($guests as $g): ?>
                <mdui-menu-item value="<?= $g['id'] ?>"><?= esc($g['full_name']) ?></mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>

        <mdui-select name="room_id" id="edit-room_id" label="Kamar" variant="outlined" required style="width: 100%; margin-top: 12px;" onchange="onRoomChange('edit')">
            <?php foreach ($rooms as $rm): ?>
                <mdui-menu-item value="<?= $rm['id'] ?>" data-price="<?= $rm['base_price'] ?>">
                    <?= esc($rm['room_number']) ?> — <?= esc($rm['type_name']) ?>
                </mdui-menu-item>
            <?php endforeach; ?>
        </mdui-select>

        <div style="display: flex; gap: 12px; margin-top: 12px;">
            <mdui-text-field id="edit-checkin" label="Check-in" name="check_in_date" variant="outlined" required style="flex: 1;" onchange="recalc('edit')"></mdui-text-field>
            <mdui-text-field id="edit-checkout" label="Check-out" name="check_out_date" variant="outlined" required style="flex: 1;" onchange="recalc('edit')"></mdui-text-field>
        </div>

        <div id="edit-summary" style="margin-top: 16px; padding: 14px; background: var(--primary-soft); border-radius: 10px; display: none;">
            <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px;">
                <span style="color: var(--text-secondary);">Jumlah Malam:</span>
                <strong id="edit-nights" style="color: var(--text-primary);">0</strong>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 14px;">
                <span style="color: var(--text-secondary);">Total:</span>
                <strong id="edit-total" style="color: var(--primary);">Rp 0</strong>
            </div>
        </div>

        <mdui-text-field label="Catatan" name="notes" id="edit-notes" variant="outlined" rows="2" style="margin-top: 12px; width: 100%;"></mdui-text-field>
    </form>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-edit')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-edit').submit()">Update</mdui-button>
</mdui-dialog>

<!-- ================== DIALOG: UBAH STATUS ================== -->
<mdui-dialog id="dialog-status" style="--mdui-dialog-width: 440px;">
    <span slot="headline">Ubah Status Reservasi</span>
    <div style="padding: 4px 0;">
        <div class="status-info-box">
            <div class="status-info-label">Kode Reservasi</div>
            <div class="status-info-value" id="status-code"></div>
        </div>

        <form id="form-status" method="post">
            <?= csrf_field() ?>
            <mdui-select name="status" id="status-select" label="Status Baru" variant="outlined" required style="width: 100%; margin-top: 12px;">
                <mdui-menu-item value="pending">Pending</mdui-menu-item>
                <mdui-menu-item value="confirmed">Confirmed</mdui-menu-item>
                <mdui-menu-item value="checked_in">Checked In</mdui-menu-item>
                <mdui-menu-item value="checked_out">Checked Out</mdui-menu-item>
                <mdui-menu-item value="cancelled">Cancelled</mdui-menu-item>
            </mdui-select>
        </form>
    </div>
    <mdui-button slot="action" variant="text" onclick="closeDialog('dialog-status')">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" onclick="document.getElementById('form-status').submit()">Simpan</mdui-button>
</mdui-dialog>

<!-- ================== DIALOG: HAPUS ================== -->
<mdui-dialog id="dialog-delete" style="--mdui-dialog-width: 400px;">
    <div style="text-align: center; padding: 8px;">
        <mdui-icon name="delete_forever" style="font-size: 56px; color: #EF4444;"></mdui-icon>
        <h3 style="margin: 12px 0 6px 0; font-size: 18px;">Hapus Reservasi?</h3>
        <p style="color: #666; margin: 0;">Yakin ingin menghapus reservasi <strong id="delete-code"></strong>?</p>
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

    /* ACTIVE FILTERS */
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

    .price-text { font-weight: 700; color: var(--text-primary); font-size: 13px; }

    .action-group { display: inline-flex; gap: 2px; }

    .empty-state { padding: 48px 20px; text-align: center; }
    .empty-state p { font-size: 15px; font-weight: 600; color: var(--text-secondary); margin: 12px 0 4px 0; }
    .empty-state span { font-size: 13px; color: var(--text-muted); }

    /* FILTER MODAL */
    .filter-section-title {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; font-weight: 600; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .filter-section-title mdui-icon { font-size: 18px; }

    .filter-options {
        display: flex; flex-direction: column; gap: 8px;
        max-height: 380px; overflow-y: auto;
        padding-right: 6px;
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
        border-color: var(--primary);
        background: var(--primary-soft);
    }
    .filter-option input[type="radio"]:checked + .filter-option-content .filter-option-title {
        color: var(--primary);
    }

    /* STATUS INFO BOX */
    .status-info-box {
        padding: 12px 14px;
        background: var(--primary-soft);
        border-radius: 10px;
    }
    .status-info-label {
        font-size: 11px; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.5px;
        font-weight: 600; margin-bottom: 4px;
    }
    .status-info-value {
        font-size: 15px; font-weight: 700; color: var(--primary);
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    let createPicker, editPicker;
    const roomPrices = {};
    let activeStatus = 'all';
    let activeSearch = '';

    const STATUS_LABELS = {
        'pending':     'Pending',
        'confirmed':   'Confirmed',
        'checked_in':  'Checked In',
        'checked_out': 'Checked Out',
        'cancelled':   'Cancelled',
    };

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#create-room mdui-menu-item, #edit-room_id mdui-menu-item').forEach(el => {
            if (el.dataset.price) roomPrices[el.value] = parseFloat(el.dataset.price);
        });

        createPicker = flatpickr('#create-checkin', { dateFormat: 'Y-m-d', minDate: 'today' });
        flatpickr('#create-checkout', { dateFormat: 'Y-m-d', minDate: 'today', onChange: () => recalc('create') });
        editPicker = flatpickr('#edit-checkin', { dateFormat: 'Y-m-d' });
        flatpickr('#edit-checkout', { dateFormat: 'Y-m-d', onChange: () => recalc('edit') });
    });

    function onRoomChange(prefix) { recalc(prefix); }

    function getRoomPrice(prefix) {
        const selectEl = document.getElementById(prefix + '-room') || document.getElementById(prefix + '-room_id');
        if (! selectEl) return 0;
        return roomPrices[selectEl.value] || 0;
    }

    function recalc(prefix) {
        const checkIn  = document.getElementById(prefix + '-checkin').value;
        const checkOut = document.getElementById(prefix + '-checkout').value;
        const price    = getRoomPrice(prefix);

        if (! checkIn || ! checkOut || ! price) {
            document.getElementById(prefix + '-summary').style.display = 'none';
            return;
        }

        const nights = Math.round((new Date(checkOut) - new Date(checkIn)) / 86400000);
        if (nights <= 0) {
            document.getElementById(prefix + '-summary').style.display = 'none';
            return;
        }

        const total = nights * price;
        document.getElementById(prefix + '-summary').style.display = 'block';
        document.getElementById(prefix + '-nights').textContent = nights + ' malam';
        document.getElementById(prefix + '-total').textContent  = 'Rp ' + total.toLocaleString('id-ID');

        if (prefix === 'create') {
            document.getElementById('create-total-input').value = total;
        }
    }

    // ============ SEARCH ============
 unction openSearchModal() { openDialog('dialog-search'); }
function applySearch() {
    const q = (document.getElementById('search-input').value || '').trim();
    updateQueryParam('q', q);
}
function clearSearch() { removeQueryParam('q'); }

    // ============ FILTER ============
    function openFilterModal() {
    document.querySelectorAll('input[name="filter_status"]').forEach(r => {
        r.checked = (r.value === '<?= $status ?>');
    });
    openDialog('dialog-filter');
}
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

    // ============ UI ============
    function updateUI() {
        const badge = document.getElementById('filter-badge');
        const activeFilters = document.getElementById('active-filters');
        const chipStatus = document.getElementById('filter-chip-status');
        const chipSearch = document.getElementById('filter-chip-search');

        let filterCount = 0;

        if (activeStatus !== 'all') {
            filterCount++;
            chipStatus.style.display = 'inline-flex';
            document.getElementById('chip-status-value').textContent = STATUS_LABELS[activeStatus] || activeStatus;
        } else {
            chipStatus.style.display = 'none';
        }

        if (activeSearch) {
            chipSearch.style.display = 'inline-flex';
            document.getElementById('chip-search-value').textContent = activeSearch;
        } else {
            chipSearch.style.display = 'none';
        }

        if (filterCount > 0) {
            badge.style.display = 'flex';
            badge.textContent = filterCount;
        } else {
            badge.style.display = 'none';
        }

        const totalActive = filterCount + (activeSearch ? 1 : 0);
        activeFilters.style.display = totalActive > 0 ? 'flex' : 'none';
    }

    function filterTable() {
        let visibleCount = 0;
        document.querySelectorAll('.res-row').forEach(row => {
            const matchSearch = ! activeSearch || row.dataset.search.includes(activeSearch);
            const matchStatus = activeStatus === 'all' || row.dataset.status === activeStatus;
            const show = matchSearch && matchStatus;
            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        const noResult = document.getElementById('no-result');
        const totalRows = document.querySelectorAll('.res-row').length;
        noResult.style.display = (visibleCount === 0 && totalRows > 0) ? 'block' : 'none';
    }

    // ============ CRUD ============
    function openDialog(id)  { document.getElementById(id).open = true; }
    function closeDialog(id) { document.getElementById(id).open = false; }

    function openEditDialog(el) {
        const d = el.dataset;
        document.getElementById('edit-guest_id').value  = d.guest_id;
        document.getElementById('edit-room_id').value   = d.room_id;
        document.getElementById('edit-notes').value     = d.notes || '';
        document.getElementById('form-edit').action     = '<?= base_url('reservations/update') ?>/' + d.id;

        if (editPicker) editPicker.setDate(d.check_in);
        const co = document.getElementById('edit-checkout');
        co.value = d.check_out;
        if (co._flatpickr) co._flatpickr.setDate(d.check_out);

        recalc('edit');
        openDialog('dialog-edit');
    }

    function openStatusDialog(el) {
        const d = el.dataset;
        document.getElementById('status-code').textContent = d.code;
        document.getElementById('status-select').value     = d.status;
        document.getElementById('form-status').action      = '<?= base_url('reservations/update-status') ?>/' + d.id;
        openDialog('dialog-status');
    }

    function openDeleteDialog(el) {
        const d = el.dataset;
        document.getElementById('delete-code').textContent = d.code;
        document.getElementById('form-delete').action      = '<?= base_url('reservations/delete') ?>/' + d.id;
        openDialog('dialog-delete');
    }

    // Enter di search
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') applySearch();
            });
        }
    });

    // Flash
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