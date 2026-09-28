<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="display: flex; align-items: center; justify-content: center; min-height: 60vh; padding: 20px;">
    <div style="text-align: center; max-width: 460px;">
        <mdui-icon name="lock" style="font-size: 96px; color: #EF4444;"></mdui-icon>

        <h1 style="font-size: 32px; font-weight: 700; color: var(--text-primary); margin: 16px 0 8px 0;">
            Akses Ditolak
        </h1>

        <p style="color: var(--text-secondary); font-size: 15px; margin: 0 0 8px 0;">
            Maaf, kamu tidak memiliki izin untuk mengakses halaman ini.
        </p>
        <p style="color: var(--text-muted); font-size: 13px; margin: 0 0 32px 0;">
            Hubungi administrator jika kamu merasa ini sebuah kesalahan.
        </p>

        <div style="display: flex; gap: 12px; justify-content: center;">
            <mdui-button onclick="history.back()" variant="outlined">
                <mdui-icon slot="icon" name="arrow_back"></mdui-icon>
                Kembali
            </mdui-button>
            <mdui-button href="<?= base_url('dashboard') ?>" variant="filled">
                <mdui-icon slot="icon" name="dashboard"></mdui-icon>
                Ke Dashboard
            </mdui-button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>