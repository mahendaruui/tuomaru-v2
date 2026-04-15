<!-- Begin Page Content -->
<div class="container-fluid">

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Input Pertenyaan</h6>
    </div>
    <form enctype="multipart/form-data" action="<?= base_url() ?>atursoal/simpansoal" method="POST" novalidate>
      <div class="modal-body">
        <div class="input-group flex-nowrap mb-2">
          <label for="formGroupExampleInput2" class="mr-3">Kategori Soal</label>
          <select class="form-control form-control-sm" name="kat_soal" required>
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
          <textarea class="form-control" aria-label="With textarea" rows="6" name="pertanyaan" required></textarea>
          <!-- <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input"> -->
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput2">Pilihan Jawaban</label>
          <div class="input-group flex-nowrap mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text" id="addon-wrapping">A</span>
            </div>
            <input type="text" class="form-control" name="jawabana" placeholder="Isian Jawaban A" aria-label="Jawaban A" aria-describedby="addon-wrapping" required>
          </div>
          <div class="input-group flex-nowrap mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text" id="addon-wrapping">B</span>
            </div>
            <input type="text" class="form-control" name="jawabanb" placeholder="Isian Jawaban B" aria-label="Jawaban B" aria-describedby="addon-wrapping" required>
          </div>
          <div class="input-group flex-nowrap mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text" id="addon-wrapping">C</span>
            </div>
            <input type="text" class="form-control" name="jawabanc" placeholder="Isian Jawaban C" aria-label="Jawaban C" aria-describedby="addon-wrapping" required>
          </div>
          <div class="input-group flex-nowrap mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text" id="addon-wrapping">D</span>
            </div>
            <input type="text" class="form-control" name="jawaband" placeholder="Isian Jawaban D" aria-label="Jawaban D" aria-describedby="addon-wrapping" required>
          </div>
          <div class="input-group flex-nowrap mb-2">
            <div class="input-group-prepend">
              <span class="input-group-text" id="addon-wrapping">E</span>
            </div>
            <input type="text" class="form-control" name="jawabane" placeholder="Isian Jawaban E" aria-label="Jawaban E" aria-describedby="addon-wrapping" required>
          </div>
          <hr>
          <div class="input-group flex-nowrap mb-2">
            <label for="formGroupExampleInput2" class="mr-3">Kunci Jawaban</label>
            <select class="form-control form-control-sm" name="kuncijwb" required>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
              <option value="E">E</option>
            </select>
            <!-- <input type="text" class="form-control" name="kuncijwb" placeholder="Isi Kunci Jawaban A,B,C,D,E" aria-label="Kunci" aria-describedby="addon-wrapping" required> -->
          </div>
          <div class="form-group mt-4">
            <div class="input-group-prepend">
              <span class="input-group-text" id="addon-wrapping">Pembahasan</span>
            </div>
            <textarea class="form-control" aria-label="With textarea" rows="6" name="bahasan" placeholder="Isi Pembahasan"></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">Simpan Soal</button>
        </div>
      </div>
    </form>
  </div>