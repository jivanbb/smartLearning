<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *| --------------------------------------------------------------------------
 *| Blog Controller
 *| --------------------------------------------------------------------------
 *| For default controller
 *|
 */
class Sp_mcq_exam extends Front
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_sp_mcq_exam');
    }



    public function index($offset = 0)
    {
        $filter = $this->input->get('q');
        $this->data['exam_list'] = $this->model_sp_mcq_exam->get_exam_list($filter);
        if($this->data['exam_list']){
            $this->template->build('sp_mcq_exam/index', $this->data);
        }else{
            $this->template->build('error_page', $this->data);
        }
 
    }

    public function detail($id)
    {
        $this->data['id'] = $id;
        $id = decrypt_string($id);
        $this->data['exam_detail'] = $this->model_sp_mcq_exam->get_exam_full_detail($id);
        $this->template->build('sp_mcq_exam/detail', $this->data);
    }
}


/* End of file Blog.php */
/* Location: ./application/controllers/Blog.php */