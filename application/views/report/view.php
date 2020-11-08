<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Laporan</a></li>
</ul>

<div class="page-header">
	<h2>Laporan</h2>
</div>

<?php echo form_open(site_url('report/u/'), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>
   
  <div class="control-group">
    <label class="control-label">Tahun</label>
    <div class="controls">
    
    <span style="width:50px; display:inline-block;">Dari &nbsp;</span>
    <div class="input-prepend">   
    <div class="date" data-date="" data-date-format="yyyy"><span class="add-on btn"><i class="icon-th"></i></span>
    <input type="text" class="input-small" id="bdate" name="bdate" placeholder="yyyy" value="<?php echo $this->input->post('bdate')?>" />   
    </div>
    </div>
	<?php echo form_error('bdate'); ?>
    
    <div style="height:3px;"></div>
    <span style="width:50px; display:inline-block;">Sampai &nbsp;</span>
    <div class="input-prepend">
    <div class="date" data-date="" data-date-format="yyyy"><span class="add-on btn"><i class="icon-th"></i></span>
    <input type="text" class="input-small" id="edate" name="edate" placeholder="yyyy" value="<?php echo $this->input->post('edate')?>" />
    </div>
    </div>
	<?php echo form_error('edate'); ?>
     
    </div>
  </div>
	<!-- 
  <div class="control-group">
    <label class="control-label">Pilih kategori</label>
    <div class="controls">
    <div class="input-prepend">
		<select name="category" id="category">
			<option value="0">Pilih Semua</option>
			<?php foreach($category as $row){
				echo '<option value="'.$row->categoryID.'">'.$row->category_name.'</option>';
			} ?>
		</select>
    </div>
    </div>
  </div>
	-->
	<div class="control-group">
	<label class="control-label">Pilih Kolom1</label>
		<div class="controls">
		<?php
			  $num = 1;
			  $total_fields = count($fields_doc);
			  $x = array('7','14','20');
			  
			  foreach($fields_doc as $key=>$val)
			  {
				  echo ($num==1 || $num==$x[0]+1 || $num==$x[1]+1 || $num==$x[2]+1) ? '<div class="span2">' : NULL;
				  
				  echo '<input type="checkbox" value="1" id="'.$key.'" name="fields_doc['.$key.']"'.(($num<=4)?' checked':NULL).' style="float:left"> <label for="'.$key.'" style="float:left">&nbsp;&nbsp;&nbsp;'.$val.'</label> <br>';
				  
				  echo ($num==$x[0] || $num==$x[1] || $num==$x[2] || $num==$total_fields) ? '</div>' : NULL;
				  
				  $num++;
			  }
			  ?>		
		</div>
	</div>
	
  <div class="form-actions">
    <input type="submit" class="btn btn-primary btn-large" value="Cari">
    <input type="reset" class="btn btn-large" value="Reset">
  </div>
  	
</form>


