<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_report extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function search()
	{
		$this->db->select('*');
		$bdate = $this->input->post('bdate');
		$edate = $this->input->post('edate');
		
		if($bdate)
		{
			$this->db->where('cyear >= ', $bdate);
		}
		
		if($edate)
		{
			$this->db->where('cyear <= ', $edate);
		}
		
		if(!$bdate && !$edate)
		{
			return FALSE;
		}
		
		$this->db->order_by('cyear', 'asc');		
		$query = $this->db->get('nasabah');
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}		
	}
	
} 
/* End of file Model_report.php */
/* Location: ./application/model/Model_report.php */ ?>