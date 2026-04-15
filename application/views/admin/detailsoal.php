<div class="container-fluid">
  <?php foreach ($detailsoal as $detail) : ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Detail Soal</h1>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pertanyaan </h6>
          </div>
          <div class="card-body">
            <h5 class="mb-4"><?= $detail->soal; ?></h5>
            <a href="#" class="btn btn-info btn-circle">
              <i class="fas fa-info-circle"></i>
            </a>
            <span class=" ml-2 font-italic font-weight-lighter "><span style='font-weight:bold'>Kategori Soal :
                <?php switch ($detail->kat) {
                  case "log":
                    echo "Logika</span>";
                    break;
                  case "pen":
                    echo "Penalaran Analitik</span>";
                    break;
                  case "mat":
                    echo "Matematika</span>";
                    break;
                  case "eng":
                    echo "Bahasa Inggris</span>";
                    break;
                  case "kew":
                    echo "Kewarganegaraan</span>";
                    break;
                  case "fis":
                    echo "Agama</span>";
                    break;
                  case "bio":
                    echo "Biologi</span>";
                    break;
                  case "ipa":
                    echo "IPA Terpadu</span>";
                    break;
                  case "psi":
                    echo "Psikotes</span>";
                    break;
                } ?>
              </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pilihan Jawaban</h6>
          </div>
          <div class="card-body">
            <p><span class="badge badge-primary"> Pilihan A </span> : <?= $detail->opsi_a ?> </p>
            <p><span class="badge badge-primary"> Pilihan B </span> : <?= $detail->opsi_b ?> </p>
            <p><span class="badge badge-primary"> Pilihan C </span> : <?= $detail->opsi_c ?> </p>
            <p><span class="badge badge-primary"> Pilihan D </span> : <?= $detail->opsi_d ?> </p>
            <p><span class="badge badge-primary"> Pilihan E </span> : <?= $detail->opsi_e ?> </p>
            <p class="alert alert-primary"> Kunci Jawaban : <?= $detail->jawaban ?> </p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pembahasan Jawaban</h6>
          </div>
          <div class="card-body">
            <p><?= $detail->pembahasan ?></p>
          </div>
        </div>
      </div>
    </div>
</div>
<?php endforeach; ?>
</div>