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
<link href="<?php echo base_url()?>assets/css/scan.css" type="text/css" rel="stylesheet" />
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="shortcut icon" href="<?php echo base_url()?>assets/ico/favicon.ico">
</head>
<body>

<noscript>
	<strong>Javascript Must ON!</strong>
</noscript>


<div class="container">

	<button id="closeBtn" class="btn btn-small btn-danger pull-right"><i class="icon-remove icon-white"></i> Close</button>

	<div class="page-header"><h1>Media Viewer</h1></div>

    <div id="mediaContainer">
    
	<embed id="mainDynamicWebTWAINnotIE" type="Application/DynamicWebTwain-Plugin" onposttransfer="OnPostTransferCallback" onpostalltransfers="OnPostAllTransfersCallback" height="500" width="500">
    <input type="hidden" id="xdir" value="<?php echo base64_encode('/mmbindex/'.str_replace('./', '', ARCHIVEDIR.$records->atc_rawname.$records->atc_ext))?>">
    
    </div><!--/mediaContainer-->
                
    <div id="preview-control">

        <div class="btn-toolbar">
            <div class="btn-group">
              <button id="btnFirstImage" class="btn btn-small" onclick="return btnFirstImage_onclick()"><i class="icon-step-backward"></i></button>
              <button id="btnPreImage" class="btn btn-small" onclick="return btnPreImage_onclick()"><i class="icon-fast-backward"></i></button>
            </div>
              <div class="btn-group">
              <input type="text" size="2" id="CurrentImage" class="input-mini" readonly="readonly"/> /
              <input type="text" size="2" id="TotalImage" class="input-mini" readonly="readonly"/>	
            </div>  
            <div class="btn-group">
              <button id="btnNextImage" class="btn" onclick="return btnNextImage_onclick()"><i class="icon-fast-forward"></i></button>
              <button id="btnLastImage" class="btn" onclick="return btnLastImage_onclick()"><i class="icon-step-forward"></i></button> 	
            </div>
            <div class="btn-group">
                <select size="1" id="PreviewMode" class="btn btn-small input-btn" onchange ="slPreviewMode();">
                <option value="0">1X1</option>
                <option value="1">2X2</option>
                <option value="2">3X3</option>
                <option value="3">4X4</option>
                </select>
            </div>
        </div><!--/btn-toolbar--> 
        
        <div class="btn-toolbar">
        	<div class="btn-group">
            <!--<button id="loadImgBtn" class="btn btn-info"><i class="icon-print icon-white"></i> Load</button> -->
			<?php if($this->uri->segment(4) == 1 || $this->session->userdata('uAdmin')):?>
			<button id="printBtn" class="btn btn-info"><i class="icon-print icon-white"></i> Print</button> 
            <button id="downloadBtn" class="btn btn-info"><i class="icon-download icon-white"></i> Download</button>
			<?php else:?>
			<button id="printBtn" disabled="disabled" class="btn btn-info"><i class="icon-print icon-white"></i> Print</button> 
            <button id="downloadBtn" disabled="disabled" class="btn btn-info"><i class="icon-download icon-white"></i> Download</button>
			<?php endif;?>
			
        	</div> 
        </div><!--/btn-toolbar--> 
            
    </div><!--/preview-control--> 

</div><!--/container-->

<script type="text/javascript" src="<?php echo site_url('assets/js/jquery-1.8.0.min.js')?>"></script>
<script type="text/javascript">

function utf8_to_b64( str ) {
    return window.btoa(unescape(encodeURIComponent( str )));
}

function b64_to_utf8( str ) {
    return decodeURIComponent(escape(window.atob( str )));
}

var TotalImage=document.getElementById("TotalImage"),
CurrentImage=document.getElementById("CurrentImage"),
WebTWAIN = document.getElementById("mainDynamicWebTWAINnotIE"),
dir = b64_to_utf8( $("#xdir").val() );

