<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility extends CI_Controller {
	
	public function index()
	{
		$config['image_library'] = 'gd2';
				$config['source_image'] = 'assets/pictures/default.png';
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 150;
				$config['height'] = 150;
		
				$this->load->library('image_lib', $config);
		
				$this->image_lib->resize();
	}
}
