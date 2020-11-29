<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('doc')?>" class="btn btn-mini">Daftar Dokumen</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Update Dokumen</a></li>
</ul>

<div class="page-header">
	<div class="btn-group pull-right">
	
		<a href="<?php echo site_url('doc/a')?>" class="btn btn-primary pull-right"><i class="icon-plus-sign icon-white"></i> Buat Baru</a>
		<?php if ($this->model_session->auth_display('document', 3)): ?>
		<!--
		<a href="javascript:;" class="btn btn-danger pull-right" id="deletelink" rel="<?php echo site_url('doc/d/'.$records->idn)?>" title="Hapus Arsip"><i class="icon-trash icon-white"></i> Hapus Arsip</a>  
		-->
		<?php endif; ?>			
	</div>
  <h2>Profil Arsip</h2>
</div>


<form class="form-horizontal alt1", id="form1">
	<input type="hidden" name="id" id="idn" value="<?php echo $id;?>">

		<div class="control-group">
			<label class="control-label"> Jenis Berkas </label>
			<div class="controls">
				<select class="" id="jenis_berkas">
					<?php
						foreach($jenis_berkas as $jb)
						{
							  if($jb['jenis_berkas_id']==$records->ctr)
							  {
								  echo "<option value='".$jb['jenis_berkas_id']."' selected>".$jb['nama']."</option>";
							  }
							  else
							  {
								  echo "<option value='".$jb['jenis_berkas_id']."' >".$jb['nama']."</option>";
							  }			
						  	
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="control-group"> 
		<label class="control-label"><span class="important">No. Polis </span></label> 
		<div class="controls">
		<input type="text" class="input-xlarge" id="no" name="no" placeholder="Isi Nomor" value="<?php  echo $records->no;?>"/>
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label"><span class="important">Nama Berkas</span></label>
		<div class="controls">
			<input type="text" class="input-xlarge" id="name" name="name" placeholder="Nama Debitur" value="<?php echo $records->klien;?>" /> 
		</div>
	  </div>
	  <div class="control-group">
		<label class="control-label">Tahun </label>
		<div class="controls">
			<input type="text" class="input-mini" id="thn" name="thn" placeholder="Tahun" value="<?php  echo $records->cyear;?>"/>
		</div>
	  </div>
		<!--<input type="hidden" name="category" id="category" value="02">-->
		<div class="clearfix">&nbsp;</div>
		<hr/>
	     
	  <div class="form-actions">
		<input type="button" class="btn btn-primary btn-large" id="save" value="Save"/>
	  </div>
</form> 
<style>

	.rw-t {
		border-top : 0px; 
	}
	.rw-t tr>td{
		border-top: 0px;
	} 

</style>	

<script>
$(document).ready(function () {
	idData = "<?php echo $id?>"; 
	
	$('body').on('click','#save',function(){
		//$('.page-loader').removeClass('hidden');
		var data = new Object();
		var data_berkas = new Object();
		data_berkas.idn = $('#idn').val();
		data_berkas.jenis_berkas = $('#jenis_berkas').val();
		data_berkas.no_polis =  $('#no').val();
		data_berkas.nama_dokumen = $('#name').val();
		data_berkas.tahun= $('#thn').val();
		//data_berkas.category = $('#category').val();
		data.berkas = data_berkas;
		
		
		//data.data_header_row = dat2;
		//var dd = JSON.stringify(data);
		
		//
		if(data.berkas.jenis_berkas=="")
		{
			alert("Jenis Berkas Kosong");
		}
		else if(data.berkas.no_polis == "")
		{
			alert("Nomor polis kosong");
		}	
		else if(data.berkas.nama_dokumen == "")
		{
			alert("Nama dokumen kosong");
		}	
		else if(data.berkas.tahun == "")
		{
			alert("Tahun kosong");
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
			url: base_url+"index.php/doc/updateArsip",
			type: 'POST',
			cache: false,
			dataType: "json",
			//contentType: false,
			//processData: false, 
			data : fd,
			success: function(resp) {
				  if(resp.success === "OK")
				  {
					  ms = '<div class="alert alert-succes">'+resp.msg+'</div>';
					  $(ms).insertBefore(".breadcrumb");
					  //alert("Data dokumen sudah diupdate");
					  //location.reload();
					  //$('body').find("input[type=text], textarea").val("");
					  //$('body').find("input[type=file], textarea").val("");
					  //$('body').find('#myTable').find('.rw-w').find('.rw-t').html('');
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


// function modal(id,file,dokumen)
// {
   // var ss = '<div id="myModal'+id+'" class="modal fade myModal" role="dialog">'+
				// '<div class="modal-dialog modal-lg">'+
					// '<div class="modal-content">'+
						// '<div class="modal-header">'+
							// '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
							// '<h4 class="modal-title">'+dokumen+'</h4>'+
						// '</div>'+
						// '<div class="modal-body">'+
							// '<embed  src="'+base_url+"uploads/"+file+'.pdf" frameborder="0" width="100%" height="400px"/>'+
							// '<div class="modal-footer">'+
								// '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
							// '</div>'+
						// '</div>'+ 
					// '</div>'+
				// '</div>'+
			// '</div>';
	// return ss;
// }
</script>