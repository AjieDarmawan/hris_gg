<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Materi extends CI_Controller
{


    function __construct(){
		parent::__construct();
        $sess = $this->session->userdata();
        if($sess['pegawai']->username){
			//redirect('auth');
		}else{
            redirect('auth');
        }
        $this->load->model(array('Materi_M','Jurusan_M','Jenis_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index($id)
    {
        
        // die;
    //    echo $id = base64_decode($id);
    //     die;
        $data['id'] = $id;
        

        //$data["Materi"] = $this->Materi_M->getAll();
        $data["title"] = "List Data Master Materi";
        $this->template->load('template','materi/materi_v',$data);
     
    }


    public function ajax_list($id)
    {
        header('Content-Type: application/json');
        $list = $this->Materi_M->get_datatables($id);
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_Materi) {


            $edit = "<a data-toggle='tooltip' title='Edit'  href=".base_url('master/Materi/update/'.base64_encode($data_Materi->materi_id).'/'.$id)."><button class='btn btn-success btn-xs'><i class='fa fa-edit'></i></button></a>";
			$delete =  "<a  data-toggle='tooltip' title='Hapus' id='$data_Materi->materi_id' class='hapus_dokumen' ><button class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></button></a>";
            $lihat_soal = "<a data-toggle='tooltip' title='lihat soal'  href=".base_url('master/soal/index/'.base64_encode($data_Materi->materi_id))."><button class='btn btn-info btn-xs'><i class='fa fa-edit'></i></button></a>";

           
            $m = $this->db->query('select publish from materi where materi_id="'.$data_Materi->materi_id.'"')->row();

            if($m->publish==1){
                $publsih = "<a data-toggle='tooltip' class='disabled' readonly title='publish soal'  href='#'  disabled='disabled' onclick=;return false;''><button disabled class='btn btn-primary btn-xs'><i class='fa fa-home'></i></button></a>";

                $tombol_aksi = $edit."  ".$lihat_soal." ".$publsih;
            }else{
                $publsih = "<a data-toggle='tooltip' title='publish soal'  href=".base_url('master/Materi/publish/'.base64_encode($data_Materi->materi_id)).'/'.$id."><button class='btn btn-primary btn-xs'><i class='fa fa-home'></i></button></a>";
                $tombol_aksi = $edit." ".$delete." ".$lihat_soal." ".$publsih;
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Materi->no_urut;
            $row[] = $data_Materi->jenis_nama;
            $row[] = $data_Materi->materi_nama;
           

               $sess = $this->session->userdata();
               if($sess['pegawai']->role==1){
                $row[] = $tombol_aksi;
               }else{
                   $row[] = $edit."  ".$lihat_soal;
               }

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Materi_M->count_all(),
            "recordsFiltered" => $this->Materi_M->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }

    function tambah($id){

         // error_reporting(0);  
          $event = $this->db->query("select * from event where id_event=".base64_decode($id))->row();

        //     echo "<pre>";
        //     print_r($event->id_kategori);
        //   die;

          $data["jenis"] = $this->Jenis_M->getByKategori($event->id_kategori);
         // $data["jurusan"] = $this->Jurusan_M->getByIdJenis($event->id_jenis);
        //       echo "<pre>";
        //   print_r($data["jurusan"]);
        //   die;
          $data['id'] = $id;


        //   echo "<pre>";
        //   print_r($data['jenis']);

        //   die;

       
        
           
                   

        // echo "<pre>";
        // print_r($data);
        //   die;
          $data["title"] = "List Data Master Materi";
          $this->template->load('template','materi/materi_tambah',$data);
    }

    function simpan(){
        $Materi =  $this->input->post('Materi');

        $id_jurusan =  $this->input->post('id_jurusan');

        $tgl_mulai =  $this->input->post('tgl_mulai');

        $tgl_selesai =  $this->input->post('tgl_selesai');

        $waktu =  $this->input->post('waktu');

        $id_event =  $this->input->post('id_event');

        $no_urut =  $this->input->post('no_urut');

        $id_jenis =  $this->input->post('id_jenis');

        

        $simpan = $this->Materi_M->save($Materi,$id_jurusan,$tgl_mulai,$tgl_selesai,$id_event,$waktu,$no_urut,$id_jenis);



        //soal simpan

       // $materi_id = $this->input->post('materi_id');

        $materi_id = $this->db->insert_id();
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
                            
                            $cek_row = substr($drawing->getCoordinates(),0,1);

                            // gambar image
                            if($cek_row=='A'){
                                $img_gambar = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes[] = $img_gambar;

                                //$kordinat_img[] = $drawing->getCoordinates();
                                copy($filename, 'assets/file_upload/soalonline/soal/' . $img_gambar);


                               // pembasahan
                            }elseif($cek_row=='L'){

                                $img_gambar_pembahasan = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $kordinat =   str_replace("L","",$drawing->getCoordinates());
                                $img_gambar_tes_pembahasan2[$kordinat] = $img_gambar_pembahasan;
                                 //$kordinat_pembahasan[] = $drawing->getCoordinates();
                              copy($filename, 'assets/file_upload/soalonline/pembahasan/' . $img_gambar_pembahasan);
 
                                 ksort($img_gambar_tes_pembahasan2);
                            

                            //jawaban a 
                            }elseif($cek_row=='F'){

                                $img_gambar_jawaban_a = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes_jawaban_a[] = $img_gambar_jawaban_a;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                            copy($filename, 'assets/file_upload/soalonline/jawaban_a/' . $img_gambar_jawaban_a);

                            
                                //jawaban b
                             }elseif($cek_row=='G'){

                                $img_gambar_jawaban_b = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes_jawaban_b[] = $img_gambar_jawaban_b;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                                copy($filename, 'assets/file_upload/soalonline/jawaban_b/' . $img_gambar_jawaban_b);

                            


                                //jawaban c
                            }elseif($cek_row=='H'){

                                $img_gambar_jawaban_c = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes_jawaban_c[] = $img_gambar_jawaban_c;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                                copy($filename, 'assets/file_upload/soalonline/jawaban_c/' . $img_gambar_jawaban_c);

                                 //jawaban d
                            }elseif($cek_row=='I'){

                                $img_gambar_jawaban_d = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes_jawaban_d[] = $img_gambar_jawaban_d;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                                copy($filename, 'assets/file_upload/soalonline/jawaban_d/' . $img_gambar_jawaban_d);

                                 //jawaban e
                            }elseif($cek_row=='J'){

                                $img_gambar_jawaban_e = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes_jawaban_e[] = $img_gambar_jawaban_e;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                                copy($filename, 'assets/file_upload/soalonline/jawaban_c/' . $img_gambar_jawaban_e);

                            }

    
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

          error_reporting(E_ALL & ~E_NOTICE);

          array_shift($rowData);  


                    //$objWorksheet  = $exceldata->getSheet(1);
					$data = $sheet->toArray();



        //             // jajal
        //             $no=0;
        //   foreach($rowData as $c => $key){
              
        //         if($key[0][5]!='pilihan A'){
                   
        //                 $ab[] = $key[0][5];
                    
        //         }   
             
        //   }

        
        
        //  echo "<pre>";
        //  print_r($rowData);
         

        //   die;

                    
          //pertanyaan img
          $no_img=0;
          foreach($rowData as $c => $key){
               if($key[0][0]!='img'){
                    if($key[0][0]==null){
                        $a =   $img_gambar_tes[$no_img++];
                    }else{
                        $a = "";
                    }
                    
                  $data_image[$key[0][3]] = array(
                      'img'=>$a,
                      'pertanyaan_img'=>$key[0][0],
                      'pertanyaan'=>$key[0][3],
                  );

                }  
          }
          

          //pemabahsan img
        //   echo "<pre>";
        //   print_r($img_gambar_tes);
        //   die;


        foreach($img_gambar_tes_pembahasan2 as $a ){
            $img_gambar_tes_pembahasan[] = $a;
          }

        

          $no_pembahasan=0;
          foreach($rowData as $c => $key){
            
            
              
            if($key[0][11]!='pembahasan_img'){
                   
                if($key[0][0]!=null){
                    $a =   $img_gambar_tes_pembahasan[$no_pembahasan++];

                    
                }else{
                    $a = "";
                }

           

              $data_image_pembahasan[$key[0][3]] = array(
                  'img_pembahasan'=>$a,
                  'pertanyaan_img_pembahasan'=>$key[0][11],
                  'pertanyaan'=>$key[0][3],
              );

            }   
              
          }

          //jawaban_a

        
          $no=0;
          $kosong_a = 0;
          foreach($rowData as $c => $key){
           
                if($key[0][5]!='pilihan A'){
                    if($key[0][5]==null){
                        $a =   $img_gambar_tes_jawaban_a[$kosong_a++];
                    }else{
                        $a = "";
                    }
                  $data_image_jawaban_a[$key[0][3]] = array(
                      'img_jawaban_a'=>$a,
                      'pertanyaan_img_jawaban_a'=>$key[0][5],
                      'pertanyaan'=>$key[0][3],
                      //'no'=>$kosong,
                  );
                }   
          }

          //jawaban b
          $no=0;
          $kosong_b = 0;
          foreach($rowData as $c => $key){
                if($key[0][6]!='pilihan B'){
                    
                    if($key[0][6]==null){
                        $a =   $img_gambar_tes_jawaban_b[$kosong_b++];
                    }else{
                        $a = "";
                    }

              

                  $data_image_jawaban_b[$key[0][3]] = array(
                      'img_jawaban_b'=>$a,
                      'pertanyaan_img_jawaban_b'=>$key[0][6],
                      'pertanyaan'=>$key[0][3],
                  );

                }   
              
          }


          //jawaban_c

          $no=0;
          $kosong_c=0;
          foreach($rowData as $c => $key){


            // echo "<pre>";
            // print_r($key);
            
         
              
                if($key[0][7]!='pilihan C'){
                  
                    if($key[0][7]==null){
                        $a =   $img_gambar_tes_jawaban_c[$kosong_c++];
                    }else{
                        $a = "";
                    }


                 

                  $data_image_jawaban_c[$key[0][3]] = array(
                      'img_jawaban_c'=>$a,
                      'pertanyaan_img_jawaban_c'=>$key[0][7],
                      'pertanyaan'=>$key[0][3],
                  );

                }   
              
          }


          //jawaban_d

          $no=0;
          $kosong_d = 0;
          foreach($rowData as $c => $key){
            
             
              
                if($key[0][8]!='pilihan D'){
                
                    if($key[0][8]==null){
                        $a =   $img_gambar_tes_jawaban_d[$kosong_d++];
                    }else{
                        $a = "";
                    }

               

                  $data_image_jawaban_d[$key[0][3]] = array(
                      'img_jawaban_d'=>$a,
                      'pertanyaan_img_jawaban_d'=>$key[0][8],
                      'pertanyaan'=>$key[0][3],
                  );

                }   
              
          }



          //jawaban_e

          $no=0;
          $kosong_e = 0;
          foreach($rowData as $c => $key){
            
            
              
                if($key[0][9]!='pilihan E'){
                    
                    if($key[0][9]==null){
                        $a =   $img_gambar_tes_jawaban_e[$kosong_e++];
                    }else{
                        $a = "";
                    }

               

                  $data_image_jawaban_e[$key[0][3]] = array(
                      'img_jawaban_e'=>$a,
                      'pertanyaan_img_jawaban_e'=>$key[0][9],
                      'pertanyaan'=>$key[0][3],
                  );

                }   
              
          }


          foreach($rowData as $key => $d)
          {


            // echo "<pre>";
            // print_r($d);
                   
                  error_reporting(0);
                  if($d[0][3]!=null){
                      if($d[0][3]=="pertanyaan"){
  
                      }else{   
                          
                        // echo "<pre>";
                        // print_r($data_image[$d[0][0]]);

                        // echo "<pre>";
                        // print_r($data_image_jawaban_a[$d[0][3]]);


                        // print_r($d[0][5]);

                        if($d[0][0]==null){
                            $gam = $data_image[$d[0][3]]['img'];
                          //   $gam = 'tes';
                         }else{
                             $gam = $d[0][0];
                         }

                         // echo "<pre>";
                         // print_r($gam);
 
                         // die;

                         if($d[0][11]==null){
                             $gam_pembahasan = $data_image_pembahasan[$d[0][3]]['img_pembahasan'];
                         }else{
                             $gam_pembahasan = $d[0][11];
                         }


                            if($d[0][5]==null){
                                $gam_jawaban_a = $data_image_jawaban_a[$d[0][3]]['img_jawaban_a'];
                            }else{
                                $gam_jawaban_a = $d[0][5];

                             // $gam_jawaban_a = $data_image_jawaban_a[$d[0][5]]['img_jawaban_a'];
                            }


                            if($d[0][6]==null){
                                $gam_jawaban_b = $data_image_jawaban_b[$d[0][3]]['img_jawaban_b'];
                            }else{
                                $gam_jawaban_b = $d[0][6];
                            }


                            if($d[0][7]==null){
                                $gam_jawaban_c = $data_image_jawaban_c[$d[0][3]]['img_jawaban_c'];
                            }else{
                                $gam_jawaban_c = $d[0][7];
                            }


                            if($d[0][8]==null){
                                $gam_jawaban_d = $data_image_jawaban_d[$d[0][3]]['img_jawaban_d'];
                            }else{
                                $gam_jawaban_d = $d[0][8];
                            }


                            if($d[0][9]==null){
                                $gam_jawaban_e = $data_image_jawaban_e[$d[0][3]]['img_jawaban_e'];
                            }else{
                                $gam_jawaban_e = $d[0][9];
                            }


                            // echo "<pre>";
                            // print_r($gam_jawaban_c);
                            




                           $data_data[] = array(
                             'img'=>$gam,
                             'pertanyaan'=>$d[0][3],
                             'pertanyaan_img'=>$key[0][0],
                             'jawaban'=>$d[0][4],

                            // 'pilihan_a'=>$d[0][5],
                            //  'pilihan_b'=>$d[0][6],
                            //  'pilihan_c'=>$d[0][7],
                            //  'pilihan_d'=>$d[0][8],
                            //  'pilihan_e'=>$d[0][9],

                             'pilihan_a'=>$gam_jawaban_a,
                             'pilihan_b'=>$gam_jawaban_b,
                             'pilihan_c'=>$gam_jawaban_c,
                             'pilihan_d'=>$gam_jawaban_d,
                             'pilihan_e'=>$gam_jawaban_e,

                            

                             'pembahasan'=>$d[0][10],
                             
                            'pembahasan_img'=>$gam_pembahasan,
                            'img_pembahasan_text'=>$gam_pembahasan,
                            
                           );
                      }

                }
                
        }      

        
        //   echo "<pre>";
        //   print_r($data_data);

        //   die;


          foreach($data_data as $d){



            $pilihan = array(
                array(
                    'code'=>'1',
                    'name'=>$d['pilihan_a'],
                ),

                array(
                    'code'=>'2',
                    'name'=>$d['pilihan_b'],
                ),

                array(
                    'code'=>'3',
                    'name'=>$d['pilihan_c'],
                ),

                array(
                    'code'=>'4',
                    'name'=>$d['pilihan_d'],
                ),

                array(
                    'code'=>'5',
                    'name'=>$d['pilihan_e'],
                ),
            );

            if($d['jawaban']=="A"){
                $jawaban = 1;
            }elseif($d['jawaban']=="B"){
                $jawaban = 2;
            }elseif($d['jawaban']=="C"){
                $jawaban = 3;
            }elseif($d['jawaban']=="D"){
                $jawaban = 4;
            }elseif($d['jawaban']=="E"){
                $jawaban = 5;
            } 


            $data_insert = array(
                'materi_id'=>$materi_id,
                'pertanyaan'=>$d['pertanyaan'],
                'jawaban'=>$jawaban,
                'bobot'=>'5',
                'waktu'=>'5',
                'pilihan'=>json_encode($pilihan),
                'create_add'=>date("Y-m-d H:i:s"),
                'img'=>$d['img'],
                'pertanyaan_img'=>"",
                'pembahasan'=>$d['pembahasan'],
                'pembahasan_img'=>$d['pembahasan_img'],
                  
                
            );

            $this->db->insert('soalonline',$data_insert);
          }
  
        

        


           
         
     

                   

        if($simpan){

            $sess = $this->session->userdata();
       $data_log = array(
         'aktifitas'=>$sess['pegawai']->username.''.' Menambahkan Materi '.$Materi.' id '.$materi_id,
         'datetime'=>date('Y-m-d H:i:s'),
       );

       $this->db->insert('log',$data_log);


            $this->session->set_flashdata('status',"success");
             $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");
             
             redirect('master/Materi/index/'.base64_encode($id_event));
         
         }else{
 
         }


      }
      else
      {

        echo "gagal";
        
      }

       
       
    }

    function update($id,$id_event){
         
        $data['materi'] = $this->Materi_M->getById(base64_decode($id));

        $event = $this->db->query("select * from event where id_event=".base64_decode($id_event))->row();
         // $data["jurusan"] = $this->Jurusan_M->getByIdJenis($event->id_jenis);

          $data["jenis"] = $this->Jenis_M->getByKategori($event->id_kategori);


        //       echo "<pre>";
        //   print_r($data["jurusan"]);
         
          $data['id'] = $id;

        $data['id_event'] = base64_decode($id_event);
        $data["title"] = "List Data Master Materi";
        $this->template->load('template','materi/materi_edit',$data);
    }

    function update_simpan(){
        $Materi_id  = $this->input->post('materi_id');
        $Materi_nama  = $this->input->post('materi');
        $id_event = $this->input->post('id_event');
        $no_urut =  $this->input->post('no_urut');

         $id_jenis =  $this->input->post('id_jenis');


        
      

        $simpan = $this->Materi_M->update($Materi_id,$Materi_nama,$no_urut,$id_jenis);

        if($simpan){


            $sess = $this->session->userdata();
            $data_log = array(
              'aktifitas'=>$sess['pegawai']->username.''.' Mengedit Materi '.$Materi_nama.' id '.$Materi_id,
              'datetime'=>date('Y-m-d H:i:s'),
            );
     
            $this->db->insert('log',$data_log);



           $this->session->set_flashdata('status',"success");
			$this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b>  Data berhasil di simpan");
            
            redirect('master/Materi/index/'.base64_encode($id_event));
        
        }else{

        }

    }

    function hapus(){
        $materi_id = $this->input->post('id');

		$this->db->where('materi_id',$materi_id);
		$sql = $this->db->delete('materi');


        $this->db->where('materi_id',$materi_id);
		$soalonline = $this->db->delete('soalonline');

        $this->db->where('materi_id',$materi_id);
		$jawaban = $this->db->delete('jawaban');


        $sess = $this->session->userdata();
        $data_log = array(
          'aktifitas'=>$sess['pegawai']->username.''.' Menghapus Materi id '.$materi_id,
          'datetime'=>date('Y-m-d H:i:s'),
        );
 
        $this->db->insert('log',$data_log);




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


    function ajax_jurusan(){
             $id_jenis = $this->input->post('id_jenis');

             $jurusan = $this->db->query('select * from jurusan where id_jenis="'.$id_jenis.'"')->result();

             
             foreach ($jurusan as $j) {
                                     
                  echo   '<option value="'.$j->id_jurusan.'">'.$j->jurusan_nama.'</option>';
            }
    }


    function sort_array_of_array(&$array, $subfield)
{
    $sortarray = array();
    foreach ($array as $key => $row)
    {
        $sortarray[$key] = $row[$subfield];
    }

    array_multisort($sortarray, SORT_ASC, $array);
}


    function upload_soal(){

    //     $age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");


    //     $cars = array(
    //       '2' => 'sln-L24956.png',
    //       '13' => 'sln-L139864.png',
    //       '12' => 'sln-L126351.png',
    //       '10' => 'sln-L109052.png',
    //       '9' => 'sln-L91055.png',
    //       '4' => 'sln-L42814.png',
    //       '3' => 'sln-L39014.png',
    //       '11' => 'sln-L116710.png',
    //       '6' => 'sln-L67479.png',
    //       '8' => 'sln-L85653.png',
    //       '5' => 'sln-L52991.png',
    //   );

    //    //sort($cars);

    //     // $clength = count($cars);
    //     // for($x = 0; $x < $clength; $x++) {
    //     // echo $cars[$x];
    //     // echo "<br>";
    //     // }

    //     ksort($cars);

    // // foreach($cars as $x => $x_value) {
    // //         echo "Key=" . $x . ", Value=" . $x_value;
    // //         echo "<br>";
    // // }


    // //   echo "<pre>";
    // //   print_r($age);

    //   echo "<pre>";
    //   print_r($cars);
        


    //     die;

        error_reporting(0);
        $materi_id = 10;
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
                            
                            $cek_row = substr($drawing->getCoordinates(),0,1);

                            // gambar image
                            if($cek_row=='A'){
                                $img_gambar = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes[] = $img_gambar;

                                //$kordinat_img[] = $drawing->getCoordinates();
                                copy($filename, 'assets/file_upload/soalonline/soal/' . $img_gambar);


                               // pembasahan
                            }elseif($cek_row=='L'){

                               $img_gambar_pembahasan = "sln-" . $drawing->getCoordinates() .date('Ymd'). mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                               
                                $kordinat =   str_replace("L","",$drawing->getCoordinates());
                               $img_gambar_tes_pembahasan[$kordinat-2] = $img_gambar_pembahasan;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                             copy($filename, 'assets/file_upload/soalonline/pembahasan/' . $img_gambar_pembahasan);

                                ksort($img_gambar_tes_pembahasan);

                            //jawaban a 
                            }elseif($cek_row=='F'){

                                $img_gambar_jawaban_a = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes_jawaban_a[] = $img_gambar_jawaban_a;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                            copy($filename, 'assets/file_upload/soalonline/jawaban_a/' . $img_gambar_jawaban_a);

                            
                                //jawaban b
                             }elseif($cek_row=='G'){

                                $img_gambar_jawaban_b = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes_jawaban_b[] = $img_gambar_jawaban_b;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                                copy($filename, 'assets/file_upload/soalonline/jawaban_b/' . $img_gambar_jawaban_b);

                            


                                //jawaban c
                            }elseif($cek_row=='H'){

                                $img_gambar_jawaban_c = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes_jawaban_c[] = $img_gambar_jawaban_c;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                                copy($filename, 'assets/file_upload/soalonline/jawaban_c/' . $img_gambar_jawaban_c);

                                 //jawaban d
                            }elseif($cek_row=='I'){

                                $img_gambar_jawaban_d = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes_jawaban_d[] = $img_gambar_jawaban_d;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                                copy($filename, 'assets/file_upload/soalonline/jawaban_d/' . $img_gambar_jawaban_d);

                                 //jawaban e
                            }elseif($cek_row=='J'){

                                $img_gambar_jawaban_e = "sln-" . $drawing->getCoordinates() . mt_rand(1000, 9999) .'.'. $drawing->getExtension();
                                $img_gambar_tes_jawaban_e[] = $img_gambar_jawaban_e;
                                //$kordinat_pembahasan[] = $drawing->getCoordinates();
                                copy($filename, 'assets/file_upload/soalonline/jawaban_e/' . $img_gambar_jawaban_e);

                            }

    
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

          array_shift($rowData);  


                    //$objWorksheet  = $exceldata->getSheet(1);
					$data = $sheet->toArray();



        //             // jajal
        //             $no=0;
        //   foreach($rowData as $c => $key){
              
        //         if($key[0][5]!='pilihan A'){
                   
        //                 $ab[] = $key[0][5];
                    
        //         }   
             
        //   }

        
        
        //  echo "<pre>";
        //  print_r($rowData);
         

        //   die;

                    
          //pertanyaan img
          $no_img=0;
          foreach($rowData as $c => $key){
              

          


                if($key[0][0]!='img'){
                  
                   

                    if($key[0][0]==null){
                        $a =   $img_gambar_tes[$no_img++];

                        
                    }else{
                        $a = "";
                    }
                    
                  $data_image[$key[0][3]] = array(
                      'img'=>$a,
                      'pertanyaan_img'=>$key[0][0],
                      'pertanyaan'=>$key[0][3],
                  );

                }   
              
          }


        //   echo "<pre>";
        //   print_r($img_gambar_tes_pembahasan);
        //   die;
          

          //pemabahsan img

         

        //   foreach($img_gambar_tes_pembahasan2 as $a ){
        //     $img_gambar_tes_pembahasan[] = $a;
        //  }
         

         

          $no_pembahasan=0;
          foreach($rowData as $c => $key){
            
             
              
                if($key[0][11]!='pembahasan_img'){
                   
                    if($key[0][11]==null){
                        $a =   $img_gambar_tes_pembahasan[$no_pembahasan++];

                    }else{
                        $a = "";
                    }

               

                  $data_image_pembahasan[$key[0][3]] = array(
                      'img_pembahasan'=>$a,
                      'pertanyaan_img_pembahasan'=>$key[0][11],
                      'pertanyaan'=>$key[0][3],
                      
                  );

                }   
             
          }

        //   echo "tes";

        //   echo "<pre>";
        //   print_r($data_image_pembahasan);

        //   die;


          //jawaban_a

        
          $no=0;
          $kosong_a = 0;
          foreach($rowData as $c => $key){
                if($key[0][5]!='pilihan A'){
                    if($key[0][5]==null){
                        $a =   $img_gambar_tes_jawaban_a[$kosong_a++];
                    }else{
                        $a = "";
                    }
                  $data_image_jawaban_a[$key[0][3]] = array(
                      'img_jawaban_a'=>$a,
                      'pertanyaan_img_jawaban_a'=>$key[0][5],
                      'pertanyaan'=>$key[0][3],
                      //'no'=>$kosong,
                  );
                }   
          }

          //jawaban b
          $no=0;
          $kosong_b = 0;
          foreach($rowData as $c => $key){
                if($key[0][6]!='pilihan B'){
                    
                    if($key[0][6]==null){
                        $a =   $img_gambar_tes_jawaban_b[$kosong_b++];
                    }else{
                        $a = "";
                    }

              

                  $data_image_jawaban_b[$key[0][3]] = array(
                      'img_jawaban_b'=>$a,
                      'pertanyaan_img_jawaban_b'=>$key[0][6],
                      'pertanyaan'=>$key[0][3],
                  );

                }   
              
          }


          //jawaban_c

          $no=0;
          $kosong_c=0;
          foreach($rowData as $c => $key){


            // echo "<pre>";
            // print_r($key);
            
         
              
                if($key[0][7]!='pilihan C'){
                  
                    if($key[0][7]==null){
                        $a =   $img_gambar_tes_jawaban_c[$kosong_c++];
                    }else{
                        $a = "";
                    }


                 

                  $data_image_jawaban_c[$key[0][3]] = array(
                      'img_jawaban_c'=>$a,
                      'pertanyaan_img_jawaban_c'=>$key[0][7],
                      'pertanyaan'=>$key[0][3],
                  );

                }   
              
          }


          //jawaban_d

          $no=0;
          $kosong_d = 0;
          foreach($rowData as $c => $key){
            
             
              
                if($key[0][8]!='pilihan D'){
                
                    if($key[0][8]==null){
                        $a =   $img_gambar_tes_jawaban_d[$kosong_d++];
                    }else{
                        $a = "";
                    }

               

                  $data_image_jawaban_d[$key[0][3]] = array(
                      'img_jawaban_d'=>$a,
                      'pertanyaan_img_jawaban_d'=>$key[0][8],
                      'pertanyaan'=>$key[0][3],
                  );

                }   
              
          }



          //jawaban_e

          $no=0;
          $kosong_e = 0;
          foreach($rowData as $c => $key){
            
            
              
                if($key[0][9]!='pilihan E'){
                    
                    if($key[0][9]==null){
                        $a =   $img_gambar_tes_jawaban_e[$kosong_e++];
                    }else{
                        $a = "";
                    }

               

                  $data_image_jawaban_e[$key[0][3]] = array(
                      'img_jawaban_e'=>$a,
                      'pertanyaan_img_jawaban_e'=>$key[0][9],
                      'pertanyaan'=>$key[0][3],
                  );

                }   
              
          }


          foreach($rowData as $key => $d)
          {


            // echo "<pre>";
            // print_r($d);
                   
                  error_reporting(0);
                  if($d[0][3]!=null){
                      if($d[0][3]=="pertanyaan"){
  
                      }else{   
                          
                        // echo "<pre>";
                        // print_r($d);

                        // echo "<pre>";
                        // print_r($data_image[$d[0][3]]['img']);

                        // die;

                        // die;

                        // die;


                        // print_r($d[0][5]);

                            if($d[0][0]==null){
                               $gam = $data_image[$d[0][3]]['img'];
                             //   $gam = 'tes';
                            }else{
                                $gam = $d[0][0];
                            }

                          
    
                            // die;

                            if($d[0][11]==null){
                                $gam_pembahasan = $data_image_pembahasan[$d[0][3]]['img_pembahasan'];
                            }else{
                                $gam_pembahasan = $d[0][11];
                            }

                            // echo "<pre>";
                            // echo print_r($data_image_pembahasan);


                            if($d[0][5]==null){
                                $gam_jawaban_a = $data_image_jawaban_a[$d[0][3]]['img_jawaban_a'];
                            }else{
                                $gam_jawaban_a = $d[0][5];

                             // $gam_jawaban_a = $data_image_jawaban_a[$d[0][5]]['img_jawaban_a'];
                            }


                            if($d[0][6]==null){
                                $gam_jawaban_b = $data_image_jawaban_b[$d[0][3]]['img_jawaban_b'];
                            }else{
                                $gam_jawaban_b = $d[0][6];
                            }


                            if($d[0][7]==null){
                                $gam_jawaban_c = $data_image_jawaban_c[$d[0][3]]['img_jawaban_c'];
                            }else{
                                $gam_jawaban_c = $d[0][7];
                            }


                            if($d[0][8]==null){
                                $gam_jawaban_d = $data_image_jawaban_d[$d[0][3]]['img_jawaban_d'];
                            }else{
                                $gam_jawaban_d = $d[0][8];
                            }


                            if($d[0][9]==null){
                                $gam_jawaban_e = $data_image_jawaban_e[$d[0][3]]['img_jawaban_e'];
                            }else{
                                $gam_jawaban_e = $d[0][9];
                            }


                            // echo "<pre>";
                            // print_r($gam_jawaban_c);
                            




                           $data_data[] = array(
                             'img'=>$gam,
                             'pertanyaan'=>$d[0][3],
                             'jawaban'=>$d[0][4],

                            // 'pilihan_a'=>$d[0][5],
                            //  'pilihan_b'=>$d[0][6],
                            //  'pilihan_c'=>$d[0][7],
                            //  'pilihan_d'=>$d[0][8],
                            //  'pilihan_e'=>$d[0][9],

                             'pilihan_a'=>$gam_jawaban_a,
                             'pilihan_b'=>$gam_jawaban_b,
                             'pilihan_c'=>$gam_jawaban_c,
                             'pilihan_d'=>$gam_jawaban_d,
                             'pilihan_e'=>$gam_jawaban_e,

                            

                             'pembahasan'=>$d[0][10],
                              'pembahasan_img'=>$gam_pembahasan,
                            //'pembahasan_img'=>$d[0][11],
                           );
                      }

                }
                
        }    
        
        
       

        
          echo "<pre>";
          print_r($data_data);

          die;

      


          foreach($data_data as $d){



            $pilihan = array(
                array(
                    'code'=>'1',
                    'name'=>$d['pilihan_a'],
                ),

                array(
                    'code'=>'2',
                    'name'=>$d['pilihan_b'],
                ),

                array(
                    'code'=>'3',
                    'name'=>$d['pilihan_c'],
                ),

                array(
                    'code'=>'4',
                    'name'=>$d['pilihan_d'],
                ),

                array(
                    'code'=>'5',
                    'name'=>$d['pilihan_e'],
                ),
            );

            if($d['jawaban']=="A"){
                $jawaban = 1;
            }elseif($d['jawaban']=="B"){
                $jawaban = 2;
            }elseif($d['jawaban']=="C"){
                $jawaban = 3;
            }elseif($d['jawaban']=="D"){
                $jawaban = 4;
            }elseif($d['jawaban']=="E"){
                $jawaban = 5;
            } 


            $data_insert = array(
                'materi_id'=>$materi_id,
                'pertanyaan'=>$d['pertanyaan'],
                'jawaban'=>$jawaban,
                'bobot'=>'5',
                'waktu'=>'5',
                'pilihan'=>json_encode($pilihan),
                'create_add'=>date("Y-m-d H:i:s"),
                'img'=>$d['img'],
                'pertanyaan_img'=>"",
                'pembahasan'=>$d['pembahasan'],
                  
                
            );

          //  $this->db->insert('soalonline',$data_insert);
          }
  
        }
    }


    function publish($materi_id2,$id_event){

        //     echo $id_event;
        // die;
         $materi_id = base64_decode($materi_id2);

         $data_publsih = array(
             'publish' => 1,
         );

         $this->db->where('materi_id',$materi_id);
         $this->db->update('materi',$data_publsih);


         $sess = $this->session->userdata();
         $data_log = array(
           'aktifitas'=>$sess['pegawai']->username.''.' Publish Materi id '.$materi_id,
           'datetime'=>date('Y-m-d H:i:s'),
         );
  
         $this->db->insert('log',$data_log);

         $this->session->set_flashdata('status',"success");
             $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Materi Sudah Aktif");
             

         redirect('master/Materi/index/'.$id_event);
    }

    







    
    
}
