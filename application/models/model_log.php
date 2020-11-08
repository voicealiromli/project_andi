<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_log extends CI_Model {
	
	var $datatable_json = array('log_date','ID_user','log_name','log_ip','log_agent','log_type','log_activity','log_ID');
	var $visitor_datatable_json = array('log_date','log_ip','log_agent','log_type','log_activity','log_ID');

	public function __construct()
	{
			parent::__construct();
	}
		
	function escapeString($val) {
		$db = get_instance()->db->conn_id;
		$val = mysqli_real_escape_string($db, $val);
		return $val;
	}
	
	public function get_admin_datatable_json()
	{		
		$aColumns = $this->datatable_json;
		$sIndexColumn = "log_ID";		
		$sTable = DBLOG;
		$joinCols = 'userFname';
		$joinQuery = "LEFT JOIN ".DBUSR." ON ".DBUSR.".userID = ".$sTable.".ID_user";
	
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

		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS `$joinCols`, `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$joinQuery
			$sWhere 
			$sOrder
			$sLimit
			";
		/* $rResult = mysql_query( $sQuery );
		
		$sQuery = "
			SELECT FOUND_ROWS()
		";
		$rResultFilterTotal = mysql_query( $sQuery );
		$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
		
		$sQuery = "
			SELECT COUNT(`".$sIndexColumn."`)
			FROM   $sTable
		";
		$rResultTotal = mysql_query( $sQuery );
		$aResultTotal = mysql_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0]; */		
		
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
		
		// echo "<pre>";
		// var_dump($result);exit;
		//while ( $aRow = mysql_fetch_array( $rResult ) )
		foreach( $result as $aRow )
		{
			$row = array();
			
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if( $aColumns[$i] == 'ID_user' )
				{
					$row[] = $aRow->userFname;
				}
				else if( $aColumns[$i] == 'log_agent' )
				{
					$row[] = substr($aRow->log_agent, 0, 30).( (strlen($aRow->log_agent)>30)?' ...':NULL );
				}
				else if( $aColumns[$i] == 'log_activity' )
				{
					$row[] = substr($aRow->log_activity, 0, 30).( (strlen($aRow->log_activity)>30)?' ...':NULL );
				}
				else if( $aColumns[$i] == 'log_ID' )
				{
					$row[] = '<a href="'.site_url('log/e_a_log/'.$aRow->log_ID).'"><i class="icon-search"></i></a>';
				}
				else if( $aColumns[$i] == 'log_date' )
				{
					$row[] = '<a href="'.site_url('log/e_a_log/'.$aRow->log_date).'">'.date('d-M-Y h:i', mysql_to_unix($aRow->log_date)).'</a>';
				}
				else 
				{
					// general output
					$row[] = $aRow->log_name.", ip = ".$aRow->log_ip;
				}
			}
			$output['aaData'][] = $row;
			
		}
		
		echo json_encode( $output );
		
	}	
	
	// Utility to Flush
	public function admin_flush_log()
	{
		if($this->db->truncate(DBLOG))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function get_visitor_datatable_json()
	{		
		$aColumns = $this->visitor_datatable_json;		
		$sIndexColumn = "log_ID";		
		$sTable = DBVISITOR_LOG;
	
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
				intval( $_GET['iDisplayLength'] );
		}
		
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
						mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "ORDER BY log_date DESC";
			}
		}
	
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
				{
					$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
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
				$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
			}
		}

		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$sWhere 
			$sOrder
			$sLimit
			";
		$rResult = mysql_query( $sQuery );
		
		$sQuery = "
			SELECT FOUND_ROWS()
		";
		$rResultFilterTotal = mysql_query( $sQuery );
		$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
		
		$sQuery = "
			SELECT COUNT(`".$sIndexColumn."`)
			FROM   $sTable
		";
		$rResultTotal = mysql_query( $sQuery );
		$aResultTotal = mysql_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];

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
		
		while ( $aRow = mysql_fetch_array( $rResult ) )
		{
			$row = array();
			
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if( $aColumns[$i] == 'log_agent' )
				{
					$row[] = substr($aRow[ $aColumns[$i] ], 0, 30).( (strlen($aRow[$aColumns[$i]])>30)?' ...':NULL );
				}
				else if( $aColumns[$i] == 'log_activity' )
				{
					$row[] = substr($aRow[ $aColumns[$i] ], 0, 30).( (strlen($aRow[$aColumns[$i]])>30)?' ...':NULL );
				}
				else if( $aColumns[$i] == 'log_ID' )
				{
					$row[] = '<a href="'.site_url('log/e_v_log/'.$aRow[ 'log_ID' ]).'"><i class="icon-search"></i></a>';
				}
				else if( $aColumns[$i] == 'log_date' )
				{
					$row[] = '<a href="'.site_url('log/e_v_log/'.$aRow[ 'log_ID' ]).'">'.date('d-M-Y h:i', mysql_to_unix($aRow[$aColumns[$i]])).'</a>';
				}
				else 
				{
					// general output
					$row[] = $aRow[ $aColumns[$i] ];
				}
			}
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
		
	}
	
	// Utility to Flush
	public function visitor_flush_log()
	{
		if($this->db->truncate(DBVISITOR_LOG))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	
	
}
/* End of file Model_log.php */
/* Location: ./_app/model/Model_log.php */