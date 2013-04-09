<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2><?=$section_title?></h2>
			</div>
			<div class="box-content">
				<form action="<?=base_url()?>etts/add/task/<?=$this->uri->segment(4)?>/<?=$this->uri->segment(5)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
					<fieldset>
						<input type="hidden" name="submitted" value="TRUE" />
						<?foreach ($fields as $value):?>
							<?=$value?>
						<?endforeach?>
						<div class="form-actions">
							<?if($check):?>
								<button type="submit" class="btn btn-primary">Add Task</button>
							<?endif?>
								<a href="<?=base_url()?>etts/phase/<?=$this->uri->segment(4)?>" class="btn">Cancel</a>
						</div>
					</fieldset>
				</form>
			</div>
		</div><!--/span-->
	
	</div><!--/row-->
<?
/* End of file update_1-1.php */
/* Location: ./application/views/etts/forms/update_1-1.php */