<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if($records)
{
	$arr = array();
	foreach($records as $val)
	{
		$arr[] = array("id"=>$val->content, "label"=>$val->content);
	}
	echo json_encode($arr);
}