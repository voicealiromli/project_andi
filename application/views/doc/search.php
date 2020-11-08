<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('doc/')?>" class="btn btn-mini">Dokumen</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Pencarian konten</a></li>
</ul>

<div class="page-header">
	<h2>Pencarian Konten Lanjutan</h2>
</div>

<?php echo form_open(site_url('doc/search/'), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>	
	
	<div class="control-group">
		<label class="control-label"> Nomor </label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="no" name="no" placeholder="Masukkan kata pencarian anda" value="<?php echo $this->input->post('no')?>" />
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"> Perihal </label>
		<div class="controls">
		<input type="text" class="input-xlarge" id="title" name="title" placeholder="Masukkan kata pencarian anda" value="<?php echo $this->input->post('title')?>" />
		</div>
	</div>	
  
	<div class="control-group">
		<label class="control-label"> Jenis Surat </label>
		<div class="controls">
		<select name="category">
		<option value="">- Pilih Semua -</option>
		<?php foreach($cat as $c):?>	
		<option value="<?php echo $c->categoryID?>"><?php echo $c->category_name?></option>
		<?php endforeach;?>
		</select>
		<?php echo (form_error('category')) ? form_error('category') : ''; ?>
		</div>
	</div>
   
	<div id="date_wrapper"> 
			<div class="control-group">
			<label class="control-label">Tanggal Surat</label>
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
<th> No </th>
<th> Perihal </th>
<th> Tanggal Surat </th>
<th> Asal / Pihak yang dituju</th>
</tr></thead><tbody>
<?php foreach($search as $row):?>
<tr>
<td><a href="<?php echo site_url('doc/e/'.$row->id)?>"> Detail </a></td>
<td><?php echo $row->no;?></td>
<td><?php echo $row->title;?></td>
<td><?php echo reverse_date($row->date);?></td>
<td><?php echo $row->source;?></td></tr>			
<?php endforeach;?>
</tbody>
<tfoot>
</tfoot>
</table>
<?php else:?>
<p> Tidak Ada data</p>
<?php endif;?>