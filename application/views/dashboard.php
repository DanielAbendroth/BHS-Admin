<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<?
		switch ($this->session->userdata('position')) {
			case '8'://admin
				
				break;
				
			case '6'://vp
				include 'dashboard/announcement.php';
				include 'dashboard/create_announcement.php';
				include 'dashboard/action_items.php';
				break;
				
			case '7'://pres ?>
				<!--<div class="sortable row-fluid">
					<a data-rel="tooltip" title="6 new employees" class="well span3 top-block" href="#">
						<span class="icon32 icon-red icon-user"></span>
						<div>Total Employees</div>
						<div>507</div>
						<span class="notification red">6</span>
					</a>
	
					<a data-rel="tooltip" title="4 new files uploaded" class="well span3 top-block" href="#">
						<span class="icon32 icon-orange icon-document"></span>
						<div>Total Files</div>
						<div>228</div>
						<span class="notification yellow">4</span>
					</a>
	
					<a data-rel="tooltip" title="12 new updates" class="well span3 top-block" href="#">
						<span class="icon32 icon-blue icon-users"></span>
						<div>ETTS</div>
						<div>25</div>
						<span class="notification blue">12</span>
					</a>
					
					<a data-rel="tooltip" title="$34 new sales." class="well span3 top-block" href="#">
						<span class="icon32 icon-color icon-cart"></span>
						<div>Sales</div>
						<div>$13320</div>
						<span class="notification green">$34</span>
					</a>
					
				</div>-->
				
				
			<?
				include 'dashboard/announcement.php';
				include 'dashboard/create_announcement.php';
				include 'dashboard/action_items.php';
				break;
				
			case '5'://sbc
				include 'dashboard/announcement.php';
				include 'dashboard/create_announcement.php';
				include 'dashboard/action_items.php';
				break;
			
			case '2':
			case '3':
			case '9'://sbc
				include 'dashboard/announcement.php';
				include 'dashboard/action_items.php';
				break;
			
			default:
				echo '<p>Currently under construction. Please continue to ETTS.</p>';
				break;
		}
	?>
    
<?
/* End of file dashboard.php */
/* Location: ./application/views/dashboard.php */