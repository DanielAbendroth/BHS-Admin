<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility extends CI_Controller {
	
	public function index()
	{
		$this->db->select('password','id');
		$employees = $this->db->get('employees');
		
		foreach ($employees->result() as $employee) {
			$data = array('temp_pass' => $employee->password );
			$this->db->where('id',$employee->id);
			
			$this->db->update('employees',$data);
		}
	}
}
