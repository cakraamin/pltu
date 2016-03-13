<?php



class Mlaporan extends CI_Model

{

	function __construct()

	{

		parent::__construct();

	}	



	function getTahun()

	{

		$query = $this->db->query("SELECT * FROM tahun_ajaran ORDER BY id_ta ASC");



		if ($query->num_rows()> 0)

		{

			foreach ($query->result_array() as $row)

			{

				$tahun = substr($row['nama_ta'], 0,4);



				$data[$row['id_ta']] = $tahun;

			}

		}

		else

		{

			$data[''] = "";

		}

		$query->free_result();

		return $data;

	}



	function setTahun($id)

	{

		$query = $this->db->query("SELECT * FROM tahun_ajaran WHERE id_ta='$id'");

		$hasil = $query->row();

		$nilai = ($hasil->nama_ta)?$hasil->nama_ta:0;

		return $nilai;

	}



	function getHeaderLap($id)

	{

		$kueri = $this->db->query("SELECT * FROM kuesioner WHERE jenis_kuesioner='$id' ORDER BY id_kuesioner ASC");

		return $kueri->result();

	}



	function getJenjang($id)

	{

		$kueri = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.stat_ket_kuesioner='1' AND b.id_kuesioner='$id'");

		return $kueri->result();

	}



	function getSubQuest($id)

	{

		$data = array();



		$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' ORDER BY id_ket_kuesioner DESC");

		$hasil = $kueri->result();

		foreach($hasil as $dt_hasil)

		{

			$data[] = $dt_hasil->text_ket_kuesioner;

		}



		return $data;

	}



	function getPembilang($id)

	{

		$data = array();



		$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' AND stat_ket_kuesioner='1' ORDER BY id_ket_kuesioner DESC");

		$hasil = $kueri->result();

		foreach($hasil as $dt_hasil)

		{

			$data[] = $dt_hasil->text_ket_kuesioner;

		}



		return $data;

	}



	function getPenyebut($id)

	{

		$data = array();



		$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' AND stat_ket_kuesioner='2' ORDER BY id_ket_kuesioner DESC");

		$hasil = $kueri->result();

		foreach($hasil as $dt_hasil)

		{

			$data[] = $dt_hasil->text_ket_kuesioner;

		}



		return $data;

	}



	function getDetailLaporan($id)

	{

		$sql = "tahun $id";

		return 12;

	}



	function getJawaban($id)

	{

		$kueri = $this->db->query("SELECT * FROM kuesioner WHERE id_kuesioner='$id'");

		$data = $kueri->row();

		return $data->jawaban;

	}



	function getManual($id)

	{

		$kueri = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' AND level_ket_kuesioner='2' ORDER BY id_ket_kuesioner DESC LIMIT 0,1");

		$data = $kueri->row();

		return $data->ket_ket_kuesioner;

	}



	function getTotal($id)

	{

		$kueri = $this->db->query("SELECT * FROM schools WHERE jenjang_school='$id'");

		return $kueri->num_rows();

	}



	function getTotalPem($id,$ta,$ids)

	{

		$kueri = $this->db->query("SELECT * FROM kuesioner_school WHERE id_detail_kuesioner='$id' AND id_ta='$ta' AND ket_kuesioner_school='1'");

		return $kueri->num_rows();

	}



	function getManualTotal($id,$ta,$ids)

	{

		$kueri = $this->db->query("SELECT SUM(ket_kuesioner_school) as jumlah FROM kuesioner_school WHERE id_detail_kuesioner='$id' AND id_ta='$ta'");		

		$data = $kueri->row();

		return $data->jumlah;		

	}



	function getSoal($id)

	{

		$data = array();		

		$sub = array();				



		$kueri = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1' ORDER BY b.jenjang_school ASC");

		$hasil = $kueri->result();

		$no = 1;

		$i = 0;

		foreach($hasil as $dt_hasil)

		{

			unset($subs);

			$subs = array();



			if($i > 0)

			{	

				$idks = $i - 1;



				if(array_search($dt_hasil->jenjang_school, $data[$idks]['0']) == 2)		

				{					

					$tambah = array(

						'1'		=> $dt_hasil->id_detail_kuesioner,

						'2'		=> $dt_hasil->jenjang_school,

						'3'		=> $dt_hasil->id_kuesioner

					);

					array_push($data[$idks], $tambah);

				}

				else

				{

					$subs[] = array(

						'1'		=> $dt_hasil->id_detail_kuesioner,

						'2'		=> $dt_hasil->jenjang_school,

						'3'		=> $dt_hasil->id_kuesioner

					);

					$data[$i] = $subs;				

					$i++;		

				}

			}

			else

			{

				$subs[] = array(

					'1'		=> $dt_hasil->id_detail_kuesioner,

					'2'		=> $dt_hasil->jenjang_school,

					'3'		=> $dt_hasil->id_kuesioner

				);

				$data[$i] = $subs;				

				$i++;

			}

			$no++;						

		}					



		return $data;

	}



