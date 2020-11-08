<div class="page-header">
  <div class="help-inline pull-right"><span class="important">*harus diisi</span></div>
  <h1>Laporkan Bug</h1>
</div>

<?php echo form_open(site_url('bug/send'), array('class'=>'form-horizontal', 'id'=>'xform'));?>
<fieldset>

<div id="status"></div>

<div class="control-group">
  <label class="control-label"><strong>Pesan Error / Isi Laporan</strong><span class="important">*</span></label>
  <div class="controls">
  	<textarea name="message" rows="10" class="input-xxlarge"></textarea>
    <?php echo form_error('message')?>
  </div>
</div>

<div class="form-actions">
  <input type="submit" class="btn btn-large btn-primary" value="Kirim Pesan" />
  <input type="reset" class="btn btn-large" value="Reset" />
</div>

</fieldset>
<?php echo form_close();?>