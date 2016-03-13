<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mberita extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function getBerita($num,$offset,$sort_by,$sort_order)//menu admin
	{
		if (empty($offset))
		{
			$offset=0;
		}
		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = array('a.id_berita');
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'a.id_berita';
		$sql = "SELECT * FROM berita a,users b WHERE a.user_id=b.user_id ORDER BY $sort_by $sort_order LIMIT $offset,$num";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function addBerita($id,$gambar="")
	{
		$data = array(
			'id_berita' 		=> '',
		   	'judul_berita' 		=> strip_tags(ascii_to_entities(addslashes($this->input->post('judul',TRUE)))),
		   	'content_berita' 	=> strip_tags(ascii_to_entities(addslashes($this->input->post('content',TRUE)))),
		   	'gambar_berita'		=> $gambar,
		   	'tgl_berita'		=> date('Y-m-d'),
		   	'user_id'			=> $id
		);

		$this->db->insert('berita', $data); 
	}

	function deleteBerita($id)
	{
		$kueri = $this->db->query("DELETE FROM berita WHERE id_berita='$id'");
		return $kueri;
	}

	function getBeritaId($id)
	{
		$kueri = $this->db->query("SELECT * FROM berita WHERE id_berita='$id'");
		return $kueri->row();
	}

	function updateBerita($id,$gambar="")
	{
		if($gambar == "")
		{
			$data = array(
	        	'judul_berita' 		=> strip_tags(ascii_to_entities(addslashes($this->input->post('judul',TRUE)))),
			   	'content_berita' 	=> strip_tags(ascii_to_entities(addslashes($this->input->post('content',TRUE)))),
			   	'tgl_berita'		=> date('Y-m-d'),
	        );
		}
		else
		{
			$data = array(
	        	'judul_berita' 		=> strip_tags(ascii_to_entities(addslashes($this->input->post('judul',TRUE)))),
			   	'content_berita' 	=> strip_tags(ascii_to_entities(addslashes($this->input->post('content',TRUE)))),
			   	'gambar_berita'		=> $gambar,
			   	'tgl_berita'		=> date('Y-m-d'),
	        );
		}		

		$this->db->where('id_berita', $id);
		$this->db->update('berita', $data); 
	}

	function getRole($id)
	{
		$kueri = $this->db->query("SELECT * FROM user_roles WHERE userID='$id'");
		$hasil = $kueri->row();
		$data = (isset($hasil->roleID))?$hasil->roleID:0;
		return $data;
	}

	function getBeritaBaru()
	{
		$kueri = $this->db->query("SELECT * FROM berita ORDER BY id_berita DESC LIMIT 0,6");
		return $kueri->result();
	}

	function getBeritaDetil($id)
	{
		$kueri = $this->db->query("SELECT * FROM berita WHERE id_berita='$id'");
		return $kueri->result();
	}

	function getBeritaUnread($arey)
	{
		$data = array();

		$pecah = explode("-", $arey);
		foreach($pecah as $dt_pecah)
		{
			if($dt_pecah != "")
			{					
				$query = $this->db->query("SELECT * FROM berita WHERE id_berita='$dt_pecah'");
				$hasil = $query->row();

				$id_berita = (isset($hasil->id_berita))?$hasil->id_berita:"";

				$data[] = array(
					'id_berita' 		=> $id_berita,
					'judul_berita' 		=> (isset($hasil->judul_berita))?$hasil->judul_berita:"",
					'content_berita' 	=> (isset($hasil->content_berita))?$hasil->content_berita:"",
					'gambar_berita' 	=> (isset($hasil->gambar_berita))?$hasil->gambar_berita:"",
					'tgl_berita' 		=> (isset($hasil->tgl_berita))?$hasil->tgl_berita:"",
					'user_id' 			=> (isset($hasil->user_id))?$hasil->user_id:"",
				);
				$baca = (isset($hasil->read_berita))?$hasil->read_berita:"";
				$baca = $baca.",".$this->session->userdata('user_id').",";
				$update = $this->db->query("UPDATE berita SET read_berita='$baca' WHERE id_berita='$id_berita'");
			}			
		}
		return $data;
	}
}
?>