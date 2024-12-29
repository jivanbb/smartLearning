<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sp Course Controller
 *| --------------------------------------------------------------------------
 *| Sp Course site
 *|
 */
class Sp_course extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_course');
		$this->load->model('group/model_group');
		$this->lang->load('web_lang', $this->current_lang);
		if (!$this->session->userdata('loggedin')) {
			redirect('/', 'refresh');
		}
	}

	/**
	 * show all Sp Courses
	 *
	 * @var $offset String
	 */
	public function index($offset = 0)
	{
		if (check_role_exist_or_not(9, array("view", "edit", "list"))) {
			$positions = get_user_position();
			$filter = $this->input->get('q');
			$field 	= $this->input->get('f');
			$params 	= $this->input->get('param');
			$id = get_user_data('id');
			if (check_role_exist_or_not(9, array('self_only'))) {
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
			$this->data['sp_courses'] = $this->model_sp_course->get($id, $role, $params, $filter, $field, $this->limit_page, $offset);
			$this->data['sp_course_counts'] = $this->model_sp_course->count_all($id, $role, $params, $filter, $field);
			$this->data['user_id'] = $id;
			$config = [
				'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_course/index/',
				'total_rows'   => $this->data['sp_course_counts'],
				'per_page'     => $this->limit_page,
				'uri_segment'  => 4,
			];

			$this->data['pagination'] = $this->pagination($config);

			$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_course/sp_course_data_table', $this->data, true);

			if ($this->input->get('ajax')) {
				$this->response([
					'tables' => $this->data['tables'],
					'pagination' => $this->data['pagination'],
					'total_row' => $this->data['sp_course_counts']
				]);
			}

			$this->template->title('Course List');
			$this->render('backend/standart/administrator/sp_course/sp_course_list', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	/**
	 * Add new sp_courses
	 *
	 */
	public function add()
	{
		if (!check_role_exist_or_not(9, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->template->title(' Course New');
		$this->render('backend/standart/administrator/sp_course/sp_course_add', $this->data);
	}

	/**
	 * Add New Sp Courses
	 *
	 * @return JSON
	 */
	public function add_save()
	{
		if (!check_role_exist_or_not(9, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->form_validation->set_rules('name[]', 'Name', 'trim|callback_check_course');
		$this->form_validation->set_rules('board_university', 'Board/University', 'trim|required');
		// $this->form_validation->set_rules('sp_course_image_name', 'Image', 'trim|required');
		if ($this->form_validation->run()) {
			$sp_course_image_uuid = $this->input->post('sp_course_image_uuid');
			$sp_course_image_name = $this->input->post('sp_course_image_name');
			$save_sp_course = false;
			$name = $this->input->post('name');
			$amount = $this->input->post('amount');
			$valid_days = $this->input->post('valid_days');
			$count = sizeof($name);
			for ($i = 0; $i < $count; $i++) {
				$save_data = [
					'name' => $name[$i],
					'board_university' => $this->input->post('board_university'),
					'amount'=>$amount,
					'valid_days'=>$valid_days,
					'created_by' => get_user_data('id'),
					'created_at' => date('Y-m-d')
				];
				if (!is_dir(FCPATH . '/uploads/sp_course/')) {
					mkdir(FCPATH . '/uploads/sp_course/');
				}
	
				if (!empty($sp_course_image_name)) {
					$sp_course_image_name_copy = date('YmdHis') . '-' . $sp_course_image_name;
	
					rename(
						FCPATH . 'uploads/tmp/' . $sp_course_image_uuid . '/' . $sp_course_image_name,
						FCPATH . 'uploads/sp_course/' . $sp_course_image_name_copy
					);
	
					if (!is_file(FCPATH . '/uploads/sp_course/' . $sp_course_image_name_copy)) {
						echo json_encode([
							'success' => false,
							'message' => 'Error uploading file'
						]);
						exit;
					}
	
					$save_data['image'] = $sp_course_image_name_copy;
				}
				$save_sp_course = $id = $this->model_sp_course->store($save_data);
				$save_sp_course = true;
			}
		

			if ($save_sp_course) {
				$this->data['success'] = true;
				$this->data['id'] 	   = $save_sp_course;
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
	 * Update view Sp Courses
	 *
	 * @var $id String
	 */
	public function edit($id)
	{
		if (!check_role_exist_or_not(9, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->data['sp_course'] = $this->model_sp_course->find($id);
		$this->data['user_id'] = $id = get_user_data('id');
		$this->template->title('Course Update');
		$this->render('backend/standart/administrator/sp_course/sp_course_update', $this->data);
	}

	/**
	 * Update Sp Courses
	 *
	 * @var $id String
	 */
	public function edit_save($id)
	{
		if (!check_role_exist_or_not(9, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('board_university', 'Board/University', 'trim|required');
		// $this->form_validation->set_rules('sp_course_image_name', 'Image', 'trim|required');
		if ($this->form_validation->run()) {
			$sp_course_image_uuid = $this->input->post('sp_course_image_uuid');
			$sp_course_image_name = $this->input->post('sp_course_image_name');
			$save_data = [
				'name' => $this->input->post('name'),
				'valid_days' => $this->input->post('valid_days'),
				'amount'=> $this->input->post('amount'),
				'board_university' => $this->input->post('board_university'),
			];

			if (!is_dir(FCPATH . '/uploads/sp_course/')) {
				mkdir(FCPATH . '/uploads/sp_course/');
			}

			if (!empty($sp_course_image_uuid)) {
				$sp_course_image_name_copy = date('YmdHis') . '-' . $sp_course_image_name;

				rename(
					FCPATH . 'uploads/tmp/' . $sp_course_image_uuid . '/' . $sp_course_image_name,
					FCPATH . 'uploads/sp_course/' . $sp_course_image_name_copy
				);

				if (!is_file(FCPATH . '/uploads/sp_course/' . $sp_course_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
					]);
					exit;
				}

				$save_data['image'] = $sp_course_image_name_copy;
			}
			$save_sp_course = $this->model_sp_course->change($id, $save_data);

			if ($save_sp_course) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						admin_anchor('/sp_course', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', []),
						'success'
					);

					$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_course');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_course');
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
	 * delete Sp Courses
	 *
	 * @var $id String
	 */
	public function delete($id = null)
	{
		if (!check_role_exist_or_not(9, array("delete"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}

		$this->load->helper('file');
		$child_tables = array(
			'sp_chapter' => 'course_id',
			'sp_topic' => 'course_id',
			'sp_mcq_question' => 'course_id',
		);
		$field = 'id';
		$exist = $this->model_sp_course->check_child_data_exist('sp_course', $id, $child_tables, $field);
		if ($exist) {
			$this->session->set_flashdata('f_message', 'Sorry this course is used ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/oms_branch', 'refresh');
		}
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
					"message" => cclang('has_been_deleted', 'course')
				]);
			} else {
				$this->response([
					"success" => true,
					"message" => cclang('error_delete', 'course')
				]);
			}
		} else {
			if ($remove) {
				set_message(cclang('has_been_deleted', 'course'), 'success');
			} else {
				set_message(cclang('error_delete', 'course'), 'error');
			}
			redirect_back();
		}
	}

	public function check_course()
	{
		$names = $this->input->post('name');
		$id = get_user_data('id');
		$validated = true;
		foreach ($names as $name) {
			if (empty($name)) {
				$validated = false;
				$this->form_validation->set_message('check_course', 'Please insert Course Name.');
			}
			$result = $this->model_sp_course->check_already_exist($name, $id);
			if(!empty($result)){
				$validated = false;
				$this->form_validation->set_message('check_course', ''.$result->name.' already exist');
			}
		}
		return $validated;
	}

	/**
	 * delete Sp Courses
	 *
	 * @var $id String
	 */
	private function _remove($id)
	{
		return $this->model_sp_course->soft_delete($id);
	}

	public function upload_image_file()
	{
	
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'sp_course',
		]);
	}

	/**
	 * Delete Image Sp Ad	* 
	 * @return JSON
	 */
	public function delete_image_file($uuid)
	{
	
	echo $this->delete_file([
			'uuid'              => $uuid,
			'delete_by'         => $this->input->get('by'),
			'field_name'        => 'image',
			'upload_path_tmp'   => './uploads/tmp/',
			'table_name'        => 'sp_course',
			'primary_key'       => 'id',
			'upload_path'       => 'uploads/sp_course/'
		]);
	}

	/**
	 * Get Image Sp Ad	* 
	 * @return JSON
	 */
	public function get_image_file($id)
	{
		echo $this->get_file([
			'uuid'              => $id,
			'delete_by'         => 'id',
			'field_name'        => 'image',
			'table_name'        => 'sp_course',
			'primary_key'       => 'id',
			'upload_path'       => 'uploads/sp_course/',
			'delete_endpoint'   => ADMIN_NAMESPACE_URL  .  '/sp_course/delete_image_file'
		]);
	}


	/**
	 * Export to excel
	 *
	 * @return Files Excel .xls
	 */
	public function export()
	{
		$this->is_allowed('sp_course_export');

		$this->model_sp_course->export(
			'sp_course',
			'sp_course',
			$this->model_sp_course->field_search
		);
	}

	/**
	 * Export to PDF
	 *
	 * @return Files PDF .pdf
	 */
	public function export_pdf()
	{
		$this->is_allowed('sp_course_export');

		$this->model_sp_course->pdf('sp_course', 'sp_course');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('sp_course_export');

		$table = $title = 'sp_course';
		$this->load->library('HtmlPdf');

		$config = array(
			'orientation' => 'p',
			'format' => 'a4',
			'marges' => array(5, 5, 5, 5)
		);

		$this->pdf = new HtmlPdf($config);
		$this->pdf->setDefaultFont('stsongstdlight');

		$result = $this->db->get($table);

		$data = $this->model_sp_course->find($id);
		$fields = $result->list_fields();

		$content = $this->pdf->loadHtmlPdf('core_template/pdf/pdf_single', [
			'data' => $data,
			'fields' => $fields,
			'title' => $title
		], TRUE);

		$this->pdf->initialize($config);
		$this->pdf->pdf->SetDisplayMode('fullpage');
		$this->pdf->writeHTML($content);
		$this->pdf->Output($table . '.pdf', 'H');
	}
}


/* End of file sp_course.php */
/* Location: ./application/controllers/administrator/Sp Course.php */