	function getTaAktif()

	{

		$kueri = $this->db->query("SELECT * FROM tahun_ajaran WHERE status_ta='1'");

		if($kueri->num_rows() > 0)

		{

			$hasil = $kueri->row();



			$data = array(

				'tahun'		=> $hasil->id_ta

			);

		}

		else

		{

			$data = array(

				'tahun'		=> '0'

			);

		}



		return $data;

	}



	function getTotalSoal($id)

	{

		$kueri = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1'");

		return $kueri->num_rows();

	}



	function getTotalSoalJenjang($id)

	{

		$kueri = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1'");

		return $kueri->num_rows();	

	}



	function getTotalSoals($id)

	{

		$kueri = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1'");

		$hasil = $kueri->num_rows();		

		return $hasil*2;

	}



	function getAllTotalSoal($id)

	{

		$data = array();



		$pembilang = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1' GROUP BY a.id_ket_kuesioner");

		$hpembilang = $pembilang->result();		

		$penyebut = $this->db->query("SELECT * FROM ket_kuesioner WHERE id_kuesioner='$id' AND stat_ket_kuesioner='2'");

		$hpenyebut = $penyebut->row();		

		$i = 0;

		foreach($hpembilang as $dt_hpembilang)

		{

			$data[] = "PEMBILANG : ".$dt_hpembilang->text_ket_kuesioner;

			$i++;

			$data[] = "PENYEBUT : ".$hpenyebut->text_ket_kuesioner;

			$i++;

		}



		return $data;

	}



	function getAllTotalSoalProf($id)

	{

		$data = array();



		$pembilang = $this->db->query("SELECT * FROM ket_kuesioner a,detail_kuesioner b WHERE a.id_ket_kuesioner=b.id_ket_kuesioner AND a.id_kuesioner='$id' AND a.stat_ket_kuesioner='1' GROUP BY a.id_ket_kuesioner");

		$hpembilang = $pembilang->result();				

		$i = 0;

		foreach($hpembilang as $dt_hpembilang)

		{

			$data[] = $dt_hpembilang->text_ket_kuesioner;

			$i++;			

		}



		return $data;

	}



	function getTingkat($id)

	{

		$kueri = $this->db->query("SELECT * FROM schools WHERE id_school='$id'");

		$hasil = $kueri->row();

		$data = $hasil->jenjang_school;

		$jenjang = (isset($data))?$data:"";

		return $jenjang;

	}



	function getJumMurid($id,$ids,$tahun)

	{

		$data = array();



		$kueri = $this->db->query("SELECT * FROM siswa WHERE id_school='$id' AND id_tingkat='$ids' AND id_ta='$tahun' ORDER BY id_siswa DESC LIMIT 0,1");		

		if($kueri->num_rows() > 0)

		{

			$hasil = $kueri->row();



			$data = array(

				'laki'		=> $hasil->laki_siswa,

				'perempuan'	=> $hasil->perempuan_siswa

			);

		}

		else

		{

			$data = array(

				'laki'		=> 0,

				'perempuan'	=> 0

			);	

		}



		return $data;

	}



	function getJumMuridAll($id,$ids,$tahun)

	{

		$data = array();

		$laki = 0;

		$peremp = 0;



		$sql = "SELECT a.laki_siswa,a.perempuan_siswa FROM siswa a,schools b WHERE a.id_tingkat='$ids' AND a.id_ta='$tahun' AND b.jenjang_school='$id' GROUP BY b.id_school ORDER BY a.id_siswa DESC";				



		$kueri = $this->db->query($sql);		

		$nilai = $kueri->result();



		foreach($nilai as $dt_nilai)

		{

			$laki = $laki + intval($dt_nilai->laki_siswa);

			$peremp = $peremp + intval($dt_nilai->perempuan_siswa);

		}



		$data = array(

			'laki'		=> $laki,

			'perempuan'	=> $peremp

		);		

		

		return $data;

	} 



