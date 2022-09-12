<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Bpjs.xlsx"');
header('Cache-Control: max-age=0');
?>

<table border="1" id="tablekaryawan">
    <thead>
                                <tr class="">
                                    <th></th>
                                    <th>Nik </th>
                                    <th>Nama</th>
                                    <th>Total Gaji</th>

                                    <th>Status Perkawinan</th>
                                    <th>Jumlah Anak</th>

                                    <th>BPJS (K) 1%</th>
                                    <th>JHT (K) 2%</th>
                                    <th>JP JP (K) 1 %</th>


                                    <th>BPJS (PK) 4%</th>
                                    <th>JKK(PK) 0,24% </th>
                                    <th>JHT (PK) 3,70% </th>
                                    <th>JKM (PK) 0,30%</th>
                                    <th>JP (PK) 2%</th>

                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                error_reporting(0);
                                // echo "<pre>";
                                // print_r($bpjs);

                                $no = 1;

                                $tot_bpjs_k  = 0;
                                $tot_jht_k  = 0;
                                $tot_jp_k = 0;


                                $tot_bpjs_pk = 0;
                                $tot_jkk_pk = 0;
                                $tot_jht_pk = 0;
                                $tot_jkm_pk = 0;
                                $tot_jp_pk = 0;


                                foreach ($bpjs as $data_bpjs) {


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


            $tot_bpjs_k += $bpjs_k_value;
             $tot_jht_k += $jht_k_value;

             $tot_jp_k += $jp_pk_value;
             $tot_bpjs_pk += $bpjs_pk_value;

             $tot_jkk_pk += $bpjs_pk_value;
             $tot_jht_pk += $bpjs_pk_value;

             $tot_jkm_pk += $jkm_pk_value;
             $tot_jp_pk += $jp_pk_value;

             
             

                                ?>
                                    <tr>
                                        <td><?php echo $no++ ?> </td>
                                        <td><?php echo $data_bpjs->kar_nik ?> </td>
                                        <td><?php echo $data_bpjs->kar_nm ?> </td>
                                        <td><?php echo number_format($tot_gaji->tot) ?> </td>
                                        <td><?php echo $data_bpjs->kar_dtl_sts_nkh ?> </td>
                                        <td><?php echo $data_bpjs->kar_dtl_jml_ank ?> </td>
                                        <td><?php echo number_format($bpjs_k_value) ?> </td>
                                        <td><?php echo number_format($jht_k_value) ?> </td>
                                        <td><?php echo number_format($jp_k_value) ?> </td>

                                        <td><?php echo number_format($bpjs_pk_value) ?> </td>
                                        <td><?php echo number_format($jkk_pk_value) ?> </td>
                                        <td><?php echo number_format($jht_pk_value) ?> </td>
                                        <td><?php echo number_format($jkm_pk_value) ?> </td>
                                        <td><?php echo number_format($jp_pk_value) ?> </td>



                                    </tr>

                                <?php
                                }
                                ?>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="5">Total </td>
                                    <td><?php echo number_format($tot_bpjs_k); ?></td>
                                    <td><?php echo number_format($tot_jht_k); ?></td>
                                    <td><?php echo number_format($tot_jp_k); ?></td>


                                    <td><?php echo number_format($tot_bpjs_pk) ?> </td>
                                    <td><?php echo number_format($tot_jkk_pk) ?> </td>
                                    <td><?php echo number_format($tot_jht_pk) ?> </td>
                                    <td><?php echo number_format($tot_jkm_pk) ?> </td>
                                    <td><?php echo number_format($tot_jp_pk) ?> </td>
                                </tr>
                            </tfoot>


                        </table>