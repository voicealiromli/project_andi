<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('doc/')?>" class="btn btn-mini">Dokumen</a></li>
  <li><a href="<?php echo site_url('doc/search_content/'.$this->uri->segment(3))?>" class="btn btn-mini">Pencarian konten</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Hasil pencarian konten</a></li>
</ul>

<div class="page-header">
	<h2>Hasil pencarian konten</h2>
</div>

<h3>Pencarian anda adalah: <em>"<?php echo $keyword;?>"</em></h3>

<div class="clearfix">&nbsp;</div>

<h3>Hasil dari pencarian :</h3>

<div class="clearfix">&nbsp;</div>
    
<?php if(!empty($find)):?>

    <div id="content-pagination">
        <?php foreach($find as $key):?>
                <div class="alert alert-block">
                <h4>
                     <?php echo $key['title']?> 
                    <a href="<?php echo site_url('media/viewer/'.$key['fileID'])?>" title="<?php echo $key['title']?>" class="btn btn-large pull-right"><i class="icon-share"></i> Lihat</a>
                </h4>
                <h5><i class="icon-folder-open"></i> File: <?php echo $key['filename']?></h5>
                <p>Terdapat <strong><?php echo $key['match']?></strong> kata yang sama dengan pencarian anda.</p>
            </div>
        <?php endforeach?>
    </div>
    
<?php else:?>

	<h4 class="alert">Pencarian tidak memberikan hasil, <a href="javascript:history.go(-1);">kembali ke pancarian</a></h4>

<?php endif;?>
<script src="<?php echo base_url('assets/js/pagination.min.js')?>"></script>

<script>
$(document).ready(function(){
    $("#content-pagination").jPaginate({
	items: 10,
    previous: "<<",
	next: ">>",
	active: "active",
	pagination_class: "pagination center",
	}); 
});
</script>