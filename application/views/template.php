<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$this->load->view('template/header');
	$this->load->view('template/topbar');
	$this->load->view('template/leftbar');
	$this->load->view($content);
	$this->load->view('template/footer');
	
/* End of file template.php */
/* Location: ./application/views/template.php */