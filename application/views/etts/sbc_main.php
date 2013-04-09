<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? $i=1; ?>
<?
	$phase_title = array(
		1 => 'Prior to Attending Session',
		2 => 'Prior to running session solo',
		3 => 'Running Session solo',
		4 => 'Behavior Consultant'
	);
?>
    <div class="row-fluid">
	<?for($i=1;$i<5;$i++):?>
		<div class="box span3">
			<div class="box-header well" data-original-title="">
				<h2><?=$phase_title[$i]?></h2>
			</div>
			<?sbc()?>
			<div class="box-content">
				<ul class="nav nav-stacked">
					<li><a href="<?=base_url()?>etts/phase/structure/<?=$i?>">View Structure</a></li>
					<?if($this->session->userdata('position') == 3):?>
					<li><a href="<?=base_url()?>etts/phase/<?=$i?>">My ETTS</a></li>
					<?endif?>
				</ul>
			</div>
		</div><!--/span-->
	<?endfor?>
	</div><!--/row-->
	<div class="row-fluid">
		<div class="box span12">
			<div class="box-header well" data-original-title="">
				<h2>Employees</h2>
			</div>
			<div class="box-content">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Employee</th>
							<th>Prior to Attending Session</th>
							<th>Prior to running sessions solo</th>
							<th>Running Session solo</th>
							<th>Behavior Consultant</th>
						</tr>
					</thead>
					<tbody>
						<?foreach ( $employees as $employee ):?>
							<tr>
								<td class="center"><?=$employee['name']?></td>
								<td class="center"><a href="<?=base_url()?>etts/phase/1/<?=$employee['id']?>"><?=$employee['phase1']?></a></td>
								<td class="center"><a href="<?=base_url()?>etts/phase/2/<?=$employee['id']?>"><?=$employee['phase2']?></a></td>
								<td class="center"><a href="<?=base_url()?>etts/phase/3/<?=$employee['id']?>"><?=$employee['phase3']?></a></td>
								<td class="center"><a href="<?=base_url()?>etts/phase/4/<?=$employee['id']?>"><?=$employee['phase4']?></a></td>
							</tr>
						<?endforeach?>
					</tbody>
				</table>
			</div>
		</div><!--/span-->
	</div><!--/row-->
<?
/* End of file sbc_main.php */
/* Location: ./application/views/etts/sbc_main.php */