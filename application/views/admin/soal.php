<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Bank Soal</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
  </div>
  <?php
  echo $this->session->flashdata("msg"); ?>
  <?php if (isset($soal)) : ?>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Kumpulan Soal-soal Ujian Online</h6>
      </div>
      <div class="card-body">
        <a href="<?= base_url() ?>admin/tambahsoal" class="btn btn-primary btn-icon-split btn-sm mb-2"><span class="icon text-white-50">
            <i class="fas fa-fw fa-plus"></i>
          </span>
          <span class="text">Tambah Soal</span></a>
        <div class="table-responsive">
          <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th width="200px" class="text-center">Kategori</th>
                <th width="400px">Pertanyaan</th>
                <th width="300px">Pilihan jawaban</th>
                <th width="100px" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($soal as $s) : ?>
                <tr class="font-weight-light">
                  <td class="text-center"><?= $no; ?></td>
                  <td class="text-center">
                    <?php switch ($s->kat) {
                      case "log":
                        echo "<span style='font-weight:bold'>Logika</span>";
                        break;
                      case "pen":
                        echo "<span style='font-weight:bold'>Penalaran Analitik</span>";
                        break;
                      case "mat":
                        echo "<span style='font-weight:bold'>Matematika</span>";
                        break;
                      case "eng":
                        echo "<span style='font-weight:bold'>Bahasa Inggris</span>";
                        break;
                      case "kew":
                        echo "<span style='font-weight:bold'>Kewarganegaraan</span>";
                        break;
                      case "fis":
                        echo "<span style='font-weight:bold'>Agama</span>";
                        break;
                      case "bio":
                        echo "<span style='font-weight:bold'>Biologi</span>";
                        break;
                      case "ipa":
                        echo "<span style='font-weight:bold'>IPA Terpadu</span>";
                        break;
                      case "psi":
                        echo "<span style='font-weight:bold'>Psikotes</span>";
                        break;
                    } ?>
                  </td>
                  <td><?= $s->soal; ?></td>
                  <td>
                    <p> <span class="badge badge-primary"> A </span> : <?= $s->opsi_a; ?></p>
                    <hr>
                    <p> <span class="badge badge-primary">B </span> : <?= $s->opsi_b; ?></p>
                    <hr>
                    <p> <span class="badge badge-primary">C </span> <?= $s->opsi_c; ?></p>
                    <hr>
                    <p><span class="badge badge-primary"> D </span> <?= $s->opsi_d; ?></p>
                    <hr>
                    <p><span class="badge badge-primary"> E </span> : <?= $s->opsi_e; ?></p>
                  </td>
                  <td class="text-center"><a href="<?php base_url() ?>editsoal/<?= $s->id ?>" title="Edit"><i class="far fa-edit"></i></a> | <a href="<?php base_url(); ?>hapussoal/<?= $s->id ?>" title="hapus" onclick="return confirm('Apakah anda yakin menghapus soal ini?')"><i class="fas fa-trash"></i></a> | <a href="<?php base_url() ?>detailsoal/<?= $s->id ?>" title="detail"><i class="fas fa-fw fa-info-circle"></i></a></td>
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