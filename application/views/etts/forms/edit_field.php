<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2><?=$section_title?></h2>
			</div>
			<div class="box-content">
				
				<?=validation_errors(); ?>
				<div class="row-fluid">
					<div class="span6 well">
						<form class="form-horizontal" action="<?=base_url()?>etts/edit/field/<?=$this->uri->segment(4);?>/<?=$this->uri->segment(5);?>/<?=$this->uri->segment(6);?>" method="post">
						  <fieldset>
						  	<h2>Edit Field</h2>
						  	<div class="control-group">
								<label class="control-label" for="title">Title</label>
								<div class="controls">
									<input class="input-xlarge focused" id="title" name="title" type="text" value="<?=set_value('title',$field['title'])?>">
								</div>
							</div>
						  	<div class="control-group">
								<label class="control-label" for="field">Field Type</label>
								<div class="controls">
									<select id="field" name="field" data-rel="chosen">
										<option value="text" <?if($field['field'] == 'text'){ echo 'selected'; }?>>Text</option>
										<option value="date" <?if($field['field'] == 'date'){ echo 'selected'; }?>>Date of event</option>
										<option value="employee" <?if($field['field'] == 'employee'){ echo 'selected'; }?>>Employee selection</option>
										<option value="file" <?if($field['field'] == 'file'){ echo 'selected'; }?>>File upload</option>
										<option value="location" <?if($field['field'] == 'location'){ echo 'selected'; }?>>Location selection menu</option>
										<option value="status" <?if($field['field'] == 'status'){ echo 'selected'; }?>>Status</option>
									</select>
								</div>
							</div>
							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save Changes</button>
							  <a href="<?=base_url()?>etts/phase/structure/<?=$this->uri->segment(4);?>" class="btn">Cancel</a>
							</div>
						  </fieldset>
						</form> 
					</div><!--/span-->
					<div class="span6 well"> 
						<h2>Field Types</h2>
							<dl>
								<dt>Text</dt>
									<dd>The text field is used whenever an employee will need to type in the data. i.e. scores, client initals, items in a list</dd>
								<dt>Date of event</dt>
									<dd>The date of event option create a date picker. This is used when an employee will need to include that date that the record took place. Note: The date the record was added to ETTS is automatically included.</dd>
								<dt>Employee Selection</dt>
									<dd>The employee selection option creates a drop-down menu of all the employees.</dd>
								<dt>File upload</dt>
									<dd>The file upload option create a file upload field that the employee can use to include a file.</dd>
								<dt>Location selection menu</dt>
									<dd>The location selection menu work exactly like the previous selection menus except that it lists possible locations event took place.</dd>
								<dt>Status</dt>
									<dd>The status option is used when each record will need status feedback as opposed to the phase.</dd>
							</dl>
				
					</div><!--/span-->
				</div><!--/row-->

			</div>
		</div><!--/span-->

	</div><!--/row-->

<?
/* End of file edit_field.php */
/* Location: ./application/views/etts/edit_field.php */