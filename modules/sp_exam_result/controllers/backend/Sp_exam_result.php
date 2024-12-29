<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question Controller
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question site
 *|
 */
class Sp_exam_result extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_exam_result');
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
		$user_id=get_user_data('id');
		$filter = $this->input->get();
		$this->data['filter'] = $filter;
		$this->template->title('Exam Result');
		$exam_list =$this->model_sp_exam_result->get_exam_list($user_id,$filter,$this->limit_page, $offset);
		$this->data['exam_list'] =$exam_list['result'];
		$this->data['count']=$exam_list['count']; 
		$this->data['teachers'] = get_teachers();
		$config = [
			'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_exam_result/index/',
			'total_rows'   => $exam_list['count'],
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];
		$this->data['offset']=$offset; 
		$this->data['user_id']=$user_id; 
		$this->data['pagination'] = $this->pagination($config);
		$this->render('backend/standart/administrator/sp_exam_result/sp_exam_result', $this->data);
	}

	public function result_detail($exam_id){
		$user_id=get_user_data('id');
		$this->data['exam_id'] =$exam_id;
		$this->data['user_id']=$user_id; 
		$this->data['exam_detail']=$this->model_sp_exam_result->get_exam_detail($exam_id);
		$this->data['total_user'] = count_total_exam_attended($exam_id);
		$this->data['result_detail']=$this->model_sp_exam_result->get_result_detail($exam_id,$user_id);
		$this->render('backend/standart/administrator/sp_exam_result/result_detail', $this->data);
	}

}


/* End of file sp_mcq_exam.php */
/* Location: ./application/controllers/administrator/Sq Mcq Question.php */