	function getDetailMurid($id,$ids,$tahun)

	{

		$data = "";



		$sql = "SELECT * FROM siswa a,detail_siswa b,detail_umur c,umur d WHERE a.id_school='$id' AND a.id_tingkat='$ids' AND a.id_ta='$tahun' AND a.id_siswa=b.id_siswa AND b.id_detail_umur=c.id_detail_umur AND c.id_umur=d.id_umur GROUP BY b.id_detail_umur ORDER BY b.id_detail_umur DESC";				

		$kueri = $this->db->query($sql);

		if($kueri->num_rows() > 0)

		{

			$hasil = $kueri->result();

			foreach($hasil as $dt_hasil)

			{

				if($dt_hasil->operasi_umur == 1)

				{

					$batas = "Kurang dari ".$dt_hasil->batas_awal." Tahun";

				}

				elseif($dt_hasil->operasi_umur == 2)

				{

					$batas = "Antara ".$dt_hasil->batas_awal." Tahun sampai ".$dt_hasil->batas_akhir." Tahun";

				}

				elseif($dt_hasil->operasi_umur == 3)

				{

					$batas = "Lebih dari dari ".$dt_hasil->batas_akhir." Tahun";

				}

				else

				{

					$batas = "Sama dengan ".$dt_hasil->batas_awal." Tahun";

				}

				

				$data .= $batas." = ".$dt_hasil->value_detail_siswa."; ";

			}			

		}

		else

		{

			$data = "Tidak ada detail umur";

		}



		return $data;

	}



	function getDetailMuridAll($id,$ids,$tahun)

	{

		$data = "";



		$sql = "SELECT * FROM umur a,detail_umur b,detail_siswa c,siswa d WHERE a.id_umur=b.id_umur AND b.id_detail_umur=c.id_detail_umur AND c.id_siswa=d.id_siswa AND b.jenjang_school='$id' AND a.id_tingkat='$ids' AND d.id_ta='$tahun' GROUP BY b.id_detail_umur";		

		$kueri = $this->db->query($sql);

		if($kueri->num_rows() > 0)

		{

			$hasil = $kueri->result();

			foreach($hasil as $dt_hasil)

			{

				if($dt_hasil->operasi_umur == 1)

				{

					$batas = "Kurang dari ".$dt_hasil->batas_awal." Tahun";

				}

				elseif($dt_hasil->operasi_umur == 2)

				{

					$batas = "Antara ".$dt_hasil->batas_awal." Tahun sampai ".$dt_hasil->batas_akhir." Tahun";

				}

				elseif($dt_hasil->operasi_umur == 3)

				{

					$batas = "Lebih dari dari ".$dt_hasil->batas_akhir." Tahun";

				}

				else

				{

					$batas = "Sama dengan ".$dt_hasil->batas_awal." Tahun";

				}

				

				$data .= $batas." = ".$dt_hasil->value_detail_siswa."; ";

			}			

		}

		else

		{

			$data = "Tidak ada detail umur";

		}



		return $data;

	}



	function getProdi($id)

	{

		$kueri = $this->db->query("SELECT * FROM prodi a,detail_prodi b,prodi_school c WHERE a.id_prodi=b.id_prodi AND b.id_detail_prodi=c.id_detail_prodi AND c.id_school='$id' GROUP BY a.id_prodi");

		return $kueri->result();

	}



	function getProdiAll($id)

	{

		$kueri = $this->db->query("SELECT * FROM prodi a,detail_prodi b WHERE a.id_prodi=b.id_prodi AND b.jenjang_school='$id'");

		return $kueri->result();

	}



	function getDetailJur($id,$ids,$tingkat,$tahun)

	{

		$sql = "SELECT * FROM prodi a,detail_prodi b,prodi_school c WHERE a.id_prodi=b.id_prodi AND b.id_detail_prodi=c.id_detail_prodi AND a.id_prodi='$id' AND c.id_school='$ids' AND c.id_tingkat='$tingkat' AND c.id_ta='$tahun' ORDER BY c.id_prodi_school DESC LIMIT 0,1";		

		$kueri = $this->db->query($sql);

		$hasil = $kueri->row();

		$data = (isset($hasil->peserta))?$hasil->peserta:"";

		return $data;

	}



	function getDetailJurAll($id,$ids,$tingkat,$tahun)

