<div class="laporan-page guru-profile-page">
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger" role="alert"><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>
    <?php if (!empty($profile_notice)): ?>
        <div class="alert alert-warning" role="alert"><?php echo html_escape($profile_notice); ?></div>
    <?php endif; ?>

    <div class="page-header">
        <div class="header-info">
            <div class="header-icon bg-blue">
                <i class="fas fa-user-tie"></i>
            </div>
            <div>
                <h2>Profil Pengajar</h2>
                <p>Informasi akun dan detail pengajar yang terhubung.</p>
            </div>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card stat-blue">
            <div class="stat-title">Nama Akun</div>
            <div class="stat-value"><?php echo html_escape((string) ($user->nama ?? '-')); ?></div>
        </div>
        <div class="stat-card stat-green">
            <div class="stat-title">Role</div>
            <div class="stat-value"><?php echo strtoupper(html_escape((string) ($user->role ?? '-'))); ?></div>
        </div>
        <div class="stat-card stat-orange">
            <div class="stat-title">Username</div>
            <div class="stat-value"><?php echo html_escape((string) ($user->username ?? '-')); ?></div>
        </div>
        <div class="stat-card stat-pink">
            <div class="stat-title">Terdaftar Sejak</div>
            <div class="stat-value">
                <?php
                echo !empty($user->created_at)
                    ? date('d-m-Y', strtotime((string) $user->created_at))
                    : '-';
                ?>
            </div>
        </div>
    </div>

    <div class="data-panel">
        <div class="panel-header">
            <h3><i class="fas fa-image"></i> Foto & Ijazah Terakhir</h3>
        </div>
        <div class="panel-body">
            <div class="row align-items-start">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <?php if (!empty($guru->foto)): ?>
                        <img src="<?php echo base_url('assets/uploads/foto_guru/' . $guru->foto); ?>" alt="Foto Guru"
                            class="img-circle elevation-2" style="width: 140px; height: 140px; object-fit: cover;">
                    <?php else: ?>
                        <div
                            style="width:140px;height:140px;border-radius:50%;background:#f1f5f9;display:inline-flex;align-items:center;justify-content:center;color:#64748b;">
                            <i class="fas fa-user" style="font-size:42px;"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <?php echo form_open_multipart('guru/profil-pengajar'); ?>
                    <input type="hidden" name="submit_upload_doc" value="1">
                    <div class="form-group">
                        <label class="font-weight-bold">Upload Foto</label>
                        <input type="file" name="foto" class="form-control-file" accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Format: JPG/PNG/WEBP, maksimal 4MB.</small>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Upload Ijazah Terakhir</label>
                        <input type="file" name="ijazah_terakhir" class="form-control-file"
                            accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Format: PDF/JPG/PNG, maksimal 5MB.</small>
                    </div>
                    <?php if (!empty($guru->file_ijazah_terakhir)): ?>
                        <p class="mb-2">
                            <a href="<?php echo base_url('assets/uploads/ijazah_guru/' . $guru->file_ijazah_terakhir); ?>"
                                target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-file-alt"></i> Lihat Ijazah Terakhir
                            </a>
                        </p>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Simpan Dokumen</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="data-panel">
        <div class="panel-header">
            <h3><i class="fas fa-id-card"></i> Detail Pengajar</h3>
        </div>
        <div class="panel-body">
            <div class="mb-3 text-right">
                <a href="<?php echo site_url('guru/profil-pengajar/edit'); ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Nama</label>
                        <div class="form-control-plaintext"><?php echo html_escape((string) ($user->nama ?? '-')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Role</label>
                        <div class="form-control-plaintext">
                            <?php echo strtoupper(html_escape((string) ($user->role ?? '-'))); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Username</label>
                        <div class="form-control-plaintext">
                            <?php echo html_escape((string) ($user->username ?? '-')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">NIP / NUPTK</label>
                        <div class="form-control-plaintext">
                            <?php echo html_escape((string) ($guru->nip ?? '-')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Email Guru</label>
                        <div class="form-control-plaintext">
                            <?php echo html_escape((string) ($guru->email ?? '-')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Jabatan</label>
                        <div class="form-control-plaintext">
                            <?php echo html_escape((string) ($guru->jabatan ?? '-')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-muted">No HP</label>
                        <div class="form-control-plaintext">
                            <?php echo html_escape((string) ($guru->no_hp ?? '-')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Pendidikan Terakhir</label>
                        <div class="form-control-plaintext">
                            <?php echo html_escape((string) ($guru->pendidikan_terakhir ?? '-')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Bidang Keahlian</label>
                        <div class="form-control-plaintext">
                            <?php echo html_escape((string) ($guru->bidang_keahlian ?? '-')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Sertifikasi</label>
                        <div class="form-control-plaintext">
                            <?php echo html_escape((string) ($guru->sertifikasi ?? '-')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Pengalaman Mengajar</label>
                        <div class="form-control-plaintext">
                            <?php
                            echo isset($guru->pengalaman_tahun) && $guru->pengalaman_tahun !== null && $guru->pengalaman_tahun !== ''
                                ? html_escape((string) $guru->pengalaman_tahun) . ' tahun'
                                : '-';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">Status Kepegawaian</label>
                        <div class="form-control-plaintext">
                            <?php echo html_escape((string) ($guru->status_kepegawaian ?? '-')); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-muted">Alamat</label>
                        <div class="form-control-plaintext">
                            <?php echo html_escape((string) ($guru->alamat ?? '-')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>