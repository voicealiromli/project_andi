<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('doc')?>" class="btn btn-mini">Daftar Dokumen</a></li>
  
</ul>

<div class="page-header">
	<h2>Buat Baru</h2>
</div>


<form class="form-horizontal alt1", id="form1">
   <div class="control-group">
    <label class="control-label">Jenis Berkas </label>
    <div class="controls">
		<select class="" id="jenis_berkas">
			<?php
			
				foreach($jenis_berkas as $jb)
				{
				  echo "<option value='".$jb['jenis_berkas_id']."'>".$jb['nama']."</option>";	
				}
			
			?>
		</select>
    </div>
   </div>
   <div class="control-group">
    <label class="control-label"><span class="important">No. Polis </span></label> 
    <div class="controls">
    <input type="text" class="input-xlarge" id="no" name="no" placeholder="Isi Nomor" value=""/>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label"><span class="important">Nama Berkas</span></label>
    <div class="controls">
		<input type="text" class="input-xlarge" id="name" name="name" placeholder="Nama" /> 
    </div>
  </div>
  <div class="control-group">
	<label class="control-label">Tahun </label>
	<div class="controls">
		<input type="text" class="input-mini" id="thn" name="thn" placeholder="Tahun"  />
	</div>
  </div>
<!--<input type="hidden" name="category" id="category" value="02">-->
<div class="clearfix">&nbsp;</div>
<hr/>
<div class="form-actions">
   <input type="reset" class="btn btn-default  btn-large" id="reset" value="Reset" />
   <input type="button" class="btn btn-primary btn-large" id="save" value="Save" />
   
</div>
</form>

<script>
$(document).ready(function () {
	
	$('body').on('click','#reset',function(){
		
		  $(this).closest('form').find("input[type=text], textarea").val("");
		  $(this).closest('form').find("input[type=file], textarea").val("");
		  //location.reload(); rw-w rw-t
		  $('body').find('#myTable').find('.rw-w').find('.rw-t').html('');
		
	});
	
	
	
	$('body').on('click','#save',function(){
		//$('.page-loader').removeClass('hidden');
		var data = new Object();
		var data_berkas = new Object();
		data_berkas.jenis_berkas = $('#jenis_berkas').val();
		data_berkas.no_polis =  $('#no').val();
		data_berkas.nama_dokumen = $('#name').val();
		data_berkas.tahun= $('#thn').val();
		//data_berkas.category = $('#category').val();
		data.berkas = data_berkas;
		var dd = data;//JSON.stringify(data);
		
		//console.log(data.data_header_row);
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
			saving(dd); 
		}			
		
	});
	
});	

function saving(dd)
{
	$.ajax({
			url: base_url+"index.php/doc/insertArsip",
			type: 'POST',
			cache: false,
			dataType: "json",
			//contentType: false,
			//processData: false, 
			data : dd,
			//headers: {
			//    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			//},
			success: function(resp) {
				  if(resp.success === "OK")
				  {
					  ms = '<div class="alert alert-succes">'+resp.msg+'</div>';
					  $(ms).insertBefore(".breadcrumb");
					  $('body').find("input[type=text], textarea").val("");
					  $('body').find("input[type=file], textarea").val("");
					  $('body').find('#myTable').find('tbody').html('');
					  
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

</script>