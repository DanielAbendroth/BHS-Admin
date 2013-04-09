<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2><?=$title?></h2>
			</div>
			<div class="box-content">
				<p>Are you sure you want to delete "<?=$section_title?>"?</p>
				<p>This will delete all data input from employees associated with this section!</p>
				<a href="<?=base_url()?>etts/delete/section/<?=$section_id?>/confirm" class="btn btn-primary">Yes</a>
				<a href="<?=base_url()?>etts/phase/structure/<?=$section_phase?>" class="btn">No</a>
			</div>
		</div><!--/span-->

	</div><!--/row-->

<?
/* End of file delete_section.php */
/* Location: ./application/views/etts/delete_section.php */