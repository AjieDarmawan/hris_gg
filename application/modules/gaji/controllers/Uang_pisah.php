<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Uang_Pisah extends CI_Controller
{


    function __construct(){
		parent::__construct();
		if(!$this->session->userdata()['pegawai']){
			redirect('auth');
		}
        $this->load->model(array('Uang_Pisah_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
           
        $tahun = date('Y');
        $data['risen'] = $this->db->query("select year(kar_dtl_tgl_res) as tahun, k.kar_id,k.kar_nm,k.kar_nik from kar_master as k inner join kar_detail as d on k.kar_id = d.kar_id 
        where d.kar_dtl_tgl_res != '0000-00-00' and year(kar_dtl_tgl_res) = '".$tahun."'")->result();

        

        //$data["divisi"] = $this->Uang_Pisah_M->getAll();
        $data["title"] = "List Data  Uang Pisah";
        $this->template->load('template','uang_pisah/uang_pisah_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Uang_Pisah_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_uang_pisah) {


         
			

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_uang_pisah->kar_nik;
            $row[] = $data_uang_pisah->kar_nm;
            $row[] = date('M-Y',strtotime($data_uang_pisah->bulan));
            $row[] = number_format($data_uang_pisah->nominal);
          
           
          
            
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Uang_Pisah_M->count_all(),
            "recordsFiltered" => $this->Uang_Pisah_M->count_filtered(),
            "data" => $data,
        );
        //output to json format
        $this->output->set_output(json_encode($output));
    }


    function upload_excel(){
       
       
      
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
          
        //   echo "<pre>";
        //   print_r($rowData);
        //   die;
         

          foreach($rowData as $key => $k){

           

            if($k[0][0]!='nik' and $k[0][0]!='NIK' and $k[0][0]!=''){

                $bulan = $this->input->post('bulan');
         
               

                $nik = $k[0][0];
                $nama = $k[0][1];
                $no_pel = $k[0][2];
                $pam = $k[0][3];
                $uang_pisah = $k[0][4];
                $total = $k[0][5];

                $insert_nik = $this->db->query("select * from kar_master where kar_nik='".$nik."'")->row();
              

                $data_simpan = array(
                    'kar_id'=> $insert_nik->kar_id,
                    'nik'=>$nik,
                    //'nama'=>$nama,
                    'no_pel'=>$no_pel,
                    'pam'=>$pam,
                    'uang_pisah'=>$uang_pisah,
                    'total'=>$total,
                    'crdt'=>date('Y-m-d H:i:s'),
                    'bulan'=>$bulan,


                );

                $cek_update = $this->db->query("select * from payroll.uang_pisah where nik='".$nik."'")->row();

                if($cek_update){
                    $this->db->update('payroll.uang_pisah',$data_simpan,array('nik',$nik));
                }else{
                    $this->db->insert('payroll.uang_pisah',$data_simpan);
                }
               

            }

          }

              $message = array(
              'message'=>'<div class="alert alert-success">Import file Suksess</div>',
          );
           $this->session->set_flashdata($message);
          redirect('gaji/uang_pisah');


      
            
       


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


    function simpan(){
       $kar_id = $this->input->post('kar_id');
       $nominal = $this->input->post('nominal');
       $bulan = $this->input->post('bulan');

       $k = $this->db->query('select kar_nm,kar_nik from kar_master where kar_id="'.$kar_id.'"')->row();

       $data_simpan = array(
        'kar_id'=>$kar_id,
        'kar_nm'=>$k->kar_nm,
        'kar_nik'=>$k->kar_nik,
        'nominal'=>$nominal,
        'bulan'=>$bulan,
        'crdt'=>date('Y-m-d H:i:s'),
       );

       $this->db->insert('payroll.uang_pisah',$data_simpan);

              $message = array(
              'message'=>'<div class="alert alert-primary">Sukkses</div>',
          );
          
          $this->session->set_flashdata($message);
       redirect('gaji/uang_pisah');
    
    
    }

    

    
   


    
    
}
