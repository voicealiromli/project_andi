<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('doc')?>" class="btn btn-mini">Daftar Dokumen</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Buat Baru</a></li>
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
	<legend>Alamat Penyimpanan Dan File</legend>

<a href="#" id="tambah-data" class="btn btn-mini" title="Tambah">Tambah Folder</a>
<table class="table tablesorter" id="myTable" style="width:50%;"> 
	<thead>
		<tr>
			<th style="width:20%;">#</th>
			<th style="width:20%;">NAMA FOLDER</th>
			<th style="width:20%;">BOX</th>
			<th style="width:20%;">BLOK</th>
			<th style="width:20%;">RAK</th>
		</tr>
	</thead>
	<tbody class="tb">
		<tr class="rw-hed">
			<td>
				<div style="width:130px;">
					<a class="btn btn-mini" id="btn-lampiran">Add File</a> &nbsp; 
				</div>
			</td>
			<td><input type="text" class="form-control" id="folder_name" placeholder="Nama Folder" style="width:150px;"></td>
			<td><input type="text" class="form-control" id="box"  placeholder="BOX" style="width:150px;"></td>
			<td><input type="text" class="form-control" id="blok" placeholder="BLOK" style="width:100px;"></td>
			<td><input type="text" class="form-control" id="rak" placeholder="RAK" style="width:100px;"></td>
		</tr>
		<tr class="rw-w" style="">
			   
				<td colspan="5">
					
						<table class="rw-t" style="width:100%;">
							
						</table>
					
				</td>
	    </tr>
		
		
	</tbody>
