<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('ftp');

	}

	function index()
	{		
		/*if(!$this->cekane())
		{
			redirect('import/setting');
		}*/

		$this->load->library('ftp');

		$data = $this->woconen();		

		$config['hostname'] = trim($data[0]);
		$config['username'] = trim($data[1]);
		$config['password'] = trim($data[2]);
		$config['port']     = trim($data[3]);

		/*$config['hostname'] = "192.168.11.144";
		$config['username'] = "jajal";
		$config['password'] = "vespasuper";
		$config['port']     = "21";*/		

		if(!$this->ftp->connect($config))
		{
			redirect('import/setting');
		}		

		$list = $this->ftp->list_files('/Program Files/GST/DATA');

		foreach($list as $dt_list)
		{
			$nama_file = end(explode("/", $dt_list));
			$ekstenstion = end(explode(".", $dt_list));
			$tujuan = 'G://xampp/htdocs/pltu/uploads/data/'.$nama_file;
			if($ekstenstion == "DBF")
			{
				$this->ftp->download($dt_list,$tujuan);			
			}			
		}

		redirect('import/administrator');

		$this->ftp->close();
	}

	function administrator()
	{
		$this->load->view('administrator');	
	}

	function setting()
	{
		/*if($this->cekane())
		{
			redirect('import');
		}*/

		$data = $this->woconen();

		$data = array(
			'ket'		=> 'Setting Direktori',
			'main'		=> 'settings',
			'link'		=> 'simpan',
			'jenis'		=> 'Simpan',
			'data'		=> $data
		);

		$this->load->view('template',$data);
	}

	function redir()
	{
		echo "Tunggu Sebentar, download file timbangan.....";
		$this->output->set_header('refresh:5; url=import');
	}

	function simpan()
	{
		$this->bikin();
		redirect('import/redir');
	}

	function bikin()
	{
		$myfile = fopen("./uploads/setting/settingan.txt", "w+") or die("Unable to open file!");
		$txt = $this->input->post('alamat',TRUE)."\n";
		fwrite($myfile, $txt);
		$txt = $this->input->post('username',TRUE)."\n";
		fwrite($myfile, $txt);
		$txt = $this->input->post('password',TRUE)."\n";
		fwrite($myfile, $txt);
		$txt = $this->input->post('port',TRUE)."\n";
		fwrite($myfile, $txt);
		fclose($myfile);
	}

	function woconen()
	{
		$data = array();

		$filename = './uploads/setting/settingan.txt';
		if (file_exists($filename)) 
		{
		    $myfile = fopen($filename, "r");		
			while(!feof($myfile)) 
			{
				$data[] = fgets($myfile);
			}
			fclose($myfile);
		} 
		else 
		{
		    for($i=0;$i<=3;$i++)
		    {
		    	$data[] = "";
		    }
		}		

		return $data;
	}

	function cekane()
	{
		$filename = './uploads/setting/settingan.txt';
		if (file_exists($filename)) 
		{
		    $data = $this->woconen();

		    if(count($data) == 5 && $data[0] != "")
		    {
		    	return true;		    	
		    }
		    else
		    {
		    	return false;		    	
		    }
		} 
		else 
		{
		    return false;		    
		}	
	}
}