<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Oms Module Controller
*| --------------------------------------------------------------------------
*| Oms Module site
*|
*/
class Sp_module extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_module');
		$this->load->model('menu/model_menu');
		if (!$this->session->userdata('loggedin')) {
			redirect('/', 'refresh');       
		}
	}

	/**
	* show all Oms Modules
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		// $id = 1; 
		// $ids = array();
		// $positions = get_user_position();
		// if(!empty($positions)){
		// 	foreach($positions as $position){
		// 		$ids[] =$position->group_id;			
		// 	}
		// 	if(!in_array($id,$ids)){
		// 		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 		$this->session->set_flashdata('f_type', 'warning');
		// 		redirect('administrator/dashboard', 'refresh');
		// 		}
		//   }else{
		// 	$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 	$this->session->set_flashdata('f_type', 'warning');
		// 	redirect('administrator/dashboard', 'refresh');
		//   }

		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');

		$this->data['sp_modules'] = $this->model_sp_module->get($filter, $field, $this->limit_page, $offset);
		//  var_dump($this->data['sp_modules']); die();
		$this->data['sp_module_counts'] = $this->model_sp_module->count_all($filter, $field);

		$config = [
			'base_url'     => 'administrator/sp_module/index/',
			'total_rows'   => $this->model_sp_module->count_all($filter, $field),
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);

		$this->template->title('Module List');
		$this->render('backend/standart/administrator/sp_module/sp_module_list', $this->data);
	}

	public function mobile_module(){
		$this->render('backend/standart/administrator/sp_module/oms_mobile_module_list');
	}
	
	/**
	* Add new sp_modules
	*
	*/
	public function add()
	{
		// $id = 1; 
		// $ids = array();
		// $positions = get_user_position();
		// if(!empty($positions)){
		// 	foreach($positions as $position){
		// 		$ids[] =$position->group_id;			
		// 	}
		// 	if(!in_array($id,$ids)){
		// 		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 		$this->session->set_flashdata('f_type', 'warning');
		// 		redirect('administrator/dashboard', 'refresh');
		// 		}
		//   }else{
		// 	$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 	$this->session->set_flashdata('f_type', 'warning');
		// 	redirect('administrator/dashboard', 'refresh');
		//   }
		// $this->is_allowed('sp_module_add');
		$this->data['modules'] = $this->model_sp_module->get_all_modules();
		$menu_type = "side-menu";
		$menu_type_id = $this->model_menu->get_id_menu_type_by_flag($menu_type);

		if (!$menu_type_id) {
			$this->session->set_flashdata('f_message', 'Menu type '.$menu_type.' does not exist');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/menu');
		}

		// $this->data = [
		// 	'menu_type_id' 		=> $menu_type_id,
		// 	'color_icon'		=> $this->model_menu->get_color_icon()
		// ];
		$this->data['menu_type_id'] = $menu_type_id;
		$this->data['color_icon'] = $this->model_menu->get_color_icon();
		$this->template->title('Module New');
		$this->render('backend/standart/administrator/sp_module/sp_module_add', $this->data);
	}

	/**
	* Add New Oms Modules
	*
	* @return JSON
	*/
	public function add_save()
	{
		$id = 1; 
		// $ids = array();
		// $positions = get_user_position();
		// if(!empty($positions)){
		// 	foreach($positions as $position){
		// 		$ids[] =$position->group_id;			
		// 	}
		// 	if(!in_array($id,$ids)){
		// 		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 		$this->session->set_flashdata('f_type', 'warning');
		// 		redirect('administrator/dashboard', 'refresh');
		// 		}
		//   }else{
		// 	$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 	$this->session->set_flashdata('f_type', 'warning');
		// 	redirect('administrator/dashboard', 'refresh');
		//   }
		// if (!$this->is_allowed('sp_module_add', false)) {
		// 	echo json_encode([
		// 		'success' => false,
		// 		'message' => cclang('sorry_you_do_not_have_permission_to_access')
		// 	]);
		// 	exit;
		// }

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		

		if ($this->form_validation->run()) {
			
			$save_data = [
				'name' => $this->input->post('name'),
				'link' 			=> $this->input->post('link'),
				'icon' 			=> $this->input->post('icon'),
				'parent' => $this->input->post('parent'),
				'menu_type_id' 	=> $this->input->post('menu_type_id'),
				'type' 			=> $this->input->post('type'),
				'icon_color' 	=> $this->input->post('icon_color'),
				// 'mobile'=>$this->input->post('mobile')??0,
				// 'self_only'=>$this->input->post('self_only')??0,
				'add'=>$this->input->post('add')??0,
				'list'=>$this->input->post('list')??0,
				'view'=>$this->input->post('view')??0,
				'edit'=>$this->input->post('edit')??0,
				'delete'=>$this->input->post('delete')??0,
				// 'report'=>$this->input->post('report')??0,
				'sort' 			=> $this->model_sp_module->count_all(),
				'active' 	    => 1,
				'created_at' => date("Y-m-d")
			];
			

			
			$save_sp_module = $this->model_sp_module->store($save_data);

			if ($save_sp_module) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_sp_module;
					$this->data['message'] = cclang('success_save_data_stay', [
						anchor('administrator/sp_module/edit/' . $save_sp_module, ' Module'),
						anchor('administrator/sp_module')
					]);
				} else {
					set_message(
						cclang('success_save_data_redirect', [
							anchor('administrator/sp_module/edit/' . $save_sp_module, ' Module')
						]), 'success');

					$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/sp_module');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/sp_module');
				}
			}

		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}
	
		/**
	* Update view Oms Modules
	*
	* @var $id String
	*/
	public function edit($id)
	{
		$user_id = 1; 
		$ids = array();
		// $positions = get_user_position();
		// if(!empty($positions)){
		// 	foreach($positions as $position){
		// 		$ids[] =$position->group_id;			
		// 	}
		// 	if(!in_array($user_id,$ids)){
		// 		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 		$this->session->set_flashdata('f_type', 'warning');
		// 		redirect('administrator/dashboard', 'refresh');
		// 		}
		//   }else{
		// 	$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 	$this->session->set_flashdata('f_type', 'warning');
		// 	redirect('administrator/dashboard', 'refresh');
		//   }
		$this->data = 
		[
			'menu' 			=> $this->model_sp_module->find($id),
			'color_icon'	=> $this->model_sp_module->get_color_icon(),
		];
		
		$this->render('backend/standart/administrator/sp_module/sp_module_update', $this->data);
	}

	/**
	* Update Oms Modules
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		$user_id = 1; 
		// $ids = array();
		// $positions = get_user_position();
		// if(!empty($positions)){
		// 	foreach($positions as $position){
		// 		$ids[] =$position->group_id;			
		// 	}
		// 	if(!in_array($user_id,$ids)){
		// 		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 		$this->session->set_flashdata('f_type', 'warning');
		// 		redirect('administrator/dashboard', 'refresh');
		// 		}
		//   }else{
		// 	$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 	$this->session->set_flashdata('f_type', 'warning');
		// 	redirect('administrator/dashboard', 'refresh');
		//   }
		// if (!$this->is_allowed('sp_module_update', false)) {
		// 	echo json_encode([
		// 		'success' => false,
		// 		'message' => cclang('sorry_you_do_not_have_permission_to_access')
		// 	]);
		// 	exit;
		// }
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('link', 'Link', 'trim|required');
		if ($this->form_validation->run()) {
			
			$save_data = [
				'name' 		=> $this->input->post('name'),
				'link' 			=> $this->input->post('link'),
				'icon' 			=> $this->input->post('icon'),
				'parent' 		=> $this->input->post('parent'),
				'menu_type_id' 	=> $this->input->post('menu_type_id'),
				'type' 			=> $this->input->post('type'),
				'icon_color' 	=> $this->input->post('icon_color'),
				'mobile'=>$this->input->post('mobile')??0,
				'self_only'=>$this->input->post('self_only')??0,
				'add'=>$this->input->post('add')??0,
				'list'=>$this->input->post('list')??0,
				'view'=>$this->input->post('view')??0,
				'edit'=>$this->input->post('edit')??0,
				'delete'=>$this->input->post('delete')??0,
				'report'=>$this->input->post('report')??0,				
			];

			
			$save_sp_module = $this->model_sp_module->change($id, $save_data);

			if ($save_sp_module) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						anchor('administrator/sp_module')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
						]), 'success');

					$this->data['success'] = true;
					$this->data['redirect'] = base_url('administrator/sp_module');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = base_url('administrator/sp_module');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = validation_errors();
		}

		echo json_encode($this->data);
	}

	
	public function save_ordering()
	{
		$id = 1; 
		// $ids = array();
		// $positions = get_user_position();
		// if(!empty($positions)){
		// 	foreach($positions as $position){
		// 		$ids[] =$position->group_id;			
		// 	}
		// 	if(!in_array($id,$ids)){
		// 		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 		$this->session->set_flashdata('f_type', 'warning');
		// 		redirect('administrator/dashboard', 'refresh');
		// 		}
		//   }else{
		// 	$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 	$this->session->set_flashdata('f_type', 'warning');
		// 	redirect('administrator/dashboard', 'refresh');
		//   }
		$this->menus = [];
		$this->sort = 0;
		$this->_parse_menu($_POST['menu']);
		$save_ordering = $this->db->update_batch('sp_module', $this->menus, 'id');
		if ($save_ordering) {
			$this->data = [
				'success' => true,
				'message' => cclang('success_save_data_stay'),
				'menu' 	  => display_custom_menu_module(0, 1)
			];
		} else {
			$this->data = [
				'success' => false,
				'message' => cclang('data_not_change')
			];
		}

		return $this->response($this->data);
	}

	/**
	* parse menu
	*
	* @var $menu array
	*/
	private function _parse_menu($menus, $parent = '')
	{
		$data = [];
		foreach ($menus as $menu) {
			$this->sort++;
			$this->menus[] = [
				'id' => $menu['id'],
				'sort' => $this->sort,
				'parent' => $parent
			];
			if (isset($menu['children'])) {
				$this->_parse_menu($menu['children'], $menu['id']);
			}
		}
	}

	/**
	* delete menus
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		$id = 1; 
		// $ids = array();
		// $positions = get_user_position();
		// if(!empty($positions)){
		// 	foreach($positions as $position){
		// 		$ids[] =$position->group_id;			
		// 	}
		// 	if(!in_array($id,$ids)){
		// 		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 		$this->session->set_flashdata('f_type', 'warning');
		// 		redirect('administrator/dashboard', 'refresh');
		// 		}
		//   }else{
		// 	$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		// 	$this->session->set_flashdata('f_type', 'warning');
		// 	redirect('administrator/dashboard', 'refresh');
		//   }
		$remove = $this->model_sp_module->remove($id);
		$this->model_sp_module->update_child_menu_by_parent($id);
		
		if ($remove) {
			set_message(cclang('has_been_deleted', 'Menu'), 'success');
		} else {
			set_message(cclang('error_delete', 'Menu'), 'error');
		}

		redirect('administrator/sp_module');
	}

	/**
	* Set status user
	*
	* @return JSON
	*/
	public function set_status()
	{
		// if (!$this->is_allowed('menu_update', false)) {
		// 	return $this->response([
		// 		'success' => false,
		// 		'message' => cclang('sorry_you_do_not_have_permission_to_access')
		// 	]);
		// }
		$status = $this->input->post('status');
		$id = $this->input->post('id');
		$update_status = $this->model_sp_module->change($id, [
			'active' => $status
		]);
		if ($update_status) {
			$this->response = [
				'success' => true,
				'message' => 'Menu status updated to '.($status == 1 ? 'active' : 'inactive'),
			];
		} else {
			$this->response = [
				'success' => false,
				'message' => cclang('data_not_change')
			];
		}

		return $this->response($this->response);
	}

}


/* End of file sp_module.php */
/* Location: ./application/controllers/administrator/Oms Module.php */