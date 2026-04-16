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
$detail = !empty($detailsoal) ? $detailsoal[0] : null;
?>
<?php if ($detail) : ?>
<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Bank Soal</p>
            <h2 class="section-title">Detail Soal</h2>
        </div>
        <div class="section-head__actions">
            <a href="<?= base_url('admin/editsoal/' . $detail->id); ?>" class="action-btn action-btn--warning">
                <i class="far fa-edit"></i>
                Edit Soal
            </a>
            <a href="<?= base_url('admin/viewsoal'); ?>" class="action-btn action-btn--ghost">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="detail-layout detail-layout--stack">
        <div class="detail-hero-card detail-hero-card--question">
            <div class="detail-hero-card__header">
                <span class="soal-cat-pill"><?= htmlspecialchars($categoryMap[$detail->kat] ?? strtoupper((string) $detail->kat)); ?></span>
                <span class="answer-key-pill">Kunci: <?= htmlspecialchars((string) $detail->jawaban); ?></span>
            </div>
            <div class="question-content">
                <?= $detail->soal; ?>
            </div>
        </div>

        <div class="detail-side-stack detail-side-stack--two">
            <div class="v2-card detail-panel">
                <div class="detail-panel__head">
                    <h3>Pilihan Jawaban</h3>
                </div>
                <div class="detail-option-list">
                    <div class="detail-option-row"><span class="option-chip">A</span><div><?= nl2br(htmlspecialchars((string) $detail->opsi_a)); ?></div></div>
                    <div class="detail-option-row"><span class="option-chip">B</span><div><?= nl2br(htmlspecialchars((string) $detail->opsi_b)); ?></div></div>
                    <div class="detail-option-row"><span class="option-chip">C</span><div><?= nl2br(htmlspecialchars((string) $detail->opsi_c)); ?></div></div>
                    <div class="detail-option-row"><span class="option-chip">D</span><div><?= nl2br(htmlspecialchars((string) $detail->opsi_d)); ?></div></div>
                    <div class="detail-option-row"><span class="option-chip">E</span><div><?= nl2br(htmlspecialchars((string) $detail->opsi_e)); ?></div></div>
                </div>
            </div>

            <div class="v2-card detail-panel">
                <div class="detail-panel__head">
                    <h3>Pembahasan</h3>
                </div>
                <div class="question-explanation">
                    <?= trim((string) $detail->pembahasan) !== '' ? $detail->pembahasan : '<p>Tidak ada pembahasan.</p>'; ?>
                </div>
            </div>
        </div>
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
