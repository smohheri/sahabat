<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Character_master_model extends CI_Model
{
    public function get_scales()
    {
        $this->db->order_by('score', 'ASC');
        return $this->db->get('character_scale')->result();
    }

    public function get_aspects_with_indicator_count()
    {
        $this->db->select('ca.*, COUNT(ci.id_indicator) AS total_indicators');
        $this->db->from('character_aspects ca');
        $this->db->join('character_indicators ci', 'ci.id_aspect = ca.id_aspect', 'left');
        $this->db->group_by('ca.id_aspect');
        $this->db->order_by('ca.`order`', 'ASC', FALSE);
        return $this->db->get()->result();
    }

    public function count_indicators()
    {
        return (int) $this->db->count_all('character_indicators');
    }

    public function get_scale_by_id($id_scale)
    {
        return $this->db->get_where('character_scale', ['id_scale' => $id_scale])->row();
    }

    public function is_scale_score_exists($score, $exclude_id = null)
    {
        $this->db->where('score', (int) $score);
        if (!empty($exclude_id)) {
            $this->db->where('id_scale !=', (int) $exclude_id);
        }

        return $this->db->count_all_results('character_scale') > 0;
    }

    public function insert_scale($data)
    {
        return $this->db->insert('character_scale', $data);
    }

    public function update_scale($id_scale, $data)
    {
        $this->db->where('id_scale', $id_scale);
        return $this->db->update('character_scale', $data);
    }

    public function delete_scale($id_scale)
    {
        $this->db->where('id_scale', $id_scale);
        return $this->db->delete('character_scale');
    }

    public function get_aspect_by_id($id_aspect)
    {
        return $this->db->get_where('character_aspects', ['id_aspect' => $id_aspect])->row();
    }

    public function is_aspect_code_exists($aspect_code, $exclude_id = null)
    {
        $this->db->where('aspect_code', $aspect_code);
        if (!empty($exclude_id)) {
            $this->db->where('id_aspect !=', (int) $exclude_id);
        }

        return $this->db->count_all_results('character_aspects') > 0;
    }

    public function insert_aspect($data)
    {
        return $this->db->insert('character_aspects', $data);
    }

    public function update_aspect($id_aspect, $data)
    {
        $this->db->where('id_aspect', $id_aspect);
        return $this->db->update('character_aspects', $data);
    }

    public function delete_aspect($id_aspect)
    {
        $this->db->where('id_aspect', $id_aspect);
        return $this->db->delete('character_aspects');
    }
}
