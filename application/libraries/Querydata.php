<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Querydata {

    var $ci;

    function __construct() {
        $this->ci = & get_instance();
    }

    function data($requestData,$sql,$columnOrderBy,$defaultOrder=null)
	{
		$kolom = array();
        $kolom = $columnOrderBy;
		$totalData = $this->ci->db->query($sql)->num_rows();
		$totalFiltered = $totalData; 
    	if( !empty($requestData['search']['value']) ) {  
			//echo 'afs';
			$pertama = true;
			$f =0;
			foreach($kolom As $ff=>$nil)
            {
			  if($pertama)
			  {
			     $sql.=" AND ( ".$nil." LIKE '%".$requestData['search']['value']."%' ";   
			     $pertama = false;
			  }
			  else
			  {
				 $sql.=" OR ".$nil." LIKE '%".$requestData['search']['value']."%' ";
				    
			  }
			   $f++;
			  
              
			}
			$sql.=" )";
			
		}
		$columns = $columnOrderBy;
		
		
		$totalFiltered = $this->ci->db->query($sql)->num_rows(); 
		
		if($requestData['order'][0]['column'] > 0)
		{
		  $R = $requestData['order'][0]['column']-1;
		 
		  $sql.=" ORDER BY ". $columns[$R]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		}
		else
		{
		   
		   if($defaultOrder!=null)
		   {
			     $sql.=" ORDER BY ". $defaultOrder."     LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		   }
		   else	   
		   {
		        $R = $requestData['order'][0]['column'];
		        $sql.=" ORDER BY ". $columns[$R]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			   
		   }
		}

	    $query = $this->ci->db->query($sql)->result_array();
		//return array($query,$totalData,$totalFiltered,$kolom);
		return array($query,$totalData,$totalFiltered);
		
	}
	
	function dataPengiriman($requestData,$sql,$columnOrderBy,$defaultOrder=null)
	{
		$kolom = array();
        /*$dat2 ="";
		$findme    = 'from';
		$pos1 = stripos($sql, $findme);
		if ($pos1 === false) {
			echo "The string '$findme' was not found";
		}
		else
		{
		   $dtr =  substr($sql,0,$pos1);
		   $dtr2 =  trim(substr(trim($dtr),7,$pos1));
		 }
        $dat2 = explode(',',$dtr2);
		for($d=0; $d<count($dat2); $d++ )
		 {
					$sss = explode('AS',trim($dat2[$d]));
			   
					try {
					
					  if(isset($sss[1]))
					  {	  
						 
						  $kolom[$d] = trim($sss[1]);
					  }
					  else
						throw new Exception("Kesalahan");
					} catch (Exception $e) {
						 
						  $kolom[$d] = trim($sss[0]);					 
					}
					
			}
        */
 

       
        $kolom = $columnOrderBy;
        //print_r($kolom);
		$totalData = $this->ci->db->query($sql)->num_rows();
		$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
    	if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
			//echo 'afs';
			$pertama = true;
			$f =1;
			foreach($kolom As $ff=>$nil)
            {
			  if($pertama)
			  {
			    $sql.=" AND ( ".$nil." LIKE '%".$requestData['search']['value']."%' ";   
			    $pertama = false;
			  }
              
			  if(count($kolom)==$f)
			  {
			    $sql.=" )";
			  
			  }
			  else
			  {
			    $sql.=" OR ".$nil." LIKE '%".$requestData['search']['value']."%' ";
			  
			  }
			  $f++;
              
			}
			
		}
		$columns = $columnOrderBy;
		
		
		$totalFiltered = $this->ci->db->query($sql)->num_rows(); 
		
		if($requestData['order'][0]['column'] > 0)
		{
		  $R = $requestData['order'][0]['column']-1;
		 
		  $sql.=" ORDER BY ". $columns[$R]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		}
		else
		{
		   
		   if($defaultOrder!=null)
		   {
			     $sql.=" ORDER BY ". $defaultOrder."     LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		   }
		   else	   
		   {
		        $R = $requestData['order'][0]['column'];
		        $sql.=" ORDER BY ". $columns[$R]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			   
		   }
		}

	    $query = $this->ci->db->query($sql)->result_array();
		//return array($query,$totalData,$totalFiltered,$kolom);
		return array($query,$totalData,$totalFiltered);
		
	}
}
