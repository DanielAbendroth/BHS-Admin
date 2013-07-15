<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility extends CI_Controller {
	
	public function index()
	{
		$sbc = sbc();
		print_r($sbc);
	}
}
