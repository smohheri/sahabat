<div class="laporan-page">
    <div class="page-header">
        <div class="header-info">
            <div class="header-icon bg-blue">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <h2>Manajemen Mata Pelajaran</h2>
                <p>Kelola master mata pelajaran dan guru pengampu</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="<?php echo $export_pdf_url; ?>" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="<?php echo $export_excel_url; ?>" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <button class="btn btn-export-primary" data-toggle="modal" data-target="#modalAddMapel">
                <i class="fas fa-plus"></i> Tambah Mapel
            </button>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i><?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i><?php echo $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    <?php endif; ?>

    <div class="stats-row">
        <div class="stat-card stat-blue">
            <div class="stat-icon"><i class="fas fa-book-open"></i></div>
            <div class="stat-info">
                <span class="stat-number"><?php echo (int) $total_mapel; ?></span>
                <span class="stat-label">Total Mapel</span>
            </div>
        </div>
        <div class="stat-card stat-green">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <span class="stat-number"><?php echo (int) $total_aktif; ?></span>
                <span class="stat-label">Mapel Aktif</span>
            </div>
        </div>
        <div class="stat-card stat-orange">
            <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="stat-info">
                <span class="stat-number"><?php echo (int) $total_dengan_pengampu; ?></span>
                <span class="stat-label">Dengan Pengampu</span>
            </div>
        </div>
    </div>

    <div class="data-panel">
        <div class="panel-header">
            <h3><i class="fas fa-list"></i> Daftar Mata Pelajaran</h3>
            <span class="data-count"><?php echo (int) $total_mapel; ?> data</span>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="data-table" id="tableMapel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Guru Pengampu</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($mapel_rows as $row): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><span class="badge badge-info px-2 py-1"><?php echo $row->kode_mapel; ?></span></td>
                                <td><?php echo $row->nama_mapel; ?></td>
                                <td><?php echo !empty($row->nama_pengampu) ? $row->nama_pengampu : '-'; ?></td>
                                <td>
                                    <?php if ((int) $row->is_active === 1): ?>
                                        <span class="badge badge-success px-2 py-1">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary px-2 py-1">Non Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#modalEditMapel<?php echo (int) $row->id_mata_pelajaran; ?>"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modalDeleteMapel<?php echo (int) $row->id_mata_pelajaran; ?>"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalEditMapel<?php echo (int) $row->id_mata_pelajaran; ?>"
                                tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i>Edit
                                                Mapel</h5>
                                            <button type="button" class="close text-white"
                                                data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <?php echo form_open($base_path . '/mapel', array('class' => 'js-mapel-form')); ?>
                                        <div class="modal-body p-4">
                                            <input type="hidden" name="form_type" value="save_mapel">
                                            <input type="hidden" name="id_mata_pelajaran"
                                                value="<?php echo (int) $row->id_mata_pelajaran; ?>">

                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold text-muted mb-2">Kode Mapel</label>
                                                <input type="text" class="form-control" name="kode_mapel"
                                                    value="<?php echo $row->kode_mapel; ?>" minlength="2" maxlength="50"
                                                    pattern="^[A-Za-z0-9_\-]{2,50}$"
                                                    title="Kode hanya boleh huruf, angka, underscore, dan tanda minus"
                                                    autocomplete="off" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold text-muted mb-2">Nama Mata Pelajaran</label>
                                                <input type="text" class="form-control" name="nama_mapel"
                                                    value="<?php echo $row->nama_mapel; ?>" minlength="3" maxlength="150" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold text-muted mb-2">Guru Pengampu</label>
                                                <select class="form-control" name="id_user_pengampu">
                                                    <option value="">- Belum ditentukan -</option>
                                                    <?php foreach ($pengajar_options as $teacher): ?>
                                                        <option value="<?php echo (int) $teacher->id_user; ?>" <?php echo (int) $row->id_user_pengampu === (int) $teacher->id_user ? 'selected' : ''; ?>>
                                                            <?php echo $teacher->nama; ?> (<?php echo $teacher->username; ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group mb-0">
                                                <label class="font-weight-bold text-muted mb-2">Status</label>
                                                <select class="form-control" name="is_active" required>
                                                    <option value="1" <?php echo (int) $row->is_active === 1 ? 'selected' : ''; ?>>Aktif</option>
                                                    <option value="0" <?php echo (int) $row->is_active === 0 ? 'selected' : ''; ?>>Non Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning font-weight-bold"><i
                                                    class="fas fa-save mr-1"></i>Simpan</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modalDeleteMapel<?php echo (int) $row->id_mata_pelajaran; ?>"
                                tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title font-weight-bold"><i class="fas fa-trash mr-2"></i>Hapus
                                                Mapel</h5>
                                            <button type="button" class="close text-white"
                                                data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            Apakah Anda yakin ingin menghapus mata pelajaran
                                            <strong><?php echo $row->nama_mapel; ?></strong>?
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <a href="<?php echo site_url($base_path . '/mapel?delete=' . (int) $row->id_mata_pelajaran); ?>"
                                                class="btn btn-danger font-weight-bold">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddMapel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus mr-2"></i>Tambah Mata Pelajaran</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <?php echo form_open($base_path . '/mapel', array('class' => 'js-mapel-form')); ?>
            <div class="modal-body p-4">
                <input type="hidden" name="form_type" value="save_mapel">
                <input type="hidden" name="id_mata_pelajaran" value="0">

                <div class="form-group mb-3">
                    <label class="font-weight-bold text-muted mb-2">Kode Mapel</label>
                    <input type="text" class="form-control" name="kode_mapel" placeholder="Contoh: MAT-01"
                        minlength="2" maxlength="50" pattern="^[A-Za-z0-9_\-]{2,50}$"
                        title="Kode hanya boleh huruf, angka, underscore, dan tanda minus" autocomplete="off" required>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold text-muted mb-2">Nama Mata Pelajaran</label>
                    <input type="text" class="form-control" name="nama_mapel" placeholder="Contoh: Matematika"
                        minlength="3" maxlength="150" required>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold text-muted mb-2">Guru Pengampu</label>
                    <select class="form-control" name="id_user_pengampu">
                        <option value="">- Belum ditentukan -</option>
                        <?php foreach ($pengajar_options as $teacher): ?>
                            <option value="<?php echo (int) $teacher->id_user; ?>"><?php echo $teacher->nama; ?>
                                (<?php echo $teacher->username; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-0">
                    <label class="font-weight-bold text-muted mb-2">Status</label>
                    <select class="form-control" name="is_active" required>
                        <option value="1">Aktif</option>
                        <option value="0">Non Aktif</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary font-weight-bold"><i
                        class="fas fa-save mr-1"></i>Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#tableMapel').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                },
                "emptyTable": "Belum ada data mata pelajaran"
            }
        });

        function sanitizeKodeMapel(value) {
            return (value || '').toUpperCase().replace(/[^A-Z0-9_-]/g, '');
        }

        $('input[name="kode_mapel"]').on('input', function () {
            this.value = sanitizeKodeMapel(this.value);
            $(this).removeClass('is-invalid');
        });

        $('input[name="nama_mapel"]').on('input', function () {
            $(this).removeClass('is-invalid');
        });

        $('.js-mapel-form').on('submit', function (event) {
            var $form = $(this);
            var $kode = $form.find('input[name="kode_mapel"]');
            var $nama = $form.find('input[name="nama_mapel"]');

            var kode = sanitizeKodeMapel(($kode.val() || '').trim());
            var nama = ($nama.val() || '').trim();

            $kode.val(kode);
            $nama.val(nama);

            var kodeValid = /^[A-Z0-9_-]{2,50}$/.test(kode);
            var namaValid = nama.length >= 3 && nama.length <= 150;

            $kode.toggleClass('is-invalid', !kodeValid);
            $nama.toggleClass('is-invalid', !namaValid);

            if (!kodeValid || !namaValid) {
                event.preventDefault();
            }
        });
    });
</script>