$(function() {
	
	TotalImage.value = '';
	CurrentImage.value = '0';
	loadImg();
	
	$("#closeBtn").click(function(){
		if(opener!=null) {
			window.onunload = opener.location = ("<?php echo redirect_check().'?url='.redirect_check('doc')?>");
		}
		window.close();
	});
	
	$("#printBtn").click(function(){
		$.ajax({
		  url: "<?php echo site_url('media/upcnt/')?>",
		  data: { s: "<?php echo $this->uri->segment(3)?>", <?php echo $this->config->item('csrf_token_name').':"'.$this->security->get_csrf_hash().'"'?> },
		  success: WebTWAIN.Print()
		});
		return false;
	});
	
	$("#downloadBtn").click(function(){
		window.location = "<?php echo site_url('media/dpcnt/?s='.$this->uri->segment(3).'&'.$this->config->item('csrf_token_name').'='.$this->security->get_csrf_hash().'&url='.current_url())?>";
	});
	
	
	$("#loadImgBtn").click(function(){
		loadImg();
	});

});

function UpdatePageInfo() {
    TotalImage.value = WebTWAIN.HowManyImagesInBuffer;
    CurrentImage.value = WebTWAIN.CurrentImageIndexInBuffer + 1;
}

function CheckErrorString() {
    if (WebTWAIN.ErrorCode == 0) {
			//alert(WebTWAIN.ErrorString);
      return true;
    }
	if(WebTWAIN.ErrorCode == -2115) {
		alert(WebTWAIN.ErrorString);
		return true;
	} else {
        if (WebTWAIN.ErrorCode == -2003) {
            var ErrorMessageWin = window.open("", "ErrorMessage", "height=500,width=750,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");
            ErrorMessageWin.document.writeln(WebTWAIN.HTTPPostResponseString);
        }
		alert(WebTWAIN.ErrorString);
        return false;
    }
}

function loadImg() {
	WebTWAIN.HTTPPort = location.port==""?80:location.port;
	WebTWAIN.HTTPDownload(location.hostname, dir);
	UpdatePageInfo();
	if (WebTWAIN.SourceCount == 0) {
			if (CheckErrorString()) {
					timeout = setTimeout(function () {}, 100);
					clearTimeout(timeout);
					return;
			}
	}
	return false;
}

function btnFirstImage_onclick() {
	if (WebTWAIN.HowManyImagesInBuffer == 0){
				alert("There is no image in buffer");
				return;
	}  
	WebTWAIN.CurrentImageIndexInBuffer = 0;		
	TotalImage.value = WebTWAIN.HowManyImagesInBuffer;
	CurrentImage.value = WebTWAIN.CurrentImageIndexInBuffer+1;
}

function btnPreImage_onclick() {
	if (WebTWAIN.HowManyImagesInBuffer == 0){
				alert("There is no image in buffer");
				return;
	}
	if (WebTWAIN.CurrentImageIndexInBuffer == 0)
				return;
	WebTWAIN.CurrentImageIndexInBuffer = WebTWAIN.CurrentImageIndexInBuffer - 1;
	TotalImage.value = WebTWAIN.HowManyImagesInBuffer;
	CurrentImage.value = WebTWAIN.CurrentImageIndexInBuffer+1;
	UpdatePageInfo();
}

function btnNextImage_onclick() {
	if (WebTWAIN.HowManyImagesInBuffer == 0){
				alert("There is no image in buffer");
				return;
	}
	if (WebTWAIN.CurrentImageIndexInBuffer == WebTWAIN.HowManyImagesInBuffer - 1)
				return;
	WebTWAIN.CurrentImageIndexInBuffer = WebTWAIN.CurrentImageIndexInBuffer + 1;
	TotalImage.value = WebTWAIN.HowManyImagesInBuffer;
	CurrentImage.value = WebTWAIN.CurrentImageIndexInBuffer+1;
}

function btnLastImage_onclick() {
	if (WebTWAIN.HowManyImagesInBuffer == 0){
				alert("There is no image in buffer");
				return;
	}
	WebTWAIN.CurrentImageIndexInBuffer = WebTWAIN.HowManyImagesInBuffer - 1;
	TotalImage.value = WebTWAIN.HowManyImagesInBuffer;
	CurrentImage.value = WebTWAIN.CurrentImageIndexInBuffer+1;
}

function slPreviewMode() {
	WebTWAIN.SetViewMode(parseInt(document.getElementById("PreviewMode").selectedIndex + 1), parseInt(document.getElementById("PreviewMode").selectedIndex + 1));
	if (CheckErrorString()) {
			return;
	}
}
		
</script>

</body>
</html>