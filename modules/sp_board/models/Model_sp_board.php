<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_board extends MY_Model
{

    private $primary_key    = 'id';
    private $table_name     = 'sp_board';
    public $field_search   = ['name'];
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

    public function count_all($id, $role, $q = null, $field = null)
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);
        $field = in_array($field, $this->field_search) ? $field : "";


        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = "sp_board." . $field;

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
            $where .= "(" . "sp_board." . $field . " LIKE '%" . $q . "%' )";
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        if ($role == "self_only") {
            $this->db->where('sp_board.created_by', $id);
        }
        $query = $this->db->get($this->table_name);

        return $query->num_rows();
    }

    public function get($id, $role, $q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
    {
        $iterasi = 1;
        $num = count($this->field_search);
        $where = NULL;
        $q = $this->scurity($q);
        $field = $this->scurity($field);
        $field = in_array($field, $this->field_search) ? $field : "";


        if (empty($field)) {
            foreach ($this->field_search as $field) {
                $f_search = "sp_board." . $field;
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
            $where .= "(" . "sp_board." . $field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) and count($select_field)) {
            $this->db->select($select_field);
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        if ($role == "self_only") {
            $this->db->where('sp_board.created_by', $id);
        }
        $this->db->limit($limit, $offset);

        $this->sortable();

        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable()
    {

        $this->db->select('sp_board.*');


        return $this;
    }

    public function filter_avaiable()
    {

        if (!$this->aauth->is_admin()) {
        }
        $this->db->where('is_deleted', 0);
        return $this;
    }

    public function check_already_name($name, $id)
    {
        $this->db->where('name', $name);
        $this->db->where('created_by',$id);
        $this->db->where('is_deleted',0);
        return $this->db->get('sp_board')->row();
    }
}

/* End of file Model_sp_board.php */
/* Location: ./application/models/Model_sp_board.php */