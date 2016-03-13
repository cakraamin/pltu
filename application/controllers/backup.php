<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backup extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->library(array('page','SimpleLoginSecure','arey'));

		$this->load->library('acl',$this->session->userdata('user_id'));

		if(!$this->session->userdata('logged_in')) 
		{
			redirect('home');
		}
	}

	function index()
	{
		$data = array(			
			'main'			=> 'backup',
			'backup'		=> 'select'			
		);
		$this->load->view('template',$data);
	}	

	function restore()
	{
		$data = array(			
			'main'			=> 'restore',
			'backup'		=> 'select'			
		);
		$this->load->view('template',$data);
	}	

	function bekup()
	{		
		$this->load->helper('download');
		$tanggal = date('Ymd-His');
		$namaFile = $tanggal . '.sql.zip';
		$this->load->dbutil();		
		$backup = $this->dbutil->backup();
		force_download($namaFile, $backup);		
	}

	function restor()	
	{		
		$config['upload_path'] = './uploads/database/';
		$config['allowed_types'] = 'zip|sql';
		$config['max_size']	= '100000';
		$config['max_width']  = '302400';
		$config['max_height'] = '206800';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$this->message->set('notice',$this->upload->display_errors());						
		}
		else
		{
			$hasil = $this->upload->data();
			
			$isi_file = file_get_contents("./uploads/database/".$hasil['file_name']);
			$string_query = rtrim( $isi_file, "\n;" );
			$array_query = explode(";", $query);
			foreach($array_query as $query)
			{
				$this->db->query($query);
			}

			unlink($uploadpath);
			$this->message->set('succes','Import Database Berhasil');
			redirect('backup/restore');
		}		
	}
}