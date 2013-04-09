<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends CI_Controller {
	
	public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
			if(!$this->session->userdata('id')) {
				redirect('login');
			}
       }

	public function index()
	{
		//get all data from all employees
		
		//send to view
	}
	
	public function employee()
	{
		//pull id from uri
		
		//get data for employee
		
		//send to view
	}
	
	public function send_mail()
	{
		//check for submission
		
		//if submitted, filter
		
			//send
			//add message
			//redirect back to employee page
		
		//if not, send to view
	}
	
}