<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Daftar Arsip</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Daftar Folder</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Daftar File</a></li>
</ul>

<div class="page-header">
	<div class="btn-group pull-right">
		<a href="#" class="btn btn-primary pull-right" id="create-file" data-toggle="modal" data-target="#exampleModal"><i class="icon-plus-sign icon-white"></i> Upload File</a>
	</div>
	<h2>Daftar File Dari Folder (<?php echo $folder;?>), Arsip (<?php echo $arsip;?>)</h2>
</div>

<input type="hidden" id="idfolder" value="<?php echo $idfolder;?>" />
<!--<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-latest.js')?>"></script> -->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.tablesorter.min.js')?>"></script> 

<link rel="stylesheet" href="<?php echo base_url('assets/css/datatable.css')?>">

<table class="table table-condensed display" id="myTable">
	<thead>
		<tr>
			<th width="100">#</th>
			<th>NAMA DOKUMEN</th>
			<th>ACTIONS</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="3" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
</table>
  
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js')?>"></script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
        
      </div>
      <div class="modal-body">
	   
		<form class="pull-left" id="form2">
		  <input type="hidden" id="id_dokumen">
		  <input type="hidden" id="nama_file">
		  <input type="file" name="file" id="file" class="form-controls" placeholder="Upload File">
		</form>
			   
	  </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="save-file" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	
	oTable = $('#myTable').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 2 ] } ],
		"bProcessing": true,
		"bServerSide": true,
		"bAutoWidth": false,
		"sAjaxSource": "<?php echo site_url('doc/json_data_file')?>",
		"fnServerParams": function ( aoData ) {
            aoData.push( { "name": "idfolder", "value": $('#idfolder').val() } );
        }
	});
	
	$('#create-file').click(function(){
		  $('#form2')[0].reset();
	});	
	
	//btn-view-dok
	$('body').on('click','#btn-view-dok',function(){
		//var vas = $(this).parent().parent().find('#id_dokumen_file').val();
		var vas = $(this).attr('data');
		$('#myModal'+vas+'').modal();
		//alert("ok");
	});
	
	
	$('body').on('change','input[type=file]',function(event){
		var val = $(this).val().toLowerCase(),
            //regex = new RegExp("(.*?)\.(docx|doc|pdf|xml|bmp|ppt|xls)$");
            regex = new RegExp("(.*?)\.(pdf)$");
        if (!(regex.test(val))) {
            $(this).val('');
            alert('Hanya boleh pdf format');
        }
		
	});	
	
	$('body').on('click', '#deleteBtn', function(){
		idfol = $(this).attr('data');
		var result = confirm("Anda akan menhapus file ini, anda setuju ?");
		if (result) {
			$.ajax({
						type: "POST",
						url: base_url+"index.php/doc/delDokumen",
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
		$('#create-file').click();
		$('.modal-title').html('Edit File');
		
		$.ajax({
			type: "POST",
			url: base_url+"index.php/doc/loadDataFile",
			data: {data:idfol},
			dataType: "json",  
			cache:false,
			success: function(resp) {
				  if(resp.success === "OK")
				  {
					   //console.log(resp.msg[0].id_folder);
					   $('#id_dokumen').val(resp.msg[0].id_dokumen_file);
					   $('#nama_file').val(resp.msg[0].nama_file);
					   
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
		
		
		
	});
	
    
	$('body').on('click','#save-file',function(){
			
			var fd = new FormData();
			d = $("#file")[0].files[0];
			
			if(d===undefined)
			{
					alert("File belum dipilih");
			}	
			else
			{
				fd.append('files',d);
				fd.append('id_dokumen',$('#id_dokumen').val());
				fd.append('id_folder',$('#idfolder').val());
				fd.append('nama_file',$('#nama_file').val());
				var dd = JSON.stringify(fd);
				//fd.append('data',dd);
				$.ajax({
						url: base_url+"index.php/doc/insertFile",
						type: 'POST',
						cache: false,
						dataType: "json",
						contentType: false,
						processData: false, 
						data : fd,
						//headers: {
						//    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						//},
						success: function(resp) {
							  if(resp.success === "OK")
							  {
								  ms = '<div class="alert alert-succes">'+
											'<button type="button" class="close" data-dismiss="alert">&times;</button>'+resp.msg+
									   '</div>';
								  $(ms).insertBefore(".breadcrumb");
								  $('#id_dokumen').val('');
								  $('#file').val('');
								  $('#close').click();
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
	
});



</script>