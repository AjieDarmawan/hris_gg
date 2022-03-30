<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Soal extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
        if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Soal_M','Materi_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index($id)
    {
        
        $data['id'] = $id;
        //$data['materi_id'] = $materi_id;
        
        $data["title"] = "List Data Master Soal";
        $data["materi"] = $this->Materi_M->getAll();
        $this->template->load('template','soal/soal_v',$data);
     
    }


    public function ajax_list($id)
    {

        // echo $id;
        // die;
        header('Content-Type: application/json');
        $list = $this->Soal_M->get_datatables($id);
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_jbt) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/Soal/update/'.base64_encode($data_jbt->id)).'/'.$id."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
             $delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_jbt->id' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";

             

             if($data_jbt->img){
                $gambar = "<img widht='50' height='50' src='".base_url("assets/file_upload/soalonline/soal/".$data_jbt->img)."'>";
             }else{
                $gambar = "";
             }

             if($data_jbt->pembahasan_img){
                $gambar_pembahasan = "<img widht='50' height='50' src='".base_url("assets/file_upload/soalonline/pembahasan/".$data_jbt->pembahasan_img)."'>";
             }else{
                $gambar_pembahasan = "";
             }

             $pilihan = json_decode($data_jbt->pilihan);



             foreach($pilihan as $p){
                 if($p->code==1){
                    
                    $jawaban_a  = $p->name;
                    
                 }elseif($p->code==2){
                    
                    $jawaban_b  = $p->name;
                    
                }elseif($p->code==3){
                    
                    
                    $jawaban_c  = $p->name;
                }elseif($p->code==4){
                    
                    $jawaban_d  = $p->name;
                    
                }elseif($p->code==5){
                    
                    $jawaban_e  = $p->name;
                    
                }

                    

             }


                    $Path_img_jawaban_a = base_url("assets/file_upload/soalonline/jawaban_a/".$jawaban_a);
                    $Path_jawaban_a = FCPATH.'assets/file_upload/soalonline/jawaban_a/'.$jawaban_a;
                 
                 if($jawaban_a){
                     if (file_exists($Path_jawaban_a) ){
                        $Path2_jawaban_a = " <img widht='50' height='50' src='".$Path_img_jawaban_a."'>";   
                        $type = 'gambar';
                    }else{
                        $Path2_jawaban_a =  $jawaban_a;
                        $type = 'text';
                    }
                 }else{
                        $Path2_jawaban_a =  $jawaban_a;
                        $type = 'text';
                 }
                   


                    $Path_img_jawaban_b = base_url("assets/file_upload/soalonline/jawaban_b/".$jawaban_b);
                    $Path_jawaban_b = FCPATH.'assets/file_upload/soalonline/jawaban_b/'.$jawaban_b;
                 

                 if($jawaban_b){
                    if (file_exists($Path_jawaban_b) ){
                        $Path2_jawaban_b = " <img widht='50' height='50' src='".$Path_img_jawaban_b."'>";   
                        $type = 'gambar';
                    }else{
                        $Path2_jawaban_b =  $jawaban_b;
                        $type = 'text';
                    }

                 }else{
                    $Path2_jawaban_b =  $jawaban_b;
                        $type = 'text';
                 }
            
                    


                    $Path_img_jawaban_c = base_url("assets/file_upload/soalonline/jawaban_c/".$jawaban_c);
                    $Path_jawaban_c = FCPATH.'assets/file_upload/soalonline/jawaban_c/'.$jawaban_c;
                 
            
                     if($jawaban_c){

                         if (file_exists($Path_jawaban_c) ){

                        $Path2_jawaban_c = " <img widht='50' height='50' src='".$Path_img_jawaban_c."'>";   
                        $type = 'gambar';
                    }else{
                        $Path2_jawaban_c =  $jawaban_c;
                        $type = 'text';
                    }
                            
                        }else{
                                 $Path2_jawaban_c =  $jawaban_c;
                                $type = 'text';
                     }

                   


                    $Path_img_jawaban_d = base_url("assets/file_upload/soalonline/jawaban_d/".$jawaban_d);
                    $Path_jawaban_d = FCPATH.'assets/file_upload/soalonline/jawaban_d/'.$jawaban_d;
                 
                    
                    if($jawaban_d){
                        if (file_exists($Path_jawaban_d) ){
                        $Path2_jawaban_d = " <img widht='50' height='50' src='".$Path_img_jawaban_d."'>";   
                        $type = 'gambar';
                    }else{
                        $Path2_jawaban_d =  $jawaban_d;
                        $type = 'text';
                    }
                 }else{
                    $Path2_jawaban_d =  $jawaban_d;
                        $type = 'text';
                 }


                    


                    $Path_img_jawaban_e = base_url("assets/file_upload/soalonline/jawaban_e/".$jawaban_e);
                    $Path_jawaban_e = FCPATH.'assets/file_upload/soalonline/jawaban_e/'.$jawaban_e;
                 
                
                if($jawaban_e){
                      if (file_exists($Path_jawaban_e) ){
                        $Path2_jawaban_e = " <img widht='50' height='50' src='".$Path_img_jawaban_e."'>";   
                        $type = 'gambar';
                    }else{
                        $Path2_jawaban_e =  $jawaban_e;
                        $type = 'text';
                    }
                 }else{
                     $Path2_jawaban_e =  $jawaban_e;
                        $type = 'text';
                 }

                  

                    


            $no++;
            $row = array();
            $row[] = $no;
            
            $row[] = $data_jbt->id;

            $row[] = $data_jbt->materi_nama;
            $row[] = $gambar;
            $row[] = $data_jbt->pertanyaan;

            $row[] = $Path2_jawaban_a;
            $row[] = $Path2_jawaban_b;
            $row[] = $Path2_jawaban_c;
           

            $row[] = $Path2_jawaban_d;
            $row[] = $Path2_jawaban_e;

            
            $row[] = $data_jbt->pembahasan;
            $row[] = $gambar_pembahasan;

            $sess = $this->session->userdata();
            if($sess['pegawai']->role==1){
                $row[] = $edit." ".$delete;
            }else{
                $row[] = $edit;
            }
            

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Soal_M->count_all($id),
            "recordsFiltered" => $this->Soal_M->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }


    function tambah($materi_id){
         $data["divisi"] = $this->Materi_M->getAll();
        $data["title"] = "List Data Master Soal";
        $data["materi_id"] = $materi_id;
        $this->template->load('template','soal/soal_tambah',$data);
  }

  function simpan(){
    $this->load->library('upload');
     

      $materi_id   = $this->input->post('materi_id');
      $pertanyaan   = $this->input->post('pertanyaan');
      $jawaban_a    = $this->input->post('jawaban_a');
      $jawaban_b    = $this->input->post('jawaban_b');
      $jawaban_c    = $this->input->post('jawaban_c');
      $jawaban_d    = $this->input->post('jawaban_d');
      $jawaban_e    = $this->input->post('jawaban_e');
      $pembahasan   = $this->input->post('pembahasan');
      $jawaban_benar   = $this->input->post('jawaban_benar');

       //img pertanyaan


       $config_img['upload_path']          = './assets/file_upload/soalonline/soal/';
       $config_img['allowed_types']        = 'gif|jpg|png|jpeg';
       $img_gambar                     = "sln-A". mt_rand(1000, 9999);
      $config_img['file_name']            = $img_gambar;
     //   $config_img['max_size']             = 100;
     //   $config_img['max_width']            = 1024;
     //   $config_img['max_height']           = 768;
 
       
 
       $this->upload->initialize($config_img);
       if ($this->upload->do_upload('pertanyaan_img')){
       $data = array('upload_data' => $this->upload->data());
        
 
             $filename= $_FILES["pertanyaan_img"]["name"];
             $file_ext = pathinfo($filename,PATHINFO_EXTENSION);

             $img_gambar_hasil = $img_gambar.'.'.$file_ext;
 
  
       }else{
         $error = array('error' => $this->upload->display_errors());
             $img_gambar_hasil = "";
       }
 
 
       //img pembahasan
 
 
       $config_pembahasan['upload_path']          = './assets/file_upload/soalonline/pembahasan/';
       $config_pembahasan['allowed_types']        = 'gif|jpg|png|jpeg';
       $img_pembahasan                     = "sln-L". mt_rand(1000, 9999);
       $config_pembahasan['file_name']            = $img_pembahasan;
     //   $config_pembahasan['max_size']             = 100;
     //   $config_pembahasan['max_width']            = 1024;
     //   $config_pembahasan['max_height']           = 768;
 
      
 
       $this->upload->initialize($config_pembahasan);
 
       if ($this->upload->do_upload('pembahasan_img')){
 
         // echo "<pre>";
         // print_r($config_pembahasan);
         // die;
 
         // echo "hai sukses";
         // die;
 
         $data_pembahasan = array('upload_data_pembahasan' => $this->upload->data());
         //   echo "<pre>";
         //   print_r($data_pembahasan);
 
         $filename= $_FILES["pembahasan_img"]["name"];
         $file_ext = pathinfo($filename,PATHINFO_EXTENSION);

         $pembahasan_hasil = $img_pembahasan.'.'.$file_ext;
 
         
 
 
         
        
       }else{
 
         $error = array('error' => $this->upload->display_errors());
         $pembahasan_hasil = "";
           
        
       }
 
 
 
 
       //jawaban_a
       $config_jawaban_a['upload_path']          = './assets/file_upload/soalonline/jawaban_a/';
       $config_jawaban_a['allowed_types']        = 'gif|jpg|png|jpeg';
       $img_jawaban_a                     = "sln-F". mt_rand(1000, 9999);
       $config_jawaban_a['file_name']            = $img_jawaban_a;
     //   $config_jawaban_a['max_size']             = 100;
     //   $config_jawaban_a['max_width']            = 1024;
     //   $config_jawaban_a['max_height']           = 768;
 
      // $this->load->library('upload', $config_jawaban_a);
 
       $this->upload->initialize($config_jawaban_a);
 
       if ($this->upload->do_upload('img_jawaban_a')){
          
 
         $data = array('upload_data' => $this->upload->data());
         $filename= $_FILES["img_jawaban_a"]["name"];
         $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
 
           $img_jawaban_a_simpan  = $img_jawaban_a.'.'.$file_ext;
 
        
       }else{
         $error = array('error' => $this->upload->display_errors());
         //   echo "<pre>";
         //   print_r($error);
 
           $img_jawaban_a_simpan = "";
        
        
       }
 
 
        //jawaban_b
        $config_jawaban_b['upload_path']          = './assets/file_upload/soalonline/jawaban_b/';
        $config_jawaban_b['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_jawaban_b                     = "sln-G". mt_rand(1000, 9999);
        $config_jawaban_b['file_name']            = $img_jawaban_b;
      //   $config_jawaban_b['max_size']             = 100;
      //   $config_jawaban_b['max_width']            = 1024;
      //   $config_jawaban_b['max_height']           = 768;
  
        
 
        $this->upload->initialize($config_jawaban_b);
 
 
        
  
        if ( $this->upload->do_upload('img_jawaban_b')){
           
 
         $data = array('upload_data' => $this->upload->data());
         $filename= $_FILES["img_jawaban_b"]["name"];
         $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
 
           $img_jawaban_b_simpan  = $img_jawaban_b.'.'.$file_ext;
         
        }else{
         $error = array('error' => $this->upload->display_errors());
         //    echo "<pre>";
         //    print_r($error);
         $img_jawaban_b_simpan  = "";
        }
 
 
        //jawaban_c
        $config_jawaban_c['upload_path']          = './assets/file_upload/soalonline/jawaban_c/';
        $config_jawaban_c['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_jawaban_c                     = "sln-H". mt_rand(1000, 9999);
        $config_jawaban_c['file_name']            = $img_jawaban_c;
      //   $config_jawaban_c['max_size']             = 100;
      //   $config_jawaban_c['max_width']            = 1024;
      //   $config_jawaban_c['max_height']           = 768;
  
       
 
        $this->upload->initialize($config_jawaban_c);
  
        if ($this->upload->do_upload('img_jawaban_c')){
         $data = array('upload_data' => $this->upload->data());
 
         $filename= $_FILES["img_jawaban_c"]["name"];
         $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
 
           $img_jawaban_c_simpan  = $img_jawaban_c.'.'.$file_ext;
 
 
         // echo "<pre>";
         // print_r($data);
         
        }else{
           
 
            $error = array('error' => $this->upload->display_errors());
            //    echo "<pre>";
            //    print_r($error);
            $img_jawaban_c_simpan  = "";
         
        }
 
 
        //jawaban_d
        $config_jawaban_d['upload_path']          = './assets/file_upload/soalonline/jawaban_d/';
        $config_jawaban_d['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_jawaban_d                            = "sln-I". mt_rand(1000, 9999);
        $config_jawaban_d['file_name']            = $img_jawaban_d;
      //   $config_jawaban_d['max_size']             = 100;
      //   $config_jawaban_d['max_width']            = 1024;
      //   $config_jawaban_d['max_height']           = 768;
  
 
        $this->upload->initialize($config_jawaban_d);
  
        if ($this->upload->do_upload('img_jawaban_d')){
         $data = array('upload_data' => $this->upload->data());
         $filename= $_FILES["img_jawaban_d"]["name"];
         $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
 
           $img_jawaban_d_simpan  = $img_jawaban_d.'.'.$file_ext;
         
        }else{
         $error = array('error' => $this->upload->display_errors());
         //    echo "<pre>";
         //    print_r($error);
         $img_jawaban_d_simpan  = "";
         
        }
 
 
        //jawaban_e
        $config_jawaban_e['upload_path']          = './assets/file_upload/soalonline/jawaban_e/';
        $config_jawaban_e['allowed_types']        = 'gif|jpg|png|jpeg';
        $img_jawaban_e                             = "sln-J". mt_rand(1000, 9999);
        $config_jawaban_e['file_name']            = $img_jawaban_e;
      //   $config_jawaban_e['max_size']             = 100;
      //   $config_jawaban_e['max_width']            = 1024;
      //   $config_jawaban_e['max_height']           = 768;
  
        $this->load->library('upload', $config_jawaban_e);
  
        if ($this->upload->do_upload('img_jawaban_e')){
             $data = array('upload_data' => $this->upload->data());
             $filename= $_FILES["img_jawaban_e"]["name"];
             $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
 
             $img_jawaban_e_simpan  = $img_jawaban_e.'.'.$file_ext;
         
        }else{
            
 
            $error = array('error' => $this->upload->display_errors());
            //    echo "<pre>";
            //    print_r($error);
            $img_jawaban_e_simpan  = "";
         
        }

        if($img_jawaban_a_simpan){
            $a_jawaban = $img_jawaban_a_simpan;
        }else{
            $a_jawaban = $jawaban_a;
        }
 
 
        if($img_jawaban_b_simpan){
         $b_jawaban = $img_jawaban_b_simpan;
         }else{
            $b_jawaban = $jawaban_b;
         }
 
 
             if($img_jawaban_c_simpan){
             $c_jawaban = $img_jawaban_c_simpan;
             }else{
                $c_jawaban = $jawaban_c;
             }
 
 
             if($img_jawaban_d_simpan){
                 $d_jawaban = $img_jawaban_d_simpan;
                 }else{
                    $d_jawaban = $jawaban_d;
                 }
 
                      if($img_jawaban_e_simpan){
                     $e_jawaban = $img_jawaban_e_simpan;
                     }else{
                        $e_jawaban = $jawaban_e;
                     }
  
        $pilihan = array(
          array(
              'code'=>'1',
              'name'=>$a_jawaban,
          ),
  
          array(
              'code'=>'2',
              'name'=>$b_jawaban,
          ),
  
          array(
              'code'=>'3',
              'name'=>$c_jawaban,
          ),
  
          array(
              'code'=>'4',
              'name'=>$d_jawaban,
          ),
  
          array(
              'code'=>'5',
              'name'=>$e_jawaban,
          ),
      );


        $data_insert = array(
            'img'=>$img_gambar_hasil,
            'pembahasan_img'=>$pembahasan_hasil,
            'pertanyaan'=>$pertanyaan,
            'pembahasan'=>$pembahasan,
            'jawaban'=>$jawaban_benar,
           'pilihan'=>json_encode($pilihan),
           'materi_id'=>$materi_id,
           'create_add'=>date('Y-m-d H:i:s'),

       );

    //    echo "<pre>";
    //    print_r($data_insert);
    //    die;
  
     $simpan = $this->db->insert('soalonline',$data_insert);


      if($simpan){


        $sess = $this->session->userdata();
        $data_log = array(
          'aktifitas'=>$sess['pegawai']->username.''.' Menambahkan Soal '.$pertanyaan.' id '.$this->db->insert_id(),
          'datetime'=>date('Y-m-d H:i:s'),
        );
 
        $this->db->insert('log',$data_log);


         $this->session->set_flashdata('status',"success");
          $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
          
          redirect('master/soal/index/'.base64_encode($materi_id));
      
      }else{

      }



  }

  function update($id,$id_materi){
       

      $data['soal'] = $this->Soal_M->getById(base64_decode($id));

      $data['id_materi'] = $id_materi;

   
      $data["divisi"] = $this->Materi_M->getAll();

      

      $data["title"] = "List Data Master Soal";
      $this->template->load('template','soal/soal_edit',$data);
  }

  function update_simpan(){
    $this->load->library('upload');

  

      $soal_id      = $this->input->post('soal_id');

      $id_materi      = $this->input->post('id_materi');

      


      $sql = $this->db->query('select * from soalonline where id='.$soal_id)->row();

    

     

      $pertanyaan   = $this->input->post('pertanyaan');
      $jawaban_a    = $this->input->post('jawaban_a');
      $jawaban_b    = $this->input->post('jawaban_b');
      $jawaban_c    = $this->input->post('jawaban_c');
      $jawaban_d    = $this->input->post('jawaban_d');
      $jawaban_e    = $this->input->post('jawaban_e');
      $pembahasan   = $this->input->post('pembahasan');

      $jawaban_benar   = $this->input->post('jawaban_benar');

      //img pertanyaan


      $config_img['upload_path']          = './assets/file_upload/soalonline/soal/';
      $config_img['allowed_types']        = 'gif|jpg|png|jpeg';
      $img_gambar                     = "sln-A". mt_rand(1000, 9999);
     $config_img['file_name']            = $img_gambar;
    //   $config_img['max_size']             = 100;
    //   $config_img['max_width']            = 1024;
    //   $config_img['max_height']           = 768;

      

      $this->upload->initialize($config_img);

      if ($this->upload->do_upload('pertanyaan_img')){


       

        $data = array('upload_data' => $this->upload->data());
        //   echo "<pre>";
        //   print_r($data);

            $filename= $_FILES["pertanyaan_img"]["name"];
            $file_ext = pathinfo($filename,PATHINFO_EXTENSION);

          $data_img_simpan = array(
              'img'=>$img_gambar.'.'.$file_ext,
          );

          $this->db->where('id',$soal_id);
          $this->db->update('soalonline',$data_img_simpan);


       

         

         // $this->load->view('v_upload', $error);
      }else{
        $error = array('error' => $this->upload->display_errors());
        //   echo "<pre>";
        //   print_r($error);
          
         // $this->load->view('v_upload_sukses', $data);
      }


      //img pembahasan


      $config_pembahasan['upload_path']          = './assets/file_upload/soalonline/pembahasan/';
      $config_pembahasan['allowed_types']        = 'gif|jpg|png|jpeg';
      $img_pembahasan                     = "sln-L". mt_rand(1000, 9999);
      $config_pembahasan['file_name']            = $img_pembahasan;
    //   $config_pembahasan['max_size']             = 100;
    //   $config_pembahasan['max_width']            = 1024;
    //   $config_pembahasan['max_height']           = 768;

     

      $this->upload->initialize($config_pembahasan);

      if ($this->upload->do_upload('pembahasan_img')){

        // echo "<pre>";
        // print_r($config_pembahasan);
        // die;

        // echo "hai sukses";
        // die;

        $data_pembahasan = array('upload_data_pembahasan' => $this->upload->data());
        //   echo "<pre>";
        //   print_r($data_pembahasan);

        $filename= $_FILES["pembahasan_img"]["name"];
        $file_ext = pathinfo($filename,PATHINFO_EXTENSION);

        $data_img_pembahasan_simpan = array(
            'pembahasan_img'=>$img_pembahasan.'.'.$file_ext,
        );

        $this->db->where('id',$soal_id);
        $this->db->update('soalonline',$data_img_pembahasan_simpan);


        
       
      }else{

        $error = array('error' => $this->upload->display_errors());
        // echo "<pre>";
        // print_r($error);
          
       
      }




      //jawaban_a
      $config_jawaban_a['upload_path']          = './assets/file_upload/soalonline/jawaban_a/';
      $config_jawaban_a['allowed_types']        = 'gif|jpg|png|jpeg';
      $img_jawaban_a                     = "sln-F". mt_rand(1000, 9999);
      $config_jawaban_a['file_name']            = $img_jawaban_a;
    //   $config_jawaban_a['max_size']             = 100;
    //   $config_jawaban_a['max_width']            = 1024;
    //   $config_jawaban_a['max_height']           = 768;

     // $this->load->library('upload', $config_jawaban_a);

      $this->upload->initialize($config_jawaban_a);

      if ($this->upload->do_upload('img_jawaban_a')){
         

        $data = array('upload_data' => $this->upload->data());
        $filename= $_FILES["img_jawaban_a"]["name"];
        $file_ext = pathinfo($filename,PATHINFO_EXTENSION);

          $img_jawaban_a_simpan  = $img_jawaban_a.'.'.$file_ext;

       
      }else{
        $error = array('error' => $this->upload->display_errors());
        //   echo "<pre>";
        //   print_r($error);

            $img_jawaban_a_simpan = "";
       
       
      }


       //jawaban_b
       $config_jawaban_b['upload_path']          = './assets/file_upload/soalonline/jawaban_b/';
       $config_jawaban_b['allowed_types']        = 'gif|jpg|png|jpeg';
       $img_jawaban_b                     = "sln-G". mt_rand(1000, 9999);
       $config_jawaban_b['file_name']            = $img_jawaban_b;
     //   $config_jawaban_b['max_size']             = 100;
     //   $config_jawaban_b['max_width']            = 1024;
     //   $config_jawaban_b['max_height']           = 768;
 
       

       $this->upload->initialize($config_jawaban_b);


       
 
       if ( $this->upload->do_upload('img_jawaban_b')){
          

        $data = array('upload_data' => $this->upload->data());
        $filename= $_FILES["img_jawaban_b"]["name"];
        $file_ext = pathinfo($filename,PATHINFO_EXTENSION);

          $img_jawaban_b_simpan  = $img_jawaban_b.'.'.$file_ext;
        
       }else{
        $error = array('error' => $this->upload->display_errors());
        //    echo "<pre>";
        //    print_r($error);
        $img_jawaban_b_simpan  = "";
       }


       //jawaban_c
       $config_jawaban_c['upload_path']          = './assets/file_upload/soalonline/jawaban_c/';
       $config_jawaban_c['allowed_types']        = 'gif|jpg|png|jpeg';
       $img_jawaban_c                     = "sln-H". mt_rand(1000, 9999);
       $config_jawaban_c['file_name']            = $img_jawaban_c;
     //   $config_jawaban_c['max_size']             = 100;
     //   $config_jawaban_c['max_width']            = 1024;
     //   $config_jawaban_c['max_height']           = 768;
 
      

       $this->upload->initialize($config_jawaban_c);
 
       if ($this->upload->do_upload('img_jawaban_c')){
        $data = array('upload_data' => $this->upload->data());

        $filename= $_FILES["img_jawaban_c"]["name"];
        $file_ext = pathinfo($filename,PATHINFO_EXTENSION);

          $img_jawaban_c_simpan  = $img_jawaban_c.'.'.$file_ext;


        // echo "<pre>";
        // print_r($data);
        
       }else{
          

           $error = array('error' => $this->upload->display_errors());
           //    echo "<pre>";
           //    print_r($error);
           $img_jawaban_c_simpan  = "";
        
       }


       //jawaban_d
       $config_jawaban_d['upload_path']          = './assets/file_upload/soalonline/jawaban_d/';
       $config_jawaban_d['allowed_types']        = 'gif|jpg|png|jpeg';
       $img_jawaban_d                     = "sln-I". mt_rand(1000, 9999);
       $config_jawaban_d['file_name']            = $img_jawaban_d;
     //   $config_jawaban_d['max_size']             = 100;
     //   $config_jawaban_d['max_width']            = 1024;
     //   $config_jawaban_d['max_height']           = 768;
 

       $this->upload->initialize($config_jawaban_d);
 
       if ($this->upload->do_upload('img_jawaban_d')){
        $data = array('upload_data' => $this->upload->data());
        $filename= $_FILES["img_jawaban_d"]["name"];
        $file_ext = pathinfo($filename,PATHINFO_EXTENSION);

          $img_jawaban_d_simpan  = $img_jawaban_d.'.'.$file_ext;
        
       }else{
        $error = array('error' => $this->upload->display_errors());
        //    echo "<pre>";
        //    print_r($error);
        $img_jawaban_d_simpan  = "";
        
       }


       //jawaban_e
       $config_jawaban_e['upload_path']          = './assets/file_upload/soalonline/jawaban_e/';
       $config_jawaban_e['allowed_types']        = 'gif|jpg|png|jpeg';
       $img_jawaban_e                     = "sln-J". mt_rand(1000, 9999);
       $config_jawaban_e['file_name']            = $img_jawaban_e;
     //   $config_jawaban_e['max_size']             = 100;
     //   $config_jawaban_e['max_width']            = 1024;
     //   $config_jawaban_e['max_height']           = 768;
 
       $this->load->library('upload', $config_jawaban_e);
 
       if ($this->upload->do_upload('img_jawaban_e')){
            $data = array('upload_data' => $this->upload->data());
            $filename= $_FILES["img_jawaban_e"]["name"];
            $file_ext = pathinfo($filename,PATHINFO_EXTENSION);

          $img_jawaban_e_simpan  = $img_jawaban_e.'.'.$file_ext;
        
       }else{
           

           $error = array('error' => $this->upload->display_errors());
           //    echo "<pre>";
           //    print_r($error);
           $img_jawaban_e_simpan  = "";
        
       }





       $a = json_decode($sql->pilihan);
    //    echo "<pre>";
    //    print_r($a);
 
     //   die;

       if($img_jawaban_a_simpan){
           $a_jawaban = $img_jawaban_a_simpan;
       }else{
            if($jawaban_a){
                $a_jawaban = $jawaban_a;
            }else{
                $a_jawaban = $a[0]->name;
            }
       }


       if($img_jawaban_b_simpan){
        $b_jawaban = $img_jawaban_b_simpan;
        }else{
            if($jawaban_b){
                $b_jawaban = $jawaban_b;
            }else{
                $b_jawaban = $a[1]->name;
            }
        }


            if($img_jawaban_c_simpan){
            $c_jawaban = $img_jawaban_c_simpan;
            }else{
                if($jawaban_c){
                    $c_jawaban = $jawaban_c;
                }else{
                    $c_jawaban = $a[2]->name;
                }
            }


            if($img_jawaban_d_simpan){
                $d_jawaban = $img_jawaban_d_simpan;
                }else{
                    if($jawaban_d){
                        $d_jawaban = $jawaban_d;
                    }else{
                        $d_jawaban = $a[3]->name;
                    }
                }

                     if($img_jawaban_e_simpan){
                    $e_jawaban = $img_jawaban_e_simpan;
                    }else{
                        if($jawaban_e){
                            $e_jawaban = $jawaban_e;
                        }else{
                            $e_jawaban = $a[4]->name;
                        }
                    }
 
       $pilihan = array(
         array(
             'code'=>'1',
             'name'=>$a_jawaban,
         ),
 
         array(
             'code'=>'2',
             'name'=>$b_jawaban,
         ),
 
         array(
             'code'=>'3',
             'name'=>$c_jawaban,
         ),
 
         array(
             'code'=>'4',
             'name'=>$d_jawaban,
         ),
 
         array(
             'code'=>'5',
             'name'=>$e_jawaban,
         ),
     );
 
    //  echo "<pre>";
    //  print_r($pilihan);
    //    die;



       $data_update = array(
            'pertanyaan'=>$pertanyaan,
            'pembahasan'=>$pembahasan,
            'jawaban'=>$jawaban_benar,
            'pilihan'=>json_encode($pilihan),
       );
       $this->db->where('id',$soal_id);
      $simpan = $this->db->update('soalonline',$data_update);



      


    

      if($simpan){
          $this->session->set_flashdata('status',"success");
          $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
          
          redirect('master/Soal/index/'.$id_materi);
      
      }else{

      }


  }

  function hapus(){
      $id = $this->input->post('id');
      

      $this->db->where('id',$id);
      $sql = $this->db->delete('soalonline');
      if($sql){
          $datas= array(
              'status' =>true,
          );
      }else{
          $datas= array(
              'status' =>false,
          );
      }

      echo json_encode($datas);
  }

  

  function simpan_upload_soal()
    {


        $materi_id = $this->input->post('materi_id');
        // echo $bulan;
        // die;    
      
        if(isset($_FILES["file"]["name"]))
        {


           
            // upload
          $file_tmp = $_FILES['file']['tmp_name'];
          $file_name = $_FILES['file']['name'];
          $file_size =$_FILES['file']['size'];
          $file_type=$_FILES['file']['type'];
          // move_uploaded_file($file_tmp,"uploads/".$file_name); // simpan filenya di folder uploads
          
          $object = PHPExcel_IOFactory::load($file_tmp);
  
          foreach($object->getWorksheetIterator() as $worksheet)
          {
  
              $highestRow = $worksheet->getHighestRow();
              $highestColumn = $worksheet->getHighestColumn();

              $getHighestDataColumn = $worksheet->getHighestDataColumn();

            
             

                $xls = PHPExcel_IOFactory::load($file_tmp);
                $xls->setActiveSheetIndex(0);
                $sheet = $xls->getActiveSheet();

                $objWorksheet = $sheet;
                foreach ($objWorksheet->getDrawingCollection() as $drawing) {
                    //for XLSX format
                    $string = $drawing->getCoordinates();
                        $coordinate = PHPExcel_Cell::coordinateFromString($string);

                        if ($drawing instanceof PHPExcel_Worksheet_Drawing){

                            
                            $filename = $drawing->getPath();
                            $drawing->getDescription();
                            $img_gambar = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                        
                            $img_gambar_tes[] = $img_gambar;
                        

                            copy($filename, 'assets/file_upload/soalonline/' . $img_gambar);
                            
                               
                           }

                       
                    if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
                    $image = $drawing->getImageResource();
                    // save image to disk
                    $renderingFunction = $drawing->getRenderingFunction();

                   
                    switch ($renderingFunction) {
                    case PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG:
                    imagejpeg($image, 'uploads/' . $drawing->getIndexedFilename());
                
                    break;
                    case PHPExcel_Worksheet_MemoryDrawing::RENDERING_GIF:
                        echo  imagegif($image, 'uploads/' . $drawing->getIndexedFilename());
                        echo "tes1";
                    break;
                    case PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG:
                    case PHPExcel_Worksheet_MemoryDrawing::RENDERING_DEFAULT:
                        echo   imagepng($image, 'uploads/' . $drawing->getIndexedFilename());

                        
                    break;
                    }
                    }
                    }

                
              for($row=0; $row<=$highestRow; $row++)
              {
  
                  

                 $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);



              } 
  
          }


                    //$objWorksheet  = $exceldata->getSheet(1);
					$data = $sheet->toArray();

                    // echo "<pre>";
                    // print_r($data);
                    // die;

                    

          $no=0;
          foreach($rowData as $c => $key){
            
              if($key[0][0]!=null ){
              
                if($key[0][0]!='img'){
                  //  print_r($c);
                    //echo $no++;

                 $a =   $img_gambar_tes[$no++];

                  $data_image[] = array(
                      'img'=>$a,
                      'pertanyaan_img'=>$key[0][0],
                      'pertanyaan'=>$key[0][3],
                  );

                }   
              }
          }

        //   echo "<pre>";
        //   print_r($data_image);

        // die;            
         
     
        foreach($rowData as $d)
        {


           


                 error_reporting(0);

             
             
                if($d[0][2]!=null){
                    if($d[0][3]=="pertanyaan"){

                    }else{
                          


                            if($d[0][0]!=null){
                                $img_gambar2 = $img_gambar; 
                            }else{
                                $img_gambar2 = null;
                            }



                        $pilihan = array(
                            array(
                                'code'=>'1',
                                'name'=>$d[0][5],
                            ),
            
                            array(
                                'code'=>'2',
                                'name'=>$d[0][6],
                            ),
            
                            array(
                                'code'=>'3',
                                'name'=>$d[0][7],
                            ),
            
                            array(
                                'code'=>'4',
                                'name'=>$d[0][8],
                            ),
                        );

                        // echo "<pre>";
                        // print_r($pilihan);
                        // die;


                        if($d[0][4]=="A"){
                            $jawaban = 1;
                        }elseif($d[0][4]=="B"){
                            $jawaban = 2;
                        }elseif($d[0][4]=="C"){
                            $jawaban = 3;
                        }elseif($d[0][4]=="D"){
                            $jawaban = 4;
                        }    
                        

                        //jika ada gambarnya 

                        if($data_image){
                            foreach($data_image as $i){
                                if($i['pertanyaan_img']==$d[0][0]){
                                    $data_insert = array(
                                        'materi_id'=>$materi_id,
                                        'pertanyaan'=>$d[0][3],
                                        'jawaban'=>$jawaban,
                                        'bobot'=>$d[0][2],
                                        'waktu'=>'5',
                                        'pilihan'=>json_encode($pilihan),
                                        'create_add'=>date("Y-m-d H:i:s"),
                                        'img'=>$i['img'],
                                        'pertanyaan_img'=>$d[0][0],
                                        
                                          
                                        
                                    );
                                }else if($i['pertanyaan']==$d[0][3] ){
    
                                    
    
                                    $data_insert = array(
                                        'materi_id'=>$materi_id,
                                        'pertanyaan'=>$d[0][3],
                                        'jawaban'=>$jawaban,
                                        'bobot'=>$d[0][2],
                                        'waktu'=>'5',
                                        'pilihan'=>json_encode($pilihan),
                                        'create_add'=>date("Y-m-d H:i:s"),
                                        'img'=>"",
                                        'pertanyaan_img'=>"",
                                          
                                        
                                    );
    
                                }
                            }
                        }else{
                             //kalo ga ada gambarnya

                             $data_insert = array(
                                'materi_id'=>$materi_id,
                                'pertanyaan'=>$d[0][3],
                                'jawaban'=>$jawaban,
                                'bobot'=>$d[0][2],
                                'waktu'=>'5',
                                'pilihan'=>json_encode($pilihan),
                                'create_add'=>date("Y-m-d H:i:s"),
                                'img'=>"",
                                'pertanyaan_img'=>"",
                                  
                                
                            );

                        }



                       

                      
                       


                       

                        
                       $this->db->insert('soalonline',$data_insert);

                        // echo "<pre>";
                        // print_r($img_gambar);
                        // die;
                    }
                }
        }

                    //  echo "<pre>";
                    //     print_r($data_insert);
                    //     die;
            
        $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");  
          redirect('master/soal');


      }
      else
      {

        echo "gagal";
        
      }
    }


    
    
}
