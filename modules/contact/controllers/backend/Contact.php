<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sp Contact Controller
 *| --------------------------------------------------------------------------
 *| Sp Contact site
 *|
 */
class Contact extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_contact');
		$this->load->model('group/model_group');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	 * show all Sp Contacts
	 *
	 * @var $offset String
	 */
	public function index($offset = 0)
	{
		if (check_role_exist_or_not(22, array("view", "list"))) {
			$filter = $this->input->get('q');
			$field 	= $this->input->get('f');

			$this->data['contacts'] = $this->model_contact->get($filter, $field, $this->limit_page, $offset);
			$this->data['contact_counts'] = $this->model_contact->count_all($filter, $field);

			$config = [
				'base_url'     => ADMIN_NAMESPACE_URL  . '/contact/index/',
				'total_rows'   => $this->data['contact_counts'],
				'per_page'     => $this->limit_page,
				'uri_segment'  => 4,
			];

			$this->data['pagination'] = $this->pagination($config);

			$this->data['tables'] = $this->load->view('backend/standart/administrator/contact/contact_data_table', $this->data, true);

			if ($this->input->get('ajax')) {
				$this->response([
					'tables' => $this->data['tables'],
					'pagination' => $this->data['pagination'],
					'total_row' => $this->data['contact_counts']
				]);
			}

			$this->template->title('Contact List');
			$this->render('backend/standart/administrator/contact/contact_list', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}
}


/* End of file sp_contact.php */
/* Location: ./application/controllers/administrator/Sp Contact.php */