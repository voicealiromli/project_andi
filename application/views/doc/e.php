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
		<a href="javascript:;" class="btn btn-danger pull-right" id="deletelink" rel="<?php echo site_url('doc/d/'.$records->idn)?>" title="Hapus dokumen"><i class="icon-trash icon-white"></i> Hapus Dokumen</a>  
		<?php endif; ?>			
	</div>
  <h2>Profil Dokumen</h2>
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
		<legend>Alamat Penyimpanan Dan File</legend>
	     <a href="#" id="tambah-data" class="btn btn-primary btn-sm" title="Tambah Folder">Tambah Folder</a>
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
	
	loadData(idData);
	
	
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
						
					'</table>'+
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
		var thiss = $(this);
		
		var id = thiss.parent().parent().parent().find("#hid-id-folder").val();
		
		if(id===undefined)
		{
			
				thiss.parent().parent().parent().next().remove();
				thiss.parent().parent().parent().remove();
			
		}
		else
		{		
		
				var result = confirm("Anda akan menhapus folder beserta semua isinya \n Apakah yakin ? ");
				if (result) {
					
					var id = thiss.parent().parent().parent().find("#hid-id-folder").val();
				
					$.ajax({
							type: "POST",
							url: base_url+"index.php/doc/delFolder",
							data: {data:id},
							dataType: "json",  
							cache:false,
							success: function(resp) {
								  console.log(resp.msg);
								  if(resp.success === "OK")
								  {
									  //nama_file
									  for(var i=0; i<resp.msg.length; i++)
									  {
										  ms = '<div class="alert alert-succes">Dokumen dokumen berhasil dihapus '+resp.msg[i]['nama_file']+'</div>';
										  $(ms).insertBefore(".breadcrumb");
									  }	  
									  
									  thiss.parent().parent().parent().next().remove();
									  thiss.parent().parent().parent().remove();
									  
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
		}
		
		
	});
	

	$('body').on('click','#btn-del-dok',function(){
		
		var thiss = $(this).parent().parent();
		
		if($(this).parent().parent().find("#id_dokumen_file").val()===undefined)
		{
			thiss.remove();
		}
		else
        {			
		
			var result = confirm("Anda akan menhapus dokumen "+thiss.find('b').text()+" ?");
			if (result) {
				
				var id = $(this).parent().parent().find("#id_dokumen_file").val();
			
				$.ajax({
						type: "POST",
						url: base_url+"index.php/doc/delDokumen",
						data: {data:id},
						dataType: "json",  
						cache:false,
						success: function(resp) {
							  if(resp.success === "OK")
							  {
								  ms = '<div class="alert alert-succes">'+resp.msg+'</div>';
								  $(ms).insertBefore(".breadcrumb");
								  //location.reload();
								  thiss.remove();
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
		
		}
		
	});
	
	$('body').on('click','#btn-view-dok',function(){
		var vas = $(this).parent().parent().find('#id_dokumen_file').val();
		$('#myModal'+vas+'').modal();
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
		data_berkas.idn = $('#idn').val();
		data_berkas.jenis_berkas = $('#jenis_berkas').val();
		data_berkas.no_polis =  $('#no').val();
		data_berkas.nama_dokumen = $('#name').val();
		data_berkas.tahun= $('#thn').val();
		data_berkas.category = $('#category').val();
		data.berkas = data_berkas;
		
		var fd = new FormData();
		var dat2 = [];
		var ar_file = new Array();
		$('body').find('#myTable').find('tbody').find('.rw-hed').each(function(index) {
			var dat = new Object();
			var nama_f = $(this).find("#folder_name").val(); 
			dat.nama_folder =  $(this).find("#folder_name").val(); 
			dat.id_folder =  ($(this).find("#hid-id-folder").val() ==undefined ) ? "undefined" : $(this).find("#hid-id-folder").val(); 
			dat.box  =  $(this).find("#box").val(); 
			dat.rak  =  $(this).find("#rak").val(); 
			dat.blok =  $(this).find("#blok").val(); 
			//var fd2 = new FormData();
			var dat21 = [];
			//var dat4 = new Array();
			$(this).next('tr').find('table').find('tr').each(function(idx){
				 var dat3 = new Object();
				 //dat3.id_dokumen_file =  $(this).find("#id_dokumen_file").val(); 
				 d  = $(this).find("#file")[0].files[0]; 
				 d2  = $(this).find("#file")[0].files[0]; 
				 
				 if(d!==undefined && $(this).find("#id_dokumen_file").val()==undefined )
				 {
				 	 d=$(this).find("#file")[0].files[0]; 
					 dat3.id_dokumen_file = "undefined"; //id_dokumen_file
					 dat3.file = d; // ketika ada penambahan tidak kosong
				 }	
				 
				 else if(d===undefined && $(this).find("#id_dokumen_file").val()==undefined )
				 {
				 	 d="undefined";
					 dat3.id_dokumen_file = "undefined"; //id_dokumen_file
					 dat3.file = d; // ketika ada penambahan  kosong
				 }	

                 else if(d===undefined && $(this).find("#id_dokumen_file").val()!="" )
				 {
					 d="no_update";
					 dat3.id_dokumen_file = $(this).find("#id_dokumen_file").val();
					 dat3.file = d; // tidak diupdate
				 }
                 else if(d!==undefined && $(this).find("#id_dokumen_file").val()!="" )
				 {
					 d="update";
					 dat3.file = d; // diupdate
					 dat3.id_dokumen_file =  $(this).find("#id_dokumen_file").val();
				 }		
               				 
				 fd.append('files['+nama_f+']['+idx+']',d2);
				 dat21.push(dat3);
			});
			dat.id_dokumen = dat21; 
			dat2.push(dat);
		});
		data.data_header_row = dat2;
		var dd = JSON.stringify(data);
		fd.append('data',dd);
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
					
					//console.log(data.data_header_row[i]['id_dokumen']);
					if(data.data_header_row[i]['id_dokumen'].length == 0 )
					{
						alert("File dokumen pada folder '"+data.data_header_row[i]['nama_folder'] +"' masih kosong");
						cek = false;
					}
                    else
                    {
						for(var j=0; j<data.data_header_row[i]['id_dokumen'].length; j++)
						{
							if(data.data_header_row[i]['id_dokumen'][j]['file']=="undefined")
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
			//alert("ngesave");
		}	
		
	});
});	

function saving(fd)
{
	$.ajax({
			url: base_url+"index.php/doc/updateDokumen",
			type: 'POST',
			cache: false,
			dataType: "json",
			contentType: false,
			processData: false, 
			data : fd,
			success: function(resp) {
				  if(resp.success === "OK")
				  {
					  //ms = '<div class="alert alert-succes">'+resp.msg+'</div>';
					  //$(ms).insertBefore(".breadcrumb");
					  alert("Data dokumen sudah diupdate");
					  location.reload();
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

function loadData(id)
{
	$.ajax({
			type: "POST",
			url: base_url+"index.php/doc/loadData",
			data: {data:id},
			dataType: "json",  
			cache:false,
			success: function(resp) {
				  if(resp.success === "OK")
				  {
					   $('body').find('#myTable').find('tbody').html("");
					   var kl = "";
					   var wa = '&nbsp; <a class="btn btn-mini" id="btn-del">Del</a>';
					   var n = 0;
					   for(var i=0; i<resp.msg.length; i++)
					   {
							
							var t ='';
							if(i==0)
							{
								t ='';
								
							}
							else
							{
								
								t ='&nbsp; <a class="btn btn-mini" id="btn-del">Del</a>';
							}		
								
							
							la = '<tr class="rw-hed">'+
								 '<td>'+
									'<div style="width:130px;">'+
										'<a class="btn btn-mini" id="btn-lampiran">Add File</a>'+t+
									'</div>'+
								'</td>'+
								'<td><input type="hidden" id="hid-id-folder" value="'+resp.msg[i]['id_folder']+'" /><input type="text" class="form-control" id="folder_name" placeholder="Nama Folder" style="width:150px;" value="'+resp.msg[i]['nama_folder']+'"></td>'+
								'<td><input type="text" class="form-control" id="box" placeholder="BOX" style="width:150px;" value="'+resp.msg[i]['box']+'"></td>'+
								'<td><input type="text" class="form-control" id="blok" placeholder="BLOK" style="width:100px;" value="'+resp.msg[i]['blok']+'"></td>'+
								'<td><input type="text" class="form-control" id="rak" placeholder="RAK" style="width:100px;" value="'+resp.msg[i]['rak']+'"></td>'+
							'</tr>'+
							'<tr class="rw-w" style="">'+
							   '<td colspan="5">'+
									'<table class="rw-t" style="width:100%;">';
									la = la + child(resp.msg[i]['data_dokumen'],resp.msg[i]['id_folder']);
									la = la + '</table>'+
								'</td>'+
							'</tr>';
						     kl = kl.concat(la);
							 //n++;
					   }
					   $('#myTable').find('tbody').html(kl)
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
function child(data,id) 
{
	var k = "";
	for(var i=0; i<data.length; i++)
	{
	  m = '<tr>'+
			   '<td><input type="hidden" id="view-dok-hid" value="'+data[i]['nama_file']+'"><input type="hidden" value="'+data[i]['id_dokumen_file']+'" id="id_dokumen_file"></td>'+
			   '<td>Ubah File</td>'+
			   '<td><input type="file" class="input-xlarge" id="file" name="name"/></td>'+
			   '<td><b>'+data[i]['nama_dokumen']+'</b>'+modal(data[i]['id_dokumen_file'],data[i]['nama_file'],data[i]['nama_dokumen'])+'</td>'+
			   '<td>'+
					'<a class="btn btn-mini" id="btn-del-dok">Del</a>'+
					'<a class="btn btn-mini" id="btn-view-dok" >View</a>'+
			   '</td>'+
		   '</tr>';
      k = m.concat(k);
	}	
	return k;
}

function modal(id,file,dokumen)
{
   var ss = '<div id="myModal'+id+'" class="modal fade myModal" role="dialog">'+
				'<div class="modal-dialog modal-lg">'+
					'<div class="modal-content">'+
						'<div class="modal-header">'+
							'<button type="button" class="close" data-dismiss="modal">&times;</button>'+
							'<h4 class="modal-title">'+dokumen+'</h4>'+
						'</div>'+
						'<div class="modal-body">'+
							'<embed  src="'+base_url+"uploads/"+file+'.pdf" frameborder="0" width="100%" height="400px"/>'+
							'<div class="modal-footer">'+
								'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'+
							'</div>'+
						'</div>'+ 
					'</div>'+
				'</div>'+
			'</div>';
	return ss;
}
</script>