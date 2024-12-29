<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sp Chapter Controller
 *| --------------------------------------------------------------------------
 *| Sp Chapter site
 *|
 */
class Sp_chapter extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_chapter');
		$this->load->model('group/model_group');
		$this->lang->load('web_lang', $this->current_lang);
		if (!$this->session->userdata('loggedin')) {
			redirect('/', 'refresh');
		}
	}

	/**
	 * show all Sp Chapters
	 *
	 * @var $offset String
	 */
	public function index($offset = 0)
	{
		if (check_role_exist_or_not(10, array("view", "edit", "list"))) {
			$positions = get_user_position();
			$filter = $this->input->get('q');
			$field 	= $this->input->get('f');
			$param 	= $this->input->get();
			$id = get_user_data('id');
			if (check_role_exist_or_not(10, array('self_only'))) {
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
			$this->data['sp_chapters'] = $this->model_sp_chapter->get($id, $role, $param, $filter, $field, $this->limit_page, $offset);
			$this->data['sp_chapter_counts'] = $this->model_sp_chapter->count_all($id, $role, $param, $filter, $field);
			$this->data['filter'] = $param;
			$this->data['user_id'] = $id;
			$config = [
				'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_chapter/index/',
				'total_rows'   => $this->data['sp_chapter_counts'],
				'per_page'     => $this->limit_page,
				'uri_segment'  => 4,
			];

			$this->data['pagination'] = $this->pagination($config);

			$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_chapter/sp_chapter_data_table', $this->data, true);

			if ($this->input->get('ajax')) {
				$this->response([
					'tables' => $this->data['tables'],
					'pagination' => $this->data['pagination'],
					'total_row' => $this->data['sp_chapter_counts']
				]);
			}

			$this->template->title('Chapter List');
			$this->render('backend/standart/administrator/sp_chapter/sp_chapter_list', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	/**
	 * Add new sp_chapters
	 *
	 */
	public function add()
	{
		if (!check_role_exist_or_not(10, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->template->title('Chapter New');
		$this->render('backend/standart/administrator/sp_chapter/sp_chapter_add', $this->data);
	}

	/**
	 * Add New Sp Chapters
	 *
	 * @return JSON
	 */
	public function add_save()
	{
		if (!check_role_exist_or_not(10, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->form_validation->set_rules('course_id', 'Course', 'trim|required');
		$this->form_validation->set_rules('name[]', 'Chapter Name', 'trim|callback_check_chapter');
		if ($this->form_validation->run()) {
			$save_sp_chapter = false;
			$name = $this->input->post('name');
			$count = sizeof($name);
			for ($i = 0; $i < $count; $i++) {
				$save_data = [
					'course_id' => $this->input->post('course_id'),
					'name' => $name[$i],
					'created_by' => get_user_data('id'),
					'created_at' => date('Y-m-d')
				];
				$this->model_sp_chapter->store($save_data);
				$save_sp_chapter = true;
			}
			if ($save_sp_chapter) {

				$this->data['success'] = true;
				$this->data['id'] 	   = $save_sp_chapter;
				$this->data['message'] = cclang('success_save_data_stay');
			} else {
				$this->data['success'] = false;
				$this->data['message'] = cclang('data_not_change');
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
			// $this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
	}

	/**
	 * Update view Sp Chapters
	 *
	 * @var $id String
	 */
	public function edit($id)
	{
		if (!check_role_exist_or_not(10, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->data['sp_chapter'] = $this->model_sp_chapter->find($id);
		$this->data['user_id'] = get_user_data('id');
		$this->template->title('Chapter Update');
		$this->render('backend/standart/administrator/sp_chapter/sp_chapter_update', $this->data);
	}

	/**
	 * Update Sp Chapters
	 *
	 * @var $id String
	 */
	public function edit_save($id)
	{
		if (!check_role_exist_or_not(10, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->form_validation->set_rules('course_id', 'Course', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');

		if ($this->form_validation->run()) {

			$save_data = [
				'course_id' => $this->input->post('course_id'),
				'name' => $this->input->post('name'),
			];
			$save_sp_chapter = $this->model_sp_chapter->change($id, $save_data);

			if ($save_sp_chapter) {
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
					$this->data['redirect'] = admin_base_url('/sp_chapter');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_chapter');
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
	 * delete Sp Chapters
	 *
	 * @var $id String
	 */
	public function delete($id = null)
	{
		if (!check_role_exist_or_not(10, array("delete"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}

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
					"message" => cclang('has_been_deleted', 'chapter')
				]);
			} else {
				$this->response([
					"success" => true,
					"message" => cclang('error_delete', 'chapter')
				]);
			}
		} else {
			if ($remove) {
				set_message(cclang('has_been_deleted', 'chapter'), 'success');
			} else {
				set_message(cclang('error_delete', 'hapter'), 'error');
			}
			redirect_back();
		}
	}



	/**
	 * delete Sp Chapters
	 *
	 * @var $id String
	 */
	private function _remove($id)
	{
		return $this->model_sp_chapter->soft_delete($id);
	}

	public function check_chapter()
	{
		$course_id = $this->input->post('course_id');
		$names = $this->input->post('name');
		$id = get_user_data('id');
		$validated = true;
		foreach ($names as $name) {
			if (empty($name)) {
				$validated = false;
				$this->form_validation->set_message('check_chapter', 'Please insert Chapter Name.');
			}
			$result = $this->model_sp_chapter->check_already_exist($course_id,$name, $id);
			if(!empty($result)){
				$validated = false;
				$this->form_validation->set_message('check_chapter', ''.$result->name.' already exist');
			}
		}
		return $validated;
	}
}


/* End of file sp_chapter.php */
/* Location: ./application/controllers/administrator/Sp Chapter.php */