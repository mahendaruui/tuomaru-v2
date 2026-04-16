<section class="admin-page-section">
    <div class="section-head">
        <div>
            <p class="admin-eyebrow">Evaluasi Ujian</p>
            <h2 class="section-title">Manajemen Hasil Tes</h2>
        </div>
        <div class="section-head__actions">
            <a href="<?= base_url('admin/hasiltes'); ?>" class="action-btn action-btn--danger-soft">
                <i class="fas fa-sync"></i>
                Update Data
            </a>
        </div>
    </div>

    <div class="result-summary-grid">
        <div class="detail-stat">
            <span class="detail-stat__label">Total Peserta</span>
            <strong class="detail-stat__value"><?= count($nilaitessiswa ?? []); ?> peserta</strong>
        </div>
        <div class="detail-stat">
            <span class="detail-stat__label">Lulus</span>
            <strong class="detail-stat__value"><?= (int) ($hasilSummary['lulus'] ?? 0); ?> peserta</strong>
        </div>
        <div class="detail-stat">
            <span class="detail-stat__label">Tidak Lulus</span>
            <strong class="detail-stat__value"><?= (int) ($hasilSummary['tidak_lulus'] ?? 0); ?> peserta</strong>
        </div>
        <div class="detail-stat">
            <span class="detail-stat__label">Belum Diputuskan</span>
            <strong class="detail-stat__value"><?= (int) ($hasilSummary['pending'] ?? 0); ?> peserta</strong>
        </div>
    </div>

    <div class="v2-card result-filter-card">
        <form action="<?= base_url('admin/lamanhasiltes'); ?>" method="get" class="result-filter-form">
            <div class="field-block">
                <label class="v2-label" for="gelombang">Filter Gelombang</label>
                <select name="gelombang" id="gelombang" class="v2-input">
                    <option value="">Semua Gelombang</option>
                    <?php foreach ($gelombang_list as $gel) : ?>
                        <option value="<?= htmlspecialchars($gel->gelombang); ?>" <?= ((string) $selected_gelombang === (string) $gel->gelombang) ? 'selected' : ''; ?>>
                            Gelombang <?= htmlspecialchars($gel->gelombang); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="result-filter-actions">
                <button type="submit" class="v2-btn v2-btn--primary">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <?php if (!empty($selected_gelombang)) : ?>
                    <a href="<?= base_url('admin/lamanhasiltes'); ?>" class="v2-btn v2-btn--ghost">
                        <i class="fas fa-times"></i>
                        Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="v2-card">
        <?php if (empty($nilaitessiswa)) : ?>
            <div class="empty-state">
                <p class="empty-state__label">Belum ada hasil tes yang tersedia.</p>
            </div>
        <?php else : ?>
            <div class="v2-card__toolbar">
                <span class="v2-card__count">hasil tes peserta</span>
            </div>
            <div class="table-scroll">
                <table class="v2-table hasil-table">
                    <thead>
                        <tr>
                            <th class="row-num-head">#</th>
                            <th>Gelombang</th>
                            <th>No Registrasi</th>
                            <th>Nama</th>
                            <th>Benar / Salah</th>
                            <th>Nilai</th>
                            <th>Status</th>
                            <th>Set Kelulusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($nilaitessiswa as $hasil) : ?>
                        <?php
                        $status = (string) $hasil->status;
                        $statusLabel = 'Belum diputuskan';
                        $statusClass = 'result-status--pending';
                        if ($status === 'Y') {
                            $statusLabel = 'Lulus';
                            $statusClass = 'result-status--pass';
                        } elseif ($status === 'N') {
                            $statusLabel = 'Tidak lulus';
                            $statusClass = 'result-status--fail';
                        }
                        ?>
                        <tr>
                            <td class="row-num"><?= $no; ?></td>
                            <td><span class="gelombang-badge">Gel. <?= htmlspecialchars($hasil->sesi ?: '-'); ?></span></td>
                            <td><span class="ujian-badge"><?= htmlspecialchars($hasil->no_ujian); ?></span></td>
                            <td><?= htmlspecialchars($hasil->nama); ?></td>
                            <td>
                                <div class="answer-split">
                                    <span class="answer-pill answer-pill--good"><?= (int) $hasil->jwb_b; ?></span>
                                    <span class="answer-divider">/</span>
                                    <span class="answer-pill answer-pill--bad"><?= (int) $hasil->jwb_s; ?></span>
                                </div>
                            </td>
                            <td><span class="score-pill"><?= (int) $hasil->nilai; ?></span></td>
                            <td><span class="result-status <?= $statusClass; ?>"><?= $statusLabel; ?></span></td>
                            <td>
                                <div class="row-actions row-actions--wrap">
                                    <a href="<?= base_url('admin/setlulus/' . $hasil->no_ujian . '/Y'); ?>" class="row-action row-action--success <?= $status === 'Y' ? 'is-disabled' : ''; ?>" title="Set lulus" <?= $status === 'Y' ? 'aria-disabled="true"' : ''; ?>>
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                    <a href="<?= base_url('admin/setlulus/' . $hasil->no_ujian . '/N'); ?>" class="row-action row-action--danger <?= $status === 'N' ? 'is-disabled' : ''; ?>" title="Set tidak lulus" <?= $status === 'N' ? 'aria-disabled="true"' : ''; ?>>
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
