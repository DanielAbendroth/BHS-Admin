<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
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
		$data = array(
			'title' => 'ETTS',
			'content' => 'etts'
		);
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