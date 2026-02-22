<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fasilitas_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_all_active_facilities()
	{
		$this->db->where('is_active', 1);
		$this->db->order_by('sort_order', 'ASC');
		return $this->db->get('fasilitas')->result();
	}

	public function get_all_facilities()
	{
		$this->db->order_by('sort_order', 'ASC');
		return $this->db->get('fasilitas')->result();
	}

	public function get_facility_by_id($id)
	{
		return $this->db->get_where('fasilitas', ['id_fasilitas' => $id])->row();
	}

	public function insert_facility($data)
	{
		return $this->db->insert('fasilitas', $data);
	}

	public function update_facility($id, $data)
	{
		$this->db->where('id_fasilitas', $id);
		return $this->db->update('fasilitas', $data);
	}

	public function delete_facility($id)
	{
		$this->db->where('id_fasilitas', $id);
		return $this->db->delete('fasilitas');
	}

	public function update_sort_order($id, $sort_order)
	{
		$this->db->where('id_fasilitas', $id);
		return $this->db->update('fasilitas', ['sort_order' => $sort_order]);
	}
}
