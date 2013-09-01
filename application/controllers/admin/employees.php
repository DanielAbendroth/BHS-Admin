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
			$this->load->helper('date');
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
			$id = base64_encode($this->uri->segment(3));
		} else {
			$id = base64_encode($this->session->userdata('id'));
		}
		//get data for employee
		$data['employee'] = $this->Employees_model->get_employee_data($where,$deactivated,$id);
		foreach ($data['employee'] as $employee) {
			$data['id'] = $employee['id'];
			$data['image'] = $employee['image'];
			$data['first_name'] = $employee['first_name'];
			$data['last_name'] = $employee['last_name'];
			$data['email'] = $employee['email'];
			$data['phone'] = handle_phone($employee['phone']);
			$data['position'] = handle_position($employee['position']);
			$data['hire_date'] = $employee['hire_date'];
		}
		unset($data['employee']);
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
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|numeric|exact_length[10]|is_unique[employees.phone]');
		$this->form_validation->set_rules('hire_date', 'Hire Date', 'required|numeric|exact_length[8]');
		$this->form_validation->set_rules('position', 'position', 'required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
		if ($this->form_validation->run() == TRUE){
		
		//if submited
			//format data
			$temp = uniqid();
			$salt = 'salty-salty-iamaddingsalt-thisisapparentlysafer';
			$password = sha1($salt.$temp);
			$data = array(
				'temp_pass'		=> $password,
				'first_name'	=> $this->input->post('first_name'),
				'last_name'		=> $this->input->post('last_name'),
				'email'			=> $this->input->post('email'),
				'phone'			=> $this->input->post('phone'),
				'position'		=> $this->input->post('position'),
				'image'			=> 'default.jpg',
				'hire_date'		=> $hire_date,
				'status'		=> 1
			);

			//add to database
			$this->db->insert('employees',$data);
			//email new hire
				$message	= 'A new account has been create for you at behsolutions.com/admin. Please login with this email. The password is '.$temp.
				'You will be prompted to verify your account and create a new password.
				If you have any questions, please contact Angie Peeler or reply to this email.';
	
				//send
				$this->load->library('email');
				$this->email->from('info@behsolutions.com', 'Behavior Solutions Admin');
				$this->email->to($data['email']);
				$this->email->subject('New Account');
				$this->email->message($message);
				$this->email->send();
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
		if(isset($_POST['submitted'])) {
		//if submited
			//format data
			$fields = array('first_name', 'last_name', 'email', 'phone', 'position', 'hire_date');
			foreach ($fields as $value) {
				if($this->input->post($value) != '') {
					$data[$value] = $this->input->post($value);
				}
			}
			if($_FILES['image']['name'] != '') {
				//format and upload picture
				$config['upload_path'] = './assets/pictures';
				$config['overwrite'] = TRUE;
				$config['file_name'] = $this->session->userdata('id');
				$config['allowed_types'] = 'gif|jpg|png';
		
				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('image'))
				{
					$error = array('error' => $this->upload->display_errors());
		
				}
				$file = $this->upload->data();
				
				$config['image_library'] = 'gd2';
				$config['source_image'] = $file['full_path'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 150;
				$config['height'] = 150;
		
				$this->load->library('image_lib', $config);
		
				$this->image_lib->resize();
				//set database info
				$data['image'] = $file['file_name'];
			}
			if($this->input->post('password') != '') {
				$data['password'] = sha1($this->input->post('password').$this->config->item('encryption_key'));
			}
			//add to database
			$this->db->where('id',base64_decode($this->uri->segment(3)));
			$this->db->update('employees',$data);
			//redirect to employees page
			if($this->session->userdata('new_hire')) {
				redirect('employees/success');
			} elseif(base64_decode($this->uri->segment(3)) == $this->session->userdata('id')) {
				redirect('employees/profile');
			} else {
			redirect('employees');
			}
		} else {
		//if not, get data for employee

			$data['employee'] = $this->Employees_model->get_employee_data('id',FALSE,$this->uri->segment(3));
			foreach ($data['employee'] as $key => $value) {
				$data[$key] = $value;
			}
			foreach ($data['0'] as $key => $value) {
				$data[$key] = $value;
			}
			unset($data['employee'],$data[0]);
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

	public function success()
	{
		echo '<p>You have successfully completed the signup process.</p><p><a href="'.base_url().'logout">Click here</a> to test your new password.</p>';
	}

}

/* End of file employees.php */
/* Location: ./application/controllers/employees.php */