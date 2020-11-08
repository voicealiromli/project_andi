<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Daftar Departemen</a></li>
</ul>

<div class="page-header">
	<?php if($this->model_session->auth_display('role', 1)):?>
  <a href="<?php echo site_url('department/a')?>" class="btn btn-primary pull-right"><i class="icon-plus-sign icon-white"></i> Buat Baru </a>
  <?php endif?>
	<h2>Daftar Departemen</h2>
</div>

<link rel="stylesheet" href="<?php echo base_url('assets/css/datatable.css')?>">

<table class="table table-condensed display" id="xtable">
	<thead>
		<tr>
			<th width="60">#</th>	
			<th>Kode</th>
			<th>Nama</th>
			<th>Deskripsi</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="3" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
</table>
  
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript" charset="utf-8">
var oTable;

$(document).ready(function() {
	
	oTable = $('#xtable').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0 ] } ],
		"iDisplayLength": 25,
		"bProcessing": true,
		"bServerSide": true,
		"bAutoWidth": false,
		"sAjaxSource": "<?php echo site_url('department/json_data')?>"
	} );	
} );
</script>