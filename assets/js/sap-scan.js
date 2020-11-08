var WebTWAIN;
var ua;
var em = "";
var seed;
var objEmessage;
var re;
var strre;
var ileft, itop, iright, ibottom;
var timeout;
var ostype;
var Resolution, txt_fileName, txt_fileDesc;
var CurrentImage, TotalImage, MultiPageTIFF, MultiPagePDF, PreviewMode, pNoScanner;
window.onload = Pageonload;
//====================Page Onload  Start==================//

function Pageonload() {
    //Page initiation
    var allinputs = document.getElementsByTagName("input");
    for (var i = 0; i < allinputs.length; i++) {
        if (allinputs[i].type == "checkbox") {
            allinputs[i].checked = false;
        } 
        else if (allinputs[i].type == "text") {
            allinputs[i].value = "";
        }
    }

    document.getElementById("Gray").checked = true;
    document.getElementById("imgTypepdf2").checked = true;
		
    CurrentImage = document.getElementById("CurrentImage");
    CurrentImage.value = "";
    TotalImage = document.getElementById("TotalImage");
    TotalImage.value = "0";

    ostype = "windows";
    if (navigator.userAgent.indexOf("Macintosh") != -1) {
        document.getElementById("btnEditor").style.display = "none";
        document.getElementById("tblLoadImage").style.height = "150";
        document.getElementById("notformac1").style.display = "none";
        document.getElementById("notformac2").style.display = "none";
        ostype = "mac";
    }
    var strObjectFF = "";
    strObjectFF = " <embed style='display: inline' id='mainDynamicWebTWAINnotIE' type='Application/DynamicWebTwain-Plugin'";
    strObjectFF += " OnPostTransfer='DynamicWebTwain_OnPostTransfer' OnPostAllTransfers='DynamicWebTwain_OnPostAllTransfers'";
    strObjectFF += " OnMouseClick='DynamicWebTwain_OnMouseClick'  OnPostLoad='DynamicWebTwain_OnPostLoadfunction'";
    strObjectFF += " OnImageAreaSelected = 'DynamicWebTwain_OnImageAreaSelected'";
    strObjectFF += " OnImageAreaDeSelected = 'DynamicWebTwain_OnImageAreaDeselected'";
    strObjectFF += " OnMouseDoubleClick = 'DynamicWebTwain_OnMouseDoubleClick'";
    strObjectFF += " OnMouseRightClick = 'DynamicWebTwain_OnMouseRightClick'";
    strObjectFF += " OnTopImageInTheViewChanged = 'DynamicWebTwain_OnTopImageInTheViewChanged'";
    strObjectFF += " class='divcontrol' pluginspage='DynamicWebTWAIN/DynamicWebTWAINPlugInTrial.msi'></embed>";
    var strObject = "";
    strObject = "   <param name='_cx' value='3784' />";
    strObject += "	<param name='_cy' value='4128' />";
    strObject += "	<param name='JpgQuality' value='80' />";
    strObject += "	<param name='Manufacturer' value='DynamSoft Corporation' />";
    strObject += "	<param name='ProductFamily' value='Dynamic Web TWAIN' />";
    strObject += "	<param name='ProductName' value='Dynamic Web TWAIN' />";
    strObject += "	<param name='VersionInfo' value='Dynamic Web TWAIN 7.0' />";
    strObject += "	<param name='TransferMode' value='0' />";
    strObject += "	<param name='BorderStyle' value='0' />";
    strObject += "	<param name='FTPUserName' value='' />";
    strObject += "	<param name='FTPPassword' value='' />";
    strObject += "	<param name='FTPPort' value='21' />";
    strObject += "	<param name='HTTPUserName' value='' />";
    strObject += "	<param name='HTTPPassword' value='' />";
    strObject += "	<param name='HTTPPort' value='80' />";
    strObject += "	<param name='ProxyServer' value='' />";
    strObject += "	<param name='IfDisableSourceAfterAcquire' value='0' />";
    strObject += "	<param name='IfShowUI' value='-1' />";
    strObject += "	<param name='IfModalUI' value='-1' />";
    strObject += "	<param name='IfTiffMultiPage' value='0' />";
    strObject += "	<param name='IfThrowException' value='0' />";
    strObject += "	<param name='MaxImagesInBuffer' value='1' />";
    strObject += "	<param name='TIFFCompressionType' value='0' />";
    strObject += "	<param name='IfFitWindow' value='-1' />";
    strObject += "	<param name='IfSSL' value='0' />";
    strObject += "	</object>";

		var objDivFF = document.getElementById("mainControlInstalled");
		objDivFF.style.display = "none";
		objDivFF.innerHTML = strObjectFF;
		var obj = document.getElementById("maindivIE");
		obj.style.display = "none";
		var obj = document.getElementById("maindivPlugin");
		obj.style.display = "inline";
		objDivFF.style.display = "inline";
		WebTWAIN = document.getElementById("mainDynamicWebTWAINnotIE");

    seed = setInterval(ControlDetect, 500);
}

