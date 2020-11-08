<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	var $folder = 'dashboard/';
	var $dID;
	
	function __construct()
	{
		parent::__construct();
		$this->dID = $this->uri->segment(3);
		$this->model_session->check_login(NULL, 'login');
	}
	
	public function index()
	{
		$this->db->like('ctr', 'askum');
		$data['askum'] = $this->db->get('nasabah')->num_rows();
		$this->db->like('ctr', 'claim');
		$data['claim'] = $this->db->get('nasabah')->num_rows();
		$this->db->like('ctr', 'spaj');
		$data['spaj'] = $this->db->get('nasabah')->num_rows();
		$data['layout'] = $this->folder.'view';
		$this->load->view('body', $data);
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */