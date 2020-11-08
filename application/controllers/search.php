<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

  var $folder = 'Search/';
	var $dID;

	function __construct()
	{
		parent::__construct();
		$this->dID = $this->uri->segment(3);
		$this->load->model('model_doc');
		$this->form_validation->set_error_delimiters('<div class="help-inline important">', '</div>');
	}
	
	public function file()
	{
		if(! empty($_POST)){
			$data['search'] = $this->model_doc->search_file();
		}else{
			$data['search'] = 0;
		}
		$this->model_session->auth_page('document', 2);
		$this->model_session->log_activity('Search', current_url());
		$data['layout'] = $this->folder.'search';
		$this->load->view('body', $data);
	}
}
/* End of file User.php */
/* Location: ./application/controllers/User.php */