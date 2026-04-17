<?php
$aspect_summary = array();
foreach ((array) $indicator_scores as $item) {
    $aspect_name = (string) ($item->aspect_name ?? 'Aspek');
    if (!isset($aspect_summary[$aspect_name])) {
        $aspect_summary[$aspect_name] = array('total' => 0.0, 'count' => 0);
    }

    $aspect_summary[$aspect_name]['total'] += (float) ($item->avg_score ?? 0);
    $aspect_summary[$aspect_name]['count']++;
}

$radar_labels = array_keys($aspect_summary);
$radar_scores = array();
foreach ($aspect_summary as $summary) {
    $radar_scores[] = $summary['count'] > 0 ? round($summary['total'] / $summary['count'], 2) : 0;
}
?>

<div class="anak-dashboard-radar">
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success w-100" role="alert">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger w-100" role="alert">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="data-panel w-100">
        <div class="panel-header radar-header">
            <h3>Penilaian Karakter Mandiri</h3>
            <p>Penilaian mandiri dilaksanakan 1 kali setiap bulan melalui halaman asesmen.</p>
        </div>
        <div class="panel-body radar-body">

        <?php if (!$schema_ready): ?>
            <div class="alert alert-warning mb-0">
                Modul penilaian karakter belum siap. Hubungi admin untuk menjalankan migrasi tabel penilaian.
            </div>
        <?php elseif ($already_submitted): ?>
            <div class="alert alert-info mb-0">
                Penilaian mandiri bulan <?php echo $current_month; ?>/<?php echo $current_year; ?> sudah dikirim.
                Silakan isi kembali pada bulan berikutnya.
            </div>
            <a href="<?php echo site_url('anak/asesmen-mandiri'); ?>" class="btn btn-outline-primary mt-3">
                Lihat Halaman Asesmen
            </a>
        <?php else: ?>
            <div class="alert alert-success mb-0">
                Penilaian mandiri bulan <?php echo $current_month; ?>/<?php echo $current_year; ?> belum diisi.
                Silakan lanjut ke halaman asesmen untuk melakukan pengisian.
            </div>
            <a href="<?php echo site_url('anak/asesmen-mandiri'); ?>" class="btn btn-primary mt-3">
                Isi Asesmen Mandiri Bulanan
            </a>
        <?php endif; ?>
        </div>
    </div>

    <div class="data-panel">
        <div class="panel-header radar-header">
            <h3>Grafik Radar Bulan Berjalan</h3>
            <p><?php echo html_escape($anak->nama_anak); ?> - <?php echo $current_month; ?>/<?php echo $current_year; ?>
            </p>
        </div>
        <div class="panel-body radar-body">

        <?php if (!empty($radar_labels)): ?>
            <div class="radar-canvas-wrap">
                <canvas id="anakRadarChart"></canvas>
            </div>
        <?php else: ?>
            <div class="alert alert-info mb-0">
                Data penilaian belum tersedia sehingga grafik radar belum dapat ditampilkan.
            </div>
        <?php endif; ?>
        </div>
    </div>

    <div class="data-panel">
        <div class="panel-header radar-header">
            <h3>Deskripsi Dinamis Perkembangan</h3>
            <p>Ringkasan otomatis berdasarkan data penilaian karakter dan catatan guru yang sudah tersimpan.</p>
        </div>
        <div class="panel-body radar-body">

        <div class="dynamic-insight">
            <h4>Kondisi Saat Ini</h4>
            <p><?php echo html_escape($summary_description); ?></p>
        </div>

        <div class="dynamic-insight improvement">
            <h4>Perbaikan yang Diperlukan</h4>
            <p><?php echo html_escape($improvement_description); ?></p>
            <?php if (!empty($latest_note) && !empty($latest_note->assessment_date)): ?>
                <small class="text-muted">Sumber data: catatan
                    guru<?php echo !empty($latest_note->assessor_name) ? ' (' . html_escape($latest_note->assessor_name) . ')' : ''; ?>
                    pada
                    <?php echo date('d-m-Y', strtotime($latest_note->assessment_date)); ?></small>
            <?php endif; ?>
        </div>
        </div>
    </div>
