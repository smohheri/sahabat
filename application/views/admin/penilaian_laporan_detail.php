<div class="admin-karakter-detail-page">
    <?php if (!$schema_ready): ?>
        <div class="alert alert-warning mb-4">
            <i class="fas fa-database mr-1"></i>
            Data detail perkembangan belum tersedia karena tabel penilaian karakter belum lengkap.
        </div>
    <?php endif; ?>

    <div class="page-header-card d-flex justify-content-between align-items-start flex-wrap">
        <div>
            <h2>Detail Laporan Karakter Anak</h2>
            <p class="mb-1"><strong><?php echo $anak->nama_anak; ?></strong></p>
            <p class="text-muted mb-0">
                Pendidikan: <?php echo !empty($anak->pendidikan) ? $anak->pendidikan : '-'; ?> |
                Status: <?php echo !empty($anak->status_anak) ? $anak->status_anak : '-'; ?>
            </p>
        </div>
        <div class="d-flex mt-2 mt-md-0">
            <form id="exportPdfForm" method="post"
                action="<?php echo site_url('admin/penilaian-karakter/laporan/detail/' . (int) $anak->id_anak . '/export-pdf'); ?>"
                class="mr-2">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                    value="<?php echo $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="period_type" value="<?php echo $filters['period_type']; ?>">
                <input type="hidden" name="year" value="<?php echo (int) $filters['year']; ?>">
                <input type="hidden" name="week" value="<?php echo (int) $filters['week']; ?>">
                <input type="hidden" name="month" value="<?php echo (int) $filters['month']; ?>">
                <input type="hidden" name="start_date" value="<?php echo $filters['start_date']; ?>">
                <input type="hidden" name="end_date" value="<?php echo $filters['end_date']; ?>">
                <input type="hidden" name="radar_chart_image" id="radarChartImage">
                <input type="hidden" name="aspect_chart_images" id="aspectChartImages">
                <button type="submit" class="btn btn-danger" id="exportPdfButton">
                    <i class="fas fa-file-pdf mr-1"></i> Export PDF
                </button>
            </form>
            <a href="<?php echo $back_url; ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="stats-row">
        <div class="small-box-card box-blue">
            <div class="label">Rata-rata Aspek</div>
            <div class="value"><?php echo number_format((float) $overall_avg, 2); ?></div>
        </div>
        <div class="small-box-card box-green">
            <div class="label">Total Penilaian</div>
            <div class="value"><?php echo (int) $total_assessments; ?></div>
        </div>
        <div class="small-box-card box-orange">
            <div class="label">Total Aspek Dinilai</div>
            <div class="value"><?php echo count($aspect_groups); ?></div>
        </div>
    </div>

    <?php
    $radar_labels = array();
    $radar_scores = array();
    foreach ($aspect_groups as $aspect) {
        $radar_labels[] = $aspect['aspect_name'];
        $radar_scores[] = $aspect['aspect_avg'] !== null ? round((float) $aspect['aspect_avg'], 2) : 0;
    }
    ?>

    <div class="card-panel mb-4">
        <div class="panel-header">
            <h3><i class="fas fa-bullseye text-success"></i> Grafik Radar Nilai Per Aspek</h3>
        </div>
        <div class="panel-body form-body">
            <?php if (!empty($radar_labels)): ?>
                <div class="chart-wrap">
                    <canvas id="trendChart"></canvas>
                </div>
            <?php else: ?>
                <div class="text-center text-muted py-4">Belum ada data aspek yang cukup untuk ditampilkan dalam grafik.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php foreach ($aspect_groups as $aspect): ?>
        <?php $chart_data = $aspect_trend_chart_data[$aspect['id_aspect']] ?? array('labels' => array(), 'datasets' => array()); ?>
        <div class="card-panel mb-4">
            <div class="panel-header">
                <h3><i class="fas fa-wave-square text-primary"></i> Tren Indikator - <?php echo $aspect['aspect_name']; ?>
                </h3>
            </div>
            <div class="panel-body form-body">
                <?php if (!empty($chart_data['labels']) && !empty($chart_data['datasets'])): ?>
                    <div class="chart-wrap indicator-trend-wrap">
                        <canvas id="aspectTrendChart<?php echo (int) $aspect['id_aspect']; ?>"></canvas>
                    </div>
                <?php else: ?>
                    <div class="text-center text-muted py-4">Belum ada data tren indikator untuk aspek ini pada periode
                        terpilih.</div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="card-panel mb-4">
        <div class="panel-header">
            <h3><i class="fas fa-filter text-info"></i> Filter Periode</h3>
        </div>
        <div class="panel-body form-body">
            <form method="get"
                action="<?php echo site_url('admin/penilaian-karakter/laporan/detail/' . (int) $anak->id_anak); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Periode</label>
                            <select name="period_type" class="form-control" id="period_type">
                                <option value="weekly" <?php echo $filters['period_type'] === 'weekly' ? 'selected' : ''; ?>>Mingguan</option>
                                <option value="monthly" <?php echo $filters['period_type'] === 'monthly' ? 'selected' : ''; ?>>Bulanan</option>
                                <option value="range" <?php echo $filters['period_type'] === 'range' ? 'selected' : ''; ?>>Rentang Tanggal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 period-weekly period-monthly">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select name="year" class="form-control">
                                <?php foreach ($years as $item_year): ?>
                                    <option value="<?php echo $item_year; ?>" <?php echo (int) $filters['year'] === (int) $item_year ? 'selected' : ''; ?>><?php echo $item_year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 period-weekly">
                        <div class="form-group">
                            <label>Minggu</label>
                            <input type="number" name="week" min="1" max="53" class="form-control"
                                value="<?php echo (int) $filters['week']; ?>">
                        </div>
                    </div>
                    <div class="col-md-2 period-monthly">
                        <div class="form-group">
                            <label>Bulan</label>
                            <input type="number" name="month" min="1" max="12" class="form-control"
                                value="<?php echo (int) $filters['month']; ?>">
                        </div>
                    </div>
                    <div class="col-md-2 period-range">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control"
                                value="<?php echo $filters['start_date']; ?>">
                        </div>
                    </div>
                    <div class="col-md-2 period-range">
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control"
                                value="<?php echo $filters['end_date']; ?>">
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-info btn-block"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php foreach ($aspect_groups as $aspect): ?>
        <div class="card-panel mb-4">
            <div class="panel-header d-flex justify-content-between align-items-center">
                <h3><i class="fas fa-layer-group text-primary"></i> <?php echo $aspect['aspect_name']; ?></h3>
                <span class="badge badge-pill badge-primary">Rata-rata Aspek:
                    <?php echo $aspect['aspect_avg'] !== null ? number_format((float) $aspect['aspect_avg'], 2) : '-'; ?></span>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Indikator</th>
                                <th>Kode</th>
                                <th class="text-center">Skor Rata-rata</th>
                                <th class="text-center">Jumlah Data</th>
                                <th class="text-center">Terakhir Dinilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aspect['indicators'] as $i => $indicator): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo $indicator['indicator_name']; ?></td>
                                    <td><?php echo !empty($indicator['indicator_code']) ? $indicator['indicator_code'] : '-'; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $indicator['avg_score'] !== null ? number_format((float) $indicator['avg_score'], 2) : '-'; ?>
                                    </td>
                                    <td class="text-center"><?php echo (int) $indicator['score_count']; ?></td>
                                    <td class="text-center">
                                        <?php echo !empty($indicator['last_assessed_at']) ? date('d-m-Y', strtotime($indicator['last_assessed_at'])) : '-'; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($aspect['indicators'])): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data indikator.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="card-panel">
        <div class="panel-header">
            <h3><i class="fas fa-history text-secondary"></i> Riwayat Penilaian Anak</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Minggu / Bulan / Tahun</th>
                            <th>Assessor</th>
                            <th class="text-center">Rata-rata</th>
                            <th class="text-center">Total Indikator</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history_rows as $item): ?>
                            <tr>
                                <td>#<?php echo (int) $item->id_assessment; ?></td>
                                <td><?php echo !empty($item->assessment_date) ? date('d-m-Y', strtotime($item->assessment_date)) : '-'; ?>
                                </td>
                                <td><?php echo (int) $item->week_number; ?> / <?php echo (int) $item->month; ?> /
                                    <?php echo (int) $item->year; ?>
                                </td>
                                <td><?php echo !empty($item->assessor_name) ? $item->assessor_name : '-'; ?>
                                    (<?php echo !empty($item->assessor_type) ? ucfirst($item->assessor_type) : '-'; ?>)</td>
                                <td class="text-center">
                                    <?php echo $item->avg_score !== null ? number_format((float) $item->avg_score, 2) : '-'; ?>
                                </td>
                                <td class="text-center"><?php echo (int) $item->total_indicator; ?></td>
                                <td><?php echo ucfirst($item->status); ?></td>
                                <td><?php echo !empty($item->notes) ? (strlen(strip_tags($item->notes)) > 70 ? substr(strip_tags($item->notes), 0, 70) . '...' : strip_tags($item->notes)) : '-'; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($history_rows)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada riwayat penilaian untuk
                                    periode ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-karakter-detail-page {
        padding: 10px;
    }

    .page-header-card {
        background: #fff;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        margin-bottom: 20px;
    }

    .page-header-card h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .small-box-card {
        background: #fff;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-left: 4px solid #4e73df;
    }

    .small-box-card .label {
        font-size: 13px;
        color: #718096;
    }

    .small-box-card .value {
        font-size: 28px;
        font-weight: 700;
        line-height: 1.2;
    }

    .box-blue {
        border-left-color: #4e73df;
    }

    .box-green {
        border-left-color: #1cc88a;
    }

    .box-orange {
        border-left-color: #f6c23e;
    }

    .card-panel {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .panel-header {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
    }

    .panel-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .panel-body {
        padding: 0;
    }

    .form-body {
        padding: 20px;
    }

    .period-range {
        display: none;
    }

    .chart-wrap {
        position: relative;
        height: 340px;
    }

    .indicator-trend-wrap {
        height: 300px;
    }

    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: 1fr;
        }

        .chart-wrap {
            height: 280px;
        }

        .indicator-trend-wrap {
            height: 260px;
        }
    }
