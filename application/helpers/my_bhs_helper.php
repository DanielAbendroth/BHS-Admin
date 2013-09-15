<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('manual'))
{
	function manual()
	{
		return $items = array('Core Assurances','Sexual Abuse','Technology Use','Office Use','Individual Choice','Individual Rights','Health, Safety and Well ','Abuse and Neglect','Consumer Grievance','Behavior Support Plan','Self-Administ','Documentation Reqs');
	}
}

if ( ! function_exists('manual_trainers'))
{
	function manual_trainers()
	{
		return '<input class="span6 typeahead" id="typeahead" name="trainer" placeholder="Trainer Name" data-provide="typeahead" data-items="3" data-source="[&quot;Colin Peeler&quot;,&quot;Angie Peeler&quot;,&quot;Lisa Gilbertsen&quot;]" type="text">';
	}
}

if ( ! function_exists('nav_generate'))
{
	function nav_generate($position,$session_id)
	{
		/*
		 * 1 = assistant
		 * 2 = office aid
		 * 3 = assistant and office aid
		 * 4 = consultant
		 * 5 = cosultant and office aid
		 * 6 = SBC
		 * 7 = Vice President
		 * 8 = President
		 * 9 = admin
		 */
		$pages = array();
		$pages[] = array(
			'uri'	=> base_url().'dashboard',
			'icon'	=> 'icon-home',
			'title'	=> 'Dashboard'
		);
		$pages[] = array(
			'uri'	=> '/admin/files',
			'icon'	=> 'icon-folder-open',
			'title'	=> 'File Manager'
		);
		$pages[] = array(
			'uri'	=> base_url().'employees',
			'icon'	=> 'icon-user',
			'title'	=> 'Employees'
		);
		/*if($position >= 6) {
			$pages[] = array(
				'uri'	=> base_url().'store',
				'icon'	=> 'icon-tags',
				'title'	=> 'Store'
			);
		}*/
		$pages[] = array(
			'uri'	=> base_url().'etts',
			'icon'	=> 'icon-inbox',
			'title'	=> 'ETTS'
		);
		if($position != 1) {
			$pages[] = array(
			'uri'	=> 'http://behsolutions.com/files?session_id='.$session_id,
			'icon'	=> 'icon-folder-open',
			'title'	=> 'Restricted File Manager'
		);
		}
		return $pages;
	}
}

if ( ! function_exists('field_dropdown'))
{
	function field_dropdown()
	{
		return '<select id="field" name="field" data-rel="chosen">
					<option value="text" '.set_select('field', 'text').'>Text</option>
					<option value="employee" '.set_select('field', 'employee').'>Employee selection</option>
					<option value="file" '.set_select('field', 'file').'>File upload</option>
					<option value="location" '.set_select('field', 'location').'>Location selection menu</option>
					<option value="status" '.set_select('field', 'status').'>Status</option>
				</select>';
	}
}

if ( ! function_exists('check_perm'))
{
	function check_perm($perm)
	{
		if(($perm == 1) | ($perm == 4)) {
			$message = '<p>You do not have permission to view this.</p><p>If you feel you have reached this message in error, please contact Angie or Dr. Peeler.';
			show_error($message);
		}
	}
}

if ( ! function_exists('sbc'))
{
	function sbc()
	{
		$query = 'SELECT first_name, last_name, email FROM employees WHERE position = 6 LIMIT 1';
		$result = mysql_query($query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$data['name'] = $row['first_name'].' '.$row['last_name'];
			$data['email'] = $row['email'];
		}
		return $data;
	}
}
if ( ! function_exists('handle_position')) {
	function handle_position($position)
	{
		switch ($position) {
			case '0':
				$position = 'Website Developer';
				break;
				
			case '1':
				$position = 'Behavior Assistant';
				break;
				
			case '2':
				$position = 'Office Aid';
				break;
				
			case '3':
				$position = 'Behavior Assistant / Office Aid';
				break;
				
			case '4':
				$position = 'Consultant';
				break;
				
				
			case '5':
				$position = 'Consultant / Office Aid';
				break;
				
			case '6':
				$position = 'Senior Behavior Consultant';
				break;
				
			case '7':
				$position = 'Vice President / Consultant';
				break;
			
			case '8':
				$position = 'President / Consultant';
				break;
		}
		return $position;
	}
}

if ( ! function_exists('handle_phone')) {
	function handle_phone($phone)
	{
		$phone = '('.substr($phone,0,3).') '.substr($phone,3,3).'-'.substr($phone,6,4);
		return $phone;
	}
}

if ( ! function_exists('handle_status')) {
	function handle_status($status)
	{
		if($status) {
			$status = 'Active';
		} else {
			$status = 'Non-Active';
		}
		return $status;
	}
}

if ( ! function_exists('handle_date')) {
	function handle_date($date)
	{
		$year = substr($date,4,4);
		$month = substr($date,0,2);
		$day = substr($date,2,2);
		$date = $month.'/'.$day.'/'.$year;
		return $date;
	}
}

if ( ! function_exists('is_exempt')) {
	function is_exempt($task, $employee)
	{
		$dbc = mysqli_connect("localhost", "root", "mysql", "admin");
		$query = "SELECT * FROM `exemption` WHERE `task` =$task AND `employee` =$employee";
		$result = mysqli_query($dbc,$query);
		mysqli_num_rows($result);
		if(mysqli_num_rows($result) > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
/* End of file MY_bhs_array_helper.php */
/* Location: ./application/helpers/MY_bhs_array_helper.php */