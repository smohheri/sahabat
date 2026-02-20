<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengurus_model extends CI_Model
{
	public function get_all_pengurus()
	{
		$this->db->order_by('id_pengurus', 'DESC');
		return $this->db->get('pengurus')->result();
	}

	public function get_pengurus_by_id($id)
	{
		return $this->db->get_where('pengurus', array('id_pengurus' => $id))->row();
	}

	public function insert_pengurus($data)
	{
		return $this->db->insert('pengurus', $data);
	}

	public function update_pengurus($id, $data)
	{
		$this->db->where('id_pengurus', $id);
		return $this->db->update('pengurus', $data);
	}

	public function delete_pengurus($id)
	{
		$this->db->where('id_pengurus', $id);
		return $this->db->delete('pengurus');
	}

	public function update_foto($id, $foto)
	{
		$this->db->where('id_pengurus', $id);
		return $this->db->update('pengurus', array('foto' => $foto));
	}

	public function update_ktp($id, $file_ktp)
	{
		$this->db->where('id_pengurus', $id);
		return $this->db->update('pengurus', array('file_ktp' => $file_ktp));
	}
}
