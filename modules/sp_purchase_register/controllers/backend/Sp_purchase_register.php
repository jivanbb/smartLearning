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
class Sp_purchase_register extends Admin
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_sp_purchase_register');
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
			$this->data['sp_purchase_registers'] = $this->model_sp_purchase_register->get($id, $role, $filter, $field, $this->limit_page, $offset);
			$this->data['sp_purchase_register_counts'] = $this->model_sp_purchase_register->count_all($id, $role, $filter, $field);
			$this->data['offset'] = $offset;
			$config = [
				'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_purchase_register/index/',
				'total_rows'   => $this->data['sp_purchase_register_counts'],
				'per_page'     => $this->limit_page,
				'uri_segment'  => 4,
			];

			$this->data['pagination'] = $this->pagination($config);

			$this->data['tables'] = $this->load->view('backend/standart/administrator/sp_purchase_register/sp_purchase_register_data_table', $this->data, true);

			if ($this->input->get('ajax')) {
				$this->response([
					'tables' => $this->data['tables'],
					'pagination' => $this->data['pagination'],
					'total_row' => $this->data['sp_purchase_register_counts']
				]);
			}

			$this->template->title('Sales Register List');
			$this->render('backend/standart/administrator/sp_purchase_register/sp_purchase_register_list', $this->data);
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
		$this->form_validation->set_rules('tax_period_type', 'Tax Period Type', 'trim|required|callback_tax_period_type');
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

			$sales_register_id  = $this->model_sp_purchase_register->store($save_data);


			if ($sales_register_id) {
				$this->data['success'] = true;
				$this->data['id'] 	   = $sales_register_id;
				$this->data['redirect'] = base_url('administrator/sp_purchase_register/purchase_register_detail/' . $sales_register_id);
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
		$declaration_form_number = $this->input->post('declaration_form_number');
		$date = $this->input->post('date');
		$supplier_pan = $this->input->post('supplier_pan');
		$supplier_name = $this->input->post('supplier_name');
		$item_name = $this->input->post('item_name');
		$quantity = $this->input->post('quantity');
		$unit = $this->input->post('unit');
		$total_purchase_price = $this->input->post('total_purchase_price');
		$purchase_discount_price = $this->input->post('purchase_discount_price');
		$vatable_price = $this->input->post('vatable_price');
		$vat_price = $this->input->post('vat_price');
		$without_vatable_price = $this->input->post('without_vatable_price');
		$without_vat_price = $this->input->post('without_vat_price');
		$capital_vatable_price = $this->input->post('capital_vatable_price');
		$capital_vat_price = $this->input->post('capital_vat_price');
		$register_id = $this->input->post('register_id');
		$count = sizeof($supplier_name);
		for ($i = 0; $i < $count; $i++) {
			$save_data = [
				'purchase_register_id' => $register_id,
				'date' => $date[$i],
				'bill_number' => $bill_number[$i],
				'declaration_form_number' => $declaration_form_number[$i],
				'supplier_pan' => $supplier_pan[$i],
				'supplier_name' => $supplier_name[$i],
				'item_name' => $item_name[$i],
				'quantity' => $quantity[$i],
				'unit' => $unit[$i],
				'total_purchase_price' => $total_purchase_price[$i],
				'purchase_discount_price' => $purchase_discount_price[$i],
				'vatable_price' => $vatable_price[$i],
				'vat_price' => $vat_price[$i],
				'without_vatable_price' => $without_vatable_price[$i],
				'without_vat_price' => $without_vat_price[$i],
				'capital_vatable_price' => $capital_vatable_price[$i],
				'capital_vat_price' => $capital_vat_price[$i],
				'created_by' => get_user_data('id'),
				'created_at' => date('Y-m-d')
			];
			$this->db->insert('sp_purchase_register_detail', $save_data);
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
			$this->data['tax_period_type'] = $this->model_sp_purchase_register->get_tax_period_type();
			$this->render('backend/standart/administrator/sp_purchase_register/sp_purchase_register_add', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	public function purchase_register_detail($id)
	{
		$this->data['register_id'] = $id;
		$this->data['sp_purchase_register'] = $this->model_sp_purchase_register->get_sales_register($id);
		$this->render('backend/standart/administrator/sp_purchase_register/sp_purchase_register_detail', $this->data);
	}

	/**
	 * Update view Sp Boards
	 *
	 * @var $id String
	 */
	public function edit($id)
	{
		if (check_role_exist_or_not(29, array("edit"))) {

			$this->data['sp_purchase_register'] = $this->model_sp_purchase_register->get_sales_register($id);
			$this->data['register_detail'] = $this->model_sp_purchase_register->get_register_detail($id);
			$this->data['tax_period_type'] = $this->model_sp_purchase_register->get_tax_period_type();
			$this->data['id'] = $id;
			$this->template->title('Register Update');
			$this->render('backend/standart/administrator/sp_purchase_register/sp_purchase_register_update', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	public function view($id)
	{
		if (check_role_exist_or_not(29, array("view"))) {
			$this->data['sp_purchase_register'] = $this->model_sp_purchase_register->get_sales_register($id);
			$this->data['register_detail'] = $this->model_sp_purchase_register->get_register_detail($id);
			$this->data['id'] = $id;
			$this->template->title('Register View');
			$this->render('backend/standart/administrator/sp_purchase_register/sp_purchase_register_view', $this->data);
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
			$register_id = $this->input->post('purchase_register_id');

			// $date = $spreadsheet->getActiveSheet()->getCell('C4')->getValue();
			$sheetData = $spreadsheet->getActiveSheet()->rangeToArray('A7:P' . $highestRow . '', NULL, True, True);
			if (!empty($sheetData)) {
				$exel_data_saved = false;
				// try{
				//   $this->db->trans_start();
				for ($i = 0; $i < count($sheetData); $i++) {
					$converte_date = convertToDateYmd($sheetData[$i][0]);
					$save_data = [
						'purchase_register_id' => $register_id,
						'date' => $converte_date,
						'bill_number' => $sheetData[$i][1],
						'declaration_form_number' => $sheetData[$i][2],
						'supplier_name' => $sheetData[$i][3],
						'supplier_pan' => $sheetData[$i][4],
						'item_name' => $sheetData[$i][5],
						'quantity' => $sheetData[$i][6],
						'unit' => $sheetData[$i][7],
						'total_purchase_price' => $sheetData[$i][8],
						'purchase_discount_price' => $sheetData[$i][9],
						'vatable_price' => $sheetData[$i][10],
						'vat_price' => $sheetData[$i][11],
						'without_vatable_price' => $sheetData[$i][12],
						'without_vat_price' => $sheetData[$i][13],
						'capital_vatable_price' => $sheetData[$i][14],
						'capital_vat_price' => $sheetData[$i][15],
						'created_by' => get_user_data('id'),
						'created_at' => date('Y-m-d')
					];
					$this->db->insert('sp_purchase_register_detail', $save_data);
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


	public function purchase_register_excel()
	{
		ob_clean(); // cleaning the buffer before Output()
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'खरिद खाता')->mergeCells('A1:O1');
		$sheet->getStyle('A1')->getAlignment()
			->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
			->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1')->getFont()->setSize(20)->setBold(1);
		$sheet->getRowDimension(1)->setRowHeight(30);
		$sheet->setCellValue('A2', '(नियम २३ को उपनियम (१) को खण्ड  (छ) संग सम्बन्धित)')->mergeCells('A2:O2');
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A2')->getFont()->setSize(11);
		$sheet->setCellValue('A3', '')->mergeCells('A3:O3');
		$sheet->setCellValue('A4', 'करदाता दर्ता नं (PAN) : ....करदाताको नाम:....   साल:............. कर अवधि: …...........')->mergeCells('A4:O4');
		$sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A4')->getFont()->setSize(10)->setBold(1);

		$tableStructure = [
			'बीजक/प्रज्ञापनपत्र नम्बर' => [
				'मिति',
				'बीजक नम्बर',
				'प्रज्ञापनपत्र नं.',
				'आपूर्तिकर्ताको नाम',
				'आपूर्तिकर्ताको स्थायी लेखा नम्बर',
				'वस्तु वा सेवाको नाम',
				'वस्तु वा सेवाको परिमाण',
				'वस्तु वा सेवाको एकाई',
			],
			'जम्मा बिक्री / निकासी (रु)',
			'स्थानीय कर छुटको बिक्री  मूल्य (रु)',
			'करयोग्य खरिद(पूंजीगत बाहेक)' => [
				'मूल्य (रु)',
				'कर (रु)'
			],
			'करयोग्य पैठारी (पूंजीगत बाहेक)' => [
				'मूल्य (रु)',
				'कर (रु)'
			],
			'पूंजीगत करयोग्य खरिद / पैठारी ' => [
				'मूल्य (रु)',
				'कर (रु)'
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

		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 'P-1-2079.80-1');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, '8456');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 'Red Cat Technology');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, '601470123');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 'Web Hosting Service and Renew');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 1);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 'units');
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 13841.26);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 0);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 0);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 0);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 0);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 0);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 0);
		$sheet->getStyle($excelColumns[$columnIndex - 1] . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$columnIndex++;
		$sheet->setCellValue($excelColumns[$columnIndex - 1] . $rowIndex, 0);
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
		header('Content-Disposition: attachment; filename=' . 'Purchase Register' . '.xlsx');
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
		if (!check_role_exist_or_not(29, array("edit"))) {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
		// $this->form_validation->set_rules('name', 'Name', 'trim|required');
		// if ($this->form_validation->run()) {
		$data_saved = false;
		try {
			$this->db->trans_start();
			$customer_id = $this->input->post('customer_id');
			$tax_period_id = $this->input->post('tax_period_id');
			$tax_period_type = $this->input->post('tax_period_type');
			$year = $this->input->post('year');
			$register_id = $this->input->post('register_id');
			$save_data = [
				'customer_id' => $customer_id,
				'tax_period_id' => $tax_period_id,
				'tax_period_type' => $tax_period_type,
				'year' => $year
			];
			$save_sp_purchase_register = $this->model_sp_purchase_register->change($register_id, $save_data);
			$updatedGroupData = $this->input->post('group');
			$updateData = [];
			$updatedPurchaseDetailIDs = [];
			if (!empty($updatedGroupData)) {
				foreach ($updatedGroupData as $groupID => $data) {
					$updatedPurchaseDetailIDs[] = $groupID;
					array_push($updateData, [
						'id' => $groupID,
						'purchase_register_id' => $register_id,
						'date' => $data['date'],
						'bill_number' => $data['bill_number'],
						'declaration_form_number' => $data['declaration_form_number'],
						'supplier_name' => $data['supplier_name'],
						'supplier_pan' => $data['supplier_pan'],
						'item_name' => $data['item_name'],
						'quantity' => $data['quantity'],
						'unit' => $data['unit'],
						'total_purchase_price' => $data['total_purchase_price'],
						'purchase_discount_price' => $data['purchase_discount_price'],
						'vatable_price' => $data['vatable_price'],
						'vat_price' => $data['vat_price'],
						'without_vatable_price' => $data['without_vatable_price'],
						'without_vat_price' => $data['without_vat_price'],
						'capital_vatable_price' => $data['capital_vatable_price'],
						'capital_vat_price' => $data['capital_vat_price'],
						'created_by' => get_user_data('id'),
						'created_at' => date('Y-m-d')

					]);
				}
			}


			if (!empty($updateData)) {
				$this->db->update_batch('sp_purchase_register_detail', $updateData, 'id');
			}
			if (!empty($updatedPurchaseDetailIDs)) {
				$this->db->where('purchase_register_id', $register_id)
					->where_not_in('id', $updatedPurchaseDetailIDs)->delete('sp_purchase_register_detail');
			}

			$bill_number = $this->input->post('bill_number');
			$declaration_form_number = $this->input->post('declaration_form_number');
			$date = $this->input->post('date');
			$supplier_pan = $this->input->post('supplier_pan');
			$supplier_name = $this->input->post('supplier_name');
			$item_name = $this->input->post('item_name');
			$quantity = $this->input->post('quantity');
			$unit = $this->input->post('unit');
			$total_purchase_price = $this->input->post('total_purchase_price');
			$purchase_discount_price = $this->input->post('purchase_discount_price');
			$vatable_price = $this->input->post('vatable_price');
			$vat_price = $this->input->post('vat_price');
			$without_vatable_price = $this->input->post('without_vatable_price');
			$without_vat_price = $this->input->post('without_vat_price');
			$capital_vatable_price = $this->input->post('capital_vatable_price');
			$capital_vat_price = $this->input->post('capital_vat_price');
			$register_id = $this->input->post('register_id');
			if (!empty($supplier_name)) {
				$count = sizeof($supplier_name);
				for ($i = 0; $i < $count; $i++) {
					$save_data = [
						'purchase_register_id' => $register_id,
						'date' => $date[$i],
						'bill_number' => $bill_number[$i],
						'declaration_form_number' => $declaration_form_number[$i],
						'supplier_pan' => $supplier_pan[$i],
						'supplier_name' => $supplier_name[$i],
						'item_name' => $item_name[$i],
						'quantity' => $quantity[$i],
						'unit' => $unit[$i],
						'total_purchase_price' => $total_purchase_price[$i],
						'purchase_discount_price' => $purchase_discount_price[$i],
						'vatable_price' => $vatable_price[$i],
						'vat_price' => $vat_price[$i],
						'without_vatable_price' => $without_vatable_price[$i],
						'without_vat_price' => $without_vat_price[$i],
						'capital_vatable_price' => $capital_vatable_price[$i],
						'capital_vat_price' => $capital_vat_price[$i],
						'created_by' => get_user_data('id'),
						'created_at' => date('Y-m-d')
					];
					$this->db->insert('sp_purchase_register_detail', $save_data);
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
		// 	$this->data['message'] = 'Opss validation failed';
		// 	$this->data['errors'] = $this->form_validation->error_array();
		// }

		$this->response($this->data);
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
			$result_list = $this->model_sp_purchase_register->get_register_list($id, $role, $filter,  $this->limit_page, $offset);
			$this->data['purchase_list'] = $result_list['result'];
			$count = $result_list["count"];
			$this->data['count'] = $count;
			$this->data['offset'] = $offset;
			$config = [
				'base_url'     => ADMIN_NAMESPACE_URL  . '/sp_purchase_register/report/',
				'total_rows'   => $count,
				'per_page'     => $this->limit_page,
				'uri_segment'  => 4,
			];
			$this->data['filter'] = $filter;
			$this->data['tax_period_type'] = $this->model_sp_purchase_register->get_tax_period_type();
			$this->data['pagination'] = $this->pagination($config);
			$this->render('backend/standart/administrator/sp_purchase_register/sp_purchase_register_report', $this->data);
		} else {
			$this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
			$this->session->set_flashdata('f_type', 'warning');
			redirect('administrator/dashboard', 'refresh');
		}
	}

	public function getPanNo()
	{
		if (isset($_GET['term'])) {
			$this->model_sp_purchase_register->getPanNo($_GET['term']);
		}
	}

	public function getSupplierPanNo()
	{
		if (isset($_GET['term'])) {
			$this->model_sp_purchase_register->getSupplierPanNo($_GET['term']);
		}
	}

	public function getTaxPeriod($slug)
	{
		$data = $this->model_sp_purchase_register->getTaxPeriod($slug);
		echo '<option value="">Select Tax Period</option>';
		foreach ($data as $key => $value) {
			echo '<option value="' . $value->id . '">' . $value->value . '</option>';
		}
		die();
	}

	public function tax_period_type()
	{
		$tax_period_id = $this->input->post('tax_period_id');
		$year = $this->input->post('year');
		$validated = true;
		if (empty($tax_period_id)) {
			$validated = false;
			$this->form_validation->set_message('tax_period_type', 'Please insert Tax Period.');
		}
		$result = $this->model_sp_purchase_register->check_already_exist($tax_period_id, $year);
		if (!empty($result)) {
			$validated = false;
			$this->form_validation->set_message('tax_period_type', 'Already exist');
		}

		return $validated;
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
		$exist = $this->model_sp_purchase_register->check_child_data_exist('sp_purchase_register', $id, $child_tables, $field);
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

		return $this->model_sp_purchase_register->soft_delete($id);
	}


	/**
	 * Export to excel
	 *
	 * @return Files Excel .xls
	 */
	public function export()
	{
		$this->is_allowed('sp_purchase_register_export');

		$this->model_sp_purchase_register->export(
			'sp_purchase_register',
			'sp_purchase_register',
			$this->model_sp_purchase_register->field_search
		);
	}

	/**
	 * Export to PDF
	 *
	 * @return Files PDF .pdf
	 */
	public function export_pdf()
	{
		$this->is_allowed('sp_purchase_register_export');

		$this->model_sp_purchase_register->pdf('sp_purchase_register', 'sp_purchase_register');
	}
}


/* End of file sp_purchase_register.php */
/* Location: ./application/controllers/administrator/Sp Board.php */