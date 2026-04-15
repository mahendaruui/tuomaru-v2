<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Tes</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
  </div>


  <div class="row">
    <div class="col-md-8">
      <?php echo $this->session->flashdata("msg"); ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-10">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Tes</h6>
        </div>
        <div class="card-body">
          <a href="" class="btn btn-primary btn-icon-split btn-sm mb-1" data-toggle="modal" data-target="#newJadwalModal">
            <span class="icon text-white-50">
              <i class="fas fa-fw fa-plus"></i>
            </span>
            <span class="text">Tambah Jadwal</span>
          </a>
          <div class="table-responsive mt-2">
            <table class="table table-unbordered">
              <thead>
                <tr align="center">
                  <!-- <th>No.</th> -->
                  <th>Gelombang Tes</th>
                  <th>Tanggal Tes</th>
                  <th>Waktu Tes</th>
                  <th>Status</th>
                  <th>Aksi</th>
                  <th>Atur peserta</th>
                </tr>
              </thead>
              <?php
              $no = 1;
              foreach ($jadwaltes as $jd) : ?>
                <tbody align="center">
                  <!-- <td><?= $no; ?></td> -->
                  <td><?= $jd->gelombang; ?></td>
                  <td>
                    <?php $jadwal = $jd->tgl_tes;
                      echo tgl_indo(date("Y-m-d", $jadwal));
                      ?>
                  </td>
                  <td>
                    <?php echo date("H:i", $jadwal); ?> WIB
                  </td>

                  <?php if ($jd->active == 0) : ?>
                    <td class="badge badge-secondary mt-1"> <i class="fas fa-fw fa-exclamation-triangle"></i> Non Aktif</td>
                  <?php else : ?>
                    <td class="badge badge-success mt-1"> <i class="fas fa-fw fa-check"></i>Aktif</td>
                  <?php endif; ?>
                  <td>
                    <a href="<?php base_url() ?>editjdw/<?= $jd->id ?>" title="Edit"><i class="far fa-edit"></i></a> |
                    <a href="<?php base_url() ?>hapusjdw/<?= $jd->id ?>" title="Hapus" onclick="return confirm('Apakah anda yakin menghapus Jadwal ini?')"><i class="fas fa-trash"></i></a>
                  </td>
                  <td>
                    <a href="<?= base_url() ?>admin/aturpeserta/<?= $jd->gelombang; ?>" title="Atur peserta pada gelombang <?= $jd->gelombang; ?>"><i class="fas fa-fw fa-users"></i></a>
                  </td>
                  <?php $no++; ?>
                </tbody>
              <?php endforeach; ?>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- modal tambah gelombang jadwal -->
  <!--  -->
  <div class="modal fade" id="newJadwalModal" tabindex="-1" role="dialog" aria-labelledby="newJadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newJadwalModalLabel">Tambah Jadwal Ujian</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?= base_url() ?>admin/tambahjadwal" method="post">
          <div class="modal-body">

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Gelombang</label>
              </div>
              <?php
              if (isset($jd->gelombang)) {
                $addgel = $jd->gelombang + 1;
              } else {
                $addgel = 1;
              }
              ?>
              <input type="text" name="gelombang" value="<?= $addgel ?>" hidden>
              <input type="text" value=" <?= $addgel ?>" disabled>
            </div>

            <div class="input-group flex-nowrap mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">Tanggal Tes</span>
              </div>
              <input type="date" class="form-control" name="tglujian" placeholder="tglujian" aria-label="tglujian" aria-describedby="addon-wrapping">
              <input type="time" class="form-control" name="wktujian" placeholder="tglujian" aria-label="tglujian" aria-describedby="addon-wrapping">
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">Aktif?</span>
                <div class="input-group-text">
                  <input type="checkbox" aria-label="Checkbox for following text input" name="aktifkan" value="1">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
</div>