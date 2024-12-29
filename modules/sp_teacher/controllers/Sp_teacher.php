<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Blog Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Sp_teacher extends Front
{
	
	public function __construct()
	{
		parent::__construct();
        $this->load->model('model_sp_teacher');
	}


 
    public function index($offset = 0) 
    {
        $this->limit_page = 5;
        $filter =$this->input->get('q');
        $this->data['teacher_list'] = $this->model_sp_teacher->get_teacher_list($filter);
        if($this->data['teacher_list']){
            $this->template->build('sp_teacher/index', $this->data);
        }else{
            $this->template->build('error_page', $this->data);
        }
    }

    public function detail($id) 
    {
        $id =decrypt_string($id);
        $this->data['teacher_detail'] = $this->model_sp_teacher->get_teacher_detail($id);
        $this->template->build('sp_teacher/detail', $this->data);
    }

  

}


/* End of file Blog.php */
/* Location: ./application/controllers/Blog.php */