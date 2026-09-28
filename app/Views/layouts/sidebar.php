<?php
$currentPath = trim(parse_url(current_url(), PHP_URL_PATH), '/');
$isActive = function ($segment) use ($currentPath) {
    $segment = trim($segment, '/');
    return $currentPath === $segment || strpos($currentPath, $segment . '/') === 0;
};

// Cek role user
$user    = auth()->user();
$isAdmin = $user->inGroup('admin') || $user->inGroup('superadmin');
$isMgr   = $user->inGroup('manager');
$isFO    = $user->inGroup('front_office');
$isHK    = $user->inGroup('housekeeping');
$isPur   = $user->inGroup('purchasing');
?>

<aside id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <a href="<?= base_url('dashboard') ?>" class="brand">
            <div class="brand-icon">
                <mdui-icon name="apartment"></mdui-icon>
            </div>
            <div>
                <div class="brand-name"><?= esc(app_setting('hotel_name', 'Sistem Hotel')) ?></div>
                <div class="brand-sub">Management System</div>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">Menu Utama</div>
            <a href="<?= base_url('dashboard') ?>" class="nav-item <?= $isActive('dashboard') ? 'active' : '' ?>">
                <mdui-icon name="dashboard"></mdui-icon>
                <span>Dashboard</span>
            </a>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">Operasional</div>

            <?php if ($isAdmin || $isMgr || $isFO || $isHK): ?>
                <a href="<?= base_url('rooms') ?>" class="nav-item <?= $isActive('rooms') && ! $isActive('room-map') && ! $isActive('room-types') ? 'active' : '' ?>">
                    <mdui-icon name="bed"></mdui-icon>
                    <span>Kamar</span>
                </a>
            <?php endif; ?>

            <?php if ($isAdmin || $isMgr): ?>
                <a href="<?= base_url('room-types') ?>" class="nav-item <?= $isActive('room-types') ? 'active' : '' ?>">
                    <mdui-icon name="meeting_room"></mdui-icon>
                    <span>Tipe Kamar</span>
                </a>
            <?php endif; ?>

            <a href="<?= base_url('room-map') ?>" class="nav-item <?= $isActive('room-map') ? 'active' : '' ?>">
                <mdui-icon name="grid_view"></mdui-icon>
                <span>Denah Kamar</span>
            </a>

            <?php if ($isAdmin || $isMgr || $isFO): ?>
                <a href="<?= base_url('guests') ?>" class="nav-item <?= $isActive('guests') ? 'active' : '' ?>">
                    <mdui-icon name="people"></mdui-icon>
                    <span>Tamu</span>
                </a>
                <a href="<?= base_url('reservations') ?>" class="nav-item <?= $isActive('reservations') ? 'active' : '' ?>">
                    <mdui-icon name="book_online"></mdui-icon>
                    <span>Reservasi</span>
                </a>
            <?php endif; ?>

            <?php if ($isAdmin || $isMgr || $isHK): ?>
                <a href="<?= base_url('housekeeping') ?>" class="nav-item <?= $isActive('housekeeping') ? 'active' : '' ?>">
                    <mdui-icon name="cleaning_services"></mdui-icon>
                    <span>Housekeeping</span>
                </a>
            <?php endif; ?>
        </div>

        <?php if ($isAdmin || $isMgr || $isPur): ?>
            <div class="nav-section">
                <div class="nav-section-title">Inventori</div>
                <a href="<?= base_url('items') ?>" class="nav-item <?= $isActive('items') ? 'active' : '' ?>">
                    <mdui-icon name="inventory_2"></mdui-icon>
                    <span>Barang</span>
                </a>
                <a href="<?= base_url('suppliers') ?>" class="nav-item <?= $isActive('suppliers') ? 'active' : '' ?>">
                    <mdui-icon name="local_shipping"></mdui-icon>
                    <span>Supplier</span>
                </a>
                <a href="<?= base_url('purchasing') ?>" class="nav-item <?= $isActive('purchasing') ? 'active' : '' ?>">
                    <mdui-icon name="shopping_cart"></mdui-icon>
                    <span>Purchasing</span>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($isAdmin || $isMgr): ?>
            <div class="nav-section">
                <div class="nav-section-title">Lainnya</div>
                <a href="<?= base_url('reports') ?>" class="nav-item <?= $isActive('reports') ? 'active' : '' ?>">
                    <mdui-icon name="bar_chart"></mdui-icon>
                    <span>Laporan</span>
                </a>
                <?php if ($isAdmin): ?>
                    <a href="<?= base_url('settings') ?>" class="nav-item <?= $isActive('settings') ? 'active' : '' ?>">
                        <mdui-icon name="settings"></mdui-icon>
                        <span>Pengaturan</span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </nav>

    <?php if (auth()->loggedIn()): ?>
        <div class="sidebar-footer">
            <div class="user-mini">
                <div class="user-avatar-mini">
                    <?= strtoupper(substr(auth()->user()->username, 0, 1)) ?>
                </div>
                <div class="user-mini-info">
                    <div class="user-mini-name"><?= esc(auth()->user()->username) ?></div>
                    <div class="user-mini-role"><?= implode(', ', auth()->user()->getGroups()) ?></div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</aside>