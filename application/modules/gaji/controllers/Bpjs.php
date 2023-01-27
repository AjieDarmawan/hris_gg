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


           


            /////


            // if($data_bpjs->kar_nik=='SG.0675.2022' or $data_bpjs->kar_nik=='SG.0636.2021'){

            //     $bpjs_k  = 0;
            //     $bpjs_pk = 0;

            //     $jht_k  = 0;
            //     $jht_pk = 0;

            //     $jp_k  = 0;
            //     $jp_pk  = 0;

            //     $jkk_pk = 0;
            //     $jkm_pk = 0;

                

            //     $gaji_bpjs = 0;

            // }else{

            

          $plus_tiga_bulan =  date('Y-m-d', strtotime('+3 month', strtotime($data_bpjs->kar_dtl_tgl_joi)));
           
          if($plus_tiga_bulan>=date('Y-m-d')){
              $custom = " Belum dapet";
          }else{
             $custom = "";
          }
           

            $tot_gj = $this->db->query('select * from payroll.komponen_gaji where kar_id =  "'.$data_bpjs->kar_id.'"')->row();

            $array_gp = array(
                'cid' => (string)$tot_gj->nik,
                'secret' => (string)$tot_gj->kar_id,
                'data' => (string)$tot_gj->gaji_pokok,
                'action' => 'decrypt',
            );

            $gaji_pokok_en = educrypt($array_gp);


            $array_t_fungsional = array(
                'cid' => (string)$tot_gj->nik,
                'secret' => $tot_gj->kar_id,
                'data' => (string)$tot_gj->t_fungsional,
                'action' => 'decrypt',
            );

            $t_fungsional_en = educrypt($array_t_fungsional);


            $array_t_struktural = array(
                'cid' => (string)$tot_gj->nik,
                'secret' => $tot_gj->kar_id,
                'data' => (string)$tot_gj->t_struktural,
                'action' => 'decrypt',
            );

            $t_struktural_en = educrypt($array_t_struktural);


            $array_t_umum = array(
                'cid' => (string)$tot_gj->nik,
                'secret' => $tot_gj->kar_id,
                'data' => (string)$tot_gj->t_umum,
                'action' => 'decrypt',
            );

            $t_umum_en = educrypt($array_t_umum);

            $array_t_kinerja = array(
                'cid' => (string)$tot_gj->nik,
                'secret' => $tot_gj->kar_id,
                'data' => (string)$tot_gj->t_kinerja,
                'action' => 'decrypt',
            );

            $t_kinerja_en = educrypt($array_t_kinerja);

            $total_gaji = intval($gaji_pokok_en+$t_fungsional_en+$t_struktural_en+$t_kinerja_en+$t_umum_en);

          // $total_gaji = $gaji_pokok_en;




            $tot_gaji_a2 =  intval($gaji_pokok_en+$t_fungsional_en+$t_struktural_en);

             if($tot_gaji_a2 >= 12000000){
             
                $tot_gaji_a = 12000000;
             
             }else{
                $tot_gaji_a = $tot_gaji_a2;
             }

              if($tot_gaji_a2 >= 9077600){
             
                $tot_gaji_jp = 9077600;

               
             
             }else{
                 $tot_gaji_jp = $tot_gaji_a2;
               
             }



            // $tot_gaji_aa = $this->db->query('select sum(gaji_pokok+t_struktural+t_fungsional) as tot from payroll.komponen_gaji where kar_id =  "'.$data_bpjs->kar_id.'"')->row();
            
            

            // $tot_gaji_a = $tot_gaji_aa->tot;

            $bpjs_default = 4217206;


            //12000000
            if($total_gaji>=$bpjs_default){
                // A 

                if($tot_gaji_a>$bpjs_default){

                    $bpjs_k  = $tot_gaji_a*1/100;
                    $bpjs_pk = $tot_gaji_a*4/100;
    
                    $jht_k  = $tot_gaji_a2*2/100;
                    $jht_pk = $tot_gaji_a2*3.70/100;
    
                    $jp_k  = $tot_gaji_jp*1/100;
                    $jp_pk  = $tot_gaji_jp*2/100;
    
                    $jkk_pk = $tot_gaji_a2*0.24/100;
                    $jkm_pk = $tot_gaji_a2*0.30/100;
    
                   

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

                $jht_k  = $tot_gaji_a2*2/100;
                $jht_pk = $tot_gaji_a2*3.70/100;

                $jp_k  = $tot_gaji_jp*1/100;
                $jp_pk  = $tot_gaji_jp*2/100;

                $jkk_pk = $tot_gaji_a2*0.24/100;
                $jkm_pk = $tot_gaji_a2*0.30/100;

                

                $gaji_bpjs = $tot_gaji_a;
         

            }


        // }



             $kar_bpjs = $this->db->query('select * from payroll.kar_bpjs where kar_id = "'.$data_bpjs->kar_id.'"')->row();


            if($kar_bpjs){

                if($kar_bpjs->bpjs_k==1){
                     $bpjs_k_value  = $bpjs_k;
                }else{
                     $bpjs_k_value  = 0;
                }

                if($kar_bpjs->bpjs_pk==1){
                    $bpjs_pk_value = $bpjs_pk;
                }else{
                    $bpjs_pk_value = 0;
                }


                if($kar_bpjs->jht_k==1){
                    $jht_k_value  = $jht_k;
                }else{
                    $jht_k_value  = 0;
                }


                if($kar_bpjs->jht_pk==1){
                    $jht_pk_value  = $jht_pk;
                }else{
                    $jht_pk_value  = 0;
                }


                if($kar_bpjs->jp_k==1){
                    $jp_k_value = $jp_k;
                }else{
                    $jp_k_value = 0;
                }


                if($kar_bpjs->jp_pk==1){
                    $jp_pk_value = $jp_pk;
                }else{
                    $jp_pk_value = 0;
                }


                  if($kar_bpjs->jkm_pk==1){
                    $jkm_pk_value = $jkm_pk;
                }else{
                    $jkk_pk_value = 0;
                }


                if($kar_bpjs->jkk_pk==1){
                    $jkk_pk_value = $jkk_pk;
                }else{
                    $jkk_pk_value = 0;
                }



                



            }else{
                 $bpjs_k_value  = 0;
                $bpjs_pk_value = 0;

                $jht_k_value  = 0;
                $jht_pk_value = 0;

                $jp_k_value  = 0;
                $jp_pk_value  = 0;

                $jkk_pk_value = 0;
                $jkm_pk_value = 0;

                

                $gaji_bpjs = 0;
            }



            

            $no++;
            $row = array();
            $row[] = $no.$custom;
            $row[] = $data_bpjs->kar_nik;
            $row[] = $data_bpjs->kar_nm;
            $row[] = date('d-M-Y',strtotime($data_bpjs->kar_dtl_tgl_joi));
            $row[] = number_format($gaji_bpjs);
            $row[] = number_format($total_gaji);
            $row[] = $data_bpjs->kar_dtl_sts_nkh;
            $row[] = $data_bpjs->kar_dtl_jml_ank;
            $row[] = number_format($bpjs_k_value);
            $row[] = number_format($jht_k_value);
            $row[] = number_format($jp_k_value);
           
            $row[] = number_format($bpjs_pk_value);
            $row[] = number_format($jkk_pk_value);
            $row[] = number_format($jht_pk_value);
            $row[] = number_format($jkm_pk_value);
            $row[] = number_format($jp_pk_value);
           
           
          
           
          
            
          

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

    function bpjs_insert(){

        error_reporting(0);
        
        $data_kar = $this->db->query('select d.kar_dtl_tgl_joi,d.kar_dtl_sts_nkh,k.kar_nm, k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() order by k.ktr_id asc')->result();


        foreach($data_kar as $k){

             $plus_tiga_bulan =  date('Y-m-d', strtotime('+3 month', strtotime($k->kar_dtl_tgl_joi)));
           
          if($plus_tiga_bulan>=date('Y-m-d')){
              $custom = " Belum dapet";
          }else{
             $custom = "";
          }
           

            $tot_gj = $this->db->query('select * from payroll.komponen_gaji where kar_id =  "'.$k->kar_id.'"')->row();

            $array_gp = array(
                'cid' => (string)$tot_gj->nik,
                'secret' => (string)$tot_gj->kar_id,
                'data' => (string)$tot_gj->gaji_pokok,
                'action' => 'decrypt',
            );

            $gaji_pokok_en = educrypt($array_gp);


            $array_t_fungsional = array(
                'cid' => (string)$tot_gj->nik,
                'secret' => $tot_gj->kar_id,
                'data' => (string)$tot_gj->t_fungsional,
                'action' => 'decrypt',
            );

            $t_fungsional_en = educrypt($array_t_fungsional);


            $array_t_struktural = array(
                'cid' => (string)$tot_gj->nik,
                'secret' => $tot_gj->kar_id,
                'data' => (string)$tot_gj->t_struktural,
                'action' => 'decrypt',
            );

            $t_struktural_en = educrypt($array_t_struktural);


            $array_t_umum = array(
                'cid' => (string)$tot_gj->nik,
                'secret' => $tot_gj->kar_id,
                'data' => (string)$tot_gj->t_umum,
                'action' => 'decrypt',
            );

            $t_umum_en = educrypt($array_t_umum);

            $array_t_kinerja = array(
                'cid' => (string)$tot_gj->nik,
                'secret' => $tot_gj->kar_id,
                'data' => (string)$tot_gj->t_kinerja,
                'action' => 'decrypt',
            );

            $t_kinerja_en = educrypt($array_t_kinerja);

            $total_gaji = intval($gaji_pokok_en+$t_fungsional_en+$t_struktural_en+$t_kinerja_en+$t_umum_en);

          // $total_gaji = $gaji_pokok_en;




            $tot_gaji_a2 =  intval($gaji_pokok_en+$t_fungsional_en+$t_struktural_en);

             if($tot_gaji_a2 >= 12000000){
             
                $tot_gaji_a = 12000000;
             
             }else{
                $tot_gaji_a = $tot_gaji_a2;
             }

              if($tot_gaji_a2 >= 9077600){
             
                $tot_gaji_jp = 9077600;

               
             
             }else{
                 $tot_gaji_jp = $tot_gaji_a2;
               
             }



            // $tot_gaji_aa = $this->db->query('select sum(gaji_pokok+t_struktural+t_fungsional) as tot from payroll.komponen_gaji where kar_id =  "'.$k->kar_id.'"')->row();
            
            

            // $tot_gaji_a = $tot_gaji_aa->tot;

            $bpjs_default = 4217206;


            //12000000
            if($total_gaji>=$bpjs_default){
                // A 

                if($tot_gaji_a>$bpjs_default){

                    $bpjs_k  = $tot_gaji_a*1/100;
                    $bpjs_pk = $tot_gaji_a*4/100;
    
                    $jht_k  = $tot_gaji_a2*2/100;
                    $jht_pk = $tot_gaji_a2*3.70/100;
    
                    $jp_k  = $tot_gaji_jp*1/100;
                    $jp_pk  = $tot_gaji_jp*2/100;
    
                    $jkk_pk = $tot_gaji_a2*0.24/100;
                    $jkm_pk = $tot_gaji_a2*0.30/100;
    
                   

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

                $jht_k  = $tot_gaji_a2*2/100;
                $jht_pk = $tot_gaji_a2*3.70/100;

                $jp_k  = $tot_gaji_jp*1/100;
                $jp_pk  = $tot_gaji_jp*2/100;

                $jkk_pk = $tot_gaji_a2*0.24/100;
                $jkm_pk = $tot_gaji_a2*0.30/100;

                

                $gaji_bpjs = $tot_gaji_a;
         

            }


        // }



             $kar_bpjs = $this->db->query('select * from payroll.kar_bpjs where kar_id = "'.$k->kar_id.'"')->row();


            if($kar_bpjs){

                if($kar_bpjs->bpjs_k==1){
                     $bpjs_k_value  = $bpjs_k;
                }else{
                     $bpjs_k_value  = 0;
                }

                if($kar_bpjs->bpjs_pk==1){
                    $bpjs_pk_value = $bpjs_pk;
                }else{
                    $bpjs_pk_value = 0;
                }


                if($kar_bpjs->jht_k==1){
                    $jht_k_value  = $jht_k;
                }else{
                    $jht_k_value  = 0;
                }


                if($kar_bpjs->jht_pk==1){
                    $jht_pk_value  = $jht_pk;
                }else{
                    $jht_pk_value  = 0;
                }


                if($kar_bpjs->jp_k==1){
                    $jp_k_value = $jp_k;
                }else{
                    $jp_k_value = 0;
                }


                if($kar_bpjs->jp_pk==1){
                    $jp_pk_value = $jp_pk;
                }else{
                    $jp_pk_value = 0;
                }


                  if($kar_bpjs->jkm_pk==1){
                    $jkm_pk_value = $jkm_pk;
                }else{
                    $jkk_pk_value = 0;
                }


                if($kar_bpjs->jkk_pk==1){
                    $jkk_pk_value = $jkk_pk;
                }else{
                    $jkk_pk_value = 0;
                }



                



            }else{
                 $bpjs_k_value  = 0;
                $bpjs_pk_value = 0;

                $jht_k_value  = 0;
                $jht_pk_value = 0;

                $jp_k_value  = 0;
                $jp_pk_value  = 0;

                $jkk_pk_value = 0;
                $jkm_pk_value = 0;

                

                $gaji_bpjs = 0;
            }


              $array_tg = array(
                'cid' => (string)$k->kar_nik,
                'secret' => (string)$k->kar_id,
                'data' => (string)$total_gaji,
                'action' => 'encrypt',
            );

            $total_gaji_en = educrypt($array_tg);


            $array_g_bpjs = array(
                'cid' => (string)$k->kar_nik,
                'secret' => (string)$k->kar_id,
                'data' => (string)$gaji_bpjs,
                'action' => 'encrypt',
            );

            $total_gaji_bpjs = educrypt($array_g_bpjs);
             

              if($custom!='Belumdapet'){

                if($k->kar_nik=='SG.0675.2022' or $k->kar_nik=='SG.0636.2021'){

                    $data_array = array(
                        'custom'=>'0',
                        'kar_id'=>'0',
                        'kar_nik'=>$k->kar_nik,
                        'kar_nama'=>$k->kar_nm,
                        // 'bulan'=>date('m-Y'),
                        'bulan'=>'09-2022',
                        'total_gaji'=>$total_gaji_en,
                        'gaji_bpjs'=>$total_gaji_bpjs,
                        
                        
                    
                        'bpjs_k_1'=>'0',
                        'jht_k_2'=>'0',
                        'jp_k_1'=>'0',
                        'bpjs_pk_4'=>'0',
                        'jht_pk'=>'0',
                        'jkk_pk_024'=>'0',
                        'jkm_pk'=>'0',
                        'jp_pk'=>'0',
                        'crdt'=>date('Y-m-d H:i:s'),
                        
    
                    );

                }else{
                    $data_array = array(
                        'custom'=>$custom,
                        'kar_id'=>$k->kar_id,
                        'kar_nik'=>$k->kar_nik,
                        'kar_nama'=>$k->kar_nm,
                       // 'bulan'=>date('m-Y'),
                         'bulan'=>'09-2022',
                        'total_gaji'=>$total_gaji_en,
                        'gaji_bpjs'=>$total_gaji_bpjs,
                        
                        
                    
                      'bpjs_k_1'=>$bpjs_k_value,
                        'jht_k_2'=>$jht_k_value,
                        'jp_k_1'=>$jp_k_value,
                        'bpjs_pk_4'=>$bpjs_pk_value,
                        'jht_pk'=>$jht_pk_value,
                        'jkk_pk_024'=>$jkk_pk_value,
                        'jkm_pk'=>$jkm_pk_value,
                        'jp_pk'=>$jp_pk_value,
                        'crdt'=>date('Y-m-d H:i:s'),
                        
    
                    );
                }
               
            

                $simpan = $this->db->insert('payroll.bpjs',$data_array);

            }

      

     }

     if($simpan){
        redirect('gaji/bpjs');
    }
    }

    

    
   


    
    
}
