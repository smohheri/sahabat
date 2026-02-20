<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function login($username, $password)
	{
		$this->db->where('username', $username);
		$query = $this->db->get('users');

		if ($query->num_rows() == 1) {
			$user = $query->row();
			// Verify password (assuming password is hashed)
			if (password_verify($password, $user->password)) {
				return $user;
			} else {
				// Check if password is plain text (for first login)
				if ($password === $user->password) {
					return $user;
				}
			}
		}
		return FALSE;
	}

	public function get_all_users()
	{
		return $this->db->get('users')->result();
	}

	public function get_user_by_id($id)
	{
		return $this->db->get_where('users', ['id_user' => $id])->row();
	}

	public function insert_user($data)
	{
		return $this->db->insert('users', $data);
	}

	public function update_user($id, $data)
	{
		$this->db->where('id_user', $id);
		return $this->db->update('users', $data);
	}

	public function delete_user($id)
	{
		$this->db->where('id_user', $id);
		return $this->db->delete('users');
	}
}
