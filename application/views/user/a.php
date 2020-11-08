<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('user')?>" class="btn btn-mini">Daftar Pengguna</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Buat Pengguna</a></li>
</ul>

<div class="page-header">
	<h2>Profil Pengguna</h2>
</div>

<?php echo form_open(site_url('user/i/'), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>

  <div class="control-group">
    <label class="control-label"><span class="important">Username</span></label>
    <div class="controls">
    <input type="text" class="input-xlarge" id="email" name="email" placeholder="Used for the login application" value="<?php echo $this->input->post('email')?>" />
    <div id="email_status"></div>
    <?php echo (form_error('email')) ? form_error('email') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"><span class="important">Nama</span></label>
    <div class="controls">
    <input type="text" class="input-xlarge" id="name" name="name" placeholder="User's full name" value="<?php echo $this->input->post('name')?>" />
    <?php echo (form_error('name')) ? form_error('name') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"><span class="important">Kata Sandi</span></label>
    <div class="controls">
    <input type="password" class="input-xlarge" id="pwd" name="pwd" placeholder="User password" value="<?php echo $this->input->post('pwd')?>" />
    <?php echo (form_error('pwd')) ? form_error('pwd') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"><span class="important">Konfirmasi Kata Sandi</span></label>
    <div class="controls">
    <input type="password" class="input-xlarge" id="repwd" name="repwd" placeholder="Fill in the same password" value="<?php echo $this->input->post('repwd')?>" />
    <?php echo (form_error('repwd')) ? form_error('repwd') : ''; ?>
    </div>
  </div>

	<input type="hidden" name="su" id="su1" value="1" checked>			
  
  <div class="control-group">
    <label class="control-label">Status</label>
    <div class="controls">
      <select name="status" id="status" class="input-large">
        <option value="">=== Pilih ===</option>
        <option value="1" selected>Active</option>
        <option value="0">Non-active</option>
      </select>
    </div>
  </div>
  
  <div class="control-group">
  <label class="control-label">Role</label>
  <div class="controls">
  <?php if($role):?>
  <select name="role">
  <?php
  foreach($role as $row):
    echo '<option value="'.$row->group_id.'"'.(($this->input->post('role')==$row->group_id)?' selected':NULL).'>'.$row->group_title.'</option>';
  endforeach;
  ?>
  </select>
  <?php echo form_error('role')?>
  <?php else:?>
  <p class="alert alert-important">Mohon buat data role terlebih dahulu.</p>
  <?php endif;?>
  </div>
  </div>  
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary btn-large" value="Save">
	<?php if($this->uri->segment(2) == 'i'){
		echo "<a href=".site_url('user/a')." class='btn btn-large'>Reset</a>";
	}else{
		echo '<input type="reset" class="btn btn-large" value="Reset">';
	}?>
  </div>
	
</form>
<script type="text/javascript">
$(document).ready(function()
{
	$("#dept").prop('disabled',true);
	$("input[name='su']").change(function(){		
		if($("#su1").attr("checked")) {		
			$("#dept").prop('disabled',true);					
		}else{			
            $("#dept").prop('disabled',false);									
		}		
	});	
});
</script>

<script type="text/javascript">
$(document).ready(function(){

	$("#email").change(function() {
		var email = $("#email").val(),
		email_s = $("#email_status");	
		if(email.length >= 3) {
			$.ajax({
				type: "POST",
				url: "<?php echo site_url('user/check')?>",
				data: {"n": email, "type":"email", <?php echo $this->config->item('csrf_token_name').':"'.$this->security->get_csrf_hash().'"'?>},
				success: function(msg){
					email_s.ajaxComplete(function(event, request, settings){				
						if(msg == 1) {
							$(this).html('Email sudah terpakai!.').addClass('help-inline important');
						} else {
							$(this).html('').removeClass('important');
						}
					});
				}//end success				
			});		
		}//ending min-length		
	});
	
});
</script>