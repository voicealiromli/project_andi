<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/* DATABASE */
define('DBDOC', 'ar_doc');

/* ATC */
define('DBATC', 'ar_atc');

/* DIR */
define('ARCHIVEDIR', './88c5b7c925302b402fb9216bc5742449/');
define('DOWNLOADDIR', 'download/');
define('UPLOADSDIR', './uploads/');
define('DATA_VIEW', './upzip/');

/* MASTER */
define('DBUSR',	'ar_user');
define('DBGRP', 'ar_user_group');
define('DBLOG', 'ar_user_log');
define('DBDEPT', 'ar_department');
define('DBCHK', 'ar_doc_check');
define('DBDAT', 'ar_data');
define('DBOPT', 'ar_option');
define('DBG', 'ar_location_gedung');
define('DBF', 'ar_location_lantai');
define('DBR', 'ar_location_ruangan');
define('DBRK', 'ar_location_rak');
define('DBRW', 'ar_location_row');
define('DBRC', 'ar_location_col');
define('DBB', 'ar_location_box');
define('DBCAT', 'ar_category');

/* End of file constants.php */
/* Location: ./application/config/constants.php */