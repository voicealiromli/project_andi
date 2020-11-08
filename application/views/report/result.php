<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('report')?>" class="btn btn-mini">Laporan</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Hasil</a></li>
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
    
    <div style="height:3px;"></div>
    <span style="width:50px; display:inline-block;">Sampai &nbsp;</span>
    <div class="input-prepend">
    <div class="date" data-date="" data-date-format="yyyy"><span class="add-on btn"><i class="icon-th"></i></span>
    <input type="text" class="input-small" id="edate" name="edate" placeholder="yyyy" value="<?php echo $this->input->post('edate')?>" />
    </div>
    </div>    
     
    </div>
  </div>
	<div class="control-group">
	<label class="control-label">Pilih Kolom</label>
		<div class="controls">
		<?php
			  $num = 1;
			  $total_fields = count($fields_doc);
			  $x = array('7','14','20');
			  
				foreach($fields_doc as $key=>$val)
				{
					echo ($num==1 || $num==$x[0]+1 || $num==$x[1]+1 || $num==$x[2]+1) ? '<div class="span2">' : NULL;
				  
					echo '<input type="checkbox" value="1" id="'.$key.'" name="fields_doc['.$key.']"'.(($num<=4)?' checked':NULL).' style="float:left"> 
							<label for="'.$key.'" style="float:left">&nbsp;&nbsp;&nbsp;'.$val.'</label> <br>';
				  
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

<hr class="normal">

<?php if($records):?>

<?php echo form_open(site_url('report/print_report'), array('class' => 'pull-left left', 'id' => 'printForm')) ?>
<input type="hidden" name="content_" id="content_" value="">
<button type="submit" class="btn" id="printBtn"> <i class="icon-print"></i> Print</button>
</form> 

<?php echo form_open(site_url('report/xls_p'), array('class' => 'pull-left left', 'id' => 'xlsForm')) ?>
<input type="hidden" name="content_" id="content_" value="">
<input type="hidden" name="bdate" id="bdate" value="">
<input type="hidden" name="edate" id="edate" value="">
<button type="submit" class="btn" id="xlsBtn"><i class="icon-file"></i> Excel</button>
</form>

<div class="clear"></div>

<div id="report-wrapper">
	
	<h4>Laporan</h4>

<p><strong>Total data: <?php echo count($records)?></strong></p>
		<table class="table">
		<thead><tr>
		<th>#</th>
		<?php
		foreach($fields as $key=>$val)
		{
			if(isset($fields_checked[$key]))
			{
				echo '<th>'.$val.'</th>';
			}
		}	
		?>
		</tr></thead>
		<tbody>
		<?php
			$search_array = array();
			$num=1;
			$colspan='';
			foreach($records as $key=>$val)
			{
				$colspan=1;
				echo '<tr>';
				echo '<td>'.$num.'</td>';
				foreach($fields as $a=>$b)
				{
					if(isset($fields_checked[$a]))
					{
						echo '<td>'.$val->$a.'</td>';
						$colspan++;
					}
				}
				echo '</tr>';
				$num++;
			}
		?>
		</tbody>
		<tfoot>
		<?php $t_n = $num - 1;?>
		<?php echo '<tr><th colspan="'.($colspan).'" class="center" style="color:#ffffff">Total hasil: '.$t_n.'</th></tr>';?>
		</tfoot>
		</table>

</div>
<?php else:?>
<h3 class="">There are no results</h3>
<?php endif;?>

<script type="text/javascript">
$(document).ready(function(){
 var content_ = $("#report-wrapper").html();

        $("#printForm").submit(function() {
            $("[id=content_]").val(content_);
        });

        $("#xlsForm").submit(function() {
            $("[id=content_]").val(content_);
        });
});
</script>

