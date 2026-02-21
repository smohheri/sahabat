<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('log_activity')) {
	function log_activity($activity, $description)
	{
		$CI =& get_instance();
		$CI->load->model('User_log_model');
		$CI->load->helper('ip');

		$log_data = array(
			'id_user' => $CI->session->userdata('id_user'),
			'activity' => $activity,
			'description' => $description,
			'ip_address' => get_real_ip(),
			'user_agent' => $CI->input->user_agent()
		);
		$CI->User_log_model->insert_log($log_data);
	}
}

if (!function_exists('get_activity_color')) {
	function get_activity_color($activity)
	{
		$colors = [
			'login' => 'success',
			'logout' => 'warning',
			'add_user' => 'primary',
			'edit_user' => 'info',
			'delete_user' => 'danger',
			'add_anak' => 'primary',
			'edit_anak' => 'info',
			'delete_anak' => 'danger',
			'add_pengurus' => 'primary',
			'edit_pengurus' => 'info',
			'delete_pengurus' => 'danger',
			'update_settings' => 'info',
			'upload_logo' => 'primary',
			'upload_dokumen' => 'primary',
			'upload_kop' => 'primary',
			'upload_hero_image' => 'primary',
			'upload_about_image' => 'primary',
			'upload_foto' => 'primary',
			'upload_kk' => 'primary',
			'upload_akta' => 'primary',
			'upload_pendukung' => 'primary',
			'export_pdf' => 'success',
			'export_excel' => 'success',
			'backup_database' => 'warning',
			'backup_files' => 'warning',
			'restore_database' => 'danger',
			'restore_files' => 'danger',
			'download_backup' => 'info'
		];
		return $colors[$activity] ?? 'secondary';
	}
}

if (!function_exists('get_activity_icon')) {
	function get_activity_icon($activity)
	{
		$icons = [
			'login' => 'sign-in-alt',
			'logout' => 'sign-out-alt',
			'add_user' => 'user-plus',
			'edit_user' => 'user-edit',
			'delete_user' => 'user-minus',
			'add_anak' => 'child',
			'edit_anak' => 'edit',
			'delete_anak' => 'trash',
			'add_pengurus' => 'user-tie',
			'edit_pengurus' => 'edit',
			'delete_pengurus' => 'trash',
			'update_settings' => 'cog',
			'upload_logo' => 'image',
			'upload_dokumen' => 'file-alt',
			'upload_kop' => 'stamp',
			'upload_hero_image' => 'image',
			'upload_about_image' => 'image',
			'upload_foto' => 'camera',
			'upload_kk' => 'id-card',
			'upload_akta' => 'file-contract',
			'upload_pendukung' => 'folder-open',
			'export_pdf' => 'file-pdf',
			'export_excel' => 'file-excel',
			'backup_database' => 'database',
			'backup_files' => 'folder',
			'restore_database' => 'undo',
			'restore_files' => 'undo',
			'download_backup' => 'download'
		];
		return $icons[$activity] ?? 'circle';
	}
}
