<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Masters extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mmaster','',TRUE);
		$this->load->library(array('page','SimpleLoginSecure','arey'));

		$this->load->library('acl',$this->session->userdata('user_id'));

		if(!$this->session->userdata('logged_in')) 
		{
			redirect('home');
		}
	}

	function index()
	{
		redirect('masters/sekolah');		
	}

	function sekolah($id,$nama,$short_by='id_school',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->mmaster->getNumSkul($id);
		$url = 'masters/sekolah/'.$id.'/'.$nama.'/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->mmaster->getSkul($id,$per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('masters/sekolah/'.$id.'/'.$nama.'/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'schools',
			'sekolah'		=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page,
			'id'			=> $id,
			'nama'			=> $nama
		);

		$this->load->view('template',$data);
	}

	function propinsi($short_by='id_propinsi',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->db->count_all('propinsi');
		$url = 'masters/propinsi/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->mmaster->getPropinsi($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('masters/propinsi/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'propinsi',
			'master'		=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page
		);
		$this->load->view('template',$data);
	}

	function kabupaten($short_by='id_kabupaten',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->db->count_all('kabupaten');
		$url = 'masters/kabupaten/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->mmaster->getKabupaten($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('masters/kabupaten/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'kabupaten',
			'master'		=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page
		);
		$this->load->view('template',$data);
	}

	function kecamatan($short_by='id_kecamatan',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->db->count_all('kecamatan');
		$url = 'masters/kecamatan/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->mmaster->getKecamatan($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('masters/kecamatan/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'kecamatan',
			'master'		=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page
		);
		$this->load->view('template',$data);
	}

	function tahun($short_by='id_ta',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->db->count_all('tahun_ajaran');
		$url = 'masters/tahun/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->mmaster->getTa($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('masters/tahun/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'tahun',
			'master'		=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page
		);
		$this->load->view('template',$data);
	}

	function fasilitas($short_by='id_fasilitas',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->db->count_all('fasilitas');
		$url = 'masters/fasilitas/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->mmaster->getFasilitas($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('masters/fasilitas/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'fasilitas',
			'master'		=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page
		);
		$this->load->view('template',$data);
	}

	function kuesioner($short_by='id_kuesioner',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->db->count_all('kuesioner');
		$url = 'masters/kuesioner/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->mmaster->getKuesioner($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('masters/kuesioner/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'kuesioner',
			'master'		=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page
		);
		$this->load->view('template',$data);
	}

	function umur($short_by='id_umur',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->db->count_all('umur');
		$url = 'masters/umur/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->mmaster->getUmur($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('masters/umur/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'umur',
			'master'		=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page
		);
		$this->load->view('template',$data);
	}

	function mapel($short_by='id_mapel',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->db->count_all('mapel');
		$url = 'masters/mapel/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->mmaster->getMapel($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('masters/mapel/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'mapel',
			'master'		=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page
		);
		$this->load->view('template',$data);
	}

	function prodi($short_by='id_prodi',$short_order='desc',$page=0)
	{
		$per_page = 20;
		$total_page = $this->db->count_all('prodi');
		$url = 'masters/prodi/'.$short_by.'/'.$short_order.'/';
		
		$query = $this->mmaster->getProdi($per_page,$page,$short_by,$short_order);
		if(count($query) == 0 && $page != 0)
		{
			redirect('masters/prodi/'.$short_by.'/'.$short_order.'/'.($page - $per_page));		
		}
				
		$data = array(
			'kueri' 		=> $query,
			'page'			=> $page,
			'paging' 		=> $this->page->getPagination($total_page,$per_page,$url,$uri=5),
			'main'			=> 'prodi',
			'master'		=> 'select',
			'sort_by' 		=> $short_by,
			'sort_order' 	=> $short_order,			
			'page'			=> $page
		);
		$this->load->view('template',$data);
	}

	function tambah_sekolah($id,$nama)
	{
		$data = array(	  		
			'main'			=> 'formSekolah',
			'ket'			=> 'Form Master Sekolah',
			'jenis'			=> 'Tambah',
			'sekolah'		=> 'select',
			'link'			=> 'simpan_sekolah/'.$id.'/'.$nama,
			'jenjang'		=> $this->arey->getJenjang(),
			'id'			=> $id,
			'nama'			=> $nama
		);
			
		$this->load->view('template',$data);
	}

	function tambah_propinsi()
	{
		$data = array(	  		
			'main'			=> 'formPropinsi',
			'ket'			=> 'Form Master Propinsi',
			'jenis'			=> 'Tambah',
			'master'		=> 'select',
			'link'			=> 'simpan_propinsi'
		);
			
		$this->load->view('template',$data);
	}

	function tambah_kabupaten()
	{
		$data = array(	  		
			'main'			=> 'formKabupaten',
			'ket'			=> 'Form Master Kabupaten',
			'jenis'			=> 'Tambah',
			'master'		=> 'select',
			'link'			=> 'simpan_kabupaten',
			'propinsi'		=> $this->mmaster->getSelekProp()
		);
			
		$this->load->view('template',$data);
	}

	function tambah_kecamatan()
	{
		$data = array(	  		
			'main'			=> 'formKecamatan',
			'ket'			=> 'Form Master Kecamatan',
			'jenis'			=> 'Tambah',
			'master'		=> 'select',
			'link'			=> 'simpan_kecamatan',
			'kabupaten'		=> $this->mmaster->getSelekKab()
		);
			
		$this->load->view('template',$data);
	}

	function tambah_tahun()
	{
		$data = array(	  		
			'main'			=> 'formTahun',
			'ket'			=> 'Form Master Tahun Ajaran',
			'jenis'			=> 'Tambah',
			'master'		=> 'select',
			'link'			=> 'simpan_tahun',
			'status'		=> $this->arey->getStatusTa()
		);
			
		$this->load->view('template',$data);
	}

	function tambah_fasilitas()
	{
		$data = array(	  		
			'main'			=> 'formFasilitas',
			'ket'			=> 'Form Master Fasilitas',
			'jenis'			=> 'Tambah',
			'master'		=> 'select',
			'link'			=> 'simpan_fasilitas',
			'jenjang'		=> $this->arey->getJenjang(),
			'jeniss'		=> $this->arey->getJenis(),
			'kategori'		=> $this->arey->getKategori(),
			'subs'			=> $this->arey->getSubsKategori()
		);
			
		$this->load->view('template',$data);
	}

	function tambah_kuesioner()
	{
		$data = array(	  		
			'main'			=> 'formKuesioner',
			'ket'			=> 'Form Master Kuesioner',
			'jenis'			=> 'Tambah',
			'master'		=> 'select',
			'link'			=> 'simpan_kuesioner',
			'jenjang'		=> $this->arey->getJenjang(),
			'jeniss'		=> $this->arey->getJenisKue(),
			'pembilang'		=> $this->arey->getPembilang()
		);
			
		$this->load->view('template',$data);
	}

	function tambah_umur()
	{
		$data = array(	  		
			'main'			=> 'formUmur',
			'ket'			=> 'Form Master Detail Umur Siswa',
			'jenis'			=> 'Tambah',
			'master'		=> 'select',
			'link'			=> 'simpan_umur',
			'jenjang'		=> $this->arey->getJenjang(),
			'tingkat'		=> $this->arey->getTingkatKelas(),
			'operasi'		=> $this->arey->getOperasi()
		);
			
		$this->load->view('template',$data);
	}

	function tambah_mapel()
	{
		$data = array(	  		
			'main'			=> 'formMapel',
			'ket'			=> 'Form Mata Pelajaran',
			'jenis'			=> 'Tambah',
			'master'		=> 'select',
			'link'			=> 'simpan_mapel',
			'jenjang'		=> $this->arey->getJenjang(),
			'mapel'			=> $this->arey->getJabatan("",1)
		);
			
		$this->load->view('template',$data);
	}

	function tambah_prodi()
	{
		$data = array(	  		
			'main'			=> 'formProdi',
			'ket'			=> 'Form Program Studi',
			'jenis'			=> 'Tambah',
			'master'		=> 'select',
			'link'			=> 'simpan_prodi',
			'jenjang'		=> $this->arey->getJenjang()
		);
			
		$this->load->view('template',$data);
	}

	function edit_sekolah($ids,$nama,$id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/sekolah/<?=$ids?>/<?=$nama?>');
		}

		$data = array(	  	
			'main'			=> 'formSekolah',
			'ket'			=> 'Form Master Sekolah',
			'jenis'			=> 'Edit',
			'master'		=> 'select',
			'link'			=> 'update_sekolah/'.$ids.'/'.$nama.'/'.$id,
			'kueri'			=> $this->mmaster->editSekolah($id),
			'jenjang'		=> $this->arey->getJenjang(),
			'nama'			=> $nama,
			'id'			=> $ids
		);
			
		$this->load->view('template',$data);
	}

	function edit_propinsi($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/propinsi');
		}

		$data = array(	  	
			'main'			=> 'formPropinsi',
			'ket'			=> 'Form Master Propinsi',
			'jenis'			=> 'Edit',
			'master'		=> 'select',
			'link'			=> 'update_propinsi/'.$id,
			'kueri'			=> $this->mmaster->editPropinsi($id)
		);
			
		$this->load->view('template',$data);
	}

	function edit_kabupaten($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/kabupaten');
		}

		$data = array(	  	
			'main'			=> 'formKabupaten',
			'ket'			=> 'Form Master Kabupaten',
			'jenis'			=> 'Edit',
			'master'		=> 'select',
			'link'			=> 'update_kabupaten/'.$id,
			'kueri'			=> $this->mmaster->editKabupaten($id),
			'propinsi'		=> $this->mmaster->getSelekProp()
		);
			
		$this->load->view('template',$data);
	}

	function edit_kecamatan($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/kecamatan');
		}

		$data = array(	  	
			'main'			=> 'formKecamatan',
			'ket'			=> 'Form Master Kecamatan',
			'jenis'			=> 'Edit',
			'master'		=> 'select',
			'link'			=> 'update_kecamatan/'.$id,
			'kueri'			=> $this->mmaster->editKecamatan($id),
			'kabupaten'		=> $this->mmaster->getSelekKab()
		);
			
		$this->load->view('template',$data);
	}

	function edit_tahun($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/tahun');
		}

		$data = array(	  	
			'main'			=> 'formTahun',
			'ket'			=> 'Form Master Tahun Ajaran',
			'jenis'			=> 'Edit',
			'master'		=> 'select',
			'link'			=> 'update_tahun/'.$id,
			'kueri'			=> $this->mmaster->editTahun($id),
			'status'		=> $this->arey->getStatusTa()
		);
			
		$this->load->view('template',$data);
	}

	function edit_fasilitas($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/fasilitas');
		}

		$data = array(	  	
			'main'			=> 'formFasilitas',
			'ket'			=> 'Form Master Fasilitas Sekolah',
			'jenis'			=> 'Edit',
			'master'		=> 'select',
			'link'			=> 'update_fasilitas/'.$id,
			'kueri'			=> $this->mmaster->editFasilitas($id),
			'jenjang'		=> $this->arey->getJenjang()
		);
			
		$this->load->view('template',$data);
	}

	function edit_kuesioner($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/kuesioner');
		}

		$data = array(	  	
			'main'			=> 'formKuesioner',
			'ket'			=> 'Form Master Kuesioner',
			'jenis'			=> 'Edit',
			'master'		=> 'select',
			'link'			=> 'update_kuesioner/'.$id,
			'kueri'			=> $this->mmaster->editKuesioner($id),
			'jenjang'		=> $this->arey->getJenjang()
		);
			
		$this->load->view('template',$data);
	}

	function edit_umur($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/umur');
		}

		$data = array(	  	
			'main'			=> 'formUmur',
			'ket'			=> 'Form Master Batas Umur Siswa',
			'jenis'			=> 'Edit',
			'master'		=> 'select',
			'link'			=> 'update_umur/'.$id,
			'kueri'			=> $this->mmaster->editUmur($id),
			'jenjang'		=> $this->arey->getJenjang(),
			'operasi'		=> $this->arey->getOperasi(),
			'tingkat'		=> $this->arey->getTingkatKelas()
		);
			
		$this->load->view('template',$data);
	}	

	function edit_mapel($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/mapel');
		}

		$data = array(	  	
			'main'			=> 'formMapel',
			'ket'			=> 'Form Master Mata Pelajaran',
			'jenis'			=> 'Edit',
			'master'		=> 'select',
			'link'			=> 'update_mapel/'.$id,
			'kueri'			=> $this->mmaster->editMapel($id),
			'jenjang'		=> $this->arey->getJenjang(),
			'mapel'			=> $this->arey->getJabatan("",1)
		);
			
		$this->load->view('template',$data);
	}

	function edit_prodi($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/prodi');
		}

		$data = array(	  	
			'main'			=> 'formProdi',
			'ket'			=> 'Form Master Program Studi',
			'jenis'			=> 'Edit',
			'master'		=> 'select',
			'link'			=> 'update_prodi/'.$id,
			'kueri'			=> $this->mmaster->editProdi($id),
			'jenjang'		=> $this->arey->getJenjang()
		);
			
		$this->load->view('template',$data);
	}

	function simpan_sekolah($id,$nama)
	{
		$this->mmaster->addSekolah();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Sekolah berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Sekolah gagal dibuat');
		}

		redirect('masters/sekolah/'.$id.'/'.$nama);
	}

	function simpan_propinsi()
	{
		$this->mmaster->addPropinsi();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Propinsi berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Propinsi gagal dibuat');
		}

		redirect('masters/propinsi');
	}

	function simpan_kabupaten()
	{
		$this->mmaster->addKabupaten();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Kabupaten berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Kabupaten gagal dibuat');
		}

		redirect('masters/kabupaten');
	}

	function simpan_kecamatan()
	{
		$this->mmaster->addKecamatan();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Kecamatan berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Kecamatan gagal dibuat');
		}

		redirect('masters/kecamatan');
	}

	function simpan_tahun()
	{
		$this->mmaster->addTahun();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Tahun ajaran berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Tahun ajaran gagal dibuat');
		}

		redirect('masters/tahun');
	}

	function simpan_fasilitas()
	{
		$this->mmaster->addFasilitas();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Fasilitas Sekolah berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Fasilitas sekolah gagal dibuat');
		}

		redirect('masters/fasilitas');
	}

	function simpan_kuesioner()
	{
		$this->mmaster->addKuesioner();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Kuesioner berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Kuesioner gagal dibuat');
		}

		redirect('masters/kuesioner');
	}

	function simpan_umur()
	{
		$this->mmaster->addUmur();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Batas umur berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Batas umur gagal dibuat');
		}

		redirect('masters/umur');
	}

	function simpan_mapel()
	{
		$this->mmaster->addMapel();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Mata pelajaran berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Mata pelajaran gagal dibuat');
		}

		redirect('masters/mapel');
	}

	function simpan_prodi()
	{
		$this->mmaster->addProdi();

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Program studi berhasil dibuat');
		}
		else
		{
			$this->message->set('notice','Program studi gagal dibuat');
		}

		redirect('masters/prodi');
	}

	function update_sekolah($ids,$nama,$id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/sekolah/'.$ids.'/'.$nama);
		}

		$this->mmaster->updateSekolah($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data sekolah berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Data sekolah gagal diupdate');
		}
		redirect('masters/sekolah/'.$ids.'/'.$nama);
	}

	function update_propinsi($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/propinsi');
		}

		$this->mmaster->updatePropinsi($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data propinsi berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Data propinsi gagal diupdate');
		}
		redirect('masters/propinsi');
	}

	function update_kabupaten($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/kabupaten');
		}

		$this->mmaster->updateKabupaten($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data kabupaten berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Data kabupaten gagal diupdate');
		}
		redirect('masters/kabupaten');
	}

	function update_kecamatan($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/kecamatan');
		}

		$this->mmaster->updateKecamatan($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data kecamatan berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Data kecamatan gagal diupdate');
		}
		redirect('masters/kecamatan');
	}

	function update_tahun($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/tahun');
		}

		$this->mmaster->updateTahun($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data tahun ajaran berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Data tahun ajaran gagal diupdate');
		}
		redirect('masters/tahun');
	}

	function update_fasilitas($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/fasilitas');
		}

		$this->mmaster->updateFasilitas($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Fasilitas sekolah berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Fasilitas sekolah gagal diupdate');
		}
		redirect('masters/fasilitas');
	}

	function update_kuesioner($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/kuesioner');
		}

		$this->mmaster->updateKuesioner($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Kuesioner berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Kuesioner gagal diupdate');
		}
		redirect('masters/kuesioner');
	}

	function update_umur($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/umur');
		}

		$this->mmaster->updateUmur($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Batas umur siswa berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Batas umur siswa gagal diupdate');
		}
		redirect('masters/umur');
	}

	function update_mapel($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/mapel');
		}

		$this->mmaster->updateMapel($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Mata pelajaran berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Mata pelajaran gagal diupdate');
		}
		redirect('masters/mapel');
	}

	function update_prodi($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/prodi');
		}

		$this->mmaster->updateProdi($id);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Program studi berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Program studi gagal diupdate');
		}
		redirect('masters/prodi');
	}

	function hapus_sekolah($ids,$nama,$id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/sekolah/'.$ids.'/'.$nama);
		}

		if($this->mmaster->deleteSchool($id))
		{
			$this->message->set('succes','Data sekolah berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Data sekolah gagal dihapus');
		}
		redirect('masters/sekolah/'.$ids.'/'.$nama);
	}

	function hapus_propinsi($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/propinsi');
		}

		if($this->mmaster->deletePropinsi($id))
		{
			$this->message->set('succes','Data propinsi berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Data propinsi gagal dihapus');
		}
		redirect('masters/propinsi');
	}

	function hapus_kabupaten($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/kabupaten');
		}

		if($this->mmaster->deleteKabupaten($id))
		{
			$this->message->set('succes','Data kabupaten berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Data kabupaten gagal dihapus');
		}
		redirect('masters/kabupaten');
	}

	function hapus_kecamatan($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/kecamatan');
		}

		if($this->mmaster->deleteKecamatan($id))
		{
			$this->message->set('succes','Data kecamatan berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Data kecamatan gagal dihapus');
		}
		redirect('masters/kecamatan');
	}

	function hapus_tahun($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/tahun');
		}

		if($this->mmaster->deleteTahun($id))
		{
			$this->message->set('succes','Data tahun ajaran berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Data tahun ajaran gagal dihapus');
		}
		redirect('masters/tahun');
	}

	function hapus_fasilitas($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/fasilitas');
		}

		if($this->mmaster->deleteFasilitas($id))
		{
			$this->message->set('succes','Data fasilitas sekolah berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Data fasilitas sekolah gagal dihapus');
		}
		redirect('masters/fasilitas');
	}

	function hapus_kuesioner($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/kuesioner');
		}

		if($this->mmaster->deleteKuesioner($id))
		{
			$this->message->set('succes','Data kuesioner berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Data kuesioner gagal dihapus');
		}
		redirect('masters/kuesioner');
	}

	function hapus_umur($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/umur');
		}

		if($this->mmaster->deleteUmur($id))
		{
			$this->message->set('succes','Data batas umur siswa berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Data batas umur siswa gagal dihapus');
		}
		redirect('masters/umur');
	}

	function hapus_mapel($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/mapel');
		}

		if($this->mmaster->deleteMapel($id))
		{
			$this->message->set('succes','Mata pelajaran berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Mata pelajaran gagal dihapus');
		}
		redirect('masters/mapel');
	}

	function hapus_prodi($id)
	{
		if($id == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/prodi');
		}

		if($this->mmaster->deleteProdi($id))
		{
			$this->message->set('succes','Program studi berhasil dihapus');
		}
		else
		{
			$this->message->set('notice','Program studi gagal dihapus');
		}
		redirect('masters/prodi');
	}

	function all_sekolah($id,$nama)
	{
		$cek = $this->input->post('check');
		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data sekolah yang dipilih');
			redirect('masters/sekolah');
		}
		foreach($cek as $dt_cek)
		{
			$this->mmaster->deleteSchool($dt_cek);
		}
		$this->message->set('succes','Data sekolah berhasil dihapus');
		redirect('masters/sekolah/'.$id.'/'.$nama);
	}

	function all_propinsi()
	{
		$cek = $this->input->post('check');
		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data propinsi yang dipilih');
			redirect('masters/propinsi');
		}
		foreach($cek as $dt_cek)
		{
			$this->mmaster->deletePropinsi($dt_cek);
		}
		$this->message->set('succes','Data propinsi berhasil dihapus');
		redirect('masters/propinsi');
	}

	function all_kabupaten()
	{
		$cek = $this->input->post('check');
		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data kabupaten yang dipilih');
			redirect('masters/kabupaten');
		}
		foreach($cek as $dt_cek)
		{
			$this->mmaster->deleteKabupaten($dt_cek);
		}
		$this->message->set('succes','Data kabupaten berhasil dihapus');
		redirect('masters/kabupaten');
	}

	function all_kecamatan()
	{
		$cek = $this->input->post('check');
		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data kecamatan yang dipilih');
			redirect('masters/kecamatan');
		}
		foreach($cek as $dt_cek)
		{
			$this->mmaster->deleteKecamatan($dt_cek);
		}
		$this->message->set('succes','Data kecamatan berhasil dihapus');
		redirect('masters/kecamatan');
	}

	function all_tahun()
	{
		$cek = $this->input->post('check');
		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data tahun ajaran yang dipilih');
			redirect('masters/tahun');
		}
		foreach($cek as $dt_cek)
		{
			$this->mmaster->deleteTahun($dt_cek);
		}
		$this->message->set('succes','Data tahun ajaran berhasil dihapus');
		redirect('masters/tahun');
	}

	function all_fasilitas()
	{
		$cek = $this->input->post('check');
		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data fasilitas yang dipilih');
			redirect('masters/fasilitas');
		}
		foreach($cek as $dt_cek)
		{
			$this->mmaster->deleteFasilitas($dt_cek);
		}
		$this->message->set('succes','Data fasilitas sekolah berhasil dihapus');
		redirect('masters/fasilitas');
	}

	function all_kuesioner()
	{
		$cek = $this->input->post('check');
		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data kuesioner yang dipilih');
			redirect('masters/kuesioner');
		}
		foreach($cek as $dt_cek)
		{
			$this->mmaster->deleteKuesioner($dt_cek);
		}
		$this->message->set('succes','Data kuesioner berhasil dihapus');
		redirect('masters/kuesioner');
	}

	function all_umur()
	{
		$cek = $this->input->post('check');
		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data batas umur siswa yang dipilih');
			redirect('masters/umur');
		}
		foreach($cek as $dt_cek)
		{
			$this->mmaster->deleteUmur($dt_cek);
		}
		$this->message->set('succes','Data batas umur siswa berhasil dihapus');
		redirect('masters/umur');
	}

	function all_mapel()
	{
		$cek = $this->input->post('check');
		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data mata pelajaran siswa yang dipilih');
			redirect('masters/mapel');
		}
		foreach($cek as $dt_cek)
		{
			$this->mmaster->deleteMapel($dt_cek);
		}
		$this->message->set('succes','Data mata pelajaran berhasil dihapus');
		redirect('masters/mapel');
	}

	function all_prodi()
	{
		$cek = $this->input->post('check');
		if(!is_array($cek))
		{
			$this->message->set('notice','Tidak ada data program studi siswa yang dipilih');
			redirect('masters/prodi');
		}
		foreach($cek as $dt_cek)
		{
			$this->mmaster->deleteProdi($dt_cek);
		}
		$this->message->set('succes','Data program studi berhasil dihapus');
		redirect('masters/prodi');
	}

	function set_tahun($id,$val)
	{
		if($id == "" OR $val == "")
		{
			$this->message->set('notice','Maaf parameter salah');
			redirect('masters/tahun');
		}

		$this->mmaster->setTahun($id,$val);

		if($this->db->affected_rows() > 0)
		{
			$this->message->set('succes','Data tahun ajaran berhasil diupdate');
		}
		else
		{
			$this->message->set('notice','Data tahun ajaran gagal diupdate');
		}
		redirect('masters/tahun');
	}
}