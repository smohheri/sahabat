<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    .title {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin: 8px 0 2px;
        text-transform: uppercase;
    }

    .subtitle {
        text-align: center;
        font-size: 11px;
        margin-bottom: 12px;
    }

    .meta {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
        font-size: 10px;
    }

    .meta td {
        border: 1px solid #d9d9d9;
        padding: 4px 6px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9px;
    }

    .table th,
    .table td {
        border: 1px solid #333;
        padding: 4px 5px;
    }

    .table th {
        background: #f0f0f0;
        text-align: center;
        font-weight: bold;
    }

    .text-center {
        text-align: center;
    }

    .chart-block {
        margin-bottom: 12px;
        text-align: center;
    }

    .chart-image {
        width: 88%;
        max-width: 88%;
        border: 1px solid #d9d9d9;
        padding: 4px;
        background: #fff;
    }

    .chart-title {
        font-size: 10px;
        font-weight: bold;
        margin: 3px 0 5px;
    }

    .section-title {
        font-size: 12px;
        font-weight: bold;
        margin: 10px 0 6px;
    }
</style>

<div class="title">Laporan Karakter Anak - Rekapan Keseluruhan Aspek</div>
<div class="subtitle"><?php echo strtoupper($settings->nama_lksa ?? 'LKSA HARAPAN BANGSA'); ?></div>

<table class="meta">
    <tr>
        <td style="width: 22%;"><strong>Periode Laporan</strong></td>
        <td style="width: 78%;"><?php echo $period_label; ?></td>
    </tr>
    <tr>
        <td><strong>Tanggal Cetak</strong></td>
        <td><?php echo tanggal_indo(date('Y-m-d H:i:s')); ?></td>
    </tr>
    <tr>
        <td><strong>Keterangan</strong></td>
        <td>Rekapan nilai rata-rata tiap aspek per anak.</td>
    </tr>
</table>

<?php if (!empty($radar_chart_image) || !empty($aspect_trend_images)): ?>
    <div class="section-title">Visualisasi Grafik</div>

    <?php if (!empty($radar_chart_image)): ?>
        <div class="chart-block">
            <div class="chart-title">Grafik Radar Rata-rata Aspek</div>
            <img src="<?php echo $radar_chart_image; ?>" class="chart-image" alt="Radar Aspek">
        </div>
    <?php endif; ?>

    <?php if (!empty($aspect_trend_images) && is_array($aspect_trend_images)): ?>
        <?php foreach ($aspects as $aspect): ?>
            <?php $aspect_id = (int) $aspect->id_aspect; ?>
            <?php if (isset($aspect_trend_images[$aspect_id]) && !empty($aspect_trend_images[$aspect_id])): ?>
                <div class="chart-block">
                    <div class="chart-title">Grafik Tren Aspek -
                        <?php echo htmlspecialchars($aspect->aspect_name, ENT_QUOTES, 'UTF-8'); ?></div>
                    <img src="<?php echo $aspect_trend_images[$aspect_id]; ?>" class="chart-image"
                        alt="Tren <?php echo htmlspecialchars($aspect->aspect_name, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th style="width: 3%;">No</th>
            <th style="width: 14%;">Nama Anak</th>
            <th style="width: 8%;">Pendidikan</th>
            <?php foreach ($aspects as $aspect): ?>
                <th><?php echo $aspect->aspect_name; ?></th>
            <?php endforeach; ?>
            <th style="width: 7%;">Total</th>
            <th style="width: 6%;">Rata-rata</th>
            <th style="width: 9%;">Kategori</th>
            <th style="width: 8%;">Update</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($table_rows)): ?>
            <?php foreach ($table_rows as $i => $row): ?>
                <tr>
                    <td class="text-center"><?php echo $i + 1; ?></td>
                    <td><?php echo htmlspecialchars($row['nama_anak'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="text-center">
                        <?php echo !empty($row['pendidikan']) ? htmlspecialchars($row['pendidikan'], ENT_QUOTES, 'UTF-8') : '-'; ?>
                    </td>
                    <?php foreach ($aspects as $aspect): ?>
                        <?php $score = $row['aspect_scores'][(int) $aspect->id_aspect] ?? null; ?>
                        <td class="text-center"><?php echo $score !== null ? number_format((float) $score, 2) : '-'; ?></td>
                    <?php endforeach; ?>
                    <td class="text-center"><?php echo (int) $row['total_penilaian']; ?></td>
                    <td class="text-center">
                        <?php echo $row['avg_score'] !== null ? number_format((float) $row['avg_score'], 2) : '-'; ?>
                    </td>
                    <td class="text-center"><?php echo htmlspecialchars((string) $row['kategori'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="text-center">
                        <?php echo !empty($row['tanggal_terakhir']) ? date('d-m-Y', strtotime($row['tanggal_terakhir'])) : '-'; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?php echo count($aspects) + 7; ?>" class="text-center">Belum ada data untuk periode ini.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
