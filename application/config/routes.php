<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'landing';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';

// Admin
$route['admin'] = 'admin/index';
$route['admin/anak'] = 'admin/anak';
$route['admin/anak/tambah'] = 'admin/anak';
$route['admin/anak/edit/(:num)'] = 'admin/anak/$1';
$route['admin/anak/delete/(:num)'] = 'admin/anak/$1';
$route['admin/anak/upload_kk/(:num)'] = 'admin/upload_kk/$1';
$route['admin/anak/upload_akta/(:num)'] = 'admin/upload_akta/$1';
$route['admin/anak/upload_pendukung/(:num)'] = 'admin/upload_pendukung/$1';
$route['admin/anak/view_dokumen/(:num)/(:any)'] = 'admin/view_dokumen/$1/$2';

$route['admin/pengurus'] = 'admin/pengurus';
$route['admin/pengurus/tambah'] = 'admin/pengurus';
$route['admin/pengurus/edit/(:num)'] = 'admin/pengurus/$1';
$route['admin/pengurus/delete/(:num)'] = 'admin/pengurus/$1';
$route['admin/pengurus/upload_ktp/(:num)'] = 'admin/upload_ktp/$1';
$route['admin/pengurus/view_ktp/(:num)'] = 'admin/view_ktp/$1';

$route['admin/user'] = 'admin/user';
$route['admin/user/tambah'] = 'admin/user';
$route['admin/user/edit/(:num)'] = 'admin/user/$1';
$route['admin/user/delete/(:num)'] = 'admin/user/$1';

$route['admin/laporan'] = 'admin/laporan';
$route['admin/laporan/(:any)'] = 'admin/laporan/$1';

$route['admin/export_pdf_anak'] = 'admin/export_pdf_anak';
$route['admin/export_excel_anak'] = 'admin/export_excel_anak';
$route['admin/export_pdf_pengurus'] = 'admin/export_pdf_pengurus';
$route['admin/export_excel_pengurus'] = 'admin/export_excel_pengurus';
$route['admin/export_pdf_dokumen'] = 'admin/export_pdf_dokumen';
$route['admin/export_excel_dokumen'] = 'admin/export_excel_dokumen';
$route['admin/export_pdf_statistik'] = 'admin/export_pdf_statistik';
$route['admin/generate_pdf_statistik'] = 'admin/generate_pdf_statistik';
$route['admin/delete_temp_file'] = 'admin/delete_temp_file';

$route['admin/pengaturan'] = 'admin/pengaturan';
$route['admin/pengaturan/upload_logo'] = 'admin/upload_logo';
$route['admin/pengaturan/upload_dokumen'] = 'admin/upload_dokumen';
$route['admin/pengaturan/upload_kop'] = 'admin/upload_kop';

$route['admin/dukung_kami'] = 'admin/dukung_kami';
$route['admin/kontak'] = 'admin/kontak';
$route['admin/changelog'] = 'admin/changelog';
$route['admin/logs'] = 'admin/logs';
$route['admin/logs_ajax'] = 'admin/logs_ajax';
$route['admin/backup'] = 'admin/backup';
$route['admin/download_backup/(:any)/(:any)'] = 'admin/download_backup/$1/$2';
$route['admin/restore_database'] = 'admin/restore_database';
$route['admin/restore_files'] = 'admin/restore_files';
