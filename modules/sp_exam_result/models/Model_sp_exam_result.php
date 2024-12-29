<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_exam_result extends MY_Model
{

    private $primary_key    = 'id';
    private $table_name     = 'sp_exam_result';
    public $field_search   = ['exam_id', 'score', 'time_taken'];
    public $sort_option = ['id', 'DESC'];

    public function __construct()
    {
        $config = array(
            'primary_key'   => $this->primary_key,
            'table_name'    => $this->table_name,
            'field_search'  => $this->field_search,
            'sort_option'   => $this->sort_option,
        );

        parent::__construct($config);
    }

    public function get_exam_list($user_id, $filter, $limit, $offset)
    {
        $this->db->select('c.name as course_name,r.exam_id,e.full_marks');
        $this->db->from('sp_exam_result r');
        $this->db->join('sp_mcq_exam e', 'r.exam_id =e.id');
        $this->db->join('sp_course c', 'e.course_id =c.id');
        if (!empty(@$filter['course_id'])) {
            $this->db->where('e.course_id', @$filter['course_id']);
        }
        $this->db->where('r.user_id', $user_id);
        $this->db->group_by('r.exam_id');
        $this->db->limit($limit, $offset);
        $data['result'] = $this->db->get()->result();
        $this->db->select('c.name as course_name,e.full_marks');
        $this->db->from('sp_exam_result r');
        $this->db->join('sp_mcq_exam e', 'r.exam_id =e.id');
        $this->db->join('sp_course c', 'e.course_id =c.id');
        if (!empty(@$filter['course_id'])) {
            $this->db->where('e.course_id', @$filter['course_id']);
        }
        $this->db->where('r.user_id', $user_id);
        $this->db->group_by('r.exam_id');
        $data['count'] = $this->db->get()->num_rows();
        return $data;
    }


    public function get_result_detail($exam_id, $user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('exam_id', $exam_id);
        return $this->db->get('sp_exam_result')->result();
    }

    public function get_exam_detail($exam_id)
    {
        $this->db->select('e.total_questions,c.name as course_name,a.full_name');
        $this->db->from('sp_mcq_exam e');
        $this->db->join('sp_course c','e.course_id =c.id');
        $this->db->join('aauth_users a','c.created_by =a.id');
        $this->db->where('e.id',$exam_id);
        return $this->db->get()->row();
    }
}

/* End of file Model_sp_mcq_question.php */
/* Location: ./application/models/Model_sp_mcq_question.php */