<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{


    function __construct(){
        parent::__construct();
        // if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
        //  redirect('auth');
        // }
      // $this->load->model(array('auth/auth_model'));
        
    }

    function absen(){
        

        $id_kar = $this->input->post('id_kar');

        $lat = $this->input->post('lat');
        $long = $this->input->post('long');


        $kar  = $this->db->query("select * from m_karyawan where id_karyawan = '".$id_kar."'")->Row();
        $kantor  = $this->db->query("select * from m_kantor where ktr_id = '".$kar->ktr_id."'")->Row();
        $lat_kantor = $kantor->lat;
        $long_kantor = $kantor->long;

        $jadwal  = $this->db->query("select * from jadwal where id_karyawan = '".$id_kar."' and date(tanggal) =  '".date('Y-m-d')."'")->Row();


        // echo "<pre>";
        // print_r($kar);
        // die;

        if($jadwal->jenis_masuk=='WFO'){

            $lat_tujuan = $kantor->lat;
            $long_tujuan = $kantor->long;

        }else if($jadwal->jenis_masuk=='WFH'){

            $lat_tujuan = $kar->lat;
            $long_tujuan = $kar->long;
        }



       // error_reporting(0);


        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".$lat_tujuan.",".$long_tujuan."&origins=".$lat.",".$long."&mode=walking&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow";


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


            // echo "<pre>";
            // print_r($output->rows[0]->elements[0]->distance->value);
            //echo json_encode($output);

            $jarak_skrang = $output->rows[0]->elements[0]->distance->value;

           //echo "<br>";
            
            // echo "<pre>";
            // print_r();
            // die;



            $jarak_orang = $kar->radius;

        
          

           $jarak_orang2 =   $jarak_orang * 1000;

             

       
              //40317  >=   500
             if($jarak_skrang <= $jarak_orang2){


                $check_absen = $this->db->query("select * from absen where id_karyawan = ".$id_kar." and date(masuk) = '".date('Y-m-d')."'")->row();

                // echo "<pre>";
                // print_r($check_absen);
                // die;

                if($check_absen){

                        // jika dia sif 3 cek pulang kalo ada tambah/insert
                         if($check_absen->pulang != '0000-00-00 00:00:00'){

                        $data_insert = array(
                            'id_karyawan'=>$id_kar,
                            'masuk'=>date('Y-m-d H:i:s'),
                            'pulang'=>'',
                            'alasan'=>'',
                            'ket'=>'',
                        );
        
                        $this->db->insert('absen',$data_insert);

                        $data_array = array(
                            'status'=>200,
                            'message'=>"Success",
                         );

                    }else{


                      $foto = $this->db->query('select * from users  where id_kar ='.$id_kar)->row();
                    //    echo "<pre>";
                    //    print_r($foto->image);     
                    //   die;

    
                    $Path = './assets/file_upload/images/'.$foto->image;
                    if (file_exists($Path)){
                        if (unlink($Path)) {   

                           
                           
                            $config['upload_path']          = './assets/file_upload/images/';
                            $config['allowed_types']        = 'gif|jpg|png';
                            // $config['max_size']             = 100;
                            // $config['max_width']            = 1024;
                            // $config['max_height']           = 768;
                    
                            $this->load->library('upload', $config);
                    
                            if ( ! $this->upload->do_upload('image')){
                                $error = array('error' => $this->upload->display_errors());
        
                                echo "<pre>";
                                print_r($error);
                                //$this->load->view('v_upload', $error);
                            }else{
                                $data = array('upload_data' => $this->upload->data());
        
                                $data_update = array(
                                    'image'=>$data['upload_data']['file_name'],
                                   
                                );
            
            
                                $this->db->update('users',$data_update,array('id_kar'=>$id_kar));
                               
                               $data_insert = array(
                                'id_karyawan'=>$id_kar,
                              //  'masuk'=>date('Y-m-d H:i:s'),
                                'pulang'=>date('Y-m-d H:i:s'),
                                'alasan'=>'',
                                'ket'=>'',
                            );
            
                            $this->db->update('absen',$data_insert, array('id_absen' => $check_absen->id_absen));
        
                            $data_array = array(
                                'status'=>200,
                                'message'=>"Success update",
                             );
                            
                        }




                        } else {
                            echo "fail";    
                        }   
                    } else {
                        echo "file does not exist";
                    }

                   



                  

              }

                  

                }else{



                    $config['upload_path']          = './assets/file_upload/images/';
                    $config['allowed_types']        = 'gif|jpg|png';
                    // $config['max_size']             = 100;
                    // $config['max_width']            = 1024;
                    // $config['max_height']           = 768;
            
                    $this->load->library('upload', $config);
            
                    if ( ! $this->upload->do_upload('image')){
                        $error = array('error' => $this->upload->display_errors());

                        echo "<pre>";
                        print_r($error);
                        //$this->load->view('v_upload', $error);
                    }else{
                        $data = array('upload_data' => $this->upload->data());

                        
                       // $this->load->view('v_upload_sukses', $data);

                       $data_insert = array(
                        'id_karyawan'=>$id_kar,
                        'masuk'=>date('Y-m-d H:i:s'),
                        'pulang'=>'',
                        'alasan'=>'',
                        'ket'=>'',
                    );
    
                    $this->db->insert('absen',$data_insert);


                    $data_update = array(
                        'image'=>$data['upload_data']['file_name'],
                       
                    );


                    $this->db->update('users',$data_update,array('id_kar'=>$id_kar));

                    $data_array = array(
                        'status'=>200,
                        'message'=>"Success",
                     );
                    
                
                }


                  
                   

                   

                }
                

               



                    
             }else{
                   $data_array = array(
                       'status'=>400,
                       'message'=>"Lokasi Kejauhan",
                    );

             }

             echo json_encode($data_array);

    }


    function check_absen(){


        $id_kar = $this->input->post('id_kar');

        $lat = $this->input->post('lat');
        $long = $this->input->post('long');


        $kar  = $this->db->query("select * from m_karyawan where id_karyawan = '".$id_kar."'")->Row();
        $kantor  = $this->db->query("select * from m_kantor where ktr_id = '".$kar->ktr_id."'")->Row();


        $jadwal  = $this->db->query("select * from jadwal where id_karyawan = '".$id_kar."' and date(tanggal) =  '".date('Y-m-d')."'")->Row();

        $daily  = $this->db->query("select * from wfh_data where kar_id = '".$id_kar."' and date(wfd_createdate) =  '".date('Y-m-d')."' and wfd_lock = 'Y'")->Row();

        // echo "<pre>";
        // print_r($kar);
        // die;

        if($daily){
            $daily = "sudah_bikin_daily";
        }else{
            $daily = "belum_bikin_daily";
        }

        if($jadwal->jenis_masuk=='WFO'){

            $lat_tujuan = $kantor->lat;
            $long_tujuan = $kantor->long;
           

        }else if($jadwal->jenis_masuk=='WFH' || $jadwal->jenis_masuk=='M' ||  $jadwal->jenis_masuk=='L'){

            $lat_tujuan = $kar->lat;
            $long_tujuan = $kar->long;
        }  else{
            $lat_tujuan = $kar->lat;
            $long_tujuan = $kar->long;
        }
        

        
        



       // error_reporting(0);


        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".$lat_tujuan.",".$long_tujuan."&origins=".$lat.",".$long."&mode=walking&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow";


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


        //     echo "<pre>";
        //    print_r($output);

        //    die;
          //  echo json_encode($output);

            $jarak_skrang = $output->rows[0]->elements[0]->distance->value;

           //echo "<br>";
            
            // echo "<pre>";
            // print_r();
            // die;

            $jarak_orang = $kar->radius;


            $jarak_orang * 1000;
              //40317  >=   500

              $check_absen = $this->db->query("select * from absen where id_karyawan = ".$id_kar." and date(masuk) = '".date('Y-m-d')."'")->row();

              error_reporting(0);

               if($check_absen->masuk){

                    if($check_absen->masuk && $check_absen->pulang != '0000-00-00 00:00:00'){
                        $status_button = "sudah_pulang";
                    }else{
                        $status_button = "sudah_masuk";
                    }
                   
               }else{
                    $status_button = "belum_masuk";
               }


                 $data_json = array(
                  'jenis_masuk'=>$jadwal->jenis_masuk,
                  'tujuan_lat'=>$lat_tujuan,
                  'tujuan_long'=>$long_tujuan,
                  'posisi_lat'=>$lat,
                  'posisi_long'=>$long,
                  'jarak_skrang'=>"".$jarak_skrang."",
                  'status_button'=> $status_button,
                  'radius'=>$kar->radius * 1000,
                  'kantor'=>$kantor->kantor_nama,
                  'lokasi_skrang'=>$output->destination_addresses[0],
                  'lokasi_tujuan'=>$output->origin_addresses[0],
                  'daily'=>$daily
              );

              echo json_encode($data_json);
            

    }


    function jadwal(){

      

       $id_kar = $this->input->post('id_kar');

        $jadwal = $this->db->query("select j.*,m.nama_karyawan from jadwal as j
        inner join m_karyawan as m on m.id_karyawan = j.id_karyawan where  j.id_karyawan = '".$id_kar."' 
        and MONTH(j.tanggal) = '02' and year(j.tanggal) = '2022'
        ")->result();

        foreach($jadwal as $ja){
            $data[] = array(
                "id_jadwal"=> $ja->id_jadwal,
                "id_karyawan"=> $ja->id_karyawan,
                "jenis_masuk"=> $ja->jenis_masuk,
                "tanggal"=>date('d-m-Y',strtotime($ja->tanggal)),
                "id_ktr"=> $ja->id_ktr,
                "ket"=> "",
                "nama_karyawan"=> $ja->nama_karyawan,
            );
        }

        echo json_encode($data);
    }


    


    

   

}
