<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_purchase_register extends MY_Model
{

    private $primary_key    = 'id';
    private $table_name     = 'sp_purchase_register';
    public $field_search   = ['year'];
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
                $f_search = "sp_purchase_register." . $field;

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
            $where .= "(" . "sp_purchase_register." . $field . " LIKE '%" . $q . "%' )";
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        if ($role == "self_only") {
            $this->db->where('sp_purchase_register.created_by', $id);
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
                $f_search = "sp_purchase_register." . $field;
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
            $where .= "(" . "sp_purchase_register." . $field . " LIKE '%" . $q . "%' )";
        }

        if (is_array($select_field) and count($select_field)) {
            $this->db->select($select_field);
        }

        $this->join_avaiable()->filter_avaiable();
        $this->db->where($where);
        if ($role == "self_only") {
            $this->db->where('sp_purchase_register.created_by', $id);
        }
        $this->db->limit($limit, $offset);

        $this->sortable();

        $query = $this->db->get($this->table_name);

        return $query->result();
    }

    public function join_avaiable()
    {
        $this->db->join('sp_customer_detail', 'sp_purchase_register.customer_id=sp_customer_detail.id');
        $this->db->join('sp_tax_period_type', 'sp_purchase_register.tax_period_id=sp_tax_period_type.id');
        $this->db->join('sp_year', 'sp_purchase_register.year=sp_year.id');
        $this->db->select('sp_purchase_register.*,sp_customer_detail.pan_no,sp_customer_detail.name,sp_tax_period_type.value as tax_period,sp_year.name as year');


        return $this;
    }

    public function filter_avaiable()
    {

        if (!$this->aauth->is_admin()) {
        }
        return $this;
    }

    public function get_tax_period_type()
    {
        $this->db->group_by('slug');
        return $this->db->get('sp_tax_period_type')->result();
    }

    public function getPanNo($pan_no)
    {
        $this->db->select('*');
        $this->db->from('sp_customer_detail');;
        $this->db->like('pan_no', $pan_no);
        $this->db->where('is_client', 1);
        $query = $this->db->get();
        $results = $query->result_array();
        $row_set = [];
        if (is_array($results) && count($results) > 0) {
            foreach ($results as $result) :
                $new_row['label'] = htmlentities(stripslashes($result['pan_no']));
                $new_row['customer_name'] = htmlentities(stripslashes($result['name']));
                $new_row['customer_id'] = htmlentities(stripslashes($result['id']));
                $row_set[] = $new_row; //build an array 
            endforeach;
        }
        echo json_encode($row_set); //format the array into json data
        exit;
    }

    public function getSupplierPanNo($pan_no)
    {
        $this->db->select('*');
        $this->db->from('sp_customer_detail');;
        $this->db->like('pan_no', $pan_no);
        $query = $this->db->get();
        $results = $query->result_array();
        $row_set = [];
        if (is_array($results) && count($results) > 0) {
            foreach ($results as $result) :
                $new_row['label'] = htmlentities(stripslashes($result['pan_no']));
                $new_row['customer_name'] = htmlentities(stripslashes($result['name']));
                $new_row['customer_id'] = htmlentities(stripslashes($result['id']));
                $row_set[] = $new_row; //build an array 
            endforeach;
        }
        echo json_encode($row_set); //format the array into json data
        exit;
    }

    public function getTaxPeriod($slug)
    {
        $this->db->where('slug', $slug);
        return $this->db->get('sp_tax_period_type')->result();
    }

    public function get_sales_register($id)
    {
        $this->db->select('r.*,c.name,c.pan_no,t.value as tax_period,y.name as year_name');
        $this->db->from('sp_purchase_register r');
        $this->db->join('sp_customer_detail c', 'r.customer_id=c.id');
        $this->db->join('sp_tax_period_type t', 'r.tax_period_id=t.id');
        $this->db->join('sp_year y', 'r.year=y.id');
        $this->db->where('r.id', $id);
        return $this->db->get()->row();
    }

    public function get_register_detail($id)
    {
        $this->db->where('purchase_register_id', $id);
        return $this->db->get('sp_purchase_register_detail')->result();
    }

    public function check_already_exist($tax_period_id, $year)
    {
        $this->db->where('tax_period_id', $tax_period_id);
        $this->db->where('year', $year);
        return $this->db->get('sp_purchase_register')->row();
    }

    public function get_register_list($id,$role,$filter,$limit,$offset)
	{
		$this->db->select('p.*,c.pan_no,c.name,t.value as tax_period,y.name as year');
		$this->db->from('sp_purchase_register p');
		$this->db->join('sp_customer_detail c', 'p.customer_id=c.id');
		$this->db->join('sp_tax_period_type t', 'p.tax_period_id=t.id');
		$this->db->join('sp_year y', 'p.year =y.id');
        if ($role == "self_only") {
            $this->db->where('p.created_by', $id);
        }
        if(!empty($filter['customer_id'])){
            $this->db->where('p.customer_id', $filter['customer_id']);
        }
        if(!empty($filter['tax_period_type'])){
            $this->db->where('p.tax_period_type', $filter['tax_period_type']);
        }
        if(!empty(@$filter['tax_period_id'])){
            $this->db->where('p.tax_period_id', @$filter['tax_period_id']);
        }
        if(!empty($filter['year'])){
            $this->db->where('p.year', $filter['year']);
        }
		$this->db->order_by('p.id', 'desc');
		$data['result'] = $this->db->limit($limit, $offset)->get()->result();
        $this->db->select('p.*');
		$this->db->from('sp_purchase_register p');
		$this->db->join('sp_customer_detail c', 'p.customer_id=c.id');
		$this->db->join('sp_tax_period_type t', 'p.tax_period_id=t.id');
		$this->db->join('sp_year y', 'p.year =y.id');
        if ($role == "self_only") {
            $this->db->where('p.created_by', $id);
        }
        if(!empty($filter['customer_id'])){
            $this->db->where('p.customer_id', $filter['customer_id']);
        }
        if(!empty($filter['tax_period_type'])){
            $this->db->where('p.tax_period_type', $filter['tax_period_type']);
        }
        if(!empty(@$filter['tax_period_id'])){
            $this->db->where('p.tax_period_id', @$filter['tax_period_id']);
        }
        if(!empty($filter['year'])){
            $this->db->where('p.year', $filter['year']);
        }
		$data['count'] = $this->db->count_all_results();
        return $data;
    }
}


/* End of file Model_sp_purchase_register.php */
/* Location: ./application/models/Model_sp_purchase_register.php */