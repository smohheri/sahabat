<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_real_ip')) {
	function get_real_ip()
	{
		$ip = '';

		// Check for forwarded IP
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = trim($ip_list[0]); // Take the first IP
		} elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
			$ip = $_SERVER['HTTP_X_REAL_IP'];
		} elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
			$ip = $_SERVER['HTTP_FORWARDED'];
		} elseif (!empty($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		// Validate IP
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
			$ip = '127.0.0.1'; // Fallback
		}

		return $ip;
	}
}
