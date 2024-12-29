<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Sp Materials Controller
*| --------------------------------------------------------------------------
*| Sp Materials site
*|
*/
class Sp_video extends Admin	
{
	
	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_video');
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
		if (check_role_exist_or_not(26, array( "view","edit","list"))) {
			$positions = get_user_position();
		$filter = $this->input->get('q');
		$field 	= $this->input->get('f');
		$param 	= $this->input->get();

		$id = get_user_data('id');
		if (check_role_exist_or_not(26, array('self_only'))) {
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
		$this->data['sp_videos'] = $this->model_sp_video->get($id,$role, $param,$filter, $field, $this->limit_page, $offset);
		$this->data['sp_video_counts'] = $this->model_sp_video->count_all($id,$role, $param,$filter, $field);
		$this->data['offset'] = $offset;
		$this->data['user_id'] = $id;
		$this->data['filter'] = $param;
		$config = [
			'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_video/index/',
			'total_rows'   => $this->data['sp_video_counts'],
			'per_page'     => $this->limit_page,
			'uri_segment'  => 4,
		];

		$this->data['pagination'] = $this->pagination($config);
		
		$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_video/sp_video_data_table', $this->data, true);
		
		if ($this->input->get('ajax')) {
			$this->response([
				'tables' => $this->data['tables'],
				'pagination' => $this->data['pagination'],
				'total_row' => $this->data['sp_video_counts']
			]);
		}

		$this->template->title('Video List');
		$this->render('backend/standart/administrator/sp_video/sp_video_list', $this->data);
	} else {
		$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
		$this->session->set_flashdata('f_type', 'warning');
		redirect('administrator/dashboard','refresh');
	}
	}
	
	/**
	* Add new sp_videos
	*
	*/
	public function add()
	{
		if (!check_role_exist_or_not(26, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard','refresh');
		}
		$this->template->title('Video New');
		$this->render('backend/standart/administrator/sp_video/sp_video_add', $this->data);
	}

	/**
	* Add New Sp Materialss
	*
	* @return JSON
	*/
	public function add_save()
	{
		if (!check_role_exist_or_not(26, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard','refresh');
		}
		$this->form_validation->set_rules('course_id', 'Course', 'trim|required');
		$this->form_validation->set_rules('sp_video_materials_name[]', 'Materials', 'trim|required');
		if ($this->form_validation->run()) {
		
			$save_data = [
				'course_id' => $this->input->post('course_id'),
				'chapter_id' => $this->input->post('chapter_id'),
				'topic_id' => $this->input->post('topic_id'),
				'created_by'=>get_user_data('id'),
				'created_at'=>date('Y-m-d')
			];
	
			if (!is_dir(FCPATH . '/uploads/sp_video/')) {
				mkdir(FCPATH . '/uploads/sp_video/');
			}

			if (count((array) $this->input->post('sp_video_materials_name'))) {
				foreach ((array) $_POST['sp_video_materials_name'] as $idx => $file_name) {
					$sp_video_materials_name_copy = date('YmdHis') . '-' . $file_name;

					rename(FCPATH . 'uploads/tmp/' . $_POST['sp_video_materials_uuid'][$idx] . '/' .  $file_name, 
							FCPATH . 'uploads/sp_video/' . $sp_video_materials_name_copy);

					$listed_image[] = $sp_video_materials_name_copy;

					if (!is_file(FCPATH . '/uploads/sp_video/' . $sp_video_materials_name_copy)) {
						echo json_encode([
							'success' => false,
							'message' => 'Error uploading file'
							]);
						exit;
					}
				}

				$save_data['materials'] = implode(',',$listed_image);
				$listed_image = [];
			}
		
			
			$save_sp_video = $id = $this->model_sp_video->store($save_data);
            

			if ($save_sp_video) {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_sp_video;
					$this->data['message'] = cclang('success_save_data_stay');
			} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
			}

		} else {
			$this->data['success'] = false;
			// $this->data['message'] = 'Opss validation failed';
			$this->data['message'] = validation_errors();
		}

		$this->response($this->data);
	}
	
		/**
	* Update view Sp Materialss
	*
	* @var $id String
	*/
	public function edit($id)
	{
		if (!check_role_exist_or_not(26, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard','refresh');
		}
		$this->data['sp_video'] = $this->model_sp_video->find($id);
		$this->data['user_id'] = get_user_data('id');
		$this->template->title('Video Update');
		$this->render('backend/standart/administrator/sp_video/sp_video_update', $this->data);
	}

	/**
	* Update Sp Materialss
	*
	* @var $id String
	*/
	public function edit_save($id)
	{
		if (!check_role_exist_or_not(26, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard','refresh');
		}
				$this->form_validation->set_rules('course_id', 'Course Id', 'trim|required');
		$this->form_validation->set_rules('sp_video_materials_name[]', 'Materials', 'trim|required');
		if ($this->form_validation->run()) {
		
			$save_data = [
				'course_id' => $this->input->post('course_id'),
				'chapter_id' => $this->input->post('chapter_id'),
				'topic_id' => $this->input->post('topic_id'),
			];

		
			$listed_image = [];
			if (count((array) $this->input->post('sp_video_materials_name'))) {
				foreach ((array) $_POST['sp_video_materials_name'] as $idx => $file_name) {
					if (isset($_POST['sp_video_materials_uuid'][$idx]) AND !empty($_POST['sp_video_materials_uuid'][$idx])) {
						$sp_video_materials_name_copy = date('YmdHis') . '-' . $file_name;

						rename(FCPATH . 'uploads/tmp/' . $_POST['sp_video_materials_uuid'][$idx] . '/' .  $file_name, 
								FCPATH . 'uploads/sp_video/' . $sp_video_materials_name_copy);

						$listed_image[] = $sp_video_materials_name_copy;

						if (!is_file(FCPATH . '/uploads/sp_video/' . $sp_video_materials_name_copy)) {
							echo json_encode([
								'success' => false,
								'message' => 'Error uploading file'
								]);
							exit;
						}
					} else {
						$listed_image[] = $file_name;
					}
				}
			}
			
			$save_data['materials'] = implode(',',$listed_image);
			$listed_image = [];

		
			
			$save_sp_video = $this->model_sp_video->change($id, $save_data);

			if ($save_sp_video) {
		
				
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						admin_anchor('/sp_video', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', [
					]), 'success');

            		$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_video');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
            		$this->data['success'] = false;
            		$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_video');
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
	* delete Sp Materialss
	*
	* @var $id String
	*/
	public function delete($id = null)
	{
		if (!check_role_exist_or_not(26, array("delete"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard','refresh');
		}

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
					"message" => cclang('has_been_deleted', 'sp_video')
				]);
			} else {
				$this->response([
					"success" => true,
					"message" => cclang('error_delete', 'sp_video')
				]);
			}

		} else {
			if ($remove) {
				set_message(cclang('has_been_deleted', 'sp_video'), 'success');
			} else {
				set_message(cclang('error_delete', 'sp_video'), 'error');
			}
			redirect_back();
		}

	}

		/**
	* View view Sp Materialss
	*
	* @var $id String
	*/
	public function view($id)
	{
		$this->is_allowed('sp_video_view');

		$this->data['sp_video'] = $this->model_sp_video->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('Sp Materials Detail');
		$this->render('backend/standart/administrator/sp_video/sp_video_view', $this->data);
	}
	
	/**
	* delete Sp Materialss
	*
	* @var $id String
	*/
	private function _remove($id)
	{
		$sp_video = $this->model_sp_video->find($id);

		
		if (!empty($sp_video->materials)) {
			foreach ((array) explode(',', $sp_video->materials) as $filename) {
				$path = FCPATH . '/uploads/sp_video/' . $filename;

				if (is_file($path)) {
					$delete_file = unlink($path);
				}
			}
		}
		
		return $this->model_sp_video->soft_delete($id);
	}
	
	
	/**
	* Upload Image Sp Materials	* 
	* @return JSON
	*/
	public function upload_materials_file()
	{
		
		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'sp_video',
		]);
	}

