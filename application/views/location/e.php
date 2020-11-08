<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Back</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('location')?>" class="btn btn-mini">Daftar Gedung</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Update Gedung</a></li>
</ul>

<div class="page-header">
	<h2>Update Gedung</h2>
</div>

<?php echo form_open(site_url('location/u/'.$records->gedungID), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>
    <input type="hidden" class="input-xlarge" name="id" value="<?php echo $records->gedungID?>" />
  <div class="control-group">
    <label class="control-label"><span class="important">Nama Gedung</span></label>
    <div class="controls">
    <input type="text" class="input-xlarge" id="name" name="name" placeholder="Enter the name of the building" value="<?php echo $records->gedung_name?>" />
    <?php echo (form_error('name')) ? form_error('name') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label">Informasi</label>
    <div class="controls">
    <textarea id="desc" name="desc"><?php echo $records->gedung_desc?></textarea>
    <?php echo (form_error('desc')) ? form_error('desc') : ''; ?>
    </div>
  </div>
   


  <div class="form-actions">
    <input type="submit" class="btn btn-primary btn-large" value="Save">
    <input type="reset" class="btn btn-large" value="Reset">
  </div>
	
</form>