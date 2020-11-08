<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends CI_Controller {
	
	var $folder = 'role/';
	
	function __construct()
	{
		parent::__construct();
		$this->model_session->check_login(NULL, 'login');
		$this->load->model('model_role');
		$this->form_validation->set_error_delimiters('<div class="help-inline important">', '</div>');
	}
	
	public function index()
	{
		$this->model_session->auth_page('role', 4);
		
		$this->model_session->log_activity('V', current_url());
		$data['layout'] = $this->folder.'view';
		$this->load->view('body', $data);
	}
	
	public function json_data()
	{
		$this->model_session->auth_page('role', 4);
		
		$this->model_role->get_datatable_json();		
	}
	
	public function a()
	{
		$this->model_session->auth_page('role', 4);
		$this->model_session->log_activity('V', current_url());
		
		$data['auth_pages'] = $this->config->item('auth_pages');
		$data['auth_array'] = $this->config->item('auth_array');
		$data['layout'] = $this->folder.'a';
		$this->load->view('body', $data);
	}
	
	public function i()
	{
		$this->model_session->auth_page('role', 4);
		$this->model_session->log_activity('A', current_url());	
		$this->form_validation->set_rules('name', 'Nama Lengkap', 'required|max_length[50]');
		$this->form_validation->set_rules('desc', 'Deskripsi Role', 'max_length[250]');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->a();
		}
		else
		{
			$this->model_session->log_activity('A', current_url(), $_POST);
			$insertID = $this->model_role->insert();
			$this->session->set_flashdata('success', 'Data baru telah terentry, <a href="'.site_url('role/e/'.$insertID).'">Untuk detailnya klik disini</a>');
			redirect(site_url('role/a'));			
		}
	}
	
	public function e()
	{
		$this->model_session->auth_page('role', 4);
		$this->model_session->log_activity('V', current_url());
		
		$id = $this->uri->segment(3);
		
		$records = $this->model_role->get_byID($id);
		
		if(!$records || !$id)
		{
			redirect(404);
		}
		
		$data['auth_pages'] = $this->config->item('auth_pages');
		$data['auth_array'] = $this->config->item('auth_array');
		
		$data['group_id'] = $records->group_id;
		$data['group_title'] = $records->group_title;
		$data['group_desc'] = $records->group_desc;
		$data['group_lvl'] = '';
				
		$data['group_lvl'] = $this->model_role->fetch_lvl($records->group_lvl);
		
		$data['layout'] = $this->folder.'e';
		$this->load->view('body', $data);
	}
	
	public function u()
	{
		$this->model_session->auth_page('role', 4);
		$this->model_session->log_activity('E', current_url());	
		$this->form_validation->set_rules('name', 'Nama Lengkap', 'required|max_length[50]');
		$this->form_validation->set_rules('desc', 'Deskripsi Role', 'max_length[250]');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->e($this->input->post('id'));
		}
		else
		{

			$this->model_session->log_activity('E', current_url(), $_POST);
			$this->model_role->update();
			if($this->session->userdata('gID')==$this->input->post('id'))
			{
				redirect(site_url('logout'));
			}
			$this->session->set_flashdata('success', 'Data telah diperbaharui, <a href="'.site_url('role/u/'.$this->input->post('id')).'">Untuk detailnya klik disini</a>');
			redirect(site_url('role'));			
		}		
	}
	
	public function d()
	{
		$this->model_session->auth_page('role', 4);
		
		$id = $this->uri->segment(3);
		if(!$id)
		{
			redirect(404);
		}
		
		$return = $this->model_role->delete($id);
		if($return)
		{
			$this->session->set_flashdata('success', 'Data telah berhasil dihapus.');
		}
		
		$this->model_session->log_activity('D', current_url());
		redirect(site_url('role'));
	}
	
}
/* End of file Role.php */
/* Location: ./application/controllers/Role.php */