	{

		$sql = "SELECT * FROM prodi a,detail_prodi b,prodi_school c WHERE a.id_prodi=b.id_prodi AND b.id_detail_prodi=c.id_detail_prodi AND a.id_prodi='$id' AND b.jenjang_school='$ids' AND c.id_tingkat='$tingkat' AND c.id_ta='$tahun' ORDER BY c.id_prodi_school DESC LIMIT 0,1";						

		$kueri = $this->db->query($sql);

		$hasil = $kueri->row();

		$data = (isset($hasil->peserta))?$hasil->peserta:"0";

		return $data;

	}



	function getMapel($id)

	{

		$kueri = $this->db->query("SELECT * FROM guru WHERE id_school='$id' GROUP BY id_jabatan");		

		return $kueri->result();

	}



	function getMapelAll($id)

	{

		$kueri = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_school=b.id_school AND b.jenjang_school='$id' GROUP BY a.id_jabatan");		

		return $kueri->result();

	}



	function getJumMapelAll($ids,$jenis,$id)

	{

		$kueri = $this->db->query("SELECT * FROM guru a,schools b WHERE a.id_jabatan='$ids' AND a.jenis_kel='$jenis' AND b.jenjang_school='$id'");

		return $kueri->num_rows();

	}



	function getJumMapel($ids,$id,$jenis)

	{

		$kueri = $this->db->query("SELECT * FROM guru WHERE id_school='$id' AND id_jabatan='$ids' AND jenis_kel='$jenis'");

		return $kueri->num_rows();

	}



	function getDetailSchool($id)

	{

		$kueri = $this->db->query("SELECT * FROM schools a,detail_schools b WHERE a.id_school=b.id_school AND a.id_school='$id' ORDER BY b.id_detail_school LIMIT 0,5");

		return $kueri->result();

	}	



	function getLapJumNonProdi($tahun,$id)

	{

		$kueri = $this->db->query("SELECT * FROM prodi_school WHERE id_ta='$tahun' AND id_school='$id' AND id_tingkat='6' ORDER BY id_prodi_school DESC LIMIT 0,1");

		return $kueri->row();

	}



	function getMapelUN($id)

	{

		$kueri = $this->db->query("SELECT * FROM mapel a,detail_mapel b WHERE a.id_mapel=b.id_mapel AND b.jenjang_school='$id'");

		return $kueri->result();

	}



	function getNilaiMapel($ids,$id,$ta)

	{

		$kueri = $this->db->query("SELECT * FROM mapel_school WHERE id_detail_mapel='$ids' AND id_school='$id' AND id_ta='$ta'");

		$hasil = $kueri->row();

		$data = (isset($hasil->nilai_mapel))?$hasil->nilai_mapel:"";

		return $data;

	}



	function getTanah($id,$ta)

	{

		$kueri = $this->db->query("SELECT * FROM tanah WHERE id_ta='$ta' AND id_school='$id'");

		return $kueri->row();



	}



	function getDetailSekali($id)

	{

		$nilai = array();



		$kueri = $this->db->query('SELECT * FROM kecamatan a,kabupaten b,propinsi c WHERE a.id_kabupaten=b.id_kabupaten AND b.id_propinsi=c.id_propinsi AND a.id_kecamatan="$id"');

		$data = $kueri->row();



		$kecamatan = isset($data->nama_kecamatan)?$data->nama_kecamatan:"";

		$kabupaten = isset($data->nama_kabupaten )?$data->nama_kabupaten :"";

		$propinsi = isset($data->nama_propinsi )?$data->nama_propinsi :"";



		$nilai = array(

			'kecamatan'		=> $kecamatan,

			'kabupaten'		=> $kabupaten,

			'propinsi'		=> $propinsi

		);



		return $nilai;

	}



	function getKepsek($id)

	{

		$kueri = $this->db->query("SELECT * FROM guru WHERE id_guru='$id'");

		$hasil = $kueri->row();

		$data = isset($hasil->nama_guru)?$hasil->nama_guru:"";

		return $data;

	}



	function getPenggunaan($tingkat)

	{

		$sql = "SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND a.jenis_fasilitas='1' AND b.jenjang_school='$tingkat'";

		$kueri = $this->db->query($sql);

		return $kueri->result();

	}



	function getDetailBangunan($ids,$tahun,$id,$tingkat)

