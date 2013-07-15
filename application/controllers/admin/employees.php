<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends CI_Controller {
	
	public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
			if(!$this->session->userdata('id')) {
				redirect('login');
			}
			$this->load->model('Employees_model');
       }

	public function index()
	{
		$data = array();
		
		//determine where
		if($this->input->get('where')) {
			$where = $this->input->get('where');
		} else {
			$where = '';
		}
		//determine deactivated
		if($this->input->get('deactivated')) {
			$deactivated = $this->input->get('deactivated');
		} else {
			$deactivated = FALSE;
		}
		//determine extra
		if($this->input->get('extra')) {
			$extra = $this->input->get('extra');
		} else {
			$extra = '';
		}
		//get data
		$data['employees'] = $this->Employees_model->get_employee_data($where,$deactivated,$extra);
		
		//send to view
		$data['content'] = 'employees/employees_view';
		$data['title'] = 'Employees -- Behavior Solutions Admin';
		$this->load->view('template', $data);
	}

	public function profile()
	{
		$where = 'id';
		$deactivated = FALSE;
		//pull id from uri
		if($this->uri->segment(3)) {
			$id = $this->encrypt->encode($this->uri->segment(3));
		} else {
			$id = $this->encrypt->encode($this->session->userdata('id'));
		}
		//get data for employee
		$data['employee'] = $this->Employees_model->get_employee_data($where,$deactivated,$id);
		foreach ($data['employee'] as $employee) {
			$employee['position'] = handle_position($employee['position']);
			$employee['phone'] = handle_phone($employee['phone']);
		}
		//send to view
		$data['content'] = 'employees/profile_view';
		$data['title'] = 'Employees -- Behavior Solutions Admin';
		$this->load->view('template', $data);
	}

	public function email()
	{
		$employee	= $this->Employees_model->get_employee_data('id',FALSE,$this->uri->segment(3));
		//check for submission
		if(isset($_POST['submitted'])) {
		//if submitted
			$from		= $this->session->userdata('email');
			$name		= $this->session->userdata('first_name') .' '.$this->session->userdata('last_name');
			$to			= $employee[0]['email'];
			$subject	= $this->input->post('subject');
			$message	= $this->input->post('message');

			//send
			$this->load->library('email');
			$this->email->from($from, $name);
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();

			//add message
			//redirect back to employee page
			$url = base_url().'employees';
			redirect($url);
		} else {
		//if not, send to view
			$data['email'] = $employee[0]['email'];
			$data['content'] = 'employees/email_view';
			$data['title'] = 'Employees -- Behavior Solutions Admin';
			$this->load->view('template', $data);
		}
	}

	public function add()
	{
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[employees.email]');
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|numeric|exact_length[10]');
		$this->form_validation->set_rules('hire_date', 'Hire Date', 'required|numeric|exact_length[8]');
		$this->form_validation->set_rules('position', 'position', 'required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		if ($this->form_validation->run() == TRUE){
		
		//if submited
			//format data
			$data = array(
				'first_name'	=> $this->input->post('first_name'),
				'last_name'		=> $this->input->post('last_name'),
				'email'			=> $this->input->post('email'),
				'phone'			=> $this->input->post('phone'),
				'position'		=> $this->input->post('position'),
				'hire_date'		=> $this->input->post('hire_date'),
				'status'		=> 1
			);
			//add to database
			$this->db->insert('employees',$data);
			//redirect to employees page
			redirect('employees');
		} else {
		//if not submitted, send to view
			$data = array(
				'first_name'	=> '',
				'last_name'		=> '',
				'email'			=> '',
				'phone'			=> '',
				'position'		=> '',
				'hire_date'		=> ''
			);
			$data['content'] = 'employees/update_view';
			$data['title'] = 'Employees -- Behavior Solutions Admin';
			$this->load->view('template', $data);
		}
	}
	
	public function update()
	{
		$this->load->library('form_validation');
		//check for submission
		if($_POST['submitted']) {
		//if submited
			//format data
			$data[] = array(
				'first_name'	=> $this->input->post('first_name'),
				'last_name'		=> $this->input->post('last_name'),
				'email'			=> $this->input->post('email'),
				'phone'			=> $this->input->post('phone'),
				'position'		=> $this->input->post('position'),
				'hire_date'		=> $this->input->post('hire_date'),
				'status'		=> 1
			);
			//add to database
			$this->db->where('id',$this->encrypt->decode($this->uri->segment(3)));
			$this->db->update('employees',$data);
			//redirect to employees page
			redirect('employees');
		} else {
		//if not, get data for employee
			$data['employee'] = $this->Employee_model->get_employee_data('id',FALSE,$this->uri->segment(3));
		//send to view
			$data['content'] = 'employees/update_view';
			$data['title'] = 'Employees -- Behavior Solutions Admin';
			$this->load->view('template', $data);
		}
	}
	
	public function change_status()
	{
		//get id from uri
		$id = $this->uri->segment(3);
		//call model
		$this->Employees_model->change_status($id);
		//redirect to employees page
		redirect('employees');
	}
}

/* End of file employees.php */
/* Location: ./application/controllers/employees.php */