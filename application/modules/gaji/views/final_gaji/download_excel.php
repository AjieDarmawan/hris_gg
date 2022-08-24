<center><h2>Laporan Penggajian <?php echo BulanIndo(date('m'))?> <?php echo ' '. date('Y')?></h2></center>

<table border="1">
<thead>
                    <tr class="table-success">
                        <th></th>
                        <th>Jumlah Hari Masuk</th>
                        <th>Libur</th>
                        <th>Jumlah Masuk</th>
                        <th>Nik</th>
                        <th>Nama</th>
                        <th>Tgl Masuk</th>
                        <th>Gaji Pokok</th>
                        <th>T.Struktural</th>
                        <th>T.Fungsional</th>
                        <th>Upah Gaji Tetap</th>


                        <th>T.Umum</th>
                        <th>T.Kinerja</th>
                        <th>Upah Gaji Tidak Tetap</th>

                        <th>T.Beras</th>
                        <th>T.Dinas</th>
                        <th>T.Listrik</th>
                        <th>T.Lain-lain</th>

                        <th>Insentif</th>
                        <th>Total Gaji</th>
                        <th>Total Gaji + insentif</th>



                        <th>BPJS (K) 1%</th>
                        <th>JHT (K) 2%</th>
                        <th>JP JP (K) 1 %</th>


                        <th>BPJS (PK) 4%</th>
                        <th>JKK(PK) 0,24% </th>
                        <th>JHT (PK) 3,70% </th>
                        <th>JKM (PK) 0,30%</th>
                        <th>JP (PK) 2%</th>
                        <th>Iuran Paguyuban</th>
                        <th>Paguyuban</th>
                        <th>Total Potongan</th>
                        <th>Total diterima</th>







                    </tr>
                </thead>

                <tbody>

                    <?php


                    $bulan_dibayarkan = date('Y-m');
                    $waktu = date('Y-m-d');

                    $bulan_where = date('m');
                    $year_where = date('Y');
                    $no = 1;
                    $tot_harga = 0;
                    foreach ($data_kar as $m) {
                        error_reporting(0);
                        $data_kom = $this->db->query('select * from payroll.komponen_gaji where kar_id =  "' . $m->kar_id . '"')->row();
                        $data_insentif = $this->db->query('select * from payroll.insentif where kar_id =  "' . $m->kar_id . '" and date(bulan_dibayarkan) = "' . $bulan_dibayarkan . '" ')->row();

                        $insentif = $data_insentif->jumlah;

                        $data_listrik = $this->db->query('select * from payroll.listrik where kar_id =  "' . $m->kar_id . '" and month(crdt) = "'.$bulan_where.'" and year(crdt) = "'.$year_where.'" ')->row();
                        $t_listik = $data_listrik->total;

                        $data_dinas = $this->db->query('select sum(jumlah_hari) as jumlah from dinas_lk where kar_id =  "' . $m->kar_id . '" and month(tgl_selesai) = "'.$bulan_where.'" and year(tgl_selesai) = "'.$year_where.'" ')->row();
                        $t_dinas = $data_dinas->jumlah * 40000;


                        $data_sembako = $this->db->query('select d.kar_dtl_sts_nkh,k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
                        inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
                        and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() and k.kar_id = "'.$m->kar_id.'"')->row();
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

                       
                        
                        $t_lain = $t_listik + $t_beras;


                        $gaji_tetap = $data_kom->gaji_pokok + $data_kom->t_struktural + $data_kom->t_fungsional;
                        $gaji_tidak_tetap = $data_kom->t_umum + $data_kom->t_kinerja;

                        $total_gaji = $gaji_tetap + $gaji_tidak_tetap + $t_lain;
                        $total_gaji_inst = $gaji_tetap + $gaji_tidak_tetap+$t_lain+ $insentif;


                        // $tot_gaji = $this->db->query('select sum(gaji_pokok+t_struktural+t_fungsional+t_umum+t_kinerja) as tot from payroll.komponen_gaji where kar_id =  "' . $m->kar_id . '"')->row();

                        // $total_gaji = $tot_gaji->tot;


                        $tot_gaji_aa = $this->db->query('select sum(gaji_pokok+t_struktural) as tot from payroll.komponen_gaji where kar_id =  "'.$m->kar_id.'"')->row();
                                    
                      
            
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
                
                                $jkk_pk = $tot_gaji_a*0.4/100;
                                $jkm_pk = $tot_gaji_a*0.30/100;
                
                                $bpjs_k  = $tot_gaji_a*1/100;
                                $bpjs_pk = $tot_gaji_a*4/100;
                
                                $jht_k  = $tot_gaji_a*2/100;
                                $jht_pk = $tot_gaji_a*3.70/100;
                
                                $jp_k  = $tot_gaji_a*1/100;
                                $jp_pk  = $tot_gaji_a*2/100;
                
                                $jkk_pk = $tot_gaji_a*0.4/100;
                                $jkm_pk = $tot_gaji_a*0.30/100;
            
                            }else{
                                $bpjs_k  = $bpjs_default*1/100;
                                $bpjs_pk = $bpjs_default*4/100;
            
                                $jht_k  = $bpjs_default*2/100;
                                $jht_pk = $bpjs_default*3.70/100;
            
                                $jp_k  = $bpjs_default*1/100;
                                $jp_pk  = $bpjs_default*2/100;
            
                                $jkk_pk = $bpjs_default*0.4/100;
                                $jkm_pk = $bpjs_default*0.30/100;
            
                                $bpjs_k  = $bpjs_default*1/100;
                                $bpjs_pk = $bpjs_default*4/100;
            
                                $jht_k  = $bpjs_default*2/100;
                                $jht_pk = $bpjs_default*3.70/100;
            
                                $jp_k  = $bpjs_default*1/100;
                                $jp_pk  = $bpjs_default*2/100;
            
                                $jkk_pk = $bpjs_default*0.4/100;
                                $jkm_pk = $bpjs_default*0.30/100;
                            }
            
                        }elseif($total_gaji>=12000000){
                            // A + B;
            
                            $bpjs_k  = $tot_gaji_a*1/100;
                            $bpjs_pk = $tot_gaji_a*4/100;
            
                            $jht_k  = $tot_gaji_a*2/100;
                            $jht_pk = $tot_gaji_a*3.70/100;
            
                            $jp_k  = $tot_gaji_a*1/100;
                            $jp_pk  = $tot_gaji_a*2/100;
            
                            $jkk_pk = $tot_gaji_a*0.4/100;
                            $jkm_pk = $tot_gaji_a*0.30/100;
            
                            $bpjs_k  = $tot_gaji_a*1/100;
                            $bpjs_pk = $tot_gaji_a*4/100;
            
                            $jht_k  = $tot_gaji_a*2/100;
                            $jht_pk = $tot_gaji_a*3.70/100;
            
                            $jp_k  = $tot_gaji_a*1/100;
                            $jp_pk  = $tot_gaji_a*2/100;
            
                            $jkk_pk = $tot_gaji_a*0.4/100;
                            $jkm_pk = $tot_gaji_a*0.30/100;
            
                            
                     
            
                        }


                        $tot_bpjs_k += $bpjs_k;
                        $tot_jht_k  += $jht_pk;
                        $tot_jp_k += $jp_k;


                        $tot_bpjs_pk += $bpjs_pk;
                        $tot_jkk_pk += $jkk_pk;
                        $tot_jht_pk += $tot_jht_k;
                        $tot_jkm_pk += $jkm_pk;
                        $tot_jp_pk += $jp_pk;

                        $data_paguyuban = $this->db->query('select * from payroll.paguyuban where kar_id =  "' . $m->kar_id . '" and date(crdt) = "' . $waktu . '" ')->row();
                        $paguyuban = $data_paguyuban->dibayarkan;

                        $iuran_paguyuban = 55000;


                        $potongan = $bpjs_k + $jht_k + $iuran_paguyuban + $jp_k + $paguyuban + $t_beras;


                       











                        $total_penerimaan =  $total_gaji - $potongan;

                        

                         $tgl_akhir_bulan2= date('m-Y',strtotime($tgl_akhir_bulan));
                         $kar_dtl_tgl_joi2= date('m-Y',strtotime($m->kar_dtl_tgl_joi));

                         $kar_dtl_tgl_res2= date('m-Y',strtotime($m->kar_dtl_tgl_res));

                         $cek_absen_masuk = $this->db->query('select count(kar_id) as total from abs_detail where kar_id = "'.$m->kar_id.'" and MONTH(abs_dtl_tgl) = "'.date('m').'" and year(abs_dtl_tgl) = "'.date('Y').'" and abs_dtl_sts = "H"')->row();
                         $cek_absen_libur = $this->db->query('select count(kar_id) as total from abs_detail where kar_id = "'.$m->kar_id.'" and MONTH(abs_dtl_tgl) = "'.date('m').'" and year(abs_dtl_tgl) = "'.date('Y').'" and abs_dtl_sts = "L"')->row();
                         
                        $waktu_sebulan = date('d',strtotime($tgl_akhir_bulan));

                         if($tgl_akhir_bulan2==$kar_dtl_tgl_joi2){
                            $colom = 'style="
                            background: green;
                        "';

                            //jumlah absen masuk/bulan -libur*gaji

                            $total_penerimaan = ($cek_absen_masuk->total/$waktu_sebulan - $cek_absen_libur->total)*$total_gaji;
                         }else{
                            $colom = "";
                         }

                         if($tgl_akhir_bulan2==$kar_dtl_tgl_res2){
                            $colom = 'style="
                            background: red;
                        "';
                        $total_penerimaan = ($cek_absen_masuk->total/$waktu_sebulan - $cek_absen_libur->total)*$total_gaji;
                         }


                        

                        
      

                       




                    ?>
                        <tr>
                            <td <?php echo $colom?>><?php echo $no++; ?></td>
                            <td><?php echo $cek_absen_masuk->total;?></td>
                            <td><?php echo $cek_absen_libur->total;?></td>
                            <td><?php echo date('d',strtotime($tgl_akhir_bulan))?></td>
                            <td><?php echo $m->kar_nik ?></td>
                            <td><?php echo $m->kar_nm ?></td>
                            <td><?php echo date('d-M-Y', strtotime($m->kar_dtl_tgl_joi)) ?></td>
                            <td><?php echo number_format($data_kom->gaji_pokok) ?></td>
                            <td><?php echo number_format($data_kom->t_struktural) ?></td>
                            <td><?php echo number_format($data_kom->t_fungsional) ?></td>
                            <td><b><?php echo number_format($gaji_tetap) ?></b></td>
                            <td><?php echo number_format($data_kom->t_umum) ?></td>
                            <td><?php echo number_format($data_kom->t_kinerja) ?></td>
                            <td><b><?php echo number_format($gaji_tidak_tetap) ?></b></td>
                            
                           <td><?php echo number_format($t_beras) ?></td>
                           
                            <td><?php echo number_format($t_dinas) ?></td>
                            <td><?php echo number_format($t_listik) ?></td> 
                           
                            <td><b><?php echo number_format($t_lain) ?></b></td>
                            <td><?php echo number_format($insentif) ?></td>
                            <td style="color:blue"><?php echo number_format($total_gaji) ?></td>
                            <td><?php echo number_format($total_gaji_inst) ?></td>

                            <td><?php echo number_format($bpjs_k) ?> </td>
                            <td><?php echo number_format($jht_k) ?> </td>
                            <td><?php echo number_format($jp_k) ?> </td>

                            <td><?php echo number_format($bpjs_pk) ?> </td>
                            <td><?php echo number_format($jkk_pk) ?> </td>
                            <td><?php echo number_format($jht_pk) ?> </td>
                            <td><?php echo number_format($jkm_pk) ?> </td>
                            <td><?php echo number_format($jp_pk) ?> </td>
                            <td><?php echo number_format($iuran_paguyuban) ?> </td>
                            <td><?php echo number_format($paguyuban) ?> </td>
                            <td><?php echo number_format($potongan) ?> </td>
                            <td><b><?php echo number_format($total_penerimaan) ?> <b></td> 
                            
                           

                            


                        </tr>

                    <?php
                    }
                    ?>

                </tbody>

                <tfoot>
                    <tr>
                        <td></td>
                        <td>Total Harga</td>
                        <td><?php echo number_format($tot_harga); ?></td>
                    </tr>
                </tfoot>


            </table>