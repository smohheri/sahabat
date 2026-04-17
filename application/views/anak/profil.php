<div class="laporan-page anak-profil-page">
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="page-header">
        <div class="header-info">
            <div class="header-icon bg-blue">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <h2>Profil Saya</h2>
                <p>Ringkasan data pribadi dan informasi pendidikan anak.</p>
            </div>
        </div>
    </div>

    <div class="data-panel profile-photo-panel">
        <div class="panel-header">
            <h3><i class="fas fa-camera"></i> Foto Profil</h3>
        </div>
        <div class="panel-body text-center">
            <?php if (!empty($anak->foto)): ?>
                <img src="<?php echo base_url('assets/uploads/foto_anak/' . $anak->foto); ?>"
                    alt="Foto <?php echo html_escape($anak->nama_anak); ?>" class="child-photo-preview">
            <?php else: ?>
                <div class="child-photo-fallback">
                    <i class="fas fa-user-circle"></i>
                    <span>Foto belum tersedia</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card stat-blue">
            <div class="stat-icon bg-blue-soft">
                <i class="fas fa-birthday-cake text-blue"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number"><?php echo html_escape((string) $current_age); ?></span>
                <span class="stat-label">Usia</span>
            </div>
        </div>
        <div class="stat-card stat-green">
            <div class="stat-icon bg-green-soft">
                <i class="fas fa-graduation-cap text-green"></i>
            </div>
            <div class="stat-info">
                <span
                    class="stat-number"><?php echo !empty($anak->pendidikan) ? html_escape($anak->pendidikan) : '-'; ?></span>
                <span class="stat-label">Pendidikan</span>
            </div>
        </div>
        <div class="stat-card stat-orange">
            <div class="stat-icon bg-orange-soft">
                <i class="fas fa-users text-orange"></i>
            </div>
            <div class="stat-info">
                <span
                    class="stat-number"><?php echo !empty($anak->kategori) ? html_escape($anak->kategori) : '-'; ?></span>
                <span class="stat-label">Kategori</span>
            </div>
        </div>
        <div class="stat-card stat-pink">
            <div class="stat-icon bg-pink-soft">
                <i class="fas fa-home text-pink"></i>
            </div>
            <div class="stat-info">
                <span
                    class="stat-number"><?php echo !empty($anak->status_tinggal) ? html_escape($anak->status_tinggal) : '-'; ?></span>
                <span class="stat-label">Status Tinggal</span>
            </div>
        </div>
    </div>

    <div class="data-panel">
        <div class="panel-header">
            <h3><i class="fas fa-id-card"></i> Data Pribadi</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Nama Lengkap</label>
                        <div class="form-control-plaintext"><?php echo html_escape($anak->nama_anak); ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">NIK</label>
                        <div class="form-control-plaintext">
                            <?php echo !empty($anak->nik) ? html_escape($anak->nik) : '-'; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Jenis Kelamin</label>
                        <div class="form-control-plaintext">
                            <?php echo !empty($anak->jenis_kelamin) ? html_escape($anak->jenis_kelamin) : '-'; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Tempat, Tanggal Lahir</label>
                        <div class="form-control-plaintext">
                            <?php
                            $ttl = '-';
                            if (!empty($anak->tempat_lahir) || !empty($anak->tanggal_lahir)) {
                                $ttl = trim((string) $anak->tempat_lahir);
                                if (!empty($anak->tanggal_lahir)) {
                                    $ttl .= ($ttl !== '' ? ', ' : '') . date('d-m-Y', strtotime($anak->tanggal_lahir));
                                }
                            }
                            echo html_escape($ttl);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Agama</label>
                        <div class="form-control-plaintext">
                            <?php echo !empty($anak->agama) ? html_escape($anak->agama) : '-'; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Tanggal Masuk LKSA</label>
                        <div class="form-control-plaintext">
                            <?php echo !empty($anak->tanggal_masuk) ? date('d-m-Y', strtotime($anak->tanggal_masuk)) : '-'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="data-panel">
        <div class="panel-header">
            <h3><i class="fas fa-school"></i> Informasi Pendidikan</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Nama Sekolah</label>
                        <div class="form-control-plaintext">
                            <?php echo !empty($anak->nama_sekolah) ? html_escape($anak->nama_sekolah) : '-'; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Kelas</label>
                        <div class="form-control-plaintext">
                            <?php echo !empty($anak->kelas) ? html_escape($anak->kelas) : '-'; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">No. Telp Sekolah</label>
                        <div class="form-control-plaintext">
                            <?php echo !empty($anak->no_telp_sekolah) ? html_escape($anak->no_telp_sekolah) : '-'; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-muted">Alamat Sekolah</label>
                        <div class="form-control-plaintext">
                            <?php echo !empty($anak->alamat_sekolah) ? html_escape($anak->alamat_sekolah) : '-'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="data-panel">
        <div class="panel-header">
            <h3><i class="fas fa-key"></i> Keamanan Akun</h3>
        </div>
        <div class="panel-body">
            <?php echo form_open('anak/profil'); ?>
            <input type="hidden" name="submit_change_password" value="1">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="current_password" class="font-weight-bold">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password"
                            required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="new_password" class="font-weight-bold">Password Baru</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" minlength="8"
                            required>
                        <small class="text-muted">Minimal 8 karakter.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="confirm_password" class="font-weight-bold">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            minlength="8" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Perbarui Password</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<style>
    .anak-profil-page .stats-row {
        margin-bottom: 24px;
    }

    .anak-profil-page .data-panel {
        margin-bottom: 20px;
    }

    .profile-photo-panel .panel-body {
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .child-photo-preview {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #e2e8f0;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12);
    }

    .child-photo-fallback {
        width: 140px;
        height: 140px;
        margin: 0 auto;
        border-radius: 50%;
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        color: #64748b;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .child-photo-fallback i {
        font-size: 36px;
    }

    .child-photo-fallback span {
        font-size: 12px;
        font-weight: 600;
    }

    body.dark-mode .anak-profil-page .form-control-plaintext {
        color: #e5e7eb;
    }

    body.dark-mode .anak-profil-page .text-muted,
    body.dark-mode .anak-profil-page label.text-muted,
    body.dark-mode .anak-profil-page .stat-label {
        color: #9fb3c8 !important;
    }

    body.dark-mode .anak-profil-page .child-photo-fallback {
        background: #1a2c4d;
        border-color: #31537e;
        color: #dbeafe;
    }
</style>