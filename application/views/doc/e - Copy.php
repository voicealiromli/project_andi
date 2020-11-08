<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('doc')?>" class="btn btn-mini">Daftar Dokumen</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Update Dokumen</a></li>
</ul>

<div class="page-header">
<div class="btn-group pull-right">
<!-- 
	<a href="javascript:;" id="printBarcode" title="Print Barcode Code 128" class="btn btn-inverse pull-right"><i class="icon-qrcode icon-white"></i> Print Barcode</a>
 -->
	<a href="<?php echo site_url('doc/a')?>" class="btn btn-primary pull-right"><i class="icon-plus-sign icon-white"></i> Buat Baru</a>
	<a href="javascript:;" class="btn btn-danger pull-right" id="deletelink" rel="<?php echo site_url('doc/d/'.$records->id)?>" title="Hapus dokumen"><i class="icon-trash icon-white"></i> Hapus Dokumen</a>  
</div>
  <h2>Profil Dokumen</h2>

</div>

<div class="row-fluid">
<div class="span6">

<?php echo form_open(site_url('doc/u/'.$records->id), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>
<input type="hidden" name="id" value="<?php echo $records->id?>">

	<div class="control-group">
		<label class="control-label"> No. Debitur </label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="no" name="no" placeholder="Isi Nomor" value="<?php echo $records->no?>" />
		<?php echo (form_error('no')) ? form_error('no') : ''; ?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><span class="important">Nama Debitur </span></label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="name" name="name" placeholder="Nama Debitur" value="<?php echo $records->title?>" />
		<?php echo (form_error('name')) ? form_error('name') : ''; ?>
		</div>
	</div>
	
	<div class="clearfix">&nbsp;</div>
	<legend>Informasi Lokasi Penyimpanan</legend>

	  <div class="control-group">
    <label class="control-label"> Box </label>
    <div class="controls">
    <input type="text" class="input-mini" id="ab" name="ab" value="<?php echo $records->ab?>" />
    <?php echo (form_error('ab')) ? form_error('ab') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"> Lorong </label>
    <div class="controls">
    <input type="text" class="input-mini" id="sap" name="sap" value="<?php echo $records->sap?>" />
    <?php echo (form_error('sap')) ? form_error('sap') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"> Laci </label>
    <div class="controls">
    <input type="text" class="input-mini" id="od" name="od" value="<?php echo $records->od?>" />
    <?php echo (form_error('od')) ? form_error('od') : ''; ?>
    </div>
  </div>
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary btn-large" value="Save">
    <input type="reset" class="btn btn-large" value="Reset">
  </div>
	
</form> 
</div>
<div class="span6">

<legend>Daftar File</legend>
<?php echo form_open_multipart(site_url('doc/upload/'), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>
<input type="hidden" name="id" value="<?php echo $records->id?>">

	<table class="table table-condensed">
  <thead>
    <tr>
      <th width="50">#</th>
      <th>File</th>
      <th width="100">size</th>
      <th width="150"></th>
    </tr>
  </thead>
  <tbody>
  
  
  <?php if($file):
	$i = 1;?>
  <?php foreach($file as $key):?>

  
  <?php if($records->flag == 0):?>
     <tr>
      <td><?php echo $i?>.</td>
      <td><?php echo $key->atc_filename?></td>
      <td><?php echo substr($key->atc_size/100, 0, -2)?> KB</td>
      <td>	  
      <a class="btn btn-mini" target="_blank" href="<?php echo site_url('media/viewer/'.$key->atc_id.'/'.'?url='.current_url())?>" title="Lihat file"><i class="icon-eye-open"></i> [<?php echo $key->atc_vcnt?>]</a>
	  
	  <?php if($this->model_session->auth_page_check('view_dan_download', 2)):?>
      <a href="javascript:;" class="btn btn-mini" id="hidelink" rel="<?php echo site_url('doc/download/'.$key->atc_id.'/'.$records->id_s)?>" title="Download file"><i class="icon-download"></i> [<?php echo $key->atc_dcnt?>]</a>	  
	  <?php endif;?>
	  
      <a href="javascript:;" class="btn btn-mini btn-danger" id="deletelink" rel="<?php echo site_url('doc/deletefile/'.$key->atc_id.'/'.$records->id_s)?>" title="Hapus file"><i class="icon-trash"></i></a>
      </td>
    </tr>
	<?php elseif($records->cby == $this->session->userdata('uID')):?>
	<tr>
      <td><?php echo $i?>.</td>
      <td><?php echo $key->atc_filename?></td>
      <td><?php echo substr($key->atc_size/100, 0, -2)?> KB</td>
      <td>
      <a class="btn btn-mini" target="_blank" href="<?php echo site_url('media/viewer/'.$key->atc_id.'?url='.current_url())?>" title="Lihat file"><i class="icon-eye-open"></i> [<?php echo $key->atc_vcnt?>]</a>
	  
      <?php if($this->model_session->auth_page_check('view_dan_download', 2)):?>
	  <a href="javascript:;" class="btn btn-mini" id="hidelink" rel="<?php echo site_url('doc/download/'.$key->atc_id.'/'.$records->id_s)?>" title="Download file"><i class="icon-download"></i> [<?php echo $key->atc_dcnt?>]</a>
	  <?php endif;?>
	  
      <a href="javascript:;" class="btn btn-mini btn-danger" id="deletelink" rel="<?php echo site_url('doc/deletefile/'.$key->atc_id.'/'.$records->id_s)?>" title="Hapus file"><i class="icon-trash"></i></a>
      </td>
    </tr>
	<?php else:?>
	<tr>
      <td><?php echo $i?>.</td>
	  
	  <?php if($this->model_session->auth_page_check('view_dan_download', 2)):?>
      <td><a href="javascript:;" id="hidelink" rel="" title="Download file"><?php echo $key->atc_filename?></a></td>
	  <?php endif;?>
	  
      <td><?php echo substr($key->atc_size/100, 0, -2)?> KB</td>
      <td>
      <a class="btn btn-mini" target="_blank" href="<?php echo site_url('media/viewer/'.$key->atc_id.'?url='.current_url())?>" title="Lihat file"><i class="icon-eye-open"></i> [<?php echo $key->atc_vcnt?>]</a>      	  
      </td>
    </tr>
	<?php endif;?>
  <?php 
	$i++;
	endforeach;?>
  <?php else:?>
  <tr><td colspan="4"><strong>Tidak ada Lampiran</strong></td></tr>
  <?php endif;?>
  </tbody>
  </table>
  
  <hr class="normal">

  <div class="control-group">
    <label class="control-label">Lampiran</label>
    <div class="controls">
    <input type="file" class="input-xlarge" id="userfile" name="userfile"/>
    </div>
  </div>
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary btn-medium" value="Upload">
    <input type="reset" class="btn btn-medium" value="Reset">
  </div>  
 
</form>

</div>
</div>
<script>
jQuery('input[name="dates"]').bind('keyup',function(){
    var strokes = $(this).val().length;
    if(strokes === 2 || strokes === 5){
        var thisVal = $(this).val();
        thisVal += '-';
        $(this).val(thisVal);
    }
});

$(function(){
	borrow = $("input[type=radio][name='pinjam']:checked").val();
	complete = $("input[type=radio][name='lengkap']:checked").val();
	
	if(borrow == 1){
		$('.dpj').show();
	}else{
		$('.dpj').hide();
	};
	
	if(complete == 0){
		$('.lkp').show();
	}else{
		$('.lkp').hide();
	};
	
	$('body').on('click','.pn', function(){
		pinjam = $(this).val();
		if(pinjam == 1){
			$('.dpj').show();
		}else{
			$('.dpj').hide();
		}
	});
	$('body').on('click','.lk', function(){
		lengkap = $(this).val();
		if(lengkap == 0){
			$('.lkp').show();
		}else{
			$('.lkp').hide();
		}
	});
	
	$("#printBarcode").click(function(){
		var barcodeWindow = window.open('<?php echo site_url('media/barcode_single/'.$records->id.'/single')?>','Barcode','width=500,height=300', true);
		barcodeWindow.focus();
		//barcodeWindow.print();
		return false;		
	});
})
</script>