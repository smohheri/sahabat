<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Character_assessment_model extends CI_Model
{
    public function get_child_progress_summary($filters = array())
    {
        $period_type = $filters['period_type'] ?? 'weekly';

        switch ($period_type) {
            case 'monthly':
                return $this->get_child_progress_summary_monthly($filters);
            case 'range':
                return $this->get_child_progress_summary_range($filters);
            case 'weekly':
            default:
                return $this->get_child_progress_summary_weekly($filters);
        }
    }

    public function count_assessments()
    {
        return $this->safe_count('character_assessments');
    }

    public function count_details()
    {
        return $this->safe_count('character_assessment_details');
    }

    public function count_notes()
    {
        return $this->safe_count('character_qualitative_notes');
    }

    public function count_weekly_summary()
    {
        return $this->safe_count('character_weekly_summary');
    }

    public function count_monthly_summary()
    {
        return $this->safe_count('character_monthly_summary');
    }

    public function get_assessments($limit = 100)
    {
        if (!$this->db->table_exists('character_assessments')) {
            return array();
        }

        $this->db->select('ca.id_assessment, a.nama_anak, u.nama AS assessor_name, ca.assessor_type, ca.assessment_date, ca.week_number, ca.month, ca.year, ca.status, ca.created_at');
        $this->db->from('character_assessments ca');
        $this->db->join('anak a', 'a.id_anak = ca.id_anak', 'left');
        $this->db->join('users u', 'u.id_user = ca.id_assessor', 'left');
        $this->db->order_by('ca.assessment_date', 'DESC');
        $this->db->order_by('ca.id_assessment', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function get_assessment_details($limit = 200)
    {
        if (!$this->db->table_exists('character_assessment_details')) {
            return array();
        }

        $this->db->select('cad.id_detail, cad.id_assessment, a.nama_anak, ca.assessment_date, asp.aspect_name, ci.indicator_name, cad.score, cad.updated_at');
        $this->db->from('character_assessment_details cad');
        $this->db->join('character_assessments ca', 'ca.id_assessment = cad.id_assessment', 'left');
        $this->db->join('anak a', 'a.id_anak = ca.id_anak', 'left');
        $this->db->join('character_indicators ci', 'ci.id_indicator = cad.id_indicator', 'left');
        $this->db->join('character_aspects asp', 'asp.id_aspect = ci.id_aspect', 'left');
        $this->db->order_by('cad.id_detail', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function get_qualitative_notes($limit = 100)
    {
        if (!$this->db->table_exists('character_qualitative_notes')) {
            return array();
        }

        $this->db->select('cqn.id_note, cqn.id_assessment, a.nama_anak, u.nama AS assessor_name, ca.assessment_date, cqn.strengths, cqn.areas_to_support, cqn.updated_at');
        $this->db->from('character_qualitative_notes cqn');
        $this->db->join('character_assessments ca', 'ca.id_assessment = cqn.id_assessment', 'left');
        $this->db->join('anak a', 'a.id_anak = ca.id_anak', 'left');
        $this->db->join('users u', 'u.id_user = ca.id_assessor', 'left');
        $this->db->order_by('cqn.id_note', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function get_weekly_summary($limit = 200)
    {
        if (!$this->db->table_exists('character_weekly_summary')) {
            return array();
        }

        $this->db->select('cws.id_summary, a.nama_anak, asp.aspect_name, cws.week_number, cws.year, cws.avg_score, cws.assessor_type, cws.last_updated');
        $this->db->from('character_weekly_summary cws');
        $this->db->join('anak a', 'a.id_anak = cws.id_anak', 'left');
        $this->db->join('character_aspects asp', 'asp.id_aspect = cws.id_aspect', 'left');
        $this->db->order_by('cws.year', 'DESC');
        $this->db->order_by('cws.week_number', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function get_monthly_summary($limit = 200)
    {
        if (!$this->db->table_exists('character_monthly_summary')) {
            return array();
        }

        $this->db->select('cms.id_summary, a.nama_anak, asp.aspect_name, cms.month, cms.year, cms.avg_score, cms.assessor_type, cms.last_updated');
        $this->db->from('character_monthly_summary cms');
        $this->db->join('anak a', 'a.id_anak = cms.id_anak', 'left');
        $this->db->join('character_aspects asp', 'asp.id_aspect = cms.id_aspect', 'left');
        $this->db->order_by('cms.year', 'DESC');
        $this->db->order_by('cms.month', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function get_weekly_report($limit = 200)
    {
        if (!$this->db->table_exists('v_weekly_character_report')) {
            return array();
        }

        $this->db->order_by('year', 'DESC');
        $this->db->order_by('week_number', 'DESC');
        $this->db->limit((int) $limit);
        $query = $this->db->get('v_weekly_character_report');
        return $query ? $query->result() : array();
    }

    public function get_monthly_report($limit = 200)
    {
        if (!$this->db->table_exists('v_monthly_character_report')) {
            return array();
        }

        $this->db->order_by('year', 'DESC');
        $this->db->order_by('month', 'DESC');
        $this->db->limit((int) $limit);
        $query = $this->db->get('v_monthly_character_report');
        return $query ? $query->result() : array();
    }

    private function safe_count($table)
    {
        if (!$this->db->table_exists($table)) {
            return 0;
        }

        return (int) $this->db->count_all($table);
    }

    private function get_child_progress_summary_weekly($filters)
    {
        if (!$this->db->table_exists('character_weekly_summary')) {
            return array();
        }

        $week = (int) ($filters['week'] ?? date('W'));
        $year = (int) ($filters['year'] ?? date('Y'));

        $this->db->select('a.id_anak, a.nama_anak, COUNT(cws.id_summary) AS total_penilaian, AVG(cws.avg_score) AS avg_score, MAX(cws.last_updated) AS tanggal_terakhir', false);
        $this->db->from('character_weekly_summary cws');
        $this->db->join('anak a', 'a.id_anak = cws.id_anak', 'inner');
        $this->db->where('cws.week_number', $week);
        $this->db->where('cws.year', $year);
        $this->db->group_by('a.id_anak');
        $this->db->order_by('a.nama_anak', 'ASC');

        $rows = $this->db->get()->result();
        return $this->append_category($rows);
    }

    private function get_child_progress_summary_monthly($filters)
    {
        if (!$this->db->table_exists('character_monthly_summary')) {
            return array();
        }

        $month = (int) ($filters['month'] ?? date('n'));
        $year = (int) ($filters['year'] ?? date('Y'));

        $this->db->select('a.id_anak, a.nama_anak, COUNT(cms.id_summary) AS total_penilaian, AVG(cms.avg_score) AS avg_score, MAX(cms.last_updated) AS tanggal_terakhir', false);
        $this->db->from('character_monthly_summary cms');
        $this->db->join('anak a', 'a.id_anak = cms.id_anak', 'inner');
        $this->db->where('cms.month', $month);
        $this->db->where('cms.year', $year);
        $this->db->group_by('a.id_anak');
        $this->db->order_by('a.nama_anak', 'ASC');

        $rows = $this->db->get()->result();
        return $this->append_category($rows);
    }

    private function get_child_progress_summary_range($filters)
    {
        if (!$this->db->table_exists('character_assessments') || !$this->db->table_exists('character_assessment_details')) {
            return array();
        }

        $start_date = $filters['start_date'] ?? date('Y-m-01');
        $end_date = $filters['end_date'] ?? date('Y-m-d');

        $this->db->select('a.id_anak, a.nama_anak, COUNT(DISTINCT ca.id_assessment) AS total_penilaian, AVG(cad.score) AS avg_score, MAX(ca.assessment_date) AS tanggal_terakhir', false);
        $this->db->from('character_assessments ca');
        $this->db->join('anak a', 'a.id_anak = ca.id_anak', 'inner');
        $this->db->join('character_assessment_details cad', 'cad.id_assessment = ca.id_assessment', 'inner');
        $this->db->where('ca.assessment_date >=', $start_date);
        $this->db->where('ca.assessment_date <=', $end_date);
        $this->db->group_by('a.id_anak');
        $this->db->order_by('a.nama_anak', 'ASC');

        $rows = $this->db->get()->result();
        return $this->append_category($rows);
    }

    private function append_category($rows)
    {
        foreach ($rows as $row) {
            $score = (float) ($row->avg_score ?? 0);
            if ($score >= 3.5) {
                $row->kategori = 'Sangat Baik';
            } elseif ($score >= 2.5) {
                $row->kategori = 'Baik';
            } elseif ($score >= 1.5) {
                $row->kategori = 'Mulai Berkembang';
            } else {
                $row->kategori = 'Perlu Pendampingan Intensif';
            }
        }

        return $rows;
    }
}
