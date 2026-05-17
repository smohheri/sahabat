<div class="laporan-page">
    <div class="page-header">
        <div class="header-info">
            <div class="header-icon bg-blue">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div>
                <h2>Absensi Mata Pelajaran</h2>
                <p>Input absensi per mapel dengan filter rombel, periode, dan tanggal</p>
            </div>
        </div>
        <?php if (empty($is_teacher_panel)): ?>
            <div class="header-actions">
                <a href="<?php echo $export_pdf_url; ?>" class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="<?php echo $export_excel_url; ?>" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        <?php endif; ?>
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

    <?php
    $mapel_hint_default = !empty($is_teacher_panel)
        ? 'Daftar mapel sesuai pengampu yang disetting admin.'
        : 'Daftar mapel mengikuti rombel yang dipilih.';
    ?>

    <div class="filter-card">
        <div class="filter-header">
            <h3><i class="fas fa-filter"></i> Filter Input & Rekap</h3>
        </div>
        <div class="filter-body">
            <form method="get" action="<?php echo site_url($base_path . '/absensi'); ?>" id="filterAbsensiForm">
                <div class="filter-grid">
                    <div class="filter-item">
                        <label>Tahun Ajaran</label>
                        <select class="form-select" name="tahun_ajaran" id="tahun_ajaran" required>
                            <?php foreach ($tahun_ajaran_options as $option): ?>
                                <option value="<?php echo $option; ?>" <?php echo $selected_tahun_ajaran === $option ? 'selected' : ''; ?>><?php echo $option; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label>Semester</label>
                        <select class="form-select" name="semester" id="semester" required>
                            <option value="1" <?php echo (int) $selected_semester === 1 ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?php echo (int) $selected_semester === 2 ? 'selected' : ''; ?>>2</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label>Rombel</label>
                        <select class="form-select" name="id_rombel" id="id_rombel" required>
                            <option value="0">Pilih Rombel</option>
                            <?php foreach ($rombel_options as $rombel): ?>
                                <option value="<?php echo (int) $rombel->id_rombel; ?>" <?php echo (int) $selected_rombel === (int) $rombel->id_rombel ? 'selected' : ''; ?>>
                                    <?php echo $rombel->nama_rombel; ?> (<?php echo $rombel->tahun_ajaran; ?> -
                                    S<?php echo (int) $rombel->semester; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label>Mata Pelajaran</label>
                        <select class="form-select" name="id_mata_pelajaran" id="id_mata_pelajaran" <?php echo (int) $selected_rombel > 0 ? '' : 'disabled'; ?> required>
                            <option value="0">Pilih Mapel</option>
                            <?php foreach ($mapel_options as $mapel): ?>
                                <option value="<?php echo (int) $mapel->id_mata_pelajaran; ?>" <?php echo (int) $selected_mapel === (int) $mapel->id_mata_pelajaran ? 'selected' : ''; ?>>
                                    <?php echo $mapel->kode_mapel; ?> - <?php echo $mapel->nama_mapel; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted" id="mapelHint"><?php echo $mapel_hint_default; ?></small>
                    </div>
                    <div class="filter-item">
                        <label>Tanggal Absensi</label>
                        <input type="date" class="form-control" name="tanggal_absensi" id="tanggal_absensi"
                            value="<?php echo $selected_tanggal; ?>" required>
                    </div>
                    <div class="filter-item">
                        <label>Range Mulai Rekap</label>
                        <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                            value="<?php echo $tanggal_mulai; ?>">
                    </div>
                    <div class="filter-item">
                        <label>Range Selesai Rekap</label>
                        <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                            value="<?php echo $tanggal_selesai; ?>">
                    </div>
                    <div class="filter-item filter-actions">
                        <button type="submit" class="btn btn-filter"><i class="fas fa-search"></i> Tampilkan</button>
                        <a href="<?php echo site_url($base_path . '/absensi'); ?>" class="btn btn-reset"><i
                                class="fas fa-redo"></i> Reset</a>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="btnRange7">Range 7
                            Hari</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="btnRange30">Range 30
                            Hari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($is_teacher_panel)): ?>
        <div class="data-panel mb-4">
            <div class="panel-header">
                <h3><i class="fas fa-file-export"></i> Laporan Rekap Per Anak</h3>
                <span class="data-count">Mengikuti filter saat ini</span>
            </div>
            <div class="panel-body p-3">
                <p class="text-muted mb-3">Export Excel berisi daftar siswa, jumlah Hadir/Izin/Sakit/Alpha, dan persentase kehadiran.</p>
                <a href="<?php echo $export_excel_url; ?>" class="btn btn-success">
                    <i class="fas fa-file-excel mr-1"></i> Export Excel Rekap Per Anak
                </a>
            </div>
        </div>
    <?php endif; ?>

    <?php
    $last_month_ts = strtotime('first day of last month');
    $default_import_month = (int) date('n', $last_month_ts);
    $default_import_year = (int) date('Y', $last_month_ts);

    $import_month = $default_import_month;
    $import_year = $default_import_year;

    if ($import_month < 1 || $import_month > 12) {
        $import_month = $default_import_month;
    }
    if ($import_year < 2000 || $import_year > 3000) {
        $import_year = $default_import_year;
    }

    $can_import = (int) $selected_rombel > 0 && (int) $selected_mapel > 0;
    $bulan_options = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );
    $year_start = min($import_year, $default_import_year) - 1;
    $year_end = max($import_year, $default_import_year) + 1;
    ?>

    <div class="data-panel mb-4">
        <div class="panel-header">
            <h3><i class="fas fa-file-import"></i> Import Format Absensi Bulanan</h3>
            <span class="data-count">Template siswa x tanggal 1-31</span>
        </div>
        <div class="panel-body p-3">
            <?php echo form_open_multipart($base_path . '/absensi', array('id' => 'formImportAbsensi', 'class' => 'mb-0')); ?>
            <input type="hidden" name="form_type" value="import_absensi">
            <input type="hidden" name="tahun_ajaran" value="<?php echo $selected_tahun_ajaran; ?>">
            <input type="hidden" name="semester" value="<?php echo (int) $selected_semester; ?>">
            <input type="hidden" name="id_rombel" value="<?php echo (int) $selected_rombel; ?>">
            <input type="hidden" name="id_mata_pelajaran" value="<?php echo (int) $selected_mapel; ?>">

            <?php if (!$can_import): ?>
                <div class="alert alert-warning mb-3">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Pilih rombel dan mata pelajaran pada filter di atas
                    terlebih dahulu sebelum import.
                </div>
            <?php endif; ?>

            <div class="form-row align-items-end">
                <div class="form-group col-md-3">
                    <label class="font-weight-bold text-muted mb-2">Bulan Import</label>
                    <select class="form-control" name="import_month" id="import_month" <?php echo $can_import ? '' : 'disabled'; ?> required>
                        <?php foreach ($bulan_options as $bulan_value => $bulan_label): ?>
                            <option value="<?php echo (int) $bulan_value; ?>" <?php echo (int) $import_month === (int) $bulan_value ? 'selected' : ''; ?>>
                                <?php echo $bulan_label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label class="font-weight-bold text-muted mb-2">Tahun Import</label>
                    <select class="form-control" name="import_year" id="import_year" <?php echo $can_import ? '' : 'disabled'; ?> required>
                        <?php for ($year = $year_start; $year <= $year_end; $year++): ?>
                            <option value="<?php echo (int) $year; ?>" <?php echo (int) $import_year === (int) $year ? 'selected' : ''; ?>><?php echo (int) $year; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label class="font-weight-bold text-muted mb-2">File Template Absensi (.xlsx / .xls)</label>
                    <input type="file" class="form-control-file" name="file_absensi_import" id="file_absensi_import"
                        accept=".xlsx,.xls" <?php echo $can_import ? '' : 'disabled'; ?> required>
                </div>
                <div class="form-group col-md-2">
                    <a href="#" id="btnDownloadTemplateAbsensi"
                        class="btn btn-outline-success btn-block mb-2 <?php echo $can_import ? '' : 'disabled'; ?>"
                        <?php echo $can_import ? '' : 'aria-disabled="true" tabindex="-1"'; ?>>
                        <i class="fas fa-file-download mr-1"></i> Template
                    </a>
                    <button type="submit" class="btn btn-outline-primary btn-block" <?php echo $can_import ? '' : 'disabled'; ?>>
                        <i class="fas fa-upload mr-1"></i> Import
                    </button>
                </div>
            </div>

            <small class="text-muted">Kode yang didukung di sel tanggal: H (Hadir), I (Izin), S (Sakit), A
                (Alpha).</small>
            </form>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card stat-blue">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-number"><?php echo (int) ($status_summary['total'] ?? 0); ?></span>
                <span class="stat-label">Total Kehadiran Tercatat</span>
            </div>
        </div>
        <div class="stat-card stat-green">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <span class="stat-number"><?php echo (int) ($status_summary['Hadir'] ?? 0); ?></span>
                <span class="stat-label">Hadir</span>
            </div>
        </div>
        <div class="stat-card stat-orange">
            <div class="stat-icon"><i class="fas fa-notes-medical"></i></div>
            <div class="stat-info">
                <span
                    class="stat-number"><?php echo (int) (($status_summary['Izin'] ?? 0) + ($status_summary['Sakit'] ?? 0)); ?></span>
                <span class="stat-label">Izin + Sakit</span>
            </div>
        </div>
        <div class="stat-card stat-pink">
            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <span class="stat-number"><?php echo (int) ($status_summary['Alpha'] ?? 0); ?></span>
                <span class="stat-label">Alpha</span>
            </div>
        </div>
    </div>

    <?php if (!empty($children) && (int) $selected_rombel > 0 && (int) $selected_mapel > 0): ?>
        <div class="data-panel mb-4">
            <div class="panel-header">
                <h3><i class="fas fa-pen"></i> Form Input Absensi</h3>
                <span class="data-count"><?php echo count($children); ?> anak aktif</span>
            </div>
            <div class="panel-body p-3">
                <?php echo form_open($base_path . '/absensi', array('id' => 'formAbsensiMapel')); ?>
                <input type="hidden" name="form_type" value="save_absensi">
                <input type="hidden" name="tahun_ajaran" value="<?php echo $selected_tahun_ajaran; ?>">
                <input type="hidden" name="semester" value="<?php echo (int) $selected_semester; ?>">
                <input type="hidden" name="id_rombel" value="<?php echo (int) $selected_rombel; ?>">
                <input type="hidden" name="id_mata_pelajaran" value="<?php echo (int) $selected_mapel; ?>">
                <input type="hidden" name="tanggal_absensi" value="<?php echo $selected_tanggal; ?>">

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <div class="d-flex flex-wrap align-items-center">
                        <label class="font-weight-bold text-muted mr-2 mb-1">Aksi Cepat Status</label>
                        <select class="form-control form-control-sm mr-2 mb-1" id="bulkStatus" style="width: 150px;">
                            <option value="">Pilih status</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Alpha">Alpha</option>
                        </select>
                        <button type="button" class="btn btn-outline-primary btn-sm mb-1" id="btnApplyBulkStatus">
                            Terapkan ke Semua
                        </button>
                    </div>
                    <div class="d-flex flex-wrap align-items-center" id="statusLiveSummary">
                        <span class="badge badge-success mr-1 mb-1" data-status="Hadir">Hadir: 0</span>
                        <span class="badge badge-info mr-1 mb-1" data-status="Izin">Izin: 0</span>
                        <span class="badge badge-warning mr-1 mb-1" data-status="Sakit">Sakit: 0</span>
                        <span class="badge badge-danger mb-1" data-status="Alpha">Alpha: 0</span>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-hover mb-0" id="tableInputAbsensi">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Anak</th>
                                <th style="width: 170px;">Status Kehadiran</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($children as $child): ?>
                                <?php
                                $id_anak = (int) $child->id_anak;
                                $detail = $detail_map[$id_anak] ?? null;
                                $current_status = $detail ? $detail->status_kehadiran : 'Hadir';
                                $current_keterangan = $detail ? $detail->keterangan : '';
                                ?>
                                <tr class="attendance-row" data-anak-id="<?php echo $id_anak; ?>">
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $child->nama_anak; ?></td>
                                    <td>
                                        <select class="form-control status-kehadiran-select"
                                            name="status_kehadiran[<?php echo $id_anak; ?>]" required>
                                            <option value="Hadir" <?php echo $current_status === 'Hadir' ? 'selected' : ''; ?>>
                                                Hadir</option>
                                            <option value="Izin" <?php echo $current_status === 'Izin' ? 'selected' : ''; ?>>Izin
                                            </option>
                                            <option value="Sakit" <?php echo $current_status === 'Sakit' ? 'selected' : ''; ?>>
                                                Sakit</option>
                                            <option value="Alpha" <?php echo $current_status === 'Alpha' ? 'selected' : ''; ?>>
                                                Alpha</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control keterangan-input"
                                            name="keterangan[<?php echo $id_anak; ?>]" maxlength="255"
                                            value="<?php echo htmlspecialchars((string) $current_keterangan, ENT_QUOTES, 'UTF-8'); ?>"
                                            placeholder="Opsional">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold text-muted mb-2">Catatan Sesi Absensi (Opsional)</label>
                    <textarea class="form-control" name="catatan"
                        rows="2"><?php echo $existing_session ? $existing_session->catatan : ''; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Simpan Absensi
                </button>
                </form>
            </div>
        </div>
    <?php elseif ((int) $selected_rombel > 0 && (int) $selected_mapel > 0): ?>
        <div class="alert alert-warning shadow-sm">
            <i class="fas fa-exclamation-triangle mr-2"></i>Rombel ini belum memiliki anak aktif untuk diinput absensinya.
        </div>
    <?php endif; ?>

    <div class="data-panel">
        <div class="panel-header">
            <h3><i class="fas fa-table"></i> Rekap Absensi</h3>
            <span class="data-count"><?php echo count($recap_rows); ?> sesi</span>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="data-table" id="tableRekapAbsensi">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tahun/Smt</th>
                            <th>Rombel</th>
                            <th>Mapel</th>
                            <th>Hadir</th>
                            <th>Izin</th>
                            <th>Sakit</th>
                            <th>Alpha</th>
                            <th>Total</th>
                            <th>Input Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recap_rows as $row): ?>
                            <tr>
                                <td><?php echo $row->tanggal_absensi; ?></td>
                                <td><?php echo $row->tahun_ajaran; ?> / <?php echo (int) $row->semester; ?></td>
                                <td><?php echo $row->nama_rombel; ?></td>
                                <td><?php echo $row->nama_mapel; ?></td>
                                <td><span
                                        class="badge badge-success px-2 py-1"><?php echo (int) $row->total_hadir; ?></span>
                                </td>
                                <td><span class="badge badge-info px-2 py-1"><?php echo (int) $row->total_izin; ?></span>
                                </td>
                                <td><span
                                        class="badge badge-warning px-2 py-1"><?php echo (int) $row->total_sakit; ?></span>
                                </td>
                                <td><span class="badge badge-danger px-2 py-1"><?php echo (int) $row->total_alpha; ?></span>
                                </td>
                                <td><?php echo (int) $row->total_siswa; ?></td>
                                <td><?php echo !empty($row->input_by) ? $row->input_by : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#tableRekapAbsensi').DataTable({
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
                "emptyTable": "Belum ada data absensi"
            }
        });

        var $filterForm = $('#filterAbsensiForm');
        var $tahunAjaran = $('#tahun_ajaran');
        var $semester = $('#semester');
        var $rombel = $('#id_rombel');
        var $mapel = $('#id_mata_pelajaran');
        var $mapelHint = $('#mapelHint');
        var $tanggalAbsensi = $('#tanggal_absensi');
        var $tanggalMulai = $('#tanggal_mulai');
        var $tanggalSelesai = $('#tanggal_selesai');
        var $importForm = $('#formImportAbsensi');
        var $importMonth = $('#import_month');
        var $importYear = $('#import_year');
        var $btnDownloadTemplateAbsensi = $('#btnDownloadTemplateAbsensi');
        var exportTemplateBaseUrl = <?php echo json_encode(site_url($base_path . '/export/absensi/excel')); ?>;
        var mapelHintDefault = <?php echo json_encode($mapel_hint_default); ?>;

        function toggleMapelState() {
            var hasRombel = parseInt($rombel.val(), 10) > 0;
            $mapel.prop('disabled', !hasRombel);
            if (!hasRombel) {
                $mapel.val('0');
                $mapelHint.text('Pilih rombel terlebih dahulu untuk menampilkan mapel.');
            } else {
                $mapelHint.text(mapelHintDefault);
            }
        }

        function toDateInputFormat(dateObj) {
            var year = dateObj.getFullYear();
            var month = String(dateObj.getMonth() + 1).padStart(2, '0');
            var day = String(dateObj.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

        function applyRange(days) {
            var baseValue = $tanggalAbsensi.val();
            var baseDate = baseValue ? new Date(baseValue + 'T00:00:00') : new Date();
            if (isNaN(baseDate.getTime())) {
                baseDate = new Date();
            }

            var endDate = new Date(baseDate.getTime());
            var startDate = new Date(baseDate.getTime());
            startDate.setDate(startDate.getDate() - (days - 1));

            $tanggalMulai.val(toDateInputFormat(startDate)).removeClass('is-invalid');
            $tanggalSelesai.val(toDateInputFormat(endDate)).removeClass('is-invalid');
        }

        function validateTanggalRange() {
            var mulai = $tanggalMulai.val();
            var selesai = $tanggalSelesai.val();
            var valid = true;

            if (mulai !== '' && selesai !== '' && mulai > selesai) {
                valid = false;
            }

            $tanggalMulai.toggleClass('is-invalid', !valid);
            $tanggalSelesai.toggleClass('is-invalid', !valid);

            return valid;
        }

        $('#btnRange7').on('click', function () {
            applyRange(7);
        });

        $('#btnRange30').on('click', function () {
            applyRange(30);
        });

        $tanggalMulai.add($tanggalSelesai).on('change', function () {
            validateTanggalRange();
        });

        $tahunAjaran.add($semester).on('change', function () {
            $rombel.val('0');
            toggleMapelState();
            $filterForm.submit();
        });

        $rombel.on('change', function () {
            $mapel.val('0');
            toggleMapelState();
            $filterForm.submit();
        });

        $filterForm.on('submit', function (event) {
            if (!validateTanggalRange()) {
                event.preventDefault();
            }
        });

        if ($importForm.length > 0) {
            function updateTemplateDownloadLink() {
                var tahunAjaran = ($importForm.find('input[name="tahun_ajaran"]').val() || '').trim();
                var semesterValue = parseInt($importForm.find('input[name="semester"]').val(), 10) || 0;
                var rombelValue = parseInt($importForm.find('input[name="id_rombel"]').val(), 10) || 0;
                var mapelValue = parseInt($importForm.find('input[name="id_mata_pelajaran"]').val(), 10) || 0;
                var monthValue = parseInt($importMonth.val(), 10) || 0;
                var yearValue = parseInt($importYear.val(), 10) || 0;

                var canDownloadTemplate = rombelValue > 0 && mapelValue > 0 && monthValue >= 1 && monthValue <= 12 && yearValue >= 2000;
                if (!canDownloadTemplate) {
                    $btnDownloadTemplateAbsensi.attr('href', '#').addClass('disabled').attr('aria-disabled', 'true').attr('tabindex', '-1');
                    return;
                }

                var query = $.param({
                    tahun_ajaran: tahunAjaran,
                    semester: semesterValue,
                    id_rombel: rombelValue,
                    id_mata_pelajaran: mapelValue,
                    export_format: 'template_rombel',
                    periode_bulan: monthValue,
                    periode_tahun: yearValue
                });
                $btnDownloadTemplateAbsensi.attr('href', exportTemplateBaseUrl + '?' + query).removeClass('disabled').removeAttr('aria-disabled').removeAttr('tabindex');
            }

            $importMonth.add($importYear).on('change', function () {
                updateTemplateDownloadLink();
            });

            $importForm.on('submit', function (event) {
                var hasRombel = parseInt($rombel.val(), 10) > 0;
                var hasMapel = parseInt($mapel.val(), 10) > 0;
                if (!hasRombel || !hasMapel) {
                    event.preventDefault();
                }
            });

            updateTemplateDownloadLink();
        }

        toggleMapelState();
        validateTanggalRange();

        var $absensiForm = $('#formAbsensiMapel');
        if ($absensiForm.length > 0) {
            var $bulkStatus = $('#bulkStatus');
            var $statusSelects = $absensiForm.find('.status-kehadiran-select');
            var $keteranganInputs = $absensiForm.find('.keterangan-input');
            var $catatanInput = $absensiForm.find('textarea[name="catatan"]');
            var isDirty = false;

            function updateRowStyle($select) {
                var status = $select.val();
                var $row = $select.closest('tr');
                $row.removeClass('table-success table-info table-warning table-danger');

                if (status === 'Hadir') {
                    $row.addClass('table-success');
                } else if (status === 'Izin') {
                    $row.addClass('table-info');
                } else if (status === 'Sakit') {
                    $row.addClass('table-warning');
                } else if (status === 'Alpha') {
                    $row.addClass('table-danger');
                }
            }

            function updateLiveSummary() {
                var summary = {
                    'Hadir': 0,
                    'Izin': 0,
                    'Sakit': 0,
                    'Alpha': 0
                };

                $statusSelects.each(function () {
                    var currentValue = $(this).val();
                    if (Object.prototype.hasOwnProperty.call(summary, currentValue)) {
                        summary[currentValue] += 1;
                    }
                });

                $('#statusLiveSummary [data-status="Hadir"]').text('Hadir: ' + summary.Hadir);
                $('#statusLiveSummary [data-status="Izin"]').text('Izin: ' + summary.Izin);
                $('#statusLiveSummary [data-status="Sakit"]').text('Sakit: ' + summary.Sakit);
                $('#statusLiveSummary [data-status="Alpha"]').text('Alpha: ' + summary.Alpha);
            }

            function markDirty() {
                isDirty = true;
            }

            $statusSelects.each(function () {
                updateRowStyle($(this));
            });

            updateLiveSummary();

   $statusSelects.on('change', function () {
       updateRowStyle($(this));
                updateLiveSummary();
                markDirty();
                $(this).removeClass('is-invalid');
            });

            $keteranganInputs.on('input', function () {
                markDirty();
                $(this).removeClass('is-invalid');
            });

            $catatanInput.on('input', function () {
                markDirty();
            });

            $bulkStatus.on('change', function () {
                $(this).removeClass('is-invalid');
            });

            $('#btnApplyBulkStatus').on('click', function () {
                var statusTerpilih = $bulkStatus.val();
                if (!statusTerpilih) {
                    $bulkStatus.addClass('is-invalid');
                    return;
                }

                $statusSelects.val(statusTerpilih).trigger('change');
            });

            $absensiForm.on('submit', function (event) {
                var statusValid = true;
                $statusSelects.each(function () {
                    var currentValue = $(this).val();
                    var isCurrentValid = currentValue === 'Hadir' || currentValue === 'Izin' || currentValue === 'Sakit' || currentValue === 'Alpha';
                    $(this).toggleClass('is-invalid', !isCurrentValid);
                    if (!isCurrentValid) {
                        statusValid = false;
                    }
                });

                if (!statusValid) {
                    event.preventDefault();
                    return;
                }

                isDirty = false;
            });

            if ($importForm.length > 0) {
                $importForm.on('submit', function () {
                    isDirty = false;
                });
            }

            $(window).on('beforeunload', function () {
                if (isDirty) {
                    return 'Perubahan absensi belum disimpan.';
                }
                return undefined;
            });
        }
    });
</script>