function ExplorerType() {
    ua = (navigator.userAgent.toLowerCase());
    if (ua.indexOf("msie") != -1) {
        return "IE";
    }
    else {
        return "notIE";
    }
}

function pause() {
    clearInterval(seed);
}

function ControlDetect() {
    if (WebTWAIN.ErrorCode == 0) {
        pause();
        var i;
        document.getElementById("source").options.length = 0;
        WebTWAIN.OpenSourceManager();

        for (i = 0; i < WebTWAIN.SourceCount; i++) {
            document.getElementById("source").options.add(new Option(WebTWAIN.SourceNameItems(i), i));
        }

        WebTWAIN.MaxImagesInBuffer = 4096;
				
        Resolution = document.getElementById("Resolution");
        Resolution.options.length = 0;
        Resolution.options.add(new Option("100", 100));
        Resolution.options.add(new Option("150", 150));
        Resolution.options.add(new Option("200", 200));
        Resolution.options.add(new Option("300", 300));

        txt_fileName = document.getElementById("txt_fileName");
        txt_fileName.value = "Untitled";
        txt_fileDesc = document.getElementById("txt_fileDesc");

        document.getElementById("ADF").checked = false;

        MultiPagePDF = document.getElementById("MultiPagePDF");
        MultiPagePDF.disabled = false;

        PreviewMode = document.getElementById("PreviewMode");
        PreviewMode.options.length = 0;
        PreviewMode.options.add(new Option("1X1", 0));
        PreviewMode.options.add(new Option("2X2", 1));
        PreviewMode.options.add(new Option("3X3", 2));
        PreviewMode.options.add(new Option("4X4", 3));
        PreviewMode.options.add(new Option("5X5", 4));
        PreviewMode.selectedIndex = 0;

        pNoScanner = document.getElementById("pNoScanner");
        pNoScanner.style.display = "inline";
        objEmessage = document.getElementById("emessage");

        re = /^\d+$/;
        strre = /^[\s\w]+$/;

        ileft = 0;
        itop = 0;
        iright = 0;
        ibottom = 0;
		
        var allinputs = document.getElementsByTagName("input");
        var j = 0;
        objEmessage.ondblclick = function () {
            em = "";
            this.innerHTML = "";
        }

        if (WebTWAIN.SourceCount == 0) {
            pNoScanner.innerHTML = '<span class="label label-important">No Scanner detected:</span>';
            document.getElementById("Resolution").style.display = "none";
        }
        else
            document.getElementById("divBlank").style.display = "none";
    }
    else {
        if (ua.match(/chrome\/([\d.]+)/) || ua.match(/opera.([\d.]+)/) || ua.match(/version\/([\d.]+).*safari/)) {
            document.getElementById("mainControlNotInstalled").style.display = "inline";
            document.getElementById("mainControlInstalled").style.display = "none";
            document.getElementById("divBlank").style.display = "inline";
        }
    }
    timeout = setTimeout(function () { }, 10);
}
//====================Page Onload End====================//

//====================Frequently Used Functions=======================//

function CheckIfImagesInBuffer() {
    if (WebTWAIN.HowManyImagesInBuffer == 0) {
        em = em + "There is no image in buffer.<br />";
        objEmessage.innerHTML = em;
        return false;
    }
    else {
        return true;
    }
}

