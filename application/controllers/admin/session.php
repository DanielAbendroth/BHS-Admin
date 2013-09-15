<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session extends CI_Controller {
	
	public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
       }
	   
	public function index()
	{
		
	}

	public function login()
	{
		$data['error'] = array();
		if(isset($_POST['email'])) {
			//if the login form has been submitted
			//make sure fields have been filled in
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			if(empty($email)) {
				unset($email);
				$data['error'][] = 'Email cannot be empty.';
			}
			if(empty($password)) {
				unset($password);
				$data['error'][] = 'Password cannot be empty';
			}
			
			if(isset($email) && isset($password)) {
				$salt = 'salty-salty-iamaddingsalt-thisisapparentlysafer';
				$temp_pass = sha1($salt.$password);

				$password = sha1($password.$this->config->item('encryption_key'));
				//check if it is a current user
				$record = $this->db->get_where('employees',array('email' => $email, 'password' => $password),1);
				if($record->num_rows == 0){
					
					//i need to check to see whether or not the user is a new hire.
					$record = $this->db->get_where('employees',array('email' => $email, 'temp_pass' => $temp_pass),1);
					
					if($record->num_rows == 0){
						//we have determined that the person either typed the wrong email/password or does not belong here. Let them know.
						$data['error'][] = 'Email/Password does not match our records.';
					} else {
						//we have determined this person is a new hire and needs to set up their account
						$new_hire = TRUE;
					}//end check for new hire
				}//end check for current user
				
				if(empty($data['error'])) {
					
					//if there are no errors we have determined the person has a record. pull their data.
					$this->load->model('employees_model');
					$record = $this->employees_model->get_employee_data('email', FALSE, $email);
					foreach ($record as $row) {
						$this->session->set_userdata($row);
						//delete after Files conversion
						session_start();
						$_SESSION['beh_user_name'] = $row['first_name'];
						$_SESSION['beh_perm'] = 1;
						$_SESSION['beh_email'] = $row['email'];
						$_SESSION['beh_id'] = $row['id'];
					}
					$date = date('M j, Y g:i:s A');
					$update = array('last_login' => $date);
					$this->db->where('id', $this->session->userdata('id'));
					$this->db->update('employees',$update);
					
					 
					//now we need to send new hires to update their info and current users to their dashboard
					if($new_hire){
						redirect('employees/update'.'/'.base64_encode($this->session->userdata('id')));
					} else {
						
						redirect('dashboard');
					}
				}//end check for errors
			}// end check for empty values
			
		}// end check for submission
		
		
		$data['title'] = 'Behavior Solutions Admin';
		$this->load->view('login', $data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url().'/etts');
	}
}
	   
/* End of file session.php */
/* Location: ./application/controllers/admin/session.php */