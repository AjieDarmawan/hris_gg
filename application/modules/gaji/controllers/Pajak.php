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

        // echo "<pre>";
        // print_r($list);
        // die;

         //  $insentif = 0;

            //$dibayarkan = date('Y-m');
            $dibayarkan = '2022-08';

            //$bulan_where = date('m-Y');
         $bulan_where = '08-2022';

         $bulan_skrang = '08';
         $tahun_sekarang = date('Y');
        $data = array();
        $no = $this->input->post('start');
        //looping data mahasiswa
        foreach ($list as $data_bpjs) {

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
            


            if($data_bpjs->kar_id=='663'){
                $uang_tambahan = 2000000;
            }else{
                $uang_tambahan = 0;
            }

            $data_dinas_lk = $this->db->query('select jumlah_hari from dinas_lk where kar_id =  "'.$data_bpjs->kar_id.'" and month(tgl_mulai)="'.$bulan_skrang.'" and year(tgl_mulai)="'.$tahun_sekarang.'" ')->row();
            
            if($data_dinas_lk){
                $t_dinas_lk = $data_dinas_lk->jumlah_hari * 40000;
            }else{
                $t_dinas_lk = 0;
            }



            $total_gaji = intval($uang_tambahan+$gaji_pokok_en+$t_fungsional_en+$t_struktural_en+$t_kinerja_en+$t_umum_en);

          // $total_gaji = $gaji_pokok_en;

            $tunjangan =  $t_struktural_en;
           
            
            $ptkp_pekerja =  54000000;

            $istri = 4500000;

            $pajak_tanggungan_data = $data_bpjs->pajak_tanggungan * 4500000;


            if($data_bpjs->kar_dtl_gen=='L'){

                if($data_bpjs->pajak_status=='Kawin'){

                    if($data_bpjs->pajak_tanggungan==0 ){
                        $tot_ptkp = $ptkp_pekerja+$istri;
        
                    }elseif($data_bpjs->pajak_tanggungan<=4){
                       // $ptkp_anak =  $data_bpjs->kar_dtl_jml_ank * 4500000;
                        $tot_ptkp =  $ptkp_pekerja + $pajak_tanggungan_data; 
                    }
    

                }else{

                      if($data_bpjs->pajak_tanggungan!=0){
                             //$ptkp_anak =  $pajak_tanggungan_data;
                             $tot_ptkp = $ptkp_pekerja + $pajak_tanggungan_data;
                    }else{
                          $tot_ptkp = $ptkp_pekerja;
                    }
                  
                }

                
              }elseif($data_bpjs->kar_dtl_gen=='P'){

               // $tot_ptkp = $ptkp_pekerja;

                 if($data_bpjs->pajak_tanggungan!=0){
                             //$ptkp_anak =  $pajak_tanggungan_data;
                             $tot_ptkp = $ptkp_pekerja + $pajak_tanggungan_data;
                    }else{
                          $tot_ptkp = $ptkp_pekerja;
                    }

            }

           
            
           

          

            $data_insentif = $this->db->query('select jumlah from payroll.insentif where kar_id =  "'.$data_bpjs->kar_id.'" and bulan_dibayarkan="'.$dibayarkan.'"')->row();
            
            if($data_insentif->jumlah){
                $insentif = $data_insentif->jumlah;
            }else{
                $insentif = 0;
            }

            
          
           
            $data_sembako = $this->db->query('select * from payroll.sembako where kar_id =  "'.$data_bpjs->kar_id.'" and bulan="'.$bulan_where.'"')->row();
            
            if($data_sembako){
                $t_beras = $data_sembako->harga;
            }else{
                $t_beras = 0;
            }
            

       

            $total_gaji = $total_gaji ;

            $r_bpjs = $this->db->query('select * from payroll.bpjs where kar_id =  "'.$data_bpjs->kar_id.'" and bulan="'.$bulan_where.'"')->row();
                                    
                      
                
                $bpjs_k  = $r_bpjs->bpjs_k_1;
                $bpjs_pk = $r_bpjs->bpjs_pk_4;

                $jht_k  = $r_bpjs->jht_k_2;
                $jht_pk = $r_bpjs->jht_pk;

                $jp_k  =$r_bpjs->jp_k_1;
                $jp_pk  =$r_bpjs->jp_pk;
                $jkk_pk = $r_bpjs->jkk_pk_024;
                $jkm_pk = $r_bpjs->jkm_pk;

                $gaji_bpjs = $r_bpjs->gaji_bpjs;



                $date1 = date_create('2023-04-15'); 
                $date2 = date_create($data_bpjs->kar_dtl_tgl_joi); 
                 
                $interval = date_diff($date1, $date2); 

                // if( $interval->y==0){
                //     $hari_thr =   $interval->m." bulan, ".$interval->d." hari ";
                // }else{
                //     $hari_thr =   "";
                // }

                ///  itungan manual

                //  if( $interval->y==0){
                //     $hari_thr =   $interval->m." bulan, ".$interval->d." hari ";

                //     $bulan_thr_masuk = $interval->m;
                //     $hari_thr_masuk = $interval->d;

                //    $perhitungan_thr = $bulan_thr_masuk.".".$hari_thr_masuk;

                //    $final_perhitungan_thr = ($perhitungan_thr/12)*$total_gaji;

                //     $thr =  round($final_perhitungan_thr) ; 
                // }else{
                //     $hari_thr =   "";
                //     $thr =  $total_gaji; 
                // }

                 $pajak_thr_thr = $this->db->query('select * from payroll.pajak_thr where kar_id =  "'.$data_bpjs->kar_id.'"')->row();

                 if($pajak_thr_thr){
                    $thr = $pajak_thr_thr->jumlah;
                 }else{
                    $thr = 0;
                 }
                 
              
                

               

                $hari_ini = date_create(date('Y').'-'.'12-31'); 
                $tgl_join_dulu = date_create($data_bpjs->kar_dtl_tgl_joi); 
                 
                $interval_selisih = date_diff($hari_ini, $tgl_join_dulu); 
                
                 $waktu_masa_kerja =   $interval_selisih->y." tahun, ".$interval_selisih->m." bulan, ".$interval_selisih->d." hari ";
                  $bulan_join = date('m', strtotime($data_bpjs->kar_dtl_tgl_joi));


                 if($interval_selisih->y>=1){
                      $tahun_pajak = 12;
                     
                 }else{

                  

                    $tahun_pajak = 12-($bulan_join-1);

                    // if($interval_selisih->d!=0){
                    //      $tahun_pajak = $interval_selisih->m+1;
                    // }else{

                    //      if($interval_selisih->d!=0){
                    //                 $tahun_pajak = $interval_selisih->m+1;
                    //             }else{
                    //                 $tahun_pajak = $interval_selisih->m;
                    //             }
                       
                    // }


                     
                 }

                 
                   $bpjs_jp_jht_pajak = $tahun_pajak;
                    

                   
              

                


                 




                $total_gaji_setahun_review = (($total_gaji+$t_beras+$bpjs_pk+$jkk_pk+round($jkm_pk))*$tahun_pajak);

                if($total_gaji_setahun_review>=$tot_ptkp){
                       
                    
                        $total_gaji_setahun = $total_gaji_setahun_review;
                        $tot_jht_jp_setahun = ($jht_k+$jp_k)*$bpjs_jp_jht_pajak;

                        $jabatan2 = $total_gaji_setahun*0.05;
                        if($jabatan2>6000000){
                            $jabatan_review = 6000000;
                        }else{

                             
                                    $bulan_review = 12-($bulan_join-1);
                               

                            $max = 500000;

                            if($interval_selisih->y>=1){
                                $jabatan_review = $jabatan2;
                            }else{
                              $jabatan_belum_setahun_lebih =  $bulan_review * $max;

                              if($jabatan2>=$jabatan_belum_setahun_lebih){
                                $jabatan_review =$jabatan_belum_setahun_lebih;

                              }else{
                                $jabatan_review =$jabatan_belum_setahun_lebih;
                              }

                            }


                          


                        }


               $gaji_pajak_setahun_riview = floor(($total_gaji_setahun - $jabatan_review - $tot_ptkp - $tot_jht_jp_setahun)/1000)*1000;
              
                        if($gaji_pajak_setahun_riview<0){
                            $gaji_pajak_setahun = 0;
                        }else{
                            $gaji_pajak_setahun = $gaji_pajak_setahun_riview;
                        }


                }else{
                    $total_gaji_setahun = 0;
                    $tot_jht_jp_setahun = ($jht_k+$jp_k)*$bpjs_jp_jht_pajak;
                }

               // $total_gaji_setahun_thr = (($total_gaji+$t_beras+$bpjs_pk+$jkk_pk+round($jkm_pk))*$tahun_pajak)+$thr;

                 $total_gaji_setahun_thr = (($thr+$t_beras+$bpjs_pk+$jkk_pk+round($jkm_pk))*$tahun_pajak)+$thr;

               $total_gaji_setahun_insentif = (($total_gaji+$t_beras+$bpjs_pk+$jkk_pk+round($jkm_pk)+$insentif)*$tahun_pajak);

   
           
                $jabatan2 = $total_gaji_setahun_review*0.05;
                if($jabatan2>6000000){
                    $jabatan = 6000000;
                }else{
                    //$jabatan = $jabatan2;

                        $bulan_review = 12-($bulan_join-1);

                            $max = 500000;

                            if($interval_selisih->y>=1){
                                $jabatan = $jabatan2;
                            }else{
                              $jabatan_belum_setahun_lebih =  $bulan_review * $max;

                              if($jabatan2>=$jabatan_belum_setahun_lebih){
                                $jabatan =$jabatan_belum_setahun_lebih;

                              }else{
                                $jabatan =$jabatan_belum_setahun_lebih;
                              }

                            }
                }

                $jabatan_thr_2 = $total_gaji_setahun_thr*0.05;
                if($jabatan_thr_2>6000000){
                    $jabatan_thr = 6000000;
                }else{
                    $jabatan_thr = $jabatan_thr_2;
                }

                $jabatan_insentif_2 = $total_gaji_setahun_insentif*0.05;
                if($jabatan_insentif_2>6000000){
                    $jabatan_insentif = 6000000;
                }else{
                    $jabatan_insentif = $jabatan_insentif_2;
                }

               



               // $pajak_setahun = $gaji_setahun - $tot_ptkp;
              
            //  $gaji_pajak_setahun = round($total_gaji_setahun - $jabatan - $tot_ptkp - $tot_jht_jp_setahun,-3);
              

              
               $gaji_pajak_setahun_thr = floor(($total_gaji_setahun_thr - $jabatan_thr - $tot_ptkp - $tot_jht_jp_setahun)/1000)*1000;

               $gaji_pajak_setahun_insentif = floor(($total_gaji_setahun_insentif - $jabatan_insentif - $tot_ptkp - $tot_jht_jp_setahun)/1000)*1000;
               
                if($gaji_pajak_setahun<=60000000){
                    $pajak_setahun =  0.05*$gaji_pajak_setahun;
                }elseif($gaji_pajak_setahun>60000000 && $gaji_pajak_setahun<=250000000){
                    // $pajak_setahun =  0.15*$gaji_pajak_setahun;
                    $pajak_setahun = 0.05*60000000 + 0.15*($gaji_pajak_setahun-60000000);
                }

                elseif($gaji_pajak_setahun>250000000 && $gaji_pajak_setahun<=500000000){
                      //$pajak_setahun =  0.25*$gaji_pajak_setahun;
                      $pajak_setahun = 0.05*60000000 + 0.15*190000000 + 0.25*($gaji_pajak_setahun-250000000);
                }

                 elseif($gaji_pajak_setahun>500000000 && $gaji_pajak_setahun<=5000000000){
                     // $pajak_setahun =  0.30*$gaji_pajak_setahun;
                     $pajak_setahun =  0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*($gaji_pajak_setahun-500000000);
                }

                elseif($gaji_pajak_setahun>5000000000 ){
                      $pajak_setahun =  0.35*$gaji_pajak_setahun;
                }





               


                //THR


                if($gaji_pajak_setahun_thr<=60000000){
                    $pajak_setahun_thr =  0.05*$gaji_pajak_setahun_thr;
                }elseif($gaji_pajak_setahun_thr>60000000 && $gaji_pajak_setahun_thr<=250000000){
                    // $pajak_setahun_thr =  0.15*$gaji_pajak_setahun_thr;
                    $pajak_setahun_thr = 0.05*60000000 + 0.15*($gaji_pajak_setahun_thr-60000000);
                }

                elseif($gaji_pajak_setahun_thr>250000000 && $gaji_pajak_setahun_thr<=500000000){
                      //$pajak_setahun_thr =  0.25*$gaji_pajak_setahun_thr;
                      $pajak_setahun_thr = 0.05*60000000 + 0.15*190000000 + 0.25*($gaji_pajak_setahun_thr-250000000);
                }

                 elseif($gaji_pajak_setahun_thr>500000000 && $gaji_pajak_setahun_thr<=5000000000){
                     // $pajak_setahun_thr =  0.30*$gaji_pajak_setahun_thr;
                     $pajak_setahun_thr =  0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*($gaji_pajak_setahun_thr-500000000);
                }

                elseif($gaji_pajak_setahun_thr>5000000000 ){
                      $pajak_setahun_thr =  0.35*$gaji_pajak_setahun_thr;
                }


               
                
                //insentif

                 if($data_bpjs->kar_dtl_no_npw){
                        $ga_ada_npwp = 1.20;
                 }else{
                        $ga_ada_npwp = "";
                 }


                if($gaji_pajak_setahun_insentif<=60000000){

                     if($data_bpjs->kar_dtl_no_npw){
                         $pajak_setahun_insentif =  0.05*$gaji_pajak_setahun_insentif;
                     }else{
                           
                            $pajak_setahun_insentif =  (0.05*$gaji_pajak_setahun_insentif)*1.20;
                     }


                   
                }elseif($gaji_pajak_setahun_insentif>60000000 && $gaji_pajak_setahun_insentif<=250000000){
                    // $pajak_setahun_insentif =  0.15*$gaji_pajak_setahun_insentif;
                    //$pajak_setahun_insentif = 0.05*60000000 + 0.15*($gaji_pajak_setahun_insentif-60000000);


                    if($data_bpjs->kar_dtl_no_npw){
                            $pajak_setahun_insentif = 0.05*60000000 + 0.15*($gaji_pajak_setahun_insentif-60000000);
                     }else{
                          
                           $pajak_setahun_insentif = (0.05*60000000 + 0.15*($gaji_pajak_setahun_insentif-60000000))*1.20;
                     }


                }

                elseif($gaji_pajak_setahun_insentif>250000000 && $gaji_pajak_setahun_insentif<=500000000){
                      //$pajak_setahun_insentif =  0.25*$gaji_pajak_setahun_insentif;

                       if($data_bpjs->kar_dtl_no_npw){
                           $pajak_setahun_insentif = 0.05*60000000 + 0.15*190000000 + 0.25*($gaji_pajak_setahun_insentif-250000000);
                      
                     }else{
                           $pajak_setahun_insentif = (0.05*60000000 + 0.15*190000000 + 0.25*($gaji_pajak_setahun_insentif-250000000))*1.20;
                     
                     }




                }

                 elseif($gaji_pajak_setahun_insentif>500000000 && $gaji_pajak_setahun_insentif<=5000000000){
                     // $pajak_setahun_insentif =  0.30*$gaji_pajak_setahun_insentif;
                    

                      if($data_bpjs->kar_dtl_no_npw){
                           $pajak_setahun_insentif =  0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*($gaji_pajak_setahun_insentif-500000000);
                       
                     }else{
                        $pajak_setahun_insentif =  (0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*($gaji_pajak_setahun_insentif-500000000))*1.20;
                           
                      
                     }



                }

                elseif($gaji_pajak_setahun_insentif>5000000000 ){

                    if($data_bpjs->kar_dtl_no_npw){
                          $pajak_setahun_insentif =  0.35*$gaji_pajak_setahun_insentif;
                      
                     }else{
                            $pajak_setahun_insentif =  (0.35*$gaji_pajak_setahun_insentif)*1.20;
                        
                     }


                     
                }


                if($data_bpjs->kar_dtl_no_npw){
                    $pajak_perbulan = round($pajak_setahun/12); 

                    $pajak_perbulan_insentif = round($pajak_setahun_insentif/12); 
                }else{
                    $pajak_perbulan = round(($pajak_setahun/12)*120/100); 

                    $pajak_perbulan_insentif = round(($pajak_setahun_insentif/12)*120/100); 
                }

              $selisih_thr2 =  ($pajak_setahun_thr - $pajak_setahun)/12;


              // if($selisih_thr2<0){
              //       $selisih_thr = 0;
              // }else{
              //   $selisih_thr = $selisih_thr2;
              // }




                 $pajak_thr_nominal = $this->db->query('select * from payroll.pajak_thr_nominal where kar_id =  "'.$data_bpjs->kar_id.'"')->row();

                 if($pajak_thr_nominal){
                    $selisih_thr = $pajak_thr_nominal->jumlah;
                 }else{
                    $selisih_thr = 0;
                 }





                

                if($tahun_pajak<12){
                    
                    $pajak_perbulan_final = round($pajak_setahun/$tahun_pajak);
                   // $pajak_perbulan_final = 12;
                }else{
                    $pajak_perbulan_final = $pajak_perbulan;
                }

                 if($tahun_pajak<12){
                    
                    $pajak_perbulan_insentif_final = round($pajak_setahun_insentif/$tahun_pajak);
                    //$pajak_perbulan_insentif_final = 12;
                }else{
                   // $pajak_perbulan_insentif_final = $pajak_perbulan_insentif;

                     $pajak_perbulan_insentif_final = round($pajak_setahun_insentif/12);

                }

                $pph_bayar2 = $pajak_perbulan_insentif_final+$selisih_thr;

                if($pph_bayar2<0){
                    $pph_bayar = 0;
                }else{
                    $pph_bayar = $pph_bayar2;
                }

                  

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $data_bpjs->kar_nik;
            $row[] = $data_bpjs->kar_nm;
            $row[] = $data_bpjs->kar_dtl_no_npw;

            
            $row[] = number_format($total_gaji);
            $row[] = '';
            $row[] = number_format($t_beras);
            $row[] = number_format($insentif);
            $row[] = number_format($total_gaji+$insentif+$t_beras);

            $row[] = $data_bpjs->kar_dtl_sts_nkh;
            $row[] = $data_bpjs->kar_dtl_jml_ank;

            $row[] = date('d-M-Y', strtotime($data_bpjs->kar_dtl_tgl_joi));
            $row[] = $data_bpjs->pajak_status." tanggung ".$data_bpjs->pajak_tanggungan;;
            
            $row[] = '';
           
            $row[] = number_format($thr);
            $row[] = $tahun_pajak;
            $row[] = number_format($total_gaji_setahun_insentif)."($total_gaji+$t_beras++$bpjs_pk+$jkk_pk+round($jkm_pk))*12+".$insentif;
            $row[] = number_format($jabatan_insentif);
            $row[] = number_format($tot_ptkp);
            $row[] = number_format($tot_jht_jp_setahun);
            $row[] = number_format($gaji_pajak_setahun)."-".number_format($gaji_pajak_setahun_insentif);
           

            
            $row[] = number_format($pajak_setahun_insentif);
            $row[] = number_format($pajak_setahun_thr);
            $row[] = number_format($selisih_thr);
            $row[] = number_format($pajak_perbulan);

            $row[] = number_format($pajak_perbulan_insentif_final);

          
            $row[] = number_format($pajak_perbulan);
            $row[] = number_format($pajak_perbulan_insentif_final)."-".number_format($pajak_perbulan_insentif_final-$pajak_perbulan);
            $row[] = number_format($selisih_thr);


            
            $row[] = number_format($pph_bayar);
           
           
           
          
           
          
            
          

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

        $this->load->view('pajak/download_excel',$data);

    }

       function pajak_insert(){

        error_reporting(0);
        $data_kar = $this->db->query('select d.pajak_tanggungan,d.pajak_status, d.kar_dtl_gen,d.kar_dtl_jml_ank,d.kar_dtl_no_npw,k.kar_nm,d.kar_dtl_tgl_joi,d.kar_dtl_sts_nkh,k.kar_nm, k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
        inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
        order by k.ktr_id asc')->result();

         //  $insentif = 0;

            //$dibayarkan = date('Y-m');
            $dibayarkan = '2022-08';

            //$bulan_where = date('m-Y');
         $bulan_where = '08-2022';

         $bulan_skrang = '08';
         $tahun_sekarang = date('Y');

        foreach($data_kar as $data_bpjs){

           
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

            if($data_bpjs->kar_id=='663'){
                $uang_tambahan = 2000000;
            }else{
                $uang_tambahan = 0;
            }

            $data_dinas_lk = $this->db->query('select jumlah_hari from dinas_lk where kar_id =  "'.$data_bpjs->kar_id.'" and month(tgl_mulai)="'.$bulan_skrang.'" and year(tgl_mulai)="'.$tahun_sekarang.'" ')->row();
            
            if($data_dinas_lk){
                $t_dinas_lk = $data_dinas_lk->jumlah_hari * 40000;
            }else{
                $t_dinas_lk = 0;
            }



            $total_gaji = intval($uang_tambahan+$gaji_pokok_en+$t_fungsional_en+$t_struktural_en+$t_kinerja_en+$t_umum_en);


            $tunjangan =  $t_struktural_en;
           
            
            $ptkp_pekerja =  54000000;

            $istri = 4500000;

            $pajak_tanggungan_data = $data_bpjs->pajak_tanggungan * 4500000;


            if($data_bpjs->kar_dtl_gen=='L'){

                if($data_bpjs->pajak_status=='Kawin'){

                    if($data_bpjs->pajak_tanggungan==0 ){
                        $tot_ptkp = $ptkp_pekerja+$istri;
        
                    }elseif($data_bpjs->pajak_tanggungan<=4){
                       // $ptkp_anak =  $data_bpjs->kar_dtl_jml_ank * 4500000;
                        $tot_ptkp =  $ptkp_pekerja + $pajak_tanggungan_data; 
                    }
    

                }else{

                      if($data_bpjs->pajak_tanggungan!=0){
                             //$ptkp_anak =  $pajak_tanggungan_data;
                             $tot_ptkp = $ptkp_pekerja + $pajak_tanggungan_data;
                    }else{
                          $tot_ptkp = $ptkp_pekerja;
                    }
                  
                }

                
              }elseif($data_bpjs->kar_dtl_gen=='P'){

               // $tot_ptkp = $ptkp_pekerja;

                 if($data_bpjs->pajak_tanggungan!=0){
                             //$ptkp_anak =  $pajak_tanggungan_data;
                             $tot_ptkp = $ptkp_pekerja + $pajak_tanggungan_data;
                    }else{
                          $tot_ptkp = $ptkp_pekerja;
                    }

            }

           
            
           

          

            $data_insentif = $this->db->query('select jumlah from payroll.insentif where kar_id =  "'.$data_bpjs->kar_id.'" and bulan_dibayarkan="'.$dibayarkan.'"')->row();
            
            if($data_insentif->jumlah){
                $insentif = $data_insentif->jumlah;
            }else{
                $insentif = 0;
            }

            
          
           
            $data_sembako = $this->db->query('select * from payroll.sembako where kar_id =  "'.$data_bpjs->kar_id.'" and bulan="'.$bulan_where.'"')->row();
            
            if($data_sembako){
                $t_beras = $data_sembako->harga;
            }else{
                $t_beras = 0;
            }
            

       

            $total_gaji = $total_gaji ;

            $r_bpjs = $this->db->query('select * from payroll.bpjs where kar_id =  "'.$data_bpjs->kar_id.'" and bulan="'.$bulan_where.'"')->row();
                                    
                      
                
                $bpjs_k  = $r_bpjs->bpjs_k_1;
                $bpjs_pk = $r_bpjs->bpjs_pk_4;

                $jht_k  = $r_bpjs->jht_k_2;
                $jht_pk = $r_bpjs->jht_pk;

                $jp_k  =$r_bpjs->jp_k_1;
                $jp_pk  =$r_bpjs->jp_pk;
                $jkk_pk = $r_bpjs->jkk_pk_024;
                $jkm_pk = $r_bpjs->jkm_pk;

                $gaji_bpjs = $r_bpjs->gaji_bpjs;



                $date1 = date_create('2023-04-15'); 
                $date2 = date_create($data_bpjs->kar_dtl_tgl_joi); 
                 
                $interval = date_diff($date1, $date2); 

                // if( $interval->y==0){
                //     $hari_thr =   $interval->m." bulan, ".$interval->d." hari ";
                // }else{
                //     $hari_thr =   "";
                // }

                ///  itungan manual

                //  if( $interval->y==0){
                //     $hari_thr =   $interval->m." bulan, ".$interval->d." hari ";

                //     $bulan_thr_masuk = $interval->m;
                //     $hari_thr_masuk = $interval->d;

                //    $perhitungan_thr = $bulan_thr_masuk.".".$hari_thr_masuk;

                //    $final_perhitungan_thr = ($perhitungan_thr/12)*$total_gaji;

                //     $thr =  round($final_perhitungan_thr) ; 
                // }else{
                //     $hari_thr =   "";
                //     $thr =  $total_gaji; 
                // }

                 $pajak_thr_thr = $this->db->query('select * from payroll.pajak_thr where kar_id =  "'.$data_bpjs->kar_id.'"')->row();

                 if($pajak_thr_thr){
                    $thr = $pajak_thr_thr->jumlah;
                 }else{
                    $thr = 0;
                 }
                 
              
                

               

                $hari_ini = date_create(date('Y').'-'.'12-31'); 
                $tgl_join_dulu = date_create($data_bpjs->kar_dtl_tgl_joi); 
                 
                $interval_selisih = date_diff($hari_ini, $tgl_join_dulu); 
                
                 $waktu_masa_kerja =   $interval_selisih->y." tahun, ".$interval_selisih->m." bulan, ".$interval_selisih->d." hari ";
                  $bulan_join = date('m', strtotime($data_bpjs->kar_dtl_tgl_joi));


                 if($interval_selisih->y>=1){
                      $tahun_pajak = 12;
                     
                 }else{

                  

                    $tahun_pajak = 12-($bulan_join-1);

                    // if($interval_selisih->d!=0){
                    //      $tahun_pajak = $interval_selisih->m+1;
                    // }else{

                    //      if($interval_selisih->d!=0){
                    //                 $tahun_pajak = $interval_selisih->m+1;
                    //             }else{
                    //                 $tahun_pajak = $interval_selisih->m;
                    //             }
                       
                    // }


                     
                 }

                 
                   $bpjs_jp_jht_pajak = $tahun_pajak;
                    

                   
              

                


                 




                $total_gaji_setahun_review = (($total_gaji+$t_beras+$bpjs_pk+$jkk_pk+round($jkm_pk))*$tahun_pajak);

                if($total_gaji_setahun_review>=$tot_ptkp){
                       
                    
                        $total_gaji_setahun = $total_gaji_setahun_review;
                        $tot_jht_jp_setahun = ($jht_k+$jp_k)*$bpjs_jp_jht_pajak;

                        $jabatan2 = $total_gaji_setahun*0.05;
                        if($jabatan2>6000000){
                            $jabatan_review = 6000000;
                        }else{

                             
                                    $bulan_review = 12-($bulan_join-1);
                               

                            $max = 500000;

                            if($interval_selisih->y>=1){
                                $jabatan_review = $jabatan2;
                            }else{
                              $jabatan_belum_setahun_lebih =  $bulan_review * $max;

                              if($jabatan2>=$jabatan_belum_setahun_lebih){
                                $jabatan_review =$jabatan_belum_setahun_lebih;

                              }else{
                                $jabatan_review =$jabatan_belum_setahun_lebih;
                              }

                            }


                          


                        }


               $gaji_pajak_setahun_riview = floor(($total_gaji_setahun - $jabatan_review - $tot_ptkp - $tot_jht_jp_setahun)/1000)*1000;
              
                        if($gaji_pajak_setahun_riview<0){
                            $gaji_pajak_setahun = 0;
                        }else{
                            $gaji_pajak_setahun = $gaji_pajak_setahun_riview;
                        }


                }else{
                    $total_gaji_setahun = 0;
                    $tot_jht_jp_setahun = ($jht_k+$jp_k)*$bpjs_jp_jht_pajak;
                }

               // $total_gaji_setahun_thr = (($total_gaji+$t_beras+$bpjs_pk+$jkk_pk+round($jkm_pk))*$tahun_pajak)+$thr;

                 $total_gaji_setahun_thr = (($thr+$t_beras+$bpjs_pk+$jkk_pk+round($jkm_pk))*$tahun_pajak)+$thr;

               $total_gaji_setahun_insentif = (($total_gaji+$t_beras+$bpjs_pk+$jkk_pk+round($jkm_pk)+$insentif)*$tahun_pajak);

   
           
                $jabatan2 = $total_gaji_setahun_review*0.05;
                if($jabatan2>6000000){
                    $jabatan = 6000000;
                }else{
                    //$jabatan = $jabatan2;

                        $bulan_review = 12-($bulan_join-1);

                            $max = 500000;

                            if($interval_selisih->y>=1){
                                $jabatan = $jabatan2;
                            }else{
                              $jabatan_belum_setahun_lebih =  $bulan_review * $max;

                              if($jabatan2>=$jabatan_belum_setahun_lebih){
                                $jabatan =$jabatan_belum_setahun_lebih;

                              }else{
                                $jabatan =$jabatan_belum_setahun_lebih;
                              }

                            }
                }

                $jabatan_thr_2 = $total_gaji_setahun_thr*0.05;
                if($jabatan_thr_2>6000000){
                    $jabatan_thr = 6000000;
                }else{
                    $jabatan_thr = $jabatan_thr_2;
                }

                $jabatan_insentif_2 = $total_gaji_setahun_insentif*0.05;
                if($jabatan_insentif_2>6000000){
                    $jabatan_insentif = 6000000;
                }else{
                    $jabatan_insentif = $jabatan_insentif_2;
                }

               



               // $pajak_setahun = $gaji_setahun - $tot_ptkp;
              
            //  $gaji_pajak_setahun = round($total_gaji_setahun - $jabatan - $tot_ptkp - $tot_jht_jp_setahun,-3);
              

              
               $gaji_pajak_setahun_thr = floor(($total_gaji_setahun_thr - $jabatan_thr - $tot_ptkp - $tot_jht_jp_setahun)/1000)*1000;

               $gaji_pajak_setahun_insentif = floor(($total_gaji_setahun_insentif - $jabatan_insentif - $tot_ptkp - $tot_jht_jp_setahun)/1000)*1000;
               
                if($gaji_pajak_setahun<=60000000){
                    $pajak_setahun =  0.05*$gaji_pajak_setahun;
                }elseif($gaji_pajak_setahun>60000000 && $gaji_pajak_setahun<=250000000){
                    // $pajak_setahun =  0.15*$gaji_pajak_setahun;
                    $pajak_setahun = 0.05*60000000 + 0.15*($gaji_pajak_setahun-60000000);
                }

                elseif($gaji_pajak_setahun>250000000 && $gaji_pajak_setahun<=500000000){
                      //$pajak_setahun =  0.25*$gaji_pajak_setahun;
                      $pajak_setahun = 0.05*60000000 + 0.15*190000000 + 0.25*($gaji_pajak_setahun-250000000);
                }

                 elseif($gaji_pajak_setahun>500000000 && $gaji_pajak_setahun<=5000000000){
                     // $pajak_setahun =  0.30*$gaji_pajak_setahun;
                     $pajak_setahun =  0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*($gaji_pajak_setahun-500000000);
                }

                elseif($gaji_pajak_setahun>5000000000 ){
                      $pajak_setahun =  0.35*$gaji_pajak_setahun;
                }





               


                //THR


                if($gaji_pajak_setahun_thr<=60000000){
                    $pajak_setahun_thr =  0.05*$gaji_pajak_setahun_thr;
                }elseif($gaji_pajak_setahun_thr>60000000 && $gaji_pajak_setahun_thr<=250000000){
                    // $pajak_setahun_thr =  0.15*$gaji_pajak_setahun_thr;
                    $pajak_setahun_thr = 0.05*60000000 + 0.15*($gaji_pajak_setahun_thr-60000000);
                }

                elseif($gaji_pajak_setahun_thr>250000000 && $gaji_pajak_setahun_thr<=500000000){
                      //$pajak_setahun_thr =  0.25*$gaji_pajak_setahun_thr;
                      $pajak_setahun_thr = 0.05*60000000 + 0.15*190000000 + 0.25*($gaji_pajak_setahun_thr-250000000);
                }

                 elseif($gaji_pajak_setahun_thr>500000000 && $gaji_pajak_setahun_thr<=5000000000){
                     // $pajak_setahun_thr =  0.30*$gaji_pajak_setahun_thr;
                     $pajak_setahun_thr =  0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*($gaji_pajak_setahun_thr-500000000);
                }

                elseif($gaji_pajak_setahun_thr>5000000000 ){
                      $pajak_setahun_thr =  0.35*$gaji_pajak_setahun_thr;
                }


               
                
                //insentif

                 if($data_bpjs->kar_dtl_no_npw){
                        $ga_ada_npwp = 1.20;
                 }else{
                        $ga_ada_npwp = "";
                 }


                if($gaji_pajak_setahun_insentif<=60000000){

                     if($data_bpjs->kar_dtl_no_npw){
                         $pajak_setahun_insentif =  0.05*$gaji_pajak_setahun_insentif;
                     }else{
                           
                            $pajak_setahun_insentif =  (0.05*$gaji_pajak_setahun_insentif)*1.20;
                     }


                   
                }elseif($gaji_pajak_setahun_insentif>60000000 && $gaji_pajak_setahun_insentif<=250000000){
                    // $pajak_setahun_insentif =  0.15*$gaji_pajak_setahun_insentif;
                    //$pajak_setahun_insentif = 0.05*60000000 + 0.15*($gaji_pajak_setahun_insentif-60000000);


                    if($data_bpjs->kar_dtl_no_npw){
                            $pajak_setahun_insentif = 0.05*60000000 + 0.15*($gaji_pajak_setahun_insentif-60000000);
                     }else{
                          
                           $pajak_setahun_insentif = (0.05*60000000 + 0.15*($gaji_pajak_setahun_insentif-60000000))*1.20;
                     }


                }

                elseif($gaji_pajak_setahun_insentif>250000000 && $gaji_pajak_setahun_insentif<=500000000){
                      //$pajak_setahun_insentif =  0.25*$gaji_pajak_setahun_insentif;

                       if($data_bpjs->kar_dtl_no_npw){
                           $pajak_setahun_insentif = 0.05*60000000 + 0.15*190000000 + 0.25*($gaji_pajak_setahun_insentif-250000000);
                      
                     }else{
                           $pajak_setahun_insentif = (0.05*60000000 + 0.15*190000000 + 0.25*($gaji_pajak_setahun_insentif-250000000))*1.20;
                     
                     }




                }

                 elseif($gaji_pajak_setahun_insentif>500000000 && $gaji_pajak_setahun_insentif<=5000000000){
                     // $pajak_setahun_insentif =  0.30*$gaji_pajak_setahun_insentif;
                    

                      if($data_bpjs->kar_dtl_no_npw){
                           $pajak_setahun_insentif =  0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*($gaji_pajak_setahun_insentif-500000000);
                       
                     }else{
                        $pajak_setahun_insentif =  (0.05*60000000 + 0.15*190000000 + 0.25*250000000 + 0.3*($gaji_pajak_setahun_insentif-500000000))*1.20;
                           
                      
                     }



                }

                elseif($gaji_pajak_setahun_insentif>5000000000 ){

                    if($data_bpjs->kar_dtl_no_npw){
                          $pajak_setahun_insentif =  0.35*$gaji_pajak_setahun_insentif;
                      
                     }else{
                            $pajak_setahun_insentif =  (0.35*$gaji_pajak_setahun_insentif)*1.20;
                        
                     }


                     
                }


                if($data_bpjs->kar_dtl_no_npw){
                    $pajak_perbulan = round($pajak_setahun/12); 

                    $pajak_perbulan_insentif = round($pajak_setahun_insentif/12); 
                }else{
                    $pajak_perbulan = round(($pajak_setahun/12)*120/100); 

                    $pajak_perbulan_insentif = round(($pajak_setahun_insentif/12)*120/100); 
                }

              $selisih_thr2 =  ($pajak_setahun_thr - $pajak_setahun)/12;


              // if($selisih_thr2<0){
              //       $selisih_thr = 0;
              // }else{
              //   $selisih_thr = $selisih_thr2;
              // }




                 $pajak_thr_nominal = $this->db->query('select * from payroll.pajak_thr_nominal where kar_id =  "'.$data_bpjs->kar_id.'"')->row();

                 if($pajak_thr_nominal){
                    $selisih_thr = $pajak_thr_nominal->jumlah;
                 }else{
                    $selisih_thr = 0;
                 }





                

                if($tahun_pajak<12){
                    
                    $pajak_perbulan_final = round($pajak_setahun/$tahun_pajak);
                   // $pajak_perbulan_final = 12;
                }else{
                    $pajak_perbulan_final = $pajak_perbulan;
                }

                 if($tahun_pajak<12){
                    
                    $pajak_perbulan_insentif_final = round($pajak_setahun_insentif/$tahun_pajak);
                    //$pajak_perbulan_insentif_final = 12;
                }else{
                   // $pajak_perbulan_insentif_final = $pajak_perbulan_insentif;

                     $pajak_perbulan_insentif_final = round($pajak_setahun_insentif/12);

                }

                $pph_bayar2 = $pajak_perbulan_insentif_final+$selisih_thr;

                if($pph_bayar2<0){
                    $pph_bayar = 0;
                }else{
                    $pph_bayar = $pph_bayar2;
                }


               $array_tg = array(
                'cid' => (string)$data_bpjs->kar_nik,
                'secret' => (string)$data_bpjs->kar_id,
                'data' => (string)$total_gaji,
                'action' => 'encrypt',
            );

            $total_gaji_en = educrypt($array_tg);


            $array_total_gaji_inf = array(
                'cid' => (string)$data_bpjs->kar_nik,
                'secret' => (string)$data_bpjs->kar_id,
                'data' => (string)intval($total_gaji+$insentif+$t_beras),
                'action' => 'encrypt',
            );

            $array_total_gaji_inf_en = educrypt($array_total_gaji_inf);


            $array_total_gaji_setahun = array(
                'cid' => (string)$data_bpjs->kar_nik,
                'secret' => (string)$data_bpjs->kar_id,
                'data' => (string)$total_gaji_setahun,
                'action' => 'encrypt',
            );

            $total_gaji_setahun_en = educrypt($array_total_gaji_setahun);


           

            $data_array = array(
                'kar_id'=>$data_bpjs->kar_id,
                'kar_nik'=>$data_bpjs->kar_nik,
                'kar_nm'=>$data_bpjs->kar_nm,
                // 'bulan'=>date('m-Y'),
                'bulan'=>'08-2022',
                'npwp'=>$data_bpjs->kar_dtl_no_npw,
                'anak'=>$data_bpjs->kar_dtl_jml_ank,
                'status_perkawinan'=>$data_bpjs->kar_dtl_sts_nkh,
                'total_gaji'=>$total_gaji_en,
                't_lain'=>$t_beras,
                
                'insentif'=>$insentif,
               
                'total_gaji_inf'=>$array_total_gaji_inf_en,
                'total_gaji_setahun'=>$total_gaji_setahun_en,
                'jabatan'=>$jabatan,
                'tot_ptkp'=>$tot_ptkp,
                'tot_jht_jp_setahun'=>$tot_jht_jp_setahun,
                'gaji_pajak_setahun'=>$gaji_pajak_setahun_insentif,
                'pajak_setahun'=>$pajak_setahun,
                'pajak_setahun_thr'=>$pajak_setahun_thr,
                'selisih_thr'=>$selisih_thr,
                'pajak_perbulan'=>$pajak_perbulan_insentif,
                'pph_dibayar' => $pph_bayar,
                'crdt'=>date('Y-m-d H:i:s'),
    
            );
    
            $simpan = $this->db->insert('payroll.pajak',$data_array);

        }

        if($simpan){
            redirect('gaji/pajak');
        }

      
    }


    function pajak_insert_testing(){
        error_reporting(0);
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


            if($k[0][1]!='nik' and $k[0][1]!='NIK' and $k[0][1]!=''){

               

                $nik = $k[0][1];
                $kar_nm = $k[0][2];
                $jumlah = $k[0][6];

                $insert_nik = $this->db->query("select * from kar_master where kar_nik='".$nik."'")->row();
              

                $data_simpan = array(
                    'kar_id'=> $insert_nik->kar_id,
                    'kar_nm'=> $kar_nm,
                    'kar_nik'=>$nik,
                    'nominal'=>$jumlah,
                    'bulan'=>'08-2022',
                 


                );

                $cek_update = $this->db->query("select * from payroll.pajak_testing where kar_nik='".$nik."'")->row();

                if($cek_update){
                    $this->db->update('payroll.pajak_testing',$data_simpan,array('kar_nik',$nik));
                }else{
                    $this->db->insert('payroll.pajak_testing',$data_simpan);
                }
               

            }

          }

              $message = array(
              'message'=>'<div class="alert alert-success">Import file Suksess</div>',
          );
           $this->session->set_flashdata($message);
          redirect('gaji/pajak');


      
            
       


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

    function selisih_pajak(){
        $data['data_kar'] = $this->db->query('select * from payroll.pajak as f left join payroll.pajak_testing as t on t.kar_id = f.kar_id')->result();
        
        $this->load->view('gaji/pajak/selisih_pajak',$data);
    }








    

    
   


    
    
}
