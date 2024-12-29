<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 *| --------------------------------------------------------------------------
 *| Sp Board Controller
 *| --------------------------------------------------------------------------
 *| Sp Board site
 *|
 */
class Sp_sales_register extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_sales_register');
		$this->load->model('group/model_group');
		$this->lang->load('web_lang', $this->current_lang);
		if (!$this->session->userdata('loggedin')) {
			redirect('/', 'refresh');
		}
	}

	/**
	 * show all Sp Boards
	 *
	 * @var $offset String
	 */
	public function index($offset = 0)
	{
		if (check_role_exist_or_not(29, array("view", "edit", "list"))) {
			$positions = get_user_position();
			$filter = $this->input->get('q');
			$field 	= $this->input->get('f');
			$id = get_user_data('id');
			if (check_role_exist_or_not(29, array('self_only'))) {
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
			$this->data['sp_sales_registers'] = $this->model_sp_sales_register->get($id, $role, $filter, $field, $this->limit_page, $offset);
			$this->data['sp_sales_register_counts'] = $this->model_sp_sales_register->count_all($id, $role, $filter, $field);
			$this->data['offset'] = $offset;
			$config = [
				'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_sales_register/index/',
				'total_rows'   => $this->data['sp_sales_register_counts'],
				'per_page'     => $this->limit_page,
				'uri_segment'  => 4,
			];

			$this->data['pagination'] = $this->pagination($config);

			$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_sales_register/sp_sales_register_data_table', $this->data, true);

			if ($this->input->get('ajax')) {
				$this->response([
					'tables' => $this->data['tables'],
					'pagination' => $this->data['pagination'],
					'total_row' => $this->data['sp_sales_register_counts']
				]);
			}

			$this->template->title('Sales Register List');
			$this->render('backend/standart/administrator/sp_sales_register/sp_sales_register_list', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}



	/**
	 * Add New Sp Boards
	 *
	 * @return JSON
	 */
	public function add_save()
	{
		if (!check_role_exist_or_not(29, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('pan_no', 'Pan No', 'trim|required');
		$this->form_validation->set_rules('tax_period_type', 'Tax Period Type', 'trim|required');
		$this->form_validation->set_rules('tax_period_id', 'Tax Period', 'trim|required');
		$this->form_validation->set_rules('year', 'Year', 'trim|required');
		if ($this->form_validation->run()) {

			$save_data = [
				'customer_id' => $this->input->post('customer_id'),
				'tax_period_id' => $this->input->post('tax_period_id'),
				'tax_period_type' => $this->input->post('tax_period_type'),
				'year' => $this->input->post('year'),
				'created_at' => date('Y-m-d'),
				'created_by' => get_user_data('id'),
			];

			$sales_register_id  = $this->model_sp_sales_register->store($save_data);


			if ($sales_register_id) {
				$this->data['success'] = true;
				$this->data['id'] 	   = $sales_register_id;
				$this->data['redirect'] = base_url('administrator/sp_sales_register/sales_register_detail/' . $sales_register_id);
				$this->data['message'] = cclang('success_save_data_stay');
			} else {

				$this->data['success'] = false;
				$this->data['message'] = cclang('data_not_change');
			}
		} else {
			$this->data['success'] = false;
			$this->data['message'] = 'Opss validation failed';
			$this->data['errors'] = $this->form_validation->error_array();
		}

		$this->response($this->data);
		exit;
	}

	public function detail_save()
	{
		if (!check_role_exist_or_not(29, array("add"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		// $this->form_validation->set_rules('name', 'Name', 'trim|required');
		// $this->form_validation->set_rules('pan_no', 'Pan No', 'trim|required');
		// $this->form_validation->set_rules('tax_period_type', 'Tax Period Type', 'trim|required');
		// $this->form_validation->set_rules('tax_period_id', 'Tax Period', 'trim|required');
		// $this->form_validation->set_rules('year', 'Year', 'trim|required');
		// if ($this->form_validation->run()) {
		$bill_number = $this->input->post('bill_number');
		$date = $this->input->post('date');
		$customer_pan = $this->input->post('customer_pan');
		$customer_name = $this->input->post('customer_name');
		$item_name = $this->input->post('item_name');
		$quantity = $this->input->post('quantity');
		$unit = $this->input->post('unit');
		$total = $this->input->post('total');
		$taxable_discount_price = $this->input->post('taxable_discount_price');
		$vatable_price = $this->input->post('vatable_price');
		$vat_price = $this->input->post('vat_price');
		$withdraw_item_price = $this->input->post('withdraw_item_price');
		$withdraw_country = $this->input->post('withdraw_country');
		$withdraw_date = $this->input->post('withdraw_date');
		$withdraw_letter_no = $this->input->post('withdraw_letter_no');
		$register_id = $this->input->post('register_id');
		$count = sizeof($customer_name);
		for ($i = 0; $i < $count; $i++) {
			$save_data = [
				'sales_register_id' => $register_id,
				'date' => $date[$i],
				'bill_number' => $bill_number[$i],
				'customer_pan' => $customer_pan[$i],
				'customer_name' => $customer_name[$i],
				'item_name' => $item_name[$i],
				'quantity' => $quantity[$i],
				'unit' => $unit[$i],
				'total' => $total[$i],
				'taxable_discount_price' => $taxable_discount_price[$i],
				'vatable_price' => $vatable_price[$i],
				'vat_price' => $vat_price[$i],
				'withdraw_item_price' => $withdraw_item_price[$i],
				'withdraw_country' => $withdraw_country[$i],
				'withdraw_date' => $withdraw_date[$i],
				'withdraw_letter_no' => $withdraw_letter_no[$i],
				'created_by' => get_user_data('id'),
				'created_at' => date('Y-m-d')
			];
			$this->db->insert('sp_sales_register_detail', $save_data);
			$sales_register_id = $this->db->insert_id();
		}

		if ($sales_register_id) {
			$this->data['success'] = true;
			$this->data['id'] 	   = $sales_register_id;
			$this->data['message'] = cclang('success_save_data_stay');
		} else {

			$this->data['success'] = false;
			$this->data['message'] = cclang('data_not_change');
		}
		// } else {
		// 	$this->data['success'] = false;
		// 	$this->data['message'] = 'Opss validation failed';
		// 	$this->data['errors'] = $this->form_validation->error_array();
		// }

		$this->response($this->data);
		exit;
	}

	public function add()
	{
		if (check_role_exist_or_not(29, array("add"))) {
			$this->template->title('Sales Register');
			$this->data['months'] = englishMonthsName();
			$this->data['tax_period_type'] = $this->model_sp_sales_register->get_tax_period_type();
			$this->render('backend/standart/administrator/sp_sales_register/sp_sales_register_add', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	public function sales_register_detail($id)
	{
		$this->data['register_id'] = $id;
		$this->data['sp_sales_register'] = $this->model_sp_sales_register->get_sales_register($id);
		$this->render('backend/standart/administrator/sp_sales_register/sp_sales_register_detail', $this->data);
	}

	/**
	 * Update view Sp Boards
	 *
	 * @var $id String
	 */
	public function edit($id)
	{
		if (check_role_exist_or_not(29, array("edit"))) {

			$this->data['sp_sales_register'] = $this->model_sp_sales_register->get_sales_register($id);
			$this->data['register_detail'] = $this->model_sp_sales_register->get_register_detail($id);
			$this->data['id'] = $id;
			$this->data['tax_period_type'] = $this->model_sp_sales_register->get_tax_period_type();
			$this->template->title('Register Update');
			$this->render('backend/standart/administrator/sp_sales_register/sp_sales_register_update', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	public function view($id)
	{
		if (check_role_exist_or_not(29, array("view"))) {
			$this->data['sp_sales_register'] = $this->model_sp_sales_register->get_sales_register($id);
			$this->data['register_detail'] = $this->model_sp_sales_register->get_register_detail($id);
			$this->data['id'] = $id;
			$this->template->title('Register View');
			$this->render('backend/standart/administrator/sp_sales_register/sp_sales_register_view', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	public function report($offset = 0)
	{
		if (check_role_exist_or_not(30, array("view"))) {
			$filter = $this->input->get();
			$positions = get_user_position();
			$this->template->title('Report');
			$id = get_user_data('id');
			if (check_role_exist_or_not(30, array('self_only'))) {
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
			$result_list = $this->model_sp_sales_register->get_register_list($id, $role, $filter,  $this->limit_page, $offset);
			$this->data['sales_list'] = $result_list['result'];
			$count = $result_list["count"];
			$this->data['count'] = $count;
			$this->data['offset'] = $offset;
			$config = [
				'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_sales_register/report/',
				'total_rows'   => $count,
				'per_page'     => $this->limit_page,
				'uri_segment'  => 4,
			];
			$this->data['filter'] = $filter;
			$this->data['pagination'] = $this->pagination($config);
			$this->data['tax_period_type'] = $this->model_sp_sales_register->get_tax_period_type();
			// var_dump($this->data['sales_list']); die();
			$this->render('backend/standart/administrator/sp_sales_register/sp_sales_register_report', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	public function import()
	{
		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
			$arr_file = explode('.', $_FILES['upload_file']['name']);
			$extension = end($arr_file);
			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} elseif ('xls' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
			$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
			$register_id = $this->input->post('sales_register_id');

			// $date = $spreadsheet->getActiveSheet()->getCell('C4')->getValue();
			$sheetData = $spreadsheet->getActiveSheet()->rangeToArray('A7:O' . $highestRow . '', NULL, True, True);
			if (!empty($sheetData)) {
				$exel_data_saved = false;
				// try{
				//   $this->db->trans_start();
				for ($i = 0; $i < count($sheetData); $i++) {
					$converte_date = convertToDateYmd($sheetData[$i][0]);
					$withdraw_date = convertToDateYmd($sheetData[$i][14]);
					$save_data = [
						'sales_register_id' => $register_id,
						'date' => $converte_date,
						'bill_number' => $sheetData[$i][1],
						'customer_name' => $sheetData[$i][2],
						'customer_pan' => $sheetData[$i][3],
						'item_name' => $sheetData[$i][4],
						'quantity' => $sheetData[$i][5],
						'unit' => $sheetData[$i][6],
						'total' => $sheetData[$i][7],
						'taxable_discount_price' => $sheetData[$i][8],
						'vatable_price' => $sheetData[$i][9],
						'vat_price' => $sheetData[$i][10],
						'withdraw_item_price' => $sheetData[$i][11],
						'withdraw_country' => $sheetData[$i][12],
						'withdraw_letter_no' => $sheetData[$i][13],
						'withdraw_date' => $withdraw_date,
						'created_by' => get_user_data('id'),
						'created_at' => date('Y-m-d')
					];
					$this->db->insert('sp_sales_register_detail', $save_data);
				}
				if ($register_id) {
					set_message(cclang('Sucessfully Uploaded'), 'success');
				} else {
					set_message(cclang('error_delete', 'Assets'), 'error');
				}

				redirect_back();
			}
		}
	}


	public function sales_register_excel()
	{
		ob_clean(); // cleaning the buffer before Output()
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'बिक्री खाता')->mergeCells('A1:O1');
		$sheet->getStyle('A1')->getAlignment()
			->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1')->getFont()->setSize(20)->setBold(1);
		$sheet->getRowDimension(1)->setRowHeight(30);
		$sheet->setCellValue('A2', '(नियम २३ को उपनियम (१) को खण्ड  (ज) संग सम्बन्धित)')->mergeCells('A2:O2');
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A2')->getFont()->setSize(11);
		$sheet->setCellValue('A3', '')->mergeCells('A3:O3');
		$sheet->setCellValue('A4', 'करदाता दर्ता नं (PAN) : ....करदाताको नाम:....   साल:............. कर अवधि: …...........')->mergeCells('A4:O4');
		$sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A4')->getFont()->setSize(10)->setBold(1);

		$tableStructure = [
			'बीजक' => [
				'मिति',
				'बीजक नम्बर',
				'खरिदकर्ताको नाम',
				'खरिदकर्ताको स्थायी लेखा नम्बर',
				'वस्तु वा सेवाको नाम',
				'वस्तु वा सेवाको परिमाण',
				'वस्तु वा सेवाको एकाई',
			],
			'जम्मा बिक्री / निकासी (रु)',
			'स्थानीय कर छुटको बिक्री  मूल्य (रु)',
			'करयोग्य बिक्री' => [
				'मूल्य (रु)',
				'कर (रु)'
			],
			'निकासी' => [
				'निकासी गरेको वस्तु वा सेवाको मूल्य (रु)',
				'निकासी गरेको देश',
				'निकासी प्रज्ञापनपत्र नम्बर',
				'निकासी प्रज्ञापनपत्र मिति'
			],
		];

		$alphabets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$excelColumns = str_split($alphabets);
		$rowIndex = 5;
		$columnIndex = 1;
		foreach ($tableStructure as $columnKey => $column) {
			$cellCoordinate = $excelColumns[$columnIndex - 1] . $rowIndex;
			if (is_array($column)) {
				$mergedCellCoordinate = $excelColumns[($columnIndex - 1) + (count($column) - 1)] . $rowIndex;
				$sheet->setCellValue($cellCoordinate, $columnKey)->mergeCells($cellCoordinate . ':' . $mergedCellCoordinate);
				$sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				$sheet->getStyle($cellCoordinate)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
				$sheet->getStyle($cellCoordinate)->getFont()->setSize(10)->setBold(1);

				$subRowIndex = $rowIndex + 1;
				$subRowColIndex = $columnIndex;
				foreach ($column as $col) {
					$cellCoordinate = $excelColumns[$subRowColIndex - 1] . $subRowIndex;
					$sheet->setCellValue($cellCoordinate, $col);
					$sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
					$sheet->getStyle($cellCoordinate)->getFont()->setSize(10)->setBold(1);
					$columnIndex++;
					$subRowColIndex++;
				}
				continue;
			}

			$mergedCellCoordinate = $excelColumns[($columnIndex - 1)] . ($rowIndex + 1);
			$sheet->setCellValue($cellCoordinate, $column)->mergeCells($cellCoordinate . ':' . $mergedCellCoordinate);
			$sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$sheet->getStyle($cellCoordinate)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$columnIndex++;
		}

		$rowIndex = 7;

		$columnIndex = 1;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, '2079-04-02');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;

		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 'S-1-2079.80-1');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 'Red Cat Technology');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, '601470123');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 'Development and support');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 1);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 'units');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 166249);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 0);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 166249);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 21612.37);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 0);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 'Nepal');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, NULL);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, NULL);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

		foreach (range('A', $sheet->getHighestColumn()) as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
			$sheet->getStyle($col)->getAlignment()->setWrapText(true);
		}

		/**
		 * set height of row 5 to double of individual height as this row has text wrapped heading
		 */
		$sheet->getRowDimension(5)->setRowHeight('30');

		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename=' . 'Sales Register' . '.xlsx');
		$writer->save('php://output');
		exit;
	}

	/**
	 * Update Sp Boards
	 *
	 * @var $id String
	 */
	public function edit_save()
	{

		if (!check_role_exist_or_not(120, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		// $this->form_validation->set_rules('group[][name]', 'Name', 'trim|callback_check_country_name');
		// if ($this->form_validation->run()) {
		$data_saved = false;
		try {
			$this->db->trans_start();
			$customer_id = $this->input->post('customer_id');
			$tax_period_type = $this->input->post('tax_period_type');
			$tax_period_id = $this->input->post('tax_period_id');
			$year = $this->input->post('year');
			$updatedGroupData = $this->input->post('group');
			$register_id = $this->input->post('register_id');
			$sales_register = [
				'customer_id' => $customer_id,
				'tax_period_id' => $tax_period_id,
				'tax_period_type' => $tax_period_type,
				'year' => $year
			];
			$this->db->where('id', $register_id);
			$this->db->update('sp_sales_register', $sales_register);
			$updateData = [];
			$updatedSalesDetailIDs = [];
			if (!empty($updatedGroupData)) {
				foreach ($updatedGroupData as $groupID => $data) {
					$updatedSalesDetailIDs[] = $groupID;
					array_push($updateData, [
						'id' => $groupID,
						'sales_register_id' => $register_id,
						'date' => $data['date'],
						'bill_number' => $data['bill_number'],
						'customer_name' => $data['customer_name'],
						'customer_pan' => $data['customer_pan'],
						'item_name' => $data['item_name'],
						'quantity' => $data['quantity'],
						'unit' => $data['unit'],
						'total' => $data['total'],
						'taxable_discount_price' => $data['taxable_discount_price'],
						'vatable_price' => $data['vatable_price'],
						'vat_price' => $data['vat_price'],
						'withdraw_item_price' => $data['withdraw_item_price'],
						'withdraw_country' => $data['withdraw_country'],
						'withdraw_letter_no' => $data['withdraw_letter_no'],
						'withdraw_date' => $data['withdraw_date'],
						'created_by' => get_user_data('id'),
						'created_at' => date('Y-m-d')

					]);
				}
			}

			if (!empty($updateData)) {
				$this->db->update_batch('sp_sales_register_detail', $updateData, 'id');
			}
			if (!empty($updatedSalesDetailIDs)) {
				$this->db->where('sales_register_id', $register_id)
					->where_not_in('id', $updatedSalesDetailIDs)->delete('sp_sales_register_detail');
			}
			$bill_number = $this->input->post('bill_number');
			$date = $this->input->post('date');
			$customer_pan = $this->input->post('customer_pan');
			$customer_name = $this->input->post('customer_name');
			$item_name = $this->input->post('item_name');
			$quantity = $this->input->post('quantity');
			$unit = $this->input->post('unit');
			$total = $this->input->post('total');
			$taxable_discount_price = $this->input->post('taxable_discount_price');
			$vatable_price = $this->input->post('vatable_price');
			$vat_price = $this->input->post('vat_price');
			$withdraw_item_price = $this->input->post('withdraw_item_price');
			$withdraw_country = $this->input->post('withdraw_country');
			$withdraw_date = $this->input->post('withdraw_date');
			$withdraw_letter_no = $this->input->post('withdraw_letter_no');
			$register_id = $this->input->post('register_id');
			if (!empty($customer_name)) {
				$count = sizeof($customer_name);
				for ($i = 0; $i < $count; $i++) {
					$save_data = [
						'sales_register_id' => $register_id,
						'date' => $date[$i],
						'bill_number' => $bill_number[$i],
						'customer_pan' => $customer_pan[$i],
						'customer_name' => $customer_name[$i],
						'item_name' => $item_name[$i],
						'quantity' => $quantity[$i],
						'unit' => $unit[$i],
						'total' => $total[$i],
						'taxable_discount_price' => $taxable_discount_price[$i],
						'vatable_price' => $vatable_price[$i],
						'vat_price' => $vat_price[$i],
						'withdraw_item_price' => $withdraw_item_price[$i],
						'withdraw_country' => $withdraw_country[$i],
						'withdraw_date' => $withdraw_date[$i]??NULL,
						'withdraw_letter_no' => $withdraw_letter_no[$i],
						'created_by' => get_user_data('id'),
						'created_at' => date('Y-m-d')
					];
					$this->db->insert('sp_sales_register_detail', $save_data);
				}
			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_complete();
				$data_saved = true;
			}
		} catch (Exception $e) {
			$this->db->trans_rollback();
		}
		if (!empty($data_saved)) {
			$this->data['success'] = true;
			$this->data['message'] = cclang('success_update_data_stay');
		} else {
			$this->data['success'] = false;
			$this->data['message'] = cclang('data_not_change');
		}
		// } else {
		// 	$this->data['success'] = false;
		// 	$this->data['message'] = validation_errors();
		// }

		echo json_encode($this->data);
	}

	public function getPanNo()
	{
		if (isset($_GET['term'])) {
			$this->model_sp_sales_register->getPanNo($_GET['term']);
		}
	}

	public function getCustomerPanNo()
	{
		if (isset($_GET['term'])) {
			$this->model_sp_sales_register->getCustomerPanNo($_GET['term']);
		}
	}

	public function getTaxPeriod($slug)
	{
		$data = $this->model_sp_sales_register->getTaxPeriod($slug);
		echo '<option value="">Select Tax Period</option>';
		foreach ($data as $key => $value) {
			echo '<option value="' . $value->id . '">' . $value->value . '</option>';
		}
		die();
	}

	/**
	 * delete Sp Boards
	 *
	 * @var $id String
	 */
	public function delete($id = null)
	{
		if (!check_role_exist_or_not(29, array("delete"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}

		$this->load->helper('file');
		$child_tables = array(
			'sp_course' => 'board_university',
		);
		$field = 'id';
		$exist = $this->model_sp_sales_register->check_child_data_exist('sp_sales_register', $id, $child_tables, $field);
		if ($exist) {
			$this->session->set_flashdata('f_message', 'Sorry this Board/University is used ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/oms_branch', 'refresh');
		}
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
					"message" => cclang('has_been_deleted', 'board')
				]);
			} else {
				$this->response([
					"success" => true,
					"message" => cclang('error_delete', 'board')
				]);
			}
		} else {
			if ($remove) {
				set_message(cclang('has_been_deleted', 'board'), 'success');
			} else {
				set_message(cclang('error_delete', 'board'), 'error');
			}
			redirect_back();
		}
	}



	/**
	 * delete Sp Boards
	 *
	 * @var $id String
	 */
	private function _remove($id)
	{

		return $this->model_sp_sales_register->soft_delete($id);
	}


	/**
	 * Export to excel
	 *
	 * @return Files Excel .xls
	 */
	public function export()
	{
		$this->is_allowed('sp_sales_register_export');

		$this->model_sp_sales_register->export(
			'sp_sales_register',
			'sp_sales_register',
			$this->model_sp_sales_register->field_search
		);
	}

	/**
	 * Export to PDF
	 *
	 * @return Files PDF .pdf
	 */
	public function export_pdf()
	{
		$this->is_allowed('sp_sales_register_export');

		$this->model_sp_sales_register->pdf('sp_sales_register', 'sp_sales_register');
	}
}


/* End of file sp_sales_register.php */
/* Location: ./application/controllers/administrator/Sp Board.php */