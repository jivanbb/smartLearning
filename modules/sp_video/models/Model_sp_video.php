<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_sp_video extends MY_Model {

    private $primary_key    = 'id';
    private $table_name     = 'sp_video';
    public $field_search   = ['course_id', 'chapter_id', 'topic_id', 'materials'];
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

    public function count_all($id,$role, $param,$q = null, $field = null)
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);
        $field = in_array($field, $this->field_search) ? $field : "";


        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = "sp_video.".$field;

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
            $where .= "(" . "sp_video.".$field . " LIKE '%" . $q . "%' )";
        }

        $this->join_avaiable()->filter_avaiable();
        if($role =="self_only"){
            $this->db->where('sp_video.created_by', $id);
            }
            if (@$param['course_id']) {
                $this->db->where('sp_video.course_id', @$param['course_id']);
            }
            if (@$param['chapter_id']) {
                $this->db->where('sp_video.chapter_id', @$param['chapter_id']);
            }
            if(@$param['topic_id']){
                $this->db->where('sp_video.topic_id',@$param['topic_id']);
            }
        $this->db->where($where);
        $this->db->where('sp_video.is_deleted',0);
        $query = $this->db->get($this->table_name);

        return $query->num_rows();
    }

    public function get($id,$role, $param,$q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);
        $field = in_array($field, $this->field_search) ? $field : "";


        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = "sp_video.".$field;
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
            $where .= "(" . "sp_video.".$field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) AND count($select_field)) {
            $this->db->select($select_field);
        }
        
        $this->join_avaiable()->filter_avaiable();
        if($role =="self_only"){
            $this->db->where('sp_video.created_by', $id);
            }
            if (@$param['course_id']) {
                $this->db->where('sp_video.course_id', @$param['course_id']);
            }
            if (@$param['chapter_id']) {
                $this->db->where('sp_video.chapter_id', @$param['chapter_id']);
            }
            if(@$param['topic_id']){
                $this->db->where('sp_video.topic_id',@$param['topic_id']);
            }
            $this->db->where('sp_video.is_deleted',0);
        $this->db->where($where);
        $this->db->limit($limit, $offset);
        
        $this->sortable();
        
        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable() {
        $this->db->join('sp_course', 'sp_course.id = sp_video.course_id', 'LEFT');
        $this->db->join('sp_topic', 'sp_topic.id = sp_video.topic_id', 'LEFT');
        $this->db->join('sp_chapter', 'sp_chapter.id = sp_video.chapter_id', 'LEFT');
        $this->db->select('sp_video.*,sp_course.name as course_name,sp_topic.name as topic_name,sp_chapter.name as chapter_name');


        return $this;
    }

    public function filter_avaiable() {

        if (!$this->aauth->is_admin()) {
            }

        return $this;
    }

}

/* End of file Model_sp_video.php */
/* Location: ./application/models/Model_sp_video.php */