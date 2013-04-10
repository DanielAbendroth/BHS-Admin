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
		
	}	   
	   
}
/* End of file files.php */
/* Location: ./application/controllers/files.php */