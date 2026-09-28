<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Hotel' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url('assets/mdui/mdui.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/animate.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/flatpickr/flatpickr.min.css') ?>">

    <style>
        // ==================
// PAGINATION HELPER
// ==================
function changePerPage(perPage) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', perPage);
    url.searchParams.set('page', 1); // reset ke halaman 1
    window.location.href = url.toString();
}

function updateQueryParam(key, value) {
    const url = new URL(window.location.href);
    if (value === '' || value === null || value === undefined) {
        url.searchParams.delete(key);
    } else {
        url.searchParams.set(key, value);
    }
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

function removeQueryParam(key) {
    const url = new URL(window.location.href);
    url.searchParams.delete(key);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
        /* ========== FIX ICON ========== */
mdui-icon {
    font-family: 'Material Symbols Outlined' !important;
    font-weight: normal;
    font-style: normal;
    font-size: 24px;
    line-height: 1;
    letter-spacing: normal;
    text-transform: none;
    display: inline-block;
    white-space: nowrap;
    word-wrap: normal;
    direction: ltr;
    -webkit-font-feature-settings: 'liga';
    -webkit-font-smoothing: antialiased;
}
        :root {
            --primary: #6C5CE7;
            --primary-light: #A29BFE;
            --primary-soft: #F0EFFF;
            --primary-dark: #5B4DD1;
            --success: #10B981;
            --success-soft: #ECFDF5;
            --warning: #F59E0B;
            --warning-soft: #FFFBEB;
            --danger: #EF4444;
            --danger-soft: #FEF2F2;
            --info: #3B82F6;
            --info-soft: #EFF6FF;
            --text-primary: #111827;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --bg-page: #F7F8FC;
            --bg-card: #FFFFFF;
            --border: #EAECF0;
            --shadow-sm: 0 1px 2px rgba(16, 24, 40, 0.04);
            --shadow-md: 0 4px 16px rgba(16, 24, 40, 0.06);
            --shadow-lg: 0 12px 32px rgba(108, 92, 231, 0.12);
        }

        *, *::before, *::after { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; }

        body {
            font-family: 'Inter', 'Roboto', sans-serif;
            background: var(--bg-page);
            color: var(--text-primary);
            font-size: 14px;
            line-height: 1.5;
        }

        /* ====== TOP APP BAR ====== */
      mdui-top-app-bar {
    position: fixed !important;
    top: 0; left: 0; right: 0;
    z-index: 200;
    background: #ffffff !important;
    box-shadow: 0 1px 3px rgba(16, 24, 40, 0.04);
    border-bottom: 1px solid var(--border);
}

/* Override variabel internal MDUI supaya background solid */
mdui-top-app-bar::part(container),
mdui-top-app-bar::part(inner) {
    background: #ffffff !important;
}

        /* ====== SIDEBAR ====== */
        .sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            bottom: 0;
            width: 260px;
            background: #FFFFFF;
            border-right: 1px solid var(--border);
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 100;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 18px 20px 14px 20px;
            border-bottom: 1px solid var(--border);
        }

        .brand { display: flex; align-items: center; gap: 12px; text-decoration: none; color: inherit; }
        .brand-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex; align-items: center; justify-content: center;
            color: white;
            box-shadow: 0 4px 10px rgba(108, 92, 231, 0.25);
        }
        .brand-icon mdui-icon { font-size: 22px; }
        .brand-name { font-size: 15px; font-weight: 700; color: var(--text-primary); line-height: 1.2; }
        .brand-sub { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .nav-section { margin-bottom: 20px; }
        .nav-section-title {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            padding: 0 12px;
            margin-bottom: 6px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.15s ease;
            margin-bottom: 2px;
        }
        .nav-item mdui-icon { font-size: 20px; transition: color 0.15s ease; }
        .nav-item:hover { background: var(--primary-soft); color: var(--primary); }
        .nav-item.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.25);
            font-weight: 600;
        }
        .nav-item.active mdui-icon { color: white; }

        .sidebar-footer {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: #FAFBFC;
        }
        .user-mini { display: flex; align-items: center; gap: 12px; }
        .user-avatar-mini {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 14px;
        }
        .user-mini-info { flex: 1; min-width: 0; }
        .user-mini-name {
            font-size: 13px; font-weight: 600; color: var(--text-primary);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .user-mini-role {
            font-size: 11px; color: var(--text-muted);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        /* ====== MAIN CONTENT ====== */
        .main-content {
            margin-left: 260px;
            margin-top: 64px;
            padding: 24px 28px;
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - 64px);
        }

        body.sidebar-collapsed .sidebar { transform: translateX(-100%); }
        body.sidebar-collapsed .main-content { margin-left: 0; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 16px; }
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>
<body>

    <?= $this->include('layouts/sidebar') ?>
    <?= $this->include('layouts/header') ?>

    <main class="main-content">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- GLOBAL ALERT MODAL -->
    <mdui-dialog id="dialog-alert" style="--mdui-dialog-width: 400px;">
        <div style="text-align: center; padding: 16px 8px;">
            <mdui-icon id="alert-icon" name="check_circle" style="font-size: 64px; color: #10B981;"></mdui-icon>
            <h3 id="alert-title" style="margin: 16px 0 8px 0;">Berhasil</h3>
            <p id="alert-message" style="margin: 0; color: #666;"></p>
        </div>
        <mdui-button slot="action" variant="filled" id="alert-ok-btn" onclick="closeAlert()" style="width: 100%;">OK</mdui-button>
    </mdui-dialog>

    <script src="<?= base_url('assets/mdui/mdui.global.js') ?>"></script>
    <script src="<?= base_url('assets/js/chart.umd.js') ?>"></script>
    <script src="<?= base_url('assets/flatpickr/flatpickr.min.js') ?>"></script>

    <script>
        function toggleSidebar() {
            const isMobile = window.innerWidth <= 768;
            if (isMobile) {
                document.getElementById('sidebar').classList.toggle('open');
            } else {
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', document.body.classList.contains('sidebar-collapsed'));
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (window.innerWidth > 768) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) document.body.classList.add('sidebar-collapsed');
            }
        });

        const ALERT_STYLES = {
            success: { icon: 'check_circle', color: '#10B981', title: 'Berhasil', btnBg: '#10B981' },
            error:   { icon: 'error',        color: '#EF4444', title: 'Gagal',     btnBg: '#EF4444' },
            warning: { icon: 'warning',      color: '#F59E0B', title: 'Perhatian', btnBg: '#F59E0B' },
            info:    { icon: 'info',         color: '#3B82F6', title: 'Informasi', btnBg: '#3B82F6' },
        };

        function showAlert(message, type = 'success', autoCloseMs = 0) {
            const style = ALERT_STYLES[type] || ALERT_STYLES.info;
            document.getElementById('alert-icon').textContent    = style.icon;
            document.getElementById('alert-icon').style.color    = style.color;
            document.getElementById('alert-title').textContent   = style.title;
            document.getElementById('alert-title').style.color   = style.color;
            document.getElementById('alert-message').textContent = message;
            document.getElementById('alert-ok-btn').style.background = style.btnBg;
            document.getElementById('dialog-alert').open = true;
            if (autoCloseMs > 0) setTimeout(() => closeAlert(), autoCloseMs);
        }
        function closeAlert() {
            document.getElementById('dialog-alert').open = false;
        }
        function showSnackbar(message, isError = false) {
            showAlert(message, isError ? 'error' : 'success', isError ? 0 : 2000);
        }
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>