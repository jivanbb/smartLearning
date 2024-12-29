<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question Controller
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question site
 *|
 */
class Sp_mcq_practise extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_mcq_practise');
		$this->load->model('group/model_group');
		$this->lang->load('web_lang', $this->current_lang);
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
		$this->data['teachers'] = $this->model_sp_mcq_practise->get_teachers();
		$this->data['results'] = $this->model_sp_mcq_practise->get_mcq_question($filter);
		$this->data['filter'] = $filter;
		$this->template->title('Mcq Exam List');
		$this->render('backend/standart/administrator/sp_mcq_practise/sp_mcq_exam_list', $this->data);
	}

	public function start_practice($id)
	{
		$id =decrypt_string($id);
		$question_arr = [];
		$questions = $this->model_sp_mcq_practise->get_questions($id);
		foreach ($questions as $res) {
			$question_arr[] = [
				'question' => $res->question,
				'answers' => [
					["text" => $res->option_1, "correct" => $res->correct_option == 1],
					["text" => $res->option_2, "correct" => $res->correct_option == 2],
					["text" => $res->option_3, "correct" => $res->correct_option == 3],
					["text" => $res->option_4, "correct" => $res->correct_option == 4]

				],
				'explanation'=>$res->explanation
			];
		}
		$this->data['questions'] = json_encode($question_arr);
		$this->render('backend/standart/administrator/sp_mcq_practise/sp_question_practice', $this->data);
	}

	public function getCourse($teacher)
	{
		$data = $this->model_sp_mcq_practise->getCourseByTeacher($teacher);
		echo '<option value="">Select Course</option>';
		foreach ($data as $key => $value) {
			echo '<option value="' . $value->id . '">' . $value->name . '</option>';
		}
		die();
	}
}


/* End of file sp_mcq_exam.php */
/* Location: ./application/controllers/administrator/Sq Mcq Question.php */