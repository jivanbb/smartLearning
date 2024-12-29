<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Blog Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Contact extends Front
{
	
	public function __construct()
	{
		parent::__construct();
        $this->load->model('model_contact');
	}

    public function index($offset = 0) 
    {
        $this->template->build('contact/index', $this->data);
    }

    public function add_save()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
		if ($this->form_validation->run()) {

			$save_data = [
				'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone_no' => $this->input->post('phone_no'),
                'subject' => $this->input->post('subject'),
                'description' => $this->input->post('message'),
				'created_at' => date('Y-m-d H:i:s'),
			];

			$contact_id = $id = $this->model_contact->store($save_data);
			if ($contact_id) {
					$this->data['success'] = true;
					$this->data['id'] 	   = $contact_id;
                    $this->data['redirect'] 	   = base_url('contact');
					$this->data['message'] = cclang('success_save_data_stay');			
			} else {

					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
			}
		} else {
			$this->data['success'] = false;
			$this->data['errors'] = validation_errors();
		}

		$this->response($this->data);
		exit;
	}
 
}


/* End of file Blog.php */
/* Location: ./application/controllers/Blog.php */