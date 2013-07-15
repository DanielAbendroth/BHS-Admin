<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	
	<form class="form-horizontal" method="post" action="<?=base_url().'employees/email'?>">
			
		<div class="control-group">
			<label class="control-label">Send to</label>
			<div class="controls">
				<span class="input-xlarge uneditable-input"><?=$email?></span>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="subject">Subject</label>
			<div class="controls">
				<input class="input-xlarge focused" id="subject" name="subject" type="text" style="width: 80%">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="message">Message</label>
			<div class="controls">
				<textarea name="message" id="message" style="width: 80%" rows="10"></textarea>
			</div>
		</div>
		
		<input type="hidden" name="submitted" id="submitted" value="TRUE" />
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Send</button>
		</div>
	</form>
<?
/* End of file email_view.php */
/* Location: ./application/views/employees/email_view.php */