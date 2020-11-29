<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_doc extends CI_Model {
	
	var $datatable_json = array('id','no','title','cat_id','borw','cmpl','date','vcnt','ab','sap','od','fe','laci','hm','page','desc','flag');
	var $datatable_json_folder = array('id_folder','id_nasabah','nama_folder','blok','rak','box');
	var $datatable_json_doc = array('idn','no','klien','ctr','box','lemari','laci','cyear','cdt','cby');
	var $datatable_json_file = array('id_dokumen_file','nama_dokumen','nama_file','id_folder');
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
						// 'lemari'=>$this->input->post('sap'), // isian ga ada
						// 'laci'=>$this->input->post('od'),	// isian ga ada
						// 'box'=>$this->input->post('ab'),   // isian ga ada 
						//'lemari'=>'0', // isian ga ada
						//'laci'=>'0',	// isian ga ada
						//'box'=>'0',   // isian ga ada 
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
			
			/* add alay */
			$fs = $this->db->query("select * from folder where id_nasabah='$id'")->result_array();
			foreach($fs as $row)
			{
				$id_f = $row['id_folder'];
				$fss = $this->db->query("select * from dokumen_file where id_folder='$id_f'")->result_array();
				foreach($fss as $r)
				{
					//$this->db->where('idn', $id);
					//$this->db->delete('nasabah');
					unlink(realpath(DATA_VIEW.$r->nama_file.'.pdf'));
				}
				$this->db->where('id_folder', $id_f);
			    $this->db->delete('dokumen_file');
			}
			/* end alay */
			
			
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
	
	public function get_datatable_json_folder()
	{		
		$aColumns = $this->datatable_json_folder;
		
		$sIndexColumn = "id_folder";	
		$sTable = 'folder';
		$joinCols = null;//'group_title';
		$joinQuery = '';//"LEFT JOIN ".DBGRP." ON ".DBGRP.".group_id = ".$sTable.".group_id";
	
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
		$sWhere .= "where id_nasabah = ".$_GET['idn']."";
		// customize, added $joinQuery var name //`$joinCols`,
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS  `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$joinQuery
			$sWhere
			$sOrder
			$sLimit
			";
		 		
		$rResult = $this->db->query($sQuery);
		$result = $rResult->result();//`$joinCols`,
		$sQueryC = "
			SELECT SQL_CALC_FOUND_ROWS  `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
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
		
		
		//print_r($result);
		
		foreach( $result as $aRow )
		{
			
			
			$row = array();
			$button = '';
			
			$editUrl = site_url('user/e/'.$aRow->id_folder );
			$arsip  = 'arsip';
			$fol =  'folder';
			//$deleteUrl = site_url('user/d/'.$aRow->id_folder );
			$file = site_url('doc/file/'.$aRow->id_folder.'/'.$arsip.'/'.$fol);
			
			$button .= '<a class="btn btn-mini" id="open-edit" data="'.$aRow->id_folder.'"><i class="icon-pencil"></i> </a> ';
		    $button .= '<a href="#" class="btn btn-mini btn-danger" id="deleteBtn" data="'.$aRow->id_folder.'" ><i class="icon-trash icon-white"></i> </a>';
			$button .= '<a href="'.$file.'" class="btn btn-mini default" id="file-input">File </a>';
			
			// $row[] = $button;
			$row[] = $aRow->id_folder;
			$row[] = $aRow->nama_folder;
			$row[] = $aRow->blok;
			$row[] = $aRow->box;
			$row[] = $aRow->rak;
			//$row[] = ($aRow->userFlag)?'Aktif':'Non-Aktif';
			//$row[] = $aRow->group_title;
			$row[] = $button;
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
		
	}
	function escapeString($val) {
		$db = get_instance()->db->conn_id;
		$val = mysqli_real_escape_string($db, $val);
		return $val;
	}
	/* doc */
	public function get_datatable_json_doc()
	{		
		$aColumns = $this->datatable_json_doc;
		
		$sIndexColumn = "idn";	
		$sTable = 'nasabah';
		$joinCols = null;//'group_title';
		$joinQuery = '';//"LEFT JOIN ".DBGRP." ON ".DBGRP.".group_id = ".$sTable.".group_id";
	
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
		//$sWhere = "id_nasabah = ".$_GET['idn']."";
		//$sWhere = "id_nasabah = '122090'";
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
		
		// customize, added $joinQuery var name //`$joinCols`,
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS  `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$joinQuery
			$sWhere
			$sOrder
			$sLimit
			";
	   
			
		$rResult = $this->db->query($sQuery);
		$result = $rResult->result();//`$joinCols`,
		$sQueryC = "
			SELECT SQL_CALC_FOUND_ROWS  `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
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
		
		$no = $_GET['iDisplayStart'] + 1;
		foreach( $result as $aRow )
		{
			
			
			$row = array();
			$button = '';
			
			$editUrl = site_url('doc/dk/'.$aRow->idn );
			$deleteUrl = site_url('doc/d/'.$aRow->idn );
			$folder = site_url('doc/folder/'.$aRow->idn );
			
			$button .= '<a href="'.$editUrl.'" class="btn btn-mini"><i class="icon-pencil"></i> </a> ';
			$button .= '<a href="'.$deleteUrl.'" class="btn btn-mini btn-danger" id="deleteBtn" onClick="return confirm(\'You are sure to delete the data?\')"><i class="icon-trash icon-white"></i> </a>';
			$button .= '<a href="'.$folder.'" class="btn btn-mini default" id="file-input">Folder </a>';
			
			// $row[] = $button;
			$row[] = $no;//$aRow->idn;
			$row[] = $aRow->no;
			$row[] = $aRow->klien;
			//$row[] = $aRow->lemari;
			//$row[] = $aRow->laci;
			//$row[] = $aRow->cyear;
			$row[] = $aRow->cdt;
			$row[] = $aRow->cby;
			$row[] = $aRow->cby;
			$row[] = $aRow->cby;
			//$row[] = ($aRow->userFlag)?'Aktif':'Non-Aktif';
			//$row[] = $aRow->group_title;
			$row[] = $button;
			$output['aaData'][] = $row;
			
			$no++;
		}
		
		/*
		
		<td>
					<a href="<?php echo site_url('doc/dk/'.$row->idn);?>" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a>
                    <?php if ($this->model_session->auth_display('document', 3)): ?>
					<a href="<?php echo site_url('doc/p/'.$row->idn);?>" class="btn btn-mini btn-warning" title="Print Barcode" target="_blank"><i class="icon-barcode icon-white"></i></a>
					<a href="<?php echo site_url('doc/d/'.$row->idn);?>" class="btn btn-mini btn-danger" title="Hapus" id="deleteBtn" onClick="return confirm(\'Anda yakin akan menghapus data?\')"><i class="icon-trash icon-white"></i></a>
                    <?php endif; ?>			
				</td>
				<td><?php echo $row->no;?></td>
				<td><?php echo $row->klien;?></td>
				<td><?php echo $row->ctr;?></td>
				<td><?php echo $row->box;?></td>
				<td><?php echo $row->lemari;?></td>
				<td><?php echo $row->laci;?></td>
				<td><?php echo $row->cyear;?></td>
				<td><?php echo $row->cdt;?></td>
				<td><?php echo $row->cby;?></td>
				<td><a href="<?php echo site_url('doc/folder/'.$row->idn) ?>" class="btn btn-mini default">Folder</a></td>
		
		*/
		
		echo json_encode( $output );
		
	}
	
	public function get_datatable_json_file()
	{		
		$aColumns = $this->datatable_json_file;
		
		$sIndexColumn = "id_dokumen_file";	
		$sTable = 'dokumen_file';
		$joinCols = null;//'group_title';
		$joinQuery = '';//"LEFT JOIN ".DBGRP." ON ".DBGRP.".group_id = ".$sTable.".group_id";
	
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
		$sWhere .= "where id_folder = ".$_GET['idfolder']."";
		// customize, added $joinQuery var name //`$joinCols`,
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS  `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
			FROM   $sTable
			$joinQuery
			$sWhere
			$sOrder
			$sLimit
			";
		 		
		$rResult = $this->db->query($sQuery);
		$result = $rResult->result();//`$joinCols`,
		$sQueryC = "
			SELECT SQL_CALC_FOUND_ROWS  `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
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
		
		
		//print_r($result);
		
		foreach( $result as $aRow )
		{
			
			
			$row = array();
			$button = '';
			
			$button .= '<a class="btn btn-mini" id="open-edit" data="'.$aRow->id_dokumen_file.'"><i class="icon-pencil"></i> </a> ';
			$button .= '<a href="#" class="btn btn-mini btn-danger" id="deleteBtn" data="'.$aRow->id_dokumen_file.'" ><i class="icon-trash icon-white"></i> </a>';
			$button .= '<a href="#" class="btn btn-mini default" id="btn-view-dok" data="'.$aRow->id_dokumen_file.'">View File </a>'.$this->modalViewPdf($aRow->id_dokumen_file,$aRow->nama_dokumen,$aRow->nama_file).'';
			
			// $row[] = $button;
			$row[] = $aRow->id_dokumen_file;
			$row[] = $aRow->nama_dokumen;
			
			$row[] = $button;
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
		
	}
	
	public function modalViewPdf($id,$file,$dokumen)
	{
		 $ss = '<div id="myModal'.$id.'" class="modal fade myModal" role="dialog">
					 <div class="modal-dialog modal-lg">
						 <div class="modal-content">
							 <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								 <h4 class="modal-title">'.$file.'</h4>
							 </div>
							 <div class="modal-body">
								 <embed  src="'.base_url().'/uploads/'.$dokumen.'.pdf" frameborder="0" width="100%" height="400px"/>
								 <div class="modal-footer">
									 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								 </div>
							 </div>
						 </div>
					</div>
				 </div>';
		return $ss;
	}
		
} 
/* End of file Model_doc.php */
/* Location: ./application/model/Model_doc.php */