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
    <input type="text" class="input-xlarge" id="no" name="no" placeholder="Isi Nomor"/>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label"><span class="important">Nama Berkas</span></label>
    <div class="controls">
		<input type="text" class="input-xlarge" id="name" name="name" placeholder="Nama Debitur" /> 
    </div>
  </div>
  <div class="control-group">
	<label class="control-label">Tahun </label>
	<div class="controls">
		<input type="text" class="input-mini" id="thn" name="thn" placeholder="Tahun" />
	</div>
  </div>
	<input type="hidden" name="category" id="category" value="02">
	<div class="clearfix">&nbsp;</div>
	<legend>Alamat Penyimpanan Dan File</legend>
</form>
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
   <input type="button" class="btn btn-primary btn-large" id="save" value="Save" />
</div>
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
	
	//$("#myTable").tablesorter(); 
	
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
		
		//alert("s");
	
		 var tr = $(this).parent().parent().parent();
		 //$(ks).insertAfter(tr);
		 
		 // k = '<table>'+
				// '<tr>'+
					// '<td>'+
					
					 // 'Adasdas adsasdasd adsasdasd  asdasdasdasdasdasdas'+
					
					// '</td>'+
				// '</tr>'+
			 // '</table>';
		 
		 //tr.next('.rw-w').css("display","block");
		 //tr.next('.rw-w').find('td').append('LLLLL');
	     //console.log(tr.next('.rw-w').find('td'));
		 var k = '<tr><td></td><td>File</td><td><input type="file" class="input-xlarge" id="file" name="name"/></td><td><a class="btn btn-mini" id="btn-del-dok">Del</a></td></tr>';
		 //$( k ).appendTo( tr.next('.rw-w').find('td').find('.rw-t') );
		 tr.next('.rw-w').find('.rw-t').append(k);
		 //tr.next('.rw-w').append(k)
		 //console.log();
	});
	
	$('body').on('click','#btn-del',function(){
		$(this).parent().parent().parent().remove();
		//$(this).parent().parent().parent().next('.rw-w').remove();
		
		
	});
	
	$('body').on('click','#btn-del-dok',function(){
		$(this).parent().parent().remove();
	});
	
	
	$('body').on('click','#save',function(){
		//$('.page-loader').removeClass('hidden');
		var data = new Object();
		var data_berkas = new Object();
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
			dat.box  =  $(this).find("#box").val(); 
			dat.rak  =  $(this).find("#rak").val(); 
			dat.blok =  $(this).find("#blok").val(); 
			
			var fd2 = new FormData();
			$(this).next('tr').find('table').find('tr').each(function(idx){
				var dat3 = new Object();
				//dat3.
				 d = $(this).find("#file")[0].files[0];
				//ar_file.push(fi);
				//console.log($(this).find("#file")[0].files[0]);
				//dat.f = fi;
				
				fd.append('files['+nama_f+']['+idx+']',d);
				//fd.append('files['+idx+']',d);
				//fd.append('files['+index+']['+idx+']',d);
				//fd.append('files[][]',d);
				
				
				
				
				
			});
			//fd.append('file',fd2);
			//dat.f = ar_file;
			dat2.push(dat);
			
			
		});
		
		
		
		
		
		data.data_header_row = dat2;
		//data.files = fd;
		 
		var dd = JSON.stringify(data);
		fd.append('data',dd);
		
		//console.log(fd);
		$.ajax({
                url: base_url+"index.php/doc/insertDokumen",
                type: 'POST',
                cache: false,
				
                dataType: "json",
                contentType: false,
                processData: false, 
                data : fd,
                ///headers: {
                //    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //},
                success: function(resp) {
                  //if(resp.responseCode === 200) {
                    // Reload datatable
                    // window.location.href = baseUrl+'/candidates';
                    
                    // Send success message
					 /* $.smallBox({
							height: 50,
							title : "Success",
							content : resp.responseMessage,
							color : "#109618",
							sound_file: "voice_on",
							timeout: 3000
							//icon : "fa fa-bell swing animated"
						});
					} else {
						$.smallBox({
							height: 50,
							title : "Error",
							content : resp.responseMessage,
							color : "#dc3912",
							sound_file: "smallbox",
							timeout: 3000
							//icon : "fa fa-bell swing animated"
						});
					} */
                // Hide loder
               // $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
               /*  $.smallBox({
                    title : "Error",
                    content : xhr.statusText,
                    color : "#dc3912",
                    timeout: 3000
                    //icon : "fa fa-bell swing animated"
                }); */
                // Hide loder
               // $('.page-loader').addClass('hidden');
            }
        });
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	});
	
});	

</script>