	{

		$kueri = $this->db->query("SELECT * FROM fasilitas_school WHERE id_ta='$tahun' AND id_school='$id' AND id_detail_fasilitas='$ids' AND tingkat='$tingkat' ORDER BY id_fasilitas_school DESC LIMIT 0,1");

		$hasil = $kueri->row();

		$data = isset($hasil->jumlah_fasilitas)?$hasil->jumlah_fasilitas:0;

		return $data;

	}



	function getBuku($tingkat)

	{

		$sql = "SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND a.jenis_fasilitas='2' AND b.jenjang_school='$tingkat'";

		$kueri = $this->db->query($sql);

		return $kueri->result();

	}



	function getRuang($tingkat)

	{

		$sql = "SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND a.jenis_fasilitas='4' AND b.jenjang_school='$tingkat'";

		$kueri = $this->db->query($sql);

		return $kueri->result();	

	}



	function getAdministrasi($tingkat)

	{

		$sql = "SELECT * FROM fasilitas a,detail_fasilitas b WHERE a.id_fasilitas=b.id_fasilitas AND a.jenis_fasilitas='3' AND b.jenjang_school='$tingkat'";

		$kueri = $this->db->query($sql);

		return $kueri->result();		

	}

	function getBarang($tgl1=0,$tgl2=0,$id)
	{
		$data = array();
		$nilai = array();

		if($id == 1)
		{
			$tamb = " AND a.tgltb1='$tgl1'";
		}
		elseif($id == 2)
		{
			$tamb = " AND a.tgltb1 BETWEEN '$tgl1' AND '$tgl2'";
		}
		else
		{			
			$tamb = " AND (YEAR(a.tgltb1)='".$tgl1."' OR YEAR(a.tgltb1)='".$tgl2."')";
		}

		$sql = "SELECT * FROM datscale a,tabbrg b WHERE a.kodebrg=b.kodebrg AND (b.namabrg LIKE '%1#2' OR b.namabrg LIKE '%3#4') $tamb GROUP BY a.kodebrg ORDER BY b.namabrg ASC";
		$kueri = $this->db->query($sql);
		$hasil = $kueri->result();		
		foreach($hasil as $dt_hasil)
		{			
			$pecah = explode(",", $dt_hasil->namabrg);
			$jumlah = strlen($dt_hasil->namabrg);
			$unit = substr($dt_hasil->namabrg, $jumlah-3,3);
			if (!array_key_exists($dt_hasil->namabrg, $data)) 
			{
				$nilai[$unit] = $dt_hasil->kodebrg;

				$data[$pecah[0]] = $nilai;
			}
			else
			{
				$nilai[$unit] = $dt_hasil->kodebrg;

				array_merge($nilai,$data[$pecah[0]]);
			}
		}
		return $data;
	}

	function getHarian($kode,$tanggal)
	{
		$sql = "SELECT * FROM datscale a,tabcust b WHERE a.kodecust=b.kodecust AND a.kodebrg='$kode' AND a.tgltb1='$tanggal'";
		$kueri = $this->db->query($sql);
		return $kueri->result();
	}

	function getBulanan($id,$tgl1=0,$tgl2=0,$kode,$jenis)
	{
		$jumlah = 0;

		$tamb = ($kode == 1)?"WHERE tgltb1 BETWEEN '$tgl1' AND '$tgl2'":"WHERE tgltb1='$tgl1'";
		$jenis = ($jenis == 1)?" AND nomorspk=''":" AND nomorspk<>''";

		if(is_array($id))
		{
			foreach($id as $dt_id)
			{
				$sql = "SELECT * FROM datscale $tamb $jenis AND kodebrg='$dt_id'";
				$kueri = $this->db->query($sql);
				$hasil = $kueri->result();
				foreach($hasil as $dt_kueri)
				{
					$jumlah = $jumlah + $dt_kueri->netto;
				}
			}
		}
		else
		{
			$sql = "SELECT * FROM datscale $tamb $jenis AND kodebrg='$id'";
			$kueri = $this->db->query($sql);
			$hasil = $kueri->result();
			foreach($hasil as $dt_kueri)
			{
				$jumlah = $jumlah + $dt_kueri->netto;
			}
		}		

		return $this->konversi($jumlah);
	}

