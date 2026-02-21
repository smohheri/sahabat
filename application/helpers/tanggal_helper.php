<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Indonesian Date Helper
 * Helper untuk menampilkan tanggal dalam format Indonesia
 */

if (!function_exists('tanggal_indo')) {
	/**
	 * Mengkonversi tanggal ke format Indonesia
	 * 
	 * @param string|null $date Tanggal dalam format YYYY-MM-DD atau timestamp
	 * @param bool $show_day Menampilkan hari atau tidak
	 * @return string Tanggal dalam format Indonesia
	 */
	function tanggal_indo($date = null, $show_day = false)
	{
		if ($date === null || $date === '') {
			return '-';
		}

		// Jika format timestamp atau sudah berupa integer
		if (is_numeric($date)) {
			$date = date('Y-m-d', $date);
		}

		// Parse tanggal
		$timestamp = strtotime($date);
		if ($timestamp === false) {
			return $date;
		}

		// Nama hari dalam Bahasa Indonesia
		$hari = array(
			0 => 'Minggu',
			1 => 'Senin',
			2 => 'Selasa',
			3 => 'Rabu',
			4 => 'Kamis',
			5 => 'Jumat',
			6 => 'Sabtu'
		);

		// Nama bulan dalam Bahasa Indonesia
		$bulan = array(
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

		$day_name = $hari[date('w', $timestamp)];
		$day = date('j', $timestamp);
		$month = $bulan[date('n', $timestamp)];
		$year = date('Y', $timestamp);

		if ($show_day) {
			return $day_name . ', ' . $day . ' ' . $month . ' ' . $year;
		}

		return $day . ' ' . $month . ' ' . $year;
	}
}

if (!function_exists('tanggal_indo_short')) {
	/**
	 * Mengkonversi tanggal ke format Indonesia singkat
	 * 
	 * @param string|null $date Tanggal dalam format YYYY-MM-DD
	 * @return string Tanggal dalam format singkat Indonesia
	 */
	function tanggal_indo_short($date = null)
	{
		if ($date === null || $date === '') {
			return '-';
		}

		$timestamp = strtotime($date);
		if ($timestamp === false) {
			return $date;
		}

		$bulan = array(
			1 => 'Jan',
			2 => 'Feb',
			3 => 'Mar',
			4 => 'Apr',
			5 => 'Mei',
			6 => 'Jun',
			7 => 'Jul',
			8 => 'Agt',
			9 => 'Sep',
			10 => 'Okt',
			11 => 'Nov',
			12 => 'Des'
		);

		$day = date('j', $timestamp);
		$month = $bulan[date('n', $timestamp)];
		$year = date('Y', $timestamp);

		return $day . ' ' . $month . ' ' . $year;
	}
}

if (!function_exists('bulan_indo')) {
	/**
	 * Mengkonversi nomor bulan ke nama bulan dalam Bahasa Indonesia
	 * 
	 * @param int|string|null $month Nomor bulan (1-12)
	 * @return string Nama bulan dalam Bahasa Indonesia
	 */
	function bulan_indo($month = null)
	{
		if ($month === null) {
			return '-';
		}

		$bulan = array(
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

		$month = (int) $month;
		if ($month >= 1 && $month <= 12) {
			return $bulan[$month];
		}

		return '-';
	}
}

if (!function_exists('umur')) {
	/**
	 * Menghitung umur dari tanggal lahir
	 * 
	 * @param string|null $tanggal_lahir Tanggal lahir dalam format YYYY-MM-DD
	 * @return string Umur dalam tahun
	 */
	function umur($tanggal_lahir = null)
	{
		if ($tanggal_lahir === null || $tanggal_lahir === '') {
			return '-';
		}

		$birthdate = new DateTime($tanggal_lahir);
		$today = new DateTime('today');
		$age = $birthdate->diff($today)->y;

		return $age . ' tahun';
	}
}

if (!function_exists('waktu_indo')) {
	/**
	 * Mengkonversi datetime ke format Indonesia lengkap
	 * 
	 * @param string|null $datetime Datetime dalam format YYYY-MM-DD HH:MM:SS
	 * @return string Datetime dalam format Indonesia
	 */
	function waktu_indo($datetime = null)
	{
		if ($datetime === null || $datetime === '') {
			return '-';
		}

		$timestamp = strtotime($datetime);
		if ($timestamp === false) {
			return $datetime;
		}

		return tanggal_indo(date('Y-m-d', $timestamp), true) . ' ' . date('H:i', $timestamp) . ' WIB';
	}
}
