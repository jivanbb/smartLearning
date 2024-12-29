<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_sp_topic extends MY_Model {

    private $primary_key    = 'id';
    private $table_name     = 'sp_topic';
    public $field_search   = ['course_id', 'chapter_id', 'topic_no', 'name', 'sp_course.name', 'sp_chapter.name'];
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

    public function count_all($id,$role,$param,$q = null, $field = null)
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);
        $field = in_array($field, $this->field_search) ? $field : "";


        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = "sp_topic.".$field;

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

            $where = '('.$where.')';
        } else {
            $where .= "(" . "sp_topic.".$field . " LIKE '%" . $q . "%' )";
        }

        $this->join_avaiable()->filter_avaiable();
        if($role =="self_only"){
        $this->db->where('sp_topic.created_by',$id);
        }
        if(@$param['course_id']){
            $this->db->where('sp_topic.course_id',@$param['course_id']);
        }
        if(@$param['chapter_id']){
            $this->db->where('sp_topic.chapter_id',@$param['chapter_id']);
        }
        if(@$param['board_id']){
            $this->db->where('sp_course.board_university',@$param['board_id']);
        }
        $this->db->where($where);
        $query = $this->db->get($this->table_name);

        return $query->num_rows();
    }

    public function get($id,$role,$param,$q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);
        $field = in_array($field, $this->field_search) ? $field : "";


        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = "sp_topic.".$field;
                if (strpos($field, '.')) {
                    $f_search = $field;
                }

                if ($iterasi == 1) {
                    $where .= $f_search . " LIKE '%" . $q . "%' ";
                } else {
                    $where .= "OR " .$f_search . " LIKE '%" . $q . "%' ";
                }
                $iterasi++;
            }

            $where = '('.$where.')';
        } else {
            $where .= "(" . "sp_topic.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
            $this->db->select($select_field);
        }
        
        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        if($role =="self_only"){
        $this->db->where('sp_topic.created_by',$id);
        }
        if(@$param['course_id']){
            $this->db->where('sp_topic.course_id',@$param['course_id']);
        }
        if(@$param['course_id']){
            $this->db->where('sp_topic.course_id',@$param['course_id']);
        }
        if(@$param['board_id']){
            $this->db->where('sp_course.board_university',@$param['board_id']);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('sp_topic.id','desc');
        // $this->sortable();
        
        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable() {
        $this->db->join('sp_course', 'sp_course.id = sp_topic.course_id', 'LEFT');
        $this->db->join('sp_chapter', 'sp_chapter.id = sp_topic.chapter_id', 'LEFT');
        
        $this->db->select('sp_topic.*,sp_course.name as sp_course_name,sp_chapter.name as sp_chapter_name');


        return $this;
    }

    public function filter_avaiable() {

        if (!$this->aauth->is_admin()) {
            }
            $this->db->where('sp_topic.is_deleted',0);
        return $this;
    }

    public function check_already_exist($course_id,$chapter_id,$name, $id)
    {
        $this->db->where('course_id', $course_id);
        $this->db->where('chapter_id', $chapter_id);
        $this->db->where('name', $name);
        $this->db->where('created_by', $id);
        $this->db->where('is_deleted',0);
        return $this->db->get('sp_topic')->row();
    }

}

/* End of file Model_sp_topic.php */
/* Location: ./application/models/Model_sp_topic.php */