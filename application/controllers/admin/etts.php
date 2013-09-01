<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Etts extends CI_Controller {
	
	public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
			//session check
			if(!$this->session->userdata('id')) {
				redirect('login');
			}
       }
	   
	public function index()
	{
		//load the main ETTS page based on position
		if($this->session->userdata('position') == 1) {
			$this->load->model('Phase_1_model');
			$data['phase1'] = $this->Phase_1_model->get_status($this->session->userdata('id'));
			$this->load->model('Phase_model');
			$data['phase2'] = $this->Phase_model->get_status(2,$this->session->userdata('id'));
			$data['phase3'] = $this->Phase_model->get_status(3,$this->session->userdata('id'));
			$data['phase4'] = $this->Phase_model->get_status(4,$this->session->userdata('id'));
			$data['content'] = 'etts/assistant_main';
		} elseif($this->session->userdata('position') == 4) {
			$data['content'] = 'etts/consultant_main';
		
		} else {
			$this->load->model('Phase_1_model');
			$this->load->model('Phase_model');
			$employees = array();
			$this->db->where('position',1);
			$this->db->or_where('position',3);
			$this->db->select('id,first_name,last_name');
			$query = $this->db->get('employees');
			foreach ($query->result() as $row) {
				$employees[] = array(
					'id' 		=> $row->id,
					'name'		=> $row->first_name.' '.$row->last_name,
					'phase1'	=> '',
					'phase2'	=> '',
					'phase3'	=> '',
					'phase4'	=> ''
				);
			}
			$e = 0;
			foreach ($employees as $employee) {
				$status = $this->Phase_1_model->get_status($employee['id']);
				if($status['progress'] == '100%') {
					if($status['status'] == 'Approved') {
						$employees[$e]['phase1'] = 'Completed';
					} elseif($status['status'] == 'Approval Pending') {
						$employees[$e]['phase1'] = 'Pending Approval';
					} else {
						$employees[$e]['phase1'] = '100%';
					}
				} else {
					$employees[$e]['phase1'] = $status['progress'];
				}
				$e++;
			}
			for ($i=2; $i < 5; $i++) {
				$e = 0;
				foreach ($employees as $employee) {
					$status = $this->Phase_model->get_status($i,$employee['id']);
					if($status['progress'] == '100%') {
						if($status['status'] == 'Approved') {
							$employees[$e]['phase'.$i] = 'Completed';
						} elseif($status['status'] == 'Approval Pending') {
							$employees[$e]['phase'.$i] = 'Pending Approval';
						} else {
							$employees[$e]['phase'.$i] = '100%';
						}
					} else {
						$employees[$e]['phase'.$i] = $status['progress'];
					}
					$e++;
				}
			}
			$data['employees'] = $employees;
			$data['content'] = 'etts/sbc_main';
		}
		$data['title'] = 'ETTS Dashboard';
		$this->load->view('template', $data);
	}
	
	public function phase()
	{
		//load the data for that phase based on the employee logged in
		$this->load->helper(array('form', 'date'));
		$phase = $this->uri->segment(3);
		if($this->uri->segment(4)) {
			if($this->session->userdata('position') != 1) {
				$employee = $this->uri->segment(4);
				$sbc = TRUE;
			} else {
				show_error('You are not autorized to view this page.');
				exit;
			}
		} else {
			$employee = $this->session->userdata('id');
			$sbc = FALSE;
		}
			switch ($phase) {
				case '1':
					$this->load->model('Phase_1_model');
					$this->load->model('Phase_model');
					$data = $this->Phase_1_model->get_phase_1($employee);
					$data['phase1'] = $this->Phase_1_model->get_status($employee);
					$data['sections'] = $this->Phase_model->get_sections_employee(1,$employee);
					if($data['hippaa_file'] == '') {
						if(!$sbc) {
							$data['hippaa_date'] = '<p>Allowed file types: pdf, doc, docx, jpeg, ppt, pptx, xls, xlsx</p><p>Max file size: 2mb';
							$data['hippaa_link'] ='</a><form action ="'.base_url().'admin/etts/do_upload" method = "post" id="hippaa_form" enctype="multipart/form-data">';
							$data['hippaa_link'] .= form_upload('userfile');
							$data['hippaa_link'] .= form_hidden('hippaa_file', TRUE);
							$data['hippaa_link'] .= '<button type="submit" class="btn btn-primary">Save</button>';
							$data['hippaa_link'] .= form_close();
						} else {
							$data['hippaa_link'] = '';
						}
					} else {
						$data['hippaa_link'] = 'Download File';
					}
					if($sbc) {
						if($data['phase1']['top_status'] == '<div class="yellow">Pending Approval</div>') {
							$data['phase1']['top_status'] = '
								<a href="'.base_url().'etts/phase_approval/1/'.$employee.'" class="btn btn-primary">Approve</a>
								<a href="'.base_url().'etts/phase_rejection/1/'.$employee.'" class="btn">Reject</a>
								';
						} elseif(strstr($data['phase1']['top_status'],'Submit to SBC')) {
							$data['phase1']['top_status'] = '<div class="red">In Progress</div>';
						}
					}
					$data['title'] = 'Prior to Attending Sessions';
					$data['content'] = '/etts/phase_1';
					break;
					
				default:
					$this->load->model('Phase_model');
					$phase = $this->uri->segment(3);
					$data['phase'] = $this->Phase_model->get_status($phase,$employee);
					$data['sections'] = $this->Phase_model->get_sections_employee($phase,$employee);
					if($sbc) {
						if($data['phase']['top_status'] == '<div class="yellow">Approval Pending</div>') {
							$data['phase']['top_status'] = '
								<a href="'.base_url().'etts/phase_approval/'.$phase.'/'.$employee.'" class="btn btn-primary">Approve</a>
								<a href="'.base_url().'etts/phase_rejection/'.$phase.'/'.$employee.'" class="btn">Reject</a>
								';
						} elseif(strstr($data['phase']['top_status'],'Submit to SBC')) {
							$data['phase']['top_status'] = '<div class="red">In Progress</div>';
						}
					}
					switch ($phase) {
						case '2':
							$data['header'] = 'Prior to Running Sessions Solo';
							$data['subtitle'] = 'You can ride along and begin training with kids under direct observation by  a Consultant or Behavior Assistant Trained in Training Skills.';
							break;
						case '3':
							$data['header'] = 'Running Sessions Solo';
							$data['subtitle'] = 'You now can run sessions solo but must complete the below within 6 months of being approved to run sessions solo.';
							break;
						case '4':
							$data['header'] = 'Criteria for position as Behavior Consultant';
							$data['subtitle'] = 'In order to prepare you for a successful career as a Behavior Analyst there are a variety of skills and tasks you will need to become proficient at. Below are a small set of those skills/tasks that you’ll need to complete prior to being eligible for a position as a Behavior Consultant and a long a rewarding career with Behavior Solutions, Inc. If you ever have questions feel free to talk to Dr. Peeler. Completing the tasks below does not guarantee a position with Behavior Solutions, Inc.';
							break;
					}
					$data['title'] = $data['header'];
					$data['content'] = '/etts/phase';
					
					break;
				}
		$data['sbc'] = $sbc;
		$this->load->view('template', $data);
	}
	
	public function create_section()
	{
		check_perm($this->session->userdata('position'));
		$this->load->model('Sections_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		$this->form_validation->set_rules('phase', 'Phase selection', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('minimum', 'Minimum tasks', 'required|numeric');

		if($this->uri->segment(2) == 'edit'){	
			if ($this->form_validation->run() == FALSE) {
			
				$data = array(
					'title' => 'Update section',
					'content' => 'etts/forms/create_section'
				);
				$section = $this->Sections_model->get_section($this->uri->segment(5));
				foreach ($section->result() as $row) {

					$data['section'] = array(
						'title'		=> $row->title,
						'note'		=> $row->note,
						'minimum'	=> $row->minimum
					);
					
				}
				
			} else {
				
				//update edit
				$data = array(
					'title'		=> $this->input->post('title'),
					'note'		=> $this->input->post('info'),
					'minimum'	=> $this->input->post('minimum')
				);
				$this->db->where('id', $this->uri->segment(5));
				$this->db->update('sections', $data); 
				redirect('etts/phase/structure/'.$this->uri->segment(4));
			}
			
			
				
		} else {
			
			if ($this->form_validation->run() == FALSE) {
				
				$data = array(
					'title' => 'Create a new section',
					'content' => 'etts/forms/create_section'
				);
				$data['section'] = array(
					'title'		=> '',
					'phase'		=> '',
					'note'		=> '',
					'minimum'	=> ''
				);
				
			} else {
				//process data
				$section = array(
					'title'		=> $this->input->post('title'),
					'phase'		=> $this->input->post('phase'),
					'note'		=> $this->input->post('info'),
					'minimum'	=> $this->input->post('minimum')
				);
				//load modal
				$result = $this->Sections_model->create_section($section);
				$id = $this->db->insert_id();
				if(empty($result)) {
					$this->session->set_flashdata('error','The section could not be added. Please try again.');
				} else {
					$this->session->set_flashdata('success', 'The section was successfully added.');
				}
				
				//change to add fields!!!!!!!
				redirect('etts/add/field/'.$section['phase'].'/'.$id);	
			}		
		}
		$this->load->helper('form');
			$this->load->view('template', $data);
	}
	
	public function add_field()
	{
		check_perm($this->session->userdata('position'));
		$this->load->model('Sections_model');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		$this->form_validation->set_rules('title', 'Title', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'title' => 'Add a new field',
				'content' => 'etts/forms/add_field'
			);
			$this->db->select('title');
			$result = $this->db->get_where('sections',array('id'=>$this->uri->segment(5)),1);
			foreach ($result->result() as $row) {
				$data['section_title'] = $row->title;
			}
			$this->load->helper('form');
			$this->load->view('template', $data);
		} else {
			//format data and send to mode;
			$field = array(
				'title' => $this->input->post('title'),
				'field' => $this->input->post('field')
			);
			$this->Sections_model->add_field($field);
			redirect('etts/add/field/'.$this->uri->segment(4).'/'.$this->uri->segment(5));
		}
	}
	
	public function delete_section()
	{
		check_perm($this->session->userdata('position'));
		$id = $this->uri->segment(4);
		$confirm = $this->uri->segment(5);
		$this->db->select('title, phase');
		$query = $this->db->get_where('sections',array('id'=>$id));
		foreach ($query->result() as $row) {
			$data['section_id']	= $id;
			$data['section_title'] = $row->title;
			$data['section_phase'] = $row->phase;
		}
		if(!empty($confirm)) {
			$this->db->delete('sections',array('id'=>$id));
			$this->db->delete('tasks',array('section'=>$id));
			$this->db->delete('approval',array('section'=>$id));
			redirect('etts/phase/structure/'.$data['section_phase']);
		} else {		
			$data['title'] = 'Confirm Deletion';
			$data['content'] = 'etts/forms/delete_section';
	
			$this->load->view('template',$data);
		}
	}

	public function edit_field()
	{
		check_perm($this->session->userdata('position'));
		$this->load->model('Sections_model');
		$this->load->library('form_validation');
		$phase = $this->uri->segment(4);
		$section = $this->uri->segment(5);
		$field = $this->uri->segment(6);
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		$this->form_validation->set_rules('title', 'Title', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$data['field'] = $this->Sections_model->get_field($section,$field);
			
			$data['title'] = 'Edit Field';
			$data['content'] = 'etts/forms/edit_field';
			
			$this->db->select('title');
			$result = $this->db->get_where('sections',array('id'=>$this->uri->segment(5)),1);
			foreach ($result->result() as $row) {
				$data['section_title'] = $row->title;
			}
			$this->load->view('template',$data);
		} else {
			//format data and send to model;
			$data = array(
				'title' => $this->input->post('title'),
				'field' => $this->input->post('field')
			);
			$this->Sections_model->update_field($data,$section,$field);
			redirect('etts/phase/structure/'.$phase);
		}
		
		
	}
		
	public function add_task()
	{
		$s = 0;
		$this->load->library('form_validation');
		if (isset($_POST['submitted'])) {
			if(!empty($_FILES)) {
				foreach ($_FILES as $key => $file) {
					$config['file_name'] = $_POST[$key];
					$config['allowed_types'] = 'pdf|doc|docx|jpg|ppt|pptx|xls|xlsx';
					$config['upload_path'] = './assets/etts/phases';
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if ( ! $this->upload->do_upload($key)) {
						$message = array('alert-error' => $this->upload->display_errors());
						$this->session->set_flashdata('message',array($message));
						
					} else {
						$file = $this->upload->data();
						$_POST[$key] = $file['file_name'];
					}
					
					
				}//end foreach
			}
			array_shift($_POST);
			$phase = $this->uri->segment(4);
			$data = array(
				'section'	=> $this->uri->segment(5),
				'employee'	=> $this->session->userdata('id'),
				'date'		=> date('m/d/Y'),
				'data'		=> serialize($_POST)
			);
			$this->db->insert('tasks',$data);
			$task = $this->db->insert_id();
			if(isset($_POST['status1'])) {
				//send email to SBC
				$this->load->library('email');
				$employee = $this->session->userdata('first_name').' '.$this->session->userdata('last_name');
				$message = $employee .' has added a task that requires your attention for approval. Please log into '.base_url().' and check your "Current Action Items" to approve or reject it.';
				$this->email->from('webmail@behsolutions.com', 'Behavior Solutions Admin');
				$this->email->to('lgilbertsen@behsolutions.com');
				//$this->email->cc('cpeeler@behsolutions.com');
				$this->email->reply_to($this->session->userdata('email'), $employee);
				
				$this->email->subject('Aprroval needed');
				$this->email->message($message);
				
				$this->email->send();
				
				//add database record
				array_pop($data);
				$data['task'] = $task;
				$data['approval_needed'] = 5;
				$this->db->insert('approval',$data);				
			}
			redirect('etts/phase/'.$phase);
			
		} else {
			//load form
			$this->db->where('id',$this->uri->segment(5));
			$this->db->select('title,options');
			$query = $this->db->get('sections');
			foreach ($query->result() as $row) {
				$data['section_title'] = $row->title;
				$options = unserialize($row->options);
			}
			$fields = array();
			if(is_array($options)) {
				$data['check'] = TRUE;
				$sbc = sbc();
				foreach ($options as $option) {
					switch ($option['field']) {
						case 'text':
							$fields[] = '
								<div class="control-group">
									<label class="control-label" for="'.$option['title'].'">'.$option['title'].'</label>
									<div class="controls">
										<input type="text" name="'.$option['title'].'" placeholder="'.$option['title'].'" '.set_value($option['title']).' />
									</div>
								</div>';
							break;
						
						case 'date':
							$fields[] = '
								<div class="control-group">
									<label class="control-label" for="'.$option['title'].'">'.$option['title'].'</label>
									<div class="controls">
										<input type="text" class="input-xlarge datepicker" id="'.$option['title'].'" name="'.$option['title'].'" placeholder="'.$option['title'].'" '.set_value($option['title']).'>
									</div>
								</div>';
							break;
						case 'employee':
							if(!isset($employees)) {
								$this->db->select('first_name, last_name');
								$this->db->where('id >', 1);
								$query = $this->db->get('employees');
								$employees = '<select id="employee" name="'.$option['title'].'" data-rel="chosen">';
									$employees .='<option value="N/A" '.set_select($option['title'], 'N/A').'>N/A</option>';
									foreach ($query->result() as $row) {
										$name = $row->first_name.' '.$row->last_name;
										$employees .='<option value="'.$name.'" '.set_select($option['title'], $name).'>'.$name.'</option>';
									}
								$employees .='</select>';
							}
							$fields[] = '
								<div class="control-group">
									<label class="control-label" for="'.$option['title'].'">'.$option['title'].'</label>
									<div class="controls">
										'.$employees.'
									</div>
								</div>';
							break;
						case 'location':
							$locations = '
								<select id="location" name="'.$option['title'].'" data-rel="chosen">
									<option value="school" '.set_select($option['title'], 'School').'>School</option>
									<option value="home" '.set_select($option['title'], 'Home').'>Home</option>
								</select>';
							$fields[] = '
								<div class="control-group">
									<label class="control-label" for="'.$option['title'].'">'.$option['title'].'</label>
									<div class="controls">
										'.$locations.'
									</div>
								</div>';
							break;
						case 'file':
							$fields[] = '
								<div class="control-group">
									<label class="control-label" for="'.$option['title'].'">'.$option['title'].'</label>
									<div class="controls">
										<input type="hidden" name="'.$option['title'].'" value="'.uniqid().'" />
										<input type="file" name="'.$option['title'].'" id="'.$option['title'].'" '.set_value($option['title']).' />
									</div>
								</div>';
							break;
						case 'status':
							$s++;
							$fields[] = '
							<input type="hidden" name="status'.$s.'" value="Pending" />';
							break;
					}//end switch
					if($s == 1) {
						$text = '<p class="alert alert-info">Submitting this task will send an email to '.$sbc['name'].' for approval.';
						array_unshift($fields,$text);
					}
				}//end foreach
			} else {
				$data['check'] = FALSE;
				$fields = array('<p class="alert alert-info">No fields have been added yet. Try again later or contact Angie.');
			}//end if
			$data['fields'] = $fields;
			$data['title'] = 'Add Task';
			$data['content'] = 'etts/forms/add_task';
			$this->load->view('template',$data);
		}//end if posted
	}

	public function delete_task()
	{
		if(isset($_POST['submitted'])) {
			//delete task
			$task = $this->uri->segment(5);
			$this->db->delete('tasks', array('id' => $task)); 
			redirect(base_url().'etts/phase/'.$this->uri->segment(4));
		} else {
			//show confirmation
			$data['title'] = 'Delete Task';
			$data['content'] = 'etts/forms/delete_task';
			$this->load->view('template',$data);			
		}
	}
	
	public function structure()
	{
		check_perm($this->session->userdata('position'));
		$this->load->model('Phase_model');
		$phase = $this->uri->segment(4);
		$data['sections'] = $this->Phase_model->get_sections_sbc($phase);
		
		$data['phase'] = $phase;
		$data['title'] = 'Phase Structure';
		$data['content'] = 'etts/structure';
		$this->load->view('template', $data);
	}
	
	public function update_background()
	{
		check_perm($this->session->userdata('position'));
		if(isset($_POST['date'])) {
			$data = array('background' => $this->input->post('date'));
			$this->db->where('employee', $this->uri->segment(4));
			$query = $this->db->update('phase1-1', $data);
			redirect('dashboard');
		} else {
			$data['title'] = 'Update background chack';
			$data['content'] = 'etts/forms/update_1-1';
			$this->load->view('template', $data);
		}
	}

	public function update_contract()
	{
		if(isset($_POST['date'])) {
			$data = array('contract' => $this->input->post('date'));
			$this->db->where('employee', $this->uri->segment(4));
			$query = $this->db->update('phase1-1', $data);
			redirect('dashboard');
		} else {
			$data['title'] = 'Update Employee Contract Aprroval';
			$data['content'] = 'etts/forms/update_1-1';
			$this->load->view('template', $data);
		}
	}
	
	public function update_supervision()
	{
		if(isset($_POST['date'])) {
			$data = array('supervision' => $this->input->post('date'));
			$this->db->where('employee', $this->uri->segment(4));
			$query = $this->db->update('phase1-1', $data);
			redirect('dashboard');
		} else {
			$data['title'] = 'Update Employee Information';
			$data['content'] = 'etts/forms/update_1-1';
			$this->load->view('template', $data);
		}
	}
	
	public function update_manual()
	{
		if(isset($_POST['submitted'])) {
			$this->db->where('employee',$this->session->userdata('id'));
			$query = $this->db->get('phase1-2');
			$data = array();
			foreach ($query->result() as $row) {
				if(!$row->trainer){$data['trainer'] = $this->input->post('trainer');}
				if(!$row->initials){$data['initials'] = $this->input->post('initials');}
			}
			$this->db->where('employee',$this->session->userdata('id'));
			$this->db->update('phase1-2',$data);
		}
		redirect('etts/phase/1');
	}
	
	public function approval()
	{
		$id = $this->uri->segment(3);
		$this->db->select('section,task,employee');
		$query = $this->db->get_where('approval',array('id'=>$id),1);
		foreach ($query->result() as $row) {
			$section = $row->section;
			$task = $row->task;
			$employee = $row->employee;
		}
		
		$this->db->select('phase');
		$query = $this->db->get_where('sections',array('id'=>$section));
		foreach ($query->result() as $row) {
			$phase = $row->phase;
		}
		$this->db->select('first_name, last_name');
		$query = $this->db->get_where('employees',array('id'=>$employee));
		foreach ($query->result() as $row) {
			$employee_name = $row->first_name.' '.$row->last_name;
		}
		$this->load->model('Phase_model');
		$section_data = $this->Phase_model->get_sections_employee($phase,$employee);
		
		$data['section'] = $section_data[$section]['options'];		
		//get task data
		foreach($section_data[$section]['data'] as $task_info) {
			if($task_info['id'] == $task) {
				$date = array_shift($task_info);
				array_pop($task_info);
				$task_data = $task_info;
			}
		}
		if(isset($_POST['submitted'])) {
			//check for second status
			$i = 0;
			foreach($section_data[$section]['options'] as $value) {
				if(strstr($value, 'Peeler')) { $i++; }
			}
			if($i > 0) {
				//check if dr. peeler approved
				if($this->session->userdata('position') != 8) {
					//email dr. peeler and update approval record
					$this->load->library('email');
					$message = $employee_name .' has added a task that requires your attention for approval. Please log into '.base_url().' and check your "Current Action Items" to approve or reject it.';
					$this->email->from('webmail@behsolutions.com', 'Behavior Solutions Admin');
					$this->email->to('cpeeler@behsolutions.com');
					$this->email->subject('Aprroval needed');
					$this->email->message($message);
					$this->email->send();
					
					$update = array('approval_needed' => 8);
					$this->db->where('id', $id);
					$this->db->update('approval',$update);
					//update task data
					$task_data['status1'] = 'Approved';
					$update = array('data'=>serialize($task_data));
					$this->db->where('id', $task);
					$this->db->update('tasks',$update);
					redirect('admin');
				} else {
					//delete approval record
					$this->db->delete('approval',array('id' => $id));
					//update task data
					$task_data['status2'] = 'Approved';
					$update = array('data'=>serialize($task_data));
					$this->db->where('id', $task);
					$this->db->update('tasks',$update);
					redirect('admin');
				}
			} else {
				//delete approval record
				$this->db->delete('approval',array('id' => $id));
				//update task data
				$task_data['status1'] = 'Approved';
				$update = array('data'=>serialize($task_data));
				$this->db->where('id', $task);
				$this->db->update('tasks',$update);
				redirect('admin');
			}
			
			//update task data
			$task_data['status1'] = 'Approved';
			$update = array('data'=>serialize($task_data));
			$this->db->where('id', $task);
			$this->db->update('tasks',$update);
			redirect('admin');
			
		} else {
			$data['task'] = $task_data;
			$data['date'] = $date;
			$data['content'] = 'etts/forms/approval';
			$data['title'] = 'Approval';
			$this->load->view('template', $data);
		}
	}

	public function rejection()
	{
		//get task data
		$id = $this->uri->segment(3);
		$this->db->select('section,task,employee');
		$query = $this->db->get_where('approval',array('id'=>$id),1);
		
		foreach ($query->result() as $row) {
			$section = $row->section;
			$task = $row->task;
			$employee = $row->employee;
		}
		
		$this->db->select('phase');
		$query = $this->db->get_where('sections',array('id'=>$section));
		foreach ($query->result() as $row) {
			$phase = $row->phase;
		}
		
		$this->db->select('email');
		$query = $this->db->get_where('employees',array('id'=>$employee));
		foreach ($query->result() as $row) {
			$employee_email = $row->email;
		}
		$this->load->model('Phase_model');
		$section_data = $this->Phase_model->get_sections_employee($phase,$employee);
		
		$data['section'] = $section_data[$section]['options'];		
		//get task data
		foreach($section_data[$section]['data'] as $task_info) {
			if($task_info['id'] == $task) {
				$date = array_shift($task_info);
				array_pop($task_info);
				$task_data = $task_info;
			}
		}
		if(isset($_POST['submitted'])) {
			//determine who is rejecting
			if($this->session->userdata('position') == 6) {
				//delete approval record
				$this->db->delete('approval',array('id' => $id));
				//update task data
				$task_data['status1'] = 'Rejected';
				$update = array('data'=>serialize($task_data));
				$this->db->where('id', $task);
				$this->db->update('tasks',$update);
				$consultant = $this->session->userdata('first_name').' '.$this->session->userdata('last_name');
			} else { // dr. peeler
				//delete approval record
				$this->db->delete('approval',array('id' => $id));
				//update task data
				$task_data['status2'] = 'Rejected';
				$update = array('data'=>serialize($task_data));
				$this->db->where('id', $task);
				$this->db->update('tasks',$update);
				$consultant = $this->session->userdata('first_name').' '.$this->session->userdata('last_name');
			}
			//email employee
			$this->load->library('email');
			$subject = $consultant .' has rejected your recent task approval request.';
			$message = $this->input->post('message');
			$this->email->from('webmail@behsolutions.com', 'Behavior Solutions Admin');
			$this->email->to($emploayee_email);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
			redirect('dashboard');
		} else {
			//if not submitted
			$data['content'] = 'etts/forms/rejection';
			$data['title'] = 'Behavior Solutions Admin';
			$this->load->view('template',$data);
		}
	}
	
	public function phase_approval()
	{
		$phase = $this->uri->segment(3);
		$employee = $this->uri->segment(4);
		//update phases table
		$this->db->where('employee',$employee);
		$this->db->where('phase',$phase);
		$update = array(
			'status'		=> 'Approved',
			'date'			=> date('m/d/Y'),
			'approved_by'	=> $this->session->userdata('id')
		);
		$this->db->update('phases', $update);
		
		$this->db->select('first_name, last_name, email');
		$query = $this->db->get_where('employees',array('id'=>$employee));
		foreach ($query->result() as $row) {
			$employee_email = $row->email;
			$employee_name = $row->first_name.' '.$row->last_name;
		}
		//send email to emp
		$this->load->library('email');
		
		switch ($phase) {
			case '1':
				$message = 'Congratulations! You have completed the training criteria to begin ride alongs with Behavior Solutions\' Behavior Assistants and Consultants seeing clients.  Consultants will get an email saying you are now eligible for such hours and they will contact you if they have openings. You can find all of their contact information at www.behsolutions.com/admin so you can email or call them to follow up on what’s available. If not contact Angie Peeler and she can assist in identifying clients. Keep up the great efforts training.';
				$consultant_message = $employee_name .' has completed phase 1. They are now available to begin working with clients under supervision.';
				break;
			case '2':
				$message = 'Congratulations! You have mastered all of the prerequisites for running sessions solo with clients. Keep up the great efforts in ongoing training!';
				$consultant_message = $employee_name .' has completed phase 2. They are now available to begin working with clients on their own.';
				break;
			case '3':
				$message = 'Congratulations! You have mastered all the tasks of running sessions solo.';
				break;
			case '4':
				$message = 'Congratulations! You have finished the Behavior Cosultant criteria.';
				break;
		}
		$this->email->from('webmail@behsolutions.com', 'Behavior Solutions Admin');
		$this->email->to($employee_email);		
		$this->email->subject('Phase Completion');
		$this->email->message($message);
		
		$this->email->send();
		//send email to consultants and dr. peeler
		if($phase < 3) {
			$consultant_message .= ' Reply to this email to contact him/her or got to behsolutions.com/admin.';
			$this->db->where('position >', 3);
			$this->db->where('position !=', 9);
			$this->db->select('email');
			$query = $this->db->get('employees');
			foreach ($query->result() as $row) {
				$emails = $row->email.', ';
			}
			
			$emails = substr($emails,0,-2);
			$this->email->from('webmail@behsolutions.com', 'Behavior Solutions Admin');
			$this->email->cc('cpeeler@behsolutions.com');
			$this->email->to($emails);
			$this->email->reply_to($employee_email);
			$this->email->subject('Phase Completion');
			$this->email->message($consultant_message);
			
			$this->email->send();
		} else {
			$message = $employee_name .' has completed phase '.$phase.'. Reply to this email to contact him/her.';
			$this->email->from('webmail@behsolutions.com', 'Behavior Solutions Admin');
			$this->email->to('cpeeler@behsolutions.com');
			$this->email->reply_to($employee_email);
			$this->email->subject('Phase Completion');
			$this->email->message($message);
			
			$this->email->send();
		}
		redirect(base_url().'etts');
	}
	
	public function phase_rejection()
	{
		$this->load->library('email');
		$phase = $this->uri->segment(3);
		$employee = $this->uri->segment(4);
		
		if(isset($_POST['submitted'])) {
			//update phases table
			$this->db->where('employee',$employee);
			$this->db->where('phase',$phase);
			$update = array(
				'status'	=> 'Rejected',
				'date'		=> date('m/d/Y'),
				'approved_by'	=> $this->session->userdata('id')
			);
			$this->db->update('phases', $update);
			//send emp email
			$this->db->select('email');
			$query = $this->db->get_where('employees',array('id'=>$employee));
			foreach ($query->result() as $row) {
				$employee_email = $row->email;
			}
			$this->email->from('webmail@behsolutions.com', 'Behavior Solutions Admin');
			$this->email->to($employee_email);
			$this->email->subject('Your phase approval request has been rejected.');
			$this->email->message($message);
			
			$this->email->send();
			redirect(base_url().'etts');
		} else {
			//display message form
			$data['content'] = 'etts/forms/phase_rejection';
			$data['title'] = 'Behavior Solutions Admin';
			$this->load->view('template',$data);
		}
	}
	
	public function download_file()
	{
		$this->load->helper('download');
		$path = $this->uri->segment('4');
		$file = $this->uri->segment('5');
		$data = file_get_contents("./assets/etts/".$path.'/'.$file);
		$name = 'userfile_'.$path.substr($file,1);

		force_download($name, $data);
		if($path == 'hippaa'|'signature') {
			$redirect = 'etts/phase/1';
		}
		redirect($redirect);
	}
	
	public function sbc_mail()
	{
		$employee = $this->session->userdata('first_name').' '.$this->session->userdata('last_name');
		$phase = $this->uri->segment(4);
		$redirect = base_url().'etts/phase/'.$phase;
		$this->db->where('employee',$this->session->userdata('id'));
		$this->db->where('phase',$phase);
		$query = $this->db->get('phases');
		
		if($query->num_rows() == 1){
			//update database
			$this->db->where('employee', $this->session->userdata('id'));
			$this->db->where('phase', $phase);
			$data = array('status'=>'Pending');
			$this->db->update('phases',$data);
		} else {
			$data = array(
				'phase'		=> $phase,
				'employee'	=> $this->session->userdata('id'),
				'status'	=> 'Pending'
			);
			$this->db->insert('phases',$data);
			
		}
			// send email
		$this->load->library('email');
		
		$message = $employee .' have completed phase '.$phase.'. Please log into '.base_url().' to approve or reject it.';
		$this->email->from('webmail@behsolutions.com', 'Behavior Solutions Admin');
		$this->email->to('lgilbertsen@behsolutions.com');
		$this->email->cc('cpeeler@behsolutions.com');
		$this->email->reply_to($this->session->userdata('email'), $employee);
		
		$this->email->subject('Phase Completion');
		$this->email->message($message);
		
		$this->email->send();
		
		redirect($redirect);
	}

	public function exemption()
	{
		if($this->uri->segment(3) == 'add') {
			$data = array(
				'task' => $this->uri->segment(4),
				'employee' => $this->uri->segment(5),
				'phase' => $this->uri->segment(6)
			);
			$this->db->insert('exemption', $data);
			redirect(base_url().'etts/phase/'.$this->uri->segment(6).'/'.$this->uri->segment(5));
		} else {
			$this->db->where('task',$this->uri->segment(4));
			$this->db->where('employee',$this->uri->segment(5));
			$this->db->delete('exemption');
			redirect(base_url().'etts/phase/'.$this->uri->segment(6).'/'.$this->uri->segment(5));
		}
	}
	
	private function __process_section($section_id, $purpose)
	{
		$data = $this->Sections_model->get_options($section_id);
		if($purpose == 'form') {
			$options = array();
			foreach ($data as $option) {
				switch ($option) {
					case 'title':
						$options[] = array(
										'name'	=> 'title',
										'type'	=> 'text',
										'class'	=> 'input-xlarge focused'
									);
						break;
					case 'date':
						$options[] = array(
										'name'	=> 'date',
										'type'	=> 'text',
										'class'	=> 'input-xlarge datepicker hasDatepicker'
									);
						break;
					case 'score':
						$options[] = array(
										'name'	=> 'score',
										'type'	=> 'text',
										'class'	=> 'input-xlarge focused'
									);
						break;
					case 'client':
						$options[] = array(
										'name'	=> 'client',
										'type'	=> 'text',
										'class'	=> 'input-xlarge focused'
									);
						break;
					case 'trainer':
						$options[] = array(
										'name'	=> 'trainer',
										'type'	=> 'text',
										'class'	=> 'span6 typeahead'
									);
						break;
					case 'employee':
						$options[] = array(
										'name'	=> 'employee',
										'type'	=> 'text',
										'class'	=> 'input-xlarge focused'
									);
						break;
					case 'file':
						$options[] = array(
										'name'	=> 'file',
										'type'	=> 'file',
										'class'	=> 'uploader'
									);
						break;
				}
			}
			
		} else {
			//display data
		}
	}

	public function do_upload()
	{
		$this->load->library('upload');
		
		if(isset($_POST['hippaa_file'])) {
			$config['upload_path'] = './assets/etts/hippaa';
			$redirect = '/etts/phase/1';
		} elseif(isset($_POST['sig_page'])) {
			$config['upload_path'] = './assets/etts/signature';
			$redirect = '/etts/phase/1';
		}
		$config['file_name'] = $this->session->userdata('id');
		$config['allowed_types'] = 'pdf|doc|docx|jpg|ppt|pptx|xls|xlsx';
		$config['max_size']	= '2048';
		$this->load->library('upload',$config);
		$this->upload->initialize($config);

		if ( ! $this->upload->do_upload())
		{
			$message = array('alert-error' => $this->upload->display_errors());
			$this->session->set_flashdata('message',array($message));
			
		}
		else
		{
			$file = $this->upload->data();
			if(isset($_POST['hippaa_file'])) {
				$data = array(
					'hippaa' => date('m/d/Y'),
					'hippaa_file' => $file['file_name']
				);
				$table = 'phase1-1';
			} elseif(isset($_POST['sig_page'])) {
				$data = array(
					'date' => date('m/d/Y'),
					'sig_file' => $file['file_name']
				);
				$table = 'phase1-2';
			}
			$this->db->where('employee',$this->session->userdata('id'));
			$this->db->update($table,$data);
		}
		
		redirect($redirect);
	}

}

/* End of file etts.php */
/* Location: ./application/controllers/admin/etts.php */