<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class backdoor extends CI_Controller {

  var $folder = 'doc/';
	var $dID;

	function __construct()
	{
		parent::__construct();
		

	}
	
	public function index()
	{
		echo 'test';
	}	
	public function _clean_td()
	{
		$this->db->like('no','<td>');
		$doc = $this->db->get('ar_doc')->result();
		//print_r($doc);exit();
		$rep1 = '';
		$rep2 = '';
		foreach($doc as $r):

		$rep1 = str_replace('<td>','',$r->no);
		$rep2 = str_replace('</td>','',$rep1);

		$this->db->set('no',$rep2);
		$this->db->where('id',$r->id);
		$this->db->update('ar_doc');

		endforeach;
	}
}