<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
    <div class="row-fluid">
		<div class="box span12">
			<div class="box-header well" data-original-title="">
				<h2>Phase <?=$phase?> Structure</h2>
				<div class="box-icon">
					<a href="<?=base_url()?>etts/create/section/<?=$this->uri->segment(4)?>" title="Add Section" data-rel="tooltip"><i style="margin: -2px -15px" class="icon32 icon-add"></i></a>
				</div>
			</div>
		</div><!--/span-->
	</div><!--/row-->
	
		<?if(empty($sections)):?>
		<div class="row-fluid">
			<div class="span12 well">
				<div>
					<p>No sections have been added to this phase.</p>
				</div>
			</div><!--/span-->
		</div><!--/row-->
		<?endif?>
		<?while (count($sections) > 0):?>
		<div class="row-fluid">
			<?for ($i=0; $i < 2; $i++):?>
				
				<?$section = array_shift($sections)?>
				<?if(!empty($section)):?>
					<div class="box span6">
						<div class="box-header well" data-original-title="">
							<h2><?=$section['title']?></h2>
							<div class="box-icon">
								<a href="<?=base_url()?>etts/add/field/<?=$phase?>/<?=$section['id']?>" title="Add Field" data-rel="tooltip"><i class="icon32 icon-plus"></i></a>
								<a href="<?=base_url()?>etts/delete/section/<?=$section['id']?>" style="margin:0 10px 0 25px;" title="Delete Section" data-rel="tooltip"><i class="icon32 icon-close"></i></a>
							</div>
						</div>
						
						<div class="box-content">
							<?if(empty($section['options'])):?>
								<p>No fields have been added to this section.</p>
							<?else:?>
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Title</th>
											<th>Field Type</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?$n=0;?>
										<?foreach($section['options'] as $option):?>
										<tr>
											<td><?=$option['title']?></td>
											<td><?=$option['field']?></td>
											<td><a href="<?=base_url()?>etts/edit/field/<?=$phase?>/<?=$section['id']?>/<?=$n?>" style="margin:0 0px 0 20px;" title="Edit Field" data-rel="tooltip"><i class="icon16 icon-edit"></i></a></td>
										</tr>
										<?$n++?>
										<?endforeach?>
									</tbody>
								</table>
							<?endif?>
						</div>
					</div><!--/span-->
				<?endif?>
			<?endfor?>
			</div><!--/row-->
			<?unset($i)?>
		<?endwhile?>
	
<?
/* End of file structure.php */
/* Location: ./application/views/etts/structure.php */