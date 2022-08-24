<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pajak extends CI_Controller
{


    function __construct(){
		parent::__construct();
		if(!$this->session->userdata()['pegawai']){
			redirect('auth');
		}
        $this->load->model(array('Pajak_M'));
		
    }


    

    // redirect if needed, otherwise display the user list
    public function index()
    {
      

        //$data["divisi"] = $this->Pajak_M->getAll();
        $data["title"] = "List Data Master Pajak";
        $this->template->load('template','pajak/pajak_v',$data);
     
    }


    public function ajax_list()
    {
        error_reporting(0);
        header('Content-Type: application/json');
        $list = $this->Pajak_M->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_bpjs) {

            $tot_gaji = $this->db->query('select sum(gaji_pokok+t_struktural+t_fungsional+t_umum+t_kinerja) as tot from payroll.komponen_gaji where kar_id =  "'.$data_bpjs->kar_id.'"')->row();

            $tunjangan = $this->db->query('select t_struktural from payroll.komponen_gaji where kar_id =  "'.$data_bpjs->kar_id.'"')->row();

           
            $total_gaji = $tot_gaji->tot;
            $ptkp_pekerja =  54000000;

            $istri = 4500000;


            if($data_bpjs->kar_dtl_gen=='L'){

                if($data_bpjs->kar_dtl_sts_nkh='K'){

                    if($data_bpjs->kar_dtl_jml_ank==0 ){
                        $tot_ptkp = $ptkp_pekerja+$istri;
        
                    }elseif($data_bpjs->kar_dtl_jml_ank<=3){
                        $ptkp_anak =  $data_bpjs->kar_dtl_jml_ank * 4500000;
                        $tot_ptkp =  $ptkp_pekerja + $istri +  $ptkp_anak; 
                    }
    

                }else{
                    $tot_ptkp = $ptkp_pekerja;
                }

                
            }elseif($data_bpjs->kar_dtl_gen=='P'){

                $tot_ptkp = $istri;

            }

           

           

          //  $insentif = 0;

          $dibayarkan = date('m-Y');

            $data_insentif = $this->db->query('select jumlah from payroll.insentif where kar_id =  "'.$data_bpjs->kar_id.'" and bulan_dibayarkan="'.$dibayarkan.'"')->row();
            
            if($data_insentif->jumlah){
                $insentif = $data_insentif->jumlah;
            }else{
                $insentif = 0;
            }

            
          

            $data_sembako = $this->db->query('select d.kar_dtl_sts_nkh,k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
            inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
            and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() and k.kar_id = "'.$data_bpjs->kar_id.'"')->row();
            $data_sembako->kar_dtl_sts_nkh;

            if(($data_sembako->kar_nik!='SG.0060.2010' and $data_sembako->kar_nik!='SG.0035.2007' 
            and $data_sembako->kar_nik!='SG.0410.2017' and $data_sembako->kar_nik!='SG.0205.2014'
            and $data_sembako->kar_nik!='SG.0247.2015' and $data_sembako->kar_nik!='SG.0186.2014' and $data_sembako->kar_nik!='SG.0273.2015' )){
                if($data_sembako->kar_dtl_sts_nkh=='TK'){
                    $t_beras = 110000;
                }elseif($data_sembako->kar_dtl_sts_nkh=='K'){
                    $t_beras = 220000;
                }else{
                    $t_beras = 0;
                }
            }else{
                $t_beras = 0;
            }








            $tot_gaji_aa = $this->db->query('select sum(gaji_pokok+t_struktural) as tot from payroll.komponen_gaji where kar_id =  "'.$data_bpjs->kar_id.'"')->row();
                                    
                      
            
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





                $thr =  6570000; 

        //$thr = 0;


                $total_gaji_setahun = ($total_gaji+$t_beras+$bpjs_pk+$jkk_pk+$jkm_pk)*12;

               $total_gaji_setahun_thr = (($total_gaji+$t_beras+$bpjs_pk+$jkk_pk+$jkm_pk)*12)+$thr;
           
                $jabatan2 = $total_gaji_setahun*0.05;
                if($jabatan2>6000000){
                    $jabatan = 6000000;
                }else{
                    $jabatan = $jabatan2;
                }

                $jabatan_thr_2 = $total_gaji_setahun_thr*0.05;
                if($jabatan_thr_2>6000000){
                    $jabatan_thr = 6000000;
                }else{
                    $jabatan_thr = $jabatan_thr_2;
                }

               // $pajak_setahun = $gaji_setahun - $tot_ptkp;
               $tot_jht_jp_setahun = ($jht_k+$jp_k)*12;
            //  $gaji_pajak_setahun = round($total_gaji_setahun - $jabatan - $tot_ptkp - $tot_jht_jp_setahun,-3);
              

               $gaji_pajak_setahun = floor(($total_gaji_setahun - $jabatan - $tot_ptkp - $tot_jht_jp_setahun)/1000)*1000;
               $gaji_pajak_setahun_thr = floor(($total_gaji_setahun_thr - $jabatan_thr - $tot_ptkp - $tot_jht_jp_setahun)/1000)*1000;
               
                if($gaji_pajak_setahun<=60000000){
                    $pajak_setahun =  0.05*$gaji_pajak_setahun;
                }else{
                    if($gaji_pajak_setahun>60000000 && $gaji_pajak_setahun<=250000000){
                        $pajak_setahun = 0.05*60000000 + 0.15*($gaji_pajak_setahun-60000000);
                       //$pajak_setahun = 15;
                    }else{
                        IF($gaji_pajak_setahun>250000000 && $gaji_pajak_setahun<=500000000){
                            $pajak_setahun = 0.05*60000000 + 0.15*190000000;
                        }else{
                            $pajak_setahun = 0.25*($gaji_pajak_setahun-250000000);
                        }
                
                        IF($gaji_pajak_setahun>500000000 && $gaji_pajak_setahun<=5000000000){
                            $pajak_setahun =  0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*($gaji_pajak_setahun-500000000);
                            
                        }else{
                            $pajak_setahun = 0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*45000000000 + ($gaji_pajak_setahun-5000000000)*0.35;
                        }
                    }
                }


                //THR


                if($gaji_pajak_setahun_thr<=60000000){
                    $pajak_setahun_thr =  0.05*$gaji_pajak_setahun_thr;
                }else{
                    if($gaji_pajak_setahun_thr>60000000 && $gaji_pajak_setahun_thr<=250000000){
                        $pajak_setahun_thr = 0.05*60000000 + 0.15*($gaji_pajak_setahun_thr-60000000);
                       //$pajak_setahun_thr = 15;
                    }else{
                        IF($gaji_pajak_setahun_thr>250000000 && $gaji_pajak_setahun_thr<=500000000){
                            $pajak_setahun_thr = 0.05*60000000 + 0.15*190000000;
                        }else{
                            $pajak_setahun_thr = 0.25*($gaji_pajak_setahun_thr-250000000);
                        }
                
                        IF($gaji_pajak_setahun_thr>500000000 && $gaji_pajak_setahun_thr<=5000000000){
                            $pajak_setahun_thr =  0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*($gaji_pajak_setahun_thr-500000000);
                            
                        }else{
                            $pajak_setahun_thr = 0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*45000000000 + ($gaji_pajak_setahun_thr-5000000000)*0.35;
                        }
                    }
                }


                if($data_bpjs->kar_dtl_no_npw){
                    $pajak_perbulan = round($pajak_setahun/12); 
                }else{
                    $pajak_perbulan = round(($pajak_setahun/12)*120/100); 
                }

              $selisih_thr =  ($pajak_setahun_thr - $pajak_setahun)/12;

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_bpjs->kar_nik;
            $row[] = $data_bpjs->kar_nm;
            $row[] = $data_bpjs->kar_dtl_no_npw;

            
            $row[] = number_format($total_gaji);
            $row[] = number_format($t_beras);
            $row[] = number_format($insentif);
            $row[] = number_format($total_gaji+$insentif+$t_beras);

            $row[] = $data_bpjs->kar_dtl_sts_nkh;
            $row[] = $data_bpjs->kar_dtl_jml_ank;
            $row[] = number_format($total_gaji_setahun)."($total_gaji+$bpjs_pk+$jkk_pk+$jkm_pk)*12";
            $row[] = number_format($jabatan);
            $row[] = number_format($tot_ptkp);
            $row[] = number_format($tot_jht_jp_setahun);
            $row[] = number_format($gaji_pajak_setahun);
           

            
            $row[] = number_format($pajak_setahun);
            $row[] = number_format($pajak_setahun_thr);
            $row[] = number_format($selisih_thr);
            $row[] = number_format($pajak_perbulan);
            $row[] = number_format($pajak_perbulan+$selisih_thr);
           
           
           
          
           
          
            
          

            $data[] = $row;
        }
        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->Pajak_M->count_all(),
            "recordsFiltered" => $this->Pajak_M->count_filtered(),
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

       $data['bpjs'] = $this->Pajak_M->getAll();

    //    echo "<pre>";
    //    print_r($data);

       $data["title"] = "List Data Pajak";
       $this->template->load('template','pajak/cross_cek',$data);

    }

    function download_excel(){


        $data['bpjs'] = $this->Pajak_M->getAll();

        $this->load->view('bpjs/download_excel',$data);

    }

    

    
   


    
    
}
