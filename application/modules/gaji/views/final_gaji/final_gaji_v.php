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


<div class="card">

    <div class="card-body">
        <div class="table-responsive">
            <a href="<?php echo base_url('gaji/final_gaji/download_excel') ?>" class="btn btn-primary btn-sm">Download Excel</a>
            <center>
               <?php 
                //$bulan_ini = date('m');
                $bulan_ini = '09';
               ?>
                <h2>Laporan Penggajian <?php echo BulanIndo($bulan_ini) ?> <?php echo ' ' . date('Y') ?></h2>
            </center>

            <?php 
            $bulan_where = date('m-Y');
                $cek_final_gaji = $this->db->query('select * from payroll.final_gaji where bulan="'.$bulan_where.'" limit 1')->row();
                if($cek_final_gaji){
                        ?>
                                 <button class="btn btn-success btn-sm" disabled  >Sudah DI Acc Divisi Keuangan</button>
                        <?php
                }else{
                    ?>
                                  <a href="<?php echo base_url('gaji/final_gaji/insert_final')?>" onclick="return confirm('Apakah Kamu Yakin?')" class="btn btn-success btn-sm">Mengetahui Divisi Keuangan</a>

                    <?php
                    

                }
            
            ?>

 <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#upload_excel">Upload Excel Testing</button>
            <br> 




            <br> <br> <br>
            <div class="fixTableHead">
                <table class="table table-striped table-bordered table-hover" id="tablekaryawan">
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
                               <th>Potongan Beras</th>
                            <th>Potongan Lainya</th>
                            <th>Total Potongan</th>
                            <th>Total diterima</th>
                            <th>Pph 21 Belum dibayar</th>



                        </tr>
                    </thead>

                    <tbody style="height:300px;overflow-y:scroll">



                        <?php

