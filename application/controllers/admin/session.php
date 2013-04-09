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
		if(isset($_POST['email']))
		{
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			if(empty($email))
			{
				$data['error'][] = 'Email is empty.';
			}
			
			if(empty($password))
			{
				$data['error'][] = 'Password is empty.';
			}
			
			if(!isset($data['error']))
			{
				$salt = 'salty-salty-iamaddingsalt-thisisapparentlysafer';
				$password = sha1($salt.$password);
				//if there or no issues, check for a record
				$creds = array(
					'email' => $email,
					'password' => $password
				);
				$record = $this->db->get_where('employees',$creds,1);

				if($record->num_rows === 0)
				{
					$data['error'][] = 'Email/password do not match our records.';
				} else {
					foreach ($record->result() as $row) {
						$user = array(
							'id'			=> $row->id ,
							'first_name'	=> $row->first_name,
							'last_name'		=> $row->last_name,
							'position'		=> $row->position,
							'email'			=> $row->email							
						);
					}
					$this->session->set_userdata($user);
					redirect('dashboard');
				}
			}
		}// end if post
		$data['flash'] = $this->session->flashdata('response');
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