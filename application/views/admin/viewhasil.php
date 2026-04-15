<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Hasil Tes</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i></a>
  </div>

  <div class="row mb-4">
    <div class="col-md-6">
      <a href="<?= base_url('admin/hasiltes') ?>" class="btn btn-danger"> <i class="fas fa-fw fa-sync"></i> Update Data</a>
    </div>
    <div class="col-md-6">
      <form action="<?= base_url('admin/lamanhasiltes') ?>" method="get" class="form-inline float-right">
        <div class="form-group mr-2">
          <label for="gelombang" class="mr-2">Filter Gelombang:</label>
          <select name="gelombang" id="gelombang" class="form-control">
            <option value="">Semua Gelombang</option>
            <?php foreach ($gelombang_list as $gel) : ?>
              <option value="<?= $gel->gelombang ?>" <?= ($selected_gelombang == $gel->gelombang) ? 'selected' : '' ?>>
                Gelombang <?= $gel->gelombang ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
        <?php if (!empty($selected_gelombang)) : ?>
          <a href="<?= base_url('admin/lamanhasiltes') ?>" class="btn btn-secondary ml-2"><i class="fas fa-times"></i> Reset</a>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="text-primary font-weight-bold m-0">Hasil Peserta Tes</h6>
        </div>
        <?php if (isset($nilaitessiswa)) : ?>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr align="center">
                    <th>No.</th>
                    <th>Gelombang</th>
                    <th>No Registrasi</th>
                    <th>Nama</th>
                    <th>Jwb Benar / jwb Salah</th>
                    <th>Nilai</th>
                    <th>Set Kelulusan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($nilaitessiswa as $hasil) : ?>
                    <tr align="center">
                      <td><?= $no ?></td>
                      <td><?= $hasil->sesi ?></td>
                      <td><?= $hasil->no_ujian ?></td>
                      <td><?= $hasil->nama ?></td>
                      <td><span class="badge badge-success"><?= $hasil->jwb_b ?></span> / <span class="badge badge-danger"><?= $hasil->jwb_s ?></span></td>
                      <td><?= $hasil->nilai ?></td>
                      <td>
                        <?php if ($hasil->status == 'Y') : ?>
                          <button href="<?= base_url('admin/setlulus/'); ?><?= $hasil->no_ujian; ?>/Y" class="btn btn-primary btn-sm" disabled><i class="fas fa-fw fa-check-circle"></i>Lulus</button>
                          <a href="<?= base_url('admin/setlulus/'); ?><?= $hasil->no_ujian; ?>/N" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-lock"></i>Tidak</a> | <span class="badge badge-primary">lulus</span>
                        <?php elseif ($hasil->status == 'N') : ?>
                          <a href="<?= base_url('admin/setlulus/'); ?><?= $hasil->no_ujian; ?>/Y" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-check-circle"></i>Lulus</a>
                          <button href="<?= base_url('admin/setlulus/'); ?><?= $hasil->no_ujian; ?>/N" class="btn btn-danger btn-sm" disabled><i class="fas fa-fw fa-lock"></i>Tidak</button> | | <span class="badge badge-danger">Tidak lulus</span>
                        <?php else : ?>
                          <a href="<?= base_url('admin/setlulus/'); ?><?= $hasil->no_ujian; ?>/Y" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-check-circle"></i>Lulus</a>
                          <a href="<?= base_url('admin/setlulus/'); ?><?= $hasil->no_ujian; ?>/N" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-lock"></i>Tidak</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php $no++;
                  endforeach;
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>



</div>