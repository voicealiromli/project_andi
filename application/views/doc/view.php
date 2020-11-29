<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Daftar Dokumen</a></li>
</ul>

<div class="page-header">
	<?php if($this->model_session->auth_display('document', 3)):?>
	
		<!-- 
		<a href="<?php echo site_url('doc/a')?>" class="btn btn-primary pull-right"><i class="icon-plus-sign icon-white"></i> Buat Baru</a>
		<a href="<?php echo site_url('search/file')?>" class="btn btn-warning pull-right"><i class="icon-zoom-in icon-white"></i> Pencarian File</a>
		-->
		
		<!-- 
		<select onchange="navigateTo(this, 'window', false);" class="pull-right" style="margin-right:10px;">
		<option value="<?php echo site_url('doc/')?>"> Filter </option>
		<?php foreach($cat as $c):?>
		<option value="<?php echo site_url('doc/filter/'.$c->categoryID)?>"><?php echo $c->category_name?></option>
		<?php endforeach;?>
		</select>
		-->

  <?php endif?>
	<div class="btn-group pull-right">
		<a href="<?php echo site_url('doc/a')?>" class="btn btn-primary pull-right"><i class="icon-plus-sign icon-white"></i> Buat  Baru</a>
	</div>
  
	<h2>Daftar Arsip Dokumen</h2>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-latest.js')?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.tablesorter.min.js')?>"></script> 

<link rel="stylesheet" href="<?php echo base_url('assets/css/datatable.css')?>">

<!--
<form action="<?php echo site_url('doc/datasearch') ?>" method="post" style="text-align:right;margin-bottom:5px" id="myKey">
	<input type="text" name="search" id="search">
	<input type="submit" class="btn btn-primary" value="Search" style="margin-top: -11px;">
</form>
-->

<table class="table table-condensed display" id="myTable">
	<thead>
		<tr>
			<th width="35">No</th>
			<th>NO. POLIS</th>
			<th>NAMA</th>
			<th>JENIS DOKUMEN</th>
			
			<th>TAHUN DOKUMEN</th>
			<th>TANGGAL UPLOAD</th>
			<th>PETUGAS</th>
			<th>ACTIONS</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="11" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
</table>
 
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	
	
	oTable = $('#myTable').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 7 ] } ],
		"bProcessing": true,
		"bServerSide": true,
		"bAutoWidth": false,
		"sAjaxSource": "<?php echo site_url('doc/json_data_doc')?>"
		
	} );
	
	
});
</script>