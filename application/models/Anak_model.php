<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anak_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_all_anak()
	{
		$this->db->select('anak.*');
		$this->db->from('anak');
		$this->db->order_by('anak.created_at', 'DESC');
		return $this->db->get()->result();
	}

	public function get_anak_by_id($id)
	{
		$this->db->select('anak.*');
		$this->db->from('anak');
		$this->db->where('anak.id_anak', $id);
		return $this->db->get()->row();
	}

	public function insert_anak($data)
	{
		return $this->db->insert('anak', $data);
	}

	public function update_anak($id, $data)
	{
		$this->db->where('id_anak', $id);
		return $this->db->update('anak', $data);
	}

	public function delete_anak($id)
	{
		$this->db->where('id_anak', $id);
		return $this->db->delete('anak');
	}

	public function update_file_kk($id, $filename)
	{
		$this->db->where('id_anak', $id);
		return $this->db->update('anak', ['file_kk' => $filename]);
	}

	public function update_file_akta($id, $filename)
	{
		$this->db->where('id_anak', $id);
		return $this->db->update('anak', ['file_akta' => $filename]);
	}

	public function update_file_pendukung($id, $filename)
	{
		$this->db->where('id_anak', $id);
		return $this->db->update('anak', ['file_pendukung' => $filename]);
	}

	public function update_foto($id, $filename)
	{
		$this->db->where('id_anak', $id);
		return $this->db->update('anak', ['foto' => $filename]);
	}

}
