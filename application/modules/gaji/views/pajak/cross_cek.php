<style>
    .fixTableHead {
        overflow-y: auto;
        height: 500px;
    }

    .fixTableHead thead th {
        position: sticky;
        top: 0;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 8px 15px;
        border: 2px solid #529432;
    }

    th {
        background: #ABDD93;
    }
</style>



<div class="container pt-5">
    <h3><?= $title ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a>karyawan</a></li>
            <li class="breadcrumb-item active" aria-current="page">List Data</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">



            <a href="<?php echo base_url('gaji/pajak/download_excel') ?>" class=" btn btn-primary btn-sm">Download Excel</a>


            <div mb-2>
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                <?php $this->load->view('layouts/alert'); ?>
            </div>




            <div class="card">



                <div class="card-body">
                    <div class="table-responsive fixTableHead">
                        
                        <table class="table table-striped table-bordered table-hover" id="tablekaryawan">
                            <thead>
                                <tr class="">
                                    <th></th>
                                    <th>Nik </th>
                                    <th>Nama</th>
                                    <th>Npwp</th>
                                    <th>Total Gaji</th>
                                    <th>Tunjangan Lain</th>
                                    <th>Insentif</th>
                                    <th>Total gaji + insentif</th>
                                    <th>Status Perkawinan</th>
                                    <th>Jumlah Anak</th>

                                    <th>Tgl Join</th>
                                    <th>Hari THR</th>
                                    <th>Nominal THR</th>

                                    <th>Gaji Total 1 Tahun</th>
                                    <th>Jabatan</th>
                                    <th>PTKP</th>
                                    <th>Jht & Jp / Setahun</th>
                                    <th>Gaji Pajak Setahun</th>
                                    <th>Pajak Setahun</th>
                                    <th>Pajak Setahun THR</th>
                                    <th>Selisih Thr - P</th>
                                    <th>Pajak Perbulan</th>
                                    <th>Pajak Gaji</th>
                                  <!--   <th>Pajak + BONUS</th>
                                    <th>PKP THR</th> -->
                                    <th>PPh Di bayar</th>

                                </tr>
                            </thead>

                            <tbody>

                                <?php

                                error_reporting(0);

                                // echo "<pre>";
                                // print_r($bpjs);

                                $tot_pph_bayar = 0;

                                foreach ($bpjs as $data_bpjs) {

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

           
            
           

           //  $insentif = 0;

            //$dibayarkan = date('Y-m');
             $dibayarkan = '2022-08';

               //$bulan_where = date('m-Y');
            $bulan_where = '08-2022';

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

                   $tot_pph_bayar += $pph_bayar;


                                ?>
                                    <tr>
                                        <td><?php echo  $no++ ?></td>
                                        <td><?php echo  $data_bpjs->kar_nik ?></td>
                                        <td><?php echo  $data_bpjs->kar_nm ?></td>
                                        <td><?php echo  $data_bpjs->kar_dtl_no_npw ?></td>


                                        <td><?php echo  number_format($total_gaji) ?></td>
                                        <td><?php echo  number_format($t_beras) ?></td>
                                        <td><?php echo  number_format($insentif) ?></td>
                                        <td><?php echo  number_format($total_gaji + $insentif + $t_beras) ?></td>

                                        <td><?php echo  $data_bpjs->kar_dtl_sts_nkh ?></td>
                                        <td><?php echo  $data_bpjs->kar_dtl_jml_ank ?></td>

                                        <td><?php echo  $data_bpjs->kar_dtl_tgl_joi ?></td>
                                        <td><?php echo  $hari_thr ?></td>
                                        <td><?php echo  $thr ?></td>







                                        <td><?php echo  number_format($total_gaji_setahun) . "($total_gaji+$bpjs_pk+$jkk_pk+$jkm_pk)*12" ?></td>
                                        <td><?php echo  number_format($jabatan) ?></td>
                                        <td> <?php echo  number_format($tot_ptkp) ?> </td>
                                        <td> <?php echo  number_format($tot_jht_jp_setahun) ?> </td>
                                        <td> <?php echo  number_format($gaji_pajak_setahun) ?> </td>



                                        <td> <?php echo  number_format($pajak_setahun) ?> </td>
                                        <td> <?php echo  number_format($pajak_setahun_thr) ?> </td>
                                        <td> <?php echo  number_format($selisih_thr) ?> </td>
                                        <td> <?php echo  number_format($pajak_perbulan) ?> </td>

                                     
                                        <!-- td> <?php echo  number_format($pajak_perbulan) ?> </td>
                                        <td> <?php echo  number_format($pajak_perbulan_insentif) ?> ++ <?php echo  number_format($pajak_perbulan_insentif-$pajak_perbulan) ?>   </td> -->
                                        <td> <?php echo  number_format($selisih_thr) ?> </td>
                                        <td> <?php echo  number_format($pph_bayar) ?> </td>


                                        





                                    </tr>

                                <?php
                                }
                                ?>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="15">Total </td>
                                    <td><?php echo number_format($tot_bpjs_k); ?></td>
                                    <td><?php echo number_format($tot_jht_k); ?></td>
                                    <td><?php echo number_format($tot_jp_k); ?></td>


                                    <td><?php echo number_format($tot_bpjs_pk) ?> </td>
                                    <td><?php echo number_format($tot_jkk_pk) ?> </td>
                                    <td><?php echo number_format($tot_jht_pk) ?> </td>
                                    <td><?php echo number_format($tot_jkm_pk) ?> </td>
                                    <td><b><?php echo number_format($tot_pph_bayar) ?> </b></td>
                                </tr>
                            </tfoot>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>