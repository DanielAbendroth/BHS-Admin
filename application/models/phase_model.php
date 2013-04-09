<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Phase_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_sections_employee($phase,$employee)
	{
		$this->db->where('phase',$phase);
		$this->db->order_by('id','asc');
		$query = $this->db->get('sections');
		$sections = array();
		foreach ($query->result() as $row) {
			$option = unserialize($row->options);
			$options = array();
			if(is_array($option)) {
				foreach ($option as $value) {
					$options[] = ucfirst($value['title']);
				}
			}
			$sections[$row->id] = array(
				'id'		=> $row->id,
				'title'		=> $row->title,
				'note'		=> $row->note,
				'minimum'	=> $row->minimum,
				'options'	=> $options
			);
		}
		foreach ($sections as $id => $value) {
			$where = array('section'=>$id,'employee' => $employee);
			$this->db->order_by('id','asc');
			$query = $this->db->get_where('tasks',$where);
			
			$i = 0;
			foreach ($query->result() as $row) {
				$sections[$row->section]['data'][] = unserialize($row->data);
				array_unshift($sections[$row->section]['data'][$i],$row->date);
				$sections[$row->section]['data'][$i]['id'] = $row->id;
				$i++;
			}
		}
		return $sections;
	}
	
	public function get_status($phase,$employee)
	{
		$status = '';
		//count sections
		$total = 0;
		$complete = 0;
		$this->db->select('id, minimum');
		$this->db->where('phase',$phase);
		$sections = $this->db->get('sections');
		$total += $sections->num_rows;
		//check to see if the employee has completed them
		if($sections->num_rows != 0) {
			$this->db->select('id');

			foreach ($sections->result() as $row) {
				$where = array(
					'employee' => $employee,
					'section' => $row->id
				);
				
				$query = $this->db->get_where('tasks',$where);
				if($query->num_rows >= $row->minimum) {
					$complete++;
				}
			}
			
		}
		if($total != 0) {
			$progress = round(($complete/$total)*100).'%';
		} else {
			$progress = '0%';
		}
		if($progress < 100) {
			$status = 'In Progress';
			$label  = 'red';
			$progress_label = 'danger';
			$top_status = $progress;
		} else {
			$this->db->where(array('employee' => $employee,'phase' => $phase));
			$this->db->select('date,status');
			$query = $this->db->get('phases');

			foreach ($query->result() as $row) {
				$date = $row->date;
				$status = $row->status;
			}
			if($status == 'Approved') {
				$top_status = '<div class="green">Approved<br>'.$date.'</div>';
				$status = 'Approved';
				$label  = 'green';
				$progress_label = 'success';
			} elseif($status == 'Pending') {
				$top_status = '<div class="yellow">Approval Pending</div>';
				$status = 'Approval Pending';
				$label  = 'yellow';
				$progress_label = 'warning';
			} else {
				$top_status = '<a href="'.base_url().'admin/etts/sbc_mail/'.$phase.'" class="btn btn-success">Submit to SBC</a>';
				$status = 'Pending';
				$label  = 'yellow';
				$progress_label = 'warning';
			}
		}
		return array(
			'completed'	=> $complete,
			'total'		=> $total,
			'progress'	=> $progress,
			'status'	=> $status,
			'label'		=> $label,
			'progress_label' => $progress_label,
			'top_status' => $top_status
			
		);
	}

	public function get_sections_sbc($phase)
	{
		$this->db->where('phase',$phase);
		$this->db->order_by('id','asc');
		$query = $this->db->get('sections');
		$sections = array();
		foreach ($query->result() as $row) {
			$options = unserialize($row->options);
			if(strlen($row->title) > 50) {
				$title = substr($row->title, 0,50);
				$title .= '...';
			} else {
				$title = $row->title;
			}
			$sections[$row->id] = array(
				'id'		=> $row->id,
				'title'		=> $title,
				'note'		=> $row->note,
				'minimum'	=> $row->minimum,
				'options'	=> $options
			);
		}
		return $sections;
	}

	public function get_tasks_approval($position)
	{
		$this->db->select('id, employee');
		$tasks = $this->db->get_where('approval',array('approval_needed'=>$position));

		if($tasks->num_rows > 0) {
			$where ='';
			$data = array();
			$employees = array();
			$ids = array();
			foreach ($tasks->result() as $row) {
				$employees[$row->id] = $row->employee;
			}
			
			foreach ($employees as $id => $employee) {
				$this->db->where('id', $employee);
				$this->db->select('id, first_name');
				$names = $this->db->get('employees');
				foreach ($names->result() as $row) {
					$data[$id] = $row->first_name;
				}
			}
			return $data;
		} else {
			return FALSE;
		}
	}
}



/* End of file sections_model.php */
/* Location: ./application/models/sections_model.php */