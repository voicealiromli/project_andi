<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Back</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('user')?>" class="btn btn-mini">Daftar Pengguna</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Update Pengguna</a></li>
</ul>

<div class="page-header">
	<h2>Profile Pengguna</h2>
</div>

<?php echo form_open(site_url('user/u/'), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>
<input type="hidden" name="id" value="<?php echo $records->userID?>">
  
  <div class="control-group">
    <label class="control-label"><span class="important">Username</span></label>
    <div class="controls">
    <input type="text" class="input-xlarge" id="email" name="email" placeholder="Used for the login application" value="<?php echo $records->userName?>" />
    <div id="email_status"></div>
    <?php echo (form_error('email')) ? form_error('email') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"><span class="important">Nama</span></label>
    <div class="controls">
    <input type="text" class="input-xlarge" id="name" name="name" value="<?php echo $records->userFname?>" />
    <?php echo (form_error('name')) ? form_error('name') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"><span class="important">Kata Sandi</span></label>
    <div class="controls">
    <input type="password" class="input-xlarge" id="pwd" name="pwd" value="<?php echo $this->input->post('pwd')?>" />
    <?php echo (form_error('pwd')) ? form_error('pwd') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"><span class="important">Konfirmasi Kata Sandi</span></label>
    <div class="controls">
    <input type="password" class="input-xlarge" id="repwd" name="repwd" value="<?php echo $this->input->post('repwd')?>" />
    <?php echo (form_error('repwd')) ? form_error('repwd') : ''; ?>
    </div>
  </div>
 
			<input type="hidden" name="su" id="su1" value="1" <?php echo ($records->userAdmin==1)? 'checked' : NULL ?>>


  <script type="text/javascript">
$(document).ready(function()
{	
	if($("#su1").attr("checked")) {		
		$("#dept").prop('disabled',true);					
	}else{			
		$("#dept").prop('disabled',false);									
	}		
});
</script>
  
  <div class="control-group">
    <label class="control-label">Status</label>
    <div class="controls">
      <select name="status" id="status" class="input-large">
        <option value="">=== Pilih ===</option>
        <option value="1"<?php echo ($records->userFlag==1)?' selected':NULL?>>Active</option>
        <option value="0"<?php echo ($records->userFlag==0)?' selected':NULL?>>Non-Active</option>
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
    echo '<option value="'.$row->group_id.'"'.(($row->group_id==$records->group_id)?' selected':NULL).'>'.$row->group_title.'</option>';
  endforeach;
  ?>
  </select>
  <?php echo form_error('role')?>
  <?php else:?>
  <p class="alert alert-important">Please create a data role first.</p>
  <?php endif;?>
  </div>
  </div> 

  <div class="form-actions">
    <input type="submit" class="btn btn-primary btn-large" value="Save">
    <input type="reset" class="btn btn-large" value="Reset">
    <a href="javascript:;" id="hidelink" rel="<?php echo site_url('user/a')?>" class="btn btn-large btn-info">Create New</a>
  </div>
  	
</form>

<script type="text/javascript">
$(document).ready(function()
{
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