	/**
	* Delete Image Sp Materials	* 
	* @return JSON
	*/
	public function delete_materials_file($uuid)
	{

		echo $this->delete_file([
            'uuid'              => $uuid, 
            'delete_by'         => $this->input->get('by'), 
            'field_name'        => 'materials', 
            'upload_path_tmp'   => './uploads/tmp/',
            'table_name'        => 'sp_video',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/sp_video/'
        ]);
	}

	/**
	* Get Image Sp Materials	* 
	* @return JSON
	*/
	public function get_materials_file($id)
	{
		$sp_video = $this->model_sp_video->find($id);

		echo $this->get_file([
            'uuid'              => $id, 
            'delete_by'         => 'id', 
            'field_name'        => 'materials', 
            'table_name'        => 'sp_video',
            'primary_key'       => 'id',
            'upload_path'       => 'uploads/sp_video/',
            'delete_endpoint'   => ADMIN_NAMESPACE_URL  .  '/sp_video/delete_materials_file'
        ]);
	}
	
	/**
	* Export to excel
	*
	* @return Files Excel .xls
	*/
	public function export()
	{
		$this->is_allowed('sp_video_export');

		$this->model_sp_video->export(
			'sp_video', 
			'sp_video',
			$this->model_sp_video->field_search
		);
	}

	/**
	* Export to PDF
	*
	* @return Files PDF .pdf
	*/
	public function export_pdf()
	{
		$this->is_allowed('sp_video_export');

		$this->model_sp_video->pdf('sp_video', 'sp_video');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('sp_video_export');

		$table = $title = 'sp_video';
		$this->load->library('HtmlPdf');
      
        $config = array(
            'orientation' => 'p',
            'format' => 'a4',
            'marges' => array(5, 5, 5, 5)
        );

        $this->pdf = new HtmlPdf($config);
        $this->pdf->setDefaultFont('stsongstdlight'); 

        $result = $this->db->get($table);
       
        $data = $this->model_sp_video->find($id);
        $fields = $result->list_fields();

        $content = $this->pdf->loadHtmlPdf('core_template/pdf/pdf_single', [
            'data' => $data,
            'fields' => $fields,
            'title' => $title
        ], TRUE);

        $this->pdf->initialize($config);
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $this->pdf->writeHTML($content);
        $this->pdf->Output($table.'.pdf', 'H');
	}

	
}


/* End of file sp_video.php */
/* Location: ./application/controllers/administrator/Sp Materials.php */