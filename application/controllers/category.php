<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

  var $folder = 'category/';
	var $dID;

  function __construct()
	{
		parent::__construct();
		$this->dID = $this->uri->segment(3);
		$this->load->model('model_category');
    	$this->form_validation->set_error_delimiters('<div class="help-inline important">', '</div>');
	}

	public function index()
	{
		$this->model_session->auth_page('category', 2);
		$this->model_session->log_activity('V', current_url());
		$data['layout'] = $this->folder.'view';
		$this->load->view('body', $data);
	}
	
	public function json_data()
	{
		$this->model_session->auth_page('category', 2);
		$this->model_category->get_datatable_json();		
	}
	
	public function a()
	{
		$this->model_session->auth_page('category', 2);
		$this->model_session->log_activity('V', current_url());
		$data['layout'] = $this->folder.'a';
		$this->load->view('body', $data);
	}

	public function i()
	{
		$this->model_session->auth_page('category', 2);
		$this->model_session->log_activity('A', current_url());
		$this->form_validation->set_rules('name', 'Name', 'required');
	
		if($this->form_validation->run()==FALSE)
		{
			$this->a();
		}
		else
		{
			$this->model_session->log_activity('A', current_url(), $_POST);
			$insertID = $this->model_category->insert();
			$this->session->set_flashdata('success', 'A new data has been stored, <a href="'.site_url('category/e/'.$insertID).'">Click here for details</a>');
			redirect(site_url('category/a'));		
		}
	}

	public function e()
	{
		$this->model_session->auth_page('category', 3);
		$this->model_session->log_activity('E', current_url());
		$id = $this->uri->segment(3);
		$data['records'] = $this->model_category->get_byid($id)->row();
		$data['layout'] = $this->folder.'e';
		$this->load->view('body', $data);		
	}

	public function u()
	{
		$this->model_session->auth_page('category', 3);
		$this->model_session->log_activity('E', current_url());
		$this->form_validation->set_rules('name', 'Name', 'required');
	
		if($this->form_validation->run()==FALSE)
		{
			$this->e($this->input->post('id'));
		}
		else
		{
			$this->model_session->log_activity('E', current_url(), $_POST);
			$this->model_category->update();
			$this->session->set_flashdata('success', 'Data has been updated.');
			redirect(site_url('category/e/'.$this->input->post('id')));	
		}
	}
	
	public function d()
	{	
		$this->model_session->auth_page('category', 4);
		$id = $this->dID;
		if(!$id)
		{
			redirect(404);
		}
		
		$return = $this->model_category->delete($this->dID);
		if($return)
		{
			$this->model_session->log_activity('D', current_url());
			$this->session->set_flashdata('success', 'Data has been deleted.');
		}
		redirect(site_url('category'));
	}
	
}
/* End of file User.php */
/* Location: ./application/controllers/User.php */ ?>