<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Scan Media</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="mmediadata.com">
<link href="<?php echo base_url()?>assets/css/main.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url()?>assets/css/responsive.css" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url()?>assets/css/scan.css" type="text/css" rel="stylesheet" />
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="shortcut icon" href="<?php echo base_url()?>assets/img/favicon.ico">
</head>
<body>

<div class="container">
	<div class="row">
    <div class="span8">
    
	<div class="page-header"><h1>Scan Media</h1></div>
    
          <div id="dwtcontrol">
          
            <div id="maindivPlugin" >
              <div style="display: none;" id="mainControlNotInstalled"><a id="<?php echo base_url('download/twain.msi')?>">Install plugin, klik disini untuk mendownloadnya.</a></div>
              <div style="display: none;" id="MACmainControlNotInstalled"></div>
              <div id="mainControlInstalled"></div>
            </div>
            
            <div id="maindivIE">
              <object classid="clsid:5220cb21-c88d-11cf-b347-00aa00a28331" style="display:none;">
                <param name="LPKPath" value="DynamicWebTWAIN/DynamicWebTwain.lpk" />
              </object>
              <div id="maindivIEx86" ></div>
              <div id="maindivIEx64" ></div>
            </div>
            
          </div><!--/dwtcontrol-->
      
          <div id="extraInfo" style="font-size: 11px; color: #222222; font-family: verdana sans-serif; background-color:#f0f0f0; text-align:left; width:580px;" ></div>
          
          <!--controller status-->
          <div class="divinput" style="text-align:center; width:580px; background-color:#FFFFFF;">
          
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
                		<input id="btnRemoveCurrentImage" class="btn input-btn2" onclick="return btnRemoveCurrentImage_onclick()" type="button" value="Remove Selected"/>
                		<input id="btnRemoveAllImages" class="btn input-btn2" onclick="return btnRemoveAllImages_onclick()" type="button" value="Remove All"/>
                        <select size="1" id="PreviewMode" class="btn input-btn" onchange ="slPreviewMode();">
                        <option value="0">1X1</option>
                        </select>
                    </div>
                </div><!--/btn-toolbar-->
                
                <div id="preview-control">             
                </div>
                    
                <div id="divMsg" style="text-align:left;"><strong>Message:</strong></div>
                <div id="emessage" style="min-width:550px;min-height:80px; overflow:auto; background-color:#ffffff; border:1px #ccc; border-style:solid; text-align:left;" ></div>
            
          </div><!--/divinput-->
    
    </div><!--/span8-->
    <div class="span4">
    
    
    <div id="ScanWrapper" class="form-inline">
    
    <button id="closeBtn" class="btn btn-danger pull-right" onclick="closeWindow();"><i class="icon-remove icon-white"></i> Close</button>
    <div class="clear"></div>
    
      <h4><img alt="arrow" src="<?php echo base_url()?>assets/img/nav-arrow-right.png" /> <strong>Custom Scan</strong></h4>
      <div id="divScanner" class="well">

        <div class="control-group">
            <label class="control-label" for="source"><strong>Select Source</strong></label>
            <div class="controls">
              <select size="1" id="source" class="input-large">
                <option value = ""></option>
              </select>
			</div>
		</div>
        
        <div style="display:none;" id="pNoScanner"></div>

        <div class="control-group">
            <div class="controls">
                <label class="checkbox inline"><input id="ShowUI" type="checkbox">If Show UI</label>
                <label class="checkbox inline"><input id="ADF" type="checkbox">ADF</label>
                <label class="checkbox inline"><input id="Duplex" type="checkbox">Duplex</label>
            </div>
            <div class="controls">
                <label class="checkbox inline"><input id="DiscardBlank" type="checkbox">Discard Blank Images</label>
            </div>
            <div class="controls">
                <label class="checkbox inline"><input id="BW" type="checkbox" name="PixelType" />B&amp;W</label>
                <label class="checkbox inline"><input id="Gray" type="checkbox" name="PixelType" >Gray</label>
                <label class="checkbox inline"><input id="RGB" type="checkbox" name="PixelType" >Color</label>
            </div>
		</div>
       
        <div class="control-group">
        	<label class="control-label" for="source"><strong>Resolution:</strong></label>
            <div class="controls">
              <select size="1" id="Resolution" class="input-mini">
                <option value = ""></option>
              </select>
              <button class="btn btn-large btn-warning pull-right" id="btnScan" onclick ="btnScan_onclick();"><i class="icon-inbox"></i> Scan</button>           
            </div>
		</div>
        
        <div class="clear"></div>

      </div><!--/divScanner-->
      
      <div id="divBlank" style="">
        <ul class="unstyled"><li></li></ul>
      </div>
      
      <!--Edit Control-->
      <h4><img alt="arrow" src="<?php echo base_url('assets/img/nav-arrow-right.png')?>" /> <strong>Edit Image</strong></h4>
      <div id ="divEdit" class="well">
      
      <div class="btn-toolbar">
      <button class="btn" id="btnEditor" onclick="return btnShowImageEditor_onclick()">Show Image Editor</button>
      </div>
      
     <div class="btn-toolbar">
          <div class="btn-group">
            <button class="btn" id="btnRotateR" onclick="return btnRotateRight_onclick()">Rotate Right</button>
            <button class="btn" id="btnRotateL" onclick="return btnRotateLeft_onclick()">Rotate Left</button>
            <button class="btn" id="btnMirror" onclick="return btnMirror_onclick()">Mirror</button>
            <button class="btn" id="btnFlip" onclick="return btnFlip_onclick()">Flip</button>
         </div>
     </div>          
      
      </div>
      
      <!--Upload Control-->
      <h4><img alt="arrow" src="<?php echo base_url()?>assets/img/nav-arrow-right.png" /> <strong>Upload Image</strong></h4>
      <div id="divUpload" class="well">
        
        <div class="control-group">
            <label class="control-label" for="txt_fileName"><strong>Nama File:</strong></label>
            <div class="controls">
            	<input name="txt_fileName" id="txt_fileName" type="text" />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="txt_fileDesc"><strong>Deskripsi dokumen:</strong></label>
            <div class="controls">
            	<textarea name="txt_fileDesc" id="txt_fileDesc"></textarea>
            </div>
        </div>
        
        <div class="control-group">
            <div class="controls">
