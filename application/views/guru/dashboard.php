<div class="guru-dashboard">
    <div class="stats-row">
        <div class="stat-card card-blue">
            <div class="card-content">
                <div class="card-number"><?php echo $total_anak; ?></div>
                <div class="card-label">Total Anak</div>
            </div>
            <div class="card-icon"><i class="fas fa-child"></i></div>
        </div>
        <div class="stat-card card-green">
            <div class="card-content">
                <div class="card-number"><?php echo $anak_aktif; ?></div>
                <div class="card-label">Status Aktif</div>
            </div>
            <div class="card-icon"><i class="fas fa-user-check"></i></div>
        </div>
        <div class="stat-card card-orange">
            <div class="card-content">
                <div class="card-number"><?php echo $dokumen_lengkap; ?></div>
                <div class="card-label">Dokumen Lengkap</div>
            </div>
            <div class="card-icon"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="stat-card card-purple">
            <div class="card-content">
                <div class="card-number"><?php echo $dokumen_kurang; ?></div>
                <div class="card-label">Dokumen Perlu Dicek</div>
            </div>
            <div class="card-icon"><i class="fas fa-file-medical"></i></div>
        </div>
    </div>

    <div class="substats-row">
        <div class="substat-item">
            <div class="substat-icon bg-blue-light"><i class="fas fa-mars text-blue"></i></div>
            <div class="substat-info">
                <span class="substat-value"><?php echo $anak_laki; ?></span>
                <span class="substat-label">Laki-laki</span>
            </div>
        </div>
        <div class="substat-item">
            <div class="substat-icon bg-pink-light"><i class="fas fa-venus text-pink"></i></div>
            <div class="substat-info">
                <span class="substat-value"><?php echo $anak_perempuan; ?></span>
                <span class="substat-label">Perempuan</span>
            </div>
        </div>
        <div class="substat-item">
            <div class="substat-icon bg-gray-light"><i class="fas fa-user-slash text-gray"></i></div>
            <div class="substat-info">
                <span class="substat-value"><?php echo $anak_nonaktif; ?></span>
                <span class="substat-label">Nonaktif</span>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="panel">
            <div class="panel-header">
                <h3><i class="fas fa-users text-blue"></i> Data Anak Terbaru</h3>
                <a href="<?php echo site_url('guru/anak'); ?>" class="btn-link">Lihat Semua -></a>
            </div>
            <div class="panel-body">
                <table class="clean-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Pendidikan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($anak_terbaru as $a): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <div class="user-cell">
                                        <div
                                            class="user-avatar-sm bg-<?php echo $a->jenis_kelamin === 'L' ? 'blue' : 'pink'; ?>">
                                            <?php echo strtoupper(substr($a->nama_anak, 0, 1)); ?>
                                        </div>
                                        <span><?php echo $a->nama_anak; ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-sm badge-<?php echo $a->jenis_kelamin === 'L' ? 'blue' : 'pink'; ?>">
                                        <?php echo $a->jenis_kelamin; ?>
                                    </span>
                                </td>
                                <td><?php echo !empty($a->pendidikan) ? $a->pendidikan : '-'; ?></td>
                                <td>
                                    <span
                                        class="badge-sm badge-<?php echo $a->status_anak === 'Aktif' ? 'green' : 'gray'; ?>">
                                        <?php echo $a->status_anak; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($anak_terbaru)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Belum ada data anak.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h3><i class="fas fa-lightbulb text-green"></i> Ringkasan Guru</h3>
            </div>
            <div class="panel-body summary-body">
                <div class="sum-row">
                    <span class="sum-label">Data yang perlu ditinjau</span>
                    <span class="sum-value"><?php echo $dokumen_kurang; ?> anak</span>
                </div>
                <div class="sum-row">
                    <span class="sum-label">Data sudah lengkap</span>
                    <span class="sum-value"><?php echo $dokumen_lengkap; ?> anak</span>
                </div>
                <div class="sum-row">
                    <span class="sum-label">Total aktif belajar</span>
                    <span class="sum-value"><?php echo $anak_aktif; ?> anak</span>
                </div>
                <div class="sum-row">
                    <span class="sum-label">Terakhir diperbarui</span>
                    <span class="sum-value"><?php echo date('d M Y H:i'); ?></span>
                </div>
                <div class="actions-grid">
                    <a href="<?php echo site_url('guru/anak'); ?>" class="action-box action-blue">
                        <i class="fas fa-list"></i>
                        <span>Lihat Data Anak</span>
                    </a>
                    <a href="<?php echo site_url('guru/penilaian-karakter'); ?>" class="action-box action-green">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Penilaian Karakter</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .guru-dashboard {
        padding: 10px;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        border: 2px solid transparent;
    }

    .card-blue {
        border-bottom: 4px solid #4e73df;
    }

    .card-green {
        border-bottom: 4px solid #1cc88a;
    }

    .card-orange {
        border-bottom: 4px solid #f6c23e;
    }

    .card-purple {
        border-bottom: 4px solid #6f42c1;
    }

    .card-number {
        font-size: 32px;
        font-weight: 700;
        line-height: 1;
    }

    .card-label {
        font-size: 13px;
        color: #718096;
        margin-top: 6px;
    }

    .card-icon {
        width: 58px;
        height: 58px;
        border-radius: 12px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #4a5568;
    }

    .substats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .substat-item {
        background: #fff;
        border-radius: 12px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .substat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-blue-light {
        background: rgba(78, 115, 223, 0.1);
    }

    .bg-pink-light {
        background: rgba(232, 62, 140, 0.1);
    }

    .bg-gray-light {
        background: rgba(113, 128, 150, 0.1);
    }

    .text-blue {
        color: #4e73df;
    }

    .text-pink {
        color: #e83e8c;
    }

    .text-gray {
        color: #718096;
    }

    .substat-value {
        display: block;
        font-size: 22px;
        font-weight: 700;
    }

    .substat-label {
        font-size: 13px;
        color: #718096;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .panel {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }

    .panel-header {
        padding: 18px 22px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .panel-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .panel-body {
        padding: 0;
    }

    .btn-link {
        font-size: 14px;
        font-weight: 600;
        color: #4e73df;
        text-decoration: none;
    }

    .clean-table {
        width: 100%;
        border-collapse: collapse;
    }

    .clean-table th {
        padding: 14px 18px;
        background: #f8fafc;
        font-size: 12px;
        text-transform: uppercase;
        color: #718096;
    }

    .clean-table td {
        padding: 14px 18px;
        border-bottom: 1px solid #edf2f7;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar-sm {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 13px;
    }

    .bg-blue {
        background: #4e73df;
    }

    .bg-pink {
        background: #e83e8c;
    }

    .badge-sm {
        display: inline-flex;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-blue {
        background: rgba(78, 115, 223, 0.15);
        color: #4e73df;
    }

    .badge-pink {
        background: rgba(232, 62, 140, 0.15);
        color: #e83e8c;
    }

    .badge-green {
        background: rgba(28, 200, 138, 0.15);
        color: #1cc88a;
    }

    .badge-gray {
        background: rgba(113, 128, 150, 0.15);
        color: #718096;
    }

    .summary-body {
        padding: 18px 22px;
    }

    .sum-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .sum-row:last-of-type {
        border-bottom: 0;
    }

    .sum-label {
        color: #4a5568;
        font-size: 14px;
    }

    .sum-value {
        font-weight: 600;
        font-size: 14px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
        margin-top: 15px;
    }

    .action-box {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .action-blue {
        background: rgba(78, 115, 223, 0.1);
        color: #4e73df;
    }

    .action-green {
        background: rgba(28, 200, 138, 0.1);
        color: #1cc88a;
    }

    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .substats-row {
            grid-template-columns: 1fr;
        }

        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>