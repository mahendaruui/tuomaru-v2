<script src="<?= base_url() ?>/assets/js/jqueryqore.js"></script>
<script src="<?= base_url() ?>/assets/js/jquery.countdown.js"></script>

<?php
$peserta = !empty($datapeserta) ? $datapeserta[0] : null;
$ujian = !empty($cekujian) ? $cekujian[0] : null;
$isJadwalAktif = !empty($ujian) && (string)$ujian->active === '1';
$hitungmundur = $isJadwalAktif ? date('Y/m/d H:i:s', $ujian->tgl_tes) : '';
$fotoPeserta = (!empty($peserta) && !empty($peserta->foto)) ? base_url('foto/' . $peserta->foto) : '';
$initialPeserta = !empty($peserta) ? strtoupper(substr(trim((string)$peserta->nama), 0, 1)) : 'P';
?>

<section class="peserta-dashboard">
  <?php if (!empty($peserta)) : ?>
    <div class="peserta-hero">
      <div>
        <?php if (!empty($fotoPeserta)) : ?>
          <img class="peserta-avatar" src="<?= $fotoPeserta; ?>" alt="Foto peserta">
        <?php else : ?>
          <div class="peserta-avatar-placeholder"><?= $initialPeserta; ?></div>
        <?php endif; ?>
      </div>
      <div>
        <p class="peserta-eyebrow">Dashboard Peserta</p>
        <h2 class="peserta-name"><?= strtoupper($peserta->nama); ?></h2>
        <p class="peserta-meta">Nomor Registrasi: <?= $peserta->no_ujian; ?></p>
        <div class="peserta-chip-row">
          <span class="peserta-chip">Sesi <?= !empty($peserta->sesi) ? strtoupper($peserta->sesi) : '-'; ?></span>
          <span class="peserta-chip peserta-chip--accent"><?= $isJadwalAktif ? 'Jadwal Aktif' : 'Menunggu Jadwal'; ?></span>
          <a class="peserta-chip peserta-chip--link" href="<?= base_url('dashboard/profil') ?>">Lihat Profil</a>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <div class="peserta-grid">
    <div class="peserta-card">
      <h3>Status Ujian Online</h3>
      <p>Halaman ini menampilkan status jadwal ujian Anda. Saat hitung mundur selesai, tombol mulai akan muncul otomatis.</p>
    </div>
    <div class="peserta-card">
      <h3>Persiapan Ujian</h3>
      <p>Pastikan koneksi internet stabil, perangkat terisi daya, dan kerjakan soal hingga batas waktu berakhir.</p>
    </div>
  </div>

  <div class="exam-panel">
    <?php if (!empty($cekujian)) : ?>
      <?php if ($isJadwalAktif) : ?>
        <h3>Gelombang ujian telah dibuka</h3>
        <p>Silakan tunggu hitung mundur. Ujian akan dimulai sesuai jadwal.</p>
        <div class="exam-schedule">
          <?= tgl_indo(date('Y-m-d', $ujian->tgl_tes)); ?>
          <br>
          <?= date('H:i:s', $ujian->tgl_tes); ?> WIB
        </div>
        <div id="hitungmundur" class="exam-countdown"></div>
        <div class="exam-note ket">Silakan tunggu hingga waktu hitung mundur selesai.</div>
        <div class="start-wrap" id="btnstart"></div>
      <?php else : ?>
        <div class="exam-alert exam-alert--danger">Jadwal ujian belum dibuka atau sudah ditutup.</div>
      <?php endif; ?>
    <?php else : ?>
      <div class="exam-alert exam-alert--danger">
        Anda belum terdaftar sebagai peserta ujian tulis. Silakan hubungi panitia penerimaan mahasiswa baru melalui email daa[at].uui.ac.id.
      </div>
    <?php endif; ?>
  </div>
</section>

<script>
  (function() {
    var hitung = '<?= $hitungmundur; ?>';
    if (!hitung) {
      return;
    }

    $('#hitungmundur').countdown(hitung)
      .on('update.countdown', function(event) {
        var format = '%H:%M:%S';
        if (event.offset.totalDays > 0) {
          format = '%-d day%!d ' + format;
        }
        if (event.offset.weeks > 0) {
          format = '%-w week%!w ' + format;
        }
        $(this).html(event.strftime(format));
      })
      .on('finish.countdown', function() {
        $('#btnstart').html('<form action="<?= base_url('dashboard/lamanUjian'); ?>"><button class="start-btn" id="ts-success">Mulai Ujian</button></form>');
        $('.ket').html('<strong>Klik tombol Mulai Ujian untuk memulai tes. Waktu ujian Anda 2 jam dari jadwal.</strong>');
      });
  })();
</script>