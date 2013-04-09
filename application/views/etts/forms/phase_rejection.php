<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2>Reason for rejection</h2>
			</div>
			<div class="box-content">
				
				<form action="<?=base_url()?>etts/phase_rejection/<?=$this->uri->segment(3)?>/<?=$this->uri->segment(4)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
					<fieldset>
						<div class="control-group">
							<label class="control-label" for="messsage">Message</label>
							<div class="controls">
								<textarea name="message" id="message"></textarea>
							</div>
						</div>
						<input type="hidden" name="submitted" />
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">Send Email</button>
							<a href="<?=base_url()?>" class="btn">Cancel</a>
						</div>
					</fieldset>
				</form>
				
			</div>
		</div><!--/span-->
	
	</div><!--/row-->
<?
/* End of file rejection.php */
/* Location: ./application/views/etts/forms/rejection.php */