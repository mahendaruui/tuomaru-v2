<?php
$categoryMap = [
    'log' => 'Logika',
    'pen' => 'Penalaran Analitik',
    'mat' => 'Matematika',
    'eng' => 'Bahasa Inggris',
    'kew' => 'Kewarganegaraan',
    'fis' => 'Agama',
    'bio' => 'Biologi',
    'ipa' => 'IPA Terpadu',
    'psi' => 'Psikotes',
];
?>
<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Bank Soal</p>
            <h2 class="section-title">Tambah Soal</h2>
        </div>
        <a href="<?= base_url('admin/viewsoal'); ?>" class="action-btn action-btn--ghost">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Bank Soal
        </a>
    </div>

    <div class="v2-card soal-form-card">
        <form enctype="multipart/form-data" action="<?= base_url('atursoal/simpansoal'); ?>" method="POST" novalidate>
            <div class="soal-form-grid">
                <div class="soal-form-main">
                    <div class="field-block">
                        <label class="v2-label" for="kat_soal">Kategori Soal</label>
                        <select class="v2-input" id="kat_soal" name="kat_soal" required>
                            <?php foreach ($categoryMap as $value => $label) : ?>
                                <option value="<?= $value; ?>"><?= htmlspecialchars($label); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field-block">
                        <label class="v2-label" for="pertanyaan">Pertanyaan</label>
                        <textarea class="v2-input soal-textarea soal-textarea--lg" id="pertanyaan" name="pertanyaan" rows="8" required></textarea>
                    </div>

                    <div class="field-block">
                        <label class="v2-label" for="bahasan">Pembahasan</label>
                        <textarea class="v2-input soal-textarea" id="bahasan" name="bahasan" rows="8" placeholder="Isi pembahasan soal"></textarea>
                    </div>
                </div>

                <div class="soal-form-side">
                    <div class="choice-panel">
                        <div class="choice-panel__head">
                            <h3>Pilihan Jawaban</h3>
                            <p>Isi seluruh opsi jawaban yang akan tampil ke peserta.</p>
                        </div>
                        <div class="choice-list">
                            <label class="choice-field">
                                <span class="option-chip">A</span>
                                <input type="text" class="v2-input" name="jawabana" placeholder="Isi jawaban A" required>
                            </label>
                            <label class="choice-field">
                                <span class="option-chip">B</span>
                                <input type="text" class="v2-input" name="jawabanb" placeholder="Isi jawaban B" required>
                            </label>
                            <label class="choice-field">
                                <span class="option-chip">C</span>
                                <input type="text" class="v2-input" name="jawabanc" placeholder="Isi jawaban C" required>
                            </label>
                            <label class="choice-field">
                                <span class="option-chip">D</span>
                                <input type="text" class="v2-input" name="jawaband" placeholder="Isi jawaban D" required>
                            </label>
                            <label class="choice-field">
                                <span class="option-chip">E</span>
                                <input type="text" class="v2-input" name="jawabane" placeholder="Isi jawaban E" required>
                            </label>
                        </div>
                    </div>

                    <div class="answer-panel">
                        <label class="v2-label" for="kuncijwb">Kunci Jawaban</label>
                        <select class="v2-input" id="kuncijwb" name="kuncijwb" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>

                    <div class="soal-form-actions">
                        <button type="submit" class="v2-btn v2-btn--primary">Simpan Soal</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
