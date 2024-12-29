<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Sp Materials Controller
*| --------------------------------------------------------------------------
*| Sp Materials site
*|
*/
class Sp_study_materials extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_study_materials');
		$this->load->model('group/model_group');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	* show all Sp Materialss
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		if (check_role_exist_or_not(17, array( "view","edit","list"))) {
			$positions = get_user_position();
		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		$param 	= $this->input->get();
		$this->data['teachers'] = $this->model_sp_study_materials->get_teachers();
		$this->data['sp_materialss'] = $this->model_sp_study_materials->get($param,$filter, $field, $this->limit_page, $offset);
		$this->data['sp_materials_counts'] = $this->model_sp_study_materials->count_all($param,$filter, $field);
		$this->data['offset'] = $offset;
		$this->data['filter'] = $param;
		$config = [
			'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_study_materials/index/',
			'total_rows'   => $this->data['sp_materials_counts'],
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		
		$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_study_materials/sp_materials_data_table', $this->data, true);
		
		if ($this->input->get('ajax')) {
			$this->response([
				'tables' => $this->data['tables'],
				'pagination' => $this->data['pagination'],
				'total_row' => $this->data['sp_materials_counts']
			]);
		}

		$this->template->title('Materials List');
		$this->render('backend/standart/administrator/sp_study_materials/sp_materials_list', $this->data);
	} else {
		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		$this->session->set_flashdata('f_type', 'warning');
		redirect('administrator/dashboard','refresh');
	}
	}
	
	

	
}


/* End of file sp_materials.php */
/* Location: ./application/controllers/administrator/Sp Materials.php */