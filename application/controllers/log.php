<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends CI_Controller {
	
	var $folder = 'log/';

	function __construct() {
		parent::__construct();
		$this->load->model('model_log');
		$this->load->helper('date');
		$this->model_session->check_login(NULL, 'login');
	}	
	
	public function index()
	{	
		$this->model_session->auth_page('log', 4);
		$this->model_session->log_activity('V', current_url());	
		$data['layout'] = $this->folder.'admin_log';
		$this->load->view('body', $data);
	}
	
	public function admin_json_data()
	{		
		$this->model_session->auth_page('log', 4);
		$this->model_log->get_admin_datatable_json();		
	}
	
	public function admin_flush()
	{		
		$this->model_session->auth_page('log', 4);		
		if($this->model_log->admin_flush_log()==FALSE) 
		{
			$msg = '<p class="alert alert-warning">Tidak ada data yang dihapus.</p>';
		}
		else
		{
			$msg = '<p class="alert alert-success">Berhasil menghapus semua log aktivitas server.</p>';
		}
		
		$this->model_session->log_activity('Flush Admin Log', current_url());
		$data['message'] = $msg;
		$data['layout'] = $this->folder.'flush_result_admin';
		$this->load->view('body', $data);
	}
	
	public function e_a_log()
	{
		$this->model_session->auth_page('log', 4);
		$this->model_session->log_activity('E', current_url());	
		$id = $this->uri->segment(3);
		$this->db->select('log_ip,log_date,log_agent,log_activity,userFname');
		$this->db->join(DBUSR, DBUSR.'.userID = '.DBLOG.'.ID_user');
		$this->db->where('log_ID', $id);
		$row = $this->db->get(DBLOG, 1)->row();
		
		if(!$row || !$id) {
			redirect(404);
		}
		
		$data['records'] = $row;				
		$data['layout'] = $this->folder.'detail_admin_log';
		$this->load->view('body', $data);
	}	
	
	public function download()
	{
		$sql = "SELECT * FROM ar_user_log ORDER BY log_ID";
		$results = $this->db->query($sql)->result_array();
		
		
		

		$filename = "./uploads/db_log_export.csv";

		// Actually create the file
		// The w+ parameter will wipe out and overwrite any existing file with the same name
		$handle = fopen($filename, 'w+');
		
		fputcsv($handle, array('Log ID','Log Name','Log Activity','Log Agent', 'Log IP','Log Type','Log Date'));

		foreach($results as $key=>$val)
		{
		fputcsv($handle, array($val['log_ID'],$val['log_name'],$val['log_activity'],$val['log_agent'], $val['log_ip'],$val['log_type'],$val['log_date']));
		}		
		
		$file_url = ''.$filename.'';
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary"); 
		header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
		readfile($file_url);
		
		}
	
}
/* End of file Log.php */
/* Location: ./application/controllers/Log.php */