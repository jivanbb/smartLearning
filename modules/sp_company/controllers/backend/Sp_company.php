<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question Controller
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question site
 *|
 */
class Sp_company extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_company');
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
		if (check_role_exist_or_not(23, array("view", "edit", "list"))) {
			$this->data['company_detail'] = $this->model_sp_company->get_company_detail(1);
			$this->template->title('Company Detail');
			$this->data['id'] =1;
			$this->render('backend/standart/administrator/sp_company/sp_company_detail', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	/**
	 * Update Sq Mcq Questions
	 *
	 * @var $id String
	 */
	public function edit_save($id)
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('phone_no', 'Phone', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('footer_note', 'Footer Note', 'trim|required');
		if ($this->form_validation->run()) {

			$save_data = [
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'phone_no' => $this->input->post('phone_no'),
				'email' => $this->input->post('email'),
				'fb_link' => $this->input->post('fb_link'),
				'twitter_link' => $this->input->post('twitter_link'),
				'youtube_link' => $this->input->post('youtube_link'),
				'linkedin_link' => $this->input->post('linkedin_link'),
				'footer_note' => $this->input->post('footer_note'),
				'edited_by' => get_user_data('id'),
				'edited_at' => date('Y-m-d')
			];
			$save_sp_company = $this->model_sp_company->change($id, $save_data);

			if ($save_sp_company) {
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
					$this->data['redirect'] = admin_base_url('/sp_company');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_company');
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
	 * delete Sq Mcq Questions
	 *
	 * @var $id String
	 */
	public function delete($id = null)
	{
		// $this->is_allowed('sp_company_delete');

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
					"message" => cclang('has_been_deleted', 'company')
				]);
			} else {
				$this->response([
					"success" => true,
					"message" => cclang('error_delete', 'company')
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

	/**
	 * delete Sq Mcq Questions
	 *
	 * @var $id String
	 */
	private function _remove($id)
	{

		return $this->model_sp_company->soft_delete($id);
	}
}


/* End of file sp_company.php */
/* Location: ./application/controllers/administrator/Sq Mcq Question.php */