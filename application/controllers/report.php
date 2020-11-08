<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

  var $folder = 'report/';
	var $dID;

  function __construct()
	{
		parent::__construct();
		$this->dID = $this->uri->segment(3);
		$this->load->model('model_report');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="help-inline important">', '</div>');
	}

	public function index()
	{
		$this->model_session->auth_page('report', 2);
		$this->model_session->log_activity('V', current_url());
		$data['category'] = $this->db->get('ar_category')->result();
		$data['fields_doc'] = $this->config->item('doc_field');
		$data['layout'] = $this->folder.'view';
		$this->load->view('body', $data);
	}
	
	public function u()
	{
		$data['fields'] = $this->config->item('doc_field');
		$this->form_validation->set_rules('bdate', 'Tahun mulai', 'required');
		$this->form_validation->set_rules('edate', 'Tahun akhir', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->index();
		}else{
			$data['fields_doc'] = $this->config->item('doc_field');
			$data['fields_checked'] = $this->input->post('fields_doc');
			$data['records'] = $this->model_report->search();
			$data['layout'] = $this->folder.'result';
			$this->load->view('body', $data);
		}		
	}
	
	public function print_report() {
        $filename = "report_";
        $data['content_'] = $this->input->post('content_');

        if (!$data['content_']) {
            redirect(site_url('report/'));
        }

        $filename .= '.xls';

        $this->load->view('report/report_wrapper', $data);
    }
	
    public function xls_p() {
        $filename = "report_" . date("Y-m-d") . "_" . date("h_i_s") . "_";
        $data['content_'] = $this->input->post('content_');

        if (!$data['content_']) {
            redirect(site_url('report/'));
        }

        $filename .= '.xls';
		ob_start();
        // $this->load->view('report/report_wrapper', $data);
        // header('Content-type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment; filename="' . $filename . '"');
		
		
		ob_get_clean();

		header( "Content-Type: application/vnd.ms-excel" );
		header( 'Content-disposition: attachment; filename="' . $filename . '"');
		$this->load->view('report/report_wrapper', $data);
    }
	
	public function xls_s() {
        $filename = "laporan_sertifikat_garis_muat" . date("Y-m-d") . "_" . date("h_i_s") . "_";
        $data['content_'] = $this->input->post('content_');

        if (!$data['content_']) {
            redirect(site_url('report/'));
        }

        $filename .= '.xls';

        $this->load->view('report/report_wrapper', $data);
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    }
	
}
/* End of file Report.php */
/* Location: ./application/controllers/Report.php */ ?>