</div>

<style>
    .anak-dashboard-radar {
        display: flex;
        flex-direction: column;
        gap: 14px;
        justify-content: center;
    }

    .anak-dashboard-radar .data-panel {
        width: 100%;
        max-width: 980px;
        margin-bottom: 0;
    }

    .radar-header {
        display: block;
    }

    .radar-header h3,
    .panel-header.radar-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .radar-header p,
    .panel-header.radar-header p {
        margin: 4px 0 0;
    }

    .radar-body {
        padding-top: 18px;
    }

    .radar-canvas-wrap {
        position: relative;
        min-height: 420px;
    }

    .dynamic-insight {
        background: var(--panel-bg-soft);
        border: 1px solid var(--panel-border);
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 10px;
    }

    .dynamic-insight h4 {
        margin: 0 0 6px;
        font-size: 0.98rem;
        color: var(--panel-heading);
    }

    .dynamic-insight p {
        margin: 0;
        color: var(--panel-text-soft);
        line-height: 1.5;
    }

    .dynamic-insight.improvement {
        background: rgba(246, 194, 62, 0.1);
        border-color: rgba(246, 194, 62, 0.45);
    }

    body.dark-mode .dynamic-insight {
        background: #1a2c4d;
        border-color: #31537e;
    }

    body.dark-mode .dynamic-insight.improvement {
        background: rgba(246, 194, 62, 0.14);
        border-color: rgba(246, 194, 62, 0.4);
    }

    body.dark-mode .radar-header h3,
    body.dark-mode .panel-header.radar-header h3,
    body.dark-mode .dynamic-insight h4 {
        color: #f8fafc;
    }

    body.dark-mode .radar-header p,
    body.dark-mode .panel-header.radar-header p,
    body.dark-mode .dynamic-insight p,
    body.dark-mode .dynamic-insight small.text-muted {
        color: #dbeafe !important;
    }

    @media (max-width: 992px) {
        .radar-canvas-wrap {
            min-height: 320px;
        }
    }
</style>

<?php if (!empty($radar_labels)): ?>
    <script>
        (function () {
            var ctx = document.getElementById('anakRadarChart');
            if (!ctx || typeof Chart === 'undefined') {
                return;
            }

            var isDarkMode = document.body.classList.contains('dark-mode');
            var radarPointLabelColor = isDarkMode ? '#dbeafe' : '#334155';
            var radarGridColor = isDarkMode ? 'rgba(147, 197, 253, 0.28)' : 'rgba(148, 163, 184, 0.35)';
            var radarTickColor = isDarkMode ? '#bfdbfe' : '#475569';
            var radarLegendColor = isDarkMode ? '#dbeafe' : '#334155';

            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: <?php echo json_encode(array_values($radar_labels)); ?>,
                    datasets: [{
                        label: 'Skor Rata-rata',
                        data: <?php echo json_encode($radar_scores); ?>,
                        backgroundColor: 'rgba(13, 148, 136, 0.24)',
                        borderColor: '#0d9488',
                        borderWidth: 2,
                        pointBackgroundColor: '#0f766e',
                        pointBorderColor: '#ffffff',
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            beginAtZero: true,
                            suggestedMax: 4,
                            ticks: {
                                stepSize: 1,
                                backdropColor: 'transparent',
                                color: radarTickColor
                            },
                            pointLabels: {
                                color: radarPointLabelColor,
                                font: {
                                    size: 12,
                                    weight: '600'
                                }
                            },
                            grid: {
                                color: radarGridColor
                            },
                            angleLines: {
                                color: radarGridColor
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: radarLegendColor
                            }
                        }
                    }
                }
            });
        })();
    </script>
<?php endif; ?>
