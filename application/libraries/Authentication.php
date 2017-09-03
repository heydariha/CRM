<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Authentication extends CI_Controller
{	
	
	function __construct() {
		// parent::__construct();
		// $this->load->helper('form');
		// $this->load->helper('url');
		// echo 3939;exit;
	}
	
	function checkSession()
	{
		$itus =& get_instance();
		if(empty($itus->session->userdata('user_id')))
		{
			redirect('/login');
			// redirect(base_url('/login'));
			exit();
		}		
	}
}
//end