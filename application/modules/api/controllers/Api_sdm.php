<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_sdm extends CI_Controller
{


    function __construct(){
        parent::__construct();
        // if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
        //  redirect('auth');
        // }
      // $this->load->model(array('auth/auth_model'));
        
    }



    function kehadiran_kar_ktr(){
      $tgl_mulai = $this->input->post('tgl_mulai');
      $tgl_selesai = $this->input->post('tgl_selesai');

      if($tgl_mulai){
        $tgl_mulai2 = $tgl_mulai;
        $tgl_selesai2 = $tgl_selesai;
    }else{
        $tgl_mulai2 = date('Y-m-d');
        $tgl_selesai2 = date('Y-m-d');
    }



      $sql = $this->db->query("select * from ktr_master")->result();


      foreach($sql as $s){
         
        $kar = $this->db->query("select count(*) total from abs_detail where ktr_id='".$s->ktr_id."' 
        and  abs_dtl_sts = 'H' and abs_dtl_tgl BETWEEN '".$tgl_mulai2."' AND '".$tgl_selesai2."'")->row();

        $data_data[] = array(
          'ktr_id'=>$s->ktr_id,
          'ktr_nm'=>$s->ktr_nm,
          'total_masuk'=>$kar->total,
        );
      }



      echo json_encode($data_data);



    }


    function kehadiran_kar(){

      $tgl_mulai = $this->input->post('tgl_mulai');
      $tgl_selesai = $this->input->post('tgl_selesai');
      $kar_nik_new = $this->input->post('kar_nik');


        $sql = $this->db->query("select a.abs_tgl_masuk as tanggal ,k.kar_nm,k.kar_nik as kar_nik_lama , k.kar_nik_new from abs_master as a 
        inner join kar_master as k on k.kar_id = a.kar_id
        where  a.abs_tgl_masuk BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."'
        and k.kar_nik_new = '".$kar_nik_new."'")->result_array();


        if($sql){
          $data_data = array(

            'kar_nm' => $sql[0]['kar_nm'],
            'kar_nik_lama' => $sql[0]['kar_nik_lama'],
            'kar_nik' => $sql[0]['kar_nik_new'],
            'total_absen' => count($sql),
          );

          $data_json = array(
            'status'=>200,
            'message'=>"Sukses",
            'data'=>$data_data,
          );

        }else{
          $data_json = array(
            'status'=>400,
            'message'=>"Data Tidak ditemukan",
          );

        }

        echo json_encode($data_json);


    }


    function kar_baru(){

    }

    function kar_risgn(){

      error_reporting(0);

      $tgl_mulai = $this->input->post('tgl_mulai');
      $tgl_selesai = $this->input->post('tgl_selesai');
      $divisi = $this->input->post('divisi');

      if($tgl_mulai){
          $tgl_mulai2 = $tgl_mulai;
          $tgl_selesai2 = $tgl_selesai;
      }else{
          $tgl_mulai2 = date('Y-m-d');
          $tgl_selesai2 = date('Y-m-d');
      }

      if($divisi){
        $where_div = "and di.div_nm like '%".$divisi."%'";
      }else{
        $where_div = "";
      }


        $sql = $this->db->query("select di.div_nm,di.div_id,k.kar_nm,d.kar_dtl_tgl_res from kar_detail as d
        inner join kar_master as k on k.kar_id = d.kar_id
        inner join div_master as di on di.div_id = k.div_id
        where d.kar_dtl_als_res like '%mengundurkan diri%' 
        ".$where_div."
        and d.kar_dtl_tgl_res BETWEEN '".$tgl_mulai2."' AND '".$tgl_selesai2."'")->result_array();


       // echo json_encode($sql);

       if($sql){
        $data_data = array(

          'kar_nm' => $sql[0]['kar_nm'],
          'kar_nik_lama' => $sql[0]['kar_nik_lama'],
          'kar_nik' => $sql[0]['kar_nik_new'],
          'div_nm' => $sql[0]['div_nm'],
          'div_id' => $sql[0]['div_id'],
          'tanggal' => $sql[0]['tanggal'],
         
        );

        $data_json = array(
          'status'=>200,
          'message'=>"Sukses",
          'data'=>$data_data,
        );

      }else{
        $data_json = array(
          'status'=>400,
          'message'=>"Data Tidak ditemukan",
        );

      }

      echo json_encode($data_json);


    }


    function intview_hrd(){

    }





    function kar_belum_absen(){
      //$date = date('Y-m-d');
      $bulan = '072021';

     
      $jadwal2 = $this->db->query("select * from jdw_master as j
      inner join kar_master as k on j.jdw_nik=k.kar_nik 
      where  j.jdw_blnthn = '".$bulan."'")->result();

      // echo "<pre>";
      // print_r($jadwal2);
      // die;

      foreach($jadwal2 as $key => $ja){
        $jad = $jadwal2[$key]->jdw_data;
        $jadw[] = explode("#",$jad);
      }

      foreach($jadw as $key1 => $k){

         //$tgl = date('Y-m-d');
        $tgl_absen = '2021-07-14';

        $kar  = $this->db->query("select * from kar_master where kar_nik = '".$jadwal2[$key1]->jdw_nik."'")->Row();
        


          $cek_absen = $this->db->query('select * from abs_master where  kar_id = "'.$kar->kar_id.'"  and  abs_tgl_masuk ="'.$tgl_absen.'"')->row();

          if($cek_absen){
            $status_absen = "sudah_absen";
          }else{
            $status_absen = "belum_absen";
          }


        $tgl = date('d')-1; 
        $kk = $k[$tgl]; 

        
        $data_fix[] = array(
          'username'=>$jadwal2[$key1]->jdw_username,
          'nama'=>$jadwal2[$key1]->jdw_nama,
          'jenis_masuk'=>$kk,
          'status_absen'=>$status_absen,
        );
  
      }

      //  echo "<pre>";
      // print_r($data_fix);
      // die;

      foreach($data_fix as $d){
          if($d['status_absen'] == 'belum_absen'){

                if(($d['jenis_masuk']!='L' and $d['jenis_masuk']!='P')){
                     $data_fix2[] = $d; 
                }
              
          }
          // else{
          //      $data_fix2 = ""; 
          // } 
      }
     
      echo json_encode($data_fix2);


    }


    function cari_libur(){

         error_reporting(0);
          //$date = date('Y-m-d');
         // $bulan = date('mY');

          $bulan = '072021';
          $kar_id = $this->input->post('kar_id');
         
      
          $karname = $this->db->query("select * from kar_master where kar_id='" . $kar_id . "'")->row();
          $data['jadwal2'] = $this->db->query("select * from jdw_master as j
          inner join kar_master as k on j.jdw_nik=k.kar_nik 
          where  j.jdw_blnthn = '" . $bulan . "' and j.jdw_nik='" . $karname->kar_nik . "'")->result();
      
      
          $jad = $data['jadwal2'][0]->jdw_data;
          $jadwal = explode("#", $jad);

          $tgl = date('d') - 1;
          


          // echo "<pre>";
          // print_r($jadwal[$tgl]);
          // die;

          foreach($jadwal as $key => $j){

               if($key <= $tgl){
                $data_array[$key]= $j;
               }
             

          }

        

          $jumlah = array_count_values($data_array);

            echo "<pre>";
          print_r($jumlah);


        //   $jumlah = array_count_values($jadwal);

        // echo   $libur = $jumlah['L'] + $jumlah['LN'] + $jumlah['LM'];



        
        


      
    }




 


    

   

}
