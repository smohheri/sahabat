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

	public function get_user_roles()
	{
		$default_roles = array('admin', 'petugas', 'dinas', 'operator', 'pengajar', 'anak');

		$query = $this->db->query("SHOW COLUMNS FROM users LIKE 'role'");
		$column = $query->row_array();

		if (!$column || empty($column['Type'])) {
			return $default_roles;
		}

		if (preg_match("/^enum\\((.*)\\)$/", $column['Type'], $matches) !== 1) {
			return $default_roles;
		}

		$roles = str_getcsv($matches[1], ',', "'");
		$roles = array_values(array_filter(array_map('trim', $roles)));

		return !empty($roles) ? $roles : $default_roles;
	}

	public function get_user_by_id($id)
	{
		return $this->db->get_where('users', ['id_user' => $id])->row();
	}

	public function get_user_by_anak_id($id_anak)
	{
		if (!$this->db->field_exists('id_anak', 'users')) {
			return null;
		}

		return $this->db->get_where('users', ['id_anak' => (int) $id_anak])->row();
	}

	public function get_user_by_pengurus_id($id_pengurus)
	{
		if (!$this->db->field_exists('id_pengurus', 'users')) {
			return null;
		}

		return $this->db->get_where('users', ['id_pengurus' => (int) $id_pengurus])->row();
	}

	public function get_user_by_guru_id($id_guru)
	{
		if (!$this->db->field_exists('id_guru', 'users')) {
			return null;
		}

		return $this->db->get_where('users', ['id_guru' => (int) $id_guru])->row();
	}

	public function get_user_by_username($username)
	{
		return $this->db->get_where('users', ['username' => $username])->row();
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

	public function get_pengaturan()
	{
		return $this->db->get('pengaturan')->row();
	}

	public function update_pengaturan($data)
	{
		return $this->db->update('pengaturan', $data);
	}
}
