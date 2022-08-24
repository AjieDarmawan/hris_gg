<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_fcm extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }
     //  $this->load->model(array('auth/auth_model'));

		
    }


    function blast(){

    }


    function ceklatlong(){
        $timezone = new DateTimeZone('Asia/Jakarta');
         $date = new DateTime();
         $date->setTimeZone($timezone);
         date_add($date, date_interval_create_from_date_string('6 minutes'));
         $waktu = date_format($date, 'Y-m-d H:i:s');
 
 
 
        
         $lat = $this->input->post('lat');
         $long = $this->input->post('long');
         $kar_id = $this->input->post('kar_id');
 
 
         $data_insert = array(
             'lat'=>$lat,
             'long'=>$long,
             'kar_id'=>$kar_id,
             'tanggal'=>$waktu,
         );
 
         $q = $this->db->insert('cek_posisi',$data_insert);
 
         if($q){
             $datajson['status'] = 200;
             $datajson['message'] = "success";
         }else{
             $datajson['status'] = 404;
             $datajson['message'] = "gagal";
         }
         echo json_encode($datajson);
     }

   

}
