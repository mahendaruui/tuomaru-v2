<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Input Pertenyaan</h6>
    </div>
    <?php foreach ($datasoal as $dsoal) : ?>
      <form enctype="multipart/form-data" action="<?= base_url() ?>atursoal/updatesoal" method="POST">
        <input type="text" class="form-control" name="idsoal" value="<?= $dsoal->id; ?>" aria-describedby="addon-wrapping" hidden>
        <div class="modal-body">
          <div class="input-group flex-nowrap mb-2">
            <label for="formGroupExampleInput2" class="mr-3">Kategori Soal</label>
            <select class="form-control form-control-sm" name="kat_soal" required>
              <option value="<?= $dsoal->kat ?>" selected>
                <?php switch ($dsoal->kat) {
                  case "log":
                    echo "Logika";
                    break;
                  case "pen":
                    echo "Penalaran Analitik";
                    break;
                  case "mat":
                    echo "Matematika";
                    break;
                  case "eng":
                    echo "Bahasa Inggris";
                    break;
                  case "kew":
                    echo "Kewarganegaraan";
                    break;
                  case "fis":
                    echo "Agama";
                    break;
                  case "bio":
                    echo "Biologi";
                    break;
                  case "ipa":
                    echo "IPA Terpadu";
                    break;
                  case "psi":
                    echo "Psikotes";
                    break;
                } ?> | Selected
              </option>
              <option value="log">Logika</option>
              <option value="pen">Penalaran Analitik</option>
              <option value="mat">Matematika</option>
              <option value="eng">Bahasa Inggris</option>
              <option value="kew">Kewarganegaraan</option>
              <option value="fis">Agama</option>
              <option value="bio">Biologi</option>
              <option value="ipa">IPA Terpadu</option>
              <option value="psi">Psikotes</option>
            </select>
            <!-- <input type="text" class="form-control" name="kuncijwb" placeholder="Isi Kunci Jawaban A,B,C,D,E" aria-label="Kunci" aria-describedby="addon-wrapping" required> -->
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput">Pertanyaan *</label>
            <textarea class="form-control" aria-label="With textarea" rows="6" name="pertanyaan" required><?= $dsoal->soal; ?></textarea>
            <!-- <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input"> -->
          </div>
          <div class="form-group">
            <label for="formGroupExampleInput2">Pilihan Jawaban</label>
            <div class="input-group flex-nowrap mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">A</span>
              </div>
              <input type="text" class="form-control" name="jawabana" aria-label="Jawaban A" value="<?= $dsoal->opsi_a; ?>" aria-describedby="addon-wrapping" required>
            </div>
            <div class="input-group flex-nowrap mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">B</span>
              </div>
              <input type="text" class="form-control" name="jawabanb" aria-label="Jawaban B" value="<?= $dsoal->opsi_b; ?>" aria-describedby="addon-wrapping" required>
            </div>
            <div class="input-group flex-nowrap mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">C</span>
              </div>
              <input type="text" class="form-control" name="jawabanc" aria-label="Jawaban C" value="<?= $dsoal->opsi_c; ?>" aria-describedby="addon-wrapping" required>
            </div>
            <div class="input-group flex-nowrap mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">D</span>
              </div>
              <input type="text" class="form-control" name="jawaband" aria-label="Jawaban D" value="<?= $dsoal->opsi_d; ?>" aria-describedby="addon-wrapping" required>
            </div>
            <div class="input-group flex-nowrap mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">E</span>
              </div>
              <input type="text" class="form-control" name="jawabane" aria-label="Jawaban E" value="<?= $dsoal->opsi_e; ?>" aria-describedby="addon-wrapping">
            </div>
            <hr>
            <div class="input-group flex-nowrap mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">Kunci</span>
              </div>
              <input type="text" class="form-control" name="kuncijwb" value="<?= $dsoal->jawaban; ?>" aria-label="Kunci" aria-describedby="addon-wrapping" required>
            </div>
            <div class="input-group flex-nowrap mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-wrapping">Pembahasan</span>
              </div>
              <textarea class="form-control" aria-label="With textarea" rows="6" name="bahasan" value="<?= $dsoal->pembahasan ?>"><?= $dsoal->pembahasan ?></textarea>
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan Soal</button>
          </div>
        </div>
      </form>
    <?php endforeach; ?>
  </div>