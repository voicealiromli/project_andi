<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_sys extends CI_Model {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function get_system_state()
	{
		$this->db->select('option_value');
		$this->db->where('option_title', 'SYSTEM_STATE');
		$row = $this->db->get(DBOPT, 1)->row();
		if($row->option_value=='ON')
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_email_admin()
	{
		$this->db->select('option_value');
		$this->db->where('option_title', 'EMAIL_ADMIN');
		$row = $this->db->get(DBOPT, 1)->row();
		if($row)
		{
			$e = explode(',', $row->option_value);
			return $e;
		}
		else
		{
			return NULL;
		}
	}
	
	public function get_site_info()
	{
		$output = array('SITE_NAME'=>'', 'SITE_DESC'=>'', 'SITE_ADDR'=>'');
		
		$this->db->select('option_value');
		$this->db->where('option_title', 'SITE_NAME');
		$row = $this->db->get(DBOPT, 1)->row();
		
		$output['SITE_NAME'] = $row->option_value;
		
		$this->db->select('option_value');
		$this->db->where('option_title', 'SITE_DESC');
		$row = $this->db->get(DBOPT, 1)->row();
		
		$output['SITE_DESC'] = $row->option_value;
		
		$this->db->select('option_value');
		$this->db->where('option_title', 'SITE_ADDR');
		$row = $this->db->get(DBOPT, 1)->row();
		
		$output['SITE_ADDR'] = $row->option_value;
		
		return $output;

	}
	
	public function save_config()
	{
		
		$this->db->set('option_value', $this->input->post('state'));
		$this->db->where('option_title', 'SYSTEM_STATE');
		$this->db->update(DBOPT);
		
		$this->db->set('option_value', $this->input->post('name'));
		$this->db->where('option_title', 'SITE_NAME');
		$this->db->update(DBOPT);
		
		$this->db->set('option_value', $this->input->post('desc'));
		$this->db->where('option_title', 'SITE_DESC');
		$this->db->update(DBOPT);
		
		$this->db->set('option_value', $this->input->post('addr'));
		$this->db->where('option_title', 'SITE_ADDR');
		$this->db->update(DBOPT);
		
		$email = $this->input->post('mail_primary');
		if($this->input->post('mail_secondary')) {
			$email .= ','.$this->input->post('mail_secondary');
		}

		$this->db->set('option_value', $email);
		$this->db->where('option_title', 'EMAIL_ADMIN');
		$this->db->update(DBOPT);		
		
	}
	
	/* update global login counter */
	public function update_login_counter()
	{
		$counter = 1;

		$this->db->select('option_value');
		$this->db->where('option_title', 'LOGIN_CNT');
		$row = $this->db->get(DBOPT, 1)->row();
		$user = $this->db->last_query();
		echo 'q='.$user;exit;
		
		$counter = intval($row->option_value)+1;
		
		if($counter > 1000)
		{
			$this->dbutil->optimize_database();
		}
		else if($counter > 2000)
		{
			$this->db->set('option_value', 1);	
			$this->db->where('option_title', 'LOGIN_CNT');
			$this->db->update(DBOPT);
		}
		else
		{
			//update counter
			$this->db->set('option_value', $counter);	
			$this->db->where('option_title', 'LOGIN_CNT');
			$this->db->update(DBOPT);
		}
	}

	public function get_all_sys()
	{
		$this->db->select('option_title, option_value');
		$q = $this->db->get(DBOPT);
		
		if($q)
		{			
			foreach($q->result_array() as $key)
			{
				$data[$key['option_title']] = $key['option_value'];
			}
			
			return $data;
		}
		else
		{
			return false;
		}
		
	}

}
/* End of file Model_sys.php */
/* Location: ./_app/model/Model_sys.php */ ?>