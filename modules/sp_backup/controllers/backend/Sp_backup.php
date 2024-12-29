<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
*| --------------------------------------------------------------------------
*| Sp Level Controller
*| --------------------------------------------------------------------------
*| Sp Level site
*|
*/
class Sp_backup extends Admin	
{
	const BACKUP_PATH = FCPATH . 'db_backups';
	public function __construct()
	{
		parent::__construct();
	}

	/**
	* show all Sp Levels
	*
	* @var $offset String
	*/
	public function index($offset = 0)
	{
		if (check_role_exist_or_not(24, array("add", "edit", "view", "list"))) {
	    $fileList = glob(static::BACKUP_PATH . '/backup_*.gz') ?: [];
            natsort($fileList);

            $config = [
                'base_url' => 'administrator/sp_backup/index/',
                'total_rows' => count($fileList),
                'per_page' => $this->limit_page,
                'uri_segment' => 4,
            ];

            $this->data['pagination'] = $this->pagination($config);
            $this->data['fileList'] = array_slice(array_reverse($fileList), $offset, $this->limit_page);;
            $this->render('backend/standart/administrator/sp_backup/backup', $this->data);
		} else {
            $this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
            $this->session->set_flashdata('f_type', 'warning');
            redirect('administrator/dashboard', 'refresh');
        }
	}
	
	/**
	* Add new sp_levels
	*
	*/
	public function add()
	{
		
        if (!check_role_exist_or_not(24, array("add"))) {
            $this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
            $this->session->set_flashdata('f_type', 'warning');
            redirect('administrator/dashboard', 'refresh');
        }
		$now = new DateTime();
        $backupPath = static::BACKUP_PATH;
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 755, true);
        }

        // Load the DB utility class
        $this->load->dbutil();

        $prefs = array(
            'format' => 'gzip',  // gzip, zip, txt
        );

        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup($prefs);
        if ($backup) {
            // Load the file helper and write the file to your server
            $this->load->helper('file');

            if (write_file($backupPath . '/backup_' . $now->format('Y-m-d_H-i-s') . '.gz', $backup)) {
                set_message('Backup successful', 'success');
                redirect('administrator/sp_backup');
            }
        }

        set_message('Backup Creation failed', 'error');
        redirect('administrator/sp_backup');
	}

	/**
	* Add New Sp Levels
	*
	* @return JSON
	*/
	public function download_backup($fileName){		
		if (!check_role_exist_or_not(24, array("add", "edit", "view", "list"))) {
            $this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
            $this->session->set_flashdata('f_type', 'warning');
            redirect('administrator/dashboard', 'refresh');
        }

        $file = static::BACKUP_PATH . '/' . $fileName . '.gz';
        if (!is_file($file)) {
            set_message('Backup file does not exist.', 'error');
            redirect('administrator/sp_backup');
        }

        $this->load->helper('file');
        $this->load->helper('download');
        force_download($fileName . '.gz', file_get_contents(static::BACKUP_PATH . '/' . $fileName . '.gz'));
        exit;
	}
	
	public function delete_backup($fileName)
    {
        if (!check_role_exist_or_not(24, array("delete"))) {
            $this->session->set_flashdata('f_message', 'Sorry you do not have permission to access ');
            $this->session->set_flashdata('f_type', 'warning');
            redirect('administrator/dashboard', 'refresh');
        }

        $file = static::BACKUP_PATH . '/' . $fileName . '.gz';
        if (!is_file($file)) {
            set_message('Backup file does not exist.', 'error');
            redirect('administrator/sp_backup');
        }

        if (unlink($file)) {
            set_message('Backup deleted successfully', 'success');
            redirect('administrator/sp_backup');
        }

        set_message('Error deleting backup file.', 'error');
        redirect('administrator/sp_backup');
    }

	
}


/* End of file sp_level.php */
/* Location: ./application/controllers/administrator/Sp Level.php */