
<div class="clearfix">&nbsp;</div>

<div class="alert alert-error">404 Halaman tidak diketemukan.</div>

<?php echo ($this->session->flashdata('error')) ? '<div class="alert alert-important">'.$this->session->flashdata('error').'</div>' : NULL ; ?>

<?php echo ($this->session->flashdata('success')) ? '<div class="alert alert-success">'.$this->session->flashdata('success').'</div>' : NULL ; ?>