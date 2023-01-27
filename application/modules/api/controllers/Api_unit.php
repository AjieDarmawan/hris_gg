<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_unit extends CI_Controller
{


  function __construct()
  {
    parent::__construct();
    // if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
    //  redirect('auth');
    // }
    // $this->load->model(array('auth/auth_model'));

  }

  

  function cek_jarak(){

    error_reporting(0);
     $tanggal = date('Y-m-d');
     $kar_id = $this->input->post('kar_id');


     $lat = $this->input->post('lat');
     $long = $this->input->post('long');

     $id_kategori_aktifitas = $this->input->post('id_kategori_aktifitas');

     $cek_query_aktifitas_unit = $this->db->query('select * from aktifitas_unit where id_kategori_aktifitas = "'.$id_kategori_aktifitas.'" and create_kar_id="'.$kar_id.'" and date(crdt) = "'.$tanggal.'"')->result();




     if($cek_query_aktifitas_unit[0]){



         foreach($cek_query_aktifitas_unit as $c){




        

      $lat_tujuan = $c->unt_lat;
      $long_tujuan = $c->unt_long;
  
 

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=" . $lat_tujuan . "," . $long_tujuan . "&origins=" . $lat . "," . $long . "&mode=walking&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow";

      // die;

        // https://maps.googleapis.com/maps/api/geocode/json?latlng=
        //   -6.2097162,106.9772112
        //   &key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow

      //   https://maps.googleapis.com/maps/api/distancematrix/json?destinations=
      //   -6.1092736,106.925162
      //   &origins=
      //   -6.2097162,106.9772112
      //   &mode=walking&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow

      

       // echo $url;


        $ch = curl_init($url);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json', // if the content type is json
                //  'bearer: '.$token // if you need token in header
            )
        );
        //  curl_setopt($ch, CURLOPT_HEADER, false);
        //curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        curl_close($ch);

        //   return $result;

        $output = json_decode($result);

        $jarak = $output->rows[0]->elements[0]->distance->value;
        $lokasi_anda = $output->origin_addresses[0];


           //  echo "<pre>";
           // print_r();
           //  //echo json_encode($output);
           //  die;

        if($jarak<1000){
            $data_json['status'] = 404;
            $data_json['message'] = "Maaf jarak Anda Kurang dari 1 Km";
            $data_json['jarak'] = $jarak;
             $data_json['lokasi_anda'] = $lokasi_anda;


        }else{
            $data_json['status'] = 200;
            $data_json['message'] = "sukses";
            $data_json['jarak'] = $jarak;
             $data_json['lokasi_anda'] = $lokasi_anda;

        }

      }

         

      
        }else{
         $data_json['status'] = 202;
          $data_json['message'] = "belum laporan pertama";
          $data_json['jarak'] = 0;
          $data_json['lokasi_anda'] = "";
        }

        echo json_encode($data_json);



  }


  function list_history(){

    error_reporting(0);

      $tgl = $this->input->post('tgl');
      $kar_id = $this->input->post('kar_id');
       $id_kategori_aktifitas = $this->input->post('id_kategori_aktifitas');


      if($tgl){
          $tanggal = $tgl;
      }else{
          $tanggal = date("Y-m-d");
      }


      if($id_kategori_aktifitas!=0){
          $where_id_kategori = 'id_kategori_aktifitas = "'.$id_kategori_aktifitas.'" 
      and';
      }else{
          $where_id_kategori = '';
      }
     

     $cek_query_aktifitas_unit = $this->db->query('select * from aktifitas_unit where '.$where_id_kategori.' create_kar_id="'.$kar_id.'" and date(crdt) = "'.$tanggal.'" order by id_aktifitas_unit desc ')->result();
     
     // echo 'select * from aktifitas_unit where id_kategori_aktifitas = "'.$id_kategori_aktifitas.'" 
     //  and create_kar_id="'.$kar_id.'" and date(crdt) = "'.$tanggal.'"';
     // die;

     foreach($cek_query_aktifitas_unit as $c){

     

       $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$c->unt_lat.",".$c->unt_long."&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow";

       $ch = curl_init($url);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json', // if the content type is json
                //  'bearer: '.$token // if you need token in header
            )
        );
        //  curl_setopt($ch, CURLOPT_HEADER, false);
        //curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        curl_close($ch);

        //   return $result;

        $output = json_decode($result);

        $tempat = $output->results[0]->formatted_address;


        // echo "<pre>";
        // print_r($output->results[0]->formatted_address);
        // die;





        if($c->id_kategori_aktifitas==1){
          $jenis_kategori = 'spanduk';
        }elseif($c->id_kategori_aktifitas==2){
          $jenis_kategori = 'brosur';
        }






        $data_json[] = array(
          'id_aktifitas_unit'=>$c->id_aktifitas_unit,
          'waktu' => TanggalIndo($c->crdt) .' - '. date('H:i:s',strtotime($c->crdt)),
          'tgl' =>TanggalIndo($c->crdt),
          'jam'=>date('H:i:s',strtotime($c->crdt)),
          'keterangan'=>$c->keterangan,
          'photo'=>'https://cb.web.id/module/unit_foto_aktifitas/'.$c->photo,
          'tempat'=>$tempat,
          'jumlah'=>$c->jumlah,
          'status'=>$c->status,
          'lat'=>$c->unt_lat,
          'long'=>$c->unt_long,
          'jenis_kategori'=>$jenis_kategori,
        );
     }

     if($data_json){
        $data_json2['status'] = 200;
        $data_json2['message'] = "sukses";
        $data_json2['data'] = $data_json;

     }else{

      $data_json_eror[] = array(
          'id_aktifitas_unit'=>1,
          'waktu' => '2022-01-01 00:00:00',
          'keterangan'=>'',
          'photo'=>'',
          'tempat'=>'',
        );


        $data_json2['status'] = 404;
        $data_json2['message'] = "kosong";
        $data_json2['data'] = $data_json_eror;

     }

     echo json_encode($data_json2);



  }

  function test(){
    $url = "https://dev-api.ai.web.id/index.php/auth/login";
        $ch = curl_init($url);

        $postData = array(
          "email"=> 'adamilkom00@gmail.com',
          "password"=>'61qVhy',

     );

   // for sending data as json type
   $fields = json_encode($postData);


        curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
          'from:utn.ai.web.id',
         // 'Content-Type: application/json', // if the content type is json
        //  'bearer: '.$token // if you need token in header
        )
        );

          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
         // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
          curl_setopt($ch, CURLOPT_POSTFIELDS,
            "email=adamilkom00@gmail.com&password=61qVhy");


          $result = curl_exec($ch);
          curl_close($ch);



          $output = json_decode($result);

          echo "<pre>";
          print_r($output);
  }


}