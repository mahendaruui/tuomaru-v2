<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Login peserta tes online UUI">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon.ico'); ?>">
  <title><?= $title; ?></title>
  <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700&display=swap" rel="stylesheet">
  <link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
  <link href="<?= base_url('assets/css/auth-v2.css'); ?>" rel="stylesheet">
</head>
<body class="auth-shell">
  <section class="auth-login auth-login--member">
    <div class="auth-login__card">
      <aside class="auth-brand auth-brand--member">
        <div>
          <div class="auth-brand__crest">
            <img src="<?= base_url('assets/img/uuilogo.png'); ?>" alt="Logo UUI">
          </div>
          <p class="auth-brand__eyebrow">Portal Peserta Ujian</p>
          <h1 class="auth-brand__title">Selamat Datang di Tes Masuk UUI</h1>
          <p class="auth-brand__text">Masuk menggunakan nomor ujian dan password yang diberikan panitia untuk memulai proses ujian online.</p>
        </div>

        <div class="auth-brand__stats">
          <div class="auth-brand__stat">
            <strong>Nomor Ujian</strong>
            <span>Gunakan identitas peserta resmi</span>
          </div>
          <div class="auth-brand__stat">
            <strong>Akses Ujian</strong>
            <span>Masuk ke dashboard tes peserta</span>
          </div>
          <div class="auth-brand__stat">
            <strong>Pantau Hasil</strong>
            <span>Status ujian tercatat otomatis</span>
          </div>
        </div>
      </aside>

      <div class="auth-panel">
        <div class="auth-panel__inner">
          <p class="auth-panel__eyebrow">Login Peserta</p>
          <h2 class="auth-panel__title">Masuk ke dashboard ujian</h2>
          <p class="auth-panel__text">Isi kredensial peserta untuk memulai sesi ujian yang sudah dijadwalkan.</p>

          <div class="auth-alert">
            <?php $__msg = $this->session->userdata('member_msg'); if ($__msg) : $this->session->unset_userdata('member_msg'); ?>
              <?= $__msg; ?>
            <?php endif; ?>
          </div>

          <form method="post" action="<?= base_url('login/ceklogin'); ?>">
            <div class="auth-field">
              <label class="auth-label" for="username">Nomor Ujian</label>
              <div class="auth-input-wrap">
                <i class="fas fa-id-card"></i>
                <input type="text" name="username" id="username" class="auth-input" placeholder="Contoh: 241000123" required autocomplete="username">
              </div>
            </div>

            <div class="auth-field">
              <label class="auth-label" for="password">Password</label>
              <div class="auth-input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" class="auth-input" placeholder="Masukkan password" required autocomplete="current-password">
              </div>
            </div>

            <button class="auth-submit" type="submit">
              <i class="fas fa-sign-in-alt"></i>
              Login Peserta
            </button>
          </form>

          <p class="auth-note">Jika Anda admin, gunakan halaman login admin pada jalur auth.</p>
        </div>
      </div>
    </div>
  </section>

  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
</body>
</html>