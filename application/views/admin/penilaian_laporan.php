<div class="admin-perkembangan-page">
    <div class="page-header-card d-flex justify-content-between align-items-start flex-wrap">
        <div>
            <h2>Laporan Karakter</h2>
            <p>Format admin mengikuti tampilan Perkembangan Guru dengan insight lebih lengkap untuk monitoring lintas
                assessor.</p>
        </div>
        <form method="post" action="<?php echo $export_url; ?>" id="formExportPdfKarakter" class="mt-2 mt-md-0"
            target="_blank" rel="noopener noreferrer">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="period_type"
                value="<?php echo htmlspecialchars($period_type, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="year" value="<?php echo (int) $year; ?>">
            <input type="hidden" name="week" value="<?php echo (int) $week; ?>">
            <input type="hidden" name="month" value="<?php echo (int) $month; ?>">
            <input type="hidden" name="start_date"
                value="<?php echo htmlspecialchars($start_date, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="end_date"
                value="<?php echo htmlspecialchars($end_date, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="radar_chart_image" id="radar_chart_image" value="">
            <input type="hidden" name="aspect_trend_images" id="aspect_trend_images" value="">
            <button type="submit" id="btnExportPdfKarakter" class="btn btn-danger">
                <i class="fas fa-file-pdf mr-1"></i> Export PDF
            </button>
        </form>
    </div>

    <div class="stats-row">
        <div class="small-box-card box-blue">
            <div class="label">Total Anak</div>
            <div class="value"><?php echo (int) $total_children; ?></div>
        </div>
        <div class="small-box-card box-green">
            <div class="label">Anak Dinilai</div>
            <div class="value"><?php echo (int) $assessed_children; ?></div>
        </div>
        <div class="small-box-card box-orange">
            <div class="label">Rata-rata Umum</div>
            <div class="value"><?php echo number_format((float) $overall_avg, 2); ?></div>
        </div>
        <div class="small-box-card box-red">
            <div class="label">Perlu Dukungan</div>
            <div class="value"><?php echo (int) $need_support_count; ?></div>
        </div>
    </div>

    <div class="card-panel mb-4">
        <div class="panel-header">
            <h3><i class="fas fa-filter text-info"></i> Filter Periode</h3>
        </div>
        <div class="panel-body form-body">
            <form method="get" action="<?php echo site_url('admin/penilaian-karakter/laporan'); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Periode</label>
                            <select name="period_type" class="form-control" id="period_type">
                                <option value="weekly" <?php echo $period_type === 'weekly' ? 'selected' : ''; ?>>Mingguan
                                </option>
                                <option value="monthly" <?php echo $period_type === 'monthly' ? 'selected' : ''; ?>>
                                    Bulanan</option>
                                <option value="range" <?php echo $period_type === 'range' ? 'selected' : ''; ?>>Rentang
                                    Tanggal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 period-weekly period-monthly">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select name="year" class="form-control">
                                <?php foreach ($years as $item_year): ?>
                                    <option value="<?php echo $item_year; ?>" <?php echo (int) $year === (int) $item_year ? 'selected' : ''; ?>><?php echo $item_year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 period-weekly">
                        <div class="form-group">
                            <label>Minggu</label>
                            <input type="number" name="week" min="1" max="53" class="form-control"
                                value="<?php echo (int) $week; ?>">
                        </div>
                    </div>
                    <div class="col-md-2 period-monthly">
                        <div class="form-group">
                            <label>Bulan</label>
                            <input type="number" name="month" min="1" max="12" class="form-control"
                                value="<?php echo (int) $month; ?>">
                        </div>
                    </div>
                    <div class="col-md-2 period-range">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control"
                                value="<?php echo $start_date; ?>">
                        </div>
                    </div>
                    <div class="col-md-2 period-range">
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control" value="<?php echo $end_date; ?>">
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-info btn-block"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-panel mb-4">
        <div class="panel-header d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-bullseye text-success"></i> Grafik Radar Rata-rata Aspek</h3>
            <span class="period-chip"><?php echo $period_label; ?></span>
        </div>
        <div class="panel-body form-body">
            <div class="chart-wrap">
                <canvas id="radarAspectChart"></canvas>
            </div>
            <small class="text-muted d-block mt-2">Grafik menunjukkan rerata tiap aspek dari seluruh anak pada periode
                terpilih.</small>
        </div>
    </div>

    <?php if (!empty($aspects)): ?>
        <?php foreach ($aspects as $aspect): ?>
            <?php $trend_data = $aspect_trend_chart_data[(int) $aspect->id_aspect] ?? array('labels' => array(), 'datasets' => array()); ?>
            <div class="card-panel mb-4">
                <div class="panel-header">
                    <h3><i class="fas fa-wave-square text-primary"></i> Grafik Tren Aspek - <?php echo $aspect->aspect_name; ?>
                    </h3>
                </div>
                <div class="panel-body form-body">
                    <?php if (!empty($trend_data['labels']) && !empty($trend_data['datasets'])): ?>
                        <div class="chart-wrap indicator-trend-wrap">
                            <canvas id="aspectTrendChart<?php echo (int) $aspect->id_aspect; ?>"></canvas>
                        </div>
                        <small class="text-muted d-block mt-2">Tren ini adalah agregasi seluruh nilai siswa untuk aspek
                            <?php echo $aspect->aspect_name; ?>.</small>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">Belum ada data tren untuk aspek ini pada periode terpilih.</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="card-panel">
        <div class="panel-header">
            <h3><i class="fas fa-table text-primary"></i> Skor Tiap Aspek per Anak</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 perkembangan-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anak</th>
                            <th>Pendidikan</th>
                            <?php foreach ($aspects as $aspect): ?>
                                <th class="text-center"><?php echo $aspect->aspect_name; ?></th>
                            <?php endforeach; ?>
                            <th class="text-center">Total Penilaian</th>
                            <th class="text-center">Rata-rata</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Terakhir Dinilai</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($table_rows as $index => $row): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $row['nama_anak']; ?></td>
                                <td><?php echo !empty($row['pendidikan']) ? $row['pendidikan'] : '-'; ?></td>
                                <?php foreach ($aspects as $aspect): ?>
                                    <?php
                                    $score = $row['aspect_scores'][(int) $aspect->id_aspect] ?? null;
                                    $score_class = 'badge-secondary';
                                    if ($score !== null) {
                                        if ($score >= 3.5) {
                                            $score_class = 'badge-success';
                                        } elseif ($score >= 2.5) {
                                            $score_class = 'badge-primary';
                                        } elseif ($score >= 1.5) {
                                            $score_class = 'badge-warning';
                                        } else {
                                            $score_class = 'badge-danger';
                                        }
                                    }
                                    ?>
                                    <td class="text-center">
                                        <?php if ($score !== null): ?>
                                            <span
                                                class="badge badge-pill <?php echo $score_class; ?>"><?php echo number_format((float) $score, 2); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                                <td class="text-center"><?php echo (int) $row['total_penilaian']; ?></td>
                                <td class="text-center">
                                    <?php if ($row['avg_score'] !== null): ?>
                                        <strong><?php echo number_format((float) $row['avg_score'], 2); ?></strong>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo $row['kategori']; ?></td>
                                <td class="text-center">
                                    <?php echo !empty($row['tanggal_terakhir']) ? date('d-m-Y', strtotime($row['tanggal_terakhir'])) : '-'; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo site_url('admin/penilaian-karakter/laporan/detail/' . (int) $row['id_anak'] . '?' . http_build_query(array('period_type' => $period_type, 'year' => $year, 'week' => $week, 'month' => $month, 'start_date' => $start_date, 'end_date' => $end_date))); ?>"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($table_rows)): ?>
                            <tr>
                                <td colspan="<?php echo count($aspects) + 9; ?>" class="text-center py-4 text-muted">Belum
                                    ada data anak pada periode ini.</td>
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

        function initRadarChart() {
            var canvas = document.getElementById('radarAspectChart');
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
                        label: 'Rata-rata Aspek (Admin)',
                        data: scores,
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78,115,223,0.20)',
                        borderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#4e73df',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        r: {
                            min: 0,
                            max: 4,
                            ticks: { stepSize: 0.5 }
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

                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: chartData.datasets[0].label,
                            data: chartData.datasets[0].data,
                            borderColor: '#4e73df',
                            backgroundColor: 'rgba(78, 115, 223, 0.10)',
                            borderWidth: 3,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            tension: 0.3,
                            spanGaps: true,
                            fill: false
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                min: 0,
                                max: 4,
                                ticks: { stepSize: 0.5 },
                                title: {
                                    display: true,
                                    text: 'Skor Rata-rata'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal Penilaian'
                                }
                            }
                        }
                    }
                });
            });
        }

        function getCanvasDataUrl(canvasId) {
            var canvas = document.getElementById(canvasId);
            if (!canvas || typeof canvas.toDataURL !== 'function') {
                return '';
            }

            try {
                return canvas.toDataURL('image/png');
            } catch (err) {
                return '';
            }
        }

        function collectAspectTrendImages() {
            var result = {};
            var chartDataMap = <?php echo json_encode($aspect_trend_chart_data); ?>;

            Object.keys(chartDataMap).forEach(function (aspectId) {
                var canvasId = 'aspectTrendChart' + aspectId;
                var imageData = getCanvasDataUrl(canvasId);
                if (imageData) {
                    result[aspectId] = imageData;
                }
            });

            return result;
        }

        document.addEventListener('DOMContentLoaded', function () {
            var period = document.getElementById('period_type');
            if (period) {
                period.addEventListener('change', updatePeriodFields);
            }

            updatePeriodFields();
            initRadarChart();
            initAspectTrendCharts();

            var exportBtn = document.getElementById('btnExportPdfKarakter');
            var exportForm = document.getElementById('formExportPdfKarakter');
            if (exportBtn && exportForm) {
                exportBtn.addEventListener('click', function (e) {
                    var radarImageInput = document.getElementById('radar_chart_image');
                    var aspectTrendImagesInput = document.getElementById('aspect_trend_images');

                    if (radarImageInput) {
                        radarImageInput.value = getCanvasDataUrl('radarAspectChart');
                    }

                    if (aspectTrendImagesInput) {
                        aspectTrendImagesInput.value = JSON.stringify(collectAspectTrendImages());
                    }

                    if (!('serviceWorker' in navigator)) {
                        return;
                    }

                    e.preventDefault();

                    navigator.serviceWorker.getRegistrations().then(function (registrations) {
                        var jobs = registrations.map(function (registration) {
                            return registration.unregister();
                        });

                        return Promise.all(jobs);
                    }).finally(function () {
                        exportForm.submit();
                    });
                });
            }
        });
    })();
</script>

<style>
    .admin-perkembangan-page {
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

    .page-header-card p {
        margin: 6px 0 0;
        color: #6b7280;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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

    .box-red {
        border-left-color: #e74a3b;
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

    .period-chip {
        background: #f8fafc;
        color: #4a5568;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        font-size: 12px;
        padding: 6px 12px;
        font-weight: 600;
    }

    .period-range {
        display: none;
    }

    .chart-wrap {
        position: relative;
        height: 360px;
    }

    .indicator-trend-wrap {
        height: 300px;
    }

    .perkembangan-table thead th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: 1fr;
        }

        .chart-wrap {
            height: 280px;
        }

        .indicator-trend-wrap {
            height: 250px;
        }
    }
</style>
