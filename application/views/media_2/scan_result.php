<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Hasil Scan Dokumen</title>
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

	<button id="closeBtn" class="btn btn-danger pull-right" onclick="closeWindow();"><i class="icon-remove icon-white"></i> Close</button>

	<div class="page-header"><h1>Daftar Dokumen</h1></div>

    <div id="mediaContainer">
    <table class="table table-striped">
    <thead><tr><th class="center">#</th><th>Dokumen</th><th>Ukuran</th><th>#</th></tr></thead><tbody>
    <?php if($atc) :
			$i=1;
      foreach($atc as $key)
      {
				echo '<tr>';
				echo '<td class="center">'.$i.'</td>';
        echo '<td><strong>'.$key->atc_filename.'</strong></td>';
        echo '<td><strong>'.$key->atc_size.'</strong></td>';
        echo '<td><strong><a href="'.site_url('media/datc/'.$key->atc_id.'?url='.current_url()).'" class="btn btn-danger btn-mini" onclick="return deletelink()">
				<i class="icon-trash icon-white"></i> Hapus</a></strong>
				</td>';
				echo '</tr>';
				$i++;
      }
    else:?>
		<tr><td><h3>Belum ada dokumen</h3></td></tr>
    <?php endif;?>
    </tbody></table>
    <hr />
    
    <button class="btn btn-large btn-warning" id="btnScan" onclick ="btnScan_onclick();"><i class="icon-inbox"></i> Scan Kembali</button>
    
    </div><!--/mediaContainer-->
    
</div><!--/container-->

<script type="text/javascript">
function closeWindow(){
	window.onunload = opener.location = ("<?php echo redirect_check().'?url='.redirect_check()?>");
	window.close();
}
function btnScan_onclick(){
	window.location = "<?php echo site_url('media/s/'.$this->uri->segment(3)).'?url='.redirect_check()?>";
}
function deletelink()
{
	return confirm('Anda yakin akan menghapus data?');
}
</script>

</body>
</html>