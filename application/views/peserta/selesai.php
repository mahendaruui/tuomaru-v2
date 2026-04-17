<?php
$peserta = !empty($cektes) ? $cektes[0] : null;
$hasilTes = !empty($pesertates) ? $pesertates[0] : null;

$status = !empty($hasilTes->status) ? $hasilTes->status : 'X';
$nama = !empty($peserta->nama) ? strtoupper($peserta->nama) : 'PESERTA';
$noUjian = !empty($peserta->no_ujian) ? $peserta->no_ujian : '-';

$judulStatus = 'Anda Telah Melakukan Tes Ujian Online';
$pesanStatus = 'Pengumuman kelulusan tes ujian tulis akan diberitahukan oleh panitia melalui website ini.';
$kelasStatus = 'finish-status finish-status--pending';

if ($status === 'Y') {
  $judulStatus = 'Selamat, Anda Dinyatakan Lulus Tes Ujian Tulis';
  $pesanStatus = 'Silakan lanjutkan proses berikutnya sesuai arahan panitia penerimaan mahasiswa baru.';
  $kelasStatus = 'finish-status finish-status--pass';
} elseif ($status === 'N') {
  $judulStatus = 'Mohon Maaf, Anda Belum Lulus Tes Ujian Tulis';
  $pesanStatus = 'Tetap semangat dan terima kasih telah mengikuti seluruh rangkaian ujian.';
  $kelasStatus = 'finish-status finish-status--fail';
}
?>

<section class="peserta-dashboard peserta-dashboard--finish">
  <div class="finish-layout">
    <aside class="finish-identity">
      <p class="peserta-eyebrow">Status Ujian</p>
      <h2 class="finish-name"><?= htmlspecialchars($nama); ?></h2>
      <p class="finish-meta">No Registrasi: <?= htmlspecialchars($noUjian); ?></p>
      <span class="finish-pill">Ujian Tulis Selesai</span>
    </aside>

    <div class="finish-panel">
      <?php if (!empty($peserta) && $peserta->tes_tulis == 'Y' && $peserta->hadir_tulis == 'Y') : ?>
        <div class="<?= $kelasStatus; ?>">
          <h3><?= htmlspecialchars($judulStatus); ?></h3>
          <p><?= htmlspecialchars($pesanStatus); ?></p>
        </div>

        <div class="finish-contact">
          <p>Untuk informasi lebih lanjut, hubungi panitia atau kunjungi website resmi berikut:</p>
          <a href="https://uui.siakadcloud.com" target="_blank" rel="noopener noreferrer">https://uui.siakadcloud.comfi</a>
        </div>

        <div class="finish-actions">
          <a class="start-btn" href="<?= base_url('login/logout') ?>">Logout</a>
        </div>
      <?php else : ?>
        <div class="finish-status finish-status--fail">
          <h3>Data ujian tidak valid</h3>
          <p>Status kehadiran tes tidak ditemukan. Silakan hubungi panitia untuk konfirmasi data.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>