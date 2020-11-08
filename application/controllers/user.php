<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

  var $folder = 'user/';
	var $dID;

  function __construct()
	{
		parent::__construct();
		$this->dID = $this->uri->segment(3);
		$this->load->model('model_user');
		$this->load->model('model_department');
		$this->form_validation->set_error_delimiters('<div class="help-inline important">', '</div>');
	}

	public function index()
	{		
		$this->model_session->auth_page('user', 4);
		$this->model_session->log_activity('V', current_url());		
		$data['layout'] = $this->folder.'view';
		$this->load->view('body', $data);
	}
	
	public function json_data()
	{
		$this->model_session->auth_page('user', 4);
		$this->model_user->get_datatable_json();		
	}
	
	public function a()
	{
		$this->model_session->auth_page('user', 4);
		$this->model_session->log_activity('V', current_url());
		$this->load->model('model_role');
		$data['role'] = $this->model_role->get_json();
		$data['dept'] = $this->model_department->get_all();
		$data['layout'] = $this->folder.'a';
		$this->load->view('body', $data);
	}

  public function i()
	{ 	
		$this->model_session->auth_page('user', 4);
		$this->model_session->log_activity('A', current_url());
		$this->form_validation->set_rules('email', 'Username', 'required|is_unique[ar_user.userName]');
		$this->form_validation->set_rules('name', 'Nama Pengguna', 'required|min_length[3]');
		$this->form_validation->set_rules('pwd', 'Password', 'required|min_length[4]|alpha_numeric');
		$this->form_validation->set_rules('repwd', 'Password Konfirm', 'required|matches[pwd]');
		
		if($this->form_validation->run()==FALSE)
		{
			$this->a();
		}else{
			 $insertID = $this->model_user->insert();
			 $this->model_session->log_activity('A', current_url(), $_POST);
			 $this->session->set_flashdata('success', 'Data baru telah terentry, <a href="'.site_url('user/e/'.$insertID).'">Untuk detailnya klik disini</a>');
			 redirect(site_url('user/a'));
		}
	}

  public function e()
	{
		$this->model_session->auth_page('user', 4);
		
		$this->model_session->log_activity('V', current_url());
		$data['dept'] = $this->model_department->get_all();
		$records = $this->model_user->get_byID($this->dID);
		if(!$records){
			redirect(404);
		}
		$data['records'] = $records;
		$this->load->model('model_role');
		$data['role'] = $this->model_role->get_json();
		$data['layout'] = $this->folder.'e';
		$this->load->view('body', $data);		
	}

  public function u()
	{
		$this->model_session->auth_page('user', 4);
		$this->model_session->log_activity('E', current_url());	
		$this->form_validation->set_rules('id', 'Damned You', 'required|integer');
		$this->form_validation->set_rules('email', 'Username', 'required');
		$this->form_validation->set_rules('name', 'Nama Pengguna', 'required|min_length[3]');
		
		if($this->input->post('pwd')!='')
		{
			$this->form_validation->set_rules('pwd', 'Password', 'required|min_length[4]|alpha_numeric');
			$this->form_validation->set_rules('repwd', 'Password Konfirm', 'required|matches[pwd]');
		}
	
		if($this->form_validation->run()==FALSE)
		{
			$this->e($this->input->post('id'));
		}
		else
		{
			$this->model_session->log_activity('E', current_url(), $_POST);
			$this->model_user->update();
			$this->session->set_flashdata('success', 'Data telah diperbaharui');
			redirect(site_url('user'));	
		}
	}
	
  public function d()
	{	
		$this->model_session->auth_page('user', 4);
		
		$id = $this->uri->segment(3);
		$chek = $this->uri->segment(4);
		if(!$id)
		{
			redirect(404);
		}
		
		$this->model_session->log_activity('D', current_url());
		$return = $this->model_user->delete($id);
		if($return)
		{
			$this->session->set_flashdata('success', 'Data telah berhasil dihapus.');
		}
		redirect(site_url('user'));
	}
	
	// change password
	public function chgpwd()
	{
		$data['layout'] = $this->folder.'update_password';
		$this->load->view('body', $data);
	}
	
	public function u_pwd()
	{
		$this->form_validation->set_rules('pwd', 'Password Lama', 'required|callback_same_password');
		$this->form_validation->set_rules('newpwd', 'Password Baru', 'required|min_length[4]|alpha_numeric');
		$this->form_validation->set_rules('repwd', 'Password Konfirm', 'required|matches[newpwd]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$id = $this->session->userdata('uID');
			$records = $this->model_user->get_byid($id);
			if(!$records)
			{
				redirect(404);
			}
			$data['records'] = $records;
			$data['layout'] = $this->folder.'update_password';
			$this->load->view('body', $data); 
		}
		else
		{	
			$this->model_session->log_activity('UPWD', 'Memperbaharui Password.', $_POST);
			$this->model_user->u_pwd($this->session->userdata('uID'), $this->input->post('newpwd'));
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");	
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");	
			$this->session->sess_destroy();
			redirect(site_url('login')); 
		}
	}	
	
	// helper //
	/* ajax check username availability */
	public function check()
	{
		$this->form_validation->set_rules('n', 'n', 'required');
		
		if ($this->form_validation->run() == TRUE)
		{
			$post = $this->input->post('n');
			$type = $this->input->post('type');
			$id = $this->input->post('id');
			$data['records'] = $this->model_user->check_name($post, $type, $id);
			$this->load->view($this->folder.'check', $data);					
		}
		else
		{
			$data['records'] = TRUE;
			$this->load->view($this->vdir.'/check', $data);
		}
	}
	
	// check if same email existed */
	public function email_check($val)
	{
		$user = $this->model_user->check_name($val, 'email', $this->input->post('id'));
		if ($user == TRUE)
		{
			$this->form_validation->set_message('email_check', '%s sudah dipakai selain anda');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}	
	
	// check if same email existed */
	public function same_password($val)
	{
		$id = $this->session->userdata('uID');
		$user = $this->model_user->get_byid_json($id);
		$old_pwd = $user->userPwd;
		// echo "val=".$val;
		// echo "<pre>";
		// var_dump($user->userPwd);
		
		// exit;
		// if($old_pwd != md5($this->config->item('salt').$val))
		// {
			// $this->form_validation->set_message('same_password', '%s tidak sama dengan password sekarang.');
			// return FALSE;
		// }
		
		if (crypt($val,$old_pwd)!==$old_pwd) {
			$this->form_validation->set_message('same_password', '%s tidak sama dengan password sekarang.');
			return FALSE;
		}
	}		
	
}
/* End of file User.php */
/* Location: ./application/controllers/User.php */