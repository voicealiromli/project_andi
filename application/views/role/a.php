
<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('role')?>" class="btn btn-mini">Daftar Role</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Buat Role</a></li>
</ul>

<div class="page-header">
	<h2>Buat Role</h2>
</div>

<?php echo form_open( site_url('role/i'), array('class'=>'form-horizontal alt1', 'id'=>'') );?>
<legend>Profil Role</legend>

<div id="status"></div><div id="loader"></div>

<div class="control-group">
<label class="control-label"><span class="important">Nama Role</span></label>
<div class="controls">
<input type="text" name="name" id="name" placeholder="Enter the name of the role" class="input-xlarge" value="<?php echo $this->input->post('name')?>">
<?php echo form_error('name')?>
</div>
</div>

<div class="control-group">
<label class="control-label">Penjelasan</label>
<div class="controls">
<input type="text" name="desc" id="desc" placeholder="Description of role" class="input-xxlarge" value="<?php echo $this->input->post('desc')?>">
<?php echo form_error('desc')?>
</div>
</div>

<div class="clearfix">&nbsp;</div>
<legend>Daftar Akses</legend>

<?php foreach($auth_pages as $key=>$val):?>

  <div class="control-group">
  <label class="control-label"><?php echo ucwords(str_replace('_', ' ', $val))?></label>
  <div class="controls">
  <select name="<?php echo $val?>">
    <?php 
    foreach($auth_array as $a=>$b):
	$num = $a + 1;
    echo '<option value="'.$num.'"'.(($this->input->post($val)==$num)?' selected':NULL).'>'.$b.'</option>';
    endforeach
    ?>
  </select>
  <?php echo form_error($val)?>
  </div>
  </div>

<?php endforeach?>

<div class="form-actions">
	<input type="submit" id="submitBtn" class="btn btn-primary btn-large" value="Save">
	<?php if($this->uri->segment(2) == 'i'){
		echo "<a href=".site_url('role/a')." class='btn btn-large'>Reset</a>";
	}else{
		echo '<input type="reset" class="btn btn-large" value="Reset">';
	}?>
</div>

<?php echo form_close()?>
