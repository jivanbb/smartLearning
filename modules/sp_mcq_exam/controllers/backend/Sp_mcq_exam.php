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
		$id = decrypt_string($id);
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
				'question_id' => $res->id,
				'question' => $res->question,
				'options' => [
					$res->option_1,
					$res->option_2,
					$res->option_3,
					$res->option_4
				],
				'answer' => $correct_option,
			];
		}
		$this->data['question_mark'] = $mcq_exam->question_marks;
		$this->data['time'] = $mcq_exam->time * 60;
		$this->data['time_min'] = $mcq_exam->time;
		$this->data['start_time'] = date('Y-m-d H:i:s');
		$this->data['questions'] = json_encode($question_arr);
		$this->data['exam_id'] = $id;
		$this->render('backend/standart/administrator/sp_mcq_exam/sp_mcq_exam', $this->data);
	}

	public function save_exam()
	{
		$exam_start_time = $this->input->post('start_time');
		$submitted_time = date('Y-m-d H:i:s');
		$start_time = new DateTime($exam_start_time);
        $end_time_obj = new DateTime($submitted_time);
        $time_taken = $start_time->diff($end_time_obj)->s + 
                      ($start_time->diff($end_time_obj)->i * 60) + 
                      ($start_time->diff($end_time_obj)->h * 3600);
		$questions =	$this->input->post('question');
		$exam_id =	$this->input->post('exam_id');
		$question_mark =	$this->input->post('question_mark');
		$wrong_detail =	$this->input->post('wrong_detail');
		$wrong =	$this->input->post('wrong');
		$correct =	$this->input->post('correct');
		$not_answered =	$this->input->post('not_answered');
		$wrong_ans =	$this->input->post('wrong_ans');
		$wrong_ans_list = explode(",", $wrong_ans);
		$correct_ans =	$this->input->post('correct_ans');
		$correct_ans_list = explode(",", $correct_ans);
		$not_answered_list =	$this->input->post('not_answered_list');
		$not_answered_array = explode(",", $not_answered_list);
		$score =$correct*$question_mark;
		$exam_data = [
			'exam_id' => $exam_id,
			'questions' => json_encode($questions),
			'wrong' => $wrong,
			'correct' => $correct,
			'score'=>$score,
			'not_answered' => $not_answered,
			'wrong_ans' => json_encode($wrong_ans_list),
			'correct_ans' => json_encode($correct_ans_list),
			'not_ans' => json_encode($not_answered_array),
			'user_id' => get_user_data('id'),
			'time_taken'=>$time_taken,
			'start_time'=>$exam_start_time,
			'submitted_time' => $submitted_time,
			'created_at'=>date('Y-m-d')
		];
		$this->db->insert('sp_exam_result', $exam_data);
		$result_id = $this->db->insert_id();
		$wrong_detail_list = json_decode($wrong_detail);
		foreach ($wrong_detail_list as $data) {
			$result_data = [
				'result_id' => $result_id,
				'question_id' => $data->qn,
				'ans' => $data->ans
			];
			$this->db->insert('sp_result_detail', $result_data);
		}
		if ($result_id) {

			$this->data['success'] = true;
			$this->data['id'] 	   = $result_id;
			$this->data['redirect'] = base_url('administrator/sp_mcq_exam/exam_result/' . $result_id);
			$this->data['message'] = cclang('success_save_data_stay');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = cclang('data_not_change');
		}
		$this->response($this->data);
	}

	public function exam_result($id)
	{
		$user_id=get_user_data('id');
		$this->data['exam_detail'] = $this->model_sp_mcq_exam->get_exam_result_detail($id);
		$this->data['id'] = $id;
		$this->data['rank']=get_student_rank($this->data['exam_detail']->exam_id,$user_id,$id);
		$this->data['total_user'] = count_total_exam_attended($this->data['exam_detail']->exam_id);
		$this->render('backend/standart/administrator/sp_mcq_exam/sp_exam_result', $this->data);
	}

	public function exam_result_detail($id)
	{
		$this->data['exam_detail'] = $this->model_sp_mcq_exam->get_exam_result_detail($id);
		$this->data['id'] = $id;
		$this->render('backend/standart/administrator/sp_mcq_exam/sp_exam_result_detail', $this->data);
	}
}


/* End of file sp_mcq_exam.php */
/* Location: ./application/controllers/administrator/Sq Mcq Question.php */