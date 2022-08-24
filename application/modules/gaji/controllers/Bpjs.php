<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bpjs extends CI_Controller
{


    function __construct(){
		parent::__construct();
		if(!$this->session->userdata()['pegawai']){
			redirect('auth');
		}
        $this->load->model(array('Bpjs_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
      

        //$data["divisi"] = $this->Bpjs_M->getAll();
        $data["title"] = "List Data Master Bpjs";
        $this->template->load('template','bpjs/bpjs_v',$data);
     
    }


    public function ajax_list()
    {

        error_reporting(0);
        header('Content-Type: application/json');
        $list = $this->Bpjs_M->get_datatables();

        

     
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_bpjs) {

          $plus_tiga_bulan =  date('Y-m-d', strtotime('+3 month', strtotime($data_bpjs->kar_dtl_tgl_joi)));
           
          if($plus_tiga_bulan>=date('Y-m-d')){
              $custom = " Belum dapet";
          }else{
             $custom = "";
          }
           

            $tot_gaji = $this->db->query('select sum(gaji_pokok+t_struktural+t_fungsional+t_umum+t_kinerja) as tot from payroll.komponen_gaji where kar_id =  "'.$data_bpjs->kar_id.'"')->row();

            $tot_gaji_aa = $this->db->query('select sum(gaji_pokok+t_struktural) as tot from payroll.komponen_gaji where kar_id =  "'.$data_bpjs->kar_id.'"')->row();
            
            $total_gaji = $tot_gaji->tot;

            $tot_gaji_a = $tot_gaji_aa->tot;

            $bpjs_default = 4217206;


            //12000000
            if($total_gaji>=$bpjs_default){
                // A 

                if($tot_gaji_a>$bpjs_default){

                    $bpjs_k  = $tot_gaji_a*1/100;
                    $bpjs_pk = $tot_gaji_a*4/100;
    
                    $jht_k  = $tot_gaji_a*2/100;
                    $jht_pk = $tot_gaji_a*3.70/100;
    
                    $jp_k  = $tot_gaji_a*1/100;
                    $jp_pk  = $tot_gaji_a*2/100;
    
                    $jkk_pk = $tot_gaji_a*0.24/100;
                    $jkm_pk = $tot_gaji_a*0.30/100;
    
                   

                    $gaji_bpjs = $tot_gaji_a;

                }else{
                    $bpjs_k  = $bpjs_default*1/100;
                    $bpjs_pk = $bpjs_default*4/100;

                    $jht_k  = $bpjs_default*2/100;
                    $jht_pk = $bpjs_default*3.70/100;

                    $jp_k  = $bpjs_default*1/100;
                    $jp_pk  = $bpjs_default*2/100;

                    $jkk_pk = $bpjs_default*0.24/100;
                    $jkm_pk = $bpjs_default*0.30/100;

                    

                    $gaji_bpjs = $bpjs_default;
                }

            }elseif($total_gaji>=12000000){
                // A + B;

                $bpjs_k  = $tot_gaji_a*1/100;
                $bpjs_pk = $tot_gaji_a*4/100;

                $jht_k  = $tot_gaji_a*2/100;
                $jht_pk = $tot_gaji_a*3.70/100;

                $jp_k  = $tot_gaji_a*1/100;
                $jp_pk  = $tot_gaji_a*2/100;

                $jkk_pk = $tot_gaji_a*0.24/100;
                $jkm_pk = $tot_gaji_a*0.30/100;

                

                $gaji_bpjs = $tot_gaji_a;
         

            }


            
			

            $no++;
            $row = array();
            $row[] = $no.$custom;
            $row[] = $data_bpjs->kar_nik;
            $row[] = $data_bpjs->kar_nm;
            $row[] = date('d-M-Y',strtotime($data_bpjs->kar_dtl_tgl_joi));
            $row[] = number_format($gaji_bpjs);
            $row[] = number_format($tot_gaji->tot);
            $row[] = $data_bpjs->kar_dtl_sts_nkh;
            $row[] = $data_bpjs->kar_dtl_jml_ank;
            $row[] = number_format($bpjs_k);
            $row[] = number_format($jht_k);
            $row[] = number_format($jp_k);
           
            $row[] = number_format($bpjs_pk);
            $row[] = number_format($jkk_pk);
            $row[] = number_format($jht_pk);
            $row[] = number_format($jkm_pk);
            $row[] = number_format($jp_pk);
           
           
          
           
          
            
          

            $data[] = $row;

        
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Bpjs_M->count_all(),
            "recordsFiltered" => $this->Bpjs_M->count_filtered(),
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

                $cek_update = $this->db->query("select * from payroll.bpjs where nik='".$nik."'")->row();

                if($cek_update){
                    $this->db->update('payroll.bpjs',$data_simpan,array('nik',$nik));
                }else{
                    $this->db->insert('payroll.bpjs',$data_simpan);
                }
               

            }

          }

              $message = array(
              'message'=>'<div class="alert alert-success">Import file Suksess</div>',
          );
           $this->session->set_flashdata($message);
          redirect('gaji/bpjs');


      
            
       


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


    function croscek(){


       $data['bpjs'] = $this->db->query('select d.kar_dtl_sts_nkh,d.kar_dtl_jml_ank, k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() order by k.ktr_id asc')->result();;

       

       $data["title"] = "List Data BPJS";
       $this->template->load('template','bpjs/cross_cek',$data);

    }

    function download_excel(){


        $data['bpjs'] = $this->db->query('select d.kar_dtl_sts_nkh,d.kar_dtl_jml_ank,k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() order by k.ktr_id asc')->result();;

        

        $this->load->view('bpjs/download_excel',$data);

    }

    

    
   


    
    
}