	function getTahunan($id,$thn=0,$bln=0,$kode,$jenis)
	{
		$jumlah = 0;

		$tamb = ($kode == 1)?"WHERE YEAR(tgltb1)='$thn'":"WHERE YEAR(tgltb1)='$thn' AND MONTH(tgltb1)='$bln'";
		$jenis = ($jenis == 1)?" AND nomorspk=''":" AND nomorspk<>''";

		if(is_array($id))
		{
			foreach($id as $dt_id)
			{
				$sql = "SELECT * FROM datscale $tamb $jenis AND kodebrg='$dt_id'";
				$kueri = $this->db->query($sql);
				$hasil = $kueri->result();
				foreach($hasil as $dt_kueri)
				{
					$jumlah = $jumlah + $dt_kueri->netto;
				}
			}
		}
		else
		{
			$sql = "SELECT * FROM datscale $tamb $jenis AND kodebrg='$id'";
			$kueri = $this->db->query($sql);
			$hasil = $kueri->result();
			foreach($hasil as $dt_kueri)
			{
				$jumlah = $jumlah + $dt_kueri->netto;
			}
		}		

		return $this->konversi($jumlah);
	}	

	function getBulan($bln,$thn,$id,$jenis)
	{
		$jumlah = 0;
		$jenis = ($jenis == 1)?" AND nomorspk=''":" AND nomorspk<>''";

		if(is_array($id))
		{
			foreach($id as $dt_id)
			{
				$sql = "SELECT * FROM datscale WHERE MONTH(tgltb1)='$bln' AND YEAR(tgltb1)='$thn' AND kodebrg='$dt_id' $jenis";
				$kueri = $this->db->query($sql);
				$hasil = $kueri->result();
				foreach($hasil as $dt_kueri)
				{
					$jumlah = $jumlah + $dt_kueri->netto;
				}
			}
		}
		else
		{
			$sql = "SELECT * FROM datscale WHERE MONTH(tgltb1)='$bln' AND YEAR(tgltb1)='$thn' AND kodebrg='$id' $jenis";
			$kueri = $this->db->query($sql);
			$hasil = $kueri->result();
			foreach($hasil as $dt_kueri)
			{
				$jumlah = $jumlah + $dt_kueri->netto;
			}
		}		

		return $this->konversi($jumlah);
	}

	function getDetailHarian($tgl,$a,$jenis)
	{
		$nilai = "";
		$jumlah = 0;

		if(is_array($a))
		{
			foreach($a as $data)
			{
				$jenis = ($jenis == 'LAGOON')?" AND nomorspk='' ":" AND nomorspk<>'' ";

				$sql = "SELECT netto FROM datscale WHERE tgltb1='$tgl' AND kodebrg='$data' $jenis";
				$kueri = $this->db->query($sql);
				$hasil = $kueri->result();
				foreach($hasil as $dt_hasil)
				{
					$jumlah = $jumlah+$dt_hasil->netto;
				}				
			}
		}

		return $this->konversi($jumlah);
	}

	function getCustom($tgl,$a,$jenis)
	{
		$nilai = "";
		$jumlah = 0;

		if(is_array($a))
		{
			foreach($a as $data)
			{
				$jenis = ($jenis == 'LAGOON')?" AND nomorspk='' ":" AND nomorspk<>'' ";

				$sql = "SELECT netto FROM datscale WHERE tgltrans='$tgl' AND kodebrg='$data' $jenis";
				$kueri = $this->db->query($sql);
				$hasil = $kueri->result();
				foreach($hasil as $dt_hasil)
				{
					$jumlah = $jumlah+$dt_hasil->netto;
				}				
			}
		}

		return $this->konversi($jumlah);
	}

	function getDataTahun($tahun,$a,$jenis)
	{
		$nilai = "";
		$jumlah = 0;

		if(is_array($a))
		{
			foreach($a as $data)
			{
				$jenis = ($jenis == 'LAGOON')?" AND nomorspk='' ":" AND nomorspk<>'' ";

				$sql = "SELECT netto FROM datscale WHERE year(tgltrans)='$tahun' AND kodebrg='$data' $jenis";
				$kueri = $this->db->query($sql);
				$hasil = $kueri->result();
				foreach($hasil as $dt_hasil)
				{
					$jumlah = $jumlah+$dt_hasil->netto;
				}				
			}
		}

		return $this->konversi($jumlah);
	}

