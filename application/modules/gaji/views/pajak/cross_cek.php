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



            <a href="<?php echo base_url('gaji/bpjs/download_excel') ?>" class=" btn btn-primary btn-sm">Download Excel</a>


            <div mb-2>
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                <?php $this->load->view('layouts/alert'); ?>
            </div>




            <div class="card">



                <div class="card-body">
                    <div class="table-responsive">
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

                                    <th>Gaji Total 1 Tahun</th>
                                    <th>Jabatan</th>
                                    <th>PTKP</th>
                                    <th>Jht & Jp / Setahun</th>
                                    <th>Gaji Pajak Setahun</th>
                                    <th>Pajak Setahun</th>
                                    <th>Pajak Perbulan</th>

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





                                    $tot_gaji = $this->db->query('select sum(gaji_pokok+t_struktural+t_fungsional+t_umum+t_kinerja) as tot from payroll.komponen_gaji where kar_id =  "' . $data_bpjs->kar_id . '"')->row();

                                    $tunjangan = $this->db->query('select t_struktural from payroll.komponen_gaji where kar_id =  "' . $data_bpjs->kar_id . '"')->row();


                                    $total_gaji = $tot_gaji->tot;
                                    $ptkp_pekerja =  54000000;


                                    if ($data_bpjs->kar_dtl_jml_ank == 0) {
                                        $tot_ptkp = $ptkp_pekerja;
                                    } elseif ($data_bpjs->kar_dtl_jml_ank <= 3) {
                                        $ptkp_anak =  $data_bpjs->kar_dtl_jml_ank * 4500000;
                                        $tot_ptkp =  $ptkp_pekerja +  $ptkp_anak;
                                    }



                                    //  $insentif = 0;

                                    $dibayarkan = date('m-Y');

                                    $data_insentif = $this->db->query('select jumlah from payroll.insentif where kar_id =  "' . $data_bpjs->kar_id . '" and bulan_dibayarkan="' . $dibayarkan . '"')->row();

                                    if ($data_insentif->jumlah) {
                                        $insentif = $data_insentif->jumlah;
                                    } else {
                                        $insentif = 0;
                                    }

                                    $gaji_setahun = ($total_gaji + $insentif) * 12;


                                    $data_sembako = $this->db->query('select d.kar_dtl_sts_nkh,k.kar_nik,k.kar_id,k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
                                    inner join kar_detail as d on k.kar_id = d.kar_id where  kar_dtl_typ_krj != "Resign" 
                                    and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() and k.kar_id = "' . $data_bpjs->kar_id . '"')->row();
                                    $data_sembako->kar_dtl_sts_nkh;

                                    if (($data_sembako->kar_nik != 'SG.0060.2010' and $data_sembako->kar_nik != 'SG.0035.2007'
                                        and $data_sembako->kar_nik != 'SG.0410.2017' and $data_sembako->kar_nik != 'SG.0205.2014'
                                        and $data_sembako->kar_nik != 'SG.0247.2015' and $data_sembako->kar_nik != 'SG.0186.2014' and $data_sembako->kar_nik != 'SG.0273.2015')) {
                                        if ($data_sembako->kar_dtl_sts_nkh == 'TK') {
                                            $t_beras = 110000;
                                        } elseif ($data_sembako->kar_dtl_sts_nkh == 'K') {
                                            $t_beras = 220000;
                                        } else {
                                            $t_beras = 0;
                                        }
                                    } else {
                                        $t_beras = 0;
                                    }








                                    $tot_gaji_aa = $this->db->query('select sum(gaji_pokok+t_struktural) as tot from payroll.komponen_gaji where kar_id =  "' . $data_bpjs->kar_id . '"')->row();



                                    $tot_gaji_a = $tot_gaji_aa->tot;

                                    $bpjs_default = 4217206;


                                    //12000000
                                    if ($total_gaji >= 4337000) {
                                        // A 

                                        if ($tot_gaji_a > 4337000) {

                                            $bpjs_k  = $tot_gaji_a * 1 / 100;
                                            $bpjs_pk = $tot_gaji_a * 4 / 100;

                                            $jht_k  = $tot_gaji_a * 2 / 100;
                                            $jht_pk = $tot_gaji_a * 3.70 / 100;

                                            $jp_k  = $tot_gaji_a * 1 / 100;
                                            $jp_pk  = $tot_gaji_a * 2 / 100;

                                            $jkk_pk = $tot_gaji_a * 0.24 / 100;
                                            $jkm_pk = $tot_gaji_a * 0.30 / 100;



                                            $gaji_bpjs = $tot_gaji_a;
                                        } else {
                                            $bpjs_k  = $bpjs_default * 1 / 100;
                                            $bpjs_pk = $bpjs_default * 4 / 100;

                                            $jht_k  = $bpjs_default * 2 / 100;
                                            $jht_pk = $bpjs_default * 3.70 / 100;

                                            $jp_k  = $bpjs_default * 1 / 100;
                                            $jp_pk  = $bpjs_default * 2 / 100;

                                            $jkk_pk = $bpjs_default * 0.24 / 100;
                                            $jkm_pk = $bpjs_default * 0.30 / 100;



                                            $gaji_bpjs = $bpjs_default;
                                        }
                                    } elseif ($total_gaji >= 12000000) {
                                        // A + B;

                                        $bpjs_k  = $tot_gaji_a * 1 / 100;
                                        $bpjs_pk = $tot_gaji_a * 4 / 100;

                                        $jht_k  = $tot_gaji_a * 2 / 100;
                                        $jht_pk = $tot_gaji_a * 3.70 / 100;

                                        $jp_k  = $tot_gaji_a * 1 / 100;
                                        $jp_pk  = $tot_gaji_a * 2 / 100;

                                        $jkk_pk = $tot_gaji_a * 0.24 / 100;
                                        $jkm_pk = $tot_gaji_a * 0.30 / 100;



                                        $gaji_bpjs = $tot_gaji_a;
                                    }







                                    $total_gaji_setahun = ($total_gaji + $t_beras + $bpjs_pk + $jkk_pk + $jkm_pk) * 12;


                                    $jabatan2 = $total_gaji_setahun * 0.05;

                                    if ($jabatan2 > 6000000) {
                                        $jabatan = 6000000;
                                    } else {
                                        $jabatan = $jabatan2;
                                    }


                                    // $pajak_setahun = $gaji_setahun - $tot_ptkp;

                                    $tot_jht_jp_setahun = ($jht_k + $jp_k) * 12;


                                    $gaji_pajak_setahun = $total_gaji_setahun - $jabatan - $tot_ptkp - $tot_jht_jp_setahun;





                                    if ($gaji_pajak_setahun <= 60000000) {
                                        $pajak_setahun =  0.05 * $gaji_pajak_setahun;
                                    } else {

                                        if ($gaji_pajak_setahun > 60000000 && $gaji_pajak_setahun <= 250000000) {
                                            $pajak_setahun = 0.05 * 60000000 + 0.15 * ($gaji_pajak_setahun - 60000000);
                                            //$pajak_setahun = 15;
                                        } else {
                                            if ($gaji_pajak_setahun > 250000000 && $gaji_pajak_setahun <= 500000000) {
                                                $pajak_setahun = 0.05 * 60000000 + 0.15 * 190000000;
                                            } else {
                                                $pajak_setahun = 0.25 * ($gaji_pajak_setahun - 250000000);
                                            }

                                            if ($gaji_pajak_setahun > 500000000 && $gaji_pajak_setahun <= 5000000000) {
                                                $pajak_setahun =  0.05 * 60000000 + 0.15 * 190000000 + 0.25 * 250000000 + 0.3 * ($gaji_pajak_setahun - 500000000);
                                            } else {
                                                $pajak_setahun = 0.05 * 60000000 + 0.15 * 190000000 + 0.25 * 250000000 + 0.3 * 45000000000 + ($gaji_pajak_setahun - 5000000000) * 0.35;
                                            }
                                        }
                                    }

                                    if ($data_bpjs->kar_dtl_no_npw) {
                                        $pajak_perbulan = round($pajak_setahun / 12);
                                    } else {
                                        $pajak_perbulan = round(($pajak_setahun / 12) * 120 / 100);
                                    }
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
                                        <td><?php echo  number_format($total_gaji_setahun) . "($total_gaji+$bpjs_pk+$jkk_pk+$jkm_pk)*12" ?></td>
                                        <td><?php echo  number_format($jabatan) ?></td>
                                        <td><?php echo  number_format($tot_ptkp) ?></td>
                                        <td><?php echo  number_format($tot_jht_jp_setahun) ?></td>
                                        <td><?php echo  number_format($gaji_pajak_setahun) ?></td>
                                        <td><?php echo  number_format($pajak_setahun) ?></td>
                                        <td><?php echo  number_format($pajak_perbulan) ?></td>





                                    </tr>

                                <?php
                                }
                                ?>

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="4">Total </td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>