<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mberita','',TRUE);
		$this->load->helper('header');

		if(!$this->session->userdata('logged_in')) 
		{
			redirect('home');
		}
	}

	function index()
	{		
		$data = array(
			'home'			=> 'select',
			'main'			=> 'home',
			'roles'			=> $this->mberita->getRole($this->session->userdata('user_id')),
			'beritane'		=> $this->mberita->getBeritaBaru()
		);

		$this->load->view('template',$data);
	}

	function detil_berita($id)
	{
		$data = array(
			'home'			=> 'select',
			'main'			=> 'home_detil',
			'roles'			=> $this->mberita->getRole($this->session->userdata('user_id')),
			'berita'		=> $this->mberita->getBeritaDetil($id)
		);

		$this->load->view('template',$data);
	}
}