<!--                <label class="radio inline"><input name="ImageType" id="imgTypejpeg2" type="radio" value="jpg" onclick="rd_onclick();">JPEG</label>
                <label class="radio inline"><input name="ImageType" id="imgTypetiff2" type="radio" value="tif" onclick="rdTIFF_onclick();">TIFF</label>
                <label class="radio inline"><input name="ImageType" id="imgTypepng2" type="radio" value="png" onclick="rd_onclick();">PNG</label>-->
                <label class="radio inline"><input name="ImageType" id="imgTypepdf2" type="radio" value="pdf" onclick="rdPDF_onclick();" checked>TIFF</label>
            </div>
            <div class="controls">
                <!--<label class="checkbox inline"><input id="MultiPageTIFF" type="checkbox">Multi-Page TIFF</label>-->
                <label class="checkbox inline"><input id="MultiPagePDF" type="checkbox">Multi-Page TIFF</label>
            </div>
        </div>
        
        <button class="btn btn-large btn-primary" id="btnUpload" onclick ="return btnUpload_onclick()"><i class="icon-upload"></i> Upload Image</button>
        
        <div class="clear"></div>
    
      </div><!--/divUpload-->
      
    </div><!--/ScanWrapper-->
    
    </div><!--/span4-->
    </div><!--/row-->

</div><!--/container-->
<script type="text/javascript" src="<?php echo base_url()?>assets/js/sap-scan.js"></script>
<script type="text/javascript">

/*-----------------Upload Image Group---------------------*/
function btnUpload_onclick() 
{
	if (!CheckIfImagesInBuffer()) 
	{
			return;
	}
	
	var i, strHTTPServer, strActionPage, strImageType;
	txt_fileName.className = "";
	
	if (!strre.test(txt_fileName.value)) {
			txt_fileName.className += " invalid";
			txt_fileName.focus();
			em = em + "invalid <b>file name</b>.<br />";
			alert('invalid file name');
			objEmessage.innerHTML = em;
			objEmessage.scrollTop = objEmessage.scrollHeight;
			return;
	}

	if (txt_fileDesc.value=='' || !strre.test(txt_fileDesc.value)) 
	{
		txt_fileDesc.value = txt_fileName.value;
	}

	strHTTPServer = location.hostname;
	WebTWAIN.HTTPPort = location.port==""?80:location.port;
	var CurrentPathName = unescape(location.pathname);
	var CurrentPath = "/mmbindex/media/";

	var strActionPage = CurrentPath + "<?php echo 's_p/'.$this->uri->segment(3)?>";
	var redirectURLifOK = "<?php echo site_url( 'media/s_v/'.$this->uri->segment(3).'?url='.redirect_check() )?>";
	
	strImageType = 4;
	
	var uploadfilename = txt_fileDesc.value + "-x-" + txt_fileName.value + ".tif";
	
	if (strImageType == 4) {
        if ((WebTWAIN.SelectedImagesCount == 1) || (WebTWAIN.SelectedImagesCount == WebTWAIN.HowManyImagesInBuffer)) {
            WebTWAIN.HTTPUploadAllThroughPostAsMultiPageTIFF(
                strHTTPServer,
                strActionPage,
                uploadfilename
            );
        }
        else {
            WebTWAIN.HTTPUploadThroughPostAsMultiPageTIFF(
                strHTTPServer,
                strActionPage,
                uploadfilename
            );
        }
    }
    else {
        WebTWAIN.HTTPUploadThroughPostEx(
            strHTTPServer,
            WebTWAIN.CurrentImageIndexInBuffer,
            strActionPage,
            uploadfilename,
            strImageType
        );
    }	
	em = em + "<b>Upload: </b>";

	if( CheckErrorString() ) 
	{
		if( strActionPage.indexOf("SaveToFile") != -1 )
		{
			alert(WebTWAIN.ErrorString);
		}
		else
		{
			window.location = redirectURLifOK;
		}
	}
		
}

function closeWindow()
{
	window.onunload = opener.location = ("<?php echo redirect_check().'?url='.redirect_check()?>");
	window.close();
}

</script>
</body>
</html>