<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_log_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insert_log($data)
	{
		return $this->db->insert('user_logs', $data);
	}

	public function get_all_logs()
	{
		$this->db->select('user_logs.*, users.nama, users.username, users.role');
		$this->db->from('user_logs');
		$this->db->join('users', 'user_logs.id_user = users.id_user');
		$this->db->order_by('user_logs.created_at', 'DESC');
		return $this->db->get()->result();
	}

	public function get_logs_by_user($id_user)
	{
		$this->db->select('user_logs.*, users.nama, users.username, users.role');
		$this->db->from('user_logs');
		$this->db->join('users', 'user_logs.id_user = users.id_user');
		$this->db->where('user_logs.id_user', $id_user);
		$this->db->order_by('user_logs.created_at', 'DESC');
		return $this->db->get()->result();
	}

	public function get_logs_datatable($start, $length, $search = '', $order_column = 'created_at', $order_dir = 'desc')
	{
		$this->db->select('user_logs.*, users.nama, users.username');
		$this->db->from('user_logs');
		$this->db->join('users', 'user_logs.id_user = users.id_user');

		// Search functionality
		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('users.nama', $search);
			$this->db->or_like('users.username', $search);
			$this->db->or_like('user_logs.activity', $search);
			$this->db->or_like('user_logs.description', $search);
			$this->db->or_like('user_logs.ip_address', $search);
			$this->db->group_end();
		}

		// Ordering
		$valid_columns = ['nama', 'username', 'activity', 'description', 'ip_address', 'created_at'];
		if (in_array($order_column, $valid_columns)) {
			$this->db->order_by('user_logs.' . $order_column, $order_dir);
		} else {
			$this->db->order_by('user_logs.created_at', 'DESC');
		}

		// Pagination
		if ($length != -1) {
			$this->db->limit($length, $start);
		}

		return $this->db->get()->result();
	}

	public function count_all_logs()
	{
		return $this->db->count_all('user_logs');
	}

	public function count_filtered_logs($search = '')
	{
		$this->db->select('user_logs.id_log');
		$this->db->from('user_logs');
		$this->db->join('users', 'user_logs.id_user = users.id_user');

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('users.nama', $search);
			$this->db->or_like('users.username', $search);
			$this->db->or_like('user_logs.activity', $search);
			$this->db->or_like('user_logs.description', $search);
			$this->db->or_like('user_logs.ip_address', $search);
			$this->db->group_end();
		}

		return $this->db->count_all_results();
	}
}
