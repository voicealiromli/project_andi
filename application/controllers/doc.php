<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doc extends CI_Controller {

  var $folder = 'doc/';
	var $dID;

	function __construct()
	{
		parent::__construct();
		$this->dID = $this->uri->segment(3);		
		$this->load->model('model_doc');
		$this->load->model('model_category');
		$this->load->model('model_department');
		$this->form_validation->set_error_delimiters('<div class="help-inline important">', '</div>');
	}

	public function index()
	{
		$this->load->library('pagination');
		$this->model_session->auth_page('document', 1);
		$this->model_session->log_activity('V', current_url());
		
		$sort_by = ($this->uri->segment(4)) ? $this->uri->segment(3) : 'idn';
		$config['base_url'] = base_url('doc/index').'/'.$sort_by;
		$config['total_rows'] = $this->db->get('nasabah')->num_rows();
		$config['uri_segment'] = 4;
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['next_link'] = 'Next &raquo;';
		$config['prev_link'] = '&laquo; Prev';
		$this->pagination->initialize($config);
	
		$this->db->order_by($sort_by, 'desc');
		$this->db->limit($config['per_page'], $this->uri->segment(4));
		//$this->db->order_by('idn','desc');
		$data['doc'] = $this->db->get('nasabah')->result();
		
		$data['all'] = $this->db->get('nasabah')->num_rows();
		
		$data['layout'] = $this->folder.'view';
		$this->load->view('body', $data);
	}
	
	public function box()
	{
		$this->load->library('pagination');
		$this->model_session->auth_page('document', 1);
		$this->model_session->log_activity('V', current_url());
		
		$sort_by = ($this->uri->segment(4)) ? $this->uri->segment(3) : 'idn';
		$config['base_url'] = base_url('doc/box').'/'.$sort_by;
		$config['total_rows'] = $this->db->get('nasabah')->num_rows();
		$config['uri_segment'] = 4;
		$config['per_page'] = 10;
		$config['num_links'] = 3;
		$config['next_link'] = 'Next &raquo;';
		$config['prev_link'] = '&laquo; Prev';
		$this->pagination->initialize($config);
	
		$this->db->order_by($sort_by, 'desc');
		$this->db->limit($config['per_page'], $this->uri->segment(4));
		//$this->db->order_by('idn','desc');
		$this->db->group_by('box');
		$data['doc'] = $this->db->get('nasabah')->result();
		
		$this->db->group_by('box');
		$data['all'] = $this->db->get('nasabah')->num_rows();
		
		$data['layout'] = $this->folder.'view_box';
		$this->load->view('body', $data);
	}
	
	public function datasearch()
	{
		$this->load->library('pagination');
		$this->model_session->auth_page('document', 1);
		$this->model_session->log_activity('V', current_url());
		$datasearch = $this->input->post('search');

		$search = ($this->input->post("search"))? $this->input->post("search") : "page";
        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
		
		$this->db->like('no', $search);
		$this->db->or_like('klien', $search); 
		$this->db->or_like('ctr', $search); 
		$this->db->or_like('box', $search); 
		$this->db->or_like('laci', $search); 
		$this->db->or_like('cby', $search); 
		$this->db->or_like('cyear', $search);
		$datacell = $this->db->get('nasabah')->num_rows();
		
		//$sort_by = ($this->uri->segment(5)) ? $this->uri->segment(4) : 'page';
		//$config['base_url'] = base_url('doc/datasearch').'/'.$pses.'/'.$sort_by;
		$config['base_url'] = base_url('doc/datasearch').'/'.$search;
		$config['total_rows'] = $datacell;
		$config['uri_segment'] = 4;
		$config['per_page'] = 25;
		$config['num_links'] = 3;
		$config['next_link'] = 'Next &raquo;';
		$config['prev_link'] = '&laquo; Prev';
		$this->pagination->initialize($config);
	
		$this->db->order_by('idn', 'desc');
		$this->db->limit($config['per_page'], $this->uri->segment(4));
		
		$this->db->like('no', $search);
		$this->db->or_like('klien', $search); 
		$this->db->or_like('ctr', $search); 
		$this->db->or_like('box', $search); 
		$this->db->or_like('laci', $search); 
		$this->db->or_like('cby', $search); 
		$this->db->or_like('cyear', $search);
		$data['doc'] = $this->db->get('nasabah')->result();
		
		$this->db->like('no', $search);
		$this->db->or_like('klien', $search); 
		$this->db->or_like('ctr', $search); 
		$this->db->or_like('box', $search); 
		$this->db->or_like('laci', $search); 
		$this->db->or_like('cby', $search); 
		$this->db->or_like('cyear', $search);
		$data['all'] = $this->db->get('nasabah')->num_rows();
		
		$data['layout'] = $this->folder.'view';
		$this->load->view('body', $data);
	}
	
	public function datasearch_box()
	{
		$this->load->library('pagination');
		$this->model_session->auth_page('document', 1);
		$this->model_session->log_activity('V', current_url());
		$datasearch = $this->input->post('search');

		$search = ($this->input->post("search"))? $this->input->post("search") : "page";
        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
		
		$this->db->like('no', $search);
		$this->db->or_like('klien', $search); 
		$this->db->or_like('ctr', $search); 
		$this->db->or_like('box', $search); 
		$this->db->or_like('laci', $search); 
		$this->db->or_like('cby', $search); 
		$this->db->or_like('cyear', $search);
		$this->db->group_by('box');
		$this->db->group_by('box');
		$datacell = $this->db->get('nasabah')->num_rows();
		
		//$sort_by = ($this->uri->segment(5)) ? $this->uri->segment(4) : 'page';
		//$config['base_url'] = base_url('doc/datasearch').'/'.$pses.'/'.$sort_by;
		$config['base_url'] = base_url('doc/datasearch_box').'/'.$search;
		$config['total_rows'] = $datacell;
		$config['uri_segment'] = 4;
		$config['per_page'] = 25;
		$config['num_links'] = 3;
		$config['next_link'] = 'Next &raquo;';
		$config['prev_link'] = '&laquo; Prev';
		$this->pagination->initialize($config);
	
		$this->db->order_by('idn', 'desc');
		$this->db->limit($config['per_page'], $this->uri->segment(4));
		
		$this->db->like('no', $search);
		$this->db->or_like('klien', $search); 
		$this->db->or_like('ctr', $search); 
		$this->db->or_like('box', $search); 
		$this->db->or_like('laci', $search); 
		$this->db->or_like('cby', $search); 
		$this->db->or_like('cyear', $search);
		$this->db->group_by('box');
		$data['doc'] = $this->db->get('nasabah')->result();
		
		$this->db->like('no', $search);
		$this->db->or_like('klien', $search); 
		$this->db->or_like('ctr', $search); 
		$this->db->or_like('box', $search); 
		$this->db->or_like('laci', $search); 
		$this->db->or_like('cby', $search); 
		$this->db->or_like('cyear', $search);
		$this->db->group_by('box');
		$data['all'] = $this->db->get('nasabah')->num_rows();
		
		$data['layout'] = $this->folder.'view_box';
		$this->load->view('body', $data);
	}
	
	public function filter()
	{
		$data['cat'] = $this->model_category->get_all();
		$this->model_session->auth_page('document', 1);
		$this->model_session->log_activity('V', current_url());		
		$data['layout'] = $this->folder.'view_filter';
		$this->load->view('body', $data);
	}
	
	public function p()
	{
		$this->db->where('idn',$this->uri->segment(3));
		$data['doc'] = $this->db->get('nasabah')->row();		
		$data['layout'] = $this->folder;
		$this->load->view('p', $data);
	}
	
	public function p_box()
	{
		$this->db->where('idn',$this->uri->segment(3));
		$data['doc'] = $this->db->get('nasabah')->row();		
		$data['layout'] = $this->folder;
		$this->load->view('p_box', $data);
	}
	
	public function json_data()
	{
		$this->model_session->auth_page('document', 1);
		if($this->session->userdata('uAdmin')==0 || $this->session->userdata('uAdmin') == " ")
		{
			$this->model_doc->get_datatable_json();		
		}else{
			$this->model_doc->get_datatable_json_superAdmin();				
		}
	}
	
	public function json_data_filter()
	{
		$this->model_session->auth_page('document', 1);
		$id = $this->uri->segment(3);
		$this->model_doc->get_datatable_json_filter($id);				
		
	}
	
	public function a()
	{
		$data['dept'] = $this->model_department->get_all();
		$data['cat'] = $this->model_category->get_all();
		$this->model_session->auth_page('document', 2);
		$this->model_session->log_activity('V', current_url());
		$data['layout'] = $this->folder.'a';
		$this->load->view('body', $data);
	}

  public function i()
	{
		$this->model_session->auth_page('document', 2);
		$this->model_session->log_activity('A', current_url());
		$this->form_validation->set_rules('no', 'Nomor Polis', 'required');
		$this->form_validation->set_rules('name', 'Nama Nasabah', 'required');
	
		if($this->form_validation->run()==FALSE)
		{
			$this->a();
		}else{
			$this->model_session->log_activity('A', current_url(), $_POST);
			$nopol = $this->input->post('no');
			$insertID = $this->model_doc->insert();
			$this->session->set_flashdata('success', 'Data baru telah terentry, <a href="'.site_url('doc/dk/'.$insertID.'/'.$nopol).'">Untuk detailnya klik disini</a>');
			redirect(site_url('doc/a'));		
		}
	}
	
	public function dk($id)
	{
		$this->model_session->auth_page('document', 1);
		$this->model_session->log_activity('V', current_url());
		$this->db->where('idn', $id);
		$data['records'] = $this->db->get('nasabah')->row();
		/* if(!$data['records']){
			redirect(404);
		} */
		$this->db->where('np', $id);
		$data['file'] =  $this->db->get('atc_nasabah')->result();
		$data['layout'] = $this->folder.'e';
		$this->load->view('body', $data);		
	}

  public function e()
	{
		// $data['box'] = $this->model_box->get_box();
		// $data['all'] = $this->model_box->get_all();		
		// $data['room'] = $this->model_box->get_all_room();
		// $data['floor'] = $this->model_box->get_all_floor();
		// $data['rack'] = $this->model_box->get_all_rack();
		// $data['row'] = $this->model_box->get_all_row();
		// $data['col'] = $this->model_box->get_all_col();
		//$data['user'] = $this->model_doc->get_all_user($this->dID);
	
		
		$data['dept'] = $this->model_department->get_all();
		$data['cat'] = $this->model_category->get_all();
		$this->model_session->auth_page('document', 3);
		$this->model_session->log_activity('V', current_url());
		$data['records'] = $this->model_doc->get_byID($this->dID);
		if(!$data['records']){
			redirect(404);
		}
		$this->load->model('model_atc');
		$data['file'] = $this->model_atc->get_bySID($this->dID);
		$this->model_doc->vcnt($this->dID);
		$data['layout'] = $this->folder.'e';
		$this->load->view('body', $data);		
	}
	
  public function u()
	{
		$this->model_session->auth_page('document', 3);
		$this->model_session->log_activity('E', current_url());
		$this->form_validation->set_rules('no', 'Nomor Polis', 'required');
		$this->form_validation->set_rules('name', 'Nama Nasabah', 'required');
	
		if($this->form_validation->run()==FALSE)
		{
			$this->e($this->dID);
		}else{
			$this->model_session->log_activity('E', current_url(), $_POST);
			$this->model_doc->update();
			$this->session->set_flashdata('success', 'Data telah diperbaharui.');
			redirect(site_url('doc/dk/'.$this->input->post('id').'/'.$this->input->post('no')));	
		}
	}
	
	public function c()
	{
		$id = $this->uri->segment(3);
		$uri = $this->uri->segment(4);
		$this->model_session->auth_page('document', 3);
		$this->model_session->log_activity('E', current_url(), $_POST);
		$this->model_doc->c($id,$uri);
		$this->session->set_flashdata('success', 'Data telah diperbaharui.');
		redirect(site_url('doc'));	
		}
	
	public function d()
	{	
		$this->model_session->auth_page('document', 4);
		$id = $this->dID;
		$uri = $this->uri->segment(4);
		if(!$id)
		{
			redirect(404);
		}
		
		$return = $this->model_doc->delete($this->dID);
		if($return)
		{
			$this->model_session->log_activity('D', current_url());
			$this->session->set_flashdata('success', 'Data telah berhasil dihapus.');
		}
		redirect(site_url('doc'));
	}
	
	public function upload()
	{
		$this->model_session->auth_page('document', 3);
		$this->load->model('model_atc');
		$nopol = $this->input->post('id');
		$upload = $this->model_atc->upload($nopol);
		if($upload==TRUE)
		{
			$this->model_session->log_activity('Upload File', current_url(), $_FILES);
			$this->session->set_flashdata('success', 'File berhasil terupload.');
			redirect(site_url('doc/dk/'.$nopol));
		}else{
			$this->session->set_flashdata('error', 'File gagal diupload.');
			redirect(site_url('doc/dk/'.$nopol));
		}
	}
	
	public function download()
	{
		$this->model_session->auth_page('document', 4);
		$this->model_session->log_activity('Download file', current_url());
		$this->load->model('model_atc');
		$atc = $this->model_atc->get_file($this->uri->segment(3), $this->uri->segment(4));
		return TRUE;
		//redirect(site_url('doc/e/'.$this->uri->segment(4)));
	}
	
	public function deletefile()
	{
		$this->model_session->auth_page('document', 4);
		$this->model_session->log_activity('Delete file', current_url());
		$this->load->model('model_atc');
		$idn = $this->uri->segment(5);
		$this->model_atc->deletefile($this->dID, $this->uri->segment(4));
		redirect(site_url('doc/dk/'.$idn.'/'.$this->uri->segment(4)));
	}
	
	
	/*public function search_content()
	{
		$data['layout'] = $this->folder.'search_content_form';
		$this->load->view('body', $data);	
	}
	
	public function search_content_post()
	{		
		$keyword = strip_tags(strtolower($this->input->post('keyword')));
		$data['keyword'] = strip_tags($this->input->post('keyword'));
		
		if(!$keyword)
		{
			$this->session->set_flashdata('error', 'Mohon isi kolom kata pencarian terlebih dahulu.');
			redirect(site_url('doc/search_content/'.$this->uri->segment(3)));
		}
		
		$files = $this->model_doc->get_all_files();
		
		if( !$files )
		{
			$this->session->set_flashdata('error', 'Pencarian tidak memberikan hasil, atau tidak ada dokumen.');
			redirect(site_url('doc/search_content/'.$this->uri->segment(3)));
		}
		
		$this->load->helper('file');
		$find = '';
		
		foreach($files as $key)
		{
			$file = $key->atc_path.$key->atc_rawname.'.txt';
			
			if(file_exists($file))
			{
				$content = read_file($file);
				$formatted_text = str_replace($keyword, "#$keyword#", strtolower($content));
				
				if(preg_match_all("/\#$keyword\#/i", $formatted_text, $match)) 
				{
					if(!empty($match))
					{
						$find[] = array(
								'title'=>$key->title,
								'fileID'=>$key->atc_id,
								'sID'=>$key->id_s,
								'filename'=>$key->atc_filename,
								'match'=>count($match[0])
								);
					}
				}

			}
		}		
		
		$data['find'] = $find;
		$data['layout'] = $this->folder.'search_content_result';
		$this->load->view('body', $data);	
	}
	*/
		public function detail()
	{
		$data['dept'] = $this->model_department->get_all();
		//$data['user'] = $this->model_doc->get_all_user($this->dID);
		$data['cat'] = $this->model_category->get_all();
		$this->model_session->auth_page('document', 1);
		$this->model_session->log_activity('V', current_url());
		$data['records'] = $this->model_doc->get_byID($this->dID);
		if(!$data['records']){
			redirect(404);
		}
		$this->load->model('model_atc');
		$data['file'] = $this->model_atc->get_bySID($this->dID);
		$this->model_doc->vcnt($this->dID);
		$data['layout'] = $this->folder.'detail';
		$this->load->view('body', $data);				
	}
	
	public function search()
	{		
		if(! empty($_POST)){
			
			$data['search'] = $this->model_doc->search();
			//print_r($data);exit;
		}else{
			$data['search'] = 0;
		}
		$this->model_session->auth_page('document', 2);
		$this->model_session->log_activity('Search', current_url());
		
		//$data['dept'] = $this->model_department->get_all();
		$data['cat'] = $this->model_category->get_all();
		$data['layout'] = $this->folder.'search';
		$this->load->view('body', $data);
	}
	
	/*public function deleteuser()
	{
		$this->model_session->auth_page('document', 4);
		$this->model_session->log_activity('Delete file', current_url());
		$this->model_doc->deleteuser($this->dID, $this->uri->segment(3));
		redirect(site_url('doc/e/'.$this->uri->segment(4)));
	}
	
	public function i_user()
	{
		$this->model_session->auth_page('document', 2);
		$this->form_validation->set_rules('name', 'Judul', 'required');
	
		if($this->form_validation->run()==FALSE)
		{
			$this->a();
		}
		else
		{
			$this->model_session->log_activity('A', current_url(), $_POST);
			$insertID = $this->model_doc->insert_user();
			$this->session->set_flashdata('success', 'Data baru telah terentry, <a href="'.site_url('doc/e/'.$insertID).'">Untuk detailnya klik disini</a>');
			redirect(site_url('doc/e/'.$this->dID));		
		}
	}*/
	
}
/* End of file User.php */
/* Location: ./application/controllers/User.php */