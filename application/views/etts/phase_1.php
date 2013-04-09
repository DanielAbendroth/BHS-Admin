<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row-fluid">
		<div class="box span10">
			<div class="box-header well" data-original-title>
				<h2>Prior to Attending Sessions</h2>
			</div>
			<div class="box-content">
				Before attending any sessions, client’s homes, or schools you need to have all of the training criteria below completed. This includes no ride alongs with other employees. The background check is usually the slowest so get started on the others while waiting.
			</div>
		</div><!--/span-->
		<div class="box span2">
			<div class="box-header well" data-original-title>
				<h2>Status</h2>
			</div>
			<div class="box-content">
				<div class="center">
					<?=$phase1['top_status']?>
				</div>
			</div>
		</div><!--/span-->
	</div><!--/row-->
	
	<!--End top row-->
	
	
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-content">
				<table class="table table-striped">  
				  <tbody>
					<tr>
						<td>Background Check</td>
						<td class="center" colspan="3"><?=$background_date;?></td>
						<td class="center">
							<span class="label <?=$background_label;?>"><?=$background_status?></span>
						</td>                                      
					</tr>
					<tr>
						<td>Employment Contract</td>
						<td class="center" colspan="3"><?=$contract_date;?></td>
						<td class="center">
							<span class="label <?=$contract_label;?>"><?=$contract_status?></span>
						</td>                                      
					</tr>
					<tr>
						<td>Supervision for Licensure Agreement</td>
						<td class="center" colspan="3"><?=$supervision_date;?></td>
						<td class="center">
							<span class="label <?=$supervision_label;?>"><?=$supervision_status?></span>
						</td>                                     
					</tr>
					<tr>
						<td>HIPPAA Online Training</td>
						<td class="center" colspan="2"><?=$hippaa_date;?></td>
						<td class="center"><a href="<?=base_url();?>admin/etts/download_file/hippaa/<?=$hippaa_file?>/1"><?=$hippaa_link?></a></td>
						<td class="center">
							<span class="label <?=$hippaa_label;?>"><?=$hippaa_status?></span>
						</td>                                      
					</tr>                   
				  </tbody>
			    </table>
			</div>
		</div><!--/span-->
	</div><!--/row-->

	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2>Employee Manual Policies and Procedures</h2>
			</div>
		<div class="box-content">
			<table class="table table-striped">
				  <thead>
					  <tr>
						  <th>Task</th>
						  <th>Date</th>
						  <th>Trainer Name</th>
						  <th>Employee Initials</th>
						  <?if((!$manual_trainer) | (!$manual_initials)){ echo '<th></th>';}?>
						  <th>Status</th>                                          
					  </tr>
				  </thead>     
				  <tbody>
			  	<?
			  		$manual = manual();
					$i = 0;
					foreach ($manual as $item):
				?>
					<tr>
						<td><?=$item?></td>
						<td class="center"><?=$manual_date?></td>
						<?if((!$manual_trainer) | (!$manual_initials) && ($i<1) && (!$sbc)){
							echo form_open(base_url().'admin/etts/update_manual');
							echo form_hidden('submitted',TRUE);
						}?>
						<?if ((!$manual_trainer) && ($i<1) && (!$sbc)):?>
							<td class="center"><?=manual_trainers()?>
						<?else:?>
							<td class="center"><?=$manual_trainer?></td>
						<?endif?>
						<td class="center">
						<?if((!$manual_initials) && ($i<1) && (!$sbc)){
							echo '<input type="text" name="initials" maxlength="2" placeholder="Your Initials"  />';
							} else { echo $manual_initials;
							}?>
						</td>
						<?if((!$manual_trainer) | (!$manual_initials) && ($i<1) && (!$sbc)){?>
							<td class="center"><button type="submit" class="btn btn-primary">Save</button></td></form>
							<?} elseif((!$manual_trainer) | (!$manual_initials)) {
								echo '<td></td>';
							}?>
						<td class="center">
							<span class="label <?=$manual_label?>"><?=$manual_status?></span>
						</td>                                      
					</tr>
				<?	$i++;
				endforeach; ?>
				<?if($manual_date == ''):?>
					<?if(!$sbc):?>
					<tr>
						<td>Signature Page</td>
						<td class="center"></td>
						<td class="center"><form action="<?=base_url()?>admin/etts/do_upload" method="post" enctype="multipart/form-data""><?=form_upload('userfile');?><?=form_hidden('sig_page',TRUE);?><button type="submit" class="btn btn-primary">Save</button></form></td>
						<td class="center"></td>
						<?if(!$manual_trainer | !$manual_initials){ echo '<td></td>';}?>
						<td class="center">
							<span class="label">Incomplete</span>
						</td>
					</tr>
					<?endif?>
				<?else:?>
					<tr>
						<td>Signature Page</td>
						<td class="center"><?=$manual_date?></td>
						<td class="center" colspan="2"><a href="<?=base_url();?>admin/etts/download_file/signature/<?=$manual_sig?>/1">Download Signature Page</td>
						<?if(!$manual_trainer | !$manual_initials){ echo '<td></td>';}?>
						<td class="center">
							<span class="label <?=$manual_label?>"><?=$manual_status?></span>
						</td>
					</tr>
				<?endif?>
				</tbody>
			 </table>
		</div><!--/span-->
	</div><!--/row-->
	<?
	if(isset($sections)) {
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
													if($list[1] == 'doc' | 'pdf' | 'docx') {
														$value = '<a href="'.base_url().'admin/etts/download_file/phases/'.$value.'/'.$this->uri->segment(3).'">Download File</a>';
													}
												}
											?>
												<td class="center"><?=$value?></td>
											<?endforeach?>                                  
										</tr>
										<?$i++?>
									<?endforeach?>
								<?endif?>
							<?endif?>
							<tr>
								<td class="center" colspan="20"><a href="<?=base_url()?>etts/add/task/<?=$this->uri->segment(3)?>/<?=$section['id']?>" class="btn btn-primary">Add</a></td>
							</tr>
						</table>
					</div>
				</div><!--/span-->
			</div><!--/row-->
			<?endforeach?>
			<? } ?>
	<?
/* End of file phase_1.php */
/* Location: ./application/views/etts/phase_1.php */