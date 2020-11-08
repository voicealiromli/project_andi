<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_role extends CI_Model {
	
	var $datatable_json = array('group_id', 'group_title', 'group_desc');
	var $grp_cols;
	
	function __construct()
	{
		parent::__construct();
		$this->grp_cols = $this->config->item('grp_cols');
	}
	
	function escapeString($val) {
		$db = get_instance()->db->conn_id;
		$val = mysqli_real_escape_string($db, $val);
		return $val;
	}

	public function get_datatable_json()
	{		
		$aColumns = $this->datatable_json;
		//customize here
		$sIndexColumn = "group_id";		
		$sTable = DBGRP;	
	
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
			SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$sWhere
			$sOrder
			$sLimit
			";
			
		$rResult = $this->db->query($sQuery);
		$result = $rResult->result();
		
		$sQueryC = "
			SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
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
		// $rResultTotal = mysql_query( $sQuery );
		// $aResultTotal = mysql_fetch_array($rResultTotal);
		// $iTotal = $aResultTotal[0];
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
			
			$editUrl = site_url('role/e/'.$aRow->group_id);
			$deleteUrl = site_url('role/d/'.$aRow->group_id);
			
			$button .= '<a href="'.$editUrl.'" class="btn btn-mini"><i class="icon-pencil"></i> </a> ';
			$button .= '<a href="'.$deleteUrl.'" class="btn btn-mini btn-danger" id="deleteBtn" onClick="return confirm(\'You are sure to delete the data?\')"><i class="icon-trash icon-white"></i> </a>';
			
			$row[] = $aRow->group_title;
			$row[] = $aRow->group_desc;
			$row[] = $button;
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
		
	}
	
	public function get_json()
	{
		$this->db->select($this->grp_cols);
		$query = $this->db->get(DBGRP)->result();
		
		if($query)
		{
			return $query;
		}
		else
		{
			return FALSE;
		}		
	}
	
	public function get_byID($id)
	{
		$this->db->select($this->grp_cols);
		$this->db->where('group_id', $id);
		$query = $this->db->get(DBGRP, 1);
		if($query)
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
		$level = '';
		$auth_pages = $this->config->item('auth_pages');
		foreach($auth_pages as $key=>$val)
		{
			$level .= $val.'='.$this->input->post($val).',';
		}
		$level = substr_replace($level, '', -1);
		//print_r($level);exit();
		$data = array(
			'group_title'=>$this->input->post('name'),
			'group_desc'=>$this->input->post('desc'),
			'group_lvl'=>$level
		);
		
		$this->db->set('group_cdt', 'NOW()', FALSE);
		$this->db->set('group_cby', $this->session->userdata('uID'));
		$this->db->set($data);
		$this->db->insert(DBGRP);
		return $this->db->insert_id();
	}

	public function update()
	{
		$level = '';
		$auth_pages = $this->config->item('auth_pages');
		foreach($auth_pages as $key=>$val)
		{
			$level .= $val.'='.$this->input->post($val).',';
		}
		$level = substr_replace($level, '', -1);
		//print_r($level);exit();
		$data = array(
			'group_title'=>$this->input->post('name'),
			'group_desc'=>$this->input->post('desc'),
			'group_lvl'=>$level
		);
		//print_r($data);exit();
		
		$this->db->set('group_udt', 'NOW()', FALSE);
		$this->db->set('group_uby', $this->session->userdata('uID'));
		$this->db->set($data);
		$this->db->where('group_id', $this->input->post('id'));
		$this->db->update(DBGRP);
	}
	
	public function delete($id)
	{
		$this->db->where('group_id', $id);
		$this->db->delete(DBGRP);
		if($this->db->affected_rows()>0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/* helper */
	public function fetch_lvl($group_lvl)
	{		
		$array = explode(',', $group_lvl);
		$x = '';
		$newarray = array();

		foreach($array as $key=>$val)
		{
			$x = explode('=', $val);
			if(isset($x[0]) && $x[0] != '')
			{
				$newarray[ $x[0] ] = $x[1];
			}
		}
		
		return $newarray;
	}
		
} 
/* End of file Model_role.php */
/* Location: ./staff/model/Model_role.php */