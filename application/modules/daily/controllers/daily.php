<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daily extends CI_Controller {


	function __construct(){
		parent::__construct();
		$sess = $this->session->userdata();
		// if(!$sess['pegawai']['kar_pvl']=='U'){
		// 	redirect('auth');
		// }
        $this->load->model(array('auth/Auth_model','Daily_M'));
		
    }

	public function index()
	{

		
		$sess = $this->session->userdata();
	
		$data['active_menu'] 	= 'list_kategori';
		$data['wfh_master'] = $this->Daily_M->get_master_wfh();

		$nik_kantor = str_replace(".","",$sess['pegawai']['nik_kantor']);
		$uniq = date('dmY');

		$nomor = $nik_kantor.$uniq;

		$data['get_harian'] = $this->Daily_M->get_harian($nomor);
		$data['get_harian_groupby'] = $this->Daily_M->get_harian_groupby($nomor);

		
		
		

		$this->template->load('template','v_daily', $data);
	}

	function ajax_aktifitas(){

		$wfh_id = $this->input->post('wfh_id');
		$sql = $this->db->query('select * from wfh_master where wfh_id='.$wfh_id)->row();
		$wfh_aksi = explode(',',$sql->wfh_aksi);
		foreach($wfh_aksi as $w){
			echo "<option value=$w>$w</option>";
		}

	}


	function ajax_aktifitas_satuan(){

		$wfh_id = $this->input->post('wfh_id');
		$sql = $this->db->query('select * from wfh_master where wfh_id='.$wfh_id)->row();
		$wfh_satuan = explode(',',$sql->wfh_satuan);
		foreach($wfh_satuan as $w){
			echo "<option value=$w>$w</option>";
		}

	}


	function daily_simpan(){

	


		$sess = $this->session->userdata();
		// echo "<pre>";
		// print_r($sess['pegawai']);
		//die;

		 $status = $this->input->post('status');


		$tanggal_1 = $this->input->post('tanggal_1');
		$start_1 = $this->input->post('start_1');
		$end_1 = $this->input->post('end_1');

		$aktifitas_1 = $this->input->post('aktifitas_1');
		$aksi_1 = $this->input->post('aksi_1');
		$satuan_1 = $this->input->post('satuan_1');
		$value_1 = $this->input->post('value_1');
		$keterangan_1 = $this->input->post('keterangan_1');
		$lokasi_1 = $this->input->post('lokasi_1');



		$tanggal_2 = $this->input->post('tanggal_2');
		$start_2 = $this->input->post('start_2');
		$end_2 = $this->input->post('end_2');


		$target_start_2 = $this->input->post('target_start_2');
		$target_end_2 = $this->input->post('target_end_2');
		$target_value_2 = $this->input->post('target_value_2');

		$aktifitas_2 = $this->input->post('aktifitas_2');
		$aksi_2 = $this->input->post('aksi_2');
		$satuan_2 = $this->input->post('satuan_2');
		$value_2 = $this->input->post('value_2');
		$keterangan_2 = $this->input->post('keterangan_2');
		$lokasi_2 = $this->input->post('lokasi_2');

		 $nik_kantor = str_replace(".","",$sess['pegawai']['nik_kantor']);
		$uniq = date('dmY');

		 $nomor = $nik_kantor.$uniq;

	

		if($status=='1'){



			$data_wfa= array(

				'wfa_tanggal'		=> date('Y-m-d',strtotime($tanggal_1)),
				'kar_id'			=>$sess['pegawai']['id_kar'],
				'wfa_nama'			=>$sess['pegawai']['nama_karyawan'],
				'wfa_nomor'			=>$nomor,
				'wfa_username'		=>$sess['pegawai']['username'],
			
				'wfa_lock'			=>'N',
				'wfa_data'          =>'1',
				
			);

			// echo "<pre>";
			// print_r($data);

			$this->db->insert('wfh_activity',$data_wfa);

			$wfh_id = $this->db->insert_id();

			$data_insert= array(

				'wfd_tanggal'		=> date('Y-m-d',strtotime($tanggal_1)),
				'wfd_createdate' 	=> date('Y-m-d H:i:s'),
			    'wfd_start'			=> $start_1, 
				'wfd_end'			=> $end_1,
				'wfd_aktifitas'		=> $aktifitas_1, 
				'wfd_aksi'			=> $aksi_1, 
				'wfd_satuan'		=> $satuan_1, 
				'wfd_value'			=> $value_1, 
				'wfd_keterangan'	=> $keterangan_1,
				'wfd_lokasi'		=> $lokasi_1,
				'wfd_divisi'		=>$sess['pegawai']['div_id'],
				'wfd_key'			=>'',
				'kar_id'			=>$sess['pegawai']['id_kar'],
				'wfd_nama'			=>$sess['pegawai']['nama_karyawan'],
				'wfd_nomor'			=>$nomor,
				'wfd_username'		=>$sess['pegawai']['username'],
				//'wfd_status'		=>'1',
				'wfd_lock'			=>'N',
				'wfh_id'     => $wfh_id,
				
			);

			// echo "<pre>";
			// print_r($data_insert);

			$this->db->insert('wfh_data',$data_insert);

			$wfh_data = $this->db->insert_id();


			$wfh_data_data = array(
				'wfa_data'=>$wfh_data,
			);
			$this->db->update('wfh_activity',$wfh_data_data,array('wfa_id'=>$wfh_id));

		}else{


			$data_wfa= array(

				'wfa_tanggal'		=> date('Y-m-d',strtotime($tanggal_1)),
				'kar_id'			=>$sess['pegawai']['id_kar'],
				'wfa_nama'			=>$sess['pegawai']['nama_karyawan'],
				'wfa_nomor'			=>$nomor,
				'wfa_username'		=>$sess['pegawai']['username'],
			
				'wfa_lock'			=>'N',
				'wfa_data'          =>'1',
				
			);

			// echo "<pre>";
			// print_r($data);

			$this->db->insert('wfh_activity',$data_wfa);

			$wfh_id = $this->db->insert_id();


			$data_insert= array(

				'wfd_tanggal'		=> date('Y-m-d',strtotime($tanggal_2)),
				'wfd_createdate' 	=> date('Y-m-d H:i:s'),
			    'wfd_start'			=> $start_2, 
				'wfd_end'			=> $end_2,
				'wfd_aktifitas'		=> $aktifitas_2, 
				'wfd_aksi'			=> $aksi_2, 
				'wfd_satuan'		=> $satuan_2, 
				'wfd_value'			=> $value_2, 
				'wfd_keterangan'	=> $keterangan_2,
				'wfd_lokasi'		=> $lokasi_2,
				'wfd_divisi'		=>$sess['pegawai']['div_id'],
				'wfd_key'			=>'',
				'kar_id'			=>$sess['pegawai']['id_kar'],
				'wfd_nama'			=>$sess['pegawai']['nama_karyawan'],
				'wfd_nomor'			=>'',
				'wfd_username'		=>$sess['pegawai']['username'],
				'wfd_status'		=>'1',
				'wfd_lock'			=>'N',
				'wft_start'			=> $start_2, 
				'wft_end'			=> $end_2,
				'wft_value'			=> $value_2, 
				
			);

			// echo "<pre>";
			// print_r($data_insert);

			$this->db->insert('wfh_data',$data_insert);

			$wfh_data = $this->db->insert_id();


			$wfh_data_data = array(
				'wfa_data'=>$wfh_data,
			);
			$this->db->update('wfh_activity',$wfh_data_data,array('wfa_id'=>$wfh_id));

		}


		redirect('daily/');

		
	
		
	}

	function hapus_daily($nomor){
		//echo $nomor;
		$this->db->delete('wfh_data',array('wfd_nomor'=>$nomor));


		$this->db->delete('wfh_activity',array('wfa_nomor'=>$nomor));

		redirect('daily/');
	}

	function update_lock($status_id,$nomor){

		if($status_id==1){
			$lock = 'N';
		}elseif($status_id==2){
			$lock = 'Y';
		}

		$wfh_lock_1 = array(
			'wfd_lock'=>$lock,
		);

		// echo "<pre>";
		// print_r($wfh_lock_1);
		// die;

		$this->db->update('wfh_data',$wfh_lock_1,array('wfd_nomor'=>$nomor));


		

		$wfh_lock_2 = array(
			'wfa_lock'=>$lock,
		);

		$this->db->update('wfh_activity',$wfh_lock_2,array('wfa_nomor'=>$nomor));

		redirect('daily/');
	}

	function detail_lihat($nomor){
		//echo $nomor;

		$data['get_harian'] = $this->Daily_M->get_harian($nomor);
		$this->template->load('template','print_daily',$data);
	}

	
}
