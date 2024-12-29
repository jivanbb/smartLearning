<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question Controller
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question site
 *|
 */
class Sp_mcq_question extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_mcq_question');
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
		if (check_role_exist_or_not(13, array("view", "edit", "list"))) {
			$positions = get_user_position();
			$filter = $this->input->get('q');
			$field 	= $this->input->get('f');
			$param 	= $this->input->get();
			$id = get_user_data('id');
			if (check_role_exist_or_not(13, array('self_only'))) {
				foreach ($positions as $position) {
					if (@$position->group_id > 1) {
						$role = "self_only";
					} else {
						$role = "admin";
					}
				}
			} else {
				$role = "admin";
			}
			$this->data['sp_mcq_questions'] = $this->model_sp_mcq_question->get($id, $role, $param, $filter, $field, $this->limit_page, $offset);
			$this->data['sp_mcq_question_counts'] = $this->model_sp_mcq_question->count_all($id, $role, $param, $filter, $field);
			$this->data['offset'] = $offset;
			$this->data['user_id'] = $id;
			$this->data['filter'] = $param;
			$config = [
				'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_mcq_question/index/',
				'total_rows'   => $this->data['sp_mcq_question_counts'],
				'per_page'     => $this->limit_page,
				'uri_segment'  => 4,
			];

			$this->data['pagination'] = $this->pagination($config);

			$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_mcq_question/sp_mcq_question_data_table', $this->data, true);

			if ($this->input->get('ajax')) {
				$this->response([
					'tables' => $this->data['tables'],
					'pagination' => $this->data['pagination'],
					'total_row' => $this->data['sp_mcq_question_counts']
				]);
			}

			$this->template->title('Mcq Question List');
			$this->render('backend/standart/administrator/sp_mcq_question/sp_mcq_question_list', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	/**
	 * Add new sp_mcq_questions
	 *
	 */
	public function add()
	{
		if (!check_role_exist_or_not(13, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->template->title('Mcq Question New');
		$this->data['user_id'] = get_user_data('id');
		$this->render('backend/standart/administrator/sp_mcq_question/sp_mcq_question_add', $this->data);
	}

	/**
	 * Add New Sq Mcq Questions
	 *
	 * @return JSON
	 */
	public function add_save()
	{
		if (!check_role_exist_or_not(13, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->form_validation->set_rules('course_id', 'Course ', 'trim|required');
		$this->form_validation->set_rules('chapter_id', 'Chapter', 'trim|required');
		$this->form_validation->set_rules('no_of_options', 'No Of Options', 'trim|required');

		if ($this->form_validation->run()) {

			$save_data = [
				'course_id' => $this->input->post('course_id'),
				'chapter_id' => $this->input->post('chapter_id'),
				'topic_id' => $this->input->post('topic_id'),
				'no_of_options' => $this->input->post('no_of_options'),
				// 'set_id' => $this->input->post('set_id'),
				'created_by' => get_user_data('id'),
				'created_at' => date('Y-m-d')
			];
			$save_sp_mcq_question = $id = $this->model_sp_mcq_question->store($save_data);


			if ($save_sp_mcq_question) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_sp_mcq_question;
					$this->data['message'] = cclang('success_save_data_stay');
				} else {
					set_message(
						cclang('success_save_data_redirect'),
						'success'
					);

					$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_mcq_question');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_mcq_question');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
	}

	public function question_save()
	{
		$this->form_validation->set_rules('question', 'Question ', 'trim|required');
		$this->form_validation->set_rules('correct_option', 'Correct Option', 'trim|required');
		$this->form_validation->set_rules('question_type', 'Question Type', 'trim|required');
		if ($this->form_validation->run()) {
			$mcq_id = $this->input->post('mcq_id');
			$qno = $this->model_sp_mcq_question->count_questions($mcq_id);
			$save_data = [
				'mcq_id' => $mcq_id,
				'question' => $this->input->post('question'),
				'option_1' => $this->input->post('option_1'),
				'option_2' => $this->input->post('option_2'),
				'option_3' => $this->input->post('option_3'),
				'option_4' => $this->input->post('option_4'),
				'qno' => $qno + 1,
				'correct_option' => $this->input->post('correct_option'),
				'explanation' => $this->input->post('explanation'),
				'question_type' => $this->input->post('question_type'),
				'created_by' => get_user_data('id'),
				'created_at' => date('Y-m-d')
			];
			$this->db->insert('sp_mcq_detail', $save_data);
			$question_id = $this->db->insert_id();

			if ($question_id) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $question_id;
					$this->data['message'] = cclang('success_save_data_stay');
				} else {
					set_message(
						cclang('success_save_data_redirect'),
						'success'
					);

					$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_mcq_question');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_mcq_question');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
	}
	/**
	 * Update view Sq Mcq Questions
	 *
	 * @var $id String
	 */
	public function edit($id)
	{
		if (!check_role_exist_or_not(13, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->data['sp_mcq_question'] = $this->model_sp_mcq_question->find($id);
		$this->data['user_id'] = get_user_data('id');
		$this->template->title('Mcq Question Update');
		$this->render('backend/standart/administrator/sp_mcq_question/sp_mcq_question_update', $this->data);
	}
	public function view($id)
	{
		if (!check_role_exist_or_not(13, array("view"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->data['sp_mcq_question'] = $this->model_sp_mcq_question->get_mcq_detail($id);
		$this->data['question_detail'] = $this->model_sp_mcq_question->get_question_details($id);
		$this->template->title('Mcq Question View');
		$this->render('backend/standart/administrator/sp_mcq_question/sp_mcq_question_view', $this->data);
	}

	public function question($id)
	{
		$this->data['mcq_question'] = $this->model_sp_mcq_question->get_mcq_detail($id);
		$this->data['question_details'] = $this->model_sp_mcq_question->get_question_details($id);
		$this->template->title('Question');
		$this->render('backend/standart/administrator/sp_mcq_question/sp_question_add', $this->data);
	}

	public function question_edit($id)
	{
		$this->data['question_detail'] = $this->model_sp_mcq_question->get_question_detail($id);
		$this->data['user_id'] = get_user_data('id');
		$this->render('backend/standart/administrator/sp_mcq_question/sp_question_update', $this->data);
	}

	public function question_update($id)
	{
		$this->form_validation->set_rules('question', 'Question ', 'trim|required');
		$this->form_validation->set_rules('correct_option', 'Correct Option', 'trim|required');
		$this->form_validation->set_rules('question_type', 'Question Type', 'trim|required');
		if ($this->form_validation->run()) {
			$course_id = $this->input->post('course_id');
			$chapter_id = $this->input->post('chapter_id');
			$topic_id = $this->input->post('topic_id');
			$already_exist = $this->model_sp_mcq_question->check_already_exist($course_id, $chapter_id, $topic_id);
			if ($already_exist) {
				$mcq_id = $already_exist->id;
			}else{
				$mcq_detail =[
					'course_id'=>$course_id,
					'chapter_id'=>$chapter_id,
					'topic_id'=>$topic_id,
					'created_by'=> get_user_data('id'),
					'created_at'=>date('Y-m-d')
				];
				$this->db->insert('sp_mcq_question',$mcq_detail);
				$mcq_id = $this->db->insert_id();
			}
			$save_data = [
				'mcq_id'=>$mcq_id,
				'question' => $this->input->post('question'),
				'option_1' => $this->input->post('option_1'),
				'option_2' => $this->input->post('option_2'),
				'option_3' => $this->input->post('option_3'),
				'option_4' => $this->input->post('option_4'),
				'correct_option' => $this->input->post('correct_option'),
				'explanation' => $this->input->post('explanation'),
				'question_type' => $this->input->post('question_type'),
				'edited_by' => get_user_data('id'),
				'edited_at' => date('Y-m-d')
			];
			$question_id = $this->model_sp_mcq_question->update_question($id, $save_data);
			if ($question_id) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay');
				} else {
					set_message(
						cclang('success_update_data_redirect', []),
						'success'
					);

					$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_mcq_question/question/' . $mcq_id);
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_mcq_question/question/' . $mcq_id);
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
	}
	/**
	 * Update Sq Mcq Questions
	 *
	 * @var $id String
	 */
	public function edit_save($id)
	{

		$this->form_validation->set_rules('course_id', 'Course', 'trim|required');
		$this->form_validation->set_rules('chapter_id', 'Chapter', 'trim|required');
		$this->form_validation->set_rules('topic_id', 'Topic', 'trim|required');
		$this->form_validation->set_rules('no_of_options', 'No Of Options', 'trim|required');
		if ($this->form_validation->run()) {

			$save_data = [
				'course_id' => $this->input->post('course_id'),
				'chapter_id' => $this->input->post('chapter_id'),
				'topic_id' => $this->input->post('topic_id'),
				'no_of_options' => $this->input->post('no_of_options'),
				// 'set_id' => $this->input->post('set_id'),
				'edited_by' => get_user_data('id'),
				'edited_at' => date('Y-m-d')
			];
			$save_sp_mcq_question = $this->model_sp_mcq_question->change($id, $save_data);

			if ($save_sp_mcq_question) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						admin_anchor('/sp_mcq_question', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', []),
						'success'
					);

					$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_mcq_question');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_mcq_question');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
	}

	public function publish_exam()
    {
        $id =  $this->input->post('id');
        $this->db->set('is_publish',1);
        $this->db->where('id',$id);
        $this->db->update('sp_mcq_question');
        if ($id) {
            $data['success'] = true;
            $data['id']        = $id;
            $data['redirect'] = base_url('administrator/sp_mcq_question');
            $data['message'] = "Sucessfully Updated";
        } else {
            $data['success'] = false;
            $data['message'] = "Error in Save";
        }

    echo json_encode($data);
    exit;

    }

	public function getChapter($course_id)
	{
		$data = $this->model_sp_mcq_question->getChapterByCourse($course_id);
		echo '<option value="">Select Chapter</option>';
		foreach ($data as $key => $value) {
			echo '<option value="' . $value->id . '">' . $value->name . '</option>';
		}
		die();
	}


	public function getTopic($chapter_id)
	{
		$data = $this->model_sp_mcq_question->getTopicByChapter($chapter_id);
		echo '<option value="">Select Topic</option>';
		foreach ($data as $key => $value) {
			echo '<option value="' . $value->id . '">' . $value->name . '</option>';
		}
		die();
	}

	public function getCourseByUniversity($board_id)
	{
		$data = $this->model_sp_mcq_question->getCourseByUniversity($board_id);
		echo '<option value="">Select Course</option>';
		foreach ($data as $key => $value) {
			echo '<option value="' . $value->id . '">' . $value->name . '</option>';
		}
		die();
	}
	/**
	 * delete Sq Mcq Questions
	 *
	 * @var $id String
	 */
	public function delete($id = null)
	{
		// $this->is_allowed('sp_mcq_question_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->_remove($id);
		} elseif (count($arr_id) > 0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($this->input->get('ajax')) {
			if ($remove) {
				$this->response([
					"success" => true,
					"message" => cclang('has_been_deleted', 'mcq_question')
				]);
			} else {
				$this->response([
					"success" => true,
					"message" => cclang('error_delete', 'mcq_question')
				]);
			}
		} else {
			if ($remove) {
				set_message(cclang('has_been_deleted', 'mcq_question'), 'success');
			} else {
				set_message(cclang('error_delete', 'mcq_question'), 'error');
			}
			redirect_back();
		}
	}

	public function question_delete($id = null)
	{
		$question_detail = $this->model_sp_mcq_question->get_question_detail($id);
		$remove = $this->model_sp_mcq_question->question_delete($id);

		if ($remove) {
			set_message(cclang('has_been_deleted', 'question'), 'success');
		} else {
			set_message(cclang('error_delete', 'question'), 'error');
		}
		redirect('administrator/sp_mcq_question/question/' . $question_detail->mcq_id);
		// redirect_back();

	}


	/**
	 * delete Sq Mcq Questions
	 *
	 * @var $id String
	 */
	private function _remove($id)
	{

		return $this->model_sp_mcq_question->soft_delete($id);
	}
}


/* End of file sp_mcq_question.php */
/* Location: ./application/controllers/administrator/Sq Mcq Question.php */