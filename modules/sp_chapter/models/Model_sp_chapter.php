<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_chapter extends MY_Model
{

    private $primary_key    = 'id';
    private $table_name     = 'sp_chapter';
    public $field_search   = ['course_id', 'name', 'sp_course.name'];
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
                $f_search = "sp_chapter." . $field;

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
            $where .= "(" . "sp_chapter." . $field . " LIKE '%" . $q . "%' )";
        }

        $this->join_avaiable()->filter_avaiable();
        if ($role == "self_only") {
            $this->db->where('sp_chapter.created_by', $id);
        }
        if (@$param['course_id']) {
            $this->db->where('sp_chapter.course_id', @$param['course_id']);
        }
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
                $f_search = "sp_chapter." . $field;
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
            $where .= "(" . "sp_chapter." . $field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) and count($select_field)) {
            $this->db->select($select_field);
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        if (@$param['board_id']) {
            $this->db->where('sp_course.board_university', @$param['board_id']);
        }
        if (@$param['course_id']) {
            $this->db->where('sp_chapter.course_id', @$param['course_id']);
        }
        $this->db->order_by('sp_chapter.id', 'desc');
        if ($role == "self_only") {
            $this->db->where('sp_chapter.created_by', $id);
        }
        $this->db->limit($limit, $offset);

        // $this->sortable();

        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable()
    {
        $this->db->join('sp_course', 'sp_course.id = sp_chapter.course_id', 'LEFT');
        $this->db->select('sp_chapter.*,sp_course.name as sp_course_name');


        return $this;
    }

    public function filter_avaiable()
    {

        if (!$this->aauth->is_admin()) {
        }
        $this->db->where('sp_chapter.is_deleted', 0);
        return $this;
    }

    public function check_already_exist($course_id,$name, $id)
    {
        $this->db->where('course_id', $course_id);
        $this->db->where('name', $name);
        $this->db->where('created_by', $id);
        $this->db->where('is_deleted',0);
        return $this->db->get('sp_chapter')->row();
    }
}

/* End of file Model_sp_chapter.php */
/* Location: ./application/models/Model_sp_chapter.php */