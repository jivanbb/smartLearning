<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Access Controller
*| --------------------------------------------------------------------------
*| access site
*|
*/
class Role extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_role');
		if (!$this->session->userdata('loggedin')) {
			redirect('/', 'refresh');       
		}

	}


	/**
	* show all access
	*
	* @var $offset String
	*/public function index(){
		if (!check_role_exist_or_not(2, array("add","edit","view","delete"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard','refresh');
		}
		$this->data['roles'] = $this->model_role->get_roles();
		$this->render('backend/standart/administrator/access/role_list', $this->data);
	
}
public function add()
{
	if (!check_role_exist_or_not(2, array("add"))) {
		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		$this->session->set_flashdata('f_type', 'warning');
		redirect('administrator/dashboard','refresh');
	}
		$this->data['modules'] = $this->model_role->get_modules();
		// $this->data['roles'] = $this->model_role->GetAllRoles($position_id);
		$this->template->title('Permission List');
		$this->render('backend/standart/administrator/access/role_add', $this->data);
	// } else {
	// 	$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
	// 	$this->session->set_flashdata('f_type', 'warning');
	// 	redirect('administrator/dashboard','refresh');
	// }
}

public function edit($id){
	if (!check_role_exist_or_not(2, array("edit"))) {
		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		$this->session->set_flashdata('f_type', 'warning');
		redirect('administrator/dashboard','refresh');
	}
		$this->data['modules'] = $this->model_role->get_modules();
		$this->data['roles'] = $this->model_role->GetAllRoles($id);
		$this->data['department_id'] = $id;
		// echo '<pre>';

		$this->render('backend/standart/administrator/access/role_update', $this->data);
	
}



public function Save() {
	if (!check_role_exist_or_not(2, array("add"))) {
		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		$this->session->set_flashdata('f_type', 'warning');
		redirect('administrator/dashboard','refresh');
	}
	$this->form_validation->set_rules('group_id', 'Department', 'trim|required');
	$this->form_validation->set_rules('permission[]', 'Module', 'trim|callback_check_module');
	if ($this->form_validation->run()) {
		$group_id = $this->input->post('group_id' );
		$this->model_role->update_role($group_id);
		$rolePermissions = $this->input->post('permission');
		if(!$rolePermissions){
			redirect_back();
		}
		$roles_info = [];
		foreach ($rolePermissions as $moduleID => $permissions) {
			foreach ($permissions as $action => $permission) {
				// var_dump($permission); die();
				$check_exits =	$this->model_role->check_exits($moduleID,$group_id);
				$roles_info= [
					'group_id' => $group_id,
					'module_id' => $moduleID,
					$action => $permission

				];
				if($check_exits){
					$this->db->where('id',$check_exits->id);
					$save_access =$this->db->update('sp_role', $roles_info);

				}else{
					$this->db->insert('sp_role', $roles_info);
					$save_access = $this->db->insert_id();

				}

			}
		}
		if ($save_access) {
			$this->data['success'] = true;
			$this->data['message'] = cclang('success_save_data_stay');
			$this->data['redirect'] = base_url('administrator/role');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = cclang('data_not_change');
			$this->data['redirect'] = base_url('administrator/role');
		}
	} else {
		$this->data['success'] = false;
		$this->data['message'] = validation_errors();
	}
	echo json_encode($this->data);
}


public function update() {
	if (!check_role_exist_or_not(2, array("edit"))) {
		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		$this->session->set_flashdata('f_type', 'warning');
		redirect('administrator/dashboard','refresh');
	}
	$rolePermissions = $this->input->post('permission');
	$this->form_validation->set_rules('group_id', 'Department', 'trim|required');
	$this->form_validation->set_rules('permission[]', 'Module', 'trim|callback_check_module');
	if ($this->form_validation->run()) {
	$group_id = $this->input->post('group_id' );
	$this->model_role->update_role($group_id);
	$rolePermissions = $this->input->post('permission');
	if(!$rolePermissions){
		redirect_back();
	}
	$roles_info = [];
	foreach ($rolePermissions as $moduleID => $permissions) {
		foreach ($permissions as $action => $permission) {
				// var_dump($permission); die();
			$check_exits =	$this->model_role->check_exits($moduleID,$group_id);
			$roles_info= [
				'group_id' => $group_id,
				'module_id' => $moduleID,
				$action => $permission

			];
			if($check_exits){
				$this->db->where('id',$check_exits->id);
				$save_access =$this->db->update('sp_role', $roles_info);

			}else{
				$this->db->insert('sp_role', $roles_info);
				$save_access = $this->db->insert_id();

			}

		}
	}
	if ($save_access) {
		$this->data['success'] = true;
		$this->data['message'] = cclang('success_save_data_stay');
		$this->data['redirect'] = base_url('administrator/role');
	} else {
		$this->data['success'] = false;
		$this->data['message'] = cclang('data_not_change');
		$this->data['redirect'] = base_url('administrator/role');
	}
} else {
	$this->data['success'] = false;
	$this->data['message'] = validation_errors();
}
	echo json_encode($this->data);
}

public function check_module(){
	$rolePermissions = $this->input->post('permission');
if(empty($rolePermissions)){
	$this->form_validation->set_message('check_module', 'Please Tick at least one module');
	return FALSE;
}
}
	
}


/* End of file Access.php */
/* Location: ./application/controllers/administrator/Access.php */