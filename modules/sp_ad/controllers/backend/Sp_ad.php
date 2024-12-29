<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sp Ad Controller
 *| --------------------------------------------------------------------------
 *| Sp Ad site
 *|
 */
class Sp_ad extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_ad');
		$this->load->model('group/model_group');
		$this->lang->load('web_lang', $this->current_lang);
	}

	/**
	 * show all Sp Ads
	 *
	 * @var $offset String
	 */
	public function index($offset = 0)
	{
		if (check_role_exist_or_not(20, array("view", "edit", "list"))) {
			$filter = $this->input->get('q');
			$field 	= $this->input->get('f');

			$this->data['sp_ads'] = $this->model_sp_ad->get($filter, $field, $this->limit_page, $offset);
			$this->data['sp_ad_counts'] = $this->model_sp_ad->count_all($filter, $field);

			$config = [
				'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_ad/index/',
				'total_rows'   => $this->data['sp_ad_counts'],
				'per_page'     => $this->limit_page,
				'uri_segment'  => 4,
			];

			$this->data['pagination'] = $this->pagination($config);

			$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_ad/sp_ad_data_table', $this->data, true);

			if ($this->input->get('ajax')) {
				$this->response([
					'tables' => $this->data['tables'],
					'pagination' => $this->data['pagination'],
					'total_row' => $this->data['sp_ad_counts']
				]);
			}

			$this->template->title('Advertisement List');
			$this->render('backend/standart/administrator/sp_ad/sp_ad_list', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	/**
	 * Add new sp_ads
	 *
	 */
	public function add()
	{
		if (!check_role_exist_or_not(13, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->template->title('Advertisement New');
		$this->render('backend/standart/administrator/sp_ad/sp_ad_add', $this->data);
	}

	/**
	 * Add New Sp Ads
	 *
	 * @return JSON
	 */
	public function add_save()
	{
		if (!check_role_exist_or_not(20, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->form_validation->set_rules('sp_ad_image_name', 'Image', 'trim|required');
		if ($this->form_validation->run()) {
			$sp_ad_image_uuid = $this->input->post('sp_ad_image_uuid');
			$sp_ad_image_name = $this->input->post('sp_ad_image_name');

			$save_data = [
				'title' => $this->input->post('title'),
				'link' => $this->input->post('link'),
				'order' => $this->input->post('order'),
				'type' => $this->input->post('type'),
				'description' => $this->input->post('description'),
				'created_by' => get_user_data('id'),
				'created_at' => date('Y-m-d')
			];
			if (!is_dir(FCPATH . '/uploads/sp_ad/')) {
				mkdir(FCPATH . '/uploads/sp_ad/');
			}

			if (!empty($sp_ad_image_name)) {
				$sp_ad_image_name_copy = date('YmdHis') . '-' . $sp_ad_image_name;

				rename(
					FCPATH . 'uploads/tmp/' . $sp_ad_image_uuid . '/' . $sp_ad_image_name,
					FCPATH . 'uploads/sp_ad/' . $sp_ad_image_name_copy
				);

				if (!is_file(FCPATH . '/uploads/sp_ad/' . $sp_ad_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
					]);
					exit;
				}

				$save_data['image'] = $sp_ad_image_name_copy;
			}


			$save_sp_ad = $id = $this->model_sp_ad->store($save_data);


			if ($save_sp_ad) {

				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_sp_ad;
					$this->data['message'] = cclang('success_save_data_stay');
				} else {
					set_message(
						cclang('success_save_data_redirect'),
						'success'
					);

					$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_ad');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_ad');
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
	 * Update view Sp Ads
	 *
	 * @var $id String
	 */
	public function edit($id)
	{
		if (!check_role_exist_or_not(20, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->data['sp_ad'] = $this->model_sp_ad->find($id);
		$this->template->title('Advertisement Update');
		$this->render('backend/standart/administrator/sp_ad/sp_ad_update', $this->data);
	}

	/**
	 * Update Sp Ads
	 *
	 * @var $id String
	 */
	public function edit_save($id)
	{
		if (!check_role_exist_or_not(20, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->form_validation->set_rules('sp_ad_image_name', 'Image', 'trim|required');

		if ($this->form_validation->run()) {
			$sp_ad_image_uuid = $this->input->post('sp_ad_image_uuid');
			$sp_ad_image_name = $this->input->post('sp_ad_image_name');

			$save_data = [
				'title' => $this->input->post('title'),
				'type' => $this->input->post('type'),
				'link' => $this->input->post('link'),
				'order' => $this->input->post('order'),
				'description' => $this->input->post('description'),
			];
			if (!is_dir(FCPATH . '/uploads/sp_ad/')) {
				mkdir(FCPATH . '/uploads/sp_ad/');
			}

			if (!empty($sp_ad_image_uuid)) {
				$sp_ad_image_name_copy = date('YmdHis') . '-' . $sp_ad_image_name;

				rename(
					FCPATH . 'uploads/tmp/' . $sp_ad_image_uuid . '/' . $sp_ad_image_name,
					FCPATH . 'uploads/sp_ad/' . $sp_ad_image_name_copy
				);

				if (!is_file(FCPATH . '/uploads/sp_ad/' . $sp_ad_image_name_copy)) {
					echo json_encode([
						'success' => false,
						'message' => 'Error uploading file'
					]);
					exit;
				}

				$save_data['image'] = $sp_ad_image_name_copy;
			}


			$save_sp_ad = $this->model_sp_ad->change($id, $save_data);

			if ($save_sp_ad) {

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
					$this->data['redirect'] = admin_base_url('/sp_ad');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_ad');
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
	 * delete Sp Ads
	 *
	 * @var $id String
	 */
	public function delete($id = null)
	{
		if (!check_role_exist_or_not(20, array("delete"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
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
					"message" => cclang('has_been_deleted', 'Adertisement')
				]);
			} else {
				$this->response([
					"success" => true,
					"message" => cclang('error_delete', 'sp_ad')
				]);
			}
		} else {
			if ($remove) {
				set_message(cclang('has_been_deleted', 'sp_ad'), 'success');
			} else {
				set_message(cclang('error_delete', 'sp_ad'), 'error');
			}
			redirect_back();
		}
	}

	/**
	 * View view Sp Ads
	 *
	 * @var $id String
	 */
	public function view($id)
	{
		$this->is_allowed('sp_ad_view');

		$this->data['sp_ad'] = $this->model_sp_ad->join_avaiable()->filter_avaiable()->find($id);

		$this->template->title('Sp Ad Detail');
		$this->render('backend/standart/administrator/sp_ad/sp_ad_view', $this->data);
	}

	/**
	 * delete Sp Ads
	 *
	 * @var $id String
	 */
	private function _remove($id)
	{
		$sp_ad = $this->model_sp_ad->find($id);

		if (!empty($sp_ad->image)) {
			$path = FCPATH . '/uploads/sp_ad/' . $sp_ad->image;

			if (is_file($path)) {
				$delete_file = unlink($path);
			}
		}


		return $this->model_sp_ad->soft_delete($id);
	}

	/**
	 * Upload Image Sp Ad	* 
	 * @return JSON
	 */
	public function upload_image_file()
	{
		// if (!$this->is_allowed('sp_ad_add', false)) {
		// 	echo json_encode([
		// 		'success' => false,
		// 		'message' => cclang('sorry_you_do_not_have_permission_to_access')
		// 	]);
		// 	exit;
		// }

		$uuid = $this->input->post('qquuid');

		echo $this->upload_file([
			'uuid' 		 	=> $uuid,
			'table_name' 	=> 'sp_ad',
		]);
	}

	/**
	 * Delete Image Sp Ad	* 
	 * @return JSON
	 */
	public function delete_image_file($uuid)
	{
		// if (!$this->is_allowed('sp_ad_delete', false)) {
		// 	echo json_encode([
		// 		'success' => false,
		// 		'error' => cclang('sorry_you_do_not_have_permission_to_access')
		// 	]);
		// 	exit;
		// }

		echo $this->delete_file([
			'uuid'              => $uuid,
			'delete_by'         => $this->input->get('by'),
			'field_name'        => 'image',
			'upload_path_tmp'   => './uploads/tmp/',
			'table_name'        => 'sp_ad',
			'primary_key'       => 'id',
			'upload_path'       => 'uploads/sp_ad/'
		]);
	}

	/**
	 * Get Image Sp Ad	* 
	 * @return JSON
	 */
	public function get_image_file($id)
	{
		// if (!$this->is_allowed('sp_ad_update', false)) {
		// 	echo json_encode([
		// 		'success' => false,
		// 		'message' => 'Image not loaded, you do not have permission to access'
		// 	]);
		// 	exit;
		// }

		$sp_ad = $this->model_sp_ad->find($id);

		echo $this->get_file([
			'uuid'              => $id,
			'delete_by'         => 'id',
			'field_name'        => 'image',
			'table_name'        => 'sp_ad',
			'primary_key'       => 'id',
			'upload_path'       => 'uploads/sp_ad/',
			'delete_endpoint'   => ADMIN_NAMESPACE_URL  .  '/sp_ad/delete_image_file'
		]);
	}


	/**
	 * Export to excel
	 *
	 * @return Files Excel .xls
	 */
	public function export()
	{
		$this->is_allowed('sp_ad_export');

		$this->model_sp_ad->export(
			'sp_ad',
			'sp_ad',
			$this->model_sp_ad->field_search
		);
	}

	/**
	 * Export to PDF
	 *
	 * @return Files PDF .pdf
	 */
	public function export_pdf()
	{
		$this->is_allowed('sp_ad_export');

		$this->model_sp_ad->pdf('sp_ad', 'sp_ad');
	}


	public function single_pdf($id = null)
	{
		$this->is_allowed('sp_ad_export');

		$table = $title = 'sp_ad';
		$this->load->library('HtmlPdf');

		$config = array(
			'orientation' => 'p',
			'format' => 'a4',
			'marges' => array(5, 5, 5, 5)
		);

		$this->pdf = new HtmlPdf($config);
		$this->pdf->setDefaultFont('stsongstdlight');

		$result = $this->db->get($table);

		$data = $this->model_sp_ad->find($id);
		$fields = $result->list_fields();

		$content = $this->pdf->loadHtmlPdf('core_template/pdf/pdf_single', [
			'data' => $data,
			'fields' => $fields,
			'title' => $title
		], TRUE);

		$this->pdf->initialize($config);
		$this->pdf->pdf->SetDisplayMode('fullpage');
		$this->pdf->writeHTML($content);
		$this->pdf->Output($table . '.pdf', 'H');
	}
}


/* End of file sp_ad.php */
/* Location: ./application/controllers/administrator/Sp Ad.php */