<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-content">
						<form class="form-horizontal" method="post">
						<fieldset>
							<legend>Update Employee Information</legend>  
							<div class="control-group">
							  <label class="control-label" for="date">Date</label>
							  <div class="controls">
								<input type="text" class="input-xlarge datepicker" id="date" name="date">
								<p>i.e. 01/01/2013</p>
							  </div>
							</div>

							
							  <div class="form-actions">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<a href="<?=site_url()?>dashboard" class="btn">Cancel</a>
							  </div>
							</fieldset>
						  </form>
					
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
<?
/* End of file update_1-1.php */
/* Location: ./application/views/etts/forms/update_1-1.php */