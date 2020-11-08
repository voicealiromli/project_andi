<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upzip extends CI_Controller {

	var $folder = 'upzip/';
	
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
		$this->load->library('unzip');
		$this->model_session->check_login(NULL, 'login');
		$this->form_validation->set_error_delimiters('<div class="help-inline important">', '</div>');
    }
	
    public function file()
    {
		$data['layout'] = 'upzip/upload_form_view';
		$this->load->view('body', $data);
    }
	
    public function file_upload()
    {
		if(isset($_FILES['userfile'])) {
			$filename = $_FILES['userfile']['name'];
			$source = $_FILES['userfile']['tmp_name'];
			$type = $_FILES['userfile']['type']; 
			
			$datasave = $this->db->get_where('atc_log', array('fzip'=>$filename))->num_rows();
			
			if($datasave > 0){
				$this->session->set_flashdata('error', 'File sudah pernah di upload, mohon periksa kembali lokasi penyimpanan');
				redirect(site_url('upzip/file'));
				return false;
			}else{
				// $data = array(
								// 'fzip'=>$filename
							// );
				// $this->db->insert('atc_log',$data);	
			
				$name = explode('.', $filename);
				$names = str_replace(' ','_', $name[0]);
				$target = 'upzip_temp/'.$name[0].time();
				
				$accepted_types = array('application/zip', 
										'application/x-zip-compressed', 
										'multipart/x-zip', 
										'application/s-compressed');
			 
				foreach($accepted_types as $mime_type) {
					if($mime_type == $type) {
						$okay = true;
						break;
					}
				}

			  //Safari and Chrome don't register zip mime types. Something better could be used here.
				$okay = strtolower($name[1]) == 'zip' ? true: false;
			 
				if(!$okay) {
					$this->session->set_flashdata('error', 'harap pilih file dengan format zip');
					redirect(site_url('upzip/file'));
				}
				
				$saved_file_location = $target .$names;
				$dataName = $names.time();
				
				if(move_uploaded_file($source, $saved_file_location)) {
					$this->openZip($saved_file_location, $names, $dataName);
				} else {
					$this->session->set_flashdata('error', 'Terjadi kesalahan harap ulangi proses upload kembali');
					redirect(site_url('upzip/file'));
				}
			}
		}
    }
	
	public function openZip($file_to_open, $names, $dataName) {
		global $target;
		//echo $names;exit();
		//echo 'ini dir nya '.$file_to_open.'<br>';
		$zip = new ZipArchive();
		$runExt = $zip->open($file_to_open);
		if ($runExt === TRUE){
			$path = getcwd() . "/upzip_temp/";
			$path = str_replace("\\","/",$path);
			$zip->extractTo($path);
			$zip->close();
			unlink($file_to_open);
			
			$myfile = array_slice(scandir('./upzip_temp/'.$names), 2); 
			 //$myfile = scandir('');
			  //print_r($myfile);exit();
			$di = new RecursiveDirectoryIterator($path);
			foreach ($myfile as $filename => $val) {
            $eachFile = basename($filename);
			if($val != '.' || $val != '..'){
				
			
			//echo .'--'.;exit();
			/* formation data */
				$name = explode('_', $names);
				$uname = explode('_', $val);
				$polisNo = explode('_', $uname[0]); 
				$filOne = explode('(', $uname[0]); 
				$filTwo = explode(')', $uname[0]); 
				//$userNames = explode('.', $polisNo[1]); //
				//$newFile2 = preg_replace('~[\\\\/:*?"<>|]~', '_', $name[2]);
				$newFile2 = preg_replace("([^\w\s\d\_~,;:\[\]\(\].]|[\.]{2,})", '_', $uname[1]);
				/* $newFile3 = str_replace('(', '', $newFile2);
				$newFile4 = str_replace(')', '', $newFile3); */
				$newFile = str_replace(' ', '_', $newFile2);
				$locate = $name[1];
				$location = explode('_', $locate); 
				//print_r($name);exit();
			/* variable to database */
				$year = $name[0];
				$box = $name[1];
				//$box2 = substr($box, 3);
				$lemari = $name[2];
				$laci = $name[3];
				$category = $name[4];
				$noPolis = $uname[0];
				$nameUser = $uname[1];

				
				// echo '<strong>No Polis : </strong>'.$noPolis.' <br>
				// <strong>User : </strong>'.$nameUser.'<br>
				// <strong>Old name : </strong>'.$val.'<br>
				// <strong>New name : </strong>'.$newFile.'<br>
				// <strong>Box : </strong>'.$box.' <br>
				// <strong>Lemari : </strong>'.$lemari.' <br>
				// <strong>Laci : </strong>'.$laci.' <br>
				// <strong>Data Tahun : </strong>'.$year.' <br>'; 
				// exit();
				$file = $val;
				$oldDir = './upzip_temp/'.$names.'/'.$val;
				$newDir = './upzip';
				//echo $name[4];exit();
				if(!$name[4]){
					$files = glob ($oldDir.'/*');
					foreach($files as $file){
					  if(is_file($file))
						$adaData = unlink($file);
					}
					rmdir ($oldDir);
					$this->session->set_flashdata('error', 'Terjadi kesalahan, harap periksa penamaan file yang akan di upload');
					redirect(site_url('upzip/file'));
					return false;
				}
				
				/* $chekDatabase = $this->db->get_where('nasabah', array('no'=>$noPolis, 'klien'=>$nameUser, 'ctr'=>$category, 'box'=>$box))->num_rows();
				
				if ($chekDatabase > '0'){
					$files = glob ($oldDir.'/*');
					foreach($files as $file){
					  if(is_file($file))
						$adaData = unlink($file);
					}
					rmdir ($oldDir);
					$this->session->set_flashdata('error', 'Data sudah ada, harap periksa kembali file yang akan di upload');
					redirect(site_url('upzip/file'));
					return false;
				}else{ */
				$ex = explode('.',$nameUser);
					$data = array(
									'no'=>$noPolis,
									'klien'=>$ex[0],
									'ctr'=>$category,
									'box'=>$box,
									'lemari'=>$lemari,		
									'laci'=>$laci,
									'cdt'=>date('d-m-Y'),
									'cby'=>$this->session->userdata('uFname'),
									'cyear'=>$year
								);
					$this->db->insert('nasabah',$data);	
					$insert_id = $this->db->insert_id();
					$dataAtc = array(
									//'np' => $noPolis,
									'np' => $insert_id,
									'cdt'=>date('d-m-Y'),
									'fname' => $newFile,
									'ename' => md5($newFile.time()).'.pdf'
								);
					$this->db->insert('atc_nasabah',$dataAtc);	
					$dataMove = rename($oldDir, $newDir.'/'.md5($newFile.time()).'.pdf');
				//}
				/* if($adaData === true){
					rmdir ($oldDir);
					$this->session->set_flashdata('error', 'Data sudah ada, harap periksa kembali file yang akan di upload');
					redirect(site_url('upzip/file')); 
				} */
			}
			}
				if($dataMove === true){
					 $handle = rmdir ($oldDir);
					   if ($handle) {
							$this->session->set_flashdata('success', 'Data telah tersimpan ke dalam database');
							redirect(site_url('upzip/file')); 
					   }else {
							$this->session->set_flashdata('success', 'Data telah tersimpan ke dalam database');
							redirect(site_url('upzip/file'));    
					   } 
				}
		}else{
			die("Terjadi kesalahan mohon ulangi proses upload kembali");
		}
	}

}