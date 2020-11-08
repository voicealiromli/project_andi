<ul class="breadcrumb">
  <li class="btn-back"><a href="javascript:history.go(-1);" class="btn btn-mini btn-info">Kembali</a></li>
  <li><a href="<?php echo site_url()?>" class="btn btn-mini"><i class="icon-home"></i></a></li>
  <li><a href="<?php echo site_url('log')?>" class="btn btn-mini">Log</a></li>
  <li><a href="javascript:;" class="btn btn-mini disabled">Informasi Log</a></li>
</ul>

<div class="page-header">
  <h2>Informasi Log</h2>
</div>


<table class="table">
<tbody>

<tr>
	<th width="100">User</th>
	<td><?php echo $records->userFname?></td>
</tr>

<tr>
	<th width="100">Waktu</th>
	<td><?php echo $records->log_date?></td>
</tr>

<tr>
	<th width="100">IP</th>
	<td><?php echo $records->log_ip?></td>
</tr>

<tr>
	<th width="100">Browser</th>
	<td><?php echo $records->log_agent?></td>
</tr>

<tr>
	<th width="100">Aktivitas</th>
	<td><?php	if(strstr($records->log_activity, 'Data=>')) {
		$data = explode('Data=>', $records->log_activity);
		echo $data[0];
		echo '<hr>';
		echo strip_tags($data[1]);
	} else {
		echo $records->log_activity;
	}?></td>
</tr>

</tbody>
</table>