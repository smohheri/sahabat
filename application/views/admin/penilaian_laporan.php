<div class="character-master-page">
    <div class="page-header">
        <div class="header-info">
            <div class="header-icon bg-purple">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <h2>Laporan Karakter</h2>
                <p>Ringkasan perkembangan per anak berdasarkan periode yang dipilih</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="<?php echo $export_url; ?>" id="btnExportPdfKarakter" class="btn btn-export-primary"
                target="_blank" rel="noopener noreferrer">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <div class="data-panel mb-4">
        <div class="panel-header">
            <h3><i class="fas fa-filter"></i> Filter Periode Laporan</h3>
        </div>
        <div class="panel-body p-3">
            <form method="get" action="<?php echo site_url('admin/penilaian-karakter/laporan'); ?>">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="font-weight-bold text-muted">Jenis Periode</label>
                        <select name="period_type" id="periodType" class="form-control">
                            <option value="weekly" <?php echo $period_type === 'weekly' ? 'selected' : ''; ?>>Per Minggu
                            </option>
                            <option value="monthly" <?php echo $period_type === 'monthly' ? 'selected' : ''; ?>>Per Bulan
                            </option>
                            <option value="range" <?php echo $period_type === 'range' ? 'selected' : ''; ?>>Range Tanggal
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 form-group filter-weekly filter-monthly">
                        <label class="font-weight-bold text-muted">Tahun</label>
                        <select name="year" class="form-control">
                            <?php foreach ($years as $y): ?>
                                <option value="<?php echo $y; ?>" <?php echo ((int) $year === (int) $y) ? 'selected' : ''; ?>>
                                    <?php echo $y; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2 form-group filter-weekly">
                        <label class="font-weight-bold text-muted">Minggu</label>
                        <select name="week" class="form-control">
                            <?php for ($w = 1; $w <= 53; $w++): ?>
                                <option value="<?php echo $w; ?>" <?php echo ((int) $week === $w) ? 'selected' : ''; ?>>Minggu
                                    <?php echo $w; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-2 form-group filter-monthly">
                        <label class="font-weight-bold text-muted">Bulan</label>
                        <select name="month" class="form-control">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?php echo $m; ?>" <?php echo ((int) $month === $m) ? 'selected' : ''; ?>>
                                    <?php echo $m; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-2 form-group filter-range">
                        <label class="font-weight-bold text-muted">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" value="<?php echo $start_date; ?>">
                    </div>

                    <div class="col-md-2 form-group filter-range">
                        <label class="font-weight-bold text-muted">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="end_date" value="<?php echo $end_date; ?>">
                    </div>

                    <div class="col-md-1 form-group d-flex align-items-end">
                        <button type="submit" class="btn btn-filter w-100"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card stat-blue">
            <div class="stat-icon"><i class="fas fa-child"></i></div>
            <div class="stat-info">
                <span class="stat-number"><?php echo (int) $total_children; ?></span>
                <span class="stat-label">Anak Terlapor</span>
            </div>
        </div>
        <div class="stat-card stat-green">
            <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <div class="stat-info">
                <span class="stat-number"><?php echo (int) $total_assessments; ?></span>
                <span class="stat-label">Total Penilaian</span>
            </div>
        </div>
        <div class="stat-card stat-orange">
            <div class="stat-icon"><i class="fas fa-chart-bar"></i></div>
            <div class="stat-info">
                <span class="stat-number"><?php echo number_format((float) $overall_avg, 2); ?></span>
                <span class="stat-label">Rata-rata Perkembangan</span>
            </div>
        </div>
    </div>

    <div class="data-panel">
        <div class="panel-header">
            <h3><i class="fas fa-table"></i> Ringkasan Perkembangan per Anak</h3>
            <span class="period-chip"><?php echo $period_label; ?></span>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Anak</th>
                            <th style="width: 170px;" class="text-center">Total Penilaian</th>
                            <th style="width: 170px;" class="text-center">Rata-rata Skor</th>
                            <th style="width: 240px;">Kategori Perkembangan</th>
                            <th style="width: 170px;" class="text-center">Update Terakhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($summary_rows)): ?>
                            <?php $no = 1;
                            foreach ($summary_rows as $row): ?>
                                <tr>
                                    <td class="text-center"><?php echo $no++; ?></td>
                                    <td><?php echo $row->nama_anak; ?></td>
                                    <td class="text-center"><?php echo (int) $row->total_penilaian; ?></td>
                                    <td class="text-center"><?php echo number_format((float) $row->avg_score, 2); ?></td>
                                    <td><?php echo $row->kategori; ?></td>
                                    <td class="text-center">
                                        <?php echo !empty($row->tanggal_terakhir) ? date('d-m-Y', strtotime($row->tanggal_terakhir)) : '-'; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data perkembangan untuk periode
                                    ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        function toggleFilterFields() {
            var periodType = document.getElementById('periodType').value;
            var weeklyFields = document.querySelectorAll('.filter-weekly');
            var monthlyFields = document.querySelectorAll('.filter-monthly');
            var rangeFields = document.querySelectorAll('.filter-range');

            weeklyFields.forEach(function (el) { el.style.display = (periodType === 'weekly') ? '' : 'none'; });
            monthlyFields.forEach(function (el) { el.style.display = (periodType === 'monthly') ? '' : 'none'; });
            rangeFields.forEach(function (el) { el.style.display = (periodType === 'range') ? '' : 'none'; });
        }

        document.getElementById('periodType').addEventListener('change', toggleFilterFields);
        toggleFilterFields();

        var exportBtn = document.getElementById('btnExportPdfKarakter');
        if (exportBtn) {
            exportBtn.addEventListener('click', function (e) {
                if (!('serviceWorker' in navigator)) {
                    return;
                }

                e.preventDefault();
                var href = exportBtn.getAttribute('href');

                navigator.serviceWorker.getRegistrations().then(function (registrations) {
                    var jobs = registrations.map(function (registration) {
                        return registration.unregister();
                    });

                    return Promise.all(jobs);
                }).finally(function () {
                    window.open(href, '_blank', 'noopener,noreferrer');
                });
            });
        }
    })();
