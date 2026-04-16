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
$question = !empty($datasoal) ? $datasoal[0] : null;
?>
<?php if ($question) : ?>
<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Bank Soal</p>
            <h2 class="section-title">Edit Soal</h2>
        </div>
        <a href="<?= base_url('admin/viewsoal'); ?>" class="action-btn action-btn--ghost">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Bank Soal
        </a>
    </div>

    <div class="v2-card soal-form-card">
        <form enctype="multipart/form-data" action="<?= base_url('atursoal/updatesoal'); ?>" method="POST">
            <input type="hidden" name="idsoal" value="<?= (int) $question->id; ?>">
            <div class="soal-form-grid">
                <div class="soal-form-main">
                    <div class="field-block">
                        <label class="v2-label" for="kat_soal">Kategori Soal</label>
                        <select class="v2-input" id="kat_soal" name="kat_soal" required>
                            <?php foreach ($categoryMap as $value => $label) : ?>
                                <option value="<?= $value; ?>" <?= ((string) $question->kat === (string) $value) ? 'selected' : ''; ?>><?= htmlspecialchars($label); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field-block">
                        <label class="v2-label" for="pertanyaan">Pertanyaan</label>
                        <textarea class="v2-input soal-textarea soal-textarea--lg" id="pertanyaan" name="pertanyaan" rows="8" required><?= htmlspecialchars((string) $question->soal); ?></textarea>
                    </div>

                    <div class="field-block">
                        <label class="v2-label" for="bahasan">Pembahasan</label>
                        <textarea class="v2-input soal-textarea" id="bahasan" name="bahasan" rows="8" placeholder="Isi pembahasan soal"><?= htmlspecialchars((string) $question->pembahasan); ?></textarea>
                    </div>
                </div>

                <div class="soal-form-side">
                    <div class="choice-panel">
                        <div class="choice-panel__head">
                            <h3>Pilihan Jawaban</h3>
                            <p>Perbarui opsi jawaban dan pilih kunci yang benar.</p>
                        </div>
                        <div class="choice-list">
                            <label class="choice-field">
                                <span class="option-chip">A</span>
                                <input type="text" class="v2-input" name="jawabana" value="<?= htmlspecialchars((string) $question->opsi_a); ?>" required>
                            </label>
                            <label class="choice-field">
                                <span class="option-chip">B</span>
                                <input type="text" class="v2-input" name="jawabanb" value="<?= htmlspecialchars((string) $question->opsi_b); ?>" required>
                            </label>
                            <label class="choice-field">
                                <span class="option-chip">C</span>
                                <input type="text" class="v2-input" name="jawabanc" value="<?= htmlspecialchars((string) $question->opsi_c); ?>" required>
                            </label>
                            <label class="choice-field">
                                <span class="option-chip">D</span>
                                <input type="text" class="v2-input" name="jawaband" value="<?= htmlspecialchars((string) $question->opsi_d); ?>" required>
                            </label>
                            <label class="choice-field">
                                <span class="option-chip">E</span>
                                <input type="text" class="v2-input" name="jawabane" value="<?= htmlspecialchars((string) $question->opsi_e); ?>">
                            </label>
                        </div>
                    </div>

                    <div class="answer-panel">
                        <label class="v2-label" for="kuncijwb">Kunci Jawaban</label>
                        <select class="v2-input" id="kuncijwb" name="kuncijwb" required>
                            <?php foreach (['A', 'B', 'C', 'D', 'E'] as $answerKey) : ?>
                                <option value="<?= $answerKey; ?>" <?= ((string) $question->jawaban === $answerKey) ? 'selected' : ''; ?>><?= $answerKey; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="soal-form-actions">
                        <button type="submit" class="v2-btn v2-btn--primary">Update Soal</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php else : ?>
<section class="admin-page-section">
    <div class="v2-card">
        <div class="empty-state">
            <p class="empty-state__label">Data soal tidak ditemukan.</p>
            <a href="<?= base_url('admin/viewsoal'); ?>" class="v2-btn v2-btn--primary">Kembali ke bank soal</a>
        </div>
    </div>
</section>
<?php endif; ?>
