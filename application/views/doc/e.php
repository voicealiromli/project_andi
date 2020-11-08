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
	<?php if ($this->model_session->auth_display('document', 3)): ?>
	<a href="javascript:;" class="btn btn-danger pull-right" id="deletelink" rel="<?php echo site_url('doc/d/'.$records->idn)?>" title="Hapus dokumen"><i class="icon-trash icon-white"></i> Hapus Dokumen</a>  
	<?php endif; ?>			
</div>
  <h2>Profil Dokumen</h2>

</div>

<div class="row-fluid">
<div class="span6">

<?php echo form_open(site_url('doc/u/'.$records->idn), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>
<input type="hidden" name="id" value="<?php echo $records->idn?>">

	<div class="control-group">
		<label class="control-label"> Jenis Dokumen </label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="ctr" name="ctr" placeholder="Isi Nomor" value="<?php echo $records->ctr?>" />
		<?php echo (form_error('ctr')) ? form_error('ctr') : ''; ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"> No Polis </label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="no" name="no" placeholder="Isi Nomor" value="<?php echo $records->no?>" />
		<?php echo (form_error('no')) ? form_error('no') : ''; ?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><span class="important">Nama </span></label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="name" name="name" placeholder="Nama Debitur" value="<?php echo $records->klien?>" />
		<?php echo (form_error('name')) ? form_error('name') : ''; ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label">Tahun</label>
		<div class="controls">
		<input type="text" class="input-mini" id="thn" name="thn" placeholder="Tahun" value="<?php echo $records->cyear?>" />
		<?php echo (form_error('thn')) ? form_error('thn') : ''; ?>
		</div>
	</div>
	
	<div class="clearfix">&nbsp;</div>
	<legend>Informasi Lokasi Penyimpanan</legend>

	<div class="control-group">
		<label class="control-label"> BOX </label>
		<div class="controls">
		<input type="text" class="input-mini" id="ab" name="ab" value="<?php echo $records->box?>" />
		<?php echo (form_error('ab')) ? form_error('ab') : ''; ?>
		</div>
	</div>
  
  <div class="control-group">
    <label class="control-label"> BLOK </label>
    <div class="controls">
    <input type="text" class="input-mini" id="sap" name="sap" value="<?php echo $records->lemari?>" />
    <?php echo (form_error('sap')) ? form_error('sap') : ''; ?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label"> RAK </label>
    <div class="controls">
    <input type="text" class="input-mini" id="od" name="od" value="<?php echo $records->laci?>" />
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
<input type="hidden" name="id" value="<?php echo $records->idn?>">
<input type="hidden" name="no" value="<?php echo $records->no?>">

	<table class="table table-condensed">
  <thead>
    <tr>
      <th width="50">#</th>
      <th>File</th>
      <th width="150"></th>
    </tr>
  </thead>
  <tbody>
  
  <?php if($file):
	$i = 1;?>
  <?php foreach($file as $key):?>
  
  <?php if($records){?>
	<tr>
      <td><?php echo $i?>.</td>
      <td><?php echo $key->fname?></td>
      <td>
	  
      <?php if($this->model_session->auth_page_check('view_dan_download', 2)):?>
	  <a href="javascript:;" class="btn btn-mini" id="hidelink" rel="<?php echo site_url('doc/download/'.$key->idatc.'/'.$key->np)?>" title="Download file"><i class="icon-download"></i> </a>
	  <?php endif;?>
	  
      <a class="btn btn-mini" target="_blank" href="<?php echo site_url('media/viewer2/'.$key->idatc.'/data_view/'.$key->np)?>" title="Lihat file"><i class="icon-eye-open"></i> </a>  
	  
	  <?php if ($this->model_session->auth_display('document', 3)): ?>
      <a href="javascript:;" class="btn btn-mini btn-danger" id="deletelink" rel="<?php echo site_url('doc/deletefile/'.$key->idatc.'/'.$key->np.'/'.$records->idn)?>" title="Hapus file"><i class="icon-trash"></i></a>
	  <?php endif;?>
      </td>
    </tr>
	
  <?php 
	$i++;
	}
	endforeach;
	else:?>
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