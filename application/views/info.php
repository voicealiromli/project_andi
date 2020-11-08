<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Tentang <?php echo $this->config->item('app_abbr').' - '.$this->config->item('app_name')?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="mmediadata.com">
</head>

<body>

<p>
  <h3><?php echo $this->config->item('app_abbr').' - '.$this->config->item('app_name')?></h3>
  <small>Aplikasi pengarsipan digital surat-surat/dokumen penting.</small>
</p>

<p>
  <span><strong>Versi:</strong> &nbsp;<?php echo $this->config->item('app_ver')?></span><br>
  <span><strong>Tahun:</strong> &nbsp;Januari 2013</span><br>
  <span><strong>Update:</strong> &nbsp;<span id="updater"><?php echo ($updates)?></span></span>
</p>

</body>
</html>