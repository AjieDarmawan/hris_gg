<?php

defined('BASEPATH') or exit('No direct script access allowed');

Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');

class Api extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        // if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
        //  redirect('auth');
        // }
        // $this->load->model(array('auth/auth_model'));

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    }

    function soal_latihan()
    {



        $data_api = array(
            'kode' => 001,
            'message' => "sukses",
            'listdata' => array(
                'dari' => 1,
                'hingga' => 3,
                'totaldata' => 3,
                'totalhalaman' => 1,
                'datanya' => array(
                    '0' => array(
                        'no' => 1,
                        'ccid' => "Nnc9PQb93bbfb93bbf",
                        'pertanyaan' => "Logika  fuzzy  dengan  cepat  telah  menjadi salah  satu  yang  paling  sukses  dari  teknologi  saat  ini untuk mengembangkan sistem kontrol yang canggih. Alasan yang tepat adalah",
                        'img' => 'https://api.edulearning.me/dokumen/soal?ccid=emc9PQb93bbfb93bbf&cid=ajhyTjJXSkxDZUE9"',
                        'pilihan' => array(
                            '0' => array(
                                'code' => 633,
                                'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi atau perkiraan."
                            ),

                            '1' => array(
                                'code' => 631,
                                'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang agak tepat dari informasi tertentu atau perkiraan."
                            ),

                            '2' => array(
                                'code' => 632,
                                'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang  tepat dari informasi tertentu atau perkiraan."
                            ),

                            '3' => array(
                                'code' => 634,
                                'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan  perkiraan."
                            ),

                        ),

                    ),


                    '1' => array(
                        'no' => 2,
                        'ccid' => "Nnc9PQb93bbfb93bbf",
                        'pertanyaan' => "Logika  fuzzy  dengan  cepat  telah  menjadi salah  satu  yang  paling  sukses  dari  teknologi  saat  ini untuk mengembangkan sistem kontrol yang canggih. Alasan yang tepat adalah",
                        'img' => 'https://api.edulearning.me/dokumen/soal?ccid=emc9PQb93bbfb93bbf&cid=ajhyTjJXSkxDZUE9"',
                        'pilihan' => array(
                            '0' => array(
                                'code' => 633,
                                'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi atau perkiraan."
                            ),

                            '1' => array(
                                'code' => 631,
                                'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang agak tepat dari informasi tertentu atau perkiraan."
                            ),

                            '2' => array(
                                'code' => 632,
                                'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan solusi yang  tepat dari informasi tertentu atau perkiraan."
                            ),

                            '3' => array(
                                'code' => 634,
                                'name' => "Logika fuzzy memungkinkan kemampuan untuk menghasilkan  perkiraan."
                            ),

                        ),

                    ),





                ),

                'waktunya' => 15
            )
        );

        echo json_encode($data_api);
    }


    function soal($materi_id)
    {

        $materi_id2 = base64_decode($materi_id);


          $materi_ = $this->db->query('select * from materi where publish = 1 and materi_id = "' . $materi_id2 . '"')->row();

        $soal = $this->db->query('select * from soalonline where materi_id = "' . $materi_id2 . '"')->result_array();


        // echo "<pre>";
        // print_r($soal);

        // die;

         foreach($soal as $s){

           


            $pilihan = json_decode($s['pilihan']);

                

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
             
        
                if (file_exists($Path_jawaban) ){
                    $Path2_jawaban = $Path_img_jawaban;   
                    $type = 'gambar';
                }else{
                    $Path2_jawaban =  $pi->name;
                    $type = 'text';
                }

                


                $pil[$s['id']][] = array(
                    'code'=>$pi->code,
                    'name'=>$Path2_jawaban,
                    'type'=>$type,
                );
            }

            $Path_img = base_url("assets/file_upload/soalonline/soal/".$s['img']);

            $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$s['img'];

             if (file_exists($Path) ){
                 $Path1 = $s['img'];   
                     if($Path1){
                         $Path2 = $Path_img;
                     }else{
                         $Path2 = "";
                     }
             }else{
                 $Path2 = "";
             }

          
            $data_soal[] = array(
                'no' => $s['id'],
                'ccid' => "Nnc9PQb93bbfb93bbf",
                'pertanyaan' => $s['pertanyaan'],
                'img' => $Path2,
                'pilihan' => $pil[$s['id']],
                'pembahasan'=>$s['pembahasan'],
               
            );
        }


        $data_api = array(
            'kode' => 1,
            'message' => 'sukses',
            'listdata' => array(
                "dari" => 1,
                "hingga" => count($data_soal),
                "totaldata" => count($data_soal),
                "totalhalaman" => 1,

                'materi_nama'=>$materi_->materi_nama,
                "datanya" => $data_soal,
                'waktu' => 40,
            )
        );

        echo json_encode($data_api);
    }


    function soal_preview($materi_id)
    {

        $materi_id2 = base64_decode($materi_id);


          $materi_ = $this->db->query('select * from materi where   materi_id = "' . $materi_id2 . '"')->row();

        $soal = $this->db->query('select * from soalonline where materi_id = "' . $materi_id2 . '"')->result_array();


        // echo "<pre>";
        // print_r($soal);

        // die;

         foreach($soal as $s){

           


            $pilihan = json_decode($s['pilihan']);

                

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
             
        
                if (file_exists($Path_jawaban) ){
                    $Path2_jawaban = $Path_img_jawaban;   
                    $type = 'gambar';
                }else{
                    $Path2_jawaban =  $pi->name;
                    $type = 'text';
                }

                


                $pil[$s['id']][] = array(
                    'code'=>$pi->code,
                    'name'=>$Path2_jawaban,
                    'type'=>$type,
                );
            }

            $Path_img = base_url("assets/file_upload/soalonline/soal/".$s['img']);

            $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$s['img'];

             if (file_exists($Path) ){
                 $Path1 = $s['img'];   
                     if($Path1){
                         $Path2 = $Path_img;
                     }else{
                         $Path2 = "";
                     }
             }else{
                 $Path2 = "";
             }

          
            $data_soal[] = array(
                'no' => $s['id'],
                'ccid' => "Nnc9PQb93bbfb93bbf",
                'pertanyaan' => $s['pertanyaan'],
                'img' => $Path2,
                'pilihan' => $pil[$s['id']],
                'pembahasan'=>$s['pembahasan'],
               
            );
        }


        $data_api = array(
            'kode' => 1,
            'message' => 'sukses',
            'listdata' => array(
                "dari" => 1,
                "hingga" => count($data_soal),
                "totaldata" => count($data_soal),
                "totalhalaman" => 1,

                'materi_nama'=>$materi_->materi_nama,
                "datanya" => $data_soal,
                'waktu' => 40,
            )
        );

        echo json_encode($data_api);
    }


    function event()
    {

        error_reporting(0);
        header('Access-Control-Allow-Origin: *');
        // header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Content-Type: application/json');

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");




        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='event'")->result();


        $hariini = date('Y-m-d');

        //$hariini = '2022-03-06';

         foreach($sql as $key => $s){


         


            // $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and id_event = ".$s->id_event)->result();
            // $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = ".$s->id_kategori)->row();




            // $wak = 0;
            // foreach($waktu as $w){

            //     $soal[] = $this->db->query("select * from soalonline where materi_id = ".$w->materi_id)->result();
            //     // $jumlah_soal = 0;
            //     // foreach($soal as $so){
            //     //     $jumlah_soal += count($soal);
            //     // }
                
            //     $wak += $w->waktu;
            // }

            // $j_soal = 0;
            // foreach($soal as $k){
            //     $j_soal += count($k);
            // }



            if ($hariini >= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {

                      $waktu = $this->db->query("select waktu,materi_id from materi where publish = 1 and id_event = ".$s->id_event)->result();
                $kategori = $this->db->query("select kategori_nama from kategori where id_kategori = ".$s->id_kategori)->row();
    
    
    
                // $soal = $this->db->query("select * from soalonline where materi_id = ".$s->materi_id)->result();
    
    
    
    
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

                    if($jumlah_soal!=0){
                         $data_api[] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => TanggalIndo($s->tgl_mulai),
                        "tgl_selesai" => TanggalIndo($s->tgl_selesai),
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                        // "materi_id" => $s->materi_id,
                        // "materi_nama"=> $s->materi_nama,
                        // "id_jurusan"=> $s->id_jurusan,
                        "waktu" => $wak,
                        //"jurusan"=>$jurusan->jurusan_nama,
                        'jenis' => $s->jenis_nama,
                        'kategori'=>$kategori->kategori_nama,
                         'jumlah_soal'=> $jumlah_soal,
                    );
                    }


                   
                }
            }
        }

        if($data_api){

            $data_api_sukses = array(
                'status'=>200,
                'message'=>"sukses",
                'datanya'=>$data_api
            );
            echo json_encode($data_api_sukses);

           // echo json_encode($data_api);
        }else{
            $data_api_error = array(
                'status'=>400,
                'message'=>"data kosong",
            );
            echo json_encode($data_api_error);
        }
    }


    function latihan()


    {

        error_reporting(0);
          $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' group by e.judul,e.tgl_mulai,e.tgl_selesai")->result();

        // echo "<pre>";
        // print_r($sql);
        // die;

        foreach ($sql as $s) {

            


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            if ($hariini >= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {
                    $data_api[] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => TanggalIndo($s->tgl_mulai),
                        "tgl_selesai" => TanggalIndo($s->tgl_selesai),
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                       
                    );
                }
            }
        }

        if($data_api){

            $data_api_sukses = array(
                'status'=>200,
                'message'=>"sukses",
                'datanya'=>$data_api
            );
            echo json_encode($data_api_sukses);

           // echo json_encode($data_api);
        }else{
            $data_api_error = array(
                'status'=>400,
                'message'=>"data kosong",
            );
            echo json_encode($data_api_error);
        }

        
    }



    function detail($id_event)
    {

        $id_event2 = base64_decode($id_event);
        $sql = $this->db->query("select e.*,m.tgl_mulai as tgl_mulai_materi,m.tgl_selesai as tgl_selesai_materi,m.materi_id,m.materi_nama,m.id_jurusan,m.waktu from event as e
        inner join materi as m on m.id_event = e.id_event where m.publish = 1 and e.id_event = '" . $id_event2 . "' order by m.no_urut asc")->result();

       
        foreach($sql as $s){

            $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$s->id_jurusan)->row();


            $jenis = $this->db->query("select * from jenis where id_jenis = ".$jurusan->id_jenis)->row();

              $kategori = $this->db->query("select * from kategori where id_kategori = ".$s->id_kategori)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = ".$s->materi_id)->result();

           


            $data_api[] = array(
                
                "materi_id" => base64_encode($s->materi_id),
                "materi_nama"=> $s->materi_nama,
                "id_jurusan"=> $s->id_jurusan,
                "waktu"=> $s->waktu,
               "jurusan"=>$jurusan->jurusan_nama,
               'jenis'=>$jenis->jenis_nama,
               'jenis_label'=>$jenis->label,
              
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

            "tgl_mulai"=> TanggalIndo($sql[0]->tgl_mulai_materi),
            "tgl_selesai"=> TanggalIndo($sql[0]->tgl_selesai_materi),
             'kategori'=>$kategori->kategori_nama,


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


    function jawaban()
    {
        header('Content-type: application/json');
        // {
        //     "ccid":"N0E9PQb93bbfb93bbf",
        //     "ans_Nnc9PQb93bbfb93bbf":{
        //         "ans":"633",
        //         "time":""
        //     },
        //     "ans_NkE9PQb93bbfb93bbf":{
        //         "ans":"4233",
        //         "time":""
        //     },
        //     "ans_NlE9PQb93bbfb93bbf":{
        //         "ans":"4254",
        //         "time":""
        //     }
        // }



        // $data_array =array(
        //     'ccid'=>"N0E9PQb93bbfb93bbf",
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        //     'ans_Nnc9PQb93bbfb93bbf'=>array(
        //         "ans"=>"633",
        //         "time"=>""
        //     ),
        // );


        $email = $this->input->post('email');
         $tgl_mulai = $this->input->post('tgl_mulai');
        $data_array2 = $this->input->post('res');

        $id_peserta = $this->input->post('id_peserta');


        //       $data_array2 = $_POST;

        // echo "<pre>";
        // print_r($data_array2);
        // die;

        $data_array =  (array)json_decode($data_array2);



        //  $data_array =array(
        //      'materi_id'=>"22",
        //      'jawabannya'=>array(
        //       array(
        //          'soal'=>192,
        //          'jawaban'=>'5'
        //      ),
        //      array(
        //          'soal'=>191,
        //          'jawaban'=>'2'
        //      ),
        //      array(
        //          'soal'=>190,
        //          'jawaban'=>'3'
        //      ),
        //      array(
        //          'soal'=>189,
        //          'jawaban'=>'4'
        //      ),

        //   )
        //  );

       //echo json_encode($data_array);
        // echo "<pre>";
        // print_r($data_array);
        // die;


        $sql_soal = $this->db->query('select * from soalonline where materi_id = ' . $data_array['materi_id'])->result();

        $event = $this->db->query('select id_event from materi where publish = 1 and materi_id = ' . $data_array['materi_id'])->row();



        //    echo "<pre>";
        //    print_r($event);

        //    die;


        $total_nilai = 0;
        $benar = 0;
        $salah = 0;
        $kosong = 0;
        foreach ($sql_soal as $s => $key) {





            if ($key->id == $data_array['ans_' . $key->id]->soal) {

                //hitung benar

                if ($key->jawaban == $data_array['ans_' . $key->id]->jawaban) {
                    $total_nilai +=  4;
                    $benar += 1;

                    //  echo "benar";
                } elseif ($data_array['ans_' . $key->id]->jawaban == 0) {
                    //ga di isi 
                    $total_nilai +=  0;
                      $kosong += 1;
                    //  echo "ga disi";
                } else {

                    // echo "salah";

                    //salah
                    $total_nilai +=   -1;
                    $salah += 1;
                }
            }
        }


          // if($total_nilai<=0){
          //       $total_nilai2 = 0;
          //   }else{
          //       $total_nilai2 = $total_nilai;
          //   }
        $data_jawaban = array(
            'materi_id' => $data_array['materi_id'],
            'jawaban' => json_encode($data_array),
            //'jawaban'=>$data_array,
            'skor' => $total_nilai,
            'create_add' => date('Y-m-d H:i:s'),
            'email' => $email,
            'id_event' => $event->id_event,
            'tgl_mulai'=>$tgl_mulai,
            'mode'=>2,
            'benar'=>$benar,
            'salah'=>$salah,
            'kosong'=>$kosong,
           // 'id_peserta'=>$id_peserta,
        );

        $q = $this->db->insert('jawaban', $data_jawaban);

        $id_jawaban_h = $this->db->insert_id();


        if ($q) {
            $data_api = array(
                'status' => 200,
                'message' => 'suksess',
                'skor' => $total_nilai,
                'id_jawaban'=>$id_jawaban_h,
            );
        }

        echo json_encode($data_api);
    }


    function login()
    {
        error_reporting(0);
        $email   = $this->input->post('email');
        $mypassword = $this->input->post('password');
        $users = $this->db->query('select * from edu_apps.app_userdata where email  = "'.$email.'"')->row();

        $info = $this->db->query('select * from edu_apps.edu_userinfo where email  = "'.$email.'"')->row();


        // echo "<pre>";
        // print_r($info);
        // die;


       

        if ($users) {

            $dbpassword = $users->password;
        
            $password = sha1(md5($mypassword));


            if($dbpassword == $password){
                if ($users->userstatus == 1) {
                $data['status'] = 200;
                $data['message'] = "success";
                $data['key'] = $users->keycode;
                $data['email'] = $users->email;
                $data['nama'] = $info->namalengkap;
                $data['no_wa'] = $info->nowa;
                $data['no_tlp'] = $info->notlp;


             } else if ($users->userstatus == 2) {
                $data['status'] = 300;
                $data['message'] = "Anda Belum Reset Password";
                $data['key'] = $users->keycode;
                $data['email'] = $users->email;
                }
            }else {
                $data['status'] = 405;
                $data['message'] = "email/password anda salah";
                $data['key'] = "`12345";
                $data['email'] = "12345";
            }
        } else {
            $data['status'] = 405;
            $data['message'] = "Akun Anda Belum Aktif";
            $data['key'] = "`12345";
            $data['email'] = "12345";
        }

        echo json_encode($data);
    }



    //soal event

    function soal_event($id_event)
    {

        $id_event2 = base64_decode($id_event);



        $materi = $this->db->query('select materi_id,materi_nama,waktu from  materi where id_event = "'.$id_event2.'" order by no_urut asc')->result_array();




        foreach ($materi as $m) {
            $soal = $this->db->query('select * from soalonline where materi_id = "'.$m['materi_id'].'"  ORDER BY RAND()')->result_array();



            foreach ($soal as $s) {
                $pilihan = json_decode($s['pilihan']);

                

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
                   


                    $pil[$s['id']][] = array(
                        'code'=>$pi->code,
                        'name'=>$Path2_jawaban,
                        'type'=>$type,
                    );
                }


               //  $Path = './assets/file_upload/soalonline/'.$s['img'];
               $Path_img = base_url("assets/file_upload/soalonline/soal/".$s['img']);

               $Path = FCPATH.'assets/file_upload/soalonline/soal/'.$s['img'];
                
           
                if (file_exists($Path) ){
                    $Path1 = $s['img'];   
                        if($Path1){
                            $Path2 = $Path_img;
                        }else{
                            $Path2 = "";
                        }
                }else{
                    $Path2 = "";
                }

                 $data_soal[$m['materi_id']][] = 
                    array(
                        'no' => $s['id'],
                        //'materi_id' => $s['materi_id'],
                        'pertanyaan' => $s['pertanyaan'],
                        // 'img' => base_url('assets/file_upload/soalonline/' . $s['img']),
                        'img' => $Path2,
                        'pilihan'=>$pil[$s['id']], 
                    );
            }

            $j_materi_id[] = array(
                'materi_id' => base64_encode($m['materi_id']),
                'materi_nama'=>$m['materi_nama'],
               'datanya'=>$data_soal[$m['materi_id']],
                "totalhalaman" => 1,
                 "hingga"=> count($soal),
                  "totaldata"=> count($soal),
                'waktu' => $m['waktu'],
               // 'waktu' => 1,
            );
        }

        $data_api = array(
            'kode' => 1,
            'message' => 'sukses',
            'listdata' => array(
                "dari" => 1,
                "datanya" => $j_materi_id,

            )
        );

        echo json_encode($data_api);
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

  function sortAssociativeArrayByKey($array, $key, $direction){

        switch ($direction){
            case "ASC":
                usort($array, function ($first, $second) use ($key) {
                    return $first[$key] <=> $second[$key];
                });
                break;
            case "DESC":
                usort($array, function ($first, $second) use ($key) {
                    return $second[$key] <=> $first[$key];
                });
                break;
            default:
                break;
        }
    
        return $array;
    } 


    function jawaban_event()
    {
        header('Content-type: application/json');
        // $data_array =array(
        //    'event'=>'18',
        //    'datanya'=>  array(
        //        'mat_18'=>  array(
        //         'materi_id'=>"18",
        //          'ans_192'=>   array(
        //                 'soal'=>192,
        //                 'jawaban'=>'5'
        //             ),
        //             'ans_191'=>  array(
        //                 'soal'=>191,
        //                 'jawaban'=>'2'
        //             ),
        //             'ans_190'=>  array(
        //                 'soal'=>190,
        //                 'jawaban'=>'3'
        //             ),
        //             'ans_189'=>  array(
        //                 'soal'=>189,
        //                 'jawaban'=>'4'
        //             ),

        //     ),


        //     'mat_19'=>  array(
        //         'materi_id'=>"19",

        //          'ans_193'=>   array(
        //                 'soal'=>193,
        //                 'jawaban'=>'2'
        //             ),
        //             'ans_194'=>  array(
        //                 'soal'=>194,
        //                 'jawaban'=>'5'
        //             ),
        //             'ans_195'=>  array(
        //                 'soal'=>195,
        //                 'jawaban'=>'5'
        //             ),
        //             'ans_196'=>  array(
        //                 'soal'=>196,
        //                 'jawaban'=>'2'
        //             ),


        //     ),

        //     ),

        // );




        // echo json_encode($data_array);

        // die;

        // echo "<pre>";
        // print_r($data_array['datanya']);

        // die;

        $email = $this->input->post('email');
        $data_array2 = $this->input->post('res');
        $tgl_mulai = $this->input->post('tgl_mulai');
        $id_peserta = $this->input->post('id_peserta');

          


        // echo "<pre>";
        // print_r($data_array2);
        // die;


        //$data_array =  (array)json_decode($data_array2);
        $data_array = $this->objToArray(json_decode($data_array2, true));
        //


        //  echo "<pre>";
        // print_r($data_array);
        // die;

        $total_nilai_perevent = 0;
        foreach ($data_array['datanya'] as  $a) {

            // echo "<pre>";
            // print_r($a['materi_id']);
            // die;

            $sql_soal = $this->db->query('select * from soalonline where materi_id = ' . base64_decode($a['materi_id']))->result();


             // echo "<pre>";
             //       print_r($a->ans_191);
             //       die;


            $total_nilai = 0;

            $benar = 0;
            $salah = 0;
            $kosong = 0;
            foreach ($sql_soal as $s => $key) {

                

                if($key->id==$a['ans_'.$key->id]['soal']){
            
                        //hitung benar
            
                        if($key->jawaban==$a['ans_'.$key->id]['jawaban']){
                            $total_nilai +=  4;
                            $benar += 1;
            
                            //  echo "benar";
                        }elseif($a['ans_'.$key->id]['jawaban']==0){
                                //ga di isi 
                                $total_nilai +=  0;
                                 $kosong += 1;
                            //  echo "ga disi";
                        }else{
            
                            // echo "salah";
            
                            //salah
                            $total_nilai +=   -1;
                            $salah = 1;
                        }
            
            
                        }

                         $cari_user = $this->db->query('select * from jawaban where email="'.$email.'" and materi_id="'.$key->materi_id.'"')->row();
             
                        if($cari_user){
                            $mode =3;
                        }else{
                            $mode = 1;
                        }



            }

            // if($total_nilai<=0){
            //     $total_nilai2 = 0;
            // }else{
            //     $total_nilai2 = $total_nilai;
            // }

            $data_jawaban = array(
                'materi_id' => base64_decode($a['materi_id']),
                'jawaban' => json_encode($a),
                //'jawaban'=>$data_array,
                'skor' => $total_nilai,
                'create_add' => date('Y-m-d H:i:s'),
                'email' => $email,
                'id_event' => $data_array['event'],
                'tgl_mulai'=>$tgl_mulai,
                'mode'=>$mode,
                'benar'=>$benar,
                'kosong'=>$kosong,
                'salah'=>$salah,
                'id_peserta'=>$id_peserta,
            );

            $q = $this->db->insert('jawaban', $data_jawaban);

            $total_nilai_perevent += $total_nilai;
        }


        if ($q) {
            $data_api = array(
                'status' => 200,
                'message' => 'suksess',
                'skor' => $total_nilai_perevent,
            );

            echo json_encode($data_api);
        }
    }



     function list_skor(){

        //cari nama 

        error_reporting(0);

        $id_event2 = $this->input->post('id_event');
        $id_event = base64_decode($id_event2);
        $email = $this->input->post('email');


         $user = $this->db->query('select id_peserta,email,id_event,materi_id from jawaban where id_event = "'.$id_event.'"  and mode = 1 group by email')->result();


        // echo "<pre>";
        // print_r($user);
        // die;

        //looping cari nama
        foreach($user as $u){
                     
                    //cari materi nya apa aja
                    $event_materi = $this->db->query('select * from event as e inner join materi as m on e.id_event = m.id_event where m.publish = 1 m.id_event = "'.$id_event.'"' )->result();

                    // echo "<pre>";
                    // print_r($event_materi);

                    // die;

                    //dillooping materinya cari skor
                    
                    foreach($event_materi as $e)
                    {
                        $jawaban[$u->email][] = $this->db->query('select * from jawaban where materi_id = "'.$e->materi_id.'" and mode = 1  and email = "'.$u->email.'" order by id_jawaban asc')->row();
                        

                       
                    
                    }


                  
                     $skor = 0;
                      foreach($jawaban[$u->email] as $j){
                        $skor += $j->skor;
                      }

                 $sekolah[$u->email] = $this->db->query('select asal_sekolah,nama from peserta where id_peserta="'.$u->id_peserta.'"')->row();     
                 $event = $this->db->query('select judul from event where id_event='.$u->id_event)->row();     


                 $waktu_awal        =strtotime($jawaban[$u->email][0]->tgl_mulai);
                 $waktu_akhir    =strtotime($jawaban[$u->email][0]->create_add); // bisa juga waktu sekarang now()
                 
                 //menghitung selisih dengan hasil detik
                 $diff    =$waktu_akhir - $waktu_awal;

                 $data_api[] = array(
                     'email'=>$u->email,
                     'event'=>$event->judul,
                     'skor'=>$skor,
                     'waktu'=>floor($diff/60),
                     //'asal_sekolah'=>$sekolah[$u->email],
                   // 'jawaban'=>$jawaban[$u->email],
                     'waktu_pengerjaan'=> TanggalIndo(date('Y-m-d',strtotime($jawaban[$u->email][0]->tgl_mulai))) .' '.date('H:i:s',strtotime($jawaban[$u->email][0]->tgl_mulai)),
                    
                 );


                 
        }


        foreach($data_api as $a){

            // if($a['skor']==$a['skor']){
                
            // }else{

            // }
            $data_api_api[] = array(
                'email'=>$a['email'],
                'nama'=>$sekolah[$a['email']]->nama,
                'event'=>$a['event'],
                'skor'=>$a['skor'],
                'waktu'=>$a['waktu'],
                'asal_sekolah'=>$sekolah[$a['email']]->asal_sekolah,
                'waktu_pengerjaan'=>$a['waktu_pengerjaan'],
            );
        }

        $sort_by_skor = $this->sortAssociativeArrayByKey($data_api_api,'skor','DESC');


        

        echo json_encode($sort_by_skor);
       
        // foreach($sort_by_skor as $s){
        //     $data_api_api_skor[] = array(
        //         'email'=>$s['email'],
        //         'event'=>$s['event'],
        //         'skor'=>$s['skor'],
        //         'waktu'=>$s['waktu'],
        //     );
        // }

        // $sort_by_skor_and_waktu = $this->sortAssociativeArrayByKey($data_api_api_skor,'waktu','ASC');

        // echo json_encode($sort_by_skor);
        // die;
        

        // echo json_encode($data_api_api);

 
     }


    // function list_skor(){

    //     $id_event2 = $this->input->post('id_event');
    //     $id_event = base64_decode($id_event2);
    //     $email = $this->input->post('email');


    //     //cari nama 
    //     $user = $this->db->query('select email,id_event,materi_id from jawaban where id_event = "'.$id_event.'"  and mode = 1 group by email')->result();

    //      // echo "<pre>";
    //      //  print_r($user);
    //      //   die;



    //     //looping cari nama
    //     foreach($user as $u){
                     
    //                 //cari materi nya apa aja
    //                 $event_materi = $this->db->query('select * from event as e inner join materi as m on e.id_event = m.id_event where m.id_event = "'.$id_event.'"' )->result();

    //                 // echo "<pre>";
    //                 // print_r($event_materi);

    //                 // die;

    //                 //dillooping materinya cari skor
                    
    //                 foreach($event_materi as $e)
    //                 {
    //                     $jawaban[$u->email][] = $this->db->query('select * from jawaban where materi_id = "'.$e->materi_id.'" and mode = 1  and email = "'.$u->email.'" order by id_jawaban asc')->row();
                        

                       
                    
    //                 }


                  
    //                 $skor = 0;

    //                 // echo "<pre>";
    //                 // print_r($jawaban['apreak@gmail.com']);
    //                 // die;
    //                 error_reporting(0);
    //                foreach($jawaban[$u->email] as $j){

                    

    //                     $skor += $j->skor;

    //                 }


    //                $waktu_awal        =strtotime($jawaban[$u->email][0]->tgl_mulai);
    //              $waktu_akhir    =strtotime($jawaban[$u->email][0]->create_add); // bisa juga waktu sekarang now()
                 
    //              //menghitung selisih dengan hasil detik
    //              $diff    =$waktu_akhir - $waktu_awal;


    //              // if($skor<=0){
    //              //    $hasil_skor = 0;
    //              // }else{
    //              //    $hasil_skor = $skor;
    //              // }

    //              $data_api[] = array(
    //                  'email'=>$u->email,
    //                  'event'=>$event_materi[0]->judul,
    //                  'skor'=>$skor,
    //                  'waktu'=>floor($diff/60),
    //                  'tgl_awal'=>$waktu_awal,
    //                  // 'waktu'=>$diff,
    //                  'waktu_pengerjaan'=> TanggalIndo(date('Y-m-d',strtotime($jawaban[$u->email][0]->tgl_mulai))) .' '.date('H:i:s',strtotime($jawaban[$u->email][0]->tgl_mulai)),

    //                //  'jawaban'=>$jawaban[$u->email],
    //              );


    //     }

        

    //       foreach($data_api as $a){

    //         // if($a['skor']==$a['skor']){
                
    //         // }else{

    //         // }
    //         $data_api_api[] = array(
    //             'email'=>$a['email'],
    //             'event'=>$a['event'],
    //             'skor'=>$a['skor'],
    //             'waktu'=>$a['waktu'],
    //            // 'tgl_awal'=>$a['tgl_awal'],
    //             'waktu_pengerjaan'=>$a['waktu_pengerjaan'],
    //         );
    //     }

    //     $sort_by_skor = $this->sortAssociativeArrayByKey($data_api_api,'skor','DESC');


            
    //     //  echo "<pre>";
    //     //   print_r($jawaban);
    //     //    die;    

    //     // die;

    //     echo json_encode($sort_by_skor);


    //    // echo json_encode($data_api);

 
    //  }



     function cari_nilai(){
        
         
        $id_event2 = $this->input->post('id_event');

         $id_peserta = $this->input->post('id_peserta');

        $id_event = base64_decode($id_event2);
         $email = $this->input->post('email');

        $materi =  $this->db->query('select * from materi where publish = 1 and id_event =  "'.$id_event.'"')->result();

        
        foreach($materi as $m){

          // print_r($m->materi_id);
            $jawaban[] =  $this->db->query('select * from jawaban where id_peserta = "'.$id_peserta.'" and materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();

            $soal[$m->materi_id] =  $this->db->query('select * from soalonline where materi_id =  "'.$m->materi_id.'" order by materi_id desc')->result();


            $jawaban_skor[$m->materi_id] =  $this->db->query('select * from jawaban where id_peserta = "'.$id_peserta.'" and  materi_id =  "'.$m->materi_id.'"  and email="'.$email.'" order by materi_id desc')->row();



           

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


      function datadiri(){

          $email = $this->input->post('email');
          $nama = $this->input->post('nama');
          $no_wa = $this->input->post('no_wa');
          $wilayah = $this->input->post('wilayah');
          $kampus_impian = $this->input->post('kampus_impian');
          $jurusan_diinginkan = $this->input->post('jurusan_diinginkan');
          $asal_sekolah = $this->input->post('asal_sekolah');
            $id_event = $this->input->post('id_event');

        // $email = "tes";
        // $nama = "tes";
        // $no_wa = "tes";
        // $wilayah = "tes";
        // $kampus_impian = "tes";
        // $jurusan_diinginkan = "tes";
        // $asal_sekolah = "1";


          $data_insert= array(
            'email'=>$email,
            'nama'=>$nama,
            'no_wa'=>$no_wa,
            'wilayah'=>$wilayah,
            'kampus_impian'=>$kampus_impian,
            'jurusan_diinginkan'=>$jurusan_diinginkan,
            'asal_sekolah'=>$asal_sekolah,
            'create_add'=>date('Y-m-d H:i:s'),
            'id_event'=>base64_decode($id_event),
          );

          // echo "<pre>";
          // print_r($data_insert);
          // die;

          $simpan = $this->db->insert('peserta',$data_insert);
           $id_peserta_h = $this->db->insert_id();

          if($simpan){
              $data['status'] = 200;
              $data['message'] = "sukses";
              $data['id_peserta'] = $id_peserta_h;
          }else{
            $data['status'] = 404;
            $data['message'] = "gagal";
            $data['id_peserta'] = 0;
          }
          echo json_encode($data);
      }


      function detail_latihan($judul){
        // echo "tes";
        // die;
          error_reporting(0);
        //$judul = "Pekan-I---Latihan-Soal";

  
        $event_latihan = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' and REPLACE(judul, ' ', '-' ) = '".$judul."'")->result();

        // echo "<pre>";
        // print_r($event_latihan);

        // die;

        foreach($event_latihan as $s){

            $materi[$s->id_event] = $this->db->query("select * from materi where publish = 1 and id_event = ".$s->id_event)->result();
          
           
            // echo "<pre>";
            // print_r($materi);
            
            // die;

            foreach($materi[$s->id_event] as $e){

                 //$jenis = $this->db->query("select * from jenis where id_kategori = ".$s->id_kategori)->row();

            $soal = $this->db->query("select * from soalonline where materi_id = ".$e->materi_id)->result();

             $jurusan = $this->db->query("select * from jurusan where id_jurusan = ".$e->id_jurusan)->row();

             $jenis = $this->db->query("select * from jenis where id_jenis = ".$jurusan->id_jenis)->row();



             $data[$s->kategori_nama][]  = array(
                    'materi_nama'=>$e->materi_nama,
                     'materi_id'=>$e->materi_id,
                'jenis'=>$jenis->jenis_nama,
                'jenis_label'=>$jenis->label,
                'waktu'=>$e->waktu,
                'soal'=>count($soal),
                'jurusan'=>$jurusan->jurusan_nama,
                
                
                );
            }

            
            // $data[$s->kategori_nama][] = array(
            //     'materi_nama'=>$materi->materi_nama,
            //     'materi_id'=>$materi->materi_id,
            //     'materi_id'=>base64_encode($materi->materi_id),
            //     'jenis'=>$jenis->jenis_nama,
            //      'jenis_label'=>$jenis->label,
            //     'waktu'=>$materi->waktu,
            //     'soal'=>count($soal),
            //     'jurusan'=>$jurusan->jurusan_nama,

            // );
        }

        $data_api = array(
            'status'=>200,
            'kategori'=>$kategori->kategori_nama,
            'tanggal'=> TanggalIndo($event_latihan[0]->tgl_mulai) .'-'. TanggalIndo($event_latihan[0]->tgl_selesai),
            'event'=>$event_latihan[0]->judul,
            'datanya'=>$data,

        );

        echo json_encode($data_api);


      }


      function cari_nilai_materi($email2,$id_jawaban2){
        

       
       $email = base64_decode($email2);
       $id_jawaban = base64_decode($id_jawaban2);

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


     function pembahasan_materi($email2,$id_jawaban2){

        $email = base64_decode($email2);
       $id_jawaban = base64_decode($id_jawaban2);
     
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


        function latihan_get_all(){
        // $sql = $this->db->query("select e.*,m.materi_id,m.materi_nama,m.id_jenis from event as e 
        // inner JOIN materi as m on m.id_event=e.id_event
        //         where e.mode='latihan'")->result();

        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' group by e.judul,e.tgl_mulai,e.tgl_selesai")->result();


        // echo "<pre>";
        // print_r($sql);
        //         die;


        //berlangsung
        foreach ($sql as $s) {


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            if ($hariini >= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {
                    $data_api['berlangsung'][] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => $s->tgl_mulai,
                        "tgl_selesai" => $s->tgl_selesai,
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                        
                       
                        
                    );
                }
            }
        }

        //berlalu
       
         foreach ($sql as $s) {


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            // if ($hariini <= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai <= $hariini) {
                    $data_api['lalu'][] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => $s->tgl_mulai,
                        "tgl_selesai" => $s->tgl_selesai,
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                        
                       
                        
                    );
                }
            // }
        }


        

        echo json_encode($data_api);

        
    }

     function latihan_berlangsung($paging=null){
        // $sql = $this->db->query("select e.*,m.materi_id,m.materi_nama,m.id_jenis from event as e 
        // inner JOIN materi as m on m.id_event=e.id_event
        //         where e.mode='latihan'")->result();

        if($paging){
          //  echo "1";
            $offset = $paging;
        }else{
          // echo "2";
            $offset = 0;
        }

        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' group by e.judul,e.tgl_mulai,e.tgl_selesai LIMIT 10  OFFSET ".$offset."")->result();


        // echo "<pre>";
        // print_r($sql);
        //         die;


        //berlangsung
        foreach ($sql as $s) {


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            if ($hariini >= $s->tgl_mulai) {

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai >= $hariini) {
                    $data_api['berlangsung'][] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => $s->tgl_mulai,
                        "tgl_selesai" => $s->tgl_selesai,
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                        
                       
                        
                    );
                }
            }
        }

       


        

        echo json_encode($data_api);

        
    }

    function latihan_berlalu($paging=null){
        // $sql = $this->db->query("select e.*,m.materi_id,m.materi_nama,m.id_jenis from event as e 
        // inner JOIN materi as m on m.id_event=e.id_event
        //         where e.mode='latihan'")->result();

        if($paging){
          //  echo "1";
            $offset = $paging;
        }else{
          // echo "2";
            $offset = 0;
        }
        //die;

        $sql = $this->db->query("select e.*,j.kategori_nama,j.id_kategori from event as e 
        inner JOIN kategori as j on e.id_kategori=j.id_kategori
                where  e.mode='latihan' group by e.judul,e.tgl_mulai,e.tgl_selesai LIMIT 10  OFFSET ".$offset.""
        )->result();


        // echo "<pre>";
        // print_r($sql);
        //         die;


        //berlangsung
        foreach ($sql as $s) {


            $hariini = date('Y-m-d');

            //$hariini = '2022-03-06';


            

                //jika hari ini kurang dari tgl selesai
                if ($s->tgl_selesai <= $hariini) {
                    $data_api['berlalu'][] = array(
                        "id_event" => base64_encode($s->id_event),
                        "judul" => $s->judul,
                        "tgl_mulai" => $s->tgl_mulai,
                        "tgl_selesai" => $s->tgl_selesai,
                        "desc" => $s->desc,
                        "img" => $s->img,
                        "status" => $s->status,
                        "mode" => $s->mode,
                        
                       
                        
                    );
                }
            
        }

       


        

        echo json_encode($data_api);

        
    }

}
