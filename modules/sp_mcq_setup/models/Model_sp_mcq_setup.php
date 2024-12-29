<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_mcq_setup extends MY_Model
{

    private $primary_key    = 'id';
    private $table_name     = 'sp_mcq_exam';
    public $field_search   = ['course_id', 'full_marks', 'pass_marks', 'question_marks', 'sp_course.name', 'time'];
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

    public function count_all($id, $role, $param, $q = null, $field = null)
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);
        $field = in_array($field, $this->field_search) ? $field : "";


        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = "sp_mcq_exam." . $field;

                if (strpos($field, '.')) {
                    $f_search = $field;
                }
                if ($iterasi == 1) {
                    $where .=  $f_search . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " .  $f_search . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '(' . $where . ')';
        } else {
            $where .= "(" . "sp_mcq_exam." . $field . " LIKE '%" . $q . "%' )";
        }

        $this->join_avaiable()->filter_avaiable();
        if ($role == "self_only") {
            $this->db->where('sp_mcq_exam.created_by', $id);
        }
        if (@$param['course_id']) {
            $this->db->where('sp_mcq_exam.course_id', @$param['course_id']);
        }
        if (@$param['board_id']) {
            $this->db->where('sp_course.board_university', @$param['board_id']);
        }
        $this->db->where('sp_mcq_exam.is_deleted', 0);
        $this->db->where($where);
        $query = $this->db->get($this->table_name);

        return $query->num_rows();
    }

    public function get($id, $role, $param, $q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);
        $field = in_array($field, $this->field_search) ? $field : "";


        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = "sp_mcq_exam." . $field;
                if (strpos($field, '.')) {
                    $f_search = $field;
                }

                if ($iterasi == 1) {
                    $where .= $f_search . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " . $f_search . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '(' . $where . ')';
        } else {
            $where .= "(" . "sp_mcq_exam." . $field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) and count($select_field)) {
            $this->db->select($select_field);
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        if (@$param['course_id']) {
            $this->db->where('sp_mcq_exam.course_id', @$param['course_id']);
        }
        if (@$param['board_id']) {
            $this->db->where('sp_course.board_university', @$param['board_id']);
        }
        if ($role == "self_only") {
            $this->db->where('sp_mcq_exam.created_by', $id);
        }
        $this->db->where('sp_mcq_exam.is_deleted', 0);
        $this->db->limit($limit, $offset);

        $this->sortable();

        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable()
    {
        $this->db->join('sp_course', 'sp_course.id = sp_mcq_exam.course_id', 'LEFT');
        $this->db->select('sp_mcq_exam.*,sp_course.name as course_name');


        return $this;
    }

    public function filter_avaiable()
    {

        if (!$this->aauth->is_admin()) {
        }

        return $this;
    }

    public function get_chapter_details($course_id)
    {
        $this->db->where('is_deleted',0);
        $this->db->where('course_id', $course_id);
        return $this->db->get('sp_chapter')->result();
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

    public function get_mcq_exam($id)
    {
        $this->db->select('e.*,c.name as course_name');
        $this->db->from('sp_mcq_exam e');
        $this->db->join('sp_course c','e.course_id =c.id');
        $this->db->where('e.id', $id);
        return $this->db->get()->row();
    }

    public function update_mcq_exam_detail($mcq_exam_id, $chapter_id, $no_of_question)
    {
        $this->db->set('no_of_question', $no_of_question);
        $this->db->where('mcq_exam_id', $mcq_exam_id);
        $this->db->where('chapter_id', $chapter_id);
        return $this->db->update('sp_mcq_exam_detail');
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
}

/* End of file Model_sp_mcq_exam.php */
/* Location: ./application/models/Model_sp_mcq_exam.php */