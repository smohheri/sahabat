<div class="laporan-page asesmen-page">
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="page-header mb-3">
        <div>
            <h4 class="mb-1">Asesmen Karakter Mandiri Bulanan</h4>
            <p class="text-muted mb-0"><?php echo html_escape($anak->nama_anak); ?> - Periode
                <?php echo $current_month; ?>/<?php echo $current_year; ?>
            </p>
        </div>
    </div>

    <?php if (!$schema_ready): ?>
        <div class="alert alert-warning">
            Modul penilaian karakter belum siap. Hubungi admin untuk menjalankan migrasi tabel penilaian.
        </div>
    <?php elseif ($already_submitted): ?>
        <div class="alert alert-info">
            Penilaian mandiri bulan ini sudah dikirim. Pengisian berikutnya tersedia pada bulan depan.
        </div>
        <a href="<?php echo site_url('anak'); ?>" class="btn btn-outline-primary">Kembali ke Dashboard</a>
    <?php else: ?>
        <div class="data-panel score-guide mb-3">
            <div class="panel-body">
                <h5 class="mb-2">Panduan Skor Penilaian</h5>
                <div class="score-guide-grid">
                    <?php foreach ((array) $scales as $scale): ?>
                        <div class="score-guide-item">
                            <span class="score-badge"><?php echo (int) $scale->score; ?></span>
                            <div>
                                <div class="score-title"><?php echo html_escape($scale->category); ?></div>
                                <div class="score-desc"><?php echo html_escape($scale->description); ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php echo form_open('anak/asesmen-mandiri'); ?>
        <input type="hidden" name="submit_self_assessment" value="1">

        <?php foreach ((array) $aspects as $aspect): ?>
            <div class="data-panel aspect-card mb-3">
                <div class="panel-body">
                    <h5><?php echo html_escape($aspect->aspect_name); ?></h5>
                    <?php foreach ((array) $aspect->indicators as $indicator): ?>
                        <div class="indicator-item">
                            <div class="indicator-name"><?php echo html_escape($indicator->indicator_name); ?></div>
                            <div class="indicator-score">
                                <?php foreach ((array) $scales as $scale): ?>
                                    <label>
                                        <input type="radio" name="scores[<?php echo (int) $indicator->id_indicator; ?>]"
                                            value="<?php echo (int) $scale->score; ?>">
                                        <span><?php echo (int) $scale->score; ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="form-group">
            <label for="notes">Refleksi Bulan Ini (opsional)</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"
                placeholder="Apa pencapaian utama kamu bulan ini?"></textarea>
        </div>

        <div class="form-group">
            <label for="improvement_aspect">Aspek Perbaikan Bulan Berikutnya</label>
            <textarea class="form-control" id="improvement_aspect" name="improvement_aspect" rows="3"
                placeholder="Tuliskan aspek yang ingin kamu perbaiki bulan depan" required></textarea>
        </div>

        <div class="form-group">
            <label for="improvement_plan">Rencana Perbaikan Bulan Berikutnya</label>
            <textarea class="form-control" id="improvement_plan" name="improvement_plan" rows="3"
                placeholder="Tuliskan rencana tindakan yang akan kamu lakukan" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Asesmen Mandiri</button>
        <a href="<?php echo site_url('anak'); ?>" class="btn btn-light">Batal</a>
        <?php echo form_close(); ?>
    <?php endif; ?>
</div>

<style>
    .score-guide {
        margin-bottom: 14px;
    }

    .score-guide h5 {
        margin: 0;
        font-size: 1rem;
        color: var(--panel-heading);
    }

    .score-guide-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .score-guide-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: var(--panel-bg);
        border: 1px solid var(--panel-border);
        border-radius: 8px;
        padding: 8px;
    }

    body.dark-mode .score-guide-item {
        background: #1a2c4d;
        border-color: #31537e;
    }

    .score-badge {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #0ea5e9;
        color: #fff;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .score-title {
        font-weight: 700;
        color: var(--panel-heading);
        font-size: 0.9rem;
    }

    .score-desc {
        color: var(--panel-text-soft);
        font-size: 0.84rem;
        line-height: 1.35;
    }

    .aspect-card {
        margin-bottom: 14px;
    }

    .aspect-card h5 {
        margin: 0 0 10px;
        font-size: 1rem;
        color: var(--panel-heading);
    }

    .indicator-item {
        border-top: 1px dashed var(--panel-border);
        padding: 8px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .indicator-item:first-of-type {
        border-top: none;
    }

    .indicator-name {
        color: var(--panel-text-soft);
    }

    .indicator-score {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .indicator-score label {
        margin: 0;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 600;
        color: var(--panel-text-soft);
        cursor: pointer;
    }

    body.dark-mode .asesmen-page .page-header h4,
    body.dark-mode .asesmen-page .score-guide h5,
    body.dark-mode .asesmen-page .aspect-card h5,
    body.dark-mode .asesmen-page .score-title,
    body.dark-mode .asesmen-page label {
        color: #f8fafc !important;
    }

    body.dark-mode .asesmen-page .page-header p.text-muted,
    body.dark-mode .asesmen-page .score-desc,
    body.dark-mode .asesmen-page .indicator-name,
    body.dark-mode .asesmen-page .indicator-score label,
    body.dark-mode .asesmen-page .form-control::placeholder {
        color: #dbeafe !important;
    }

    @media (max-width: 992px) {
        .score-guide-grid {
            grid-template-columns: 1fr;
        }

        .indicator-item {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>