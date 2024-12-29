<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *| --------------------------------------------------------------------------
 *| Oms Bank Name Controller
 *| --------------------------------------------------------------------------
 *| Oms Bank Name site
 *|
 */
class Upload extends Admin
{

	public function __construct()
	{
		parent::__construct();

	}

	// public function image_upload(){
	// 	if (isset($_FILES['upload']['name'])) {
	// 		$file_name = $_FILES['upload']['name'];
	// 		$file_tmp = $_FILES['upload']['tmp_name'];
	// 		$file_type = $_FILES['upload']['type'];
	// 		$file_ext = strtolower(end(explode('.', $file_name)));
			
	// 		$extensions = array("jpeg", "jpg", "png");
		
	// 		if (in_array($file_ext, $extensions) === false) {
	// 			echo '{"uploaded": false, "error": {"message": "File extension not allowed"}}';
	// 			exit();
	// 		}
		
	// 		if (move_uploaded_file($file_tmp, FCPATH."uploads/" . $file_name)) {
	// 			echo '{"uploaded": true, "url": "'.FCPATH.'uploads/' . $file_name . '"}';
	// 		} else {
	// 			echo '{"uploaded": false, "error": {"message": "File upload failed"}}';
	// 		}
	// 	} else {
	// 		echo '{"uploaded": false, "error": {"message": "No file found"}}';
	// 	}
	// }
	public function answer_upload() {
        if (!empty($_FILES['upload']['name'])) {
            $config['upload_path']          = 'uploads/answer';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 1000; // max file size in KB
            $config['overwrite']            = TRUE;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('upload')) {
                $error = array('error' => $this->upload->display_errors());
                echo json_encode($error);
            } else {
                $data = array('upload_data' => $this->upload->data());
                $url = base_url() . 'uploads/answer/' . $data['upload_data']['file_name'];				
                // echo json_encode(array('url' => $url));
				  echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']}, '{$url}', '');</script>";
            }
        } else {
            echo json_encode(array('error' => 'No file selected.'));
        }
}
public function question_upload() {
	if (!empty($_FILES['upload']['name'])) {
		$config['upload_path']          = 'uploads/question';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 1000; // max file size in KB
		$config['overwrite']            = TRUE;
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('upload')) {
			$error = array('error' => $this->upload->display_errors());
			echo json_encode($error);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$url = base_url() . 'uploads/question/' . $data['upload_data']['file_name'];				
			// echo json_encode(array('url' => $url));
			  echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']}, '{$url}', '');</script>";
		}
	} else {
		echo json_encode(array('error' => 'No file selected.'));
	}
}
}


/* End of file oms_bank_name.php */
/* Location: ./application/controllers/administrator/Oms Bank Name.php */