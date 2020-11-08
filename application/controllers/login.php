<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('model_session');
		$this->model_session->check_login('dashboard', NULL);
		$this->form_validation->set_error_delimiters('<div class="warning">', '</div>');
		$this->load->dbutil();
	}

	public function index()
	{
		$data['system_state'] = $this->model_sys->get_system_state();
		$this->load->view( 'login', $data );
	}
	
	public function validate()
	{// echo "hai val";exit;
		$this->form_validation->set_rules('usr', 'Email', 'required');
		$this->form_validation->set_rules('pwd', 'Password', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->index();
		}
		else
		{//echo "else if nih";exit;
			$usr = $this->input->post('usr');
			$pwd = $this->input->post('pwd');
			
			if( $this->model_session->validateLogin($usr, $pwd) == FALSE) 
			{
				$this->index();
			} 
			else 
			{
				$this->model_session->log_activity('LOGIN', 'LOGIN KE SISTEM');	
				redirect(site_url('doc'));
			}
		}
		
	}
	
	public function logout() {echo "andy";exit;
        $this->session->unset_userdata('login');
        $this->session->sess_destroy();
        redirect('dashboard');
    }	
	
}
/* End of file login.php */
/* Location: ./application/controllers/login.php */