</table>
<div class="form-actions">
   <input type="reset" class="btn btn-default  btn-large" id="reset" value="Reset" />
   <input type="button" class="btn btn-primary btn-large" id="save" value="Save" />
   
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
	
	$('body').on('click','#reset',function(){
		
		  $(this).closest('form').find("input[type=text], textarea").val("");
		  $(this).closest('form').find("input[type=file], textarea").val("");
		  //location.reload(); rw-w rw-t
		  $('body').find('#myTable').find('.rw-w').find('.rw-t').html('');
		
	});
	
	$('body').on('click','#tambah-data',function(){
		var k = '<tr class="rw-hed">'+
				 '<td>'+
					'<div style="width:130px;">'+
						'<a class="btn btn-mini" id="btn-lampiran">Add File</a> &nbsp; <a class="btn btn-mini" id="btn-del">Del</a>'+
					'</div>'+
				'</td>'+
				'<td><input type="text" class="form-control" id="folder_name" placeholder="Nama Folder" style="width:150px;"></td>'+
				'<td><input type="text" class="form-control" id="box" placeholder="BOX" style="width:150px;"></td>'+
				'<td><input type="text" class="form-control" id="blok" placeholder="BLOK" style="width:100px;"></td>'+
				'<td><input type="text" class="form-control" id="rak" placeholder="RAK" style="width:100px;"></td>'+
			'</tr>'+
			'<tr class="rw-w" style="">'+
			   '<td colspan="5">'+
					'<table class="rw-t" style="width:100%;">'+
						
					'</table>'
				'</td>'+
			'</tr>';
			
			
		$('body').find('#myTable').find('.tb').append(k);
	});
	
	$('body').on('click','#btn-lampiran',function(){
	
		 var tr = $(this).parent().parent().parent();
		 var k = '<tr><td></td><td>File</td><td><input type="file" class="input-xlarge" id="file" name="name"/></td><td><a class="btn btn-mini" id="btn-del-dok">Del</a></td></tr>';
		 tr.next('.rw-w').find('.rw-t').append(k);
	});
	
	$('body').on('click','#btn-del',function(){
		$(this).parent().parent().parent().next().remove();
		$(this).parent().parent().parent().remove();
		
	});
	
	$('body').on('click','#btn-del-dok',function(){
		$(this).parent().parent().remove();
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
		
		var fd = new FormData();
		var dat2 = [];
		var ar_file = new Array();
		$('body').find('#myTable').find('tbody').find('.rw-hed').each(function(index) {
			
			var dat = new Object();
			var nama_f = $(this).find("#folder_name").val(); 
			dat.nama_folder =  $(this).find("#folder_name").val(); 
			dat.box  =  $(this).find("#box").val(); 
			dat.rak  =  $(this).find("#rak").val(); 
			dat.blok =  $(this).find("#blok").val(); 
			
			//var fd2 = new FormData();
			var dat4 = new Array();
			$(this).next('tr').find('table').find('tr').each(function(idx){
				var dat3 = new Object();
				 d = $(this).find("#file")[0].files[0];
				 //console.log(d);
				 
				 if(d===undefined)
				 {
					 d="undefined";
				 }	 
				 dat3.file = d;
				 dat4.push(dat3);
				 fd.append('files['+nama_f+']['+idx+']',d);
				
			});
			dat.data_file = dat4;
			dat2.push(dat);
			
			
		});
		
		data.data_header_row = dat2;
		 
		var dd = JSON.stringify(data);
		fd.append('data',dd);
		
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
			var cek = true;
			for(var i=0; i<data.data_header_row.length; i++)
			{
			
				var b = i+1;
				if(data.data_header_row[i]['nama_folder']=="")
				{
					alert("Nama Folder Kosong pada baris folder ke "+ b);
				    cek = false;
				}
				else if(data.data_header_row[i]['box']=="")	
				{
					alert("Box Kosong pada baris folder ke "+ b);
					cek = false;
				}	
				else if(data.data_header_row[i]['rak']=="")	
				{
					alert("Rak Kosong pada baris folder ke "+ b);
					cek = false;
				}
				else if(data.data_header_row[i]['blok']=="")	
				{
					alert("Blok Kosong pada baris folder ke "+ b);
					cek = false;
				}
				else
				{
					
					if(data.data_header_row[i]['data_file'].length == 0 )
					{
						alert("File dokumen pada folder '"+data.data_header_row[i]['nama_folder'] +"' masih kosong");
						cek = false;
					}
                    else
                    {
						//console.log(data.data_header_row[i]['data_file']);
						for(var j=0; j<data.data_header_row[i]['data_file'].length; j++)
						{
							//console.log(data.data_header_row[i]['data_file'][j]['file']);
							if(data.data_header_row[i]['data_file'][j]['file']=="undefined")
							{
								alert("Ada File dokumen pada folder '"+data.data_header_row[i]['nama_folder'] +"' belum diisi !!");
								cek = false;
							}
							
						}	
					    	
					} 	
					
				}	
			
			}	
			
		}			
		
		if(cek==true)
		{
			saving(fd); 
		}	
	});
	
});	

function saving(fd)
{
	$.ajax({
			url: base_url+"index.php/doc/insertDokumen",
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
					  ms = '<div class="alert alert-succes">'+resp.msg+'</div>';
					  $(ms).insertBefore(".breadcrumb");
					  $('body').find("input[type=text], textarea").val("");
					  $('body').find("input[type=file], textarea").val("");
					  $('body').find('#myTable').find('tbody').html('');
					  
					  
					  var k = '<tr class="rw-hed">'+
						 '<td>'+
							'<div style="width:130px;">'+
								'<a class="btn btn-mini" id="btn-lampiran">Add File</a> &nbsp;'+
							'</div>'+
						'</td>'+
						'<td><input type="text" class="form-control" id="folder_name" placeholder="Nama Folder" style="width:150px;"></td>'+
						'<td><input type="text" class="form-control" id="box" placeholder="BOX" style="width:150px;"></td>'+
						'<td><input type="text" class="form-control" id="blok" placeholder="BLOK" style="width:100px;"></td>'+
						'<td><input type="text" class="form-control" id="rak" placeholder="RAK" style="width:100px;"></td>'+
						'</tr>'+
						'<tr class="rw-w" style="">'+
						   '<td colspan="5">'+
								'<table class="rw-t" style="width:100%;">'+
									
								'</table>'
							'</td>'+
						'</tr>';
					$('body').find('#myTable').find('.tb').append(k);
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