</style>

<script>
    (function () {
        function buildPalette(index) {
            var colors = [
                { border: '#4e73df', bg: 'rgba(78, 115, 223, 0.10)' },
                { border: '#1cc88a', bg: 'rgba(28, 200, 138, 0.10)' },
                { border: '#f6c23e', bg: 'rgba(246, 194, 62, 0.10)' },
                { border: '#e74a3b', bg: 'rgba(231, 74, 59, 0.10)' },
                { border: '#6f42c1', bg: 'rgba(111, 66, 193, 0.10)' },
                { border: '#20c997', bg: 'rgba(32, 201, 151, 0.10)' }
            ];

            return colors[index % colors.length];
        }

        function initTrendChart() {
            var canvas = document.getElementById('trendChart');
            if (!canvas || typeof Chart === 'undefined') {
                return;
            }

            var labels = <?php echo json_encode($radar_labels); ?>;
            var scores = <?php echo json_encode($radar_scores); ?>;

            if (!labels.length || !scores.length) {
                return;
            }

            new Chart(canvas, {
                type: 'radar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nilai Per Aspek',
                        data: scores,
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.20)',
                        borderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#4e73df',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            min: 0,
                            max: 4,
                            ticks: {
                                stepSize: 0.5
                            }
                        }
                    }
                }
            });
        }

        function initAspectTrendCharts() {
            if (typeof Chart === 'undefined') {
                return;
            }

            var chartDataMap = <?php echo json_encode($aspect_trend_chart_data); ?>;
            Object.keys(chartDataMap).forEach(function (aspectId) {
                var canvas = document.getElementById('aspectTrendChart' + aspectId);
                if (!canvas) {
                    return;
                }

                var chartData = chartDataMap[aspectId];
                if (!chartData || !chartData.labels || !chartData.datasets || !chartData.labels.length || !chartData.datasets.length) {
                    return;
                }

                var datasets = chartData.datasets.map(function (item, idx) {
                    var palette = buildPalette(idx);
                    return {
                        label: item.label,
                        data: item.data,
                        borderColor: palette.border,
                        backgroundColor: palette.bg,
                        borderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        tension: 0.3,
                        spanGaps: true,
                        fill: false
                    };
                });

                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: datasets
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                min: 0,
                                max: 4,
                                ticks: {
                                    stepSize: 0.5
                                }
                            }
                        }
                    }
                });
            });
        }

        function updatePeriodFields() {
            var period = document.getElementById('period_type');
            if (!period) {
                return;
            }

            var value = period.value;
            var weeklyEls = document.querySelectorAll('.period-weekly');
            var monthlyEls = document.querySelectorAll('.period-monthly');
            var rangeEls = document.querySelectorAll('.period-range');

            weeklyEls.forEach(function (el) {
                el.style.display = (value === 'weekly') ? 'block' : 'none';
            });

            monthlyEls.forEach(function (el) {
                el.style.display = (value === 'monthly') ? 'block' : 'none';
            });

            rangeEls.forEach(function (el) {
                el.style.display = (value === 'range') ? 'block' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            var period = document.getElementById('period_type');
            if (period) {
                period.addEventListener('change', updatePeriodFields);
            }

            var exportForm = document.getElementById('exportPdfForm');
            if (exportForm) {
       exportForm.addEventListener('submit', function () {
                    var radarInput = document.getElementById('radarChartImage');
                    var aspectInput = document.getElementById('aspectChartImages');

                    var radarCanvas = document.getElementById('trendChart');
                    if (radarInput) {
                        radarInput.value = (radarCanvas && radarCanvas.toDataURL)
                            ? radarCanvas.toDataURL('image/png', 1.0)
                            : '';
                    }

                    var aspectCharts = [];
                    var chartDataMap = <?php echo json_encode($aspect_trend_chart_data); ?>;
                    Object.keys(chartDataMap).forEach(function (aspectId) {
                        var canvas = document.getElementById('aspectTrendChart' + aspectId);
                        if (!canvas || !canvas.toDataURL) {
                            return;
                        }

                        aspectCharts.push({
                            aspect_id: parseInt(aspectId, 10),
                            image: canvas.toDataURL('image/png', 1.0)
                        });
                    });

                    if (aspectInput) {
                        aspectInput.value = JSON.stringify(aspectCharts);
                    }
                });
            }

            updatePeriodFields();
            initTrendChart();
            initAspectTrendCharts();
        });
    })();
</script>