$tot_bpjs_k = 0 ;
$tot_jht_k  = 0 ;
$tot_jp_k = 0 ;
$tot_bpjs_pk = 0 ;;
$tot_jkk_pk = 0 ;
$tot_jht_pk = 0 ;
$tot_jkm_pk = 0 ;
$tot_jp_pk = 0 ;


                        // $bulan_dibayarkan = date('Y-m');
                        // $waktu = date('Y-m-d');

                        // $bulan_where = date('m');
                        // $year_where = date('Y');
                        //$bulan_where_tahun = date('m-Y');
                        // $bulan_tahun = date('mY');

                        $bulan_dibayarkan = '2022-09';
                        $waktu = '2022-09-31';

                        $bulan_where = '09';
                        $year_where = '2022';

                        $bulan_where_tahun = '09-2022';
                         $bulan_tahun = '092022';

                          


                        $no = 1;
                        $tot_harga = 0;
                        $tot_total_penerimaan = 0;
                        $tot_pph_dibayar = 0;
                        foreach ($data_kar as $m) {
                            error_reporting(0);
                            $data_kom = $this->db->query('select * from payroll.komponen_gaji where kar_id =  "' . $m->kar_id . '"')->row();
                            $data_insentif = $this->db->query('select jumlah from payroll.insentif where kar_id =  "' . $m->kar_id . '" and date(bulan_dibayarkan) = "' . $bulan_dibayarkan . '" ')->row();

                            $insentif = $data_insentif->jumlah;

                            $data_listrik = $this->db->query('select total from payroll.listrik where kar_id =  "' . $m->kar_id . '" and month(crdt) = "' . $bulan_where . '" and year(crdt) = "' . $year_where . '" ')->row();
                            //$t_listik = $data_listrik->total;

                            if($data_listrik){
                                $t_listik = $data_listrik->total;
                            }else{
                                $t_listik = 0;
                            }

                           




                            $data_dinas = $this->db->query('select sum(jumlah_hari) as jumlah from dinas_lk where kar_id =  "' . $m->kar_id . '" and month(tgl_selesai) = "' . $bulan_where . '" and year(tgl_selesai) = "' . $year_where . '" ')->row();
                           

                            if($data_dinas){
                                $t_dinas = $data_dinas->jumlah * 40000;
                            }else{
                                $t_dinas = 0;
                            }

                            $kar_bpjs = $this->db->query('select sembako,iuran_paguyuban from payroll.kar_bpjs where kar_id =  "' . $m->kar_id . '"')->row();

                          

                            $data_sembako = $this->db->query('select harga from payroll.sembako where kar_id =  "' . $m->kar_id . '" and bulan="' . $bulan_where_tahun . '"')->row();

                            if ($data_sembako) {
                                if($kar_bpjs->sembako==2 || $kar_bpjs->sembako==0 ){
                                    $potongan_beras = 0;
                                }else{
                                    
                                    $potongan_beras = $data_sembako->harga;
                                }
                               
                            } else {
                                $potongan_beras = 0;
                            }


                            if ($data_sembako) {
                               
                                    
                                    $t_beras = $data_sembako->harga;
                               
                            } else {
                                $t_beras = 0;
                            }



                            $t_lain = $t_beras+$t_dinas;

                            $array_gp = array(
                                'cid' => (string)$data_kom->nik,
                                'secret' => (string)$data_kom->kar_id,
                                'data' => (string)$data_kom->gaji_pokok,
                                'action' => 'decrypt',
                            );
                
                            $gaji_pokok_en = educrypt($array_gp);
                
                
                            $array_t_fungsional = array(
                                'cid' => (string)$data_kom->nik,
                                'secret' => $data_kom->kar_id,
                                'data' => (string)$data_kom->t_fungsional,
                                'action' => 'decrypt',
                            );
                
                            $t_fungsional_en = educrypt($array_t_fungsional);
                
                
                            $array_t_struktural = array(
                                'cid' => (string)$data_kom->nik,
                                'secret' => $data_kom->kar_id,
                                'data' => (string)$data_kom->t_struktural,
                                'action' => 'decrypt',
                            );
                
                            $t_struktural_en = educrypt($array_t_struktural);
                
                
                            $array_t_umum = array(
                                'cid' => (string)$data_kom->nik,
                                'secret' => $data_kom->kar_id,
                                'data' => (string)$data_kom->t_umum,
                                'action' => 'decrypt',
                            );
                
                            $t_umum_en = educrypt($array_t_umum);
                
                            $array_t_kinerja = array(
                                'cid' => (string)$data_kom->nik,
                                'secret' => $data_kom->kar_id,
                                'data' => (string)$data_kom->t_kinerja,
                                'action' => 'decrypt',
                            );

                            $t_kinerja_en = educrypt($array_t_kinerja);


                         
                            $gaji_tetap = intval($gaji_pokok_en+$t_fungsional_en+$t_struktural_en);
                            $gaji_tidak_tetap = intval($t_umum_en+$t_kinerja_en);

                            

                            $total_gaji = $gaji_tetap + $gaji_tidak_tetap + $t_lain;
                            $total_gaji_inst = $gaji_tetap + $gaji_tidak_tetap + $t_lain + $insentif;




                            $r_bpjs = $this->db->query('select * from payroll.bpjs where kar_id =  "' . $m->kar_id . '" and bulan="' . $bulan_where_tahun . '"')->row();


                            if ($r_bpjs) {

                                $bpjs_k  = $r_bpjs->bpjs_k_1;
                                $bpjs_pk = $r_bpjs->bpjs_pk_4;

                                $jht_k  = $r_bpjs->jht_k_2;
                                $jht_pk = $r_bpjs->jht_pk;

                                $jp_k  = $r_bpjs->jp_k_1;
                                $jp_pk  = $r_bpjs->jp_pk;
                                $jkk_pk = $r_bpjs->jkk_pk_024;
                                $jkm_pk = $r_bpjs->jkm_pk;

                                $gaji_bpjs = $r_bpjs->gaji_bpjs;
                            } else {
                                $bpjs_k  = 0;
                                $bpjs_pk = 0;

                                $jht_k  = 0;
                                $jht_pk = 0;

                                $jp_k  = 0;
                                $jp_pk  = 0;

                                $jkk_pk = 0;
                                $jkm_pk = 0;
                            }








                            $tot_bpjs_k += $bpjs_k;
                            $tot_jht_k  += $jht_pk;
                            $tot_jp_k += $jp_k;


                            $tot_bpjs_pk += $bpjs_pk;
                            $tot_jkk_pk += $jkk_pk;
                            $tot_jht_pk += $tot_jht_k;
                            $tot_jkm_pk += $jkm_pk;
                            $tot_jp_pk += $jp_pk;


                           


                            $data_paguyuban_pinjam = $this->db->query('select dibayarkan from payroll.paguyuban_pinjam where kar_id =  "' . $m->kar_id . '"  and bulan = "'.$bulan_dibayarkan.'"')->row();
                                     $paguyuban_pinjam = $data_paguyuban_pinjam->dibayarkan;
         
         
                                     $cek_data_paguyban = $this->db->query("select kar_id_dipinjam from _paguyuban_master where pg_status = 'Disetujui' and pg_ke < 10 and pg_kar_id =  '" . $m->kar_id . "' order by pg_id desc")->row();
         
         
                                     if ($cek_data_paguyban->kar_id_dipinjam) {
                                         $paguyuban = 0;
                                     } else {

                                         $data_paguyuban = $this->db->query('select dibayarkan from payroll.paguyuban where kar_id =  "' . $m->kar_id . '"  and bulan = "'.$bulan_dibayarkan.'"')->row();
                                         $paguyuban = $data_paguyuban->dibayarkan + $paguyuban_pinjam;
                                    
                                        }
                           





                            $cek_masa_kerja = $this->db->query('select  kar_dtl_tgl_joi,kar_dtl_tgl_res from
                            kar_detail where kar_id =  "'.$m->kar_id.'"')->row();
                                       
                            $iuran_paguyban_lebih_sebulan =  date('Y-m-d', strtotime('+1 month', strtotime($cek_masa_kerja->kar_dtl_tgl_joi)));


                            if ($iuran_paguyban_lebih_sebulan >= $waktu) {
                                $iuran_paguyuban = 0;
                            } else {
                                // yg tidak dipotong iuaran paguyuban
                               // if($m->kar_id=='11' || $m->kar_id=='634' || $m->kar_id=='665' || $m->kar_id=='664' || $m->kar_id=='666' || $m->kar_id=='667' || $m->kar_id=='668' || $m->kar_id=='680'){
                                if($kar_bpjs->iuran_paguyuban==0){ 
                                $iuran_paguyuban = 0;
                                }else{

                                

                                if($cek_masa_kerja->kar_dtl_tgl_res!='0000-00-00'){
                                     $tgl_risen = date('d', strtotime($cek_masa_kerja->kar_dtl_tgl_res));

                                     $waktu_sebulan = date('d', strtotime($tgl_akhir_bulan));

                                     if($waktu_sebulan!=$tgl_risen){
                                        $iuran_paguyuban = 0;
                                     }else{
                                        $iuran_paguyuban = 55000;
                                     }

                                }else{
                                    $iuran_paguyuban = 55000;

                                }

                            }

                                
                                
                            }

                            $data_potongan_lain_lain = $this->db->query('select nominal from payroll.potongan_lain_lain where kar_id =  "' . $m->kar_id . '" and bulan="'.$bulan_dibayarkan.'"')->row();
                            //$t_listik = $data_potongan_lain_lain->total;

                           

                            if($data_potongan_lain_lain){
                                $potongan_lain_lain = $data_potongan_lain_lain->nominal;
                            }else{
                                $potongan_lain_lain = 0;
                            }

                            


                            $kar_jabodetabek = $this->db->query("select jdw_zona from jdw_master as j
                            inner join kar_master as k on j.jdw_nik=k.kar_nik 
                            where  j.jdw_blnthn = '" . $bulan_tahun . "' and j.jdw_nik='".$m->kar_nik."' and jdw_zona = 'JABODETABEK'")->row();


                           

                            if($kar_jabodetabek){
                                $potongan = $bpjs_k + $jht_k + $iuran_paguyuban + $jp_k + $paguyuban  + $potongan_beras + $t_listik + $potongan_lain_lain;
                            }else{

                                // potongan beras langsung
                                if($m->kar_id=='10' || $m->kar_id=='382' || $m->kar_id=='383'){
                                    $potongan = $bpjs_k + $jht_k + $iuran_paguyuban + $jp_k + $paguyuban  + $potongan_beras + $t_listik +$potongan_lain_lain;
                                }else{
                                    $potongan = $bpjs_k + $jht_k + $iuran_paguyuban + $jp_k + $paguyuban  + 0 + $potongan_lain_lain;

                                    //$potongan = 122;
                                }
                               
                            }

                         



                            $total_penerimaan =  $total_gaji - $potongan;




                            	//$tgl_akhir_bulan2 =  date('m-Y', strtotime('-1 month', strtotime( $tgl_akhir_bulan)));
                            $tgl_akhir_bulan2 = date('m-Y', strtotime($tgl_akhir_bulan));
                             

                             $kar_dtl_tgl_joi2 = date('m-Y', strtotime($m->kar_dtl_tgl_joi));
                             $kar_dtl_tgl_res2 = date('m-Y', strtotime($m->kar_dtl_tgl_res));

       //                   	$kar_dtl_tgl_joi2 =  date('m-Y', strtotime('-1 month', strtotime( $m->kar_dtl_tgl_joi)));
							// $kar_dtl_tgl_res2 =  date('m-Y', strtotime('-1 month', strtotime( $m->kar_dtl_tgl_res) ));



                           

                            $cek_absen_masuk = $this->db->query('select count(kar_id) as total from abs_detail where kar_id = "' . $m->kar_id . '" and MONTH(abs_dtl_tgl) = "' . $bulan_where . '" and year(abs_dtl_tgl) = "' . $year_where . '" and abs_dtl_sts = "H"')->row();
                            $cek_absen_libur = $this->db->query('select count(kar_id) as total from abs_detail where kar_id = "' . $m->kar_id . '" and MONTH(abs_dtl_tgl) = "' . $bulan_where . '" and year(abs_dtl_tgl) = "' . $year_where . '" and abs_dtl_sts = "L"')->row();



                           


                            //$karname = $this->db->query("select * from kar_master where kar_id='" . $m->kar_id . "'")->row();
                            $data['jadwal2'] = $this->db->query("select * from jdw_master as j
                        inner join kar_master as k on j.jdw_nik=k.kar_nik 
                        where  j.jdw_blnthn = '" . $bulan_tahun . "' and j.jdw_nik='SG.0617.2021'")->result();

                            // $tgl = date('d') - 1;
                              $tgl = 30 - 1;
                            $jad = $data['jadwal2'][0]->jdw_data;
                            $jadwal = explode("#", $jad);


                            foreach ($jadwal as $key => $j) {

                                if ($key <= $tgl) {
                                    $data_array[$key] = $j;
                                }
                            }



                            $jumlah = array_count_values($data_array);

                          

                            $libur = $jumlah['L'] + $jumlah['LN'] + $jumlah['LM'];

                            

                            $absen_masuk = $cek_absen_masuk->total;
                            // $libur = 5;
                            $waktu_sebulan = date('d', strtotime($tgl_akhir_bulan));
                            $hari_kerja = $waktu_sebulan - $libur;

                           

                           

                            if ($tgl_akhir_bulan2 == $kar_dtl_tgl_joi2) {
                                $colom = 'style="
                            background: green;
                        "';


                                //jumlah absen masuk/bulan -libur*gaji


                                $total_penerimaan = ($absen_masuk / $hari_kerja) * $total_gaji;
                            } else {
                                $colom = "";
                            }

                            if ($tgl_akhir_bulan2 == $kar_dtl_tgl_res2) {
                                $colom = 'style="
                            background: red;
                        "';
                                $total_penerimaan = (($absen_masuk / $hari_kerja) * $total_gaji) - $potongan;
                            }




                            $tot_total_penerimaan += $total_penerimaan;

                            $data_pajak = $this->db->query('select pph_dibayar from payroll.pajak where kar_id =  "' . $m->kar_id . '"  and bulan = "' . $bulan_where_tahun.'"')->row();
                            
                            if($data_pajak){
                                $pph_dibayar = $data_pajak->pph_dibayar;
                            }else{
                                $pph_dibayar = 0;
                            }

                            $tot_pph_dibayar += $pph_dibayar;
                           



                        ?>
                            <tr>
                                <td <?php echo $colom ?>><?php echo $no++; ?>- <?php echo $tgl_akhir_bulan2?> <?php echo $kar_dtl_tgl_joi2?>  </td>
                                <td><?php echo $cek_absen_masuk->total; ?></td>
                                <td><?php echo $libur; ?></td>
                                <td><?php echo $hari_kerja; ?></td>
                                <td><?php echo $m->kar_nik ?>  </td>
                                <td><?php echo $m->kar_nm ?> <?php echo $cek_data_paguyban->pg_kar_id ?></td>
                                <td><?php echo date('d-M-Y', strtotime($m->kar_dtl_tgl_joi)) ?></td>
                                <td><?php echo number_format($gaji_pokok_en) ?></td>
                                <td><?php echo number_format($t_struktural_en) ?></td>
                                <td><?php echo number_format($t_fungsional_en) ?></td>
                                <td><b><?php echo number_format($gaji_tetap) ?></b></td>
                                <td><?php echo number_format($t_umum_en) ?></td>
                                <td><?php echo number_format($t_kinerja_en) ?></td>
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
                                 <td><?php echo number_format($potongan_beras);?>
                                <td><?php echo number_format($potongan_lain_lain);?>
                                <td><?php echo number_format($potongan) ?> </td>
                                <td><b><?php echo number_format($total_penerimaan) ?> <b></td>
                                <td><?php echo number_format($pph_dibayar)?></td>






                            </tr>

                        <?php
                        }
                        ?>

                    </tbody>

                    <tfoot>
                        <tr>
                            <td></td>
                            <td colspan="31">Total Pembayaran</td>
                            <td><b><?php echo number_format($tot_total_penerimaan); ?></b></td>
                             <td><b><?php echo number_format($tot_pph_dibayar); ?></b></td>
                        </tr>
                    </tfoot>


                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>


<!-- Modal -->
<div id="upload_excel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">


            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                    <h4 class="modal-title" id="modalLabel"><i class="fa fa-plus" aria-hidden="true"></i> Form Upload Insentif</h4>

                </div>
                <div class="modal-body">
                    <form role="form" action="<?php echo base_url('gaji/final_gaji/final_gaji_testing') ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                               
                                <input class="form-control form-control-sm" id="formFileSm" name="file" type="file">
                                Upload Data Listrik
                                <label>Format Excel</label>
                                <a href="<?php echo base_url('assets/berkas/insentif.xlsx')?>" class="">Format Excel . xls</a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="bsave" class="btn btn-primary px-4">Simpan</button>
                        </div>

                    </form>
                </div>

            </div>


        </div>

    </div>
</div>