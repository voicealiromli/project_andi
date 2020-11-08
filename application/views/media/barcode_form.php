<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Print Barcode</a></li>
</ul>

<div class="page-header">
	<h2>Print Barcode</h2>
</div>
<?php echo form_open(site_url('media/barcode_form/'.$this->uri->segment(3)), array('class'=>"form-horizontal alt1", 'id'=>'form1'))?>

 <div class="control-group">
    <label class="control-label"><span class="important">Berdasarkan</span></label>
    <div class="controls">
	<select name="berdasarkan" id="berdasarkan">
	    <option>-Pilih-</option>
		<option value="kode">Kode</option>
		<?php echo ($this->uri->segment(3)=='sertifikat')?'<option value="masa_berlaku">Masa berlaku</option>' : NULL ;?>
		<option value="tanggal_entri">Tanggal entri</option>
	</select>     
    </div>
  </div>


<div id="kd">

  <div class="control-group">
    <label class="control-label"><span class="important">Kode</span></label>
    <div class="controls">
	
	<input type="text" class="input-medium" id="keyword_kode1" name="keyword_kode1" placeholder="eg. SER1307000010" value="<?php echo $this->input->post('keyword_kode1')?>" />
	
	<span class="btn disabled">s/d</span>
	
	<input type="text" class="input-medium" id="keyword_kode2" name="keyword_kode2" placeholder="eg. SER1307000050" value="<?php echo $this->input->post('keyword_kode2')?>" />   
    
    </div>
  </div>
</div>

<div id="ms">
  <div class="control-group">
    <label class="control-label"><span class="important">Masa Berlaku</span></label>
    <div class="controls">
	<div class="input-prepend">
				<span class="add-on btn disabled"><i class="fam-date"></i></span>
	<input type="text" class="input-medium" id="dp1" placeholder="dd-mm-yyyy" name="keyword_masa1" placeholder="eg. SER1307000010" value="<?php echo $this->input->post('keyword_masa1')?>" />
	</div>
	<span class="btn disabled">s/d</span>
		<div class="input-prepend">
				<span class="add-on btn disabled"><i class="fam-date"></i></span>
	<input type="text" class="input-medium"  id="dp2" placeholder="dd-mm-yyyy" name="keyword_masa2" placeholder="eg. SER1307000050" value="<?php echo $this->input->post('keyword_masa2')?>" />   
 	</div>
    </div>
  </div>
</div>

<div id="tgl">  
   <div class="control-group">
    <label class="control-label"><span class="important">Tanggal Entri</span></label>
    <div class="controls">
		<div class="input-prepend">
				<span class="add-on btn disabled"><i class="fam-date"></i></span>
	<input type="text" class="input-medium"  id="dp1" placeholder="dd-mm-yyyy" name="keyword_tgl1" placeholder="eg. SER1307000010" value="<?php echo $this->input->post('keyword_tgl1')?>" />
	</div>
	<span class="btn disabled">s/d</span>
	<div class="input-prepend">
				<span class="add-on btn disabled"><i class="fam-date"></i></span>
	<input type="text" class="input-medium" id="dp2" placeholder="dd-mm-yyyy"name="keyword_tgl2" placeholder="eg. SER1307000050" value="<?php echo $this->input->post('keyword_tgl2')?>" />   
     </div>
    </div>
  </div>
</div>
  
  
  <div class="form-actions">
    <input type="submit" class="btn btn-primary btn-large" value="Tampilkan">
    <input type="reset" class="btn btn-large" value="Reset">
  </div>
  	
</form>

<?php if(!empty($_POST) && $records):?>

	<?php echo form_open(site_url('media/barcode_multi/'.$this->uri->segment(3)))?>

	<button type="submit" class="btn" id="printBarcode"><i class="icon-print"></i> Cetak Barcode</button>
	<div class="clearfix"></div>
	
	<div id="report-wrapper">
	
	  <table class="table table-condensed table-zebra table-striped">
		<thead>
		<tr>
			<th><input type="checkbox" id="checkall" class="checkall_"></th>
			<th>Kode</th>
			<th>Pemilik</th>
			<th>Pemohon</th>
			<?php echo ($this->uri->segment(3) == 'sertifikat')? '<th>Masa Berlaku</th>' : NULL?>
			<th>Tgl. Entri</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($records as $key):?>
		
		<tr>
			<td><?php echo '<input type="checkbox" id="check_'.$key->id.'" name="check_'.$key->id.'">'?></td>
			<td><?php echo $key->code?></td>
			<td><?php echo $key->pemilik?></td>
			<td><?php echo $key->pemohon?></td>
            <?php echo ($this->uri->segment(3) == 'sertifikat')? '<td>'.reverse_date($key->masa_berlaku).'</td>' : NULL?>
			<td><?php echo $key->cdt?></td>
		</tr>
		
		<?php endforeach;?>	  
		</tbody>
	  </table>
	  
	</div>
		
	<?php echo form_close();?>
	
  <?php else:?>
  
  	<?php if(!empty($_POST)):?>
	<h3 class="">Tidak ada hasil</h3>
	<?php endif;?>
  
<?php endif;?>

<script type="text/javascript">
$(document).ready(function(){
	
	$("#printBtn").click( function(){
		window.print();
	});
});
</script>

<script type="text/javascript">
$(function(){
	
	var array = ['tgl','ms','kd'];
	
	var hide_tgl = $("#tgl").hide();
	var hide_kode = $("#kd").hide();
	var hide_masa = $("#ms").hide();
	
	toggle_block( $("#berdasarkan").val() );
	
	$("#berdasarkan").change(function(){
		
		var val = this.value;
		
		if(this.value=="0") {
			hide_tgl.hide();
			hide_kode.hide();
            hide_masa.hide();
		} else if(this.value=="kode"){
            hide_tgl.hide();
			hide_kode.show();
            hide_masa.hide();            
		} else if(this.value=="masa_berlaku"){
			hide_tgl.hide();
			hide_kode.hide();
            hide_masa.show();
		} else if(this.value=="tanggal_entri"){
			hide_tgl.show();
			hide_kode.hide();
            hide_masa.hide();		
		} else{
			hide_tgl.hide();
			hide_kode.hide();
            hide_masa.hide();
			toggle_block(val);
		}
		
	});
	
	function toggle_block(n) {
			
		for(var i=0; i<array.length; i++) {
			if(array[i]==n) {
				$("[name="+n+"]").val('');
				$("#"+n).show();
			} else {
				$("#"+array[i]).hide();
			}
		}

	}
	
	
});
</script>

