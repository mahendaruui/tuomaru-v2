<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Peserta</h1>
    <a href="<?= base_url('admin/downloadTemplatePeserta') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
      <i class="fas fa-download fa-sm text-white-50"></i> Download Template Peserta
    </a>
  </div>

  <!-- Flash Message -->
  <?php if ($this->session->flashdata('msg')) : ?>
    <?= $this->session->flashdata('msg') ?>
  <?php endif; ?>

  <!-- Upload CSV Card -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-file-upload mr-1"></i> Import Data Peserta (Excel)</h6>
      <button class="btn btn-sm btn-link p-0" type="button" data-toggle="collapse" data-target="#collapseImport">
        <i class="fas fa-chevron-down"></i>
      </button>
    </div>
    <div class="collapse" id="collapseImport">
      <div class="card-body">
        <p class="text-sm text-muted mb-2">
          <i class="fas fa-info-circle text-info"></i>
          Download template di atas &rarr; isi Sheet <strong>"Template Data"</strong> &rarr;
          simpan file &rarr; upload <strong>.xlsx / .xls / .csv</strong> di sini.<br>
          Password peserta akan dibuat otomatis <strong>5 karakter acak</strong> (huruf besar + angka).
        </p>
        <form action="<?= base_url('admin/importPeserta') ?>" method="post" enctype="multipart/form-data">
          <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="file_csv" name="file_csv" accept=".xlsx,.xls,.csv">
              <label class="custom-file-label" for="file_csv">Pilih file Excel atau CSV...</label>
            </div>
            <div class="input-group-append">
              <button class="btn btn-success" type="submit">
                <i class="fas fa-upload"></i> Upload & Import
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
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

</div>
<!-- End Page Content -->

<script>
// Update custom file input label with selected filename
document.getElementById('file_csv').addEventListener('change', function () {
  var fileName = this.files.length ? this.files[0].name : 'Pilih file CSV...';
  this.nextElementSibling.textContent = fileName;
});
</script>