<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Pagination Helper
 *
 * Membuat link pagination yang responsif dan mudah digunakan
 */

/**
 * Membuat link pagination
 *
 * @param string $base_url URL dasar untuk pagination
 * @param int $total_rows Total jumlah data
 * @param int $per_page Jumlah data per halaman
 * @param int $current_page Halaman saat ini
 * @param array $config Konfigurasi tambahan
 * @return string HTML pagination links
 */
function create_pagination($base_url, $total_rows, $per_page, $current_page = 1, $config = array())
{
	$CI =& get_instance();

	// Default config
	$default_config = array(
		'full_tag_open' => '<nav aria-label="Pagination"><ul class="pagination pagination-sm justify-content-center">',
		'full_tag_close' => '</ul></nav>',
		'first_tag_open' => '<li class="page-item">',
		'first_tag_close' => '</li>',
		'last_tag_open' => '<li class="page-item">',
		'last_tag_close' => '</li>',
		'next_tag_open' => '<li class="page-item">',
		'next_tag_close' => '</li>',
		'prev_tag_open' => '<li class="page-item">',
		'prev_tag_close' => '</li>',
		'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
		'cur_tag_close' => '</span></li>',
		'num_tag_open' => '<li class="page-item">',
		'num_tag_close' => '</li>',
		'first_link' => '<i class="fas fa-angle-double-left"></i>',
		'last_link' => '<i class="fas fa-angle-double-right"></i>',
		'next_link' => '<i class="fas fa-angle-right"></i>',
		'prev_link' => '<i class="fas fa-angle-left"></i>',
		'num_links' => 2,
		'show_first_last' => true,
		'show_prev_next' => true
	);

	$config = array_merge($default_config, $config);

	// Hitung total halaman
	$total_pages = ceil($total_rows / $per_page);

	if ($total_pages <= 1) {
		return '';
	}

	// Pastikan current_page dalam range
	$current_page = max(1, min($current_page, $total_pages));

	$output = $config['full_tag_open'];

	// First link
	if ($config['show_first_last'] && $current_page > ($config['num_links'] + 1)) {
		$output .= $config['first_tag_open'];
		$output .= '<a href="' . $base_url . '" class="page-link" data-page="1">' . $config['first_link'] . '</a>';
		$output .= $config['first_tag_close'];
	}

	// Previous link
	if ($config['show_prev_next'] && $current_page > 1) {
		$prev_page = $current_page - 1;
		$output .= $config['prev_tag_open'];
		$output .= '<a href="' . $base_url . '?page=' . $prev_page . '" class="page-link" data-page="' . $prev_page . '">' . $config['prev_link'] . '</a>';
		$output .= $config['prev_tag_close'];
	}

	// Calculate start and end page numbers
	$start_page = max(1, $current_page - $config['num_links']);
	$end_page = min($total_pages, $current_page + $config['num_links']);

	// Adjust start page if we're near the end
	if ($end_page - $start_page < $config['num_links'] * 2) {
		$start_page = max(1, $end_page - $config['num_links'] * 2);
	}

	// Numbered links
	for ($i = $start_page; $i <= $end_page; $i++) {
		if ($i == $current_page) {
			$output .= $config['cur_tag_open'];
			$output .= $i;
			$output .= $config['cur_tag_close'];
		} else {
			$output .= $config['num_tag_open'];
			$output .= '<a href="' . $base_url . '?page=' . $i . '" class="page-link" data-page="' . $i . '">' . $i . '</a>';
			$output .= $config['num_tag_close'];
		}
	}

	// Next link
	if ($config['show_prev_next'] && $current_page < $total_pages) {
		$next_page = $current_page + 1;
		$output .= $config['next_tag_open'];
		$output .= '<a href="' . $base_url . '?page=' . $next_page . '" class="page-link" data-page="' . $next_page . '">' . $config['next_link'] . '</a>';
		$output .= $config['next_tag_close'];
	}

	// Last link
	if ($config['show_first_last'] && $current_page < ($total_pages - $config['num_links'])) {
		$output .= $config['last_tag_open'];
		$output .= '<a href="' . $base_url . '?page=' . $total_pages . '" class="page-link" data-page="' . $total_pages . '">' . $config['last_link'] . '</a>';
		$output .= $config['last_tag_close'];
	}

	$output .= $config['full_tag_close'];

	return $output;
}

/**
 * Membuat informasi pagination
 *
 * @param int $total_rows Total jumlah data
 * @param int $per_page Jumlah data per halaman
 * @param int $current_page Halaman saat ini
 * @return string Informasi pagination
 */
function pagination_info($total_rows, $per_page, $current_page = 1)
{
	$total_pages = ceil($total_rows / $per_page);
	$start = (($current_page - 1) * $per_page) + 1;
	$end = min($current_page * $per_page, $total_rows);

	if ($total_rows == 0) {
		return 'Tidak ada data';
	}

	return "Menampilkan {$start} - {$end} dari {$total_rows} data";
}

/**
 * Membuat pagination dengan Bootstrap 4 styling
 *
 * @param string $base_url URL dasar untuk pagination
 * @param int $total_rows Total jumlah data
 * @param int $per_page Jumlah data per halaman
 * @param int $current_page Halaman saat ini
 * @return string HTML pagination links
 */
function bootstrap_pagination($base_url, $total_rows, $per_page, $current_page = 1)
{
	$config = array(
		'full_tag_open' => '<nav aria-label="Pagination"><ul class="pagination justify-content-center">',
		'full_tag_close' => '</ul></nav>',
		'first_tag_open' => '<li class="page-item">',
		'first_tag_close' => '</li>',
		'last_tag_open' => '<li class="page-item">',
		'last_tag_close' => '</li>',
		'next_tag_open' => '<li class="page-item">',
		'next_tag_close' => '</li>',
		'prev_tag_open' => '<li class="page-item">',
		'prev_tag_close' => '</li>',
		'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
		'cur_tag_close' => '<span class="sr-only">(current)</span></span></li>',
		'num_tag_open' => '<li class="page-item">',
		'num_tag_close' => '</li>',
		'first_link' => '<i class="fas fa-angle-double-left"></i>',
		'last_link' => '<i class="fas fa-angle-double-right"></i>',
		'next_link' => '<i class="fas fa-chevron-right"></i>',
		'prev_link' => '<i class="fas fa-chevron-left"></i>',
		'num_links' => 2
	);

	return create_pagination($base_url, $total_rows, $per_page, $current_page, $config);
}
