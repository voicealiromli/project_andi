<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_category extends CI_Model {
	
	var $datatable_json = array('categoryID','category_name','category_desc','category_cdt');
	var $table_cols;
	var $table_json;
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('text');
		$this->table_cols = $this->config->item('cat_cols');
		$this->table_json = $this->config->item('cat_json');
	}
	
	public function get_datatable_json()
	{
		$aColumns = $this->datatable_json;
		//customize here
		$sIndexColumn = "categoryID";	
		$sTable = DBCAT;
	
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
				$sOrder = "ORDER BY categoryID ASC";
			}
		}
		else
		{
			$sOrder = "ORDER BY categoryID ASC";	
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
		
		// customize, added $joinQuery var name
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
			$button = '';
			
			$editUrl = site_url('category/e/'.$aRow[$sIndexColumn]);
			$deleteUrl = site_url('category/d/'.$aRow[$sIndexColumn]);
			if($this->model_session->auth_display('document', 3)):
			$button .= '<a href="'.$editUrl.'" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a> ';
			endif;
			if($this->model_session->auth_display('document', 4)):
			$button .= '<a href="'.$deleteUrl.'" class="btn btn-mini btn-danger" title="Hapus" id="deleteBtn" onClick="return confirm(\'Are you sure ?\')"><i class="icon-trash icon-white"></i></a>';
			endif;
			
			$row[] = $button;			
			$row[] = $aRow['category_name'];
			$row[] = $aRow['category_desc'];
			$row[] = $aRow['category_cdt'];						
			$output['aaData'][] = $row;
		}
		echo json_encode( $output );
	}
	
	
	public function get_all()
	{
		$this->db->select('categoryID,category_name');
		$this->db->order_by("categoryID", "ASC"); 
		$query = $this->db->get(DBCAT);
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	/* get by id, json column*/
	public function get_byid($id)
	{
		$this->db->select($this->table_cols);
		$this->db->limit(1);
		$this->db->where('categoryID' , $id);
		$query = $this->db->get(DBCAT);
		if ($query->num_rows() > 0)
		{
			return $query;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function insert()
	{	
		$data = array(
						'category_name'=>$this->input->post('name'),						
						'category_desc'=>$this->input->post('desc'),
						'category_cby'=> $this->session->userdata('uID'),
						'category_cdt'=>date('Y-m-d H:i:s')

					);
	
		$this->db->insert(DBCAT,$data);	
		$insertID = $this->db->insert_id();
		return $insertID;
	}
	
	public function update()
	{	
	$data = array(
						'category_name'=>$this->input->post('name'),						
						'category_desc'=>$this->input->post('desc'),
						'category_cby'=> $this->session->userdata('uID'),
						'category_cdt'=>date('Y-m-d H:i:s')
					);

		$this->db->where('categoryID', $this->input->post('id'));
		$this->db->set($data);
		$this->db->update(DBCAT);
	}
	
	public function delete($id)
	{
		$this->db->where('categoryID', $id);
		$this->db->delete(DBCAT);
		return TRUE;
	}
	
		
} 
/* End of file Model_doc.php */
/* Location: ./application/model/Model_doc.php */