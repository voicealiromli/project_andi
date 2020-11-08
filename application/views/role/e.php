
<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Back</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('role')?>" class="btn btn-mini">Daftar Role</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Update role</a></li>
</ul>

<div class="page-header">
	<h2>Update role</h2>
</div>

<?php echo form_open(site_url('role/u/'.$group_id), array('class'=>'form-horizontal alt1', 'id'=>'detailForm'))?>

<legend>Profil Role</legend>

<input type="hidden" name="id" value="<?php echo $group_id?>">

<div id="status"></div><div id="loader"></div>

<div class="control-group">
<label class="control-label"><span class="important">Nama Role</span></label>
<div class="controls">
<input type="text" name="name" id="name" placeholder="Enter the name of the role" class="input-xlarge" value="<?php echo $group_title?>">
<?php echo form_error('name')?>
</div>
</div>

<div class="control-group">
<label class="control-label">Penjelasan</label>
<div class="controls">
<input type="text" name="desc" id="desc" placeholder="Description of role" class="input-xxlarge" value="<?php echo $group_desc?>">
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
    echo '<option value="'.($a+1).'"'.((isset($group_lvl[$val])&&$group_lvl[$val]==$a+1)?' selected':NULL).'>'.$b.'</option>';
    endforeach
    ?>
  </select>
  <?php echo form_error($val)?>
  </div>
  </div>

<?php endforeach?>

<div class="form-actions">
	<input type="submit" id="submitBtn" class="btn btn-primary btn-large" value="Save">
	<input type="reset" id="resetBtn" class="btn btn-large" value="Reset">
    <a href="javascript:;" id="hidelink" rel="<?php echo site_url('role/a')?>" class="btn btn-large btn-info">Create New</a>
</div>

<?php echo form_close()?>
