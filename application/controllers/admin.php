<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	 public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(TRUE);
       }
	   
	public function index()
	{
		$data = array(
			'title' => 'Dashboard',
			'content' => 'dashboard'
		);
		$this->load->view('template', $data);
	}
	
	public function files()
	{
		$data = array(
			'title' => 'File Manager',
			'content' => 'files'
		);
		$this->load->view('template', $data);
	}
	
	public function employees()
	{
		$data = array(
			'title' => 'Employees',
			'content' => 'employees'
		);
		$this->load->view('template', $data);
	}
	
	public function etts()
	{
		if($this->uri->segment(2))
		{
			$option = $this->uri->segment(2);
			if($option = 'phase')
			{
				$this->load->helper('form');
				$phase = $this->uri->segment(3);
				$data = array();
				
				//load modal
				
				//get data
				$data['title'] = 'ETTS';
				$data['content'] = 'etts/phase_'.$phase;
			}
			
		} else {
			$data = array(
				'title' => 'ETTS',
				'content' => 'etts/main'
			);
		}

		$this->load->view('template', $data);
	}
	
	public function store()
	{
		$data = array(
			'title' => 'Store',
			'content' => 'store'
		);
		$this->load->view('template', $data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */