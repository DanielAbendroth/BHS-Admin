<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<div class="row-fluid">
		<div class="span8 well">
			<div>
				<img src="<?=base_url()?>assets/pictures/<?=$image?>" style="float:left; margin-right:25px;">
			</div>
			<div style="float: left">
				<p><?=$first_name?> <?=$last_name?></p>
				<p><?=$email?></p>
				<p><?=$phone?></p>
				<p><?=$position?></p>
				<p><?=handle_date($hire_date)?></p>
				<p>Files uploaded:</p>
				<?if($this->session->userdata('position') > 5):?><p>Webinars:</p><?endif?>
				<p><a href="<?=base_url()?>employees/update/<?=base64_encode($this->session->userdata('id'))?>">Update Profile</p>
			</div>
		</div><!--/span-->
	</div><!--/row-->
<?
/* End of file profile_view.php */
/* Location: ./application/views/employees/profile_view.php */