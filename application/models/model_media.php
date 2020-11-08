<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_media extends CI_Model {

  public function __construct()
  {
		parent::__construct();
  }
		
	public function scan_attachment($rel_id, $filename, $raw, $ext, $size, $path, $desc=NULL)
	{
		if($desc == 'Untitled')
		{
			$desc=NULL;	
		}
		
		$array = array(
							'id_s'=>$rel_id,
							'atc_filename'=>$filename,
							'atc_rawname'=>$raw,
							'atc_ext'=>$ext,
							'atc_size'=>$size,
							'atc_path'=>$path,
							'atc_desc'=>$desc,
							'atc_from'=>1,
							'atc_cdt'=>date('Y-m-d H:i:s'),
							'atc_cby'=>$this->session->userdata('uID')
							);
							
		$this->db->set($array);
		$this->db->insert(DBATC);
		
		if ($this->db->affected_rows() > 0)
		{
			return $this->session->set_flashdata('success', 'Sukses memperbaharui data.');
		}
		else
		{
			return $this->session->set_flashdata('error', 'Error 3003: Gagal memperbaharui data.');
		}
	}	
	
	function get_attachment($idLetter)
	{
		$this->db->select('*');
		$this->db->where('np', $idLetter);
		$this->db->order_by('idatc', 'desc');
		$query = $this->db->get('atc_nasabah');
		
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}		
	}	
		
	/* get by id*/
	public function get_atc($id)
	{
		//$this->db->select('atc_id,id_s,atc_filename,atc_rawname,atc_ext,atc_path,atc_size');
		$this->db->select('*');
		$this->db->where('idatc', $id);
		$query = $this->db->get('atc_nasabah');

		if ($query->num_rows() > 0)
		{
			return $query->row();
		}else{
			return FALSE;
		}
	}
	
	/* update view counter */
	public function update_counter($id, $method='view')
	{
		if(!$id){
			return FALSE;
		}
		
		switch ($method)
		{
			case 'print':
			  $this->db->set('atc_pcnt', 'atc_pcnt+1', FALSE);
			  break;
			case 'download':
			  $this->db->set('atc_dcnt', 'atc_dcnt+1', FALSE);
			  break;
			default:
			  $this->db->set('atc_vcnt', 'atc_vcnt+1', FALSE);
		}
		
		$this->db->where(array('atc_id' => $id));
		$this->db->update(DBATC);
	}	
	
	/* delete */
	public function datc($id)
	{
		if ($id)
		{
			$query = $this->db->delete(DBATC, array('atc_id' => $id)); 
		}
		else
		{
			return $this->session->set_flashdata('error', 'Apa yang anda lakukan?');
		}
		
		if (!$query)
		{
			return $this->session->set_flashdata('error', 'Gagal menghapus data.');
		}
		else
		{
			return $this->session->set_flashdata('success', 'Berhasil menghapus data.');
		}				
	}	

}
/* End of file Model_media.php */
/* Location: ./application/model/Model_media.php */ ?>