<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cb extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }

       
      
		
    }


    // redirect if needed, otherwise display the user list
    public function maps($id)
    {
      

       $data['absen'] = $this->db->query("SELECT a.*,k.kar_nm,div_nm,md.abs_masuk,abs_pulang,abs_tgl_masuk,kt.ktr_nm FROM  abs_kar_titik_kordinat as a 
             join kar_master as k on k.kar_id = a.kar_id 
             join div_master as d on d.div_id = k.div_id 
             join ktr_master as kt on kt.ktr_id = a.ktr_id 
             join abs_master as md on md.abs_id=a.abs_id  where id_abs_kar_titik_kordinat = '".$id."'")->row();

        // $data["title"] = "List Data Master Divisi";
        // $this->template->load('template','absen/upload_jadwal',$data);

        $this->load->view('maps_absen',$data);
     
    }

     public function cek_lokasi()
    {
      

       $data['absen'] = $this->db->query("select k.kar_nm,kt.ktr_nm,kt.ktr_lat,kt.ktr_long,dm.div_nm,kt.ktr_id,k.kar_id,k.kar_lat,k.kar_long from kar_master as k 
        join kar_detail as d on d.kar_id = k.kar_id
        join div_master as dm on dm.div_id = k.div_id
        inner join ktr_master as kt on kt.ktr_id = k.ktr_id WHERE d.kar_dtl_typ_krj != 'Resign' order by kt.ktr_id asc")->result();

        // $data["title"] = "List Data Master Divisi";
        // $this->template->load('template','absen/upload_jadwal',$data);

      // $this->template->load('template','absen/cek_lokasi',$data);

       $this->load->view('cek_lokasi',$data);
     
    }


    function ubah($kar_id){
        error_reporting(0);

        $data['kar_id'] = $kar_id;

        $tempat = $this->db->query('select ktr_id,kar_lat,kar_long from kar_master where kar_id = "'.$kar_id.'"')->row();
         $data['ktr_id'] = $tempat->ktr_id;


          $cek = $this->input->post('CEK');
        $simpan = $this->input->post('simpan');


        $form_lat = $this->input->post('lat');
        $form_long =$this->input->post('long');

        if($form_lat){
                  
                  if($cek){
                     $data['lat'] = $form_lat;
                    $data['long'] = $form_long;
                  }elseif($simpan){

                    $data['lat'] = $form_lat;
                    $data['long'] = $form_long;

                    // echo "<pre>";
                    // print_r($data);
                  //  die;


                      $data_ubah_lat_long = array(
                    'kar_lat'=>$form_lat,
                    'kar_long'=>$form_long,
                  );


                  $this->db->where('kar_id',$kar_id);
                  $this->db->update('kar_master',$data_ubah_lat_long);
                  }
                 

                
        }else{
            


            if($tempat->kar_lat){
                  $data['lat'] = $tempat->kar_lat;
                  $data['long'] = $tempat->kar_long;
            }else{
                 $data['lat'] =  '-6.507369';
                 $data['long'] =    '106.843742';
            }
        }

      
      

         $data['kantor'] = $this->db->query("select * from ktr_master order by ktr_id asc")->result();


        $this->load->view('ubah',$data);
     
    }

    function simpan_ubah(){
        $kar_id = $this->input->post('kar_id');
        $ktr_id = $this->input->post('ktr_id');


        $data_simpan = array(
            'ktr_id'=>$ktr_id,
        );


        $this->db->where('kar_id',$kar_id);
        $this->db->update('kar_master',$data_simpan);

        redirect('absen/cb/cek_lokasi');


    }


    function kantor(){
          $data['kantor'] = $this->db->query("select * from ktr_master where ktr_aktif = 'A' order by ktr_id asc")->result();


        $this->load->view('kantor_v',$data);
    }

    function lihat_maps($ktr_id){

         $lat = $this->input->post('lat');
        $long = $this->input->post('long');
        $cek = $this->input->post('CEK');
        $simpan = $this->input->post('simpan');


         $data_kantor = $this->db->query("select ktr_lat,ktr_long from ktr_master where ktr_id = '".$ktr_id."' ")->row();

         if($cek){

             $data['lat'] = $lat;
             $data['long'] = $long;

         }else{

              if($data_kantor->ktr_lat){
                 $data['lat'] = $data_kantor->ktr_lat;
                 $data['long'] = $data_kantor->ktr_long;
                 }else{
                    //kantor bs
                    $data['lat'] =  '-6.507369';
                     $data['long'] =    '106.843742';
                 }

         }

         if($simpan){




            $data_simpan = array(
                'ktr_lat'=>$lat,
                'ktr_long'=>$long,
            );
            // echo "<pre>";
            // print_r($data_simpan);
            //die;

            $this->db->where('ktr_id',$ktr_id);
            $this->db->update('ktr_master',$data_simpan);
         }



       


        
         $this->load->view('lihat_maps',$data);
    }







   

  


    
    
}
