<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_data extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_all($term)
	{
		$this->db->select('content');
		$this->db->like('content', $term);
		$query = $this->db->get(DBDAT, 9);
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
	private function parse_input($var)
	{
		$output = array();
		$var = str_replace('; ', ';', $var);
		$array = explode(';', trim($var));
		foreach($array as $key=>$val) {
			if($val) {
				array_push($output, $val);
			}
		}
		return $output;
	}
	
	public function insert($var)
	{
		$x = $this->parse_input($var);
		if(!$x) {
			return FALSE;
		}
		foreach($x as $key=>$val) {
			$this->db->select('ID');
			$this->db->where('content', $val);
			$this->db->limit(1);
			$q = $this->db->get(DBDAT)->row();
			if(!$q->ID) {
				$this->db->insert(DBDAT, array('content'=>$val));
			}
		}//foreach
	}
		
} 
/* End of file Model_data.php */
/* Location: ./application/model/Model_data.php */ ?>