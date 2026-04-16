<section class="auth-login">
    <div class="auth-login__card">
        <aside class="auth-brand">
            <div>
                <div class="auth-brand__crest">
                    <img src="<?= base_url('assets/img/uuilogo.png'); ?>" alt="Logo SIPENMARU UUI">
                </div>
                <p class="auth-brand__eyebrow">Universitas Ubudiyah Indonesia</p>
                <h1 class="auth-brand__title">Panel Admin Sistem Ujian Online</h1>
                <p class="auth-brand__text">Masuk ke area pengelolaan peserta, bank soal, jadwal tes, dan hasil ujian dalam satu panel kerja yang sudah diperbarui.</p>
            </div>

            <div class="auth-brand__stats">
                <div class="auth-brand__stat">
                    <strong>Admin</strong>
                    <span>Pengelolaan data peserta dan ujian</span>
                </div>
                <div class="auth-brand__stat">
                    <strong>Terpusat</strong>
                    <span>Jadwal, soal, dan hasil tes</span>
                </div>
                <div class="auth-brand__stat">
                    <strong>Aman</strong>
                    <span>Autentikasi akun admin aktif</span>
                </div>
            </div>
        </aside>

        <div class="auth-panel">
            <div class="auth-panel__inner">
                <p class="auth-panel__eyebrow">Login Admin</p>
                <h2 class="auth-panel__title">Masuk ke dashboard</h2>
                <p class="auth-panel__text">Gunakan email dan password admin yang sudah terdaftar untuk mengakses panel pengelolaan ujian.</p>

                <div class="auth-alert">
                    <?= $this->session->flashdata('message'); ?>
                </div>

                <form method="post" action="<?= base_url('auth'); ?>">
                    <div class="auth-field">
                        <label class="auth-label" for="email">Email</label>
                        <div class="auth-input-wrap">
                            <i class="fas fa-envelope"></i>
                            <input type="text" class="auth-input" id="email" name="email" placeholder="nama@email.com" value="<?= set_value('email'); ?>" autocomplete="username">
                        </div>
                        <?= form_error('email', '<small class="auth-error">', '</small>'); ?>
                    </div>

                    <div class="auth-field">
                        <label class="auth-label" for="password">Password</label>
                        <div class="auth-input-wrap">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="auth-input" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password">
                        </div>
                        <?= form_error('password', '<small class="auth-error">', '</small>'); ?>
                    </div>

                    <button type="submit" class="auth-submit">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </button>
                </form>

                <p class="auth-note">Akses ini ditujukan untuk administrator sistem ujian. Jika Anda peserta tes, gunakan portal peserta yang sesuai.</p>
            </div>
        </div>
    </div>
</section>