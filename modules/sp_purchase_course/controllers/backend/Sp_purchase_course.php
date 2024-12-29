<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question Controller
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question site
 *|
 */
class Sp_purchase_course extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_purchase_course');
		if (!$this->session->userdata('loggedin')) {
			redirect('/', 'refresh');
		}
	}

	/**
	 * show all Sq Mcq Questions
	 *
	 * @var $offset String
	 */
	public function index($offset = 0)
	{

		$filter = $this->input->get();
		$this->data['filter'] = $filter;
		$this->template->title('Purchased Course');
		$course_list =$this->model_sp_purchase_course->get_course_list($filter,$this->limit_page, $offset);
		$this->data['course_list'] =$course_list['result'];
		$this->data['count']=$course_list['count']; 
		$config = [
			'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_purchase_course/index/',
			'total_rows'   => $course_list['count'],
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];
		$this->data['offset']=$offset; 
		$this->data['pagination'] = $this->pagination($config);
		$this->render('backend/standart/administrator/sp_purchase_course/sp_purchase_course', $this->data);
	}

	public function purchased_course(){
		
	}

}


/* End of file sp_mcq_exam.php */
/* Location: ./application/controllers/administrator/Sq Mcq Question.php */