function CheckErrorString() {
    if (WebTWAIN.ErrorCode == 0) {
        em = em + "<span style='color:#cE5E04'><b>" + WebTWAIN.ErrorString + "</b></span><br />";
        objEmessage.innerHTML = em;
        objEmessage.scrollTop = objEmessage.scrollHeight;
        return true;
    }
	if(WebTWAIN.ErrorCode == -2115) //Cancel file dialog
		return true;
    else {
        if (WebTWAIN.ErrorCode == -2003) {
            var ErrorMessageWin = window.open("", "ErrorMessage", "height=500,width=750,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");
            ErrorMessageWin.document.writeln(WebTWAIN.HTTPPostResponseString);
        }
        em = em + "<span style='color:#cE5E04'><b>" + WebTWAIN.ErrorString + "</b></span><br />";
        objEmessage.innerHTML = em;
        objEmessage.scrollTop = objEmessage.scrollHeight;
        return false;
    }
}

function ds_getleft(el) {
    var tmp = el.offsetLeft;
    el = el.offsetParent
    while (el) {
        tmp += el.offsetLeft;
        el = el.offsetParent;
    }
    return tmp;
}
function ds_gettop(el) {
    var tmp = el.offsetTop;
    el = el.offsetParent
    while (el) {
        tmp += el.offsetTop;
        el = el.offsetParent;
    }
    return tmp;
}

function UpdatePageInfo() {
    TotalImage.value = WebTWAIN.HowManyImagesInBuffer;
    CurrentImage.value = WebTWAIN.CurrentImageIndexInBuffer + 1;
}

//====================Preview Group Start====================//
function btnFirstImage_onclick() {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    WebTWAIN.CurrentImageIndexInBuffer = 0;
    UpdatePageInfo();
}
function btnPreImage_onclick() {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    else if (WebTWAIN.CurrentImageIndexInBuffer == 0) {
        return;
    }
    WebTWAIN.CurrentImageIndexInBuffer = WebTWAIN.CurrentImageIndexInBuffer - 1;
    UpdatePageInfo();
}
function btnNextImage_onclick() {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    else if (WebTWAIN.CurrentImageIndexInBuffer == WebTWAIN.HowManyImagesInBuffer - 1) {
        return;
    }
    WebTWAIN.CurrentImageIndexInBuffer = WebTWAIN.CurrentImageIndexInBuffer + 1;
    UpdatePageInfo();
}
function btnLastImage_onclick() {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    WebTWAIN.CurrentImageIndexInBuffer = WebTWAIN.HowManyImagesInBuffer - 1;
    UpdatePageInfo();
}

function btnRemoveCurrentImage_onclick() {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    WebTWAIN.RemoveAllSelectedImages();
    if (WebTWAIN.HowManyImagesInBuffer == 0) {
        TotalImage.value = WebTWAIN.HowManyImagesInBuffer;
        CurrentImage.value = "";
        return;
    }
    else {
        UpdatePageInfo();
    }
}
function btnRemoveAllImages_onclick() {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    WebTWAIN.RemoveAllImages();
    TotalImage.value = "0";
    CurrentImage.value = "";
}
function slPreviewMode() {
    WebTWAIN.SetViewMode(parseInt(PreviewMode.selectedIndex + 1), parseInt(PreviewMode.selectedIndex + 1));
    if (ostype == "mac") {
        return;
    }
    else if (PreviewMode.selectedIndex != 0) {
        WebTWAIN.MouseShape = true;
    }
    else {
        WebTWAIN.MouseShape = false;
    }
}
//====================Preview Group End====================//

//====================Get Image Group Start=====================//

/*------------------Scan Image--------------------------*/
function btnScan_onclick() {
    WebTWAIN.SelectSourceByIndex(document.getElementById("source").selectedIndex);
    WebTWAIN.CloseSource();
    WebTWAIN.OpenSource();
    WebTWAIN.IfShowUI = document.getElementById("ShowUI").checked;

    var i;
    for (i = 0; i < 3; i++) {
        if (document.getElementsByName("PixelType").item(i).checked == true)
            WebTWAIN.PixelType = i;
    }
    WebTWAIN.Resolution = Resolution.value;
    WebTWAIN.IfFeederEnabled = document.getElementById("ADF").checked;
    WebTWAIN.IfDuplexEnabled = document.getElementById("Duplex").checked;
    em = em + "Pixel Type: " + WebTWAIN.PixelType + "<br />Resolution: " + WebTWAIN.Resolution + "<br />";
    objEmessage.innerHTML = em;
    objEmessage.scrollTop = objEmessage.scrollHeight;
    WebTWAIN.IfDisableSourceAfterAcquire = true;
    WebTWAIN.AcquireImage();
}

