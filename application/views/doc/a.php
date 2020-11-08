<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('doc')?>" class="btn btn-mini">Daftar Dokumen</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Buat Baru</a></li>
</ul>

<div class="page-header">
	<h2>Buat Baru</h2>
</div>

<?php echo form_open(site_url('doc/i/'), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>

  <div class="control-group">
    <label class="control-label">Jenis Dokumen </label>
    <div class="controls">
    <input type="text" class="input-xlarge" id="ctr" name="ctr" placeholder="Jenis Dokumen" value="<?php echo $this->input->post('ctr')?>" />
    <?php echo (form_error('ctr')) ? form_error('ctr') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"><span class="important">No. Polis </span></label>
    <div class="controls">
    <input type="text" class="input-xlarge" id="no" name="no" placeholder="Isi Nomor" value="<?php echo $this->input->post('no')?>" />
    <?php echo (form_error('no')) ? form_error('no') : ''; ?>
    </div>
  </div>
  
   <div class="control-group">
    <label class="control-label"><span class="important">Nama </span></label>
    <div class="controls">
    <input type="text" class="input-xlarge" id="name" name="name" placeholder="Nama Debitur" value="<?php echo $this->input->post('name')?>" />
    <?php echo (form_error('name')) ? form_error('name') : ''; ?>
    </div>
  </div>
	
	<div class="control-group">
		<label class="control-label">Tahun </label>
		<div class="controls">
		<input type="text" class="input-mini" id="thn" name="thn" placeholder="Tahun" value="<?php echo $this->input->post('thn')?>" />
		<?php echo (form_error('thn')) ? form_error('thn') : ''; ?>
		</div>
	</div>
		
	<input type="hidden" name="category" value="02">
	<div class="clearfix">&nbsp;</div>
	<legend>Informasi Lokasi Penyimpanan</legend>
  
  
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary btn-large" value="Save">
	<?php if($this->uri->segment(2) == 'i'){
		echo "<a href=".site_url('doc/a')." class='btn btn-large'>Reset</a>";
	}else{
		echo '<input type="reset" class="btn btn-large" value="Reset">';
	}?>
  </div>
	
</form>