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
            <p class="admin-eyebrow">Manajemen Ujian</p>
            <h2 class="section-title">Bank Soal</h2>
        </div>
        <a href="<?= base_url('admin/tambahsoal'); ?>" class="action-btn">
            <i class="fas fa-plus"></i>
            Tambah Soal
        </a>
    </div>

    <?= $this->session->flashdata('msg'); ?>

    <div class="v2-card">
        <?php if (empty($soal)) : ?>
            <div class="empty-state">
                <p class="empty-state__label">Belum ada soal yang tersedia.</p>
            </div>
        <?php else : ?>
            <div class="v2-card__toolbar">
                <span class="v2-card__count"><?= count($soal); ?> soal</span>
            </div>
            <div class="table-scroll">
                <table class="v2-table soal-table">
                    <thead>
                        <tr>
                            <th class="row-num-head">#</th>
                            <th>Kategori</th>
                            <th>Pertanyaan</th>
                            <th>Pilihan Jawaban</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($soal as $item) : ?>
                        <?php
                        $categoryName = $categoryMap[$item->kat] ?? strtoupper((string) $item->kat);
                        $questionPreview = trim(strip_tags((string) $item->soal));
                        ?>
                        <tr>
                            <td class="row-num"><?= $no; ?></td>
                            <td>
                                <span class="soal-cat-pill"><?= htmlspecialchars($categoryName); ?></span>
                            </td>
                            <td>
                                <div class="soal-preview">
                                    <?= htmlspecialchars($questionPreview !== '' ? $questionPreview : '-'); ?>
                                </div>
                            </td>
                            <td>
                                <div class="option-stack">
                                    <div class="option-row"><span class="option-chip">A</span><span><?= htmlspecialchars(strip_tags((string) $item->opsi_a)); ?></span></div>
                                    <div class="option-row"><span class="option-chip">B</span><span><?= htmlspecialchars(strip_tags((string) $item->opsi_b)); ?></span></div>
                                    <div class="option-row"><span class="option-chip">C</span><span><?= htmlspecialchars(strip_tags((string) $item->opsi_c)); ?></span></div>
                                    <div class="option-row"><span class="option-chip">D</span><span><?= htmlspecialchars(strip_tags((string) $item->opsi_d)); ?></span></div>
                                    <div class="option-row"><span class="option-chip">E</span><span><?= htmlspecialchars(strip_tags((string) $item->opsi_e)); ?></span></div>
                                </div>
                            </td>
                            <td class="row-actions">
                                <a href="<?= base_url('admin/editsoal/' . $item->id); ?>" class="row-action row-action--warning" title="Edit soal">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="<?= base_url('admin/detailsoal/' . $item->id); ?>" class="row-action row-action--info" title="Detail soal">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                <a href="<?= base_url('admin/hapussoal/' . $item->id); ?>" class="row-action row-action--danger" title="Hapus soal" onclick="return confirm('Apakah anda yakin menghapus soal ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
