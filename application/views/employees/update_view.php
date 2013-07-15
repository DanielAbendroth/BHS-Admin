<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	
	<?=validation_errors(); ?>
	
	<form class="form-horizontal" method="post" action="">
		
		<div class="control-group">
			<label class="control-label" for="first_name">First Name</label>
			<div class="controls">
				<input class="input-xlarge focused" id="first_name" name="first_name" type="text" style="width: 80%" value="<?=set_value('first_name',$first_name)?>">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="last_name">Last Name</label>
			<div class="controls">
				<input class="input-xlarge focused" id="last_name" name="last_name" type="text" style="width: 80%" value="<?=set_value('last_name',$last_name)?>">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="email">Email</label>
			<div class="controls">
				<input class="input-xlarge focused" id="email" name="email" type="text" style="width: 80%" value="<?=set_value('email',$email)?>">
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="phone">Phone</label>
			<div class="controls">
				<input class="input-xlarge focused" id="phone" name="phone" type="text" style="width: 80%" maxlength="10"  value="<?=set_value('phone',$phone)?>">
				<p class="help-block">ex. 3145551234</p>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="hire_date">Hire Date</label>
			<div class="controls">
				<input class="input-xlarge focused" id="hire_date" name="hire_date" type="text" style="width: 80%" maxlength="8" value="<?=set_value('hire_date',$hire_date)?>">
				<p class="help-block">ex. 01232011</p>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="position">Posistion</label>
			<div class="controls">
			  <select id="position" name="position">
				<option value="1" <?=set_select('position',1)?> >Assistant</option>
				<option value="2" <?=set_select('position',2)?> >Office Aid</option>
				<option value="3" <?=set_select('position',3)?> >Assistant/Office Aid</option>
				<option value="4" <?=set_select('position',4)?> >Consultant</option>
				<option value="5" <?=set_select('position',5)?> >Consultant/Office Aid</option>
				<option value="6" <?=set_select('position',6)?> >Senior Behavior Consultant</option>
				<option value="7" <?=set_select('position',7)?> >Vice President/Consultant</option>
				<option value="8" <?=set_select('position',8)?> >President/Consultant</option>
			  </select>
			</div>
		  </div>

		<input type="hidden" name="submitted" id="submitted" value="TRUE" />
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</form>

<?
/* End of file update_view.php */
/* Location: ./application/views/employees/uodate_view.php */