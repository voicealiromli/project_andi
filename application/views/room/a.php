<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('room')?>" class="btn btn-mini">Daftar Ruangan</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Buat Ruangan</a></li>
</ul>

	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.chained.js"></script>
	<script type="text/javascript" charset="utf-8">
  $(function() {
    
    /* For jquery.chained.js */
    $("#lantai").chained("#gedung");
  });
  </script>

<div class="page-header">
	<h2>Informasi Ruangan</h2>
</div>

<?php echo form_open(site_url('room/i/'), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>

 <div class="control-group">
    <label class="control-label"><span class="important">Nama Gedung</span></label>
    <div class="controls">
   <select name="name_g" id="gedung">
   <option value="">- SELECT -</option>
   <?php foreach($all as $a):?>
   <option value="<?php echo $a->gedungID?>"><?php echo $a->gedung_name?></option>
   <?php endforeach;?>
   </select>
    <?php echo (form_error('name_g')) ? form_error('name_g') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"><span class="important">Nama Lantai</span></label>
    <div class="controls">
   <select name="name_l" id="lantai">
   <option value="">- SELECT -</option>
   <?php foreach($floor as $f):?>
   <option value="<?php echo $f->floorID?>" class="<?php echo $f->gedung_id?>"><?php echo $f->floor_name?></option>
   <?php endforeach;?>
   </select>
    <?php echo (form_error('name_l')) ? form_error('name_l') : ''; ?>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label"><span class="important">Nama Ruangan</span></label>
    <div class="controls">
    <input type="text" class="input-xlarge" id="name" name="name" placeholder="Enter the name of the space" value="<?php echo $this->input->post('name')?>" />
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
    <input type="reset" class="btn btn-large" value="Reset">
  </div>
	
</form>