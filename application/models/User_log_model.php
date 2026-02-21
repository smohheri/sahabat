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
		$this->db->select('user_logs.*, users.nama, users.username');
		$this->db->from('user_logs');
		$this->db->join('users', 'user_logs.id_user = users.id_user');
		$this->db->order_by('user_logs.created_at', 'DESC');
		return $this->db->get()->result();
	}

	public function get_logs_by_user($id_user)
	{
		$this->db->select('user_logs.*, users.nama, users.username');
		$this->db->from('user_logs');
		$this->db->join('users', 'user_logs.id_user = users.id_user');
		$this->db->where('user_logs.id_user', $id_user);
		$this->db->order_by('user_logs.created_at', 'DESC');
		return $this->db->get()->result();
	}
}
