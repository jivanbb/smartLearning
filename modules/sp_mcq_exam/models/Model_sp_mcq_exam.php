<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_mcq_exam extends MY_Model
{

    private $primary_key    = 'id';
    private $table_name     = 'sp_mcq_exam';
    public $field_search   = ['course_id', 'full_marks', 'pass_marks', 'question_marks', 'sp_course.name', 'time', 'total_questions'];
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



    public function get_mcq_exam_list($filter)
    {
        if (empty($filter)) {
            return [];
        }
        $this->db->select('e.*,c.name as course_name,s.name as set_name');
        $this->db->from('sp_mcq_exam e');
        $this->db->join('sp_course c', 'e.course_id =c.id');
        $this->db->join('sp_set s', 'e.set_id =s.id', 'left');
        if (@$filter['course_id']) {
            $this->db->where('e.course_id', @$filter['course_id']);
        }
        $this->db->where('e.created_by', @$filter['teacher']);
        $this->db->where('e.is_deleted', 0);
        return $this->db->get()->result();
    }

    public function get_questions($id)
    {
        $this->db->where('mcq_id', $id);
        $this->db->order_by('id', 'RANDOM');
        return $this->db->get('sp_mcq_detail')->result();
    }

    public function get_mcq_exam_detail($id)
    {
        $this->db->select('e.*,c.name as chapter_name');
        $this->db->from('sp_mcq_exam_detail e');
        $this->db->join('sp_chapter c', 'e.chapter_id=c.id');
        $this->db->where('e.mcq_exam_id', $id);
        $this->db->where('e.no_of_question >', 0);
        return $this->db->get()->result();
    }

    public function get_exam_full_detail($id)
    {
        $this->db->select('e.*,c.name as course_name,a.full_name as creator_name');
        $this->db->from('sp_mcq_exam e');
        $this->db->join('sp_course c', 'e.course_id =c.id');
        $this->db->join('aauth_users a', 'e.created_by =a.id');
        $this->db->where('e.id', $id);
        return $this->db->get()->row();
    }

    public function get_mcq_exam($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('sp_mcq_exam')->row();
    }

    public function get_teachers()
    {
        $this->db->select('u.id,u.full_name');
        $this->db->from('aauth_users u');
        $this->db->join('aauth_user_to_group g', 'g.user_id =u.id');
        $this->db->where('banned', 0);
        $this->db->where('g.group_id', 2);
        return $this->db->get()->result();
    }
    public function getCourseByTeacher($teacher)
    {
        return $this->db->select('*')
            ->where('created_by', $teacher)
            ->where('is_deleted', 0)
            ->get('sp_course')->result();
    }
    public function get_questions_detail($chapter_id, $limit)
    {
        $this->db->select('qd.*,q.no_of_options');
        $this->db->from('sp_mcq_question q');
        $this->db->join('sp_mcq_detail qd', 'qd.mcq_id =q.id');
        $this->db->where('chapter_id', $chapter_id);
        $this->db->limit($limit);
        $this->db->order_by('qd.id', 'RANDOM');
        return $this->db->get()->result();
    }

    public function get_exam_list($filter)
    {
        $this->db->select('e.*,c.name as course_name,a.full_name as creator_name');
        $this->db->from('sp_mcq_exam e');
        $this->db->join('sp_course c', 'e.course_id =c.id');
        $this->db->join('aauth_users a', 'e.created_by =a.id');
        if ($filter) {
            $this->db->like('c.name', $filter);
        }
        $this->db->where('e.is_publish', 1);
        return $this->db->get()->result();
    }

    public function get_exam_result_detail($id)
    {
        $this->db->select('er.*,e.full_marks,e.total_questions,e.full_marks,e.pass_marks,c.name as course_name');
        $this->db->from('sp_exam_result er');
        $this->db->join('sp_mcq_exam e','er.exam_id =e.id');
        $this->db->join('sp_course c','e.course_id =c.id');
        $this->db->where('er.id',$id);
        return $this->db->get()->row();
    }
}

/* End of file Model_sp_mcq_question.php */
/* Location: ./application/models/Model_sp_mcq_question.php */