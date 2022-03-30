<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_daily extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
       $this->load->model(array('Api_M'));
		
    }
    

    function daily_simpan(){


		//$sess = $this->session->userdata();

        $id_kar = $this->input->post("id_kar");
        $username = $this->input->post('username');

        $kar = $this->db->query('select * from m_karyawan where id_karyawan ='.$id_kar)->row_array();

        // echo "<pre>";
        // print_r($kar);
        // die;

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

		 $nik_kantor = str_replace(".","",$kar['nik_kantor']);
		$uniq = date('dmY');

		 $nomor = $nik_kantor.$uniq;

	

		if($status=='1'){
           

            try {
                // init bootstrapping phase
                $data_wfa= array(

                    'wfa_tanggal'		=> date('Y-m-d',strtotime($tanggal_1)),
                    'kar_id'			=>$kar['id_karyawan'],
                    'wfa_nama'			=>$kar['nama_karyawan'],
                    'wfa_nomor'			=>$nomor,
                    'wfa_username'		=>$username,
                
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
                    'wfd_divisi'		=>$kar['div_id'],
                    'wfd_key'			=>'',
                    'kar_id'			=>$kar['id_karyawan'],
                    'wfd_nama'			=>$kar['nama_karyawan'],
                    'wfd_nomor'			=>$nomor,
                    'wfd_username'		=>$username,
                    //'wfd_status'		=>'1',
                    'wfd_lock'			=>'N',
                    'wfh_id'     => $wfh_id,
                    
                );
    
                // echo "<pre>";
                // print_r($data_insert);
    
                $a = $this->db->insert('wfh_data',$data_insert);
    
                $wfh_data = $this->db->insert_id();
    
    
                $wfh_data_data = array(
                    'wfa_data'=>$wfh_data,
                );
                $b = $this->db->update('wfh_activity',$wfh_data_data,array('wfa_id'=>$wfh_id));
    
    
               
                    $data_status = array(
                        'status'=>200,
                        'message'=>'sukkses',
                    );
                
                  
               
    
             
              
                // continue execution of the bootstrapping phase
            } catch (Exception $e) {
                $data_status = array(
                    'status'=>404,
                    'message'=>'gagal',
                );
            }

			




		}else{


          try {
                // init bootstrapping phase
             
			$data_wfa= array(

				'wfa_tanggal'		=> date('Y-m-d',strtotime($tanggal_1)),
				'kar_id'			=>$kar['id_karyawan'],
				'wfa_nama'			=>$kar['nama_karyawan'],
				'wfa_nomor'			=>$nomor,
				'wfa_username'		=>$username,
			
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
				'wfd_divisi'		=>$kar['div_id'],
				'wfd_key'			=>'',
				'kar_id'			=>$kar['id_karyawan'],
				'wfd_nama'			=>$kar['nama_karyawan'],
				'wfd_nomor'			=>'',
				'wfd_username'		=>$username,
				'wfd_status'		=>'1',
				'wfd_lock'			=>'N',
				'wft_start'			=> $start_2, 
				'wft_end'			=> $end_2,
				'wft_value'			=> $value_2, 
				
			);

			// echo "<pre>";
			// print_r($data_insert);

			$a = $this->db->insert('wfh_data',$data_insert);

			$wfh_data = $this->db->insert_id();


			$wfh_data_data = array(
				'wfa_data'=>$wfh_data,
			);
			$b = $this->db->update('wfh_activity',$wfh_data_data,array('wfa_id'=>$wfh_id));

           
                $data_status = array(
                    'status'=>200,
                    'message'=>'sukkses',
                );
            
           
             
              
                // continue execution of the bootstrapping phase
            } catch (Exception $e) {
               
                $data_status = array(
                    'status'=>404,
                    'message'=>'gagal',
                );
            }




		}


       echo json_encode($data_status); 

		
	
		
	}

	function hapus_daily(){


        $id_kar = $this->input->post("id_kar");

       
        $kar = $this->db->query('select * from m_karyawan where id_karyawan ='.$id_kar)->row_array();


        $nik_kantor = str_replace(".","",$kar['nik_kantor']);
		$uniq = date('dmY');

		 $nomor = $nik_kantor.$uniq;


		//echo $nomor;
		$this->db->delete('wfh_data',array('wfd_nomor'=>$nomor));


		$this->db->delete('wfh_activity',array('wfa_nomor'=>$nomor));

		//redirect('daily/');

        $data = array(
            'status'=>200,
            'message'=>'sukkses',
        );
        echo json_encode($data);
	}

	function update_lock(){

        $id_kar = $this->input->post("id_kar");

        $status_id = $this->input->post("status_id");
        $kar = $this->db->query('select * from m_karyawan where id_karyawan ='.$id_kar)->row_array();


        $nik_kantor = str_replace(".","",$kar['nik_kantor']);
		$uniq = date('dmY');

		 $nomor = $nik_kantor.$uniq;




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

        $data = array(
            'status'=>200,
            'message'=>'sukkses',
        );
        echo json_encode($data);
	}

	function detail_lihat(){
		//echo $nomor;


        $id_kar = $this->input->post("id_kar");

       
        $kar = $this->db->query('select * from m_karyawan where id_karyawan ='.$id_kar)->row_array();


        $nik_kantor = str_replace(".","",$kar['nik_kantor']);
		$uniq = date('dmY');

		 $nomor = $nik_kantor.$uniq;
		$get_harian = $this->Daily_M->get_harian($nomor);
		
        echo json_encode($get_harian);
	}

	function list_activity(){

		$id_kar = $this->input->post("id_kar");

       
        $kar = $this->db->query('select * from m_karyawan where id_karyawan ='.$id_kar)->row_array();


        $nik_kantor = str_replace(".","",$kar['nik_kantor']);
		$uniq = date('dmY');

		  $nomor = $nik_kantor.$uniq;

        
		$get_harian = $this->Api_daily_M->get_harian($nomor);
		
        echo json_encode($get_harian);


		
	}

   

  
}
