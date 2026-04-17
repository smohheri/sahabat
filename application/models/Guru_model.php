<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru_model extends CI_Model
{
    public function is_guru_table_ready()
    {
        return $this->db->table_exists('guru');
    }

    public function get_guru_by_id($id_guru)
    {
        if (!$this->is_guru_table_ready()) {
            return null;
        }

        return $this->db->get_where('guru', array('id_guru' => (int) $id_guru))->row();
    }

    public function get_guru_by_name($name)
    {
        if (!$this->is_guru_table_ready()) {
            return null;
        }

        $name = strtolower(trim((string) $name));
        if ($name === '') {
            return null;
        }

        $this->db->from('guru');
        $this->db->where('LOWER(TRIM(nama_guru))', $name);
        return $this->db->get()->row();
    }

    public function get_teacher_rows_with_user()
    {
        if (!$this->is_guru_table_ready() || !$this->db->field_exists('id_guru', 'users')) {
            return array();
        }

        $this->db->select('u.id_user, u.nama, u.username, u.role, u.created_at, u.id_guru, g.nip, g.jabatan, g.pendidikan_terakhir, g.bidang_keahlian, g.sertifikasi, g.pengalaman_tahun, g.status_kepegawaian, g.no_hp, g.email, g.alamat');
        $this->db->from('users u');
        $this->db->join('guru g', 'g.id_guru = u.id_guru', 'left');
        $this->db->where_in('u.role', array('guru', 'pengajar'));
        $this->db->order_by('u.nama', 'ASC');

        return $this->db->get()->result();
    }
}
