<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('doc/')?>" class="btn btn-mini">Dokumen</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Pencarian konten</a></li>
</ul>

<div class="page-header">
	<h2>Pencarian konten</h2>
</div>

<?php echo form_open(site_url('doc/search_content_post/'.$this->uri->segment(3)), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>
   
	<p class="alert">Pastikan modul OCR telah dipasangkan sebelumnya</p>
	
	<div class="control-group">
		<label class="control-label"><span class="important">Kata pencarian</span></label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="keyword" name="keyword" placeholder="Masukkan kata pencarian anda" value="<?php echo $this->input->post('keyword')?>" />
		</div>
	</div>
	
	<div class="form-actions">
		<input type="submit" class="btn btn-primary btn-large" value="Cari">
		<input type="reset" class="btn btn-large" value="Reset">
	</div>
  	
</form>

