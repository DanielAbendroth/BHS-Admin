<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row-fluid">
		<div class="box span10">
			<div class="box-header well" data-original-title>
				<h2><?=$header?></h2>
			</div>
			<div class="box-content">
				<?=$subtitle?>
			</div>
		</div><!--/span-->
		<div class="box span2">
			<div class="box-header well" data-original-title>
				<h2>Status</h2>
			</div>
			<div class="box-content">
				<div class="center">
					<?=$phase['top_status']?>
				</div>
			</div>
		</div><!--/span-->
	</div><!--/row-->
	
<?
	foreach ($sections as $section): ?>
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2>
					<?=$section['title']?>
					<?if(isset($section['data'])):?>
						<?if(count($section['data']) >= $section['minimum']):?>
							<span class="label label-success">Complete</span>
						<?else:?>
							<span class="label label">Incomplete</span>
						<?endif?>
					<?else:?>
						<span class="label label">Incomplete</span>
					<?endif?>
					
				</h2>
			</div>
			<div class="box-content">
				<?if($section['note']):?>
					<p><?=$section['note']?></p>
				<?endif?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th colspan="2"></th>

						<?foreach ($section['options'] as $key => $option):?>
							<th><?=$option?></th>
						<?endforeach?>
						</tr>
					</thead>
					<tbody>
					<?if(isset($section['data'])):?>
						<?if(is_array($section['data'])):
							$i = 1;
							foreach ($section['data'] as $task):
								$id = array_pop($task);
								?>
								<tr>
									<td class="center"><?=$i?></td>
									<?foreach ($task as $value):
										$list = explode('.', $value);
										if(isset($list[1])) {
											if(($list[1] == 'doc') | ($list[1] == 'pdf') | ($list[1] == 'docx')) {
												$value = '<a href="'.base_url().'admin/etts/download_file/phases/'.$value.'/'.$this->uri->segment(3).'">Download File</a>';
											}
										}
										//check if value is a status
										if($value == 'Pending') : ?>
											<td><span class="label label-warning">Pending</span></td>
										<?elseif($value == 'Rejected') :?>
											<td><span class="label label-important">Rejected</span></td>
										<?elseif($value == 'Approved') :?>
											<td><span class="label label-success">Approved</span></td>
										<?else :?>
											<td class="center"><?=$value?></td>
										<?endif?>
									<?endforeach?>                                  
								</tr>
								<?$i++?>
							<?endforeach?>
						<?endif?>
					<?endif?>
					<tr>
						<?if(!$sbc):?>
						<td class="center" colspan="20"><a href="<?=base_url()?>etts/add/task/<?=$this->uri->segment(3)?>/<?=$section['id']?>" class="btn btn-primary">Add</a></td>
						<?endif?>
					</tr>
				</table>
			</div>
		</div><!--/span-->
	</div><!--/row-->
	<?endforeach?>
	
	<?
/* End of file phase_2.php */
/* Location: ./application/views/etts/phase_2.php */