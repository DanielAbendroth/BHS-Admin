<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	
			
			<div class="row-fluid">
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2>Current Action Items</h2>
					</div>
					<div class="box-content">
						<?if(isset($action_items)):?>
							<table class="table table-striped">
								<thead>
									<tr>
										<th colspan="5"></th>
									</tr>
								</thead>   
								<tbody>
									<?foreach ($action_items as $item):?>
									<tr>
										<td><?=$item?></td>
									</tr>
									<?endforeach?>
								</tbody>
							</table>
						<?else:?>
							<p>Looks like nothing requires your attention right now. Way to go!</p>
						<?endif?>
					</div>
				</div><!--/span-->

    
<?
/* End of file announcement.php */
/* Location: ./application/views/dashboard/announcement.php */