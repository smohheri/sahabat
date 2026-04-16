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
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($anak as $a): ?>
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
                                <a href="<?php echo site_url('guru/perkembangan-anak/detail/' . (int) $a->id_anak); ?>"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-chart-line"></i> Lihat Perkembangan
                                </a>
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
    .table thead th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>