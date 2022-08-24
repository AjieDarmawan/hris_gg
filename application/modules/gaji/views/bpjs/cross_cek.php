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
                                ?>
                                    <tr>
                                        <td><?php echo $no++ ?> </td>
                                        <td><?php echo $data_bpjs->kar_nik ?> </td>
                                        <td><?php echo $data_bpjs->kar_nm ?> </td>
                                        <td><?php echo number_format($tot_gaji->tot) ?> </td>
                                        <td><?php echo $data_bpjs->kar_dtl_sts_nkh ?> </td>
                                        <td><?php echo $data_bpjs->kar_dtl_jml_ank ?> </td>
                                        <td><?php echo number_format($bpjs_k) ?> </td>
                                        <td><?php echo number_format($jht_k) ?> </td>
                                        <td><?php echo number_format($jp_k) ?> </td>

                                        <td><?php echo number_format($bpjs_pk) ?> </td>
                                        <td><?php echo number_format($jkk_pk) ?> </td>
                                        <td><?php echo number_format($jht_pk) ?> </td>
                                        <td><?php echo number_format($jkm_pk) ?> </td>
                                        <td><?php echo number_format($jp_pk) ?> </td>



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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>