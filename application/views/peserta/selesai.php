<?php foreach ($cektes as $cek) : ?>
  <div class="container">
    <div class="row">
      <div class="col-md-3 mt-5">
        <div class="card">
          <div class="el-card-item">
            <div class="el-card-avatar el-overlay-1"> </div>
            <div class="el-card-content text-center">
              <h4 class="m-b-0 mt-2"><?= strtoupper($cek->nama); ?></h4> <span class="text-muted">No Registrasi <?= $cek->no_ujian ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9 mt-5">
        <div class="card">
          <div class="alert alert-primary">
            <div class="h3 text-center mb-3">
              <?php if ($cek->tes_tulis == 'Y' and $cek->hadir_tulis == 'Y') : ?>
                <div class="ket text-primary">Anda Telah Melakukan Tes Ujian Online</div>
                <hr>
                <?php foreach ($pesertates as $pu) : ?>
                  <?php if ($pu->status == 'X') : ?>
                    <div class="ket text-primary text-capitalize">Pengumuman kelulusan tes ujian tulis ini akan diberitahukan oleh panitia sipenmaru atau melalui website ini. Terima kasih</div>
                  <?php elseif ($pu->status == "Y") : ?>
                    <h3 class=" text-capitalize text-danger">Selamat Anda telah "LULUS" tes Ujian Tulis!!</h3>
                    <div class="ket text-danger">Silahkan melakukan tes kesehatan. Selengkapnya hubungi panitia sipenmaru.!</div>
                  <?php elseif ($pu->status == "N") : ?>
                    <h3 class=" text-capitalize text-danger">Mohon maaf, anda dinyatakan tidak Lulus Ujian Tulis. </h3>
                    <div class="ket text-danger">Coba lagi dilain kesempatan. Terima kasih..!</div>
                  <?php endif; ?>
                  <hr>
                <?php endforeach ?>
                <h4 class="ket text-primary">hubungi panitia atau kunjungi https://sipenmaru.uui.ac.id</h4>
                <a class="btn btn-primary mt-4" href="<?= base_url('login/logout') ?>">Logout</a>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>