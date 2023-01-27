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

  

    function kehadiran_kar(){

      $tgl_mulai = $this->input->post('tgl_mulai');
      $tgl_selesai = $this->input->post('tgl_selesai');
      $kar_nik_new = $this->input->post('kar_nik');


        $sql = $this->db->query("select count(status) as total from abs_flag_absen where date(tanggal) BETWEEN '".$tgl_mulai."' AND '".$tgl_selesai."'")->row();


        if($sql){
          

          $data_json = array(
            'status'=>200,
            'message'=>"Sukses",
            'data'=>$sql->total,
          );

        }else{
          $data_json = array(
            'status'=>400,
            'message'=>"Data Tidak ditemukan",
          );

        }

        echo json_encode($data_json);


    }


    

    function kar_risgn(){

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


        $sql = $this->db->query("select di.div_nm,di.div_id,k.kar_nm,d.kar_dtl_tgl_res as tanggal,k.kar_nik as kar_nik_lama, k.kar_nik_new from kar_detail as d
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


   
      function kar_belum_absen(){
      //$date = date('Y-m-d');
     // $bulan = '072021';
        $bulan = date('mY');
     
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

         $tgl_absen = date('Y-m-d');

          $kar  = $this->db->query("select k.kar_id,d.kar_dtl_tlp,k.div_id,m.div_nm 
            from kar_master as k 
            inner join kar_detail as d on d.kar_id=k.kar_id 
            inner join div_master as m on m.div_id = k.div_id
            where k.kar_nik = '".$jadwal2[$key1]->jdw_nik."'")->Row();
        


          $cek_absen = $this->db->query('select * from abs_detail where  kar_id = "'.$kar->kar_id.'"  and  abs_dtl_tgl ="'.$tgl_absen.'"')->row();

          // echo"<pre>";
          // print_r($cek_absen);
          // die;
          error_reporting(0);

          if($cek_absen->abs_dtl_sts=='H'){
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
          'no_wa'=>$kar->kar_dtl_tlp,
          'divisi'=>$kar->div_nm,
          'kar_id'=>$kar->kar_id,

        );
  
      }

      //  echo "<pre>";
      // print_r($data_fix);
      // die;

      foreach($data_fix as $d){
          if($d['status_absen'] == 'belum_absen'){

              $gl = substr($d['jenis_masuk'],0,2);

                if($gl=='GL'){
                    $gl2 = $gl;
                }else{
                  $gl2 = "";
                }



                if(($d['kar_id']!='675' and  $d['kar_id']!='369' and  $d['kar_id']!='26' and  $d['kar_id']!='43' and  $d['kar_id']!='608' and  $d['kar_id']!='634' and       $d['jenis_masuk']!='L' and $d['jenis_masuk']!='P' and $d['jenis_masuk']!='C' and $d['jenis_masuk']!='M' and $d['jenis_masuk']!='S' and $gl2!='GL')){
                     $data_fix2[] = $d; 
                }
              
          }
          // else{
          //      $data_fix2 = ""; 
          // } 
      }
     
      echo json_encode($data_fix2);


    }

     function screening(){

        $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_selesai = $this->input->post('tgl_selesai');

        $query = $this->db->query('select count(*) as total from pelamar where date(create_add) between "'.$tgl_mulai.'" and "'.$tgl_selesai.'" ')->row();


        if($query){
              $data_json = array(
              'status'=>200,
              'message'=>'sukses',
              'total' =>$query->total,
            );
            }else{

              $data_json = array(
              'status'=>400,
              'message'=>'gagal',
              'total' => 0,
            );

            }

            echo json_encode($data_json);

    }



     function undang_interview(){

        $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_selesai = $this->input->post('tgl_selesai');

        $query = $this->db->query('select count(*) as total from pelamar where status = "undang_interview" and date(date_status) between "'.$tgl_mulai.'" and "'.$tgl_selesai.'" ')->row();


        if($query){
              $data_json = array(
              'status'=>200,
              'message'=>'sukses',
              'total' =>$query->total,
            );
            }else{

              $data_json = array(
              'status'=>400,
              'message'=>'gagal',
              'total' => 0,
            );

            }

            echo json_encode($data_json);

    }


    function interview_hrd(){

       $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_selesai = $this->input->post('tgl_selesai');

        $query = $this->db->query('select count(*) as total from pelamar_interview where    date(date_status_satu) between "'.$tgl_mulai.'" and "'.$tgl_selesai.'" ')->row();


        if($query){
              $data_json = array(
              'status'=>200,
              'message'=>'sukses',
              'total' =>$query->total,
            );
            }else{

              $data_json = array(
              'status'=>400,
              'message'=>'gagal',
              'total' => 0,
            );

            }

            echo json_encode($data_json);

    }


    function interview_user(){

       $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_selesai = $this->input->post('tgl_selesai');

        $query = $this->db->query('select count(*) as total from pelamar_interview   where   date(date_status_dua) between "'.$tgl_mulai.'" and "'.$tgl_selesai.'" ')->row();


        if($query){
              $data_json = array(
              'status'=>200,
              'message'=>'sukses',
              'total' =>$query->total,
            );
            }else{

              $data_json = array(
              'status'=>400,
              'message'=>'gagal',
              'total' => 0,
            );

            }

            echo json_encode($data_json);

    }




    function offering(){

        $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_selesai = $this->input->post('tgl_selesai');

        $query = $this->db->query('select count(*) as total from pelamar_interview where status = "offering" 

          and date(date_status_offering) between "'.$tgl_mulai.'" and "'.$tgl_selesai.'" ')->row();


        if($query){
              $data_json = array(
              'status'=>200,
              'message'=>'sukses',
              'total' =>$query->total,
            );
            }else{

              $data_json = array(
              'status'=>400,
              'message'=>'gagal',
              'total' => 0,
            );

            }

            echo json_encode($data_json);



    }



    function karyawan_baru(){

        $tgl_mulai = $this->input->post('tgl_mulai');
        $tgl_selesai = $this->input->post('tgl_selesai');

        $query = $this->db->query('select count(*) as total from pelamar_interview where status_offering = "bersedia_gabung" and date(date_status_offering) between "'.$tgl_mulai.'" and "'.$tgl_selesai.'" ')->row();


        if($query){
              $data_json = array(
              'status'=>200,
              'message'=>'sukses',
              'total' =>$query->total,
            );
            }else{

              $data_json = array(
              'status'=>400,
              'message'=>'gagal',
              'total' => 0,
            );

            }

            echo json_encode($data_json);



    }




    function cron_kar_belum_absen(){

         //$date = date('Y-m-d');
     // $bulan = '072021';
        $bulan = date('mY');
     
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

         $tgl_absen = date('Y-m-d');

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

              $gl = substr($d['jenis_masuk'],0,2);

                if($gl=='GL'){
                    $gl2 = $gl;
                }else{
                  $gl2 = "";
                }



                if(($d['jenis_masuk']!='L' and $d['jenis_masuk']!='P' and $d['jenis_masuk']!='C' and $d['jenis_masuk']!='S' and $d['jenis_masuk']!='M'  and $gl2!='GL')){
                     $data_fix2[] = $d; 
                }
              
          }
          // else{
          //      $data_fix2 = ""; 
          // } 
      }
      

      $jumlah = count($data_fix2);



      if($jumlah==0){

        $status = 1;

      }else{

        $status = 0;

      }

      $tanggal = date('Y-m-d');

      $data_simpan = array(
          'tanggal'=>$tanggal,
          'status'=>$status,
          'jumlah_kar_belum_absen'=>$jumlah,
       );

      $cek = $this->db->query('select * from abs_flag_absen where date(tanggal) = "'.$tanggal.'"')->row();

      if($cek){
          $h = $this->db->update('abs_flag_absen',$data_simpan,array('tanggal'=>$tanggal));
      }else{
          $h = $this->db->insert('abs_flag_absen',$data_simpan);
      }



       if($h){
              $data_json2 = array(
              'status'=>200,
              'message'=>'sukses',
              
            );
            }else{

              $data_json2 = array(
              'status'=>400,
              'message'=>'gagal',
             
            );

            }

            echo json_encode($data_json2);






    


    }



 


    

   

}
