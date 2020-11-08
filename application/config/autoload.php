<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['libraries'] = array('database','session','form_validation');

$autoload['helper'] = array('url','file','util_helper', 'myencrypt_helper');

$autoload['config'] = array('config1');

$autoload['language'] = array();

$autoload['model'] = array('model_session', 'model_sys');
