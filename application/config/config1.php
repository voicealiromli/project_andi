<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* PARAMETER */


$config['app_abbr']		= 'bumiputera';
$config['app_name']		= 'Sistem Arsip Bumiputera';
$config['app_ver']		= '1.0.0';
$config['salt'] 			= 'MMBindex';
$config['email_form'] = 'info@bumiputera.com';

$config['auth_array'] = array(0=>'Hide', 1=>'View & written', 2=>'Edit', 3=>'Full Access');
$config['auth_pages'] = array('user', 'role', 'log', 'category', 'document', 'view_dan_download', 'upload', 'report');

$config['dayArray'] = array('Sunday'=>'Minggu', 'Monday'=>'Senin', 'Tuesday'=>'Selasa', 'Wednesday'=>'Rabu', 'Thursday'=>'Kamis', 'Friday'=>'Juma\'at', 'Saturday'=>'Sabtu');
$config['monthArray'] = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
$config['shortDayArray'] = array('M', 'S', 'S', 'R', 'K', 'J', 'S');

/* DOC */
$config['doc_cols'] 	= 'id,no,title,date,page,desc,cat_id,vcnt,cby,cdt,uby,udt,flag';
$config['doc_json'] 	= 'id,no,title,date,page,desc,vcnt,flag,cby';

$config['doc_field'] = array(
	'no'=> 'Nomor Polis',
	'klien'=> 'Nama Nasabah',
	'cyear'=> 'Tahun',
	'box'=> 'Box',
	'lemari'=> 'Block',
	'laci'=> 'Rak',
	'ctr'=> 'Jenis Dokumen1'
);

/* ATC */
$config['atc_cols'] 	= 'atc_id,atc_filename,atc_rawname,atc_size,atc_ext,atc_path,atc_from,id_s,atc_vcnt,atc_dcnt,atc_pcnt,atc_cby,atc_cdt,atc_uby,atc_udt';
$config['atc_json'] 	= 'atc_id,atc_filename,atc_rawname,atc_size,atc_ext,atc_path,atc_from,id_s,atc_vcnt,atc_dcnt,atc_pcnt';
/* MASTER DATA */
$config['user_cols'] 	= 'userID,userFname,userName,userPwd,userEmail,userFlag,group_id,userCdt,userCby,userUdt,userUby,userLastvisit';
$config['grp_cols'] 	= 'group_id,group_title,group_desc,group_lvl,group_cby,group_cdt,group_uby,group_udt';
$config['log_cols'] 	= 'log_ID,log_ip,ID_user,log_date,log_type,log_agent,log_activity';
$config['opt_cols'] 	= 'option_id,option_title,option_value';
$config['data_cols'] 	= 'ID,content';
/* LOCATION */
$config['loc_cols'] 	= 'gedungID,gedung_name,gedung_desc,gedung_cdt,gedung_cby,gedung_udt,gedung_uby';
$config['loc_json'] 	= 'gedungID,gedung_name,gedung_desc,gedung_cdt,gedung_cby,gedung_udt,gedung_uby';
/* FLOOR */
$config['floor_cols'] 	= 'floorID,floor_name,floor_desc,gedung_name,floor_cdt,floor_cby,floor_udt,floor_uby';
$config['floor_json'] 	= 'floorID,floor_name,floor_desc,gedung_name,floor_cdt,floor_cby,floor_udt,floor_uby';
/* ROOM */
$config['room_cols'] 	= 'roomID,room_name,room_desc,gedung_id,lantai_id,room_cdt,room_cby,room_udt,room_uby';
$config['room_json'] 	= 'roomID,room_name,room_desc,gedung_id,lantai_id,room_cdt,room_cby,room_udt,room_uby';
/* RACK */
$config['rack_cols'] 	= 'rackID,rack_name,rack_desc,gedung_id,lantai_id,ruangan_id,rack_cdt,rack_cby,rack_udt,rack_uby';
$config['rack_json'] 	= 'rackID,rack_name,rack_desc,gedung_id,lantai_id,ruangan_id,rack_cdt,rack_cby,rack_udt,rack_uby';
/*ROW*/
$config['row_cols'] 	= 'rowID,row_name,row_desc,gedung_id,lantai_id,ruangan_id,rak_id,row_cdt,row_cby,row_udt,row_uby';
$config['row_json'] 	= 'rowID,row_name,row_desc,gedung_id,lantai_id,ruangan_id,rak_id,row_cdt,row_cby,row_udt,row_uby';
/*COL*/
$config['col_cols'] 	= 'colID,col_name,col_desc,gedung_id,lantai_id,ruangan_id,rak_id,row_id,col_cdt,col_cby,col_udt,col_uby';
$config['col_json'] 	= 'colID,col_name,col_desc,gedung_id,lantai_id,ruangan_id,rak_id,row_id,col_cdt,col_cby,col_udt,col_uby';
/*COL*/
$config['box_cols'] 	= 'boxID,box_name,box_desc,gedung_id,lantai_id,ruangan_id,rak_id,row_id,col_id,box_cdt,box_cby,box_udt,box_uby';
$config['box_json'] 	= 'boxID,box_name,box_desc,gedung_id,lantai_id,ruangan_id,rak_id,row_id,col_id,box_cdt,box_cby,box_udt,box_uby';
/* Department */
$config['department_cols'] 	= 'departmentID,department_code,department_name,department_desc,department_cdt,department_cby,department_udt';
$config['department_json'] 	= 'departmentID,department_code,department_name,department_desc';
/* Category */
$config['cat_cols'] 	= 'categoryID,category_name,category_desc,category_cdt,category_cby,category_udt,category_uby';
$config['cat_json'] 	= 'categoryID,category_name,category_desc,category_cdt,category_cby,category_udt,category_uby';
