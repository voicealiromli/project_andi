<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_user extends CI_Model {
	
	var $datatable_json = array('userID','userName','userFname','userFlag','group_title');
	var $table_cols;
	var $table_json;
	
	function __construct()
	{
		parent::__construct();
		$this->table_cols = $this->config->item('user_cols');
		$this->table_json = $this->config->item('user_json');
	}
	
	public function get_all()
	{
		$query = $this->db->get(DBUSR);
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	
	
	function escapeString($val) {
		$db = get_instance()->db->conn_id;
		$val = mysqli_real_escape_string($db, $val);
		return $val;
	}
	public function get_datatable_json()
	{		
		$aColumns = $this->datatable_json;
		
		$sIndexColumn = "userID";	
		$sTable = DBUSR;
		$joinCols = 'group_title';
		$joinQuery = "LEFT JOIN ".DBGRP." ON ".DBGRP.".group_id = ".$sTable.".group_id";
	
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT ".(int)( $_GET['iDisplayStart'] ).", ".
				(int)( $_GET['iDisplayLength'] );
		}
		
		// ordering
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
						".$this->escapeString($_GET['sSortDir_'.$i] ) .", ";
				}
			}
		  
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		// echo "c=".$sOrder;exit;
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
				{
					$sWhere .= "`".$aColumns[$i]."` LIKE '%".$this->db->escape_like_str( $_GET['sSearch'] )."%' OR ";
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= "`".$aColumns[$i]."` LIKE '%".$this->db->escape_like_str($_GET['sSearch_'.$i])."%' ";
			}
		}
		
		// customize, added $joinQuery var name
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS `$joinCols`, `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$joinQuery
			$sWhere
			$sOrder
			$sLimit
			";
		$rResult = $this->db->query($sQuery);
		$result = $rResult->result();
		$sQueryC = "
			SELECT SQL_CALC_FOUND_ROWS `$joinCols`, `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$joinQuery
			$sWhere
			";
			
		
		
		
		$rResultC = $this->db->query($sQueryC);
		
		$iFilteredTotal = 0;
		if( $rResultC->num_rows() > 0) {
			$iFilteredTotal = $rResultC->num_rows();
		}
		
		$sQuery3 = "
			SELECT COUNT(`".$sIndexColumn."`)
			FROM   $sTable
		";
		
		$rResultTotal = $this->db->query($sQuery3);
		
		$iTotal = 0;
		if( $rResultTotal->num_rows() > 0) {
			$iTotal = $rResultTotal->num_rows();
		}
		
		if( !$this->input->get('sEcho') ) {
			exit();
		}
		
		// CSRF
		$CI =& get_instance();
		if($CI->config->item('csrf_protection') === TRUE)
		{
			$csrf_post = $this->input->get($CI->config->item('csrf_token_name'));
			$csrf_cookie = $_COOKIE[$CI->config->item('csrf_cookie_name')];
			if( !$csrf_post || $csrf_post!=$csrf_cookie ) {
				return false;
			}
		}
		
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		
		foreach( $result as $aRow )
		{
			$row = array();
			$button = '';
			
			$editUrl = site_url('user/e/'.$aRow->userID);
			$deleteUrl = site_url('user/d/'.$aRow->userID);
			
			$button .= '<a href="'.$editUrl.'" class="btn btn-mini"><i class="icon-pencil"></i> </a> ';
			$button .= '<a href="'.$deleteUrl.'" class="btn btn-mini btn-danger" id="deleteBtn" onClick="return confirm(\'You are sure to delete the data?\')"><i class="icon-trash icon-white"></i> </a>';
			
			// $row[] = $button;
			$row[] = $aRow->userID;
			$row[] = $aRow->userName;
			$row[] = $aRow->userFname;
			$row[] = ($aRow->userFlag)?'Aktif':'Non-Aktif';
			$row[] = $aRow->group_title;
			$row[] = $button;
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
		
	}
	
	public function get_byID($id)
	{
		$this->db->where('userID', $id);
		$query = $this->db->get(DBUSR, 1)->row();
		if($query)
		{
			return $query;
		}
		else
		{
			return FALSE;
		}		
	}

	/* get by id, json column*/
	public function get_byid_json($id)
	{
		$this->db->select($this->table_cols);
		$this->db->limit(1);
		$query = $this->db->get_where(DBUSR, array('userID' => $id));
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function insert()
	{
		$pwd=$this->input->post('pwd');
		$password = $this->getPassword($pwd);
		$data = array(
							'userName'=>$this->input->post('email'),
							'userFname'=>$this->input->post('name'),
							'userPwd'=>$password,
							'userFlag'=>$this->input->post('status'),
							'userAdmin'=>$this->input->post('su'),
							'userDepartment'=>$this->input->post('dept'),
							'group_id'=>$this->input->post('role'),
							'userCdt'=>date('Y-m-d H:i:s'),
							'userCby'=>$this->session->userdata('uID')
						);
		
		$this->db->insert(DBUSR,$data);
		return $this->db->insert_id();
	}
	
	public function update()
	{
		$pwd = $this->input->post('pwd');
		
		$data = array(
							'userName'=>$this->input->post('email'),
							'userFname'=>$this->input->post('name'),
							'userFlag'=>$this->input->post('status'),
							'group_id'=>$this->input->post('role'),
							'userAdmin'=>$this->input->post('su'),
							'userDepartment'=>$this->input->post('dept'),
							'userUdt'=>date('Y-m-d H:i:s'),
							'userUby'=>$this->session->userdata('uID')
						);
		
		if($pwd!='') {
			$password = $this->getPassword($pwd);
			$data['userPwd'] = $password;
		}		
						
		$this->db->set($data);
		$this->db->where('userID', $this->input->post('id'));
		$this->db->update(DBUSR);
	}

	public function delete($id)
	{
		$this->db->where('userID', $id);
		$this->db->delete(DBUSR);
		if($this->db->affected_rows()>0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/* update password*/
	/* forgot password use*/
	public function u_pwd($id, $pwd)
	{
        $password = $this->getPassword($pwd);
		
		$this->db->set('userPwd', $password);
		$this->db->set('userUdt', 'NOW()', false);	
		$this->db->where('userID', $id);
		$this->db->update(DBUSR);
		
		if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}				
	}	
	
	/* HELPERS */
	/* create password */
	public function getPassword($pwd){
		$options = [
            'cost' => 10,
        ];
            
        $password =  password_hash($pwd, PASSWORD_DEFAULT, $options);
		
		return $password;
	}
	/* create password */
	
	
	/* name checking */
	public function check_name($post, $type=NULL, $id=NULL)
	{
		$this->db->select($this->cols_json);
		$this->db->limit(1);
		
		if($type == 'email')
		{
			$this->db->where('userEmail', $post);
		}
		else
		{
			$this->db->where('userName', $post);
		}
		
		if($id)
		{
			$this->db->where_not_in('userID', $id);
		}
		
		$query = $this->db->get(DBUSR);
		
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}	
		
} 
/* End of file Model_user.php */
/* Location: ./application/model/Model_user.php */ ?>