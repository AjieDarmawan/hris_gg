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

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_Materi->no_urut;
            $row[] = $data_Materi->jenis_nama;
            $row[] = $data_Materi->materi_nama;
           	$row[] = $edit." ".$delete." ".$lihat_soal;

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

                            array(
                                'code'=>'5',
                                'name'=>$d[0][9],
                            ),
                        );

                        // echo "<pre>";
                        // print_r($rowData);
                        // die;


                        if($d[0][4]=="A"){
                            $jawaban = 1;
                        }elseif($d[0][4]=="B"){
                            $jawaban = 2;
                        }elseif($d[0][4]=="C"){
                            $jawaban = 3;
                        }elseif($d[0][4]=="D"){
                            $jawaban = 4;
                        }elseif($d[0][4]=="E"){
                            $jawaban = 5;
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
                                        'pembahasan'=>$d[0][10],
                                        
                                          
                                        
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
                                        'pembahasan'=>$d[0][10],
                                          
                                        
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
                                'pembahasan'=>$d[0][10],
                                  
                                
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
            
        // $this->session->set_flashdata('message', "<b>Success <i class='fa fa-check-square-o'></i></b> Tambah data berhasil");  
        //   redirect('master/soal');

        if($simpan){
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







    
    
}
