<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-left">
            <div>
                <mdui-icon name="apartment" style="font-size: 48px; color: #fff;"></mdui-icon>
                <h1 style="font-size: 26px; font-weight: 700; margin: 12px 0 4px 0; color: #fff;">Sistem Hotel</h1>
                <p style="opacity: 0.9; margin: 0; font-size: 13px; color: #fff;">
                    Daftar untuk mulai menggunakan sistem.
                </p>
            </div>

            <img src="<?= base_url('assets/illustration/Register.svg') ?>"
                 alt="Register Illustration"
                 style="width: 80%; max-width: 240px; margin: 24px 0;">

            <div style="font-size: 11px; opacity: 0.7; color: #fff;">
                © <?= date('Y') ?> Sistem Hotel
            </div>
        </div>

        <div class="login-right">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <h2 style="margin: 0; font-size: 22px; font-weight: 700;">Buat Akun</h2>
                <mdui-button href="<?= url_to('login') ?>" variant="outlined" style="font-size: 12px;">
                    Login
                </mdui-button>
            </div>
            <p style="color: #666; margin-bottom: 24px; font-size: 13px;">Lengkapi data untuk mendaftar.</p>

            <?php if (session('errors')): ?>
                <div style="padding: 12px; background: #ffdad6; color: #ba1a1a; border-radius: 8px; margin-bottom: 16px; font-size: 12px;">
                    <ul style="margin: 0; padding-left: 16px;">
                        <?php foreach (session('errors') as $e): ?>
                            <li><?= esc($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= url_to('register') ?>" method="post">
                <?= csrf_field() ?>

                <mdui-text-field
                    label="Email"
                    name="email"
                    type="email"
                    variant="outlined"
                    required
                    style="width: 100%; margin-bottom: 12px;">
                    <mdui-icon slot="icon" name="mail"></mdui-icon>
                </mdui-text-field>

                <mdui-text-field
                    label="Username"
                    name="username"
                    variant="outlined"
                    required
                    style="width: 100%; margin-bottom: 12px;">
                    <mdui-icon slot="icon" name="person"></mdui-icon>
                </mdui-text-field>

                <mdui-text-field
                    label="Password"
                    name="password"
                    type="password"
                    toggle-password
                    variant="outlined"
                    required
                    style="width: 100%; margin-bottom: 12px;">
                    <mdui-icon slot="icon" name="lock"></mdui-icon>
                </mdui-text-field>

                <mdui-text-field
                    label="Konfirmasi Password"
                    name="password_confirm"
                    type="password"
                    toggle-password
                    variant="outlined"
                    required
                    style="width: 100%; margin-bottom: 24px;">
                    <mdui-icon slot="icon" name="lock_reset"></mdui-icon>
                </mdui-text-field>

                <mdui-button type="submit" variant="filled" style="width: 100%;">
                    Daftar
                </mdui-button>
            </form>
        </div>
    </div>
</div>

<style>
.login-wrapper {
    min-height: 100vh;
    min-height: 100dvh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    width: 100%;
    box-sizing: border-box;
    overflow: hidden;
}
    .login-card { display: flex; width: 100%; max-width: 900px; min-height: 540px; background: #fff; border-radius: 20px; box-shadow: 0 15px 40px rgba(108, 92, 231, 0.15); overflow: hidden; }
    .login-left { flex: 1; background: linear-gradient(135deg, #6C5CE7 0%, #a29bfe 100%); padding: 40px; display: flex; flex-direction: column; justify-content: space-between; text-align: center; align-items: center; }
    .login-right { flex: 1.2; padding: 48px; display: flex; flex-direction: column; justify-content: center; }
    @media (max-width: 720px) {
        .login-card { flex-direction: column; max-width: 420px; min-height: auto; }
        .login-left { padding: 32px 24px; }
        .login-right { padding: 32px 24px; }
    }
</style>

<?= $this->endSection() ?>