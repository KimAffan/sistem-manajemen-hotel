<mdui-top-app-bar>
    <mdui-button-icon onclick="toggleSidebar()">
        <mdui-icon name="menu"></mdui-icon>
    </mdui-button-icon>
    <mdui-top-app-bar-title><?= $title ?? 'Sistem Hotel' ?></mdui-top-app-bar-title>
    <div style="flex-grow: 1"></div>

    <?php if (auth()->loggedIn()): ?>
        <mdui-button-icon>
            <mdui-icon name="notifications"></mdui-icon>
        </mdui-button-icon>

        <mdui-dropdown>
            <mdui-button-icon slot="trigger">
                <div class="header-avatar">
                    <?= strtoupper(substr(auth()->user()->username, 0, 1)) ?>
                </div>
            </mdui-button-icon>
            <mdui-menu>
                <mdui-menu-item disabled>
                    <div style="padding: 4px 0;">
                        <div style="font-weight: 600;"><?= esc(auth()->user()->username) ?></div>
                        <div style="font-size: 11px; color: #9CA3AF;">
                            <?= implode(', ', auth()->user()->getGroups()) ?>
                        </div>
                    </div>
                </mdui-menu-item>
                <mdui-divider></mdui-divider>
                <mdui-menu-item href="<?= base_url('settings') ?>">
                    <mdui-icon slot="icon" name="settings"></mdui-icon>
                    Pengaturan
                </mdui-menu-item>
                <mdui-menu-item onclick="confirmLogout()">
                    <mdui-icon slot="icon" name="logout"></mdui-icon>
                    Logout
                </mdui-menu-item>
            </mdui-menu>
        </mdui-dropdown>
    <?php else: ?>
        <mdui-button href="<?= url_to('login') ?>" variant="text">Login</mdui-button>
    <?php endif; ?>
</mdui-top-app-bar>

<style>
    .header-avatar {
        width: 32px; height: 32px; border-radius: 50%;
        background: linear-gradient(135deg, #6C5CE7 0%, #A29BFE 100%);
        color: white; font-weight: 600; font-size: 13px;
        display: flex; align-items: center; justify-content: center;
    }
</style>

<!-- Dialog Konfirmasi Logout -->
<mdui-dialog id="dialog-logout">
    <span slot="headline">Konfirmasi Logout</span>
    <p>Yakin ingin keluar dari Sistem Hotel?</p>
    <p style="color: #666; font-size: 13px;">Kamu harus login lagi untuk mengakses sistem.</p>
    <mdui-button slot="action" variant="text" onclick="closeLogoutDialog()">Batal</mdui-button>
    <mdui-button slot="action" variant="filled" style="background: #EF4444;" onclick="doLogout()">Ya, Logout</mdui-button>
</mdui-dialog>

<script>
    function confirmLogout() { document.getElementById('dialog-logout').open = true; }
    function closeLogoutDialog() { document.getElementById('dialog-logout').open = false; }
    function doLogout() { window.location.href = '<?= url_to('logout') ?>'; }
</script>