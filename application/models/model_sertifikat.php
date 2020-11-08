<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_sertifikat extends CI_Model {
	
	var $datatable_json = array('id','code','nama_kapal','pemilik','pemohon','masa_berlaku','no_pengesahan','no_sertifikat','cdt');
	var $table_cols;
	var $table_json;
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('text');
		$this->table_cols = $this->config->item('sertifikat_cols');
		$this->table_json = $this->config->item('sertifikat_json');
	}
	
	// $param = array
	public function get($param)
	{
		$this->db->select($this->table_json);
		
		if(!empty($param['order']))
		{
			foreach($param['order'] as $key=>$val)
			{
				$this->db->order_by( $key, $val );	
			}
		}
		
		if(!empty($param['limit']))
		{
			$this->db->limit( $param['limit'] );	
		}
		
		$query = $this->db->get(DBSERTIFIKAT);
		if($query)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_all()
	{
		$this->db->select($this->table_cols);
		$query = $this->db->get(DBSERTIFIKAT);
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function get_datatable_json()
	{		
		$aColumns = $this->datatable_json;
		//customize here
		$sIndexColumn = "id";	
		$sTable = DBSERTIFIKAT;
	
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
				$sOrder = "";
			}
		}
		else
		{
			$sOrder = "ORDER BY cdt DESC";	
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
			$sWhere .= " AND  disahkan = 0";
		}
		else
		{
			$sWhere = "WHERE disahkan = 0";
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
			
			$detailUrl = site_url('sertifikat/detail/'.$aRow[$sIndexColumn]);
			$editUrl = site_url('sertifikat/e/'.$aRow[$sIndexColumn]);
			$deleteUrl = site_url('sertifikat/d/'.$aRow[$sIndexColumn]);
			if($this->model_session->auth_display('sertifikat', 1)):
			$button .= '<a href="'.$detailUrl.'" class="btn btn-mini" title="Detail"><i class="fam-book-go"></i></a>';
			endif;
			if($this->model_session->auth_display('sertifikat', 4)):
			$button .= '<a href="'.$editUrl.'" class="btn btn-mini btn-info" title="Edit" id="editBtn"><i class="fam-pencil"></i></a>';
			endif;
			if($this->model_session->auth_display('sertifikat', 5)):
			$button .= '<a href="'.$deleteUrl.'" class="btn btn-mini btn-danger" title="Hapus" id="deleteBtn" onClick="return confirm(\'Anda yakin akan menghapus data?\')"><i class="fam-bin-closed"></i></a>';
			endif;

			$row[] = $button;
			$row[] = $aRow['code'];
			$row[] = $aRow['nama_kapal'];
			$row[] = $aRow['pemilik'];
			$row[] = $aRow['pemohon'];
			$row[] = $aRow['masa_berlaku'];
			$row[] = $aRow['no_pengesahan'];
			$row[] = $aRow['no_sertifikat'];
			$row[] = $aRow['cdt'];
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	
    public function get_byID($id)
	{
		$this->db->select($this->table_cols);
		$this->db->select('id_s');
		$this->db->select('atc_filename, atc_desc');
		$this->db->join(DBATC_SERTIFIKAT, DBATC_SERTIFIKAT.'.id_s = '.DBSERTIFIKAT.'.id', 'left');
		$this->db->where('id', $id);
		$query = $this->db->get(DBSERTIFIKAT, 1);
		
		if($query->num_rows()>0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}		
	}
	
    public function get_by_code($code)
	{
		//$this->db->select($this->table_json);
		$this->db->select('*');
		$this->db->where('id', $code);
		$query = $this->db->get('ar_doc', 1);
		
		if($query->num_rows()>0)
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
		$this->db->join(DBATC_SERTIFIKAT, DBATC_SERTIFIKAT.'.id_s = '.DBSERTIFIKAT.'.id', 'left');
		$query = $this->db->get(DBSERTIFIKAT);
		
		if($query)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}		
	}
	
	public function get_all_by_id($array)
	{
		$this->db->select($this->table_cols);
		
		$data = array();
		if(!empty($array))
		{
			foreach($array as $key=>$val)
			{
				if($val=='on')
				{
					$str = str_replace("check_", '', $key);	
					array_push($data, $str);
				}
			}
		}
		else
		{
			return FALSE;
		}
		
		$this->db->where_in('id', $data);
		$query = $this->db->get(DBSERTIFIKAT);
		if($query)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	/* 
	param = string 
	return STRING
	*/
	public function get_statistic($param)
	{
		$statistic = FALSE;
		
		if($param=='monthly')
		{
			$total_days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
			$date_begin = date("Y-m-01 00:00:00");
			$date_end = date("Y-m-$total_days 23:59:59");
			
			$sql = "SELECT * FROM 
			(
				SELECT COUNT(id) as total, DATE_FORMAT(cdt, '%d') as cdt 
				FROM ".DBSERTIFIKAT." 
				WHERE cdt BETWEEN '$date_begin' AND '$date_end' 
				GROUP BY DATE_FORMAT(cdt, '%d/%m/%Y')
			) 
			AS T1";		
			$statistic = $this->db->query($sql);
		}
		
		if($statistic)
		{
			$array = range(1,$total_days);
			$array = array_fill(1, $total_days, 0);
			$row = $statistic->result_array();
			
			foreach($row as $key=>$val)
			{
				if( array_key_exists(intval($val['cdt']), $array) )
					$array[ intval($val['cdt']) ] = intval($val['total']);
			}
					
			return $array;
				
		}
		else
		{
			return FALSE;
		}

	}

	public function insert()
	{
		$this->load->model('model_json');
		$sah_id = $this->input->post('sah_id');
		
		$data = array(
					"nama_kapal" => $this->model_json->check_nama_kapal($this->input->post('nama_kapal')),
					"pemilik" => $this->model_json->check_pemilik_pemohon($this->input->post('pemilik'), DBDATA_PEMILIK),
					"pemohon" => $this->model_json->check_pemilik_pemohon($this->input->post('pemohon'), DBDATA_PEMOHON),
					"gt" => $this->input->post('gt'),
					"call_sign" => $this->input->post('call_sign'),
					"ukuran_panjang" => $this->input->post('ukuran_panjang'),
					"ukuran_lebar" => $this->input->post('ukuran_lebar'),
					"ukuran_dalam" => $this->input->post('ukuran_dalam'),
					"bahan" => $this->input->post('bahan'),
					"tempat_bahan_bakar" => $this->input->post('tempat_bahan_bakar'),
					"sub_tempat_bahan_bakar" => $this->input->post('sub_tipe_kapal'),
					"masa_berlaku" => reverse_date($this->input->post('masa_berlaku')),
					"no_pengesahan" => $this->input->post('no_pengesahan'),
					"tgl_pengesahan" => reverse_date($this->input->post('tgl_pengesahan')),
					"no_sertifikat" => $this->input->post('no_sertifikat'),
					"tgl_sertifikat" => reverse_date($this->input->post('tgl_sertifikat')),
					"jenis_sertifikat" => $this->input->post('jenis_sertifikat'),
					"pelabuhan_pendaftaran" => $this->model_json->sanitize_str($this->input->post('pelabuhan_pendaftaran')),
					"thn_pembangunan" => $this->input->post('thn_pembangunan'),
					"tgl_pemeriksa" => reverse_date($this->input->post('tgl_pemeriksa')),
					"lokasi_pemeriksa" => $this->model_json->sanitize_str($this->input->post('lokasi_pemeriksa')),
					"desc" => $this->input->post('desc'),
					"cby" => $this->session->userdata('uID'),
					"cdt" => date('Y-m-d H:i:s')
					);
		
		if($sah_id)
		{
			$data["sah_id"] = $sah_id;
			$data["pelabuhan_pendaftaran"] = $this->model_json->sanitize_str($this->input->post('pelabuhan_pendaftaran'));
			$data["tgl_pendaftaran"] = reverse_date($this->input->post('tgl_pendaftaran'));
		}
		
		$this->db->insert(DBSERTIFIKAT,$data);
		$insertID = $this->db->insert_id();
		
		$code = 'GM'.date('ym').str_pad($insertID,10,'0', STR_PAD_LEFT);

		$this->db->set('code', $code);
		$this->db->where('id', $insertID);
		$this->db->update(DBSERTIFIKAT);
		
		if($sah_id)
		{
			$this->db->set('is_sertifikat', 1);
			$this->db->where('id', $sah_id);
			$this->db->update(DBPENGESAHAN);	
		}
		else
		{
			$this->db->select('id');
			$this->db->where('nama_kapal', $data['nama_kapal']);
			$query = $this->db->get(DBPENGESAHAN, 1);
			
			if($query->num_rows()>0)
			{
				$this->db->set('is_sertifikat', 1);
				$this->db->where('nama_kapal', $data['nama_kapal']);
				$this->db->update(DBPENGESAHAN);
			}
		}
		
		return $insertID;
	}

	public function update()
	{
		$this->load->model('model_json');
		
		$data = array(
					"nama_kapal" => $this->model_json->check_nama_kapal($this->input->post('nama_kapal')),
					"pemilik" => $this->model_json->check_pemilik_pemohon($this->input->post('pemilik'), DBDATA_PEMILIK),
					"pemohon" => $this->model_json->check_pemilik_pemohon($this->input->post('pemohon'), DBDATA_PEMOHON),
					"gt" => $this->input->post('gt'),
					"call_sign" => $this->input->post('call_sign'),
					"ukuran_panjang" => $this->input->post('ukuran_panjang'),
					"ukuran_lebar" => $this->input->post('ukuran_lebar'),
					"ukuran_dalam" => $this->input->post('ukuran_dalam'),
					"bahan" => $this->input->post('bahan'),
					"tempat_bahan_bakar" => $this->input->post('tempat_bahan_bakar'),
					"sub_tempat_bahan_bakar" => $this->input->post('sub_tipe_kapal'),
					"masa_berlaku" => reverse_date($this->input->post('masa_berlaku')),
					"no_pengesahan" => $this->input->post('no_pengesahan'),
					"tgl_pengesahan" => reverse_date($this->input->post('tgl_pengesahan')),
					"no_sertifikat" => $this->input->post('no_sertifikat'),
					"tgl_sertifikat" => reverse_date($this->input->post('tgl_sertifikat')),
					"jenis_sertifikat" => $this->input->post('jenis_sertifikat'),
					"pelabuhan_pendaftaran" => $this->model_json->sanitize_str($this->input->post('pelabuhan_pendaftaran')),
					"thn_pembangunan" => $this->input->post('thn_pembangunan'),
					"tgl_pemeriksa" => reverse_date($this->input->post('tgl_pemeriksa')),
					"lokasi_pemeriksa" => $this->model_json->sanitize_str($this->input->post('lokasi_pemeriksa')),
					"desc" => $this->input->post('desc'),
					"uby" => $this->session->userdata('uID'),
					"udt" => date('Y-m-d H:i:s')
					);
	
		$this->db->set($data);
		$this->db->where('id', $this->input->post('id'));
		$this->db->update(DBSERTIFIKAT);
	}

	public function delete($id)
	{
		$this->db->select($this->table_json);
		$this->db->where('id', $id);
		$row = $this->db->get(DBSERTIFIKAT);
		
		if($row)
		{
			$row = $row->row();
			$this->db->where('id', $id);
			$this->db->delete(DBSERTIFIKAT);
			
			if($this->db->affected_rows()>0)
			{
				$this->db->set('is_sertifikat', 0);
				$this->db->where('id', $row->sah_id);
				$this->db->delete(DBPENGESAHAN);
				
				$this->load->model('model_atc');
				$file = $this->model_atc->deleteAllAtc($id, DBATC_SERTIFIKAT);	
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	public function search($post)
	{
		$records = NULL;
		$return = 0;
		
		$this->db->select($this->table_cols);
		$this->db->select(DB_C_FUEL.'.title AS tipe_kapal, '.DB_C_BAHAN.'.title AS bahan_kapal', FALSE);
		$this->db->join(DB_C_FUEL, DB_C_FUEL.'.id = '.DBSERTIFIKAT.'.tempat_bahan_bakar');
		$this->db->join(DB_C_BAHAN, DB_C_BAHAN.'.id = '.DBSERTIFIKAT.'.bahan');
		
		foreach($post as $key=>$val)
		{
			$val = str_replace(array('["', '"]'), '', $val);
			$val = str_replace(array('[', ']'), '', $val);
			if($val) 
			{
				$this->db->where($key, $val);
				$return++;
			}
		}
		
		if($return>0)
		{
			$query = $this->db->get(DBSERTIFIKAT);
			if($query)
			{
				$records = $query->result_array();
			}
		}
		
		return $records;
	}
	
	public function get_reminder()
	{
		$this->db->select('id, code, nama_kapal, pemilik, pemohon, masa_berlaku, cdt');
		$this->db->join(DBREMINDER, DBREMINDER.'.doc_id = '.DBSERTIFIKAT.'.id');
		$this->db->where('snooze', 1);
		$query = $this->db->get(DBSERTIFIKAT, 20);
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	public function snooze_reminder($id)
	{
		$this->db->select('reminder_id');
		$this->db->where('doc_id', $id);
		$query = $this->db->get(DBREMINDER, 1);
		if($query)
		{
			$this->db->set('snooze', 0);
			$this->db->where('doc_id', $id);
			$this->db->update(DBREMINDER);
		}
		return TRUE;
	}
	
	public function vcnt($id)
	{
		$this->db->set('vcnt', 'vcnt+1', FALSE);
		$this->db->where('id', $id);
		$this->db->update(DBSERTIFIKAT);
	}
	
		
} 
/* End of file Model_sertifikat.php */
/* Location: ./application/model/Model_sertifikat.php */