//====================Get Image Group End=====================//

//====================Edit Image Group Start=====================//

function btnShowImageEditor_onclick() {//Dynamic Mac TWAIN doesn't support this method yet.
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    WebTWAIN.ShowImageEditor();
}

function btnRotateRight_onclick() {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    WebTWAIN.RotateRight(WebTWAIN.CurrentImageIndexInBuffer);
}
function btnRotateLeft_onclick() {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    WebTWAIN.RotateLeft(WebTWAIN.CurrentImageIndexInBuffer);
}

function btnMirror_onclick() {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    WebTWAIN.Mirror(WebTWAIN.CurrentImageIndexInBuffer);
}
function btnFlip_onclick() {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
    WebTWAIN.Flip(WebTWAIN.CurrentImageIndexInBuffer);
}

/*------------------radio response----------------------------*/

function rdTIFF_onclick() {
    MultiPageTIFF.disabled = false;

    MultiPageTIFF.checked = false;
    MultiPagePDF.checked = false;
    MultiPagePDF.disabled = true;
}
function rdPDF_onclick() {
    MultiPagePDF.disabled = false;

    MultiPageTIFF.checked = false;
    MultiPagePDF.checked = false;
    MultiPageTIFF.disabled = true;
}
function rd_onclick() {
    MultiPageTIFF.checked = false;
    MultiPagePDF.checked = false;
    MultiPageTIFF.disabled = true;
    MultiPagePDF.disabled = true;
}
/*------------------select menu response----------------------------*/

function DynamicWebTwain_OnPostTransfer() {
    if (document.getElementById("DiscardBlank").checked == true) {
        var NewlyScannedImage = WebTWAIN.CurrentImageIndexInBuffer;
        if (WebTWAIN.IsBlankImage(NewlyScannedImage)) {
            WebTWAIN.RemoveImage(NewlyScannedImage);
        }
        em = em + "<b>Blank Discard (On PostTransfer): </b>";
        if (CheckErrorString()) {
            UpdatePageInfo();
            return;
        }
    }
    UpdatePageInfo();
}

function DynamicWebTwain_OnPostLoadfunction(path, name, type) {
    if (document.getElementById("DiscardBlank").checked == true) {
        var NewlyScannedImage = WebTWAIN.CurrentImageIndexInBuffer;
        if (WebTWAIN.IsBlankImage(NewlyScannedImage)) {
            WebTWAIN.RemoveImage(NewlyScannedImage);
        }
        em = em + "<b>Blank Discard (On PostLoad): </b>";
        if (CheckErrorString()) {
            UpdatePageInfo();
            return;
        }
    }
    UpdatePageInfo();
}

function DynamicWebTwain_OnPostAllTransfers() {
    WebTWAIN.CloseSource();
}

var imageindex;
var imageindex2;
function DynamicWebTwain_OnMouseClick(index) {
    imageindex = index;
    CurrentImage.value = index + 1;
}

function DynamicWebTwain_OnMouseRightClick(index2) {
    if (!CheckIfImagesInBuffer()) {
        return;
    }
}

function DynamicWebTwain_OnImageAreaSelected(index, left, top, right, bottom) {
    ileft = left;
    itop = top;
    iright = right;
    ibottom = bottom;
}

function DynamicWebTwain_OnImageAreaDeselected(index) {
    ileft = 0;
    itop = 0;
    iright = 0;
    ibottom = 0;
}

function DynamicWebTwain_OnMouseDoubleClick() {//Dynamic Mac TWAIN doesn't support this event
    var StrextraInfo;
    StrextraInfo = "Image Width: " + WebTWAIN.GetImageWidth(WebTWAIN.CurrentImageIndexInBuffer) +
        " Image Height: " + WebTWAIN.GetImageHeight(WebTWAIN.CurrentImageIndexInBuffer) +
        " Image Bit Depth: " + WebTWAIN.GetImageBitDepth(WebTWAIN.CurrentImageIndexInBuffer);
    document.getElementById("extraInfo").innerHTML = StrextraInfo;
    clearTimeout(timeout);
    timeout = setTimeout(function () {
        document.getElementById("extraInfo").innerHTML = "";
    }, 10000);
}

function DynamicWebTwain_OnTopImageInTheViewChanged(index) {
    CurrentImage.value = index + 1;
}


