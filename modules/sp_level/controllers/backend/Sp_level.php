<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Sp Level Controller
*| --------------------------------------------------------------------------
*| Sp Level site
*|
*/
class Sp_level extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_level');
		$this->load->model('group/model_group');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Sp Levels
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['sp_levels'] = $this->model_sp_level->get($filter, $field, $this->limit_page, $offset);
		$this->data['sp_level_counts'] = $this->model_sp_level->count_all($filter, $field);

		$config = [
			'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_level/index/',
			'total_rows'   => $this->data['sp_level_counts'],
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		
		$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_level/sp_level_data_table', $this->data, true);
		
		if ($this->input->get('ajax')) {
			$this->response([
				'tables' => $this->data['tables'],
				'pagination' => $this->data['pagination'],
				'total_row' => $this->data['sp_level_counts']
			]);
		}

		$this->template->title('Level List');
		$this->render('backend/standart/administrator/sp_level/sp_level_list', $this->data);
	}
	
	/**
	* Add new sp_levels
	*
	*/
	public function add()
	{

		$this->template->title('Level New');
		$this->render('backend/standart/administrator/sp_level/sp_level_add', $this->data);
	}

	/**
	* Add New Sp Levels
	*
	* @return JSON
	*/
	public function add_save()
	{
		

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run()) {
		
			$save_data = [
				'name' => $this->input->post('name'),
				'created_at'=>date('Y-m-d')
			];
			$save_sp_level = $id = $this->model_sp_level->store($save_data);
            

			if ($save_sp_level) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_sp_level;
					$this->data['message'] = cclang('success_save_data_stay');
				} else {
					set_message(
						cclang('success_save_data_redirect'), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_level');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_level');
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
	* Update view Sp Levels
	*
	* @var $id String
	*/
	public function edit($id)
	{

		$this->data['sp_level'] = $this->model_sp_level->find($id);

		$this->template->title('Level Update');
		$this->render('backend/standart/administrator/sp_level/sp_level_update', $this->data);
	}

	/**
	* Update Sp Levels
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		
				$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run()) {
		
			$save_data = [
				'name' => $this->input->post('name'),

			];
			$save_sp_level = $this->model_sp_level->change($id, $save_data);
			if ($save_sp_level) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						admin_anchor('/sp_level', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_level');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_level');
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
	* delete Sp Levels
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$this->is_allowed('sp_level_delete');

		$this->load->helper('file');

		$arr_id = $this->input->get('id');
		$remove = false;

		if (!empty($id)) {
			$remove = $this->_remove($id);
		} elseif (count($arr_id) >0) {
			foreach ($arr_id as $id) {
				$remove = $this->_remove($id);
			}
		}

		if ($this->input->get('ajax')) {
			if ($remove) {
				$this->response([
					"success" => true,
					"message" => cclang('has_been_deleted', 'sp_level')
				]);
			} else {
				$this->response([
					"success" => true,
					"message" => cclang('error_delete', 'sp_level')
				]);
			}

		} else {
			if ($remove) {
				set_message(cclang('has_been_deleted', 'sp_level'), 'success');
			} else {
				set_message(cclang('error_delete', 'sp_level'), 'error');
			}
			redirect_back();
		}

	}

		
	
	/**
	* delete Sp Levels
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		
		
		return $this->model_sp_level->remove($id);
	}
	
	
	

	
}


/* End of file sp_level.php */
/* Location: ./application/controllers/administrator/Sp Level.php */