
<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Back</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Ganti Kata Sandi</a></li>
</ul>

<div class="page-header">
  <h1>Ganti Kata Sandi</h1>
</div>

<?php echo form_open(site_url('user/u_pwd/?url='.redirect_check('user')), array('class'=>'form-horizontal alt1', 'id'=>''));?>
<fieldset>

<div class="control-group">
  <label class="control-label"><span class="important">Kata Sandi Lama</span></label>
  <div class="controls">
  <input type="password" class="input-xlarge" id="pwd" name="pwd" value="<?php echo $this->input->post('pwd')?>" />
  <?php echo (form_error('pwd')) ? form_error('pwd') : ''; ?>
  </div>
</div>

<div class="control-group">
  <label class="control-label"><span class="important">Kata Sandi Baru</span></label>
  <div class="controls">
  <input type="password" class="input-xlarge" id="newpwd" name="newpwd" value="<?php echo $this->input->post('newpwd')?>" />
  <?php echo (form_error('newpwd')) ? form_error('newpwd') : ''; ?>
  </div>
</div>

<div class="control-group">
  <label class="control-label"><span class="important">Konfirmasi Kata Sandi</span></label>
  <div class="controls">
  <input type="password" class="input-xlarge" id="repwd" name="repwd" value="<?php echo $this->input->post('repwd')?>" />
  <?php echo (form_error('repwd')) ? form_error('repwd') : ''; ?>
  </div>
</div>

<input type="hidden" name="id" value="<?php echo $this->session->userdata('uID')?>">

<div class="form-actions">
  <input type="submit" class="btn btn-large btn-primary" value="Save" />
  <input type="reset" class="btn btn-large" value="Reset" />
</div>


</fieldset>
<?php echo form_close()?>

<script type="text/javascript">
$(document).ready(function(){
});
</script>