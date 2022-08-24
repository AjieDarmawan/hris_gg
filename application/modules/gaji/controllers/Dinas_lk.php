<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dinas_lk extends CI_Controller
{


    function __construct(){
		parent::__construct();
		if(!$this->session->userdata()['pegawai']){
			redirect('auth');
		}
        $this->load->model(array('Dinas_lk_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
      

        //$data["divisi"] = $this->Dinas_lk_M->getAll();
        $data["title"] = "List Data Master Dinas_lk";
        $this->template->load('template','dinas_lk/dinas_lk_v',$data);
     
    }


    public function ajax_list()
    {
        header('Content-Type: application/json');
        $list = $this->Dinas_lk_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_dinas_lk) {


         
			$tgl1 = new DateTime($data_dinas_lk->tgl_mulai);
            $tgl2 = new DateTime($data_dinas_lk->tgl_selesai);
            $jarak = $tgl2->diff($tgl1);



            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_dinas_lk->kar_nik;
            $row[] = $data_dinas_lk->kar_nm;
            $row[] = $data_dinas_lk->kunjungan;
            $row[] = $data_dinas_lk->keterangan;
            $row[] = date('d-m-Y',strtotime($data_dinas_lk->tgl_mulai)).'-'.  date('d-m-Y',strtotime($data_dinas_lk->tgl_selesai));
            
            $row[] = $jarak->d;
            $row[] = number_format($jarak->d*40000);
          
           
          
            
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Dinas_lk_M->count_all(),
            "recordsFiltered" => $this->Dinas_lk_M->count_filtered(),
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
                $bulan_dibayarkan  = $this->input->post('bulan_dibayarkan');
         
               

                $nik = $k[0][0];
               
                $jumlah = $k[0][1];

                $insert_nik = $this->db->query("select * from kar_master where kar_nik='".$nik."'")->row();
              

                $data_simpan = array(
                    'kar_id'=> $insert_nik->kar_id,
                    'nik'=>$nik,
                    //'nama'=>$nama,
                    'jumlah'=>$jumlah,
                    'crdt'=>date('Y-m-d H:i:s'),
                    'bulan'=>$bulan,
                    'bulan_dibayarkan'=>$bulan_dibayarkan,


                );

                $cek_update = $this->db->query("select * from payroll.dinas_lk where nik='".$nik."'")->row();

                if($cek_update){
                    $this->db->update('payroll.dinas_lk',$data_simpan,array('nik',$nik));
                }else{
                    $this->db->insert('payroll.dinas_lk',$data_simpan);
                }
               

            }

          }

              $message = array(
              'message'=>'<div class="alert alert-success">Import file Suksess</div>',
          );
           $this->session->set_flashdata($message);
          redirect('gaji/dinas_lk');


      
            
       


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

    

    
   


    
    
}
