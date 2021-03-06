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
	
	public function json_data_doc()
	{
		$this->model_session->auth_page('document', 2);
		$this->model_doc->get_datatable_json_doc();		
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
		$data['jenis_berkas'] = $this->db->query("select * from jenis_berkas")->result_array();
		$this->load->view('body', $data);
	}
	
	
	
	public function foldersave()
	{
		$data = json_decode(json_encode($_POST));
		$data = json_decode(json_encode($data), true);
		
		$nama_folder = $data['nama_folder'];
		$box 	     = $data['box'];
		$blok        = $data['blok'];
		$rak         = $data['rak'];
		$idn         = $data['idn'];
		$idfolder         = $data['idfolder'];
		
		
		
	   $folder = array(
			 'id_nasabah' =>$idn,
			 'nama_folder' =>$nama_folder,
			 'blok' =>$blok,
			 'box' =>$box,
			 'rak' =>$rak,
		);
		
		
		if(!empty($idfolder))
		{
			    $this->db->where('id_folder',$idfolder);
			    $dd = $this->db->update('folder',$folder);
			    if($dd)
				{
					$data = array(
							"success" => 'OK',
							//"msg"     => 'Data telah diubah, <a href="'.site_url('doc/dk/'.$dd.'').'">Untuk detailnya klik disini</a>'
							//"msg"     => 'Data telah diubah'
							"msg"     => 'Data telah diubah, <a href="#" id="open-edit" data="'.$idfolder.'">Untuk detailnya klik disini</a>'

						);
					echo json_encode($data);
				}
				else
				{
					$data = array(
							"success" => 'NO',
							"msg"     => 'Data Gagal diubah, Silahkan coba lagi'
						);
					echo json_encode($data);
				}	
		}
        else
        {
				$this->db->insert('folder',$folder);
				$insertID = $this->db->insert_id();
				if($insertID)
				{
					$data = array(
							"success" => 'OK',
							//"msg"     => 'Data baru telah terentry, <a href="'.site_url('doc/dk/'.$insertID.'').'">Untuk detailnya klik disini</a>'
							"msg"     => 'Data baru telah terentry, <a href="#" id="open-edit" data="'.$insertID.'">Untuk detailnya klik disini</a>'
							//"msg"     => 'Data baru telah terentry'
						);
					echo json_encode($data);
				}
				else
				{
					$data = array(
							"success" => 'NO',
							"msg"     => 'Data Gagal entry, Silahkan coba lagi'
						);
					echo json_encode($data);
				}	
			
		}			
		
				
	}
	
	public function folder()
	{
		$id = $this->uri->segment(4);
		$iddk = $this->uri->segment(3);
		$this->model_session->auth_page('document', 2);
		$this->model_session->log_activity('V', current_url());
		$data['layout'] = $this->folder.'folder';
		$data['idn'] = $iddk;
		//$data['jenis_berkas'] = $this->db->query("select * from jenis_berkas")->result_array();
		$this->load->view('body', $data);
	}
	
	public function json_data_folder()
	{
		$this->model_session->auth_page('document', 2);
		$this->model_doc->get_datatable_json_folder();		
	}
	
	public function json_data_file()
	{
		//$this->model_session->auth_page('document', 2);
		$this->model_doc->get_datatable_json_file();		
	}
	
	
	public function file()
	{
		$id = $this->uri->segment(3);
		$arsip = $this->uri->segment(4);
		$folder = $this->uri->segment(5);
		//$idfolder = $this->uri->segment(4);
		//$this->model_session->auth_page('document', 2);
		//$this->model_session->log_activity('V', current_url());
		$data['layout'] = $this->folder.'file';
		$data['idfolder'] = $id;
		$data['arsip'] = $arsip;
		$data['folder'] = $folder;
		//$data['jenis_berkas'] = $this->db->query("select * from jenis_berkas")->result_array();
		$this->load->view('body', $data);
	}
	public function insertArsip()
	{
		$data = json_decode(json_encode($_POST));
		$data = json_decode(json_encode($data), true);
		//print_r($data);
	    // $data = json_decode($data, TRUE);
		$jenis_berkas = $data['berkas']['jenis_berkas'];
		$no_polis 	  = $data['berkas']['no_polis'];
		$nama_dokumen = $data['berkas']['nama_dokumen'];
		$tahun        = $data['berkas']['tahun'];
		
		$datax = array(
			'ctr'=> $jenis_berkas,//$ctr, // jenis dokumen
			'no'=> $no_polis, // No Polis
			'klien'=>$nama_dokumen, // klien
			'cyear'=>$tahun, // thn
			'cdt'=>date('d-m-Y'),				// created_at
			
		);
	
		$this->db->insert('nasabah',$datax);	
		$insertID = $this->db->insert_id();
		
		if($insertID)
		{
			$data = array(
					"success" => 'OK',
					"msg"     => 'Data baru telah terentry, <a href="'.site_url('doc/dk/'.$insertID.'').'">Untuk detailnya klik disini</a>'
				);
			echo json_encode($data);
		}
        else
        {
			$data = array(
					"success" => 'NO',
					"msg"     => 'Data Gagal entry, Silahkan coba lagi'
				);
			echo json_encode($data);
		}			
		 
		
		
	}	
	
	public function insertFile()
	{
		$data = json_decode(json_encode($_POST));
		$data = json_decode(json_encode($data), true);
		//print_r($data);
		$id_dokumen = $data['id_dokumen']; 
		$id_folder  = $data['id_folder'];
		$nama_file  = $data['nama_file'];
		
		if(!empty($id_dokumen))
		{
			
			    $prev_file_path = "./uploads/".$nama_file.".pdf";
				if(unlink($prev_file_path))
				{
					
					 $_FILES['file']['name'] = $_FILES['files']['name'];
					  $_FILES['file']['type'] = $_FILES['files']['type'];
					  $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'];
					  $_FILES['file']['error'] = $_FILES['files']['error'];
					  $_FILES['file']['size'] = $_FILES['files']['size'];	
					  
					  $config['upload_path'] = 'uploads/'; 
					  $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|csv';
					  $config['max_size'] = '5000';
					  $config['file_name'] = $_FILES['files']['name'];
					  $config['remove_spaces'] 	= TRUE;
					  $config['encrypt_name']	= TRUE;
					  $this->load->library('upload',$config); 
					  if($this->upload->do_upload('file')){
						$uploadData = $this->upload->data();
						//$filename = $uploadData['file_name'];
						$file = array(
								'nama_dokumen' =>$_FILES['files']['name'],
								'nama_file' =>$uploadData['raw_name'],
								'id_folder' =>$id_folder, 
						);
							  $this->db->where('id_dokumen_file',$id_dokumen);
					    $d =  $this->db->update('dokumen_file',$file);
					   
					    if($d)
						{
							$data = array(
									"success" => 'OK',
									//"msg"     => 'Data File baru telah terentry, <a href="#" id="open-edit" data="'.$insertID.'">Untuk detailnya klik disini</a>'
									"msg"     => 'Data berhasil diubah'
									
								);
							echo json_encode($data);
						}
						else
						{
							$data = array(
									"success" => 'NO',
									"msg"     => 'File gagal  diupdate, Silahkan coba lagi'
								);
							echo json_encode($data);
						}	 
					}
					
				}	
				else
				{
					 $data = array(
							"success" => 'NO',
							"msg"     => 'Terjadi Kesalahan, gagal diupdate'
						);
					header('Content-Type: application/json');
					echo json_encode( $data );	 
				}
					
			
		}
        else
        {
				  $_FILES['file']['name'] = $_FILES['files']['name'];
				  $_FILES['file']['type'] = $_FILES['files']['type'];
				  $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'];
				  $_FILES['file']['error'] = $_FILES['files']['error'];
				  $_FILES['file']['size'] = $_FILES['files']['size'];	
				  
				  $config['upload_path'] = 'uploads/'; 
				  $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|csv';
				  $config['max_size'] = '5000';
				  $config['file_name'] = $_FILES['files']['name'];
				  $config['remove_spaces'] 	= TRUE;
				  $config['encrypt_name']	= TRUE;
				  $this->load->library('upload',$config); 
    			  if($this->upload->do_upload('file')){
						$uploadData = $this->upload->data();
						//$filename = $uploadData['file_name'];
						$file = array(
								'nama_dokumen' =>$_FILES['files']['name'],
								'nama_file' =>$uploadData['raw_name'],
								'id_folder' =>$id_folder, 
						);
					    $this->db->insert('dokumen_file',$file);
					    $insertID = $this->db->insert_id();
					    if($insertID)
						{
							$data = array(
									"success" => 'OK',
									//"msg"     => 'Data File baru telah terentry, <a href="#" id="open-edit" data="'.$insertID.'">Untuk detailnya klik disini</a>'
									"msg"     => 'Data File baru telah terentry'
									
								);
							echo json_encode($data);
						}
						else
						{
							$data = array(
									"success" => 'NO',
									"msg"     => 'Data Gagal entry, Silahkan coba lagi'
								);
							echo json_encode($data);
						}	 
				  }
			
			
		}			
		
	}
	
	public function insertDokumen()
	{
		//print_r($_FILES);
		$data = json_decode(json_encode($_POST));
		$data = json_decode(json_encode($data), true)['data'];
		$data = json_decode($data, TRUE);
		$jenis_berkas = $data['berkas']['jenis_berkas'];
		$no_polis 	  = $data['berkas']['no_polis'];
		$nama_dokumen = $data['berkas']['nama_dokumen'];
		$tahun        = $data['berkas']['tahun'];
		//$ctr		  = $data['berkas']['category'];
		
		$datax = array(
			'ctr'=> $jenis_berkas,//$ctr, // jenis dokumen
			'no'=> $no_polis, // No Polis
			'klien'=>$nama_dokumen, // klien
			'cyear'=>$tahun, // thn
			'cdt'=>date('d-m-Y'),				// created_at
			
		);
	
		$this->db->insert('nasabah',$datax);	
		$insertID = $this->db->insert_id();
		
		$ar_row = array();
		
		foreach($data['data_header_row'] as $row)
		{
			$folder = array(
				 'id_nasabah' =>$insertID,
				 'nama_folder' =>$row['nama_folder'],
				 'blok' =>$row['blok'],
				 'box' =>$row['box'],
				 'rak' =>$row['rak'],
			);
			$this->db->insert('folder',$folder);
			$insertIDx = $this->db->insert_id();
			array_push($ar_row,array('id_folder'=>$insertIDx,'nama_folder'=>$row['nama_folder']));	
		}
		
		foreach($ar_row as $row)
		{
			for($i=0;$i<count($_FILES['files']['name'][$row['nama_folder']]);$i++)
			{
				  
				  //$n = $_FILES['files']['name'][$row['nama_folder']];
				  $_FILES['file']['name'] = $_FILES['files']['name'][$row['nama_folder']][$i];
				  $_FILES['file']['type'] = $_FILES['files']['type'][$row['nama_folder']][$i];
				  $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$row['nama_folder']][$i];
				  $_FILES['file']['error'] = $_FILES['files']['error'][$row['nama_folder']][$i];
				  $_FILES['file']['size'] = $_FILES['files']['size'][$row['nama_folder']][$i];
				  
				  $config['upload_path'] = 'uploads/'; 
				  $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|csv';
				  $config['max_size'] = '5000';
				  $config['file_name'] = $_FILES['files']['name'][$row['nama_folder']][$i];
				  $config['remove_spaces'] 	= TRUE;
				  $config['encrypt_name']	= TRUE;
				  $this->load->library('upload',$config); 
    			  if($this->upload->do_upload('file')){
					 $uploadData = $this->upload->data();
					 //$filename = $uploadData['file_name'];
				 	 $file = array(
							'nama_dokumen' =>$_FILES['files']['name'][$row['nama_folder']][$i],
							'nama_file' =>$uploadData['raw_name'],
							'id_folder' =>$row['id_folder'], 
					 );
					 $this->db->insert('dokumen_file',$file);
				  }
			}	
		}	
		$data = array(
					"success" => 'OK',
					"msg"     => 'Data baru telah terentry, <a href="'.site_url('doc/dk/'.$insertID.'').'">Untuk detailnya klik disini</a>'
				);
		echo json_encode($data);
	}
	
	public function delFolder()
	{
		$this->load->helper("file");
		$id = $_POST['data'];
		$data = $this->db->query("select * from dokumen_file where id_folder='$id'")->result_array();
		
		$cnt_data = count($data);
		
		$ss = array();
		$ss2 = array();
		foreach($data as $row)
		{
			 $idx = $row["id_dokumen_file"];
			 $namafile = $row['nama_file'];
			 $nama_dokumen = $row['nama_dokumen'];
			 
			 $prev_file_path = "./uploads/".$namafile.".pdf";
			 
			 if(unlink($prev_file_path))
			 {
				$this->db->where('id_dokumen_file ', $idx);
				$this->db->delete('dokumen_file');
			    array_push($ss,array("nama_file"=>$nama_dokumen));
			 }	
			 else
			 {
				array_push($ss2,array("nama_file"=>$nama_dokumen));
			 }
				 
		}
		
		if(count($ss) > 0)
		{
		
		   if(count($ss) == $cnt_data)
		   {
			    $this->db->where('id_folder ', $id);
				$this->db->delete('folder');
		   }	   
			
			$data = array(
				"success" => 'OK',
				//"msg"     => $ss
				"msg"     => 'Folder ini Berhasil dihapus'
			);
			
			header('Content-Type: application/json');
			echo json_encode( $data );
		}
        else
        {
			
			$this->db->where('id_folder ', $id);
			$this->db->delete('folder');
			
			$data = array(
							"success" => 'OK',
							//"msg"     => 'Terjadi Kesalahan'
							"msg"     => 'Folder ini Berhasil dihapus'
						);
			header('Content-Type: application/json');
			echo json_encode( $data );	 
		
		}			
		
	}

	public function delDokumen()
	{
		$this->load->helper("file");
		$id = $_POST['data'];
		$row = $this->db->query("select * from dokumen_file where id_dokumen_file='$id'")->row();
		//print_r($row);
		$namafile = $row->nama_file;
		$nama_dokumen = $row->nama_dokumen;
		//$prev_file_path = site_url()."/uploads/".$namafile.".pdf";
		$prev_file_path = "./uploads/".$namafile.".pdf";
		if(unlink($prev_file_path))
		{
			
			$this->db->where('id_dokumen_file ', $id);
		    $this->db->delete('dokumen_file');
			$data = array(
				"success" => 'OK',
				"msg"     => 'Dokumen '.$nama_dokumen.' Berhasil dihapus'
			);
			header('Content-Type: application/json');
			echo json_encode( $data );
			
		}	
		else
		{
			 $data = array(
					"success" => 'NO',
					"msg"     => 'Terjadi Kesalahan'
				);
			header('Content-Type: application/json');
			echo json_encode( $data );	 
		}
		
	}	
	
	//public function del_updateDokumen($iddok,$_FILES,$row2,$i)
	public function del_updateDokumen($iddok,$row2,$i)
	{
		$this->load->helper("file");
		$id = $iddok;
		$row = $this->db->query("select * from dokumen_file where id_dokumen_file='$id'")->row();
		//print_r($row);
		$namafile = $row->nama_file;
		$nama_dokumen = $row->nama_dokumen;
		//$prev_file_path = site_url()."/uploads/".$namafile.".pdf";
		$prev_file_path = "./uploads/".$namafile.".pdf";
		if(unlink($prev_file_path))
		{
			
				//echo "error1ww";
				//$this->db->where('id_dokumen_file ', $id);
				//$this->db->delete('dokumen_file');
				//$data = array(
				//	"success" => 'OK',
				//	"msg"     => 'Dokumen '.$nama_dokumen.' Berhasil dihapus'
				//);
				//header('Content-Type: application/json');
				//echo json_encode( $data );
				//return json_encode( $data );
			
				$_FILES['file']['name'] = $_FILES['files']['name'][$row2['nama_folder']][$i];
				$_FILES['file']['type'] = $_FILES['files']['type'][$row2['nama_folder']][$i];
				$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$row2['nama_folder']][$i];
				$_FILES['file']['error'] = $_FILES['files']['error'][$row2['nama_folder']][$i];
				$_FILES['file']['size'] = $_FILES['files']['size'][$row2['nama_folder']][$i];
				
				$config['upload_path'] = 'uploads/'; 
				$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|csv';
				$config['max_size'] = '5000';
				$config['file_name'] = $_FILES['files']['name'][$row2['nama_folder']][$i];
				$config['remove_spaces'] 	= TRUE;
				$config['encrypt_name']	= TRUE;
				
				
				$this->load->library('upload',$config); 
				if($this->upload->do_upload('file')){
					 $uploadData = $this->upload->data();
					 
					 $file = array(
							'nama_dokumen' =>$_FILES['files']['name'][$row2['nama_folder']][$i],
							'nama_file' =>$uploadData['raw_name'],
							'id_folder' =>$row2['id_folder'], 
					 );
					 $this->db->where('id_dokumen_file',$id);
					 $this->db->update('dokumen_file',$file);
				}
				else
				{
					//echo "error1";
				}	
				
		}	
		else
		{
			// $data = array(
			//		"success" => 'NO',
			//		"msg"     => 'Terjadi Kesalahan'
			//	);
			//header('Content-Type: application/json');
			//echo json_encode( $data );	
				
			//echo "error2";	
			
		}
		
	}	
	
	
	public function updateArsip()
	{
		
		$data = json_decode(json_encode($_POST));
		$data = json_decode(json_encode($data), true);
		//print_r($data);
	    // $data = json_decode($data, TRUE);
		
		$idn = $data['berkas']['idn'];
		$jenis_berkas = $data['berkas']['jenis_berkas'];
		$no_polis 	  = $data['berkas']['no_polis'];
		$nama_dokumen = $data['berkas']['nama_dokumen'];
		$tahun        = $data['berkas']['tahun'];
		
		$datax = array(
			'ctr'=> $jenis_berkas,//$ctr, // jenis dokumen
			'no'=> $no_polis, // No Polis
			'klien'=>$nama_dokumen, // klien
			'cyear'=>$tahun, // thn
			'cdt'=>date('d-m-Y'),				// created_at
			
		);
		$this->db->where('idn', $idn);
		$fg = $this->db->update('nasabah',$datax);	
		
		if($fg)
		{
			$data = array(
					"success" => 'OK',
					"msg"     => 'Data Sudah terupdate'
				);
			echo json_encode($data); 
		}
        else
		{
			$data = array(
					"success" => 'NO',
					"msg"     => 'Update Gagal'
				);
			echo json_encode($data); 
		}			
		
		
	}	
	
	
	public function updateDokumen()
	{
		$data = json_decode(json_encode($_POST));
		$data = json_decode(json_encode($data), true)['data'];
		$data = json_decode($data, TRUE);
		$idn		  = $data['berkas']['idn'];
		$jenis_berkas = $data['berkas']['jenis_berkas'];
		$no_polis 	  = $data['berkas']['no_polis'];
		$nama_dokumen = $data['berkas']['nama_dokumen'];
		$tahun        = $data['berkas']['tahun'];
		//$ctr		  = $data['berkas']['category'];
		//$id_dokumen		  = $data['berkas']['id_dokumen'];
		
		$datax = array(
			'ctr'=> $jenis_berkas,//$ctr, // jenis dokumen
			'no'=> $no_polis, // No Polis
			'klien'=>$nama_dokumen, // klien
			'cyear'=>$tahun, // thn
			'cdt'=>date('d-m-Y'),				// created_at
			
		);
		$this->db->where('idn', $idn);
		$this->db->update('nasabah',$datax);	
		//$insertID = $this->db->insert_id();
		$ar_row = array();
		$datan = $this->db->query("select * from folder where id_nasabah='$idn'")->result_array();
		$array_idf = array();
		foreach($datan as $row)
		{
			 $idf = $row["id_folder"];
			 array_push($array_idf,$idf);
		}	
		
		
		foreach($data['data_header_row'] as $row)
		{
		    
			if(in_array($row['id_folder'],$array_idf))
			{
				//update folder
				$data = array(
						'nama_folder' => $row['nama_folder'],
						'blok' => $row['blok'],
						'box' => $row['box'],
						'rak' => $row['rak']
				);
				
				$this->db->where('id_folder ', $row['id_folder']);
				$this->db->update('folder',$data);
				$idf = $row['id_folder'];
				
				$data_dk = $this->db->query("select * from dokumen_file where id_folder='$idf'")->result_array();
				$array_dk = array();
				foreach($data_dk as $r)
				{
					$idd = $r["id_dokumen_file"];
					array_push($array_idf,$idd);
				} 
				$cn = 0;
				foreach($row['id_dokumen'] as $r)
				{
					//echo $r['id_dokumen_file']; echo "<br>";
					if(in_array($r['id_dokumen_file'],$array_idf))
					{
						$row2['nama_folder'] = $row['nama_folder'];
						$row2['id_folder']   = $row['id_folder'];
						//$r['file'] = "no_update";
						if($r['file'] == "update")
						{
							//print_r($_FILES['files']['name'][$row2['nama_folder']]);
							if( $_FILES['files']['name'][$row2['nama_folder']][$cn] !== "undefined")
							{	
								//$this->del_updateDokumen($r['id_dokumen_file'],$_FILES,$row2,$cn);
								$this->del_updateDokumen($r['id_dokumen_file'],$row2,$cn);
							}
						}	
						
						
					}
                    else
                    {
						
						if( $_FILES['files']['name'][$row2['nama_folder']][$cn] !== "undefined")
						{
							$row2['nama_folder'] = $row['nama_folder'];
							$row2['id_folder']   = $row['id_folder'];
							$_FILES['file']['name'] = $_FILES['files']['name'][$row2['nama_folder']][$cn];
							$_FILES['file']['type'] = $_FILES['files']['type'][$row2['nama_folder']][$cn];
							$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$row2['nama_folder']][$cn];
							$_FILES['file']['error'] = $_FILES['files']['error'][$row2['nama_folder']][$cn];
							$_FILES['file']['size'] = $_FILES['files']['size'][$row2['nama_folder']][$cn];
							
							$config['upload_path'] = 'uploads/'; 
							$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|csv';
							$config['max_size'] = '5000';
							$config['file_name'] = $_FILES['files']['name'][$row2['nama_folder']][$cn];
							$config['remove_spaces'] 	= TRUE;
							$config['encrypt_name']	= TRUE;
					
					
							$this->load->library('upload',$config); 
							if($this->upload->do_upload('file')){
								 $uploadData = $this->upload->data();
								 //$filename = $uploadData['file_name'];
								 $file = array(
										'nama_dokumen' =>$_FILES['files']['name'][$row2['nama_folder']][$cn],
										'nama_file' =>$uploadData['raw_name'],
										'id_folder' =>$row2['id_folder'], 
								 );
								 $this->db->insert('dokumen_file',$file);
								 
							}
						}
						
					}
				 $cn++;					
				}	 
				
			}	
			else
            {
				 //insert folder
				 $folder = array(
					 'id_nasabah' =>$idn,
					 'nama_folder' =>$row['nama_folder'],
					 'blok' =>$row['blok'],
					 'box' =>$row['box'],
					 'rak' =>$row['rak'],
				);
				$this->db->insert('folder',$folder);
				$insertIDx = $this->db->insert_id();
				array_push($ar_row,array('id_folder'=>$insertIDx,'nama_folder'=>$row['nama_folder']));	
				
			}				
			
		}	
		
		foreach($ar_row as $row)
		{
			for($i=0;$i<count($_FILES['files']['name'][$row['nama_folder']]);$i++)
			{
				  //$n = $_FILES['files']['name'][$row['nama_folder']];
				  $_FILES['file']['name'] = $_FILES['files']['name'][$row['nama_folder']][$i];
				  $_FILES['file']['type'] = $_FILES['files']['type'][$row['nama_folder']][$i];
				  $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$row['nama_folder']][$i];
				  $_FILES['file']['error'] = $_FILES['files']['error'][$row['nama_folder']][$i];
				  $_FILES['file']['size'] = $_FILES['files']['size'][$row['nama_folder']][$i];
				  
				  $config['upload_path'] = 'uploads/'; 
				  $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|csv';
				  $config['max_size'] = '5000';
				  $config['file_name'] = $_FILES['files']['name'][$row['nama_folder']][$i];
				  $config['remove_spaces'] 	= TRUE;
				  $config['encrypt_name']	= TRUE;
				  $this->load->library('upload',$config); 
    			  if($this->upload->do_upload('file')){
					 $uploadData = $this->upload->data();
					 //$filename = $uploadData['file_name'];
				 	 $file = array(
							'nama_dokumen' =>$_FILES['files']['name'][$row['nama_folder']][$i],
							'nama_file' =>$uploadData['raw_name'],
							'id_folder' =>$row['id_folder'], 
					 );
					 $this->db->insert('dokumen_file',$file);
				  }
			}	
		}
		
				$data = array(
					"success" => 'OK',
					"msg"     => 'Data Sudah terupdate'
				);
		echo json_encode($data); 
		
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
		$this->db->where('idn', $id);
		$data['records'] = $this->db->get('nasabah')->row();
		
		$this->db->where('np', $id);
		$data['file'] =  $this->db->get('atc_nasabah')->result();
		$data['id']   =  $id;
		$data['jenis_berkas'] = $this->db->query("select * from jenis_berkas")->result_array();
		$data['layout'] = $this->folder.'e';
		$this->load->view('body', $data);
	}	
	
	
	public function loadDataFile()
	{
		$id = $_POST['data'];
		$data_file = $this->db->query("select * from dokumen_file where id_dokumen_file='$id'")->result_array();
		
		if(count($data_file)>0)
		{
			$data = array(
					"success" => 'OK',
					"msg"     => $data_file
				);
			//header('Content-Type: application/json');
			echo json_encode( $data );
		}
		else
        {
			$data = array(
					"success" => 'NO',
					"msg"     => 'Data Tidak Ada'
				);
			//header('Content-Type: application/json');
			echo json_encode( $data );
		}			
		
	}
	
	public function loadDataFolder()
	{
		$id = $_POST['data'];
		$data_folder = $this->db->query("select * from folder where id_folder='$id'")->result_array();
		$data = array(
					"success" => 'OK',
					"msg"     => $data_folder
				);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}	
	
	public function loadData()
	{
		
		$id = $_POST['data'];
		$data_folder = $this->db->query("select * from folder where id_nasabah='$id'")->result_array();
		
		$data = array();	
		foreach($data_folder as $g){
			
				$id = $g['id_folder'];
				$dataDokumen = $this->db->query("select * from dokumen_file where id_folder='$id'")->result_array();
				
				$datadok = array();
				foreach($dataDokumen as $s)
				{
					array_push($datadok,
						array(
						'id_dokumen_file'=>$s['id_dokumen_file'],
						'nama_dokumen'=>$s['nama_dokumen'],
						'nama_file'=>$s['nama_file'],
						'id_folder'=>$s['id_folder'],
					));
				}
				
				array_push($data,array(
									   'id_folder'=>$g['id_folder'],
									   'id_nasabah'=>$g['id_nasabah'],
									   'nama_folder'=>$g['nama_folder'],
									   'blok'=>$g['blok'],
									   'box'=>$g['box'],
									   'rak'=>$g['rak'],
									   'data_dokumen'=> $datadok
									   ));
		}
		$data = array(
					"success" => 'OK',
					"msg"     => $data
				);
		header('Content-Type: application/json');
		echo json_encode( $data );
	}
	
	public function dk_($id)
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