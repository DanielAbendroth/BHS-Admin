<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2>Approval Needed</h2>
			</div>
			<div class="box-content">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Submitted</th>
						<?foreach ($section as $option):?>
							<th><?=$option?></th>
						<?endforeach?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="center"><?=$date?></td>
							<?foreach ($task as $value):
								$list = explode('.', $value);
								if(isset($list[1])) {
									if($list[1] == 'doc' | 'pdf' | 'docx') {
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
					</tbody>
				</table>
				
				
				<form action="<?=base_url()?>etts/approval/<?=$this->uri->segment(3)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
					<fieldset>
						<input type="hidden" name="submitted" />
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">Approve</button>
							<a href="<?=base_url()?>etts/rejection/<?=$this->uri->segment(3)?>" class="btn">Reject</a>
							<a href="<?=base_url()?>" class="btn">Cancel</a>
						</div>
					</fieldset>
				</form>
			</div>
		</div><!--/span-->
	
	</div><!--/row-->
<?
/* End of file update_1-1.php */
/* Location: ./application/views/etts/forms/update_1-1.php */