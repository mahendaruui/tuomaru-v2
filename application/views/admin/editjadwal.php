<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Jadwal</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Form Input Pertenyaan</h6>
        </div>
        <div class="card-body">
          <?php foreach ($datajadwal as $djdw) : ?>
            <form enctype="multipart/form-data" action="<?= base_url() ?>atursoal/updatejadwal" method="POST">
              <input type="text" class="form-control" name="idjdw" value="<?= $djdw->id; ?>" aria-describedby="addon-wrapping" hidden>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Gelombang</label>
                </div>
                <input type="text" value=" <?= $djdw->gelombang; ?>" disabled>
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Tanggal</label>
                </div>
                <?php $jdwl = $djdw->tgl_tes;
                ?>
                <input type="date" class="form-control" name="tglujian" placeholder="tglujian" aria-label="tglujian" aria-describedby="addon-wrapping" value="<?= date("Y-m-d", $jdwl); ?>">
                <input type="time" class="form-control" name="wktujian" placeholder="wktujian" aria-label="tglujian" aria-describedby="addon-wrapping" value="<?= date("H:i", $jdwl); ?>">
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="addon-wrapping">Aktif?</span>
                  <div class="input-group-text">
                    <?php if ($djdw->active == "0" or $djdw->active == null) : ?>
                      <input type="checkbox" aria-label="Checkbox for following text input" name="aktifkan">
                    <?php else : ?>
                      <input type="checkbox" aria-label="Checkbox for following text input" name="aktifkan" checked>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Update Jadwal</button>
              </div>
            </form>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>

</div>