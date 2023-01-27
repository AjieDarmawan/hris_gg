<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {


	function __construct(){
		parent::__construct();
		$sess = $this->session->userdata();
		if(!$sess['pegawai']['kar_pvl']=='U'){
			redirect('auth');
		}
        $this->load->model(array('auth/Auth_model','Pegawai_model'));
		
    }

	public function index()
	{

		//$sess = $this->session->userdata();

		//echo $this->session->userdata(['pegawai']['kar_pvl']);
		// echo "<pre>";
		// print_r($sess['pegawai']['kar_pvl']);
		// die;
		$keyword = $this->input->post('search');
		$post 	 = $this->input->post();

		$data['kar_masuk'] = $this->Pegawai_model->karyawan_masuk_tahun();
		$data['kar_keluar'] = $this->Pegawai_model->karyawan_keluar_tahun();
		$data['fasilitas_dapat'] = $this->Pegawai_model->fasilitas_dapat();
		$data['fasilitas_tidak_dapat'] = $this->Pegawai_model->fasilitas_tidak_dapat();

		$data['jumlah_karyawan_aktif'] = $this->Pegawai_model->jumlah_karyawan_aktif();

		$data['status_kar'] = $this->Pegawai_model->status_kar();

		

		

		

		

		// echo "<pre>";
		// print_r($data['kar_masuk']);

		// die;

		// foreach($data['kar_masuk'] as $k){
		// 	echo $k->TOTAL.',';
		// }

		
		// die;


		

		$this->template->load('template','pegawai_v', $data);
	}

	function beranda(){
		echo "tes";
	}

	function absen(){
		echo "absen";
	}
}
