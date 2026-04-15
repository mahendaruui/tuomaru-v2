<script src="<?= base_url() ?>/assets/js/jqueryqore.js"></script>
<script src="<?= base_url() ?>/assets/js/jquery.countdown.js"></script>

<?php foreach ($datapeserta as $peserta); ?>
<div class="container">
  <div class="row">
    <div class="col-md-3 mt-5">
      <div class="card">
        <div class="el-card-item">
          <div class="el-card-avatar el-overlay-1 text-center"> <img class="img-thumbnail" src="https://sipenmaru.uui.ac.id/foto/<?= $peserta->foto ?>" alt="user" />
          </div>
          <div class="el-card-content text-center">
            <h4 class="m-b-0 mt-2"><?= strtoupper($peserta->nama); ?></h4> <span class="text-muted">No Registrasi <?= $peserta->no_ujian ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card-body">
        <h5 class="card-title">Status Ujian Online</h5>
        <h2 class="mt-2 mx-auto text-center alert alert-primary">Selamat Datang, <Span class="font-bold"><?= strtoupper($peserta->nama); ?>!</Span></h2>
        <?php if (isset($cekujian)) : ?>
          <?php foreach ($cekujian as $ujian);
          if ($ujian->active) : ?>

            <div class="alert alert-primary">
              <div class="h3 text-center mb-3">
                <h3 class=" text-capitalize ">Gelombang ujian telah dibuka!</h3>
                <hr>
                <div class="ket text-primary">Silahkan tunggu hitung mundur, Ujian anda sesuai jadwal. Terima kasih!!</div>

              </div>
              <hr>
              <div class="h5 text-center mb-3">
                Tanggal Ujian,
                <?php $jadwal = $ujian->tgl_tes;
                echo tgl_indo(date("Y-m-d", $jadwal));
                echo "<br>";
                echo date("H:i:s", $jadwal) . " WIB";
                $hitungmundur = date("Y/m/d H:i:s", $jadwal);
                ?>
              </div>

              <div id="hitungmundur" class="text-center mb-3 h4"></div>

              <div class="row">
                <div class="col-md-3 col-sm-12 m-auto">
                  <div id="btnstart"></div>
                </div>
              </div>
            <?php else : ?>
              <div class="alert alert-danger text-center">
                Jadwal belum dibuka / telah ditutup!!
              </div>
            <?php endif; ?>

          <?php else : ?>
            <div class="alert alert-danger">
              Anda Belum terdaftar sebagai peserta Ujian Tulis. Silahkan Hubungi panitia penerimaan mahasiswa baru ke email daa[at].uui.ac.id
            </div>
          <?php endif; ?>
            </div>
      </div>
    </div>
  </div>
</div>

<script>
  // 2020/10/10 12:34:56
  var hitung = '<?= $hitungmundur ?>';
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
    .on('finish.countdown', function(event) {
      $("#btnstart").append(`<form action="<?= base_url('dashboard/lamanUjian') ?>"><button class="btn btn-lg btn-block btn-primary" id="ts-success">Mulai!</button></form>`);
      $(".ket").html('');
      $(".ket").append(`<h4 class="text-danger">Klik tombol 'Mulai' untuk memulai ujian, Waktu anda 2 Jam dari jadwal</h4>`);
      $("#clock").remove();
    });
</script>