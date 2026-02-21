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
