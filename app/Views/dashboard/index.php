<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
// Greeting berdasarkan jam
$hour = (int) date('H');
if ($hour < 12)      $greeting = 'Selamat Pagi';
elseif ($hour < 15)  $greeting = 'Selamat Siang';
elseif ($hour < 18)  $greeting = 'Selamat Sore';
else                 $greeting = 'Selamat Malam';

$roomStatus = $roomStatus ?? ['vacant_clean' => 0, 'occupied' => 0, 'vacant_dirty' => 0, 'out_of_order' => 0];
$totalStatus = array_sum($roomStatus) ?: 1;
?>

<div class="animate__animated animate__fadeIn">

    <!-- ===== WELCOME BANNER ===== -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <div class="welcome-date"><?= date('l, d F Y') ?></div>
            <h1 class="welcome-title"><?= $greeting ?>, <?= esc($user->username) ?>! 👋</h1>
            <p class="welcome-sub">Berikut ringkasan operasional hotel Anda hari ini.</p>
        </div>
        <div class="welcome-decor">
            <mdui-icon name="hotel" style="font-size: 140px; opacity: 0.12;"></mdui-icon>
        </div>
    </div>

    <!-- ===== STAT CARDS ===== -->
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-icon"><mdui-icon name="bed"></mdui-icon></div>
            <div class="stat-info">
                <div class="stat-label">Total Kamar</div>
                <div class="stat-value"><?= $totalRooms ?></div>
                <div class="stat-desc">Kamar terdaftar</div>
            </div>
        </div>

        <div class="stat-card stat-danger">
            <div class="stat-icon"><mdui-icon name="person"></mdui-icon></div>
            <div class="stat-info">
                <div class="stat-label">Kamar Terisi</div>
                <div class="stat-value"><?= $occupiedRooms ?></div>
                <div class="stat-desc">Sedang dihuni tamu</div>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon"><mdui-icon name="trending_up"></mdui-icon></div>
            <div class="stat-info">
                <div class="stat-label">Tingkat Okupansi</div>
                <div class="stat-value"><?= $occupancyRate ?>%</div>
                <div class="stat-desc">Dari total kamar</div>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon"><mdui-icon name="payments"></mdui-icon></div>
            <div class="stat-info">
                <div class="stat-label">Pendapatan Hari Ini</div>
                <div class="stat-value" style="font-size: 20px;">
                    Rp <?= number_format($todayRevenue, 0, ',', '.') ?>
                </div>
                <div class="stat-desc">Dari check-in hari ini</div>
            </div>
        </div>
    </div>

    <!-- ===== CONTENT GRID ===== -->
    <div class="content-grid">
        <!-- Status Kamar -->
        <div class="card-modern">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Status Kamar</h3>
                    <p class="card-sub">Ringkasan kondisi kamar saat ini</p>
                </div>
                <a href="<?= base_url('room-map') ?>" class="card-link">Lihat Denah →</a>
            </div>

            <div class="status-list">
                <?php
                $statusItems = [
                    ['vacant_clean', 'Vacant Clean', 'check_circle',     '#10B981', '#ECFDF5'],
                    ['occupied',     'Occupied',     'person',           '#EF4444', '#FEF2F2'],
                    ['vacant_dirty', 'Vacant Dirty', 'cleaning_services','#F59E0B', '#FFFBEB'],
                    ['out_of_order', 'Out of Order', 'warning',          '#E65100', '#FFF7ED'],
                ];
                foreach ($statusItems as [$key, $label, $icon, $color, $soft]):
                    $count = $roomStatus[$key] ?? 0;
                    $pct = $totalStatus > 0 ? round(($count / $totalStatus) * 100) : 0;
                ?>
                    <div class="status-item">
                        <div class="status-icon" style="background: <?= $soft ?>; color: <?= $color ?>;">
                            <mdui-icon name="<?= $icon ?>"></mdui-icon>
                        </div>
                        <div class="status-info">
                            <div class="status-header">
                                <span class="status-label"><?= $label ?></span>
                                <span class="status-count" style="color: <?= $color ?>;">
                                    <?= $count ?>
                                    <span style="color: #9CA3AF; font-weight: 400;">(<?= $pct ?>%)</span>
                                </span>
                            </div>
                            <div class="status-bar">
                                <div class="status-bar-fill" style="width: <?= $pct ?>%; background: <?= $color ?>;"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card-modern">
            <div class="card-header">
                <div>
                    <h3 class="card-title">Aksi Cepat</h3>
                    <p class="card-sub">Pintasan ke fitur umum</p>
                </div>
            </div>

            <div class="quick-actions">
                <a href="<?= base_url('reservations') ?>" class="quick-btn">
                    <div class="quick-icon" style="background: #EEF0FF; color: #6C5CE7;">
                        <mdui-icon name="add_circle"></mdui-icon>
                    </div>
                    <div>
                        <div class="quick-title">Reservasi Baru</div>
                        <div class="quick-sub">Buat booking tamu</div>
                    </div>
                </a>

                <a href="<?= base_url('guests') ?>" class="quick-btn">
                    <div class="quick-icon" style="background: #DBEAFE; color: #3B82F6;">
                        <mdui-icon name="person_add"></mdui-icon>
                    </div>
                    <div>
                        <div class="quick-title">Daftarkan Tamu</div>
                        <div class="quick-sub">Tambah data tamu</div>
                    </div>
                </a>

                <a href="<?= base_url('housekeeping') ?>" class="quick-btn">
                    <div class="quick-icon" style="background: #ECFDF5; color: #10B981;">
                        <mdui-icon name="cleaning_services"></mdui-icon>
                    </div>
                    <div>
                        <div class="quick-title">Tugas Housekeeping</div>
                        <div class="quick-sub">Kelola kebersihan kamar</div>
                    </div>
                </a>

                <a href="<?= base_url('reports') ?>" class="quick-btn">
                    <div class="quick-icon" style="background: #FEF3C7; color: #F59E0B;">
                        <mdui-icon name="bar_chart"></mdui-icon>
                    </div>
                    <div>
                        <div class="quick-title">Lihat Laporan</div>
                        <div class="quick-sub">Analitik & statistik</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== WELCOME BANNER ===== */
    .welcome-banner {
        background: linear-gradient(135deg, #6C5CE7 0%, #A29BFE 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(108, 92, 231, 0.2);
        margin-bottom: 24px;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%; right: -10%;
        width: 320px; height: 320px;
        background: radial-gradient(circle, rgba(255,255,255,0.18) 0%, transparent 70%);
        border-radius: 50%;
    }
    .welcome-content { position: relative; z-index: 2; }
    .welcome-date {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.85;
        margin-bottom: 6px;
    }
    .welcome-title {
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 6px 0;
    }
    .welcome-sub { margin: 0; opacity: 0.9; font-size: 14px; }
    .welcome-decor {
        position: absolute;
        right: 20px; top: 50%;
        transform: translateY(-50%);
        z-index: 1;
    }

    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon mdui-icon { font-size: 26px; }
    .stat-info { flex: 1; min-width: 0; }
    .stat-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        font-weight: 600;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 26px;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.1;
    }
    .stat-desc {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 4px;
    }
    .stat-primary .stat-icon { background: #EEF0FF; color: #6C5CE7; }
    .stat-danger  .stat-icon { background: #FEF2F2; color: #EF4444; }
    .stat-success .stat-icon { background: #ECFDF5; color: #10B981; }
    .stat-warning .stat-icon { background: #FEF3C7; color: #F59E0B; }

    /* ===== CONTENT GRID ===== */
    .content-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 16px;
    }
    @media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }

    .card-modern {
        background: #fff;
        border-radius: 14px;
        padding: 20px 22px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    .card-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 4px 0;
    }
    .card-sub {
        font-size: 12px;
        color: var(--text-muted);
        margin: 0;
    }
    .card-link {
        font-size: 12px;
        color: #6C5CE7;
        text-decoration: none;
        font-weight: 500;
        white-space: nowrap;
    }
    .card-link:hover { text-decoration: underline; }

    /* ===== STATUS LIST ===== */
    .status-list { display: flex; flex-direction: column; gap: 16px; }
    .status-item { display: flex; align-items: center; gap: 14px; }
    .status-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .status-icon mdui-icon { font-size: 20px; }
    .status-info { flex: 1; min-width: 0; }
    .status-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
        font-size: 13px;
    }
    .status-label { color: var(--text-secondary); font-weight: 500; }
    .status-count { font-weight: 700; }
    .status-bar {
        height: 6px;
        background: #F3F4F6;
        border-radius: 3px;
        overflow: hidden;
    }
    .status-bar-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.6s ease;
    }

    /* ===== QUICK ACTIONS ===== */
    .quick-actions { display: flex; flex-direction: column; gap: 8px; }
    .quick-btn {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 14px;
        border-radius: 12px;
        text-decoration: none;
        color: inherit;
        transition: all 0.15s ease;
        border: 1px solid transparent;
    }
    .quick-btn:hover {
        background: #F9FAFB;
        border-color: var(--border);
    }
    .quick-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .quick-icon mdui-icon { font-size: 20px; }
    .quick-title { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .quick-sub   { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
</style>

<?= $this->endSection() ?>