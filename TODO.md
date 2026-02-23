# TODO: Modify Dashboard Substats and Sidebar

## Tasks
- [x] Update application/views/admin/dashboard.php to replace the second substats row with Laki-laki, Perempuan, Anak Baru instead of education stats (SMP, SMA, PT)
- [x] Replace Pendidikan TK in first substats row with Anak Asrama
- [x] Adjust counting logic in Admin.php for status_tinggal: sekolah, tinggal di lksa, perawatan
- [x] Ensure icons and colors are appropriate for the new stats
- [x] Test the dashboard display (changes applied, assuming correct display)
- [x] Add 3D text effect to "SAHABAT" in sidebar

## Notes
- Data for anak_laki, anak_perempuan, anak_baru, pendidikan_tk is already passed from controller
- This avoids duplication with the education chart
- 3D effect using text-shadow on brand-text

# TODO: Apply DataTables Pagination to Data Anak Page

## Tasks
- [x] Add anak_ajax method to Admin.php controller for server-side DataTables processing
- [x] Update anak.php view to include DataTables CSS and JS
- [x] Convert static table to DataTables with server-side processing
- [x] Add pagination styling from logs.php
- [x] Implement functional filters (Status Anak, Jenis Kelamin, Pendidikan)
- [x] Test DataTables functionality and pagination

## Notes
- Used existing Anak_model datatable methods, updated to support filters
- AJAX URL: admin/anak_ajax
- Page length: 10 (default), with options 10,25,50,100
- Indonesian language settings
- Modals still work as they are loaded server-side
- Filters reload DataTable via AJAX

# TODO: Update Log Aktivitas Mapping

## Tasks
- [x] Add missing activity mappings in logging_helper.php for colors and icons
- [x] Added mappings for: export_pdf_pengurus, export_excel_pengurus, export_pdf_dokumen, export_pdf_statistik, export_excel_dokumen, export_pdf_eksternal, export_excel_eksternal, add_facility, update_facility, delete_facility

## Notes
- All export activities use 'success' color and 'file-pdf'/'file-excel' icons
- Facility activities follow the same pattern as other CRUD operations (primary/info/danger colors, plus/edit/trash icons)

# TODO: Sort Data Anak by Name Ascending

## Tasks
- [x] Update DataTable configuration in anak.php to sort by nama_anak ascending by default
- [x] Enable ordering on the Nama Anak column
- [x] Update Anak_model.php to sort by nama_anak ASC at database level
- [x] Remove DataTable sorting configuration (use database sorting only)

## Notes
- Made Nama Anak column orderable: true
- Updated get_all_anak() and get_anak_datatable() to default to nama_anak ASC
- Removed "order" configuration from DataTable to rely on database sorting