	function getTahunanAll($bulan,$tahun,$a,$jenis)
	{
		$nilai = "";
		$jumlah = 0;

		if(is_array($a))
		{
			foreach($a as $data)
			{
				$jenis = ($jenis == 'LAGOON')?" AND nomorspk='' ":" AND nomorspk<>'' ";

				$sql = "SELECT netto FROM datscale WHERE month(tgltrans)='$bulan' AND year(tgltrans)='$tahun' AND kodebrg='$data' $jenis";
				$kueri = $this->db->query($sql);
				$hasil = $kueri->result();
				foreach($hasil as $dt_hasil)
				{
					$jumlah = $jumlah+$dt_hasil->netto;
				}				
			}
		}

		return $this->konversi($jumlah);
	}

	function getGraphTahunan($thn)
	{
		$data = array();
		$header = array();

		$header = array(array('','LAGOON','OFF TAKING','LAGOON','OFF TAKING','LAGOON','OFF TAKING'));

		$bulan = $this->arey->getBulanLap();
		foreach($bulan as $key => $dt_bulan)
		{
			$fly_sold = $this->konversi($this->getTahunan(array('1','2','21','22'),$thn,$key,2,1));
			$fly_off = $this->konversi($this->getTahunan(array('1','2','21','22'),$thn,$key,2,2));
			$bot_sold = $this->konversi($this->getTahunan(array('5','6','25'),$thn,$key,2,1));
			$bot_off = $this->konversi($this->getTahunan(array('5','6','25'),$thn,$key,2,2));
			$gyp_sold = $this->konversi($this->getTahunan(array('3','4','23','24'),$thn,$key,2,1));
			$gyp_off = $this->konversi($this->getTahunan(array('3','4','23','24'),$thn,$key,2,2));
			$data[] = array($dt_bulan,$fly_sold,$fly_off,$bot_sold,$bot_off,$gyp_sold,$gyp_off);
		}

		$hasil = array_merge($header,$data);

		return $hasil;
	}

	function getGraphBulananan($bln,$thn)
	{
		$data = array();
		$header = array();

		$header = array(array('','LAGOON 1#2','LAGOON 3#4','OFFTAKE 1#2','OFFTAKE 3#4'));

		$bulan = $this->arey->getBulanLap();
		$limbah = $this->arey->getLimbah();

		foreach($limbah as $key => $dt_limbah)
		{
			$satu = $this->konversi($this->getBulan($bln,$thn,$dt_limbah['1#2'],1));
			$dua = $this->konversi($this->getBulan($bln,$thn,$dt_limbah['3#4'],1));
			$tiga = $this->konversi($this->getBulan($bln,$thn,$dt_limbah['1#2'],2));
			$empat = $this->konversi($this->getBulan($bln,$thn,$dt_limbah['3#4'],2));
			$data[] = array($key,$satu,$dua,$tiga,$empat);
		}

		$hasil = array_merge($header,$data);

		return $hasil;
	}

	function getGraphMingguan($tgl)
	{
		$data = array();
		$header = array();

		$header = array(array('','LAGOON','OFFTAKE','LAGOON','OFFTAKE','LAGOON','OFFTAKE','LAGOON','OFFTAKE','LAGOON','OFFTAKE','LAGOON','OFFTAKE'));		

		$seminggu = abs(7*86400);
		$awal = strtotime($tgl);
		$akhir = strtotime($tgl)+$seminggu;
		for($i=$awal;$i<=$akhir;$i+=86400)
		{
			$ubah = date('Y-m-d', $i);
			$pecah = explode("-",$ubah);
			$tanggal = $pecah[2]." ".$this->arey->getBulanLap(intval($pecah[1]))." ".$pecah[0];
			//fly ash
			$satu = $this->konversi($this->getBulanan(array('1','21'),$ubah,0,2,1));
			$dua = $this->konversi($this->getBulanan(array('1','21'),$ubah,0,2,2));
			$tiga = $this->konversi($this->getBulanan(array('2','22'),$ubah,0,2,1));
			$empat = $this->konversi($this->getBulanan(array('2','22'),$ubah,0,2,2));

			//bottom ash
			$lima = $this->konversi($this->getBulanan(array('5','25'),$ubah,0,2,1));
			$enam = $this->konversi($this->getBulanan(array('6'),$ubah,0,2,2));
			$tujuh = $this->konversi($this->getBulanan(array('5','25'),$ubah,0,2,1));
			$delepan = $this->konversi($this->getBulanan(array('6'),$ubah,0,2,2));

			//gypsum
			$sembilan = $this->konversi($this->getBulanan(array('3','23'),$ubah,0,2,1));
			$sepuluh = $this->konversi($this->getBulanan(array('4','24'),$ubah,0,2,2));
			$sebelas = $this->konversi($this->getBulanan(array('3','23'),$ubah,0,2,1));
			$duabelas = $this->konversi($this->getBulanan(array('4','24'),$ubah,0,2,2));

			$data[] = array($tanggal,$satu,$dua,$tiga,$empat,$lima,$enam,$tujuh,$delepan,$sembilan,$sepuluh,$sebelas,$duabelas);			
		}

		$hasil = array_merge($header,$data);

		return $hasil;
	}

