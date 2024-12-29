<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question Controller
 *| --------------------------------------------------------------------------
 *| Sq Mcq Question site
 *|
 */
class Sp_mcq_setup extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_mcq_setup');
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
		if (check_role_exist_or_not(18, array("view", "edit", "list"))) {
			$positions = get_user_position();
			$filter = $this->input->get('q');
			$field 	= $this->input->get('f');
			$param 	= $this->input->get();
			$id = get_user_data('id');
			if (check_role_exist_or_not(13, array('self_only'))) {
				foreach ($positions as $position) {
					if (@$position->group_id > 1) {
						$role = "self_only";
					} else {
						$role = "admin";
					}
				}
			} else {
				$role = "admin";
			}
			$this->data['sp_mcq_questions'] = $this->model_sp_mcq_setup->get($id, $role, $param, $filter, $field, $this->limit_page, $offset);
			$this->data['sp_mcq_question_counts'] = $this->model_sp_mcq_setup->count_all($id, $role, $param, $filter, $field);
			$this->data['offset'] = $offset;
			$this->data['user_id'] = $id;
			$this->data['filter'] = $param;
			$config = [
				'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_mcq_setup/index/',
				'total_rows'   => $this->data['sp_mcq_question_counts'],
				'per_page'     => $this->limit_page,
				'uri_segment'  => 4,
			];

			$this->data['pagination'] = $this->pagination($config);

			$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_mcq_setup/sp_mcq_exam_data_table', $this->data, true);

			if ($this->input->get('ajax')) {
				$this->response([
					'tables' => $this->data['tables'],
					'pagination' => $this->data['pagination'],
					'total_row' => $this->data['sp_mcq_question_counts']
				]);
			}

			$this->template->title('Mcq Exam List');
			$this->render('backend/standart/administrator/sp_mcq_setup/sp_mcq_exam_list', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	/**
	 * Add new sp_mcq_questions
	 *
	 */
	public function add()
	{
		if (!check_role_exist_or_not(18, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->template->title('Mcq Exam New');
		$this->data['user_id'] = get_user_data('id');
		$this->render('backend/standart/administrator/sp_mcq_setup/sp_mcq_exam_add', $this->data);
	}

	/**
	 * Add New Sq Mcq Questions
	 *
	 * @return JSON
	 */
	public function add_save()
	{
		if (!check_role_exist_or_not(18, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->form_validation->set_rules('course_id', 'Course ', 'trim|required');
		$this->form_validation->set_rules('time', 'Time', 'trim|required');
		$this->form_validation->set_rules('full_marks', 'Full Marks', 'trim|required');
		$this->form_validation->set_rules('pass_marks', 'Pass Marks', 'trim|required');
		$this->form_validation->set_rules('marks', 'Marks', 'trim|required');
		if ($this->form_validation->run()) {
			$chapter_data =	$this->input->post('chapter_data');
			$save_data = [
				'course_id' => $this->input->post('course_id'),
				'time' => $this->input->post('time'),
				'full_marks' => $this->input->post('full_marks'),
				'negative_marking' => $this->input->post('negative_marking'),
				'pass_marks' => $this->input->post('pass_marks'),
				'question_marks' => $this->input->post('marks'),
				'created_by' => get_user_data('id'),
				'created_at' => date('Y-m-d H:i:s')
			];
			$save_sp_mcq_exam = $id = $this->model_sp_mcq_setup->store($save_data);
			$total_questions = 0;
			$questions = [];
			foreach ($chapter_data as $key => $data) {
				$mcq_detail = [
					'mcq_exam_id' => $save_sp_mcq_exam,
					'chapter_id' => $key,
					'no_of_question' => $data['no_of_questions']
				];
				$questions[] = $data['no_of_questions'];
				$this->db->insert('sp_mcq_exam_detail', $mcq_detail);
			}
			$total_questions = array_sum($questions);
			$this->db->set('total_questions', $total_questions);
			$this->db->where('id', $save_sp_mcq_exam);
			$this->db->update('sp_mcq_exam');
			if ($save_sp_mcq_exam) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $save_sp_mcq_exam;
					$this->data['message'] = cclang('success_save_data_stay');
				} else {
					set_message(
						cclang('success_save_data_redirect'),
						'success'
					);

					$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_mcq_setup');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_mcq_exam');
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
	 * Update view Sq Mcq Questions
	 *
	 * @var $id String
	 */
	public function edit($id)
	{
		if (!check_role_exist_or_not(18, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->data['mcq_exam'] = $this->model_sp_mcq_setup->find($id);
		$this->data['mcq_exam_detail'] = $this->model_sp_mcq_setup->get_mcq_exam_detail($id);
		$this->data['user_id'] = get_user_data('id');
		$this->template->title('Mcq Question Update');
		$this->render('backend/standart/administrator/sp_mcq_setup/sp_mcq_exam_update', $this->data);
	}
	public function view($id)
	{
		if (!check_role_exist_or_not(18, array("view"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$exam_details = $this->model_sp_mcq_setup->get_mcq_exam_detail($id);
		$combinedArray = [];
		foreach ($exam_details as $data) {
			$questions = $this->model_sp_mcq_setup->get_questions_detail($data->chapter_id, $data->no_of_question);
			$combinedArray = array_merge($combinedArray, $questions);
		}
		$this->data['mcq_exam'] = $this->model_sp_mcq_setup->get_mcq_exam($id);
		$this->data['question_detail'] = $combinedArray;
		$this->template->title('Mcq Question View');
		$this->render('backend/standart/administrator/sp_mcq_setup/sp_mcq_exam_view', $this->data);
	}


	/**
	 * Update Sq Mcq Questions
	 *
	 * @var $id String
	 */
	public function edit_save($id)
	{
		$this->form_validation->set_rules('time', 'Time', 'trim|required');
		$this->form_validation->set_rules('full_marks', 'Full Marks', 'trim|required');
		$this->form_validation->set_rules('pass_marks', 'Pass Marks', 'trim|required');
		$this->form_validation->set_rules('marks', 'Marks', 'trim|required');
		if ($this->form_validation->run()) {
			$chapter_data =	$this->input->post('chapter_data');
			$save_data = [
				'time' => $this->input->post('time'),
				'full_marks' => $this->input->post('full_marks'),
				'pass_marks' => $this->input->post('pass_marks'),
				'question_marks' => $this->input->post('marks'),
				'negative_marking' => $this->input->post('negative_marking'),
				'edited_by' => get_user_data('id'),
				'edited_at' => date('Y-m-d')
			];
			$save_sp_mcq_question = $this->model_sp_mcq_setup->change($id, $save_data);
			$total_questions = 0;
			$questions = [];
			foreach ($chapter_data as $key => $data) {
				$this->model_sp_mcq_setup->update_mcq_exam_detail($save_sp_mcq_question, $key, $data['no_of_questions']);
				$questions[] = $data['no_of_questions'];
			}

			$total_questions = array_sum($questions);
			$this->db->set('total_questions', $total_questions);
			$this->db->where('id', $id);
			$this->db->update('sp_mcq_exam');
			if ($save_sp_mcq_question) {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = true;
					$this->data['id'] 	   = $id;
					$this->data['message'] = cclang('success_update_data_stay', [
						admin_anchor('/sp_mcq_question', ' Go back to list')
					]);
				} else {
					set_message(
						cclang('success_update_data_redirect', []),
						'success'
					);

					$this->data['success'] = true;
					$this->data['redirect'] = admin_base_url('/sp_mcq_setup');
				}
			} else {
				if ($this->input->post('save_type') == 'stay') {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
				} else {
					$this->data['success'] = false;
					$this->data['message'] = cclang('data_not_change');
					$this->data['redirect'] = admin_base_url('/sp_mcq_setup');
				}
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
	}

	public function publish_exam()
	{
		$id =  $this->input->post('id');
		$this->db->set('is_publish', 1);
		$this->db->where('id', $id);
		$this->db->update('sp_mcq_exam');
		if ($id) {
			$data['success'] = true;
			$data['id']        = $id;
			$data['redirect'] = base_url('administrator/sp_mcq_setup');
			$data['message'] = "Sucessfully Updated";
		} else {
			$data['success'] = false;
			$data['message'] = "Error in Save";
		}

		echo json_encode($data);
		exit;
	}


	function getChapter($chapter_id)
	{
		$result = $this->get_chapter_data($chapter_id);
		echo $result;
		exit;
	}

	public function get_chapter_data($course_id)
	{
		$results = $this->model_sp_mcq_setup->get_chapter_details($course_id);
		ob_start(); ?>
		<div class="form-group group-marks ">
			<label for="no_of_options" class="col-sm-2 control-label">Marks <i class="required">*</i>
			</label>
			<div class="col-sm-4">
				<input type="number" class="form-control" name="marks" placeholder="Marks">
				<small class="info help-block">(Each question marks)
				</small>
			</div>
			<label for="set" class="col-sm-2 control-label">Negative Marking <i class="required">*</i>
			</label>
			<div class="col-sm-4">
				<input type="number" class="form-control" name="negative_marking" placeholder="Negative Marking">
				<small class="info help-block">(percent)
				</small>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="dt-responsive table-responsive col-md-10">
				<table class="table table-striped table-bordered nowrap">
					<thead>
						<tr>
							<th>SN.</th>
							<th>Chapter Name</th>
							<th width="20%">No of Question</th>
						</tr>
					</thead>
					<tbody>
						<?php $sn = 0;
						foreach ($results as $result):
							$sn++; ?>
							<tr>
								<td><?php echo $sn; ?></td>
								<td><?php echo $result->name; ?></td>
								<td><input type="text" class="form-control" name="chapter_data[<?php echo $result->id; ?>][no_of_questions]"></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
<?php
		return ob_get_clean();
	}

	/**
	 * delete Sq Mcq Questions
	 *
	 * @var $id String
	 */
	public function delete($id = null)
	{
		// $this->is_allowed('sp_mcq_question_delete');

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
					"message" => cclang('has_been_deleted', 'Exam')
				]);
			} else {
				$this->response([
					"success" => true,
					"message" => cclang('error_delete', 'Exam')
				]);
			}
		} else {
			if ($remove) {
				set_message(cclang('has_been_deleted', 'Exam'), 'success');
			} else {
				set_message(cclang('error_delete', 'Exam'), 'error');
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

		return $this->model_sp_mcq_setup->soft_delete($id);
	}
}


/* End of file sp_mcq_question.php */
/* Location: ./application/controllers/administrator/Sq Mcq Question.php */