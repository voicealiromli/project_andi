<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Daftar Dokumen</a></li>
</ul>

<div class="page-header">
	<?php if($this->model_session->auth_display('document', 3)):?>
	
		<!-- 
		<a href="<?php echo site_url('doc/a')?>" class="btn btn-primary pull-right"><i class="icon-plus-sign icon-white"></i> Buat Baru</a>
		<a href="<?php echo site_url('search/file')?>" class="btn btn-warning pull-right"><i class="icon-zoom-in icon-white"></i> Pencarian File</a>
		-->
		
		<!-- 
		<select onchange="navigateTo(this, 'window', false);" class="pull-right" style="margin-right:10px;">
		<option value="<?php echo site_url('doc/')?>"> Filter </option>
		<?php foreach($cat as $c):?>
		<option value="<?php echo site_url('doc/filter/'.$c->categoryID)?>"><?php echo $c->category_name?></option>
		<?php endforeach;?>
		</select>
		-->

  <?php endif?>
	<h2>Daftar Dokumen</h2>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-latest.js')?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.tablesorter.min.js')?>"></script> 
<!-- 
<select name="part" id="jumpmenu">
	<option value="<?php echo site_url('doc/index/idn/25/25')?>">25</option>
	<option value="<?php echo site_url('doc/index/idn/50/50')?>">50</option>
	<option value="<?php echo site_url('doc/index/idn/100/100')?>">100</option>
</select>
 -->
<form action="<?php echo site_url('doc/datasearch') ?>" method="post" style="text-align:right;margin-bottom:5px" id="myKey">
	<input type="text" name="search" id="search">
	<input type="submit" class="btn btn-primary" value="Search" style="margin-top: -11px;">
</form>
<?php
// echo "<pre>";
// var_dump($doc);
// exit;
?>
<table class="table tablesorter" id="myTable"> 
	<thead>
		<tr>
			<th width="100">#</th>
			<th>NO. POLIS</th>
			<th>NAMA</th>
			<th>JENIS DOKUMEN</th>
			<th>BOX</th>
			<th>BLOK</th>
			<th>RAK</th>
			<th>TAHUN DOKUMEN</th>
			<th>TANGGAL UPLOAD</th>
			<th>PETUGAS</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($doc as $row){?>
			<tr>
				<td>
					<a href="<?php echo site_url('doc/dk/'.$row->idn);?>" class="btn btn-mini" title="Edit"><i class="icon-pencil"></i></a>
                    <?php if ($this->model_session->auth_display('document', 3)): ?>
					<a href="<?php echo site_url('doc/p/'.$row->idn);?>" class="btn btn-mini btn-warning" title="Print Barcode" target="_blank"><i class="icon-barcode icon-white"></i></a>
					<a href="<?php echo site_url('doc/d/'.$row->idn);?>" class="btn btn-mini btn-danger" title="Hapus" id="deleteBtn" onClick="return confirm(\'Anda yakin akan menghapus data?\')"><i class="icon-trash icon-white"></i></a>
                    <?php endif; ?>			
				</td>
				<td><?php echo $row->no;?></td>
				<td><?php echo $row->klien;?></td>
				<td><?php echo $row->ctr;?></td>
				<td><?php echo $row->box;?></td>
				<td><?php echo $row->lemari;?></td>
				<td><?php echo $row->laci;?></td>
				<td><?php echo $row->cyear;?></td>
				<td><?php echo $row->cdt;?></td>
				<td><?php echo $row->cby;?></td>
			</tr>
		<?php }?>
	</tbody>
</table>

<div class="pagination">
	<div class="span2" style="margin-top: 8px;color: #fff;" >
		<b><?php echo 'Total : ' .$all. ' data' ?></b>
	</div>
  <ul class="pages"> 
	  <li><?php echo $this->pagination->create_links();?></li>
  </ul>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	$("#myTable").tablesorter(); 
		  
	var timeoutID = null;

	function findMember(str) {
		console.log('search: ' + str);
		$('#myKey').submit();
	}

	$('#search').keyup(function() {
		clearTimeout(timeoutID);
		var $target = $(this);
		timeoutID = setTimeout(function() { findMember($target.val()); }, 3000); 
	});
});
</script>