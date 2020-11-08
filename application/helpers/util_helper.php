<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('redirect_check'))
{
	function redirect_check($fallback=NULL) 
	{
		$CI =& get_instance();
		$url = site_url();
		if($CI->input->get('url'))
		{
			$url = $CI->input->get('url');
		}
		else
		{
			if($fallback)
			{
				$url = site_url($fallback);
			}
		}
		return $url;
			
	}
}

/* now datetime format */
function return_now()
{
	return date("Y-m-d h:i:s");
} 

function return_now_q()
{
	return date("d-m-Y");
} 

/*
*	return format from dd-mm-YYYY to YYYY-mm-dd
*/
if ( ! function_exists('reverse_date'))
{
	function reverse_date($str)
	{
		if($str && $str != '0000-00-00' && $str != '00-00-0000') {
			$str = explode('-', $str);
			return $str[2].'-'.$str[1].'-'.$str[0];
		}
		else
		{
			return NULL;
		}
	}
}

if ( ! function_exists('search_date'))
{
	function search_date($str)
	{
		if($str && $str != '0000/00/00' && $str != '00/00/0000') {
			$str = explode('/', $str);
			return $str[2].'-'.$str[1].'-'.$str[0];
		}
		else
		{
			return NULL;
		}
	}
}

/*
*	return to array Y-m-d
*/
if ( ! function_exists('parse_date'))
{
	function parse_date($str)
	{
		if($str && $str != '00-00-0000') {
			$str = explode('-', $str);
			return $str;
		}
		else
		{
			return NULL;
		}
	}
}

/*
*	sanitize filename, url friendly
*/ 
function sanitize_filename($str, $relative_path = FALSE)
{
	$bad = array( "../", "<!--", "-->", "<", ">", "'", '"', '&', '$', '#', '{',
					'}', '[', ']', '(', ')', '=', ';', '?', "%20", "%22", "%3c", // <
					"%253c",	// <
					"%3e",		// >
					"%0e",		// >
					"%28",		// (
					"%29",		// )
					"%2528",	// (
					"%26",		// &
					"%24",		// $
					"%3f",		// ?
					"%3b",		// ;
					"%3d"		// =
				);

	if ( ! $relative_path)
	{
		$bad[] = './';
		$bad[] = '/';
	}

	$str = remove_invisible_characters($str, FALSE);
	return stripslashes(str_replace($bad, '', $str));
}	

/*
**	Create alias format text
**	@param 	= $this->input->post()
**	@return	= string
*/
function createAliasFormat($post)
{
	$post = strip_tags($post);
	$post = sanitize_filename($post);
	$post = str_replace('_', '-', stripslashes($post));
	$post = str_replace(',', '', stripslashes($post));
	$post = str_replace('.', '', stripslashes($post));
	$post = str_replace(':', '', stripslashes($post));
	$post = str_replace('/', '', stripslashes($post));
	$post = str_replace('?', '', stripslashes($post));
	$post = strtolower( preg_replace("/\s+/", "-", $post) ); 
	$post = addslashes($post);
	return $post; 
}

/**
* Searches haystack for needle and 
* returns an array of the key path if 
* it is found in the (multidimensional) 
* array, FALSE otherwise.
*
* @mixed array_searchRecursive ( mixed needle, array haystack [, bool strict[, array path]] )
*/
function array_searchRecursive( $needle, $haystack, $strict=false, $path=array() )
{
	if( ! is_array($haystack) ) {
		return false;
	}
 
	foreach( $haystack as $key => $val ) {
		if( is_array($val) && $subPath = $this->array_searchRecursive($needle, $val, $strict, $path) ) {
			$path = array_merge($path, array($key), $subPath);
			return $path;
		} elseif( (!$strict && $val == $needle) || ($strict && $val === $needle) ) {
			$path[] = $key;
			return $path;
		}
	}
	
	return false;
	
} // end array_searchRecursive
