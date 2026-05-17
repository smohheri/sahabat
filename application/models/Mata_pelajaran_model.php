<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mata_pelajaran_model extends CI_Model
{
    public function is_table_ready()
    {
        return $this->db->table_exists('mata_pelajaran');
    }

    public function get_all($filters = array())
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->select('mp.*, u.nama AS nama_pengampu, u.username AS username_pengampu');
        $this->db->from('mata_pelajaran mp');
        $this->db->join('users u', 'u.id_user = mp.id_user_pengampu', 'left');

        if (isset($filters['is_active']) && $filters['is_active'] !== '' && $filters['is_active'] !== null) {
            $this->db->where('mp.is_active', (int) $filters['is_active']);
        }

        if (!empty($filters['keyword'])) {
            $keyword = trim((string) $filters['keyword']);
            $this->db->group_start();
            $this->db->like('mp.nama_mapel', $keyword);
            $this->db->or_like('mp.kode_mapel', $keyword);
            $this->db->or_like('u.nama', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('mp.nama_mapel', 'ASC');
        return $this->db->get()->result();
    }

    public function get_active_mapel()
    {
        if (!$this->is_table_ready()) {
            return array();
        }

        $this->db->where('is_active', 1);
        $this->db->order_by('nama_mapel', 'ASC');
        return $this->db->get('mata_pelajaran')->result();
    }

    public function get_by_id($id_mata_pelajaran)
    {
        if (!$this->is_table_ready()) {
            return null;
        }

        $this->db->select('mp.*, u.nama AS nama_pengampu');
        $this->db->from('mata_pelajaran mp');
        $this->db->join('users u', 'u.id_user = mp.id_user_pengampu', 'left');
        $this->db->where('mp.id_mata_pelajaran', (int) $id_mata_pelajaran);
        return $this->db->get()->row();
    }

    public function is_kode_exists($kode_mapel, $exclude_id = null)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        $this->db->where('kode_mapel', trim((string) $kode_mapel));
        if (!empty($exclude_id)) {
            $this->db->where('id_mata_pelajaran !=', (int) $exclude_id);
        }

        return $this->db->count_all_results('mata_pelajaran') > 0;
    }

    public function insert($data)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        return $this->db->insert('mata_pelajaran', $data);
    }

    public function update($id_mata_pelajaran, $data)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        $this->db->where('id_mata_pelajaran', (int) $id_mata_pelajaran);
        return $this->db->update('mata_pelajaran', $data);
    }

    public function delete($id_mata_pelajaran)
    {
        if (!$this->is_table_ready()) {
            return false;
        }

        $this->db->where('id_mata_pelajaran', (int) $id_mata_pelajaran);
        return $this->db->delete('mata_pelajaran');
    }

    public function count_all()
    {
        if (!$this->is_table_ready()) {
            return 0;
        }

        return (int) $this->db->count_all('mata_pelajaran');
    }

    public function count_active()
    {
        if (!$this->is_table_ready()) {
            return 0;
        }

        $this->db->where('is_active', 1);
        return (int) $this->db->count_all_results('mata_pelajaran');
    }
}
