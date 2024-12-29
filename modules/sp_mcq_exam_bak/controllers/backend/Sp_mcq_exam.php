<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question Controller
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question site
 *|
 */
class Sp_mcq_exam extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_mcq_exam');
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
		$this->data['teachers'] = $this->model_sp_mcq_exam->get_teachers();
		$this->data['results'] = $this->model_sp_mcq_exam->get_mcq_exam_list($filter);
		$this->data['filter'] = $filter;
		$this->template->title('Mcq Exam List');
		$this->render('backend/standart/administrator/sp_mcq_exam/sp_mcq_exam_list', $this->data);
	}

	public function start_exam($id)
	{
		$id =decrypt_string($id);
		$question_arr = [];
		$combinedArray = [];
		$mcq_exam = $this->model_sp_mcq_exam->get_mcq_exam($id);
		$exam_details = $this->model_sp_mcq_exam->get_mcq_exam_detail($id);
		foreach ($exam_details as $data) {
			$questions = $this->model_sp_mcq_exam->get_questions_detail($data->chapter_id, $data->no_of_question);
			$combinedArray = array_merge($combinedArray, $questions);
		}

		foreach ($combinedArray  as $key => $res) {
			if ($res->correct_option == 1) {
				$correct_option = $res->option_1;
			} elseif ($res->correct_option == 2) {
				$correct_option = $res->option_2;
			} elseif ($res->correct_option == 3) {
				$correct_option = $res->option_3;
			} elseif ($res->correct_option == 4) {
				$correct_option = $res->option_4;
			} else {
				$correct_option = '';
			}
			$question_arr[] = [
				'id' => $key + 1,
				'question' => $res->question,
				'options' => [
					[
						"option_1" => $res->option_1,
						"option_2" => $res->option_2,
						"option_3" => $res->option_3,
						"option_4" => $res->option_4
					]

				],
				'answer' => $correct_option,
				'score' => 0,
				'status' => ''
			];
		}
		$this->data['question_mark'] =$mcq_exam->question_marks;
		$this->data['time'] = $mcq_exam->time * 60;
		$this->data['questions'] = json_encode($question_arr);
		$this->render('backend/standart/administrator/sp_mcq_exam/sp_mcq_exam', $this->data);
	}
}


/* End of file sp_mcq_exam.php */
/* Location: ./application/controllers/administrator/Sq Mcq Question.php */