<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('upzip/file')?>" class="btn btn-mini disabled">Upload Zip</a></li>
</ul>
<div class="page-header">
	<h2>Upload Zip</h2>
</div>
<?php echo isset($error) ? $error : ''; ?>
<?php echo form_open_multipart('upzip/file_upload');?>
<input type="file" name="userfile" size="20" style="width:400px"/>
<br /><br />
<input type="submit" value="upload" class="btn btn-primary" />
</form>