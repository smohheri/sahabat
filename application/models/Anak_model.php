<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anak_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_all_anak($sort_by = 'nama_anak', $sort_order = 'ASC')
	{
		$this->db->select('anak.*');
		$this->db->from('anak');
		$this->db->order_by('anak.' . $sort_by, $sort_order);
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

	public function get_anak_datatable($start, $length, $search = '', $order_column = 'created_at', $order_dir = 'desc', $filters = array())
	{
		$this->db->select('anak.*');
		$this->db->from('anak');

		// Filters
		if (!empty($filters)) {
			if (isset($filters['status_anak']) && !empty($filters['status_anak'])) {
				$this->db->where('anak.status_anak', $filters['status_anak']);
			}
			if (isset($filters['jenis_kelamin']) && !empty($filters['jenis_kelamin'])) {
				$this->db->where('anak.jenis_kelamin', $filters['jenis_kelamin']);
			}
			if (isset($filters['pendidikan']) && !empty($filters['pendidikan'])) {
				$this->db->where('anak.pendidikan', $filters['pendidikan']);
			}
		}

		// Search functionality
		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('anak.nama_anak', $search);
			$this->db->or_like('anak.nik', $search);
			$this->db->or_like('anak.tempat_lahir', $search);
			$this->db->or_like('anak.kategori', $search);
			$this->db->or_like('anak.nama_sekolah', $search);
			$this->db->or_like('anak.status_anak', $search);
			$this->db->or_like('anak.pendidikan', $search);
			$this->db->group_end();
		}

		// Ordering
		$valid_columns = ['nama_anak', 'jenis_kelamin', 'tempat_lahir', 'kategori', 'nama_sekolah', 'biaya_spp', 'created_at'];
		if (in_array($order_column, $valid_columns)) {
			$this->db->order_by('anak.' . $order_column, $order_dir);
		} else {
			$this->db->order_by('anak.nama_anak', 'ASC');
		}

		// Pagination
		if ($length != -1) {
			$this->db->limit($length, $start);
		}

		return $this->db->get()->result();
	}

	public function count_all_anak()
	{
		return $this->db->count_all('anak');
	}

	public function count_filtered_anak($search = '', $filters = array())
	{
		$this->db->select('anak.id_anak');
		$this->db->from('anak');

		// Filters
		if (!empty($filters)) {
			if (isset($filters['status_anak']) && !empty($filters['status_anak'])) {
				$this->db->where('anak.status_anak', $filters['status_anak']);
			}
			if (isset($filters['jenis_kelamin']) && !empty($filters['jenis_kelamin'])) {
				$this->db->where('anak.jenis_kelamin', $filters['jenis_kelamin']);
			}
			if (isset($filters['pendidikan']) && !empty($filters['pendidikan'])) {
				$this->db->where('anak.pendidikan', $filters['pendidikan']);
			}
		}

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('anak.nama_anak', $search);
			$this->db->or_like('anak.nik', $search);
			$this->db->or_like('anak.tempat_lahir', $search);
			$this->db->or_like('anak.kategori', $search);
			$this->db->or_like('anak.nama_sekolah', $search);
			$this->db->or_like('anak.status_anak', $search);
			$this->db->or_like('anak.pendidikan', $search);
			$this->db->group_end();
		}

		return $this->db->count_all_results();
	}

}
