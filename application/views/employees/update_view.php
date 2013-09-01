<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	
	<?=validation_errors(); ?>
	<?if($this->session->userdata('new_hire')):?>
	<p>Please verify your information and create a password.</p>
	<?endif?>
	<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
		<?if((base64_decode($this->uri->segment(3)) != $this->session->userdata('id')) | ($this->session->userdata('new_hire'))):?>

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
		<?endif?>
		<div class="control-group">
			<label class="control-label" for="phone">Phone</label>
			<div class="controls">
				<input class="input-xlarge focused" id="phone" name="phone" type="text" style="width: 80%" maxlength="10"  value="<?=set_value('phone',$phone)?>">
				<p class="help-block">ex. 3145551234</p>
			</div>
		</div>
		<?if(base64_decode($this->uri->segment(3)) != $this->session->userdata('id')):?>
		<?if(($this->session->userdata('position') == 2) | ($this->session->userdata('position') == 3) | ($this->session->userdata('position') == 5) | ($this->session->userdata('position') >= 7)):?>
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
				<option value="1" <?=set_select('position',1)?> <?if($position == 1){ echo 'selected';}?> >Assistant</option>
				<option value="2" <?=set_select('position',2)?> <?if($position == 2){ echo 'selected';}?> >Office Aid</option>
				<option value="3" <?=set_select('position',3)?> <?if($position == 3){ echo 'selected';}?> >Assistant/Office Aid</option>
				<option value="4" <?=set_select('position',4)?> <?if($position == 4){ echo 'selected';}?> >Consultant</option>
				<option value="5" <?=set_select('position',5)?> <?if($position == 5){ echo 'selected';}?> >Consultant/Office Aid</option>
				<option value="6" <?=set_select('position',6)?> <?if($position == 6){ echo 'selected';}?> >Senior Behavior Consultant</option>
				<option value="7" <?=set_select('position',7)?> <?if($position == 7){ echo 'selected';}?> >Vice President/Consultant</option>
				<option value="8" <?=set_select('position',8)?> <?if($position == 8){ echo 'selected';}?> >President/Consultant</option>
			  </select>
			</div>
		  </div>
		  <?endif?>
		<?endif?>
		
		<?if(base64_decode($this->uri->segment(3)) == $this->session->userdata('id')) :?>
		<div class="control-group">
			<?if($this->session->userdata('new_hire')):?>
				<label class="control-label" for="phone">Image</label>
			<?else:?>
				<label class="control-label" for="phone">Change Image</label>
			<?endif?>
			<div class="controls">
				<input class="input-xlarge focused" id="image" name="image" type="file" style="width: 80%" maxlength="10">
			<?if(!$this->session->userdata('new_hire')):?>
				<p class="help-block">Leave blank for no change</p>
			<?endif?>
			</div>
		</div>
		<div class="control-group">
			<?if($this->session->userdata('new_hire')):?>
				<label class="control-label" for="phone">Create Password</label>
			<?else:?>
				<label class="control-label" for="phone">Change Password</label>
			<?endif?>
			<div class="controls">
				<input class="input-xlarge focused" id="password" name="password" type="text" style="width: 80%" maxlength="10">
			<?if(!$this->session->userdata('new_hire')):?>
				<p class="help-block">Leave blank for no change</p>
			<?endif?>
			</div>
		</div>
		<?endif?>
		<input type="hidden" name="submitted" id="submitted" value="TRUE" />
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</form>

<?
/* End of file update_view.php */
/* Location: ./application/views/employees/update_view.php */