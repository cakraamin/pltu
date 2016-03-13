<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stream extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('mfasilitas','',TRUE);
		$this->load->library(array('page','SimpleLoginSecure','arey'));		
	}

	function index()
	{				
		$this->load->view('stream');
	}
}