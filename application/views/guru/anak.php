<?php
$total_anak = count($anak);
$anak_aktif = count(array_filter($anak, function ($a) {
    return $a->status_anak === 'Aktif';
}));
$anak_laki = count(array_filter($anak, function ($a) {
    return $a->jenis_kelamin === 'L';
}));
$anak_perempuan = count(array_filter($anak, function ($a) {
    return $a->jenis_kelamin === 'P';
}));
?>

<div class="guru-anak-page">
    <div class="page-header">
        <div>
            <h2>Data Anak</h2>
            <p>Tampilan khusus guru untuk pemantauan data anak secara cepat.</p>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card stat-blue">
            <div class="stat-title">Total Anak</div>
            <div class="stat-value"><?php echo $total_anak; ?></div>
        </div>
        <div class="stat-card stat-green">
            <div class="stat-title">Anak Aktif</div>
            <div class="stat-value"><?php echo $anak_aktif; ?></div>
        </div>
        <div class="stat-card stat-orange">
            <div class="stat-title">Laki-laki</div>
            <div class="stat-value"><?php echo $anak_laki; ?></div>
        </div>
        <div class="stat-card stat-pink">
            <div class="stat-title">Perempuan</div>
            <div class="stat-value"><?php echo $anak_perempuan; ?></div>
        </div>
    </div>

    <div class="table-panel">
        <div class="table-header">
            <h3><i class="fas fa-table"></i> Daftar Anak Asuh</h3>
            <span><?php echo $total_anak; ?> data</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Kategori</th>
                        <th>Pendidikan</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($anak as $a): ?>
                        <?php $dokumen_lengkap = !empty($a->file_kk) && !empty($a->file_akta); ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $a->nama_anak; ?></td>
                            <td><?php echo $a->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                            <td><?php echo !empty($a->kategori) ? $a->kategori : '-'; ?></td>
                            <td><?php echo !empty($a->pendidikan) ? $a->pendidikan : '-'; ?></td>
                            <td>
                                <span
                                    class="badge badge-pill <?php echo $a->status_anak === 'Aktif' ? 'badge-success' : 'badge-secondary'; ?>">
                                    <?php echo $a->status_anak; ?>
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge badge-pill <?php echo $dokumen_lengkap ? 'badge-info' : 'badge-warning'; ?>">
                                    <?php echo $dokumen_lengkap ? 'Lengkap' : 'Belum Lengkap'; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($anak)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data anak.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .guru-anak-page {
        padding: 10px;
    }

    .page-header {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    }

    .page-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }

    .page-header p {
        margin: 6px 0 0;
        color: #718096;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .stat-card {
        padding: 18px;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-left: 4px solid #4e73df;
    }

    .stat-blue {
        border-left-color: #4e73df;
    }

    .stat-green {
        border-left-color: #1cc88a;
    }

    .stat-orange {
        border-left-color: #f6c23e;
    }

    .stat-pink {
        border-left-color: #e83e8c;
    }

    .stat-title {
        font-size: 13px;
        color: #718096;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        line-height: 1.2;
    }

    .table-panel {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .table-header {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .table-header span {
        font-size: 13px;
        color: #718096;
    }

    .table thead th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>