</script>

<style>
    .character-master-page {
        padding: 10px;
    }

    .character-master-page .page-header {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .character-master-page .header-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .character-master-page .header-actions {
        display: flex;
        gap: 12px;
    }

    .character-master-page .btn-export-primary {
        padding: 10px 20px;
        background: #4e73df;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 500;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .character-master-page .btn-export-primary:hover {
        background: #2e59d9;
        color: #fff;
    }

    .character-master-page .header-icon {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .character-master-page .bg-purple {
        background: rgba(111, 66, 193, .12);
        color: #6f42c1;
    }

    .character-master-page .header-info h2 {
        margin: 0 0 5px;
        font-size: 22px;
        font-weight: 600;
        color: #2d3748;
    }

    .character-master-page .header-info p {
        margin: 0;
        color: #718096;
        font-size: 14px;
    }

    .character-master-page .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .character-master-page .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
    }

    .character-master-page .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .character-master-page .stat-blue .stat-icon {
        background: rgba(78, 115, 223, .1);
        color: #4e73df;
    }

    .character-master-page .stat-green .stat-icon {
        background: rgba(28, 200, 138, .1);
        color: #1cc88a;
    }

    .character-master-page .stat-orange .stat-icon {
        background: rgba(246, 194, 62, .1);
        color: #f6c23e;
    }

    .character-master-page .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
        line-height: 1;
    }

    .character-master-page .stat-label {
        font-size: 13px;
        color: #718096;
        margin-top: 5px;
        display: block;
    }

    .character-master-page .data-panel {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
    }

    .character-master-page .period-chip {
        background: #f8fafc;
        color: #4a5568;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        font-size: 12px;
        padding: 6px 12px;
        font-weight: 600;
    }

    .character-master-page .btn-filter {
        background: #4e73df;
        color: #fff;
        border: none;
        border-radius: 8px;
        height: 38px;
    }

    .character-master-page .btn-filter:hover {
        background: #2e59d9;
        color: #fff;
    }

    .character-master-page .panel-header {
        padding: 20px 25px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .character-master-page .panel-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .character-master-page .panel-header i {
        color: #4e73df;
    }

    .character-master-page .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .character-master-page .data-table th {
        padding: 15px 20px;
        font-size: 12px;
        font-weight: 600;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: .5px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .character-master-page .data-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
        font-size: 14px;
        color: #2d3748;
    }

    .character-master-page .data-table tbody tr:hover {
        background: #f8fafc;
    }

    @media (max-width: 992px) {
        .character-master-page .page-header {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .character-master-page .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>