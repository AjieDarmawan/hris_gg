<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api_dashboard extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
        
		
    }

    protected function objToArray($obj)
    {
        // Not an object or array
        if (!is_object($obj) && !is_array($obj)) {
            return $obj;
        }
    
        // Parse array
        foreach ($obj as $key => $value) {
            $arr[$key] = $this->objToArray($value);
        }
    
        // Return parsed array
        return $arr;
    }


    function event(){

        //$email = $this->input->post('email');

        $email = "ajie";
        $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
        inner join peserta as p on e.id_event = p.id_event where  e.mode='event' and p.email='".$email."'")->result();

        // echo "<pre>";
        // print_r($sql);
        // die;
                foreach($sql as $s){
                    $peserta = $this->db->query("select * from jawaban where id_peserta = ".$s->id_peserta)->row();
                    

                    $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and id_event = ".$s->id_event)->result();
                    $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = ".$s->id_kategori)->row();
                    
                    $wak = 0;
                    foreach($waktu as $w){
        
                        $soal[$s->id_event][] = $this->db->query("select * from soalonline where materi_id = ".$w->materi_id)->result();
                        
                        
                        $wak += $w->waktu;
                    }

                    $jumlah_soal = 0;
                    foreach($soal[$s->id_event] as $so){

                        // echo "<pre>";
                        //     print_r($so);

                        foreach($so as $sk){
                            $jumlah_soal += 1;
                        }
                    }

                    if($peserta){
                        $data_data[$s->kategori_nama][] = array(
                            "id_peserta"=>$s->id_peserta,
                            "id_event" => base64_encode($s->id_event),
                            "id_event2" => $s->id_event,
                            'judul'=>$s->judul,
                            'tgl_mulai'=>TanggalIndo($s->tgl_mulai),
                            "tgl_selesai"=>TanggalIndo($s->tgl_selesai),
                            "waktu"=> $wak,
                            'jumlah_soal'=> $jumlah_soal,
                            'waktu_mengerjakan'=>TanggalIndo($s->waktu_mengerjakan).' '. date("H:i:s",strtotime($s->waktu_mengerjakan)),
    
                        );
                    }
                    
                   

                }

                if($data_data){
                    $data2 = array(
                        'status'=>200,
                        'message'=>'sukses',
                        'data'=>$data_data,
                    );
                }else{
                    $data2 = array(
                        'status'=>404,
                        'message'=>'gagal',
                        'data'=>"",
                    );
                }
                echo json_encode($data2);

    }   


    function detail($id_event){

        

        $id_event2 = base64_decode($id_event); 
        
        //$id_event2 = 11;

        
        $sql = $this->db->query("select e.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        inner join materi as m on m.id_event = e.id_event where e.id_event = '".$id_event2."'")->result();

        // echo $id_event2;

        // echo "<pre>";
        // print_r($sql);
        // die;


        foreach($sql as $s){

            $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$s->id_jurusan)->row();
            $jenis = $this->db->query("select * from jenis where id_jenis = ".$jurusan->id_jenis)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = ".$s->materi_id)->result();

           


            $data_api[] = array(
                
                "materi_id" => base64_encode($s->materi_id),
                "materi_nama"=> $s->materi_nama,
                "id_jurusan"=> $s->id_jurusan,
                "waktu"=> $s->waktu,
               "jurusan"=>$jurusan->jurusan_nama,
               'jenis'=>$jenis->jenis_nama,
               'jumlah_soal'=>count($soal),
               
            );
        }


        $jumlah_soal = 0;
        $jumlah_waktu = 0;
        foreach($data_api as $d){
            $jumlah_soal += $d['jumlah_soal'];
            $jumlah_waktu += $d['waktu'];
        }




        $data_api_api = array(
            "id_event"=> $sql[0]->id_event,
            "judul"=> $sql[0]->judul,
            // "tgl_mulai"=> $sql[0]->tgl_mulai,
            // "tgl_selesai"=> $sql[0]->tgl_selesai,

            "tgl_mulai"=> $sql[0]->tgl_mulai_materi,
            "tgl_selesai"=> $sql[0]->tgl_selesai_materi,


            "desc"=> $sql[0]->desc,
            "img"=> $sql[0]->img,
            "status"=> $sql[0]->status,
            "mode"=> $sql[0]->mode,
            "jumlah_soal"=>$jumlah_soal,
            "jumlah_waktu"=>$jumlah_waktu,
            "data"=>$data_api
        );

        echo json_encode($data_api_api);



    }


    function cari_nilai(){
        
         
        $id_event2 = $this->input->post('id_event');

        $id_event = base64_decode($id_event2);
         $email = $this->input->post('email');

         $id_peserta = $this->input->post('id_peserta');

        $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "'.$id_event.'"')->result();

        
        foreach($materi as $m){

          // print_r($m->materi_id);
            $jawaban[] =  $this->db->query('select * from jawaban where id_peserta = "'.$id_peserta.'" and materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();


            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_peserta = "'.$id_peserta.'" and materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();



           

        // echo "<pre>";
        // print_r($soal);
       
        foreach($soal[$m->materi_id] as  $key){
             $key1[] = $key;
        }

            
        }


        


        // echo "<pre>";
        // print_r($key1);

        // die;

          $benar = 0;
        $salah = 0;
        $kosong = 0;
        $skor_benar = 0;
        $skor_salah = 0;
        $skor_gadisi = 0;
      
        foreach($key1 as $key){
             $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));


            if($key->id==$a['ans_'.$key->id]['soal']){
            
                //hitung benar

                // echo $key->id;
                // die;
    
                if($key->jawaban==$a['ans_'.$key->id]['jawaban']){
                   $benar +=  1;
                    $skor_benar += 4;
                
    
                    //  echo "benar";
                }elseif($a['ans_'.$key->id]['jawaban']==0){
                        //ga di isi 
                        $kosong +=  1;
                        $skor_gadisi += 0;
                     
                    //  echo "ga disi";
                }else{
    
                    // echo "salah";
    
                    //salah
                    $skor_salah +=   -1;
                     $salah +=  1;
                   
                }
    
    
            }
        }


        //die;

        //error_reporting(0);

       

        //  echo "<pre>";
        // print_r($soal);

        // // echo "<pre>";
        // // print_r($a);
       // die;

        // $skor = 0;
        // foreach($jawaban as $j){
        //     $skor += $j->skor;
        // }

        $hasil_hasil_nilai = $skor_benar+$skor_gadisi+$skor_salah;

        if($hasil_hasil_nilai <= 0){
            $hasil_hasil_nilai2 = 0;
        }else{
              $hasil_hasil_nilai2 = $hasil_hasil_nilai;
        }

        $data_api = array(
            'skor'=>$hasil_hasil_nilai,

            'skor_benar'=>$skor_benar,
            'skor_gadisi'=>$skor_gadisi,
            'skor_salah'=>$skor_salah,


            'benar'=>$benar,
             'kosong'=>$kosong,
            'salah'=>$salah,
           
            'totalsoal'=>count($key1),
        );

        echo json_encode($data_api);



     }

    // ntr dulu ya
    function event2(){
        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='event'")->result();

         echo "<pre>";
         print_r($sql);
         die;       

        foreach($sql as $s){
               
            
            $materi[$s->id_event] = $this->db->query("select * from materi where publish = 1 and id_event = ".$s->id_event)->result();
          
           
            // echo "<pre>";
            // print_r($materi);
            
            // die;

            foreach($materi[$s->id_event] as $e){

                 $jenis = $this->db->query("select * from jenis where id_kategori = ".$s->id_kategori)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = ".$e->materi_id)->result();

             $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$e->id_jurusan)->row();

             $data[$s->kategori_nama][]  = array(
                    'materi_nama'=>$e->materi_nama,
                     'materi_id'=>$e->materi_id,
                'jenis'=>$jenis->jenis_nama,
                'waktu'=>$e->waktu,
                'soal'=>count($soal),
                'jurusan'=>$jurusan->jurusan_nama,
                
                
                );
            }



         
        }

        $data_api = array(
            'status'=>200,
            'tanggal'=> TanggalIndo($sql[0]->tgl_mulai) .'-'. TanggalIndo($sql[0]->tgl_selesai),
            'event'=>$sql[0]->judul,
            'datanya'=>$data,

        );

        echo json_encode($data_api);
    }


    function pembahasan(){

        error_reporting(0);
       $id_event2 = $this->input->post('id_event');
       $id_peserta = $this->input->post('id_peserta');

        $id_event = base64_decode($id_event2);
         $email = $this->input->post('email');

       $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "'.$id_event.'"')->result();

       // echo "<pre>";
       // print_r($materi);
       foreach($materi as $m){
           $jawaban[] =  $this->db->query('select * from jawaban where id_peserta = "'.$id_peserta.'" and  materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

           $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();
           $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_peserta = "'.$id_peserta.'" and  materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

          
           foreach($soal[$m->materi_id] as $k =>$key){

            $pilihan = json_decode($key->pilihan);

                $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));

                foreach($pilihan as $pi){

                    if($pi->code=='1'){
                        $folder_jawaban = 'jawaban_a';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='2'){
                        $folder_jawaban = 'jawaban_b';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='3'){
                        $folder_jawaban = 'jawaban_c'; 
                        $nama_file_jawaban = $pi->name;   
                    }elseif($pi->code=='4'){
                        $folder_jawaban = 'jawaban_d';
                        $nama_file_jawaban = $pi->name;
                    }elseif($pi->code=='5'){
                        $folder_jawaban = 'jawaban_e';
                        $nama_file_jawaban = $pi->name;
                    }

                    $Path_img_jawaban = base_url("assets/file_upload/soalonline/".$folder_jawaban."/".$nama_file_jawaban);
                    $Path_jawaban = FCPATH.'assets/file_upload/soalonline/'.$folder_jawaban."/".$nama_file_jawaban;
                 
                if($nama_file_jawaban){
                     if (file_exists($Path_jawaban) ){
                        $Path2_jawaban = $Path_img_jawaban;   
                        $type = 'gambar';
                    }else{
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                    }
                }else{
                        $Path2_jawaban =  $pi->name;
                        $type = 'text';
                }
                   


                    $pil[$key->id][] = array(
                        'code'=>$pi->code,
                        'name'=>$Path2_jawaban,
                        'type'=>$type,
                    );
                }


             if($key->id==$a['ans_'.$key->id]['soal']){



                 //  $Path = './assets/file_upload/soalonline/'.$s['img'];
               $Path_img = base_url("assets/file_upload/soalonline/soal/".$key->img);

               $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$key->img;
   
                if (file_exists($Path) ){
                    $Path1 = $key->img;   
                        if($Path1){
                            $Path2 = $Path_img;
                        }else{
                            $Path2 = "";
                        }
                }else{
                    $Path2 = "";
                }


                // pembahasan
                $Path_pembahasan_img = base_url("assets/file_upload/soalonline/pembahasan/".$key->pembahasan_img);

               $Path = FCPATH.'assets/file_upload/soalonline/pembahasan/'.$key->pembahasan_img;
   
                if (file_exists($Path) ){
                    $Path1_pembahasan_img = $key->pembahasan_img;   
                        if($Path1_pembahasan_img){
                            $Path2_pembahasan_img = $Path_pembahasan_img;
                        }else{
                            $Path2_pembahasan_img = "";
                        }
                }else{
                    $Path2_pembahasan_img = "";
                }


            
                $data_data[$key->materi_id][] = array(
                    'id' => $key->id,
                    'materi_id' => $key->materi_id,
                     'materi_nama' => $m->materi_nama,
                    
                    'pertanyaan' => $key->pertanyaan,
                     'img' => $Path2,
  
                    'jawaban' => $key->jawaban,
                    'pilihan' => $pil[$key->id],
                    'pertanyaan_img' => $key->pertanyaan_img,
                     'pembahasan' => $key->pembahasan,
                    'pembahasan_img'=>$Path2_pembahasan_img,
                    'jawaban_anda'=>$a['ans_'.$key->id]['jawaban'],
              );
                
                
    
            }

              
           }


           $data_api[] = array(
            $m->materi_id=>$data_data[$m->materi_id],
               
           );
       }

       echo json_encode($data_api);


     }



     function latihan(){
        $sql = $this->db->query("select m.*,j.id_jawaban,j.mode,j.create_add from materi as m 
        inner join jawaban as j on j.materi_id = m.materi_id where email = 'tes' and j.mode=2")->result();

        foreach($sql as $s){

            $event = $this->db->query("select * from event where id_event = ".$s->id_event)->row();
            $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$s->id_jurusan)->row();
            $jenis = $this->db->query("select * from jenis where id_jenis = ".$jurusan->id_jenis)->row();

            $kategori = $this->db->query("select * from kategori where id_kategori = ".$jenis->id_kategori)->row();



            $soal = $this->db->query("select * from soalonline where materi_id = ".$s->materi_id)->result();


            $data_api[$kategori->kategori_nama][] = array(
                'kategori'=>$kategori->kategori_nama,
                'judul'=>$event->judul,
                "materi_id" => base64_encode($s->materi_id),
                "materi_nama" => $s->materi_nama,
                "jurusan"=>$jurusan->jurusan_nama,
                'jenis'=>$jenis->jenis_nama,
                "waktu" => $s->waktu,
                "jumlah_soal" => $s->tgl_selesai,
                'jumlah_soal'=>count($soal),
                'id_jawaban'=>$s->id_jawaban,
                'waktu_pengerjaan'=>TanggalIndo($s->create_add).' '. date('H:i:s',strtotime($s->create_add))
               
            );
        }


        $data_api2 = array(
            'status'=>200,
            'message'=>'sukses',
            'datanya'=>$data_api,
        );

        echo json_encode($data_api2);

     }


     function cari_nilai_materi(){
        

       
        $email = $this->input->post('email');
        $id_jawaban = $this->input->post('id_jawaban');
 
        $id_jawaban_s =  $this->db->query('select * from jawaban where id_jawaban =  "'.$id_jawaban.'"')->row();
        $materi =  $this->db->query('select * from materi where publish = 1 and materi_id =  "'.$id_jawaban_s->materi_id.'"')->result();
         
 
         
         foreach($materi as $m){
 
           // print_r($m->materi_id);
             $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();
 
             $soal[$m->materi_id] =  $this->db->query('select * from soalonline where  materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();
 
 
             $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where  id_jawaban = "'.$id_jawaban.'" and materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();
 
         // echo "<pre>";
         // print_r($soal);
        
         foreach($soal[$m->materi_id] as  $key){
              $key1[] = $key;
         }
 
             
         }
 
 
 
         $benar = 0;
         $salah = 0;
         $kosong = 0;
         $skor_benar = 0;
         $skor_salah = 0;
         $skor_gadisi = 0;
       
         foreach($key1 as $key){
              $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));
 
 
             if($key->id==$a['ans_'.$key->id]['soal']){
             
                 //hitung benar
 
                 // echo $key->id;
                 // die;
     
                 if($key->jawaban==$a['ans_'.$key->id]['jawaban']){
                    $benar +=  1;
                     $skor_benar += 4;
                 
     
                     //  echo "benar";
                 }elseif($a['ans_'.$key->id]['jawaban']==0){
                         //ga di isi 
                         $kosong +=  1;
                         $skor_gadisi += 0;
                      
                     //  echo "ga disi";
                 }else{
     
                     // echo "salah";
     
                     //salah
                     $skor_salah +=   -1;
                      $salah +=  1;
                    
                 }
     
     
             }
         }
 
 
         //die;
 
         //error_reporting(0);
 
        
 
         //  echo "<pre>";
         // print_r($soal);
 
         // // echo "<pre>";
         // // print_r($a);
        // die;
 
         // $skor = 0;
         // foreach($jawaban as $j){
         //     $skor += $j->skor;
         // }
 
         $hasil_hasil_nilai = $skor_benar+$skor_gadisi+$skor_salah;
 
         if($hasil_hasil_nilai <= 0){
             $hasil_hasil_nilai2 = 0;
         }else{
               $hasil_hasil_nilai2 = $hasil_hasil_nilai;
         }
 
         $data_api = array(
             'skor'=>$hasil_hasil_nilai,
 
             'skor_benar'=>$skor_benar,
             'skor_gadisi'=>$skor_gadisi,
             'skor_salah'=>$skor_salah,
 
 
             'benar'=>$benar,
              'kosong'=>$kosong,
             'salah'=>$salah,
            
             'totalsoal'=>count($key1),
         );
 
         echo json_encode($data_api);
 
 
 
      }



      function pembahasan_materi(){

        $email = $this->input->post('email');
        $id_jawaban = $this->input->post('id_jawaban');
     
        //$email = $this->input->post('email');

        $id_jawaban_s =  $this->db->query('select * from jawaban where id_jawaban =  "'.$id_jawaban.'"')->row();
 
        $materi =  $this->db->query('select * from materi where publish = 1 and materi_id =  "'.$id_jawaban_s->materi_id.'"')->result();
 
        // echo "<pre>";
        // print_r($materi);

        // die;
        foreach($materi as $m){
            $jawaban[] =  $this->db->query('select * from jawaban where materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();
 
            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();
            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_jawaban = "'.$id_jawaban.'" and materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();
 
           
            foreach($soal[$m->materi_id] as $k =>$key){
 
             $pilihan = json_decode($key->pilihan);
             $a = $this->objToArray(json_decode($jawaban_skor[$key->materi_id]->jawaban, true));
                 
 
                 foreach($pilihan as $pi){
 
                     if($pi->code=='1'){
                         $folder_jawaban = 'jawaban_a';
                         $nama_file_jawaban = $pi->name;
                     }elseif($pi->code=='2'){
                         $folder_jawaban = 'jawaban_b';
                         $nama_file_jawaban = $pi->name;
                     }elseif($pi->code=='3'){
                         $folder_jawaban = 'jawaban_c'; 
                         $nama_file_jawaban = $pi->name;   
                     }elseif($pi->code=='4'){
                         $folder_jawaban = 'jawaban_d';
                         $nama_file_jawaban = $pi->name;
                     }elseif($pi->code=='5'){
                         $folder_jawaban = 'jawaban_e';
                         $nama_file_jawaban = $pi->name;
                     }
 
                     $Path_img_jawaban = base_url("assets/file_upload/soalonline/".$folder_jawaban."/".$nama_file_jawaban);
                     $Path_jawaban = FCPATH.'assets/file_upload/soalonline/'.$folder_jawaban."/".$nama_file_jawaban;
                  
                 if($nama_file_jawaban){
                      if (file_exists($Path_jawaban) ){
                         $Path2_jawaban = $Path_img_jawaban;   
                         $type = 'gambar';
                     }else{
                         $Path2_jawaban =  $pi->name;
                         $type = 'text';
                     }
                 }else{
                         $Path2_jawaban =  $pi->name;
                         $type = 'text';
                 }
                    
 
 
                     $pil[$key->id][] = array(
                         'code'=>$pi->code,
                         'name'=>$Path2_jawaban,
                         'type'=>$type,
                     );
                 }
 
 
              if($key->id==$a['ans_'.$key->id]['soal']){
 
 
 
                  //  $Path = './assets/file_upload/soalonline/'.$s['img'];
                $Path_img = base_url("assets/file_upload/soalonline/soal/".$key->img);
 
                $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$key->img;
    
                 if (file_exists($Path) ){
                     $Path1 = $key->img;   
                         if($Path1){
                             $Path2 = $Path_img;
                         }else{
                             $Path2 = "";
                         }
                 }else{
                     $Path2 = "";
                 }
 
 
                 // pembahasan
                 $Path_pembahasan_img = base_url("assets/file_upload/soalonline/pembahasan/".$key->pembahasan_img);
 
                $Path = FCPATH.'assets/file_upload/soalonline/pembahasan/'.$key->pembahasan_img;
    
                 if (file_exists($Path) ){
                     $Path1_pembahasan_img = $key->pembahasan_img;   
                         if($Path1_pembahasan_img){
                             $Path2_pembahasan_img = $Path_pembahasan_img;
                         }else{
                             $Path2_pembahasan_img = "";
                         }
                 }else{
                     $Path2_pembahasan_img = "";
                 }
 
 
             
                 $data_data[$key->materi_id][] = array(
                     'id' => $key->id,
                     'materi_id' => $key->materi_id,
                      'materi_nama' => $m->materi_nama,
                     
                     'pertanyaan' => $key->pertanyaan,
                      'img' => $Path2,
   
                     'jawaban' => $key->jawaban,
                     'pilihan' => $pil[$key->id],
                     'pertanyaan_img' => $key->pertanyaan_img,
                      'pembahasan' => $key->pembahasan,
                     'pembahasan_img'=>$Path2_pembahasan_img,
                     'jawaban_anda'=>$a['ans_'.$key->id]['jawaban'],
               );
                 
                 
     
             }
 
               
            }
 
 
            $data_api[] = array(
             $m->materi_id=>$data_data[$m->materi_id],
                
            );
        }
 
        echo json_encode($data_api);
 
 
      }


      function event_ranking(){

        $email = $this->input->post('email');

        //$email = "ajie";
        $sql = $this->db->query("select p.id_peserta,p.create_add as waktu_mengerjakan,  e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
        inner join peserta as p on e.id_event = p.id_event where  e.mode='event' and p.email='".$email."'")->result();

                foreach($sql as $s){


                    $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and id_event = ".$s->id_event)->result();
                    $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = ".$s->id_kategori)->row();
                    
                    $wak = 0;
                    foreach($waktu as $w){
        
                        $soal[$s->id_event][] = $this->db->query("select * from soalonline where materi_id = ".$w->materi_id)->result();
                        
                        
                        $wak += $w->waktu;
                    }

                    $jumlah_soal = 0;
                    foreach($soal[$s->id_event] as $so){

                        // echo "<pre>";
                        //     print_r($so);

                        foreach($so as $sk){
                            $jumlah_soal += 1;
                        }
                    }
                    
                    $data_data[$s->kategori_nama] = array(
                        "id_peserta"=>$s->id_peserta,
                        "id_event" => base64_encode($s->id_event),
                        "id_event2" => $s->id_event,
                        'judul'=>$s->judul,
                        'tgl_mulai'=>TanggalIndo($s->tgl_mulai),
                        "tgl_selesai"=>TanggalIndo($s->tgl_selesai),
                        "waktu"=> $wak,
                        'jumlah_soal'=> $jumlah_soal,
                         'waktu_mengerjakan'=>TanggalIndo($s->waktu_mengerjakan).' '. date("H:i:s",strtotime($s->waktu_mengerjakan)),


                    );

                }

                if($data_data){
                    $data2 = array(
                        'status'=>200,
                        'message'=>'sukses',
                        'data'=>$data_data,
                    );
                }else{
                    $data2 = array(
                        'status'=>404,
                        'message'=>'gagal',
                        'data'=>"",
                    );
                }
                echo json_encode($data2);

    } 
 



    

   

    
    
}
