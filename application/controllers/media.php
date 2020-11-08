<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends CI_Controller {
	
	var $folder = 'media/';
	var $setter;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('model_media');
    	$this->form_validation->set_error_delimiters('<div class="help-inline important">', '</div>');
		$this->setter = $this->model_sys->get_all_sys();
	}

	function index() 
	{
		$this->model_session->check_login(NULL, 'login');
		redirect(404);
	} // index
	
	
	public function barcode_form()
	{
		$berdasarkan = $this->input->post('berdasarkan');
		$type = $this->uri->segment(3);
		$masa1 = reverse_date($this->input->post('keyword_masa1'));
		$masa2 = reverse_date($this->input->post('keyword_masa2'));
		$tgl1 = reverse_date_time($this->input->post('keyword_tgl1'));
		$tgl2 = reverse_date_time($this->input->post('keyword_tgl2'),'23:59:59');
		$kode1 = $this->input->post('keyword_kode1');
		$kode2 = $this->input->post('keyword_kode2');
		
		if($type != 'pengesahan' && $type != 'sertifikat')
		{
			$this->session->set_flashdata('error', "Data dokumen tidak dikenal oleh sistem.");
			$data['records'] = FALSE;
		}
		else
		{
			
		}
				
		switch($berdasarkan)
		{			
			case "masa_berlaku":
							
				if($masa1 && $masa2) 
				{
					$this->db->where('masa_berlaku >= ', $masa1);
					$this->db->where('masa_berlaku <= ', $masa2);
					$data['records'] =($type == 'sertifikat') ? $this->db->get(DBSERTIFIKAT) : $this->db->get(DBPENGESAHAN);
				}
				else
				{
					$this->session->set_flashdata('error', "Data dokumen tidak dikenal oleh sistem.");
					$data['records'] = FALSE;					
				}
				break;
			case "tanggal_entri":
				if($tgl1 && $tgl2) {
					$this->db->where('cdt >= ', $tgl1);
					$this->db->where('cdt <= ', $tgl2);
					$data['records'] =($type == 'sertifikat') ? $this->db->get(DBSERTIFIKAT) : $this->db->get(DBPENGESAHAN);
				}
				else
				{
					$this->session->set_flashdata('error', "Data dokumen tidak dikenal oleh sistem.");
					$data['records'] = FALSE;					
				}
				break;
			default;				
				if($kode1 && $kode2) {
					$this->db->where('code >= ', $kode1);
					$this->db->where('code <= ', $kode2);
					$data['records'] =($type == 'sertifikat') ? $this->db->get(DBSERTIFIKAT) : $this->db->get(DBPENGESAHAN);
				}
				else
				{
					$this->session->set_flashdata('error', "Data dokumen tidak dikenal oleh sistem.");
					$data['records'] = FALSE;					
				}
				break;
		}	
			
		
		if(!$data['records']) 
		{
			$data['records'] = FALSE;
		} 
		else 
		{
			$data['records'] = $data['records']->result();
		}	
		$data['layout'] = $this->folder.'barcode_form';
		$this->load->view('body', $data);	
	}
	
	
	/*public function barcode_form()
	{
		$this->model_session->check_login(NULL, 'login');
		
		$keyword1 = $this->input->post('keyword1');
		$keyword2 = $this->input->post('keyword2');
		$berdasarkan = $this->input->post('berdasarkan');
		$type = $this->uri->segment(3);
		
		switch($berdasarkan)
		{
			case "masa_berlaku":
				if($keyword1 && !$keyword2) {
					$this->db->where($berdasarkan, $keyword1);
				}
				if($keyword1 && $keyword2) {
					$this->db->where('masa_berlaku >= ', $keyword1);
					$this->db->where('masa_berlaku <= ', $keyword2);
				}
				break;
			case "tanggal_entri":
				$berdasarkan = 'cdt';
				if($keyword1 && !$keyword2) {
					$this->db->where($berdasarkan, $keyword1);
				}
				if($keyword1 && $keyword2) {
					$this->db->where('cdt >= ', $keyword1);
					$this->db->where('cdt <= ', $keyword2);
				}
				break;
			default;
				$berdasarkan = 'code';
				if($keyword1 && !$keyword2) {
					$this->db->where('code', $keyword1);
				}
					
				if($keyword1 && $keyword2) {
					$this->db->where('code >= ', $keyword1);
					$this->db->or_where('code <= ', $keyword2);
				}
				break;
		}
		
		
		if($type == 'sertifikat') {
			$data['records'] = $this->db->get(DBSERTIFIKAT);
			
		} else if($type == 'pengesahan') {
			$data['records'] = $this->db->get(DBPENGESAHAN);
			
		} else {
			$this->session->set_flashdata('error', "Data dokumen tidak dikenal oleh sistem.");
			$data['records'] = FALSE;
		}
		
		if(!$data['records']) {
			$data['records'] = FALSE;
		} else {
			$data['records'] = $data['records']->result();
		}
			
		$data['layout'] = $this->folder.'barcode_form';
		$this->load->view('body', $data);
	}*/
	
	public function barcode_multi()
	{
		$this->model_session->check_login(NULL, 'login');
		$data['sys'] = $this->setter;
		
		$type = $this->uri->segment(3);
		
		if($type == 'sertifikat') {
			$this->load->model('model_sertifikat');
			$data['records'] = $this->model_sertifikat->get_all_by_id($_POST);
			
		} else if($type == 'pengesahan') {
			$this->load->model('model_pengesahan');
			$data['records'] = $this->model_pengesahan->get_all_by_id($_POST);
			
		} else {
			$this->session->set_flashdata('error', "Mohon periksa kembali barcode yang ingin dicetak.");
			redirect(404);
		}
		
		$this->load->view($this->folder.'barcode_multi', $data);		
	}
	
	public function barcode_single()
	{
		$this->model_session->check_login(NULL, 'login');
		
		$data['url'] = $this->uri->segment(3);
		$type = $this->uri->segment(4);
		
		if($type == 'single') {
			$this->load->model('model_sertifikat');
			$data['records'] = $this->model_sertifikat->get_by_code($data['url']);
			
		} else {
			$this->session->set_flashdata('error', "Data dokumen tidak dikenal oleh sistem.");
			redirect(404);
		}
		
		if(!$data['records'])
		{
			$this->session->set_flashdata('error', "Data dokumen tidak dikenal oleh sistem.");
			redirect(404);		
		}
		
		$data['sys'] = $this->setter;
		$this->load->view($this->folder.'barcode_single', $data);
	}
	
	public function get_file()
	{
		$this->model_session->check_login(NULL, 'login');
		
		$id = $this->input->get('fid');

		if(!$id){
			redirect(404);
		}
		
		$uri[2] = $this->uri->segment(4);
		if($uri[2] == 'sertifikat') {
			$upload_path = ARCHIVEDIR_SERTIFIKAT;
		} else if($uri[2] == 'pengesahan') {
			$upload_path = ARCHIVEDIR_PENGESAHAN;
		} else {
			$this->session->set_flashdata('error', "Media penyimpanan data tidak dikenal oleh sistem.");
			redirect(site_url());	
		}
		
		$records = $this->model_media->get_atc($id, $upload_path);
		
		if(!$records)
		{
			redirect(404);			
		}
		
		$file = realpath($upload_path.$records->atc_rawname.$records->atc_ext);
		
		if($file) 
		{
			$this->load->helper('download');
			$filename = $file;
			$file = fopen($filename, "rb");
			$contents = fread($file, filesize($filename));
			fclose($file);
			$data['img'] = $contents;
			$this->load->view($this->folder.'file_getter', $data);
		}
		else
		{
			exit();	
		}
		
	}
	
	public function viewer()
	{
		$this->model_session->check_login(NULL, 'login');
		
		$id = $this->uri->segment(3);

		if(!$id){
			redirect(404);
		}
		
		$tipe = $this->uri->segment(4);
		if($tipe == 'data_view') {
			$data['upload_path'] = DATA_VIEW;
			$table = 'atc_nasabah';
			
		} else {
			$this->session->set_flashdata('error', "Media penyimpanan data tidak dikenal oleh sistem.");
			redirect(site_url());	
		}
		
		$records = $this->model_media->get_atc($id, $table);
		if(! $records ) {
			redirect(404);
		}	
		//p_code($records);exit;
		//$this->model_media->update_counter($id, 'view', $table);
		$data['records'] = $records;		
		$this->load->view($this->folder.'viewer2', $data);
	}
	
	public function viewer2()
	{
		$this->model_session->check_login(NULL, 'login');
		
		$id = $this->uri->segment(3);

		if(!$id){
			redirect(404);
		}
		
		$tipe = $this->uri->segment(4);
		
		if($tipe == 'data_view') {
			$data['upload_path'] = DATA_VIEW;
			$table = 'atc_nasabah';
			
		} else {
			$this->session->set_flashdata('error', "Media penyimpanan data tidak dikenal oleh sistem.");
			redirect(site_url());	
		}
		
		$data['uri'] = $tipe;
		
		$data['records'] = $this->model_media->get_atc($id, $table);
		/* if(! $data['records'] ) {
			redirect(404);
		} */
		//p_code($data['records']);exit;
		//$this->model_media->update_counter($id, 'view', $table);
		
		$data['atc'] = $this->model_media->get_attachment($this->uri->segment(5));
		$this->load->view($this->folder.'viewer2', $data);
	}
	
	public function single_viewer()
	{
		$this->model_session->check_login(NULL, 'login');
		
		$id = $this->uri->segment(3);

		if(!$id){
			redirect(404);
		}
		
		$tipe = $this->uri->segment(4);
		if($tipe == 'sertifikat') {
			$data['upload_path'] = ARCHIVEDIR_SERTIFIKAT;
			$table = DBATC_SERTIFIKAT;
			
		} else if($tipe == 'pengesahan') {
			$data['upload_path'] = ARCHIVEDIR_PENGESAHAN;
			$table = DBATC_PENGESAHAN;
			
		} else {
			$this->session->set_flashdata('error', "Media penyimpanan data tidak dikenal oleh sistem.");
			redirect(site_url());	
		}
		
		$data['uri'] = $tipe;
		
		$data['records'] = $this->model_media->get_atc($id, $table);
		if(! $data['records'] ) {
			redirect(404);
		}	
		
		$this->model_media->update_counter($id, 'view', $table);
			
		$this->load->view($this->folder.'single_view', $data);
	}
	
	// view counter
	public function vpcnt()
	{
		$this->model_session->check_login(NULL, 'login');
		
		// CSRF	
		$CI =& get_instance();
		$csrf_post = $this->config->item('csrf_token_name');
		$csrf_cookie = $this->config->item('csrf_cookie_name');
		if (isset($_COOKIE[$csrf_cookie]) && $_COOKIE[$csrf_cookie] != $this->input->get($csrf_post)) { header("Location: ../");exit;}
		// END CSRF		
		
		$id = $this->input->post('s');
		$tipe = $this->input->post('t');
		
		if($tipe == 'sertifikat') {
			$table = DBATC_SERTIFIKAT;
			
		} else if($tipe == 'pengesahan') {
			$table = DBATC_PENGESAHAN;
			
		} else {
			return;
		}
		
		$this->model_media->update_counter($id, 'view', $table);
	}
	
	// print counter
	public function upcnt()
	{
		$this->model_session->check_login(NULL, 'login');
		
		// CSRF	
		$CI =& get_instance();
		$csrf_post = $this->config->item('csrf_token_name');
		$csrf_cookie = $this->config->item('csrf_cookie_name');
		if (isset($_COOKIE[$csrf_cookie]) && $_COOKIE[$csrf_cookie] != $this->input->get($csrf_post)) { header("Location: ../");exit;}
		// END CSRF		
		
		$id = $this->input->post('s');
		$tipe = $this->input->post('t');
		
		if($tipe == 'sertifikat') {
			$table = DBATC_SERTIFIKAT;
			
		} else if($tipe == 'pengesahan') {
			$table = DBATC_PENGESAHAN;
			
		} else {
			return;
		}
		
		$this->model_media->update_counter($id, 'print', $table);	
	}

	// download counter
	public function dpcnt()
	{
		$this->model_session->check_login(NULL, 'login');
		
		// CSRF	
		$CI =& get_instance();
		$csrf_post = $this->config->item('csrf_token_name');
		$csrf_cookie = $this->config->item('csrf_cookie_name');
		if (isset($_COOKIE[$csrf_cookie]) && $_COOKIE[$csrf_cookie] != $this->input->get($csrf_post)) { header("Location: ../");exit;}
		// END CSRF
		$id = $this->input->get('s');
		
		$uri = $this->input->get('type');
		
		if($uri == 'sertifikat') {
			$data['upload_path'] = ARCHIVEDIR_SERTIFIKAT;
			$table = DBATC_SERTIFIKAT;
		} else if($uri == 'pengesahan') {
			$data['upload_path'] = ARCHIVEDIR_PENGESAHAN;
			$table = DBATC_PENGESAHAN;
		} else {
			$this->session->set_flashdata('error', "Media penyimpanan data tidak dikenal oleh sistem.");
			redirect(site_url());	
		}
		
		$file = $this->model_media->get_atc($id, $table);
		if(!$file)
		{
			redirect(404);			
		}
		
		$this->model_media->update_counter($id, 'download', $table);
		
		$dir = realpath($file->atc_path.$file->atc_rawname.$file->atc_ext);
		if($file && $dir)
		{
			$this->load->helper('download');			
			$filedata = file_get_contents($dir);
			$filename = $file->atc_filename;
			force_download($filename, $filedata);
		}		
		return;	
	}
	
	// delete file attachment
	public function datc()
	{
		$this->model_session->check_login(NULL, 'login');
		
		// CSRF	
		$CI =& get_instance();
		$csrf_post = $this->config->item('csrf_token_name');
		$csrf_cookie = $this->config->item('csrf_cookie_name');
		if (isset($_COOKIE[$csrf_cookie]) && $_COOKIE[$csrf_cookie] != $this->input->get($csrf_post)) { header("Location: ../");exit;}
		// END CSRF
		$atcID = $this->uri->segment(3);
		if(! $atcID) 
		{ 
			exit(); 
		}
		
		$uri[2] = $this->uri->segment(4);
		if($uri[2] == 'sertifikat') {
			$data['upload_path'] = ARCHIVEDIR_SERTIFIKAT;
			$table = DBATC_SERTIFIKAT;
		} else if($uri[2] == 'pengesahan') {
			$data['upload_path'] = ARCHIVEDIR_PENGESAHAN;
			$table = DBATC_PENGESAHAN;
		} else {
			$this->session->set_flashdata('error', "Media penyimpanan data tidak dikenal oleh sistem.");
			redirect(site_url());	
		}
		
		$file = $this->model_media->get_atc($atcID, $table);
		if(!$file)
		{
			redirect(404);			
		}
		
		$this->model_media->datc($atcID, $table);
		unlink($file->atc_path.$file->atc_rawname.$file->atc_ext);
		redirect($this->input->get('url'));		
	}	

	public function s()
	{
		$this->model_session->check_login(NULL, 'login');
		
		$error = '';
		
		$uriArray = base64url_decode($this->uri->segment(3));
		
		if(!$uriArray)
		{
			redirect(404);
		}
		
		$uri = explode('sdt', $uriArray);
		$id = $uri[0];
		$dateArray = explode('-', $uri[1]);
		$year = $dateArray[0];
		$month = $dateArray[1];
		$tipe = $this->uri->segment(4);

		if($tipe == 'sertifikat') {
			$upload_path = ARCHIVEDIR_SERTIFIKAT;
		} else if($tipe == 'pengesahan') {
			$upload_path = ARCHIVEDIR_PENGESAHAN;
		} else {
			$this->session->set_flashdata('error', "Media penyimpanan data tidak dikenal oleh sistem.");
			redirect(site_url());	
		}
				
		// MAIN DIR
		if(! realpath($upload_path)) {
			mkdir($upload_path);
			$data = '<?php header("Location: ../"); exit();?>';
			write_file($upload_path.'index.php', $data);
		}
		
		// YEAR DIR
		if(! realpath($upload_path.$year)) {
			mkdir($upload_path.$year);
			$data = '<?php header("Location: ../"); exit();?>';
			write_file($upload_path.$year.'/index.php', $data);
		}
		
		// check month dir
		if(! realpath($upload_path.$year.'/'.$month)) {
			mkdir($upload_path.$year.'/'.$month);
			$data = '<?php header("Location: ../"); exit();?>';
			write_file($upload_path.$year.'/'.$month.'/index.php', $data);
		}
		
		$this->load->view($this->folder.'scan_form');
	}
	
	public function s_p()
	{
		//exec("convert /srv/www/htdocs/mmbindex_dephub/e84bff36f65a860d4f01e18f6e293bda/2013/07/fe5a7b48be424d6087c7891744a4470f.tif /srv/www/htdocs/mmbindex_dephub/e84bff36f65a860d4f01e18f6e293bda/2013/07/fe5a7b48be424d6087c7891744a4470f.pdf");
		
		//$this->model_session->check_login(NULL, 'login');
		$sys = $this->setter;
		
		$uriArray = base64url_decode($this->uri->segment(3));
		
		if(!$uriArray) {
			exit();
		}
		
		$uri = explode('sdt', $uriArray);
		$id = $uri[0];

		$dateArray = explode('-', $uri[1]);
		$date = $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0];
		$year = $dateArray[0];
		$month = $dateArray[1];
		$tipe = $this->uri->segment(4);
		
		if($tipe == 'sertifikat') {
			$upload_path = ARCHIVEDIR_SERTIFIKAT;
			$table = DBATC_SERTIFIKAT;
		} else if($tipe == 'pengesahan') {
			$upload_path = ARCHIVEDIR_PENGESAHAN;
			$table = DBATC_PENGESAHAN;
		} else {
			$this->session->set_flashdata('error', "Media penyimpanan data tidak dikenal oleh sistem.");
			exit();
		}
		
		$fileTempName = $_FILES['RemoteFile']['tmp_name'];	
		$fileSize = $_FILES['RemoteFile']['size'];
		$fileName = trim($_FILES['RemoteFile']['name']);
		$fileExt = substr($fileName, -4, 4);
		
		$nameArray = explode('-x-', $fileName);
		
		$fileName = $nameArray[1];
		$fileDesc = $nameArray[0];
		
		if($nameArray[0] == $nameArray[1])
		{
			$fileDesc = NULL;	
		}

		$dir = $upload_path.$year.'/'.$month.'/';
		$newFileName = md5(uniqid(mt_rand()));
		
		// if the file existed
		if( file_exists($dir.$newFileName.$fileExt) )
		{
			$newFileName = md5($newFileName);
		}
		
		if( move_uploaded_file($fileTempName, $dir.$newFileName.$fileExt ) )
		{
			$this->model_media->scan_attachment($id, $fileName, $newFileName, $fileExt, substr($fileSize, 0, strlen($fileSize)-3), $dir, $fileDesc, $table);
			
			$orig_file = $dir.$newFileName.$fileExt;
			$result_file = $dir.$newFileName;
			$copy_file = UPLOADDIR.$newFileName;
			$watermark_file = './assets/img/watermark.gif';

			if($sys['OCR'] == 'ON')
			{
				@exec("convert $orig_file $result_file.pdf"); // pdf
				@exec("composite -dissolve 10 -tile -quality 100 $watermark_file $orig_file $copy_file.pdf"); // pdf
				@exec("tesseract $orig_file $result_file");
			}			
		}

	}

	public function s_v()
	{
		$this->model_session->check_login(NULL, 'login');
		
		$uriArray = base64url_decode($this->uri->segment(3));
		if(!$uriArray)
		{
			exit();
		}
		
		$uri = explode('sdt', $uriArray);
		$id = $uri[0];
		$tipe = $this->uri->segment(4);
		
		if($tipe == 'sertifikat') {
			$data['upload_path'] = 'sertifikat';
			$table = DBATC_SERTIFIKAT;
		} else if($tipe == 'pengesahan') {
			$data['upload_path'] = 'pengesahan';
			$table = DBATC_PENGESAHAN;
		} else {
			$this->session->set_flashdata('error', "Media penyimpanan data tidak dikenal oleh sistem.");
			redirect(site_url());	
		}		
		
		$data['atc'] = $this->model_media->get_attachment($id, $table);
		$this->load->view($this->folder.'scan_result', $data);
	}
	
}
/* End of file Media.php */
/* Location: ./application/controllers/Media.php */