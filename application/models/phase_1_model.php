<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Phase_1_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_phase_1($id)
	{
		$query = $this->db->get_where('phase1-1',array('employee' => $id),1);
		$data = array();
		foreach ($query->result() as $row) {
			if($row->background == NULL) {
				$data['background_date'] = '';
				$data['background_label'] = 'label-warning';
				$data['background_status'] = 'Pending';
			} else {
				$data['background_date'] = $row->background;
				$data['background_label'] = 'label-success';
				$data['background_status'] = 'Complete';
			}
			
			if($row->contract == NULL) {
				$data['contract_date'] = '';
				$data['contract_label'] = 'label';
				$data['contract_status'] = 'Incomplete';
			} else {
				$data['contract_date'] = $row->contract;
				$data['contract_label'] = 'label-success';
				$data['contract_status'] = 'Complete';
			}
			
			if($row->supervision == NULL) {
				$data['supervision_date'] = '';
				$data['supervision_label'] = 'label';
				$data['supervision_status'] = 'Incomplete';
			} else {
				$data['supervision_date'] = $row->supervision;
				$data['supervision_label'] = 'label-success';
				$data['supervision_status'] = 'Complete';
			}
			
			if($row->hippaa == NULL) {
				$data['hippaa_date'] = '';
				$data['hippaa_file'] = '';
				$data['hippaa_label'] = 'label';
				$data['hippaa_status'] = 'Incomplete';
			} else {
				$data['hippaa_date'] = $row->hippaa;
				$data['hippaa_file'] = $row->hippaa_file;
				$data['hippaa_label'] = 'label-success';
				$data['hippaa_status'] = 'Complete';
			}
		}
		$query = $this->db->get_where('phase1-2',array('employee' => $id),1);
			foreach ($query->result() as $row) {
				$data['manual_date'] = $row->date;
				$data['manual_trainer'] = $row->trainer;
				$data['manual_initials'] = $row->initials;
				$data['manual_sig'] = $row->sig_file;
				if($row->trainer == NULL) {
					$data['manual_label'] = 'label';
					$data['manual_status'] = 'Incomplete';
				} else {
					$data['manual_label'] = 'label-success';
					$data['manual_status'] = 'Complete';
				}
			}
		return $data;
	}

	public function get_no_background()
	{
		$this->db->select('employee');
		$query = $this->db->get_where('phase1-1',array('background' =>NULL));
		if($query->num_rows > 0) {
			$where ='';
			$data = array();
			foreach ($query->result() as $row) {
				$where .= "id =".$row->employee." OR ";
			}
			
			$this->db->where(substr($where,0,-4));
			$this->db->select('id, first_name');
			$names = $this->db->get('employees');
			foreach ($names->result() as $row) {
				$data[$row->id] = $row->first_name;
			}
			return $data;
		} else {
			return FALSE;
		}
	}

	public function get_no_contract()
	{
		$this->db->select('employee');
		$query = $this->db->get_where('phase1-1',array('contract' =>NULL));
		if($query->num_rows > 0) {
			$where ='';
			$data = array();
			foreach ($query->result() as $row) {
				$where .= "id =".$row->employee." OR ";
			}
			
			$this->db->where(substr($where,0,-4));
			$this->db->select('id, first_name');
			$names = $this->db->get('employees');
			foreach ($names->result() as $row) {
				$data[$row->id] = $row->first_name;
			}
			return $data;
		} else {
			return FALSE;
		}
	}
	
	public function get_no_supervision()
	{
		$this->db->select('employee');
		$query = $this->db->get_where('phase1-1',array('supervision' =>NULL));
		if($query->num_rows > 0) {
			$where ='';
			$data = array();
			foreach ($query->result() as $row) {
				$where .= "id =".$row->employee." OR ";
			}
			
			$this->db->where(substr($where,0,-4));
			$this->db->select('id, first_name');
			$names = $this->db->get('employees');
			foreach ($names->result() as $row) {
				$data[$row->id] = $row->first_name;
			}
			return $data;
		} else {
			return FALSE;
		}
	}
	
	public function get_status($employee)
	{
		{
		//check for complete on phase 1-1
		$this->db->select('background,contract,supervision,hippaa');
		$this->db->where('employee',$employee);
		$query = $this->db->get('phase1-1');

		$total = 5;
		$complete = 0;
		foreach ($query->result() as $row):
			foreach ($row as $value):
				if($value != '') {
					$complete++;
				}
			endforeach;
		endforeach;
		//check for completed on phase 1-2
		$this->db->select('date,trainer,initials');
		$this->db->where('employee',$employee);
		$query = $this->db->get('phase1-2');
		
		$i = 0;
		foreach ($query->result() as $row):
			foreach ($row as $value):
				if(!$value) {
					$i++;
				}
			endforeach;
		endforeach;
		
		if($i == 0) {
			$complete++;
		}
		
		//check to see if any more sections have been added
		$this->db->select('id');
		$this->db->where('phase',1);
		$status = '';
		$sections = $this->db->get('sections');
		$total += $sections->num_rows;
		
		//if there have been additions, check to see if the employee has completed them
		if($sections->num_rows != 0) {
			$this->db->select('id');
			
			$section = '';
			foreach ($sections->result() as $id) {
				$section .= $id->id.' OR';
			}
			$where = array(
				'employee' => $employee,
				'section' => substr($section, 0, -3)
			);
			$query = $this->db->get_where('tasks',$where);
			$complete += $query->num_rows;
		}
		$progress = round(($complete/$total)*100).'%';
		if($progress < 100) {
			$status = 'In Progress';
			$label  = 'red';
			$progress_label = 'danger';
			$top_status = $progress;
		} else {
			$this->db->where(array('employee' => $employee,'phase' => 1));
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
				$top_status = '<div class="yellow">Pending Approval</div>';
				$status = 'Approval Pending';
				$label  = 'yellow';
				$progress_label = 'warning';
			} else {
				$top_status = '<a href="'.base_url().'admin/etts/sbc_mail/1" class="btn btn-success">Submit to SBC</a>';
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
	}

}



/* End of file sections_model.php */
/* Location: ./application/models/sections_model.php */