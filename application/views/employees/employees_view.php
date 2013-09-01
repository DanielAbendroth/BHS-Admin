<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<div class="row-fluid sortable ui-sortable">
		<div>
			<div class="box-content">
          	<div class="row-fluid">
				<div class="span2"><h6><a href="<?=base_url() . 'employees'?>">All Employees</a></h6></div>
          		<?if(($this->session->userdata('position') == 3) | ($this->session->userdata('position') == 5) | ($this->session->userdata('position') > 6) | ($this->session->userdata('position') == 2)):?>
					<div class="span2"><h6><a href="<?=base_url() . 'employees?deactivated=true'?>">Former Employees</a></h6></div>
				<?endif?>
                <div class="span2"><h6><a href="<?=base_url() . 'employees?where=consultant'?>">Consultants</a></h6></div>
                <div class="span2"><h6><a href="<?=base_url() . 'employees?where=assistant'?>">Assistants</a></h6></div>
                <div class="span2"><h6><a href="<?=base_url() . 'employees?where=office'?>">Office Workers</a></h6></div>
                <?if(($this->session->userdata('position') == 3) | ($this->session->userdata('position') == 5) | ($this->session->userdata('position') > 6) | ($this->session->userdata('position') == 2)):?>
					<div class="span2"><h6><a href="<?=base_url() . 'employees/add'?>">Add Employee</a></h6></div>
				<?endif?>
            </div>                   
          </div>
		</div><!--/span-->
	</div><!--/row-->
	<div class="row-fluid sortable ui-sortable">
	<?foreach($employees as $key => $employee):?>
		<?if(($key % 2 == 0) && ($key != 0)):?>
			</div><!--/row-->
			<div class="row-fluid sortable ui-sortable">
		<?endif?>
			<div style="" class="box span6">
				<div class="box-header well" data-original-title="">
					<h2><i class="icon-user"></i> <?=$employee['first_name'].' '.$employee['last_name']?></h2>
					<div class="box-icon">
						<?if(($this->session->userdata('position') == 3) | ($this->session->userdata('position') == 5) | ($this->session->userdata('position') > 6) | ($this->session->userdata('position') == 2)):?>
							<a href="<?=base_url()?>employees/update/<?=base64_encode($employee['id'])?>" class="btn btn-minimize btn-round"><i class="icon-edit"></i></a>
							<a href="<?=base_url()?>employees/change_status/<?=base64_encode($employee['id'])?>" title="Change Status" class="btn btn-close btn-round"><i class="icon-trash"></i></a>
						<?endif?>
					</div>
				</div>
				<div class="box-content">
					<div class="row-fluid sortable ui-sortable" style="float: left">
						<div class="span4" style="margin-bottom: 10px">
							<img src="<?=base_url()?>assets/pictures/<?=$employee['image']?>" style="float:left; margin-right:25px;">
						</div>
						<div class="span6">
							<h5> <i class="icon icon-color icon-user"></i> <?=handle_position($employee['position'])?></h5>
							<h6><a href="<?=base_url()?>employees/email/<?=base64_encode($employee['id'])?>"> <i class="icon icon-color icon-mail-closed"></i> <?=$employee['email']?></a></h6>
							<h6><i class="icon icon-color icon-contacts"></i> <?=handle_phone($employee['phone'])?></h6>
						</div>
					</div>
				<?if(($this->session->userdata('position') == 3) | ($this->session->userdata('position') == 5) | ($this->session->userdata('position') > 6) | ($this->session->userdata('position') == 0)):?>
					<div class="row-fluid sortable ui-sortable">
						<div class="span4"><h6>Hire Date:</h6> <?=handle_date($employee['hire_date'])?></div>
						<div class="span4"><h6>Last Login:</h6> <?=$employee['last_login']?></div>
						<div class="span4"><h6>Status:</h6> <?=handle_status($employee['status'])?></div>
					</div>
				<?endif?>
						
				
              	</div>
			</div><!--/span-->
	<?endforeach?>
	</div><!--/row-->

<?
/* End of file employees_view.php */
/* Location: ./application/views/employees/employees_view.php */