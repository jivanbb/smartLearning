<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_purchase_course extends MY_Model
{

    private $primary_key    = 'id';
    private $table_name     = 'sp_purchased_course';
    public $field_search   = ['course_id', 'user_id', 'amount'];
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

    public function get_course_list($filter, $limit, $offset)
    {
        $this->db->select('c.name as course_name,c.id,c.amount,a.full_name');
        $this->db->from('sp_course c');
        $this->db->join('aauth_users a', 'c.created_by =a.id');
        if (!empty(@$filter['teacher'])) {
            $this->db->where('c.created_by', @$filter['teacher']);
        }
        if (!empty(@$filter['course_id'])) {
            $this->db->where('c.id', @$filter['course_id']);
        }
        $this->db->limit($limit, $offset);
        $data['result'] = $this->db->get()->result();
        $this->db->select('c.name as course_name,c.id,c.amount,a.full_name');
        $this->db->from('sp_course c');
        $this->db->join('aauth_users a', 'c.created_by =a.id');
        if(!empty(@$filter['teacher'])){
            $this->db->where('c.created_by', @$filter['teacher']);
        }
        if(!empty(@$filter['course_id'])){
            $this->db->where('c.id', @$filter['course_id']);
        }
        $data['count'] = $this->db->get()->num_rows();
        return $data;
    }
}

/* End of file Model_sp_mcq_question.php */
/* Location: ./application/models/Model_sp_mcq_question.php */