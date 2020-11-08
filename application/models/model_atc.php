<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_atc extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function get_all()
	{
		$this->db->select($this->config->item('atc_cols'));
		$query = $this->db->get(DBATC);
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function get_bySID($id)
	{
		$this->db->select('*');
		$this->db->where('np', $id);
		$query = $this->db->get('atc_nasabah');
		if($query->num_rows()>0)
		{
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function get_byID($id, $sid)
	{
		$this->db->select('*');
		$this->db->where('idatc', $id);
		$this->db->where('np', $sid);
		$query = $this->db->get('atc_nasabah');
		if($query->num_rows()>0)
		{
			return $query->row();
		}else{
			return FALSE;
		}
	}
	
	// insert uploaded data records to db
	public function insert($id, $var)
	{
		$data = array( 	
						'np' => $id,
						'cdt'=>date('d-m-Y'),
						'fname'=> $var['orig_name'], 		// nama asal file
						'ename'=>$var['raw_name'].'.pdf' 	// nama enkrip file
					);
		//p_code($data);exit;
		$this->db->insert('atc_nasabah',$data);
		
		return TRUE;
	}
	
	// upload single file
	public function upload($id)
	{
		$this->load->library('image_lib');
		$config['upload_path'] 		= DATA_VIEW;
		$config['allowed_types'] 	= 'pdf';//gif|jpg|png|zip|doc|docx|pdf|tif|rtf
		$config['max_size']			= '90000';
		$config['remove_spaces'] 	= TRUE;
		$config['encrypt_name']		= TRUE;

		$this->load->library('upload', $config);			
		
		//p_code($this->upload->data());exit;
		if ( ! $this->upload->do_upload())
		{
			$output = $this->upload->display_errors('<div class="">', '</div>');
			$this->session->set_flashdata('error', $output);
			return FALSE;
		}else{
			$data = $this->upload->data();
			$this->insert($id, $this->upload->data());
			return TRUE;
		}
	}

	public function get_file($id, $sid)
	{
		$doc = $this->get_byID($id, $sid);
		if(!$doc)
		{
			return FALSE;
		}
			
		$atc = realpath(DATA_VIEW.$doc->ename);
		
		if($atc)
		{
			$this->load->helper('download');			
			$filedata = file_get_contents($atc);
			$filename = $doc->fname;
			force_download($filename, $filedata);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	// delete one record by atc id
	public function deletefile($id, $sid)
	{
		$row = $this->get_byID($id, $sid);
		if($row)
		{
			unlink(realpath(DATA_VIEW.$row->ename));
			$this->db->where('idatc', $row->idatc);
			$this->db->delete('atc_nasabah');
		}
	}
	
	// delete all by sid
	public function deleteAllAtc($id)
	{
		$query = $this->get_bySID($id);
		if($query)
		{
			foreach($query as $row)
			{
				unlink(realpath(DATA_VIEW.$row->ename));
				$this->db->where('np', $row->np);
				$this->db->delete('atc_nasabah');
			}			
		}
	}

		
} 
/* End of file Model_atc.php */
/* Location: ./application/model/Model_atc.php */ ?>