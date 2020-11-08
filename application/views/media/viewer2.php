<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Media Viewer</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href="<?php echo base_url()?>assets/css/main.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url()?>assets/css/responsive.css" type="text/css" rel="stylesheet" />
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="shortcut icon" href="<?php echo base_url()?>assets/ico/favicon.ico">
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery-1.8.0.min.js')?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/pdfobject.js')?>"></script>
</head>
<body>

<noscript>
	<strong>Javascript Must ON!</strong>
</noscript>

<div class="container">
	<input type="hidden" id="xdir" value="<?php echo base_url(str_replace('./', '', DATA_VIEW.$records->ename) )?>">
	<script type="text/javascript">
		/* function utf8_to_b64( str ) {
			return window.btoa(unescape(encodeURIComponent( str )));
		} */
		/* function b64_to_utf8( str ) {
				return decodeURIComponent(escape(window.atob( str )));
		} */
		//var dir = b64_to_utf8( $("#xdir").val() );
		var dir = $("#xdir").val();
		window.onload = function ()
		{
			var myPDF = new PDFObject({ url: dir }).embed();
		};
  </script>
</div><!--/container-->
</body>
</html>





