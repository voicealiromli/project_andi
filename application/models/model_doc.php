<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_doc extends CI_Model {
	
	var $datatable_json = array('id','no','title','cat_id','borw','cmpl','date','vcnt','ab','sap','od','fe','laci','hm','page','desc','flag');
	var $table_cols;
	var $table_json;
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('text');
		$this->table_cols = $this->config->item('doc_cols');
		$this->table_json = $this->config->item('doc_json');
	}
	
	public function get_all()
	{
		$this->db->select($this->table_cols);
		$query = $this->db->get(DBDOC);
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	/*public function get_all_user($id)
	{
		$this->db->where('doc_id',$id);
		$this->db->select('*');
		$query = $this->db->get(DBCHK);
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}*/
	public function get_datatable_json()
	{		
		$aColumns = $this->datatable_json;
		//customize here
		$sIndexColumn = "id";	
		$sTable = DBDOC;
		$joinCols = 'category_name';
		$joinCols2 = 'department_name';
		$joinQuery = "LEFT JOIN ".DBCAT." ON ".DBCAT.".categoryID = ".$sTable.".cat_id";
		$joinQuery2 = "LEFT JOIN ".DBDEPT." ON ".DBDEPT.".departmentID = ".$sTable.".department_id";
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
				$sOrder = "ORDER BY date DESC";
			}
		}
		else
		{
			$sOrder = "ORDER BY date DESC";	
		}
	
		$sWhere = " ";
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
			SELECT SQL_CALC_FOUND_ROWS `$joinCols`,`$joinCols2`, `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$joinQuery
			$joinQuery2
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
			
			$editUrl = site_url('doc/e/'.$aRow[$sIndexColumn]);
			$deleteUrl = site_url('doc/d/'.$aRow[$sIndexColumn]);
			if($this->model_session->auth_display('document', 3)):
			$button .= '<a href="'.$editUrl.'" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a> ';
			endif;
			if($this->model_session->auth_display('document', 4)):
			$button .= '<a href="'.$deleteUrl.'" class="btn btn-mini btn-danger" title="Hapus" id="deleteBtn" onClick="return confirm(\'Anda yakin akan menghapus data?\')"><i class="icon-trash icon-white"></i></a>';
			endif;
			
			if($aRow['borw']== 1){
				$borrow = '<span class="label label-warning">Dipinjam</span>';
			}else{
				$borrow = '<span class="label label-success">Tidak Dipinjam</span>';
			}
			
			if($aRow['cmpl']== 0){
				$complete = '<span class="label label-warning">Tidak Lengkap</span>';
			}else{
				$complete = '<span class="label label-success">Lengkap</span>';
			}
			
			if($aRow['department_id'] == $this->session->userdata('uDepartment')){
			$row[] = $button;
			$row[] = $aRow['no'];
			$row[] = $aRow['title'];
			$row[] = $aRow['category_name'];
			$row[] = reverse_date($aRow['date']);
			$row[] = $borrow;
			$row[] = $complete;
			//$row[] = (($aRow['vcnt']>0)?$aRow['vcnt']:NULL);
			$output['aaData'][] = $row;
			}
		}
		
		echo json_encode( $output );
	}
	
	public function get_datatable_json_superAdmin()
	{
		$aColumns = $this->datatable_json;
		//customize here
		$sIndexColumn = "id";
		$sTable = DBDOC;
		$joinCols = 'category_name';
		$joinCols2 = 'atc_filename';
		$joinQuery = "LEFT JOIN ".DBCAT." ON ".DBCAT.".categoryID = ".$sTable.".cat_id";
		$joinQuery2 = "LEFT JOIN ".DBATC." ON ".DBATC.".id_s = ".$sTable.".id";
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
				$sOrder = "ORDER BY date DESC";
			}
		}
		else
		{
			$sOrder = "ORDER BY date DESC";	
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
			SELECT SQL_CALC_FOUND_ROWS `$joinCols`,`$joinCols2`, `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$joinQuery
			$joinQuery2
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
			$editUrl = site_url('doc/e/'.$aRow[$sIndexColumn]);
			$deleteUrl = site_url('doc/d/'.$aRow[$sIndexColumn]);					
			if($this->model_session->auth_display('document', 3)):
			$button .= '<a href="'.$editUrl.'" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a> ';
			else:
			$viewUrl = site_url('doc/detail/'.$aRow[$sIndexColumn]);	
			$button .= '<a href="'.$viewUrl.'" class="btn btn-mini" title="view"><i class="icon-eye-open"></i></a> ';
			endif;
			if($this->model_session->auth_display('document', 4)):
			$button .= '<a href="'.$deleteUrl.'" class="btn btn-mini btn-danger" title="Hapus" id="deleteBtn" onClick="return confirm(\'Anda yakin akan menghapus data?\')"><i class="icon-trash icon-white"></i></a>';
			endif;
			
			$fileAtc = explode('_', $aRow['atc_filename']);
			if($fileAtc[0] == 'sertipikat'){
				$ser = '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
			}else{
				$ser = '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
			}
			
			if($fileAtc[0] == 'PH'){
				$ph = '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
			}else{
				$ph = '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
			}
			
			if($fileAtc[0] == 'KUM'){
				$kum = '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
			}else{
				$kum = '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
			}
			
			if($fileAtc[0] == 'AJB'){
				$ajb = '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
			}else{
				$ajb = '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
			}
			
			if($fileAtc[0] == 'PK'){
				$pk = '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
			}else{
				$pk = '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
			}
			
			if($fileAtc[0] == 'SKMHT'){
				$skmht = '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
			}else{
				$skmht = '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
			}
			
			if($fileAtc[0] == 'IMB'){
				$imb = '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
			}else{
				$imb = '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
			}
			
			if($fileAtc[0] == 'APHT'){
				$apht = '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
			}else{
				$apht = '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
			}
			
			if($fileAtc[0] == 'SHT'){
				$sht = '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
			}else{
				$sht = '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
			}
			
			if($aRow['borw']== 1){
				$borrow = '<span class="label label-warning">Dipinjam</span>';
			}else{
				$borrow = '<span class="label label-success">Tidak Dipinjam</span>';
			}
			
			$row[] = $button;
			$row[] = $aRow['no'];
			$row[] = $aRow['title'];
			$row[] = $ph;
			$row[] = $kum;
			$row[] = $pk;
			$row[] = $ajb;
			$row[] = $skmht;
			$row[] = $imb;
			$row[] = $apht;
			$row[] = $sht;
			$row[] = $ser;
			$row[] = $borrow;
			//$row[] = (($aRow['vcnt']>0)?$aRow['vcnt']:NULL);
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	
	public function get_datatable_json_filter()
	{
		$aColumns = $this->datatable_json;
		//customize here
		$sIndexColumn = "id";	
		$sTable = DBDOC;
		$joinCols = 'category_name';
		$joinCols2 = 'department_name';
		$joinQuery = "LEFT JOIN ".DBCAT." ON ".DBCAT.".categoryID = ".$sTable.".cat_id";
		$joinQuery2 = "LEFT JOIN ".DBDEPT." ON ".DBDEPT.".departmentID = ".$sTable.".department_id";
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
				$sOrder = "ORDER BY date DESC";
			}
		}
		else
		{
			$sOrder = "ORDER BY date DESC";	
		}
	
		$sWhere = "WHERE cat_id = ".$this->uri->segment(3)."";
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
					$sWhere = "WHERE";
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
			SELECT SQL_CALC_FOUND_ROWS `$joinCols`,`$joinCols2`, `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$joinQuery
			$joinQuery2
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
			$editUrl = site_url('doc/e/'.$aRow[$sIndexColumn]);
			$deleteUrl = site_url('doc/d/'.$aRow[$sIndexColumn]);					
			if($this->model_session->auth_display('document', 3)):
			$button .= '<a href="'.$editUrl.'" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a> ';
			else:
			$viewUrl = site_url('doc/detail/'.$aRow[$sIndexColumn]);	
			$button .= '<a href="'.$viewUrl.'" class="btn btn-mini" title="view"><i class="icon-eye-open"></i></a> ';
			endif;
			if($this->model_session->auth_display('document', 4)):
			$button .= '<a href="'.$deleteUrl.'" class="btn btn-mini btn-danger" title="Hapus" id="deleteBtn" onClick="return confirm(\'Anda yakin akan menghapus data?\')"><i class="icon-trash icon-white"></i></a>';
			endif;		
			
			$row[] = $button;
			$row[] = $aRow['no'];
			$row[] = $aRow['title'];
			$row[] = '<span class="label label-warning">'.$aRow['category_name'].'</span>';
			$row[] = '<span class="label label-success">'.$aRow['source'].'</span>';		
			//$row[] = reverse_date($aRow['date']);		
			$row[] = $aRow['date'];		
			$row[] = (($aRow['vcnt']>0)?$aRow['vcnt']:NULL);			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	
    public function get_byID($id)
	{
		$this->db->select('*');
		$this->db->select('id_s');
		$this->db->select('atc_filename');
		$this->db->join(DBATC, DBATC.'.id_s = '.DBDOC.'.id', 'left');
		$this->db->where('id', $id);
		$query = $this->db->get(DBDOC, 1);
		
		if($query->num_rows()>0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}		
	}

	/* get by id, json column*/
	public function get_byid_json($id)
	{
		$this->db->select('*');
		$this->db->limit(1);
		$query = $this->db->get_where(DBUSR, array('docID' => $id));
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_all_files()
	{
		$this->db->select($this->table_json);
		$this->db->select('atc_id, id_s, atc_filename, atc_desc, atc_rawname, atc_ext, atc_path');
		$this->db->join(DBATC, DBATC.'.id_s = '.DBDOC.'.id', 'left');
		$query = $this->db->get(DBDOC);
		
		if($query)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}		
	}
	
	
	public function insert()
	{
				
		$data = array(
						'ctr'=>$this->input->post('ctr'), // jenis dokumen
						'no'=>$this->input->post('no'), // No Polis
						'klien'=>$this->input->post('name'), // klien
						'cyear'=>$this->input->post('thn'), // thn
						'cdt'=>date('d-m-Y'),				// created_at
						'lemari'=>$this->input->post('sap'), // isian ga ada
						'laci'=>$this->input->post('od'),	// isian ga ada
						'box'=>$this->input->post('ab'),   // isian ga ada 
					);
	
		$this->db->insert('nasabah',$data);	
		$insertID = $this->db->insert_id();
		return $insertID;
	}
	
	public function update()	
	{
		// if($this->session->userdata('uDepartment') == 0){
				// $unit = $this->input->post('department');	
		// }else{
				// $unit = $this->session->userdata('uDepartment');
		// }
		$data = array(
						'ctr'=>$this->input->post('ctr'),	// jenis dokumen
						'no'=>$this->input->post('no'),		// No Polis
						'klien'=>$this->input->post('name'), // Nama Debitur
						'cyear'=>$this->input->post('thn'),	 // tahun	
						'box'=>$this->input->post('ab'),		// box
						'lemari'=>$this->input->post('sap'),	// blok
						'laci'=>$this->input->post('od')		// rak/ laci
					);
	
		$this->db->where('idn', $this->input->post('id'));
		$this->db->set($data);
		$this->db->update('nasabah');
	}
	
	public function c($id,$uri)
	{	
		$data = array(
	
						'flag'=>$id
					);
	
		$this->db->where('id',$uri);
		$this->db->set($data);
		$this->db->update(DBDOC);
	}
	
	public function delete($id)
	{
		$this->db->where('idn', $id);
		$this->db->delete('nasabah');
		if($this->db->affected_rows()>0)
		{
			$this->load->model('model_atc');
			$file = $this->model_atc->deleteAllAtc($id);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}	
	
	public function vcnt($id)
	{
		$this->db->set('vcnt', 'vcnt+1', FALSE);
		$this->db->where('id', $id);
		$this->db->update(DBDOC);
	}
	
	public function search()
	{
		$no = $this->input->post('no');
		$title = $this->input->post('title');
		$category = $this->input->post('category');
		$sd = search_date($this->input->post('bdate'));
		$ed = search_date($this->input->post('edate'));

		if(! empty($no))
		{
			$this->db->where('no',$no);
		}
		
		if(! empty($title))
		{
			$this->db->like('title',$title);
		}		
				
		if(! empty($category))
		{
			$this->db->where('cat_id',$category);
		}
		
		if(! empty($sd ))
		{
			$this->db->where('date >= ',$sd);
		}
		
		if(! empty($ed ))
		{
			$this->db->where('date <= ',$ed);
		}
		
		$data = $this->db->get('ar_doc')->result();
		//print_r($data);exit;
		return $data;
	}
	
	public function search_file()
	{
		$atc = $this->input->post('atc');
		$sd = search_date($this->input->post('bdate'));
		$ed = search_date($this->input->post('edate'));

		if(! empty($atc))
		{
			//$this->db->where('atc_filename',$atc);
			$this->db->like('atc_filename', $atc); 
		}
		
		if(! empty($sd ))
		{
			$this->db->where('atc_cdt >= ',$sd);
		}
		
		if(! empty($ed ))
		{
			$this->db->where('atc_cdt <= ',$ed);
		}
		
		$data = $this->db->get('ar_atc')->result();
		//print_r($data);exit;
		return $data;
	}
	/*public function insert_user()
	{	
		$data = array(
						'check_name'=>$this->input->post('name'),
						'check_status'=>$this->input->post('status'),
						'check_cdt'=>date('Y-m-d H:i:s'),
						'doc_id'=>$this->input->post('id'),
						'check_cby'=>$this->session->userdata('uID'),							
					);
	
		$this->db->insert(DBCHK,$data);	
		$insertID = $this->db->insert_id();
		return $insertID;
	}
	public function deleteuser($id)
	{
		$this->db->where('checkID', $id);
		$this->db->delete(DBCHK);
		if($this->db->affected_rows()>0)
		{			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	*/
	
		
} 
/* End of file Model_doc.php */
/* Location: ./application/model/Model_doc.php */