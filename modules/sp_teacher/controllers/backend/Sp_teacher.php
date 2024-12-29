<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question Controller
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question site
 *|
 */
class Sp_teacher extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_teacher');
		if (!$this->session->userdata('loggedin')) {
			redirect('/', 'refresh');
		}
	}

	/**
	 * show all Sq Mcq Questions
	 *
	 * @var $offset String
	 */
	public function index()
	{
		if (!check_role_exist_or_not(6, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->template->title('Create Teacher');
		$this->data['user_id'] = get_user_data('id');
		$this->render('backend/standart/administrator/sp_teacher/sp_teacher_add', $this->data);
	}

	public function add_save()
	{
		
		$this->form_validation->set_rules('education', 'Education', 'trim|required');
		$this->form_validation->set_rules('experience', 'Experience', 'trim|required');
		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		if ($this->form_validation->run()) {
			$id = $this->input->post('id');
			$user_id = get_user_data('id');
			$teacher_data = [
				'education' => $this->input->post('education'),
				'specialization' => $this->input->post('specialization'),
				'experience' => $this->input->post('experience'),
				'address' => $this->input->post('address'),
			];
			$this->db->where('id', $id);
			$this->db->update('aauth_users', $teacher_data);
			$role_data = [
				'user_id' => $user_id,
				'group_id' => 2
			];
			$this->db->insert('aauth_user_to_group',$role_data);
			if ($id) {
					$this->data['success'] = true;
					$this->data['message'] = cclang('success_save_data_stay');
					$this->data['redirect'] = base_url('administrator/dashboard');
			} else {

					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('sp_teacher');
				
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
	}
}


/* End of file sp_mcq_question.php */
/* Location: ./application/controllers/administrator/Sq Mcq Question.php */