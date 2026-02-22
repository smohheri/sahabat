<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carousel_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_all_carousel_images()
	{
		$this->db->where('is_active', 1);
		$this->db->order_by('sort_order', 'ASC');
		return $this->db->get('carousel_images')->result();
	}

	public function get_all_carousel_images_admin()
	{
		$this->db->order_by('sort_order', 'ASC');
		return $this->db->get('carousel_images')->result();
	}

	public function get_carousel_image_by_id($id)
	{
		return $this->db->get_where('carousel_images', ['id_carousel' => $id])->row();
	}

	public function insert_carousel_image($data)
	{
		return $this->db->insert('carousel_images', $data);
	}

	public function update_carousel_image($id, $data)
	{
		$this->db->where('id_carousel', $id);
		return $this->db->update('carousel_images', $data);
	}

	public function delete_carousel_image($id)
	{
		$this->db->where('id_carousel', $id);
		return $this->db->delete('carousel_images');
	}

	public function update_sort_order($id, $sort_order)
	{
		$this->db->where('id_carousel', $id);
		return $this->db->update('carousel_images', ['sort_order' => $sort_order]);
	}
}
