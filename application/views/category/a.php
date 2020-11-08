<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('category')?>" class="btn btn-mini">Daftar Jenis Persuratan</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Buat Jenis Persuratan</a></li>
</ul>

<div class="page-header">
	<h2>Buat Jenis Persuratan</h2>
</div>

<?php echo form_open(site_url('category/i/'), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>
  
    <div class="control-group">
    <label class="control-label"><span class="important">Nama</span></label>
    <div class="controls">
    <input type="text" class="input-xlarge" id="name" name="name" placeholder="Jenis Persuratan" value="<?php echo $this->input->post('name')?>" />
    <?php echo (form_error('name')) ? form_error('name') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label">Informasi</label>
    <div class="controls">
    <textarea id="desc" name="desc"><?php echo $this->input->post('desc')?></textarea>
    <?php echo (form_error('desc')) ? form_error('desc') : ''; ?>
    </div>
  </div>
   
  <div class="form-actions">
    <input type="submit" class="btn btn-primary btn-large" value="Save">
	<?php if($this->uri->segment(2) == 'i'){
		echo "<a href=".site_url('category/a')." class='btn btn-large'>Reset</a>";
	}else{
		echo '<input type="reset" class="btn btn-large" value="Reset">';
	}?>
  </div>
	
</form>