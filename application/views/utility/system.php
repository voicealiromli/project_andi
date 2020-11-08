<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('utility/system')?>" class="btn btn-mini">Pengaturan Sistem</a></li>
</ul>

<div class="page-header">
	<h2>Pengaturan Sistem</h2>
</div>

<?php echo form_open(site_url('utility/system_save/'), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>
  
  <div class="control-group">
    <label class="control-label">Departemen/Direktorat/Subdit</label>
    <div class="controls">
		
		<textarea name="departemen" id="departemen" placeholder="" class="input-xlarge"><?php echo $sys['DEPARTEMEN']?></textarea>
		<span class="help help-block">Tampil pada footer laporan.</span>

		<?php echo form_error('departemen');?>
    </div>
  </div> 
  
  <hr class="normal">
  
  <div class="control-group">
    <label class="control-label">Maintenance</label>
    <div class="controls">
	
		<label class="radio inline">
		  <input name="main" value="ON" type="radio"<?php echo ((strtolower($sys['MAINTENANCE'])=='on')?' checked="checked"':NULL)?>>
		  ON
		</label>
		<label class="radio inline">
		  <input name="main" value="OFF" type="radio"<?php echo ((strtolower($sys['MAINTENANCE'])=='off')?' checked="checked"':NULL)?>>
		  OFF
		</label>
			

		<?php echo form_error('main');?>
    </div>
  </div>  

  <div class="form-actions">
    <input type="submit" class="btn btn-primary btn-large" value="Simpan Pengaturan">
    <input type="reset" class="btn btn-large" value="Reset">
  </div>
  	
</form>

<script type="text/javascript">
$(document).ready(function(){
	
});
</script>