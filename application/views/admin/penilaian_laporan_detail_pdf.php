<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h2 style="text-align:center; margin: 8px 0 4px; font-size: 18px; letter-spacing: 0.8px;">LAPORAN RESMI PERKEMBANGAN
    KARAKTER ANAK (ADMIN)</h2>
<p style="text-align:center; margin: 0 0 16px; font-size: 11px; color: #444;">Periode: <?php echo $period_label; ?></p>

<table style="width:100%; border-collapse: collapse; margin-bottom: 14px; font-size: 11px;">
    <tr>
        <td style="width: 18%; padding: 4px 6px;">Nama Anak</td>
        <td style="width: 32%; padding: 4px 6px;"><strong>:
                <?php echo htmlspecialchars($anak->nama_anak, ENT_QUOTES, 'UTF-8'); ?></strong></td>
        <td style="width: 18%; padding: 4px 6px;">Pendidikan</td>
        <td style="width: 32%; padding: 4px 6px;">:
            <?php echo !empty($anak->pendidikan) ? htmlspecialchars($anak->pendidikan, ENT_QUOTES, 'UTF-8') : '-'; ?>
        </td>
    </tr>
    <tr>
        <td style="padding: 4px 6px;">Status Anak</td>
        <td style="padding: 4px 6px;">:
            <?php echo !empty($anak->status_anak) ? htmlspecialchars($anak->status_anak, ENT_QUOTES, 'UTF-8') : '-'; ?>
        </td>
        <td style="padding: 4px 6px;">Total Penilaian</td>
        <td style="padding: 4px 6px;">: <?php echo (int) $total_assessments; ?></td>
    </tr>
    <tr>
        <td style="padding: 4px 6px;">Rata-rata Aspek</td>
        <td style="padding: 4px 6px;">: <?php echo number_format((float) $overall_avg, 2); ?></td>
        <td style="padding: 4px 6px;">Dicetak Oleh</td>
        <td style="padding: 4px 6px;">:
            <?php echo !empty($assessor_name) ? htmlspecialchars($assessor_name, ENT_QUOTES, 'UTF-8') : '-'; ?></td>
    </tr>
</table>

<?php if (!empty($radar_chart_image)): ?>
    <div style="margin-bottom: 18px; page-break-inside: avoid;">
        <h3 style="margin: 0 0 8px; font-size: 13px; border-bottom: 1px solid #ddd; padding-bottom: 4px;">Grafik Radar Nilai
            Per Aspek</h3>
        <div style="text-align: center;">
            <img src="<?php echo $radar_chart_image; ?>"
                style="width: 80%; display: inline-block; border: 1px solid #e5e5e5;" alt="Grafik Radar" />
        </div>
    </div>
<?php endif; ?>

<?php foreach ($aspect_groups as $aspect): ?>
    <div style="margin-bottom: 14px; page-break-inside: avoid;">
        <h3 style="margin: 0 0 6px; font-size: 12px; background: #f5f7fb; border: 1px solid #dfe5f0; padding: 6px 8px;">
            <?php echo htmlspecialchars($aspect['aspect_name'], ENT_QUOTES, 'UTF-8'); ?>
            (Rata-rata:
            <?php echo $aspect['aspect_avg'] !== null ? number_format((float) $aspect['aspect_avg'], 2) : '-'; ?>)
        </h3>

        <?php $aspect_id = (int) $aspect['id_aspect']; ?>
        <?php if (!empty($aspect_chart_images[$aspect_id])): ?>
            <div style="text-align: center; margin-bottom: 8px;">
                <img src="<?php echo $aspect_chart_images[$aspect_id]; ?>"
                    style="width: 80%; display: inline-block; border: 1px solid #e5e5e5;" alt="Grafik Tren Aspek" />
            </div>
        <?php endif; ?>

        <table border="1" cellspacing="0" cellpadding="4" style="width:100%; border-collapse: collapse; font-size: 10px;">
            <thead style="background: #f1f1f1;">
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 37%;">Indikator</th>
                    <th style="width: 12%;">Kode</th>
                    <th style="width: 13%;">Rata-rata</th>
                    <th style="width: 13%;">Jumlah Data</th>
                    <th style="width: 20%;">Terakhir Dinilai</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($aspect['indicators'])): ?>
                    <?php foreach ($aspect['indicators'] as $idx => $indicator): ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $idx + 1; ?></td>
                            <td><?php echo htmlspecialchars($indicator['indicator_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td style="text-align:center;">
                                <?php echo !empty($indicator['indicator_code']) ? htmlspecialchars($indicator['indicator_code'], ENT_QUOTES, 'UTF-8') : '-'; ?>
                            </td>
                            <td style="text-align:center;">
                                <?php echo $indicator['avg_score'] !== null ? number_format((float) $indicator['avg_score'], 2) : '-'; ?>
                            </td>
                            <td style="text-align:center;"><?php echo (int) $indicator['score_count']; ?></td>
                            <td style="text-align:center;">
                                <?php echo !empty($indicator['last_assessed_at']) ? date('d-m-Y', strtotime($indicator['last_assessed_at'])) : '-'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center; color:#777;">Belum ada data indikator.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>
