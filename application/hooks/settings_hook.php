<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class settings_hook
{

	public function load_settings()
	{
		$CI =& get_instance();
		$CI->load->model('User_model');
		$settings = $CI->User_model->get_pengaturan();
		$CI->config->set_item('settings', $settings);
	}

}
