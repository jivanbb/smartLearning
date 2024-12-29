<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sp_company extends MY_Model
{


    private $primary_key    = 'id';
    private $table_name     = 'sp_company';
    public function __construct()
    {
        $config = array(
            'primary_key'   => $this->primary_key,
            'table_name'    => $this->table_name,
        );

        parent::__construct($config);
    }

    public function get_company_detail($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('sp_company')->row();
    }
}

/* End of file Model_sp_mcq_question.php */
/* Location: ./application/models/Model_sp_mcq_question.php */