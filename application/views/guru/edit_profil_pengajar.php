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
                <i class="fas fa-user-edit"></i>
            </div>
            <div>
                <h2>Edit Profil Pengajar</h2>
                <p>Perbarui data profesional pengajar yang terhubung dengan akun Anda.</p>
            </div>
        </div>
    </div>

    <div class="data-panel">
        <div class="panel-header">
            <h3><i class="fas fa-id-card"></i> Form Edit Detail Pengajar</h3>
        </div>
        <div class="panel-body">
            <?php echo form_open('guru/profil-pengajar/edit'); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Akun</label>
                        <input type="text" name="nama" class="form-control" maxlength="100"
                            value="<?php echo html_escape(set_value('nama', (string) ($user->nama ?? ''))); ?>"
                            required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Username</label>
                        <input type="text" class="form-control"
                            value="<?php echo html_escape((string) ($user->username ?? '-')); ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">NIP / NUPTK</label>
                        <input type="text" name="nip" class="form-control" maxlength="50"
                            value="<?php echo html_escape(set_value('nip', (string) ($guru->nip ?? ''))); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Email Guru</label>
                        <input type="email" name="email" class="form-control" maxlength="100"
                            value="<?php echo html_escape(set_value('email', (string) ($guru->email ?? ''))); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" maxlength="100"
                            value="<?php echo html_escape(set_value('jabatan', (string) ($guru->jabatan ?? ''))); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">No HP</label>
                        <input type="text" name="no_hp" class="form-control" maxlength="30"
                            value="<?php echo html_escape(set_value('no_hp', (string) ($guru->no_hp ?? ''))); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Pendidikan Terakhir</label>
                        <?php $selected_pendidikan = (string) set_value('pendidikan_terakhir', (string) ($guru->pendidikan_terakhir ?? '')); ?>
                        <select name="pendidikan_terakhir" class="form-control">
                            <option value="">-- Pilih Pendidikan Terakhir --</option>
                            <option value="SMA/SMK" <?php echo $selected_pendidikan === 'SMA/SMK' ? 'selected' : ''; ?>>
                                SMA/SMK</option>
                            <option value="D1" <?php echo $selected_pendidikan === 'D1' ? 'selected' : ''; ?>>D1</option>
                            <option value="D2" <?php echo $selected_pendidikan === 'D2' ? 'selected' : ''; ?>>D2</option>
                            <option value="D3" <?php echo $selected_pendidikan === 'D3' ? 'selected' : ''; ?>>D3</option>
                            <option value="D4" <?php echo $selected_pendidikan === 'D4' ? 'selected' : ''; ?>>D4</option>
                            <option value="S1" <?php echo $selected_pendidikan === 'S1' ? 'selected' : ''; ?>>S1</option>
                            <option value="S2" <?php echo $selected_pendidikan === 'S2' ? 'selected' : ''; ?>>S2</option>
                            <option value="S3" <?php echo $selected_pendidikan === 'S3' ? 'selected' : ''; ?>>S3</option>
                            <option value="Lainnya" <?php echo $selected_pendidikan === 'Lainnya' ? 'selected' : ''; ?>>
                                Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Bidang Keahlian</label>
                        <input type="text" name="bidang_keahlian" class="form-control" maxlength="150"
                            value="<?php echo html_escape(set_value('bidang_keahlian', (string) ($guru->bidang_keahlian ?? ''))); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Sertifikasi</label>
                        <input type="text" name="sertifikasi" class="form-control" maxlength="150"
                            value="<?php echo html_escape(set_value('sertifikasi', (string) ($guru->sertifikasi ?? ''))); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Pengalaman Mengajar (tahun)</label>
                        <input type="number" name="pengalaman_tahun" class="form-control" min="0" max="99"
                            value="<?php echo html_escape(set_value('pengalaman_tahun', (string) ($guru->pengalaman_tahun ?? ''))); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Status Kepegawaian</label>
                        <input type="text" name="status_kepegawaian" class="form-control" maxlength="50"
                            value="<?php echo html_escape(set_value('status_kepegawaian', (string) ($guru->status_kepegawaian ?? ''))); ?>">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Alamat</label>
                        <textarea name="alamat" rows="3" class="form-control"
                            maxlength="500"><?php echo html_escape(set_value('alamat', (string) ($guru->alamat ?? ''))); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex flex-wrap" style="gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="<?php echo site_url('guru/profil-pengajar'); ?>" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>