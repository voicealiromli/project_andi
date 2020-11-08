<link class="include" rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.jqplot.min.css')?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/charting.css')?>" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/shThemejqPlot.min.css')?>" />
<script class="include" type="text/javascript" src="<?php echo base_url('assets/js/jquery.jqplot.min.js')?>"></script>
<script class="include" type="text/javascript" src="<?php echo base_url('assets/js/jqplot.barRenderer.min.js')?>"></script>
<script class="include" type="text/javascript" src="<?php echo base_url('assets/js/jqplot.categoryAxisRenderer.min.js')?>"></script>
<style>
	.jqplot-title{
		text-align: left;
	}
</style>

<div class="clearfix">&nbsp;</div>
<ul class="breadcrumb">
  <li><a href="javascript:;" class="btn btn-mini disabled">Dashboard</a></li>
</ul>

<div class="page-header">
	<h2>Dashboard</h2>
</div>

<center>
    <div id="chart3" style="max-width:1834px;min-width: 300; height:300px;"></div>
</center>
<script>
	$(document).ready(function(){
	
	     plot3 = $.jqplot('chart3', [[
			 ['CLAIM',<?php echo $claim; ?>],
			 ['SPAJ',<?php echo $spaj; ?>],
			 ['ASKUM',<?php echo $askum; ?>]
		 ]],{
				title: '<h2>Volume Dokumen</h2>',
				seriesDefaults: {
					renderer:$.jqplot.BarRenderer
				},
				axes: {
					xaxis: {
						renderer: $.jqplot.CategoryAxisRenderer
					}
				}
			});
    
        $('#chart3').bind('jqplotDataHighlight', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info3').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
            
        $('#chart3').bind('jqplotDataUnhighlight', 
            function (ev) {
                $('#info3').html('Nothing');
            }
        );
});
</script>