	function getGraphHarian($tgl1,$tgl2)
	{
		$data = array();
		$header = array();

		$header = array(array('','LAGOON','OFFTAKE','LAGOON','OFFTAKE','LAGOON','OFFTAKE','LAGOON','OFFTAKE','LAGOON','OFFTAKE','LAGOON','OFFTAKE'));		

		$seminggu = abs(7*86400);
		$awal = strtotime($tgl1);
		$akhir = strtotime($tgl2);
		for($i=$awal;$i<=$akhir;$i+=86400)
		{
			$ubah = date('Y-m-d', $i);
			$pecah = explode("-",$ubah);
			$tanggal = $pecah[2]." ".$this->arey->getBulanLap(intval($pecah[1]))." ".$pecah[0];
			//fly ash
			$satu = $this->konversi($this->getBulanan(array('1','21'),$ubah,0,2,1));
			$dua = $this->konversi($this->getBulanan(array('1','21'),$ubah,0,2,2));
			$tiga = $this->konversi($this->getBulanan(array('2','22'),$ubah,0,2,1));
			$empat = $this->konversi($this->getBulanan(array('2','22'),$ubah,0,2,2));

			//bottom ash
			$lima = $this->konversi($this->getBulanan(array('5','25'),$ubah,0,2,1));
			$enam = $this->konversi($this->getBulanan(array('6'),$ubah,0,2,2));
			$tujuh = $this->konversi($this->getBulanan(array('5','25'),$ubah,0,2,1));
			$delepan = $this->konversi($this->getBulanan(array('6'),$ubah,0,2,2));

			//gypsum
			$sembilan = $this->konversi($this->getBulanan(array('3','23'),$ubah,0,2,1));
			$sepuluh = $this->konversi($this->getBulanan(array('4','24'),$ubah,0,2,2));
			$sebelas = $this->konversi($this->getBulanan(array('3','23'),$ubah,0,2,1));
			$duabelas = $this->konversi($this->getBulanan(array('4','24'),$ubah,0,2,2));

			$data[] = array($tanggal,$satu,$dua,$tiga,$empat,$lima,$enam,$tujuh,$delepan,$sembilan,$sepuluh,$sebelas,$duabelas);			
		}

		$hasil = array_merge($header,$data);

		return $hasil;
	}

	function getHarianSold($tgl,$a,$id)
	{
		unset($nilai);
		$nilai = array();

		if(is_array($a))
		{
			foreach($a as $data)
			{
				$id = ($id == 1)?" AND a.nomorspk<>''":" AND a.nomorspk=''";

				$sql = "SELECT * FROM datscale a,tabcust b,tabtrsp c WHERE a.kodecust=b.kodecust AND a.kodetrsp=c.kodetrsp AND a.tgltrans='$tgl' AND a.kodebrg='$data' $id";				
				$kueri = $this->db->query($sql);
				$hasil = $kueri->result();
				foreach($hasil as $dt_hasil)
				{
					$nilai[] = array(
						'jamtb1'		=> $dt_hasil->jamtb1,
						'jamtb2'		=> $dt_hasil->jamtb2,
						'nomorspk'		=> $dt_hasil->nomorspk,
						'nopol'			=> $dt_hasil->nopol,
						'timbang1'		=> $this->konversi($dt_hasil->timbang1),
						'timbang2'		=> $this->konversi($dt_hasil->timbang2),
						'netto'			=> $this->konversi($dt_hasil->netto),
						'sopir'			=> $dt_hasil->sopir,
						'namacust'		=> $dt_hasil->namacust,
						'namatrsp'		=> $dt_hasil->namatrsp
					);
				}				
			}
		}

		return $nilai;
	}

	function getTahunAll()
	{
		$kueri = $this->db->query("SELECT year(tgltrans) as tahun FROM datscale WHERE year(tgltrans) <> '0' GROUP BY year(tgltrans)");
		return $kueri->result();
	}

	function konversi($no)
	{
		$berat = $no/1000;
		return $berat;
	}
}
?>