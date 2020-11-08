
<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Back</a></li>
  <li><a href="<?php echo site_url('dashboard')?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Register Login</a></li>
</ul>

<div class="page-header">	
	<a href="javascript:;" rel="<?php echo site_url('log/admin_flush?url='.current_url())?>" class="btn btn-danger pull-right" id="warningBtn" title="Hapus semua log admin"><i class="icon-trash icon-white"></i> Delete All Logs</a>	<a href="<?php echo site_url('log/download')?>" class="btn pull-right" title="export file to excel"><i class="icon-file"></i> Excel</a>	
  <h2>Register Login</h2>
</div>

<link rel="stylesheet" href="<?php echo base_url('assets/css/datatable.css')?>">

<table class="display" id="xtable">
	<thead>
		<tr>
			<th>Date</th>
			<th>Users</th>
			<th>Ip</th>
			<th>Browser</th>
			<th>Activity</th>
			<th>Data</th>
			<th>Detail</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="7" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
</table>
  
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript" charset="utf-8">
var oTable;

$(document).ready(function() {
	
	$('#warningBtn').click(function(event){
		var href = $(this).attr('rel');
		var conf = confirm('Sure to delete the server event log? the data can not be restored.');
		if(conf==true) {
			window.location = href;
		} else {
			return false;
		}
	});
			
	$('#xxform').submit( function() {
			var sData = oTable.$('input').serialize();
			return false;
	} );
	
	oTable = $('#xtable').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		//"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0 ] } ],
		"iDisplayLength": 25,
		"bProcessing": true,
		"bServerSide": true,
		"bAutoWidth": false,
		"sAjaxSource": "<?php echo site_url('log/admin_json_data')?>",
		"fnServerParams": function ( aoData ) {
					aoData.push( { "name": "<?php echo $this->config->item('csrf_token_name')?>", "value": "<?php echo $this->security->get_csrf_hash()?>" } );
			}
	} );		
	
} );
</script>