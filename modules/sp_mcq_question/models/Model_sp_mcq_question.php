<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_mcq_question extends MY_Model
{

    private $primary_key    = 'id';
    private $table_name     = 'sp_mcq_question';
    public $field_search   = ['course_id', 'chapter_id', 'topic_id', 'no_of_options', 'sp_course.name', 'sp_topic.name', 'sp_chapter.name'];
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
                $f_search = "sp_mcq_question." . $field;

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
            $where .= "(" . "sp_mcq_question." . $field . " LIKE '%" . $q . "%' )";
        }

        $this->join_avaiable()->filter_avaiable();
        if ($role == "self_only") {
            $this->db->where('sp_mcq_question.created_by', $id);
        }
        if (@$param['course_id']) {
            $this->db->where('sp_mcq_question.course_id', @$param['course_id']);
        }
        if (@$param['chapter_id']) {
            $this->db->where('sp_mcq_question.chapter_id', @$param['chapter_id']);
        }
        if (@$param['board_id']) {
            $this->db->where('sp_course.board_university', @$param['board_id']);
        }
        $this->db->where($where);
        $this->db->where('sp_mcq_question.is_deleted',0);
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
                $f_search = "sp_mcq_question." . $field;
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
            $where .= "(" . "sp_mcq_question." . $field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) and count($select_field)) {
            $this->db->select($select_field);
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        if (@$param['course_id']) {
            $this->db->where('sp_mcq_question.course_id', @$param['course_id']);
        }
        if (@$param['chapter_id']) {
            $this->db->where('sp_mcq_question.chapter_id', @$param['chapter_id']);
        }
        if (@$param['board_id']) {
            $this->db->where('sp_course.board_university', @$param['board_id']);
        }
        if ($role == "self_only") {
            $this->db->where('sp_mcq_question.created_by', $id);
        }
        $this->db->where('sp_mcq_question.is_deleted',0);
        $this->db->limit($limit, $offset);

        $this->sortable();

        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable()
    {
        $this->db->join('sp_course', 'sp_course.id = sp_mcq_question.course_id', 'LEFT');
        $this->db->join('sp_topic', 'sp_topic.id = sp_mcq_question.topic_id', 'LEFT');
        $this->db->join('sp_chapter', 'sp_chapter.id = sp_mcq_question.chapter_id', 'LEFT');
        $this->db->select('sp_course.name,sp_topic.name,sp_mcq_question.*,sp_course.name as sp_course_name,sp_course.name as name,sp_topic.name as sp_topic_name,sp_chapter.name as chapter_name');


        return $this;
    }

    public function filter_avaiable()
    {

        if (!$this->aauth->is_admin()) {
        }

        return $this;
    }

    public function get_mcq_detail($id)
    {
        $this->db->select('q.id,q.no_of_options,c.name as course_name,ch.name as chapter_name,t.name as topic_name');
        $this->db->from('sp_mcq_question q');
        $this->db->join('sp_course c', 'q.course_id=c.id');
        $this->db->join('sp_chapter ch', 'q.chapter_id=ch.id');
        $this->db->join('sp_topic t', 'q.topic_id=t.id','left');
        $this->db->where('q.id', $id);
        return $this->db->get()->row();
    }

    public function get_question_details($id)
    {
        $this->db->select('*');
        $this->db->from('sp_mcq_detail');
        $this->db->where('mcq_id', $id);
        $this->db->order_by('id','desc');
        return $this->db->get()->result();
    }

    public function get_question_detail($id)
    {
        $this->db->select('qd.*,q.course_id,q.chapter_id,q.topic_id');
        $this->db->from('sp_mcq_detail qd');
        $this->db->join('sp_mcq_question q', 'qd.mcq_id =q.id');
        $this->db->where('qd.id', $id);
        return $this->db->get()->row();
    }

    public function check_already_exist($course_id, $chapter_id, $topic_id)
    {
        $this->db->where('course_id', $course_id);
        $this->db->where('chapter_id', $chapter_id);
        $this->db->where('topic_id', $topic_id);
        return $this->db->get('sp_mcq_question')->row();
    }

    public function count_questions($id)
    {
        $this->db->where('mcq_id', $id);
        return $this->db->get('sp_mcq_detail')->num_rows();
    }

    public function update_question($id, $save_data)
    {
        $this->db->where('id', $id);
        $this->db->update('sp_mcq_detail', $save_data);
        return $id;
    }

    // public function get_question_detail($id){
    //     $this->db->select('*');
    //     $this->db->from('sp_mcq_detail');
    //     $this->db->where('mcq_id',$id);
    //     return $this->db->get()->row();
    // }

    public function getCourseByUniversity($board_id)
    {
        return $this->db->select('*')
            ->where('board_university', $board_id)
            ->where('is_deleted', 0)
            ->get('sp_course')->result();
    }

    public function getChapterByCourse($course_id)
    {
        return $this->db->select('*')
            ->where('course_id', $course_id)
            ->where('is_deleted', 0)
            ->get('sp_chapter')->result();
    }

    public function getTopicByChapter($chapter_id)
    {
        return $this->db->select('*')
            ->where('chapter_id', $chapter_id)
            ->where('is_deleted', 0)
            ->get('sp_topic')->result();
    }

    public function question_delete($id = NULL)
    {

        $this->db->where('id', $id);
        $this->db->delete('sp_mcq_detail');
        return $id;
    }
}

/* End of file Model_sp_mcq_question.php */
/* Location: ./application/models/Model_sp_mcq_question.php */