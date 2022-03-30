<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {


	function __construct(){
		parent::__construct();
		$sess = $this->session->userdata();
		// if(!$sess['pegawai']['kar_pvl']=='U'){
		// 	redirect('auth');
		// }
        // $this->load->model(array('auth/Auth_model','Pegawai_model'));
		
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

		$data['title'] 			= 'Document';
		$data['search'] 		= $keyword;
		$data['search_box'] 	= true;
		$data['active_menu'] 	= 'list_kategori';
		$data['action'] 		= base_url('document/index');
		$data['css'] 			= array(
			'plugins/datepicker/datepicker3.css',
			'plugins/sweet-alert/sweetalert.css'
		); // css tambahan
		$data['js']				= array(
			'plugins/sweet-alert/sweetalert.min.js',
			'plugins/datepicker/bootstrap-datepicker.js'
		); // js tambahan


		

		$this->template->load('template','pegawai_v', $data);
	}

	function beranda(){
		echo "tes";
	}

	function absen(){
		echo "absen";
	}
}
