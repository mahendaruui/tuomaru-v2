<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Peserta</h1>
    <a href="<?= base_url('admin/downloadTemplatePeserta') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Download Template Excel</a>
  </div>

  <?php if (isset($pendaftar)) : ?>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Peserta Calon Mahasiswa Baru</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nomor Ujian</th>
                <th>Nama Peserta</th>
                <th>Password</th>
                <th>Jenis Kelamin</th>
                <!-- <th>Tempat Lahir</th>
                                  <th>Tanggal Lahir</th> -->
                <th>Asal Sekolah</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // var_dump($pendaftar);
              $no = 1;
              foreach ($pendaftar as $peserta) : ?>
                <tr class="font-weight-light">
                  <td><?= $no; ?></td>
                  <td><?= $peserta->no_ujian; ?></td>
                  <td><?= $peserta->nama; ?></td>
                  <td><?= $peserta->pass; ?></td>
                  <td><?= $peserta->jenkel; ?></td>
                  <!-- <td><?= $peserta->tempat; ?></td>
                                                      <td><?= $peserta->tanggal; ?></td> -->
                  <td><?= $peserta->asal_sekolah; ?></td>
                  <td><a href="<?php base_url() ?>detailmember/<?= $peserta->id ?>" class="btn btn-info" title="Edit"><i class="fas fa-fw fa-info-circle"></i>Detail</a></td>
                </tr>
              <?php
                $no++;

              endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  <?php endif; ?>