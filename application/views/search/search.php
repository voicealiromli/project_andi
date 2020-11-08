<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('doc/')?>" class="btn btn-mini">Dokumen</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Pencarian konten</a></li>
</ul>

<div class="page-header">
	<h2>PencarianFile</h2>
</div>

<?php echo form_open(site_url('search/file/'), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>	
	
	<div class="control-group">
		<label class="control-label"> Nama File </label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="atc" name="atc" placeholder="Masukkan kata pencarian anda" value="<?php echo $this->input->post('atc')?>" />
		</div>
	</div>
   
	<div id="date_wrapper"> 
			<div class="control-group">
			<label class="control-label">Tanggal Upload</label>
				<div class="controls">
				<span style="width:50px; display:inline-block;">Dari &nbsp;</span>
					<div class="input-prepend">
						<span class="add-on btn"><i class="icon-th"></i></span>
						<input type="text" name="bdate" id="dp1" placeholder="dd-mm-yyyy" class="input-small" value="<?php echo ($this->input->post('bdate'))?$this->input->post('bdate'):NULL?>">
					</div>
					
					<?php echo form_error('bdate')?>
		
				<div style="height:3px;"></div>
				
				<span style="width:50px; display:inline-block;">Sampai &nbsp;</span>
					<div class="input-prepend">
						<span class="add-on btn"><i class="icon-th"></i></span>
						<input type="text" name="edate" id="dp2" placeholder="dd-mm-yyyy" class="input-small" value="<?php echo ($this->input->post('edate'))?$this->input->post('edate'):NULL?>">
					</div>    
					
					<?php echo form_error('edate')?>
				</div>
			</div>
		</div>
	
	<div class="form-actions">
		<input type="submit" class="btn btn-primary btn-large" value="Cari">
		<input type="reset" class="btn btn-large" value="Reset">
	</div>
  	
</form>
<h3> Search Result </h3>
<?php if($search):?>
<table class="table"><thead><tr><th> # </th>
<th> Nama File </th>
<th> Tanggal Upload </th>
</tr></thead><tbody>
<?php foreach($search as $row):
$timestamp = strtotime($row->atc_cdt);
$myDate = date('d-m-Y', $timestamp);
?>

<tr>
<td><a target="_blank" href="<?php echo site_url('doc/e/'.$row->id_s)?>"> Detail </a></td>
<td><?php echo $row->atc_filename;?></td>
<td><?php echo $myDate;?></td>	
<?php endforeach;?>
</tbody>
<tfoot>
</tfoot>
</table>
<?php else:?>
<p> Tidak Ada data</p>
<?php endif;?>