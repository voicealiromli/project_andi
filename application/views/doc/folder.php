<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('doc')?>" class="btn btn-mini ">Daftar Arsip</a></li>
  <li><a href="<?php echo site_url('doc/folder/'.$idn)?>" class="btn btn-mini ">Daftar Folder</a></li>
</ul>

<div class="page-header">
	<div class="btn-group pull-right">
		<a href="#" id="create-folder" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalfolder"><i class="icon-plus-sign icon-white"></i> Buat Folder</a>
	</div>
	<h2>Daftar Folder Dari Arsip (XXXXX)</h2>
</div>

<input type="hidden" id="idn" name="idn" value="<?php echo $idn?>">
<!--
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-latest.js')?>"></script> 
-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.tablesorter.min.js')?>"></script> 

<link rel="stylesheet" href="<?php echo base_url('assets/css/datatable.css')?>">

<table class="table table-condensed display" id="myTable">
	<thead>
		<tr>
			<th width="100">#</th>
			<th>NAMA FOLDER</th>
			<th>BOX</th>
			<th>BLOK</th>
			<th>RAK</th>
			<th>ACTIONS</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="6" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
</table>
  
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>


<div class="modal fade" id="modalfolder" tabindex="-1" role="dialog" aria-labelledby="modalfolderLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalfolderLabel">Buat Folder</h5>
        
      </div>
      <div class="modal-body">
	  
		<form class="form-horizontal alt1", id="form1">
		   <div class="control-group">
			<label class="control-label"><span class="important">Nama Folder </span></label> 
			<div class="controls">
			<input type="hidden" class="input-xlarge" id="idfolder" name="id-folder" />
			<input type="text" class="input-xlarge" id="nama-folder" name="nama-folder" placeholder="Nama Folder" value=""/>
			</div>
		  </div> 
		  <div class="control-group">
			<label class="control-label"><span class="important">Box</span></label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="box" name="box" placeholder="Box" /> 
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label"><span class="important">Blok</span></label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="blok" name="blok" placeholder="Blok" /> 
			</div>
		  </div>
		   <div class="control-group">
			<label class="control-label"><span class="important">Rak</span></label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="rak" name="rak" placeholder="Rak" /> 
			</div>
		  </div>
		
		<div class="clearfix">&nbsp;</div>
		<hr/>
		
		</form>
		
		
			   
	  </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="save-folder" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<script>
var oTable;

$(document).ready(function() {
	
	
	oTable = $('#myTable').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		//"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 5 ] } ],
		"bProcessing": true,
		"bServerSide": true,
		"bAutoWidth": false,
		"sAjaxSource": "<?php echo site_url('doc/json_data_folder')?>",
		
		"fnServerParams": function ( aoData ) {
            aoData.push( { "name": "idn", "value": $('#idn').val() } );
        }
	} );
	
	$('#create-folder').click(function(){
		  $('#form1')[0].reset();
	});	
	
	
	$('body').on('click', '#deleteBtn', function(){
		idfol = $(this).attr('data');
		
		//console.log($(this).closest('tr').find('td')[1]);
		
		 //var oTable = $('#myTable').dataTable();
         //console.log();
	     //alert( oTable.row( $(this) ).data() );
		 //alert('Data:'+$(this).html().trim());
		 //alert('Row:'+$(this).parent().find('td').html().trim());
		 //alert('Column:'+$('#example thead tr th').eq($(this).index()).html().trim());
		
		
		var result = confirm("Anda akan menhapus semua file yang berada dalam folder ini, anda setuju ?");
		if (result) {
			$.ajax({
						type: "POST",
						url: base_url+"index.php/doc/delFolder",
						data: {data:idfol},
						dataType: "json",  
						cache:false,
						success: function(resp) {
							  if(resp.success === "OK")
							  {
								  ms = '<div class="alert alert-succes">'+
										 '<button type="button" class="close" data-dismiss="alert">&times;</button>'+resp.msg+
								       '</div>';
								  $(ms).insertBefore(".breadcrumb");
								  //location.reload();
								  var oTable = $('#myTable').dataTable();
								  oTable.fnDraw();
							  }
							  else
							  {
								   ms = '<div class="alert alert-error">'+resp.msg+'</div>';
								   $(ms).insertBefore(".breadcrumb");
							  }		
						 
					},
					error: function(xhr, ajaxOptions, thrownError) {
					  
					}
				});
		} 
		
	});	
	
	
	
	$('body').on('click', '#open-edit', function(){
		idfol = $(this).attr('data');
		$('#create-folder').click();
		$('.modal-title').html('Edit Folder');
		
		$.ajax({
			type: "POST",
			url: base_url+"index.php/doc/loadDataFolder",
			data: {data:idfol},
			dataType: "json",  
			cache:false,
			success: function(resp) {
				  if(resp.success === "OK")
				  {
					   //console.log(resp.msg[0].id_folder);
					   $('#idfolder').val(resp.msg[0].id_folder);
					   $('#nama-folder').val(resp.msg[0].nama_folder);
					   $('#box').val(resp.msg[0].box);
					   $('#blok').val(resp.msg[0].blok);
					   $('#rak').val(resp.msg[0].rak);
				  }
				  else
				  {
					   ms = '<div class="alert alert-error">'+
								'<button type="button" class="close" data-dismiss="alert">&times;</button>'+resp.msg+
							'</div>';
					   $(ms).insertBefore(".breadcrumb");
				  }		
		    },
            error: function(xhr, ajaxOptions, thrownError) {
            }
        }); 
		
		
		
	});
		
	$('#save-folder').click(function(){
		//$('.page-loader').removeClass('hidden');
		//var data = new Object();
		var data = new Object();    
		data.nama_folder = $('#nama-folder').val();
		data.box = $('#box').val();
		data.blok =  $('#blok').val();
		data.rak = $('#rak').val();
		data.idn = $('#idn').val();
		data.idfolder = $('#idfolder').val();
		//data_berkas.tahun= $('#thn').val();
		//data_berkas.category = $('#category').val();
		//data.berkas = data_berkas;
		
		if(data.nama_folder=="")
		{
			alert("Nama Folder masih kosong");
		}
		else if(data.box == "")
		{
			alert("Box masih kosong");
		}	
		else if(data.blok == "")
		{
			alert("Blok masih kosong");
		}	
		else if(data.rak == "")
		{
			alert("Rak masih kosong");
		}
        else
		{
			saving(data); 
		}	
		
		
	});	
	
});

function saving(fd)
{
	$.ajax({
			url: base_url+"index.php/doc/foldersave",
			type: 'POST',
			cache: false,
			dataType: "json",
			//contentType: false,
			//processData: false, 
			data : fd,
			success: function(resp) {
				  if(resp.success === "OK")
				  {
					  
					  $('#close').click();
					  var oTable = $('#myTable').dataTable();
					  oTable.fnDraw();
					 
					  ms = '<div class="alert alert-succes">'+
								'<button type="button" class="close" data-dismiss="alert">&times;</button>'+resp.msg+
							'</div>';
					  $(ms).insertBefore(".breadcrumb");
					 
				  }
				  else
				  {
					   ms = '<div class="alert alert-error">'+
								'<button type="button" class="close" data-dismiss="alert">&times;</button>'+resp.msg+
					        '</div>';
					   $(ms).insertBefore(".breadcrumb");
				  }		
			 
			},
			error: function(xhr, ajaxOptions, thrownError) {
			  
			}
	});
}

</script>