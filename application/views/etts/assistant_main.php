<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><a href="<?=site_url();?>etts/phase/1">Prior to Attending Sessions</a></h2>
					</div>
					<div class="box-content">
						<div class="progress progress-<?=$phase1['progress_label'];?> progress-striped">
							<div class="bar" style="width: <?=$phase1['progress']?>;"></div>
						</div>
						<div class="sortable row-fluid">
							<span class="well span3 top-block">
								<div>Completed Tasks</div>
								<div><?=$phase1['completed']?></div>
							</span>
			
							<span class="well span3 top-block">
								<div>Total Tasks</div>
								<div><?=$phase1['total']?></div>
							</span>
			
							<span class="well span3 top-block">
								<div>Progress</div>
								<div><?=$phase1['progress']?></div>
							</span>
							<span class="well span3 top-block">
								<div>Status</div>
								<div class="<?=$phase1['label']?>"><?=$phase1['status']?></div>
							</span>						
						</div>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><a href="<?=site_url();?>etts/phase/2">Prior to Running Sessions Solo</a></h2>
					</div>
					<div class="box-content">
						<div class="progress progress-<?=$phase2['progress_label'];?> progress-striped">
							<div class="bar" style="width: <?=$phase2['progress']?>;"></div>
						</div>
						<div class="sortable row-fluid">
							<span class="well span3 top-block">
								<div>Completed Tasks</div>
								<div><?=$phase2['completed']?></div>
							</span>
			
							<span class="well span3 top-block">
								<div>Total Tasks</div>
								<div><?=$phase2['total']?></div>
							</span>
			
							<span class="well span3 top-block">
								<div>Progress</div>
								<div><?=$phase2['progress']?></div>
							</span>
							<span class="well span3 top-block">
								<div>Status</div>
								<div class="<?=$phase2['label']?>"><?=$phase2['status']?></div>
							</span>						
						</div>
					</div>
				</div><!--/span-->
			</div><!--/row-->

			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><a href="<?=site_url();?>etts/phase/3">Running Sessions Solo</a></h2>
					</div>
					<div class="box-content">
						<div class="progress progress-<?=$phase3['progress_label'];?> progress-striped">
							<div class="bar" style="width: <?=$phase3['progress']?>;"></div>
						</div>
						<div class="sortable row-fluid">
							<span class="well span3 top-block">
								<div>Completed Tasks</div>
								<div><?=$phase3['completed']?></div>
							</span>
			
							<span class="well span3 top-block">
								<div>Total Tasks</div>
								<div><?=$phase3['total']?></div>
							</span>
			
							<span class="well span3 top-block">
								<div>Progress</div>
								<div><?=$phase3['progress']?></div>
							</span>
							<span class="well span3 top-block">
								<div>Status</div>
								<div class="<?=$phase3['label']?>"><?=$phase3['status']?></div>
							</span>						
						</div>
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			
			<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><a href="<?=site_url();?>etts/phase/4">Behavior Consultant</a></h2>
					</div>
					<div class="box-content">
						<div class="progress progress-<?=$phase4['progress_label'];?> progress-striped">
							<div class="bar" style="width: <?=$phase4['progress']?>;"></div>
						</div>
						<div class="sortable row-fluid">
							<span class="well span3 top-block">
								<div>Completed Tasks</div>
								<div><?=$phase4['completed']?></div>
							</span>
			
							<span class="well span3 top-block">
								<div>Total Tasks</div>
								<div><?=$phase4['total']?></div>
							</span>
			
							<span class="well span3 top-block">
								<div>Progress</div>
								<div><?=$phase4['progress']?></div>
							</span>
							<span class="well span3 top-block">
								<div>Status</div>
								<div class="<?=$phase4['label']?>"><?=$phase4['status']?></div>
							</span>						
						</div>
					</div>
				</div><!--/span-->
			</div><!--/row-->
    
<?
/* End of file assistant_main.php */
/* Location: ./application/views/etts/assistnat_main.php */