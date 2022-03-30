<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Absen extends CI_Controller
{


    function __construct(){
		parent::__construct();
		// if(!$this->session->userdata(['pegawai']['kar_pvl']=='U')){
		// 	redirect('auth');
		// }

        if ($this->session->userdata['pegawai'] == TRUE)
        {
            //do something
            $this->load->model(array('Absen_M'));
        }
        else
        {
            redirect('auth'); //if session is not there, redirect to login page
        }   
      
		
    }


    // redirect if needed, otherwise display the user list
    public function index()
    {

       

        $data["title"] = "List Data Master Divisi";
        $this->template->load('template','absen/upload_jadwal',$data);
     
    }

    function upload_jadwal(){

        $data["title"] = "List Data Master Divisi";
        $this->template->load('template','absen/upload_jadwal',$data);

    }

    function simpan_upload_jadwal()
    {


        $bulan = $this->input->post('bulan');
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

                 $highestRow;

                
              for($row=0; $row<=$highestRow; $row++)
              {
  
                  $nim = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                  $nama = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                  $angkatan = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                 // $angkatan2 = $xls->getActiveSheet()->getCellByColumnAndRow(1, $row)->getCalculatedValue();

                 $rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);



              } 
  
          }


        $jumlah_hari = count($rowData[0][0])-3;


          // menghapus dupliakat
                $record = array();
                $name = array();
                foreach($rowData as $key=>$value)
                {
                    if(!in_array($value[0][1], $name))
                    {
                        $name[] = $value[0][1];
                        $record[$key] = $value;
                    }

                }
        // echo "<pre>";
        // print_r($record);

        // die;


        // //  echo "<pre>";
        // //  print_r($rowData);

        // die;

        foreach($record as $d)
        {

            // echo "<pre>";
            // print_r($d[0]);
            $sql = $this->db->query("select id_karyawan,ktr_id from m_karyawan where nik_kantor = '".$d[0][1]."'")->row();

            //check
            if($sql)
            {
                    
                //  $data_kar = $sql;
                // echo "<pre>";
                // print_r($d);

                 $i = 3;
                 $xx = 01;
                 for ($x = 1; $x <= $jumlah_hari; $x++) 
                {

                   
                  // echo "The number is: ".str_pad($xx++, 2, '0', STR_PAD_LEFT)." <br>";

                    $tgl_hari = str_pad($xx++, 2, '0', STR_PAD_LEFT);


                    $sql_cek = $this->db->query("select * from jadwal where tanggal = '".$bulan.'-'.$tgl_hari."' and id_karyawan = '".$sql->id_karyawan."'")->row();

                    

                    if($sql_cek){

                        $data_insert = array(
                            'id_karyawan'=>$sql->id_karyawan,
                            'jenis_masuk'=>$d[0][$i++],
                            'tanggal'=>$bulan.'-'.$tgl_hari,
                            'id_ktr'=>$sql->ktr_id,
                            'ket'=>'',
                        );

                        $this->db->update('jadwal',$data_insert,array('id_jadwal'=>$sql_cek->id_jadwal));

                    }else{

                        $data_insert = array(
                            'id_karyawan'=>$sql->id_karyawan,
                            'jenis_masuk'=>$d[0][$i++],
                            'tanggal'=>$bulan.'-'.$tgl_hari,
                            'id_ktr'=>$sql->ktr_id,
                            'ket'=>'',
                        );

                        $this->db->insert('jadwal',$data_insert);
                    }

                
                }


              

                
            }else{
                 
            }
            
        }

          redirect('absen/upload_jadwal');


      }
      else
      {

        echo "gagal";
        //    $message = array(
        //       'message'=>'<div class="alert alert-danger">Import file gagal, coba lagi</div>',
        //   );
          
        //   $this->session->set_flashdata($message);
        //   redirect('import');
      }
    }



    function jadwal(){

        $sess = $this->session->userdata();

        $id_kar = $sess['pegawai']['id_kar'];

        $level = $sess['pegawai']['level'];

        

        if($level=='A'){
            $data['jadwal'] = $this->db->query("select j.*,m.nama_karyawan from jadwal as j
            inner join m_karyawan as m on m.id_karyawan = j.id_karyawan")->result();
        }else{
            $data['jadwal'] = $this->db->query("select j.*,m.nama_karyawan from jadwal as j
            inner join m_karyawan as m on m.id_karyawan = j.id_karyawan where  j.id_karyawan = '".$id_kar."'")->result();
        }

      
      

      
        $data["title"] = "List Data Master Jadwal";
        $this->template->load('template','absen/v_jadwal',$data);
     
    }


  


    
    
}
