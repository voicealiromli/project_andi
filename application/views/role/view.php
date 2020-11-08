
<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Daftar</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Daftar Role</a></li>
</ul>

<div class="page-header">
  <a href="<?php echo site_url('role/a')?>" class="btn btn-primary pull-right"><i class="icon-plus-sign icon-white"></i> Buat Baru</a>
	<h2>Daftar Role</h2>
</div>

<link rel="stylesheet" href="<?php echo base_url('assets/css/datatable.css')?>">

<table class="display" id="xtable">
	<thead>
		<tr>
			<th>Judul</th>
			<th>Penjelasan</th>
			<th>#</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="3" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
</table>
 
</form>
  
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript" charset="utf-8">
var oTable;

$(document).ready(function() {
	
	oTable = $('#xtable').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 2 ] } ],
		"iDisplayLength": 10,
		"bProcessing": true,
		"bServerSide": true,
		"bAutoWidth": false,
		"sAjaxSource": "<?php echo site_url('role/json_data')?>",
		"fnServerParams": function ( aoData ) {
					aoData.push( { "name": "<?php echo $this->config->item('csrf_token_name')?>", "value": "<?php echo $this->security->get_csrf_hash()?>" } );
			}
	} );	
	
} );
</script>