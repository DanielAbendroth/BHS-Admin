<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_employee_data($where, $deactivated, $extra)
	{
		$data = array();
		$ids = array();
		
		//set where
		switch ($where) {
			case 'consultant':
				$this->db->where('position >', 3);
				break;
			
			case 'assistant':
				$this->db->where("position = 1 OR position = 3");
				break;
			
			case 'office':
				$this->db->where("position = 2 OR position = 3 OR position = 9");
				break;
					
			case 'phase':
				$this->db->select('employee');
				$query = $this->db->get_where('phases',array('phase' => $extra, 'status' =>'Approved'));
				foreach ($query->result() as $row) {
					$employees[] = $row->employee;
				}
				foreach ($employees as $id) {
					$ids = 'postion = '.$id.' OR ';
				}
				$ids = substr($ids, 0, -4);
				$this->db->where($ids);
				break;
				
			case 'id':
				$this->db->where('id', base64_decode($extra));
				break;
		}
		//prevent admin from ever being returned
		$this->db->where('id !=', 1);
		$this->db->order_by('position','desc');
		//determine if need to retrieve unactive employees
		if(!$deactivated) {
			$this->db->where('status !=', 0);
		} else {
			$this->db->where('status !=', 1);
		}
		//retrieve data
		$query = $this->db->get('employees');
		foreach ($query->result() as $row) {
			$data[] = array(
				'id'			=> $row->id,
				'last_login'	=> $row->last_login,
				'first_name'	=> $row->first_name,
				'last_name'		=> $row->last_name,
				'email'			=> $row->email,
				'phone'			=> $row->phone,
				'position'		=> $row->position,
				'hire_date'		=> $row->hire_date,
				'status'		=> $row->status
			);
		}
		return $data;
	}
	
	public function change_status($id)
	/*
	 * This function changes the status of the employee between active and deactive.
	 */
	{
		$id = base64_decode($id);
		$this->db->select('status');
		$this->db->where('id',$id);
		$query = $this->db->get('employees');
		foreach ($query->result() as $row) {
			if($row->status == 0) {
				$data = array('status' => 1);
			} else {
				$data = array('status' => 0);
			}
		}
		$this->db->where('id',$id);
		$this->db->update('employees',$data);
	}
	
	public function create_employee($data)
	{
		$this->db->insert('employees',$data);
		return $this->db->insert_id();
	}
	
	public function update_employee($id, $data)
	{
		$this->db->update('employees',$data);
	}
}

	   
/* End of file employees_model.php */
/* Location: ./application/models/employees_model.php */