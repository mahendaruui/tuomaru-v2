<script src="<?= base_url() ?>/assets/js/jqueryqore.js"></script>
<script src="<?= base_url() ?>/assets/js/jquery.countdown.js"></script>
<?php $p = !empty($peserta) ? $peserta[0] : null; ?>

<section class="peserta-dashboard peserta-dashboard--ujian">
  <div class="exam-session-head">
    <p class="peserta-eyebrow">Sesi Ujian Sedang Berlangsung</p>
    <h2 class="peserta-name">Semoga Sukses, <?= !empty($p) ? strtoupper($p->nama) : 'PESERTA'; ?>!</h2>
    <p class="peserta-meta">Kerjakan soal dengan tenang. Jawaban akan tersimpan otomatis saat Anda memilih opsi.</p>
    <div class="exam-timer-wrap">
      <span class="exam-timer-label">Sisa Waktu</span>
      <div id="tesmundur" class="exam-countdown"></div>
    </div>
    <p class="exam-note ket">Waktu ujian 2 jam dari jadwal yang telah ditentukan.</p>
  </div>

  <div class="exam-questions-wrap">
    <div class="peserta-card">
      <h3>Daftar Soal Ujian</h3>
      <p>Pilih salah satu jawaban A sampai E pada setiap pertanyaan.</p>
    </div>

    <div class="question-stack">
      <?php $no = 1; foreach ($datatesoke as $s) : ?>
      <article class="question-card">
        <div class="question-card__head">
          <span class="question-num">Pertanyaan <?= $no; ?></span>
          <span class="question-id">ID: <?= $s->id; ?></span>
        </div>
        <div class="question-text"><?= $s->soal; ?></div>

        <div class="question-options">
          <label class="option-item">
            <input type="radio" value="<?= $s->id ?>-A" name="jwb[<?= $s->id ?>]" <?= ($s->jwb == 'A' ? 'checked="checked"' : ''); ?> />
            <span><strong>A.</strong> <?= htmlspecialchars($s->opsi_a); ?></span>
          </label>
          <label class="option-item">
            <input type="radio" value="<?= $s->id ?>-B" name="jwb[<?= $s->id ?>]" <?= ($s->jwb == 'B' ? 'checked="checked"' : ''); ?> />
            <span><strong>B.</strong> <?= htmlspecialchars($s->opsi_b); ?></span>
          </label>
          <label class="option-item">
            <input type="radio" value="<?= $s->id ?>-C" name="jwb[<?= $s->id ?>]" <?= ($s->jwb == 'C' ? 'checked="checked"' : ''); ?> />
            <span><strong>C.</strong> <?= htmlspecialchars($s->opsi_c); ?></span>
          </label>
          <label class="option-item">
            <input type="radio" value="<?= $s->id ?>-D" name="jwb[<?= $s->id ?>]" <?= ($s->jwb == 'D' ? 'checked="checked"' : ''); ?> />
            <span><strong>D.</strong> <?= htmlspecialchars($s->opsi_d); ?></span>
          </label>
          <label class="option-item">
            <input type="radio" value="<?= $s->id ?>-E" name="jwb[<?= $s->id ?>]" <?= ($s->jwb == 'E' ? 'checked="checked"' : ''); ?> />
            <span><strong>E.</strong> <?= htmlspecialchars($s->opsi_e); ?></span>
          </label>
        </div>
      </article>
      <?php $no++; endforeach; ?>
    </div>

    <div class="finish-wrap">
      <a href="<?= base_url('dashboard/selesai') ?>" class="start-btn" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan ujian? Pastikan semua jawaban sudah terisi.')">
        <i class="fas fa-check-circle mr-2"></i> Selesaikan Ujian
      </a>
    </div>
  </div>
</section>

<script>
  (function() {
    var hitung = '<?= isset($wktmundurtes) ? $wktmundurtes : ''; ?>';
    if (!hitung) {
      return;
    }

    $('#tesmundur').countdown(hitung)
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
        $('.ket').html('<strong>Waktu ujian telah berakhir. Sistem akan mengalihkan ke halaman selesai.</strong>');
        window.location.replace("<?= base_url('dashboard/selesai') ?>");
      });
  })();
</script>

<script>
  $(document).ready(function() {
    $('input[type="radio"]').click(function() {
      let strJawab = $(this).val()
      let idSoal = strJawab.split("-")
      console.log(idSoal[0]);
      console.log(idSoal[1]);
      $.ajax({
        url: "<?= base_url() ?>Dashboard/livetesans",
        method: "POST",
        dataType: "html",
        // cache: false,
        data: {
          idsoal: idSoal[0],
          jawaban: idSoal[1]
        },
        error: function(data) {
          // alert('something is wrong')
        },
        success: function(data) {
          // alert('data masuk')
        }
      });
    });

  });
</script>