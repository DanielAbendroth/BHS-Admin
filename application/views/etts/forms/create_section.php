<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2>Add Section</h2>
			</div>
			<div class="box-content">
				
				<?=validation_errors(); ?>
				<form class="form-horizontal" action="<?=base_url()?>etts/create/section/1" method="post">
				  <fieldset>
				  	<input type="hidden" name="phase" value="<?=$this->uri->segment(4)?>" />
					<div class="control-group">
						<label class="control-label" for="title">Title</label>
						<div class="controls">
							<input class="input-xlarge focused" id="title" name="title" type="text" value="<?=set_value('title',$section['title'])?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="info">Informational Note</label>
						<div class="controls">
							<input class="input-xlarge focused" id="info" name="info" type="text" value="<?=set_value('info',$section['note'])?>">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="minimum">Minimum tasks for completion</label>
						<div class="controls">
							<input class="input-xlarge focused" id="minimum" name="minimum" type="text" value="<?=set_value('minimum',$section['minimum'])?>">
						</div>
					</div>
					<div class="form-actions">
					  <button type="submit" class="btn btn-primary">Create Section</button>
					  <a href="<?=base_url()?>etts/phase/structure/<?=$this->uri->segment(4)?>" class="btn">Cancel</a>
					</div>
				  </fieldset>
				</form>   

			</div>
		</div><!--/span-->

	</div><!--/row-->

<?
/* End of file create_task.php */
/* Location: ./application/views/etts/create_task.php */