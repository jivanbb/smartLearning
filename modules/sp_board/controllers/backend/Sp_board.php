<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sp Board Controller
 *| --------------------------------------------------------------------------
 *| Sp Board site
 *|
 */
class Sp_board extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_board');
		$this->load->model('group/model_group');
		$this->lang->load('web_lang', $this->current_lang);
		if (!$this->session->userdata('loggedin')) {
			redirect('/', 'refresh');
		}
	}

	/**
	 * show all Sp Boards
	 *
	 * @var $offset String
	 */
	public function index($offset = 0)
	{
		if (check_role_exist_or_not(8, array( "view","edit","list"))) {
		$positions = get_user_position();
		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		$id = get_user_data('id');
		if (check_role_exist_or_not(8, array('self_only'))) {
			foreach ($positions as $position) {
				if (@$position->group_id > 1) {
					$role ="self_only";
				} else {
					$role ="admin";
				}
			}
		} else {
			$role ="admin";
		}
		$this->data['sp_boards'] = $this->model_sp_board->get($id,$role, $filter, $field, $this->limit_page, $offset);
		$this->data['sp_board_counts'] = $this->model_sp_board->count_all($id,$role, $filter, $field);
		$this->data['offset'] = $offset;
		$config = [
			'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_board/index/',
			'total_rows'   => $this->data['sp_board_counts'],
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_board/sp_board_data_table', $this->data, true);

		if ($this->input->get('ajax')) {
			$this->response([
				'tables' => $this->data['tables'],
				'pagination' => $this->data['pagination'],
				'total_row' => $this->data['sp_board_counts']
			]);
		}

		$this->template->title('Board List');
		$this->render('backend/standart/administrator/sp_board/sp_board_list', $this->data);
	} else {
		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		$this->session->set_flashdata('f_type', 'warning');
		redirect('administrator/dashboard','refresh');
	}
	}

	/**
	 * Add new sp_boards
	 *
	 */
	public function add()
	{
		if (check_role_exist_or_not(8, array( "add"))) {

		$this->template->title('Board New');
		$this->render('backend/standart/administrator/sp_board/sp_board_add', $this->data);
	} else {
		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		$this->session->set_flashdata('f_type', 'warning');
		redirect('administrator/dashboard','refresh');
	}
	}

	/**
	 * Add New Sp Boards
	 *
	 * @return JSON
	 */
	public function add_save()
	{
		if (!check_role_exist_or_not(8, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard','refresh');
		}
		$this->form_validation->set_rules('name', 'Name', 'trim|callback_check_university');

		if ($this->form_validation->run()) {

			$save_data = [
				'name' => $this->input->post('name'),
				'created_at' => date('Y-m-d'),
				'created_by' => get_user_data('id'),
			];

			$save_sp_board = $id = $this->model_sp_board->store($save_data);


			if ($save_sp_board) {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_sp_board;
					$this->data['message'] = cclang('success_save_data_stay');			
			} else {

					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
		exit;
	}

	/**
	 * Update view Sp Boards
	 *
	 * @var $id String
	 */
	public function edit($id)
	{
		if (check_role_exist_or_not(8, array( "edit"))) {

		$this->data['sp_board'] = $this->model_sp_board->find($id);

		$this->template->title('Board Update');
		$this->render('backend/standart/administrator/sp_board/sp_board_update', $this->data);
	} else {
		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		$this->session->set_flashdata('f_type', 'warning');
		redirect('administrator/dashboard','refresh');
	}
	}

	/**
	 * Update Sp Boards
	 *
	 * @var $id String
	 */
	public function edit_save($id)
	{
		if (!check_role_exist_or_not(8, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard','refresh');
		}
		$this->form_validation->set_rules('name', 'Name', 'trim|required');



		if ($this->form_validation->run()) {

			$save_data = [
				'name' => $this->input->post('name'),
			];

			$save_sp_board = $this->model_sp_board->change($id, $save_data);

			if ($save_sp_board) {
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
					$this->data['redirect'] = admin_base_url('/sp_board');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_board');
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
	 * delete Sp Boards
	 *
	 * @var $id String
	 */
	public function delete($id = null)
	{
		if (!check_role_exist_or_not(8, array("delete"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard','refresh');
		}

		$this->load->helper('file');
		$child_tables = array(
			'sp_course' => 'board_university',
		);
		$field = 'id';
		$exist = $this->model_sp_board->check_child_data_exist('sp_board', $id, $child_tables, $field);
		if ($exist) {
			$this->session->set_flashdata('f_message', 'Sorry this Board/University is used ');
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
					"message" => cclang('has_been_deleted', 'board')
				]);
			} else {
				$this->response([
					"success" => true,
					"message" => cclang('error_delete', 'board')
				]);
			}
		} else {
			if ($remove) {
				set_message(cclang('has_been_deleted', 'board'), 'success');
			} else {
				set_message(cclang('error_delete', 'board'), 'error');
			}
			redirect_back();
		}
	}

	public function check_university(){
		$name =$this->input->post('name');
		$id = get_user_data('id');
		if(empty($name)){
			$this->form_validation->set_message('check_university', 'Please Insert Board/University');
			return FALSE;
		}
		$result = $this->model_sp_board->check_already_name($name,$id);
			if(!empty($result)){
				$this->form_validation->set_message('check_university', ''.$result->name.' already exist');
				return FALSE;
			}
	}



	/**
	 * delete Sp Boards
	 *
	 * @var $id String
	 */
	private function _remove($id)
	{

		return $this->model_sp_board->soft_delete($id);
	}


	/**
	 * Export to excel
	 *
	 * @return Files Excel .xls
	 */
	public function export()
	{
		$this->is_allowed('sp_board_export');

		$this->model_sp_board->export(
			'sp_board',
			'sp_board',
			$this->model_sp_board->field_search
		);
	}

	/**
	 * Export to PDF
	 *
	 * @return Files PDF .pdf
	 */
	public function export_pdf()
	{
		$this->is_allowed('sp_board_export');

		$this->model_sp_board->pdf('sp_board', 'sp_board');
	}



}


/* End of file sp_board.php */
/* Location: ./application/controllers/administrator/Sp Board.php */