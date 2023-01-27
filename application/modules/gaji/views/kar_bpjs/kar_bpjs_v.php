<style>
.div1 {
    width: 1200px;
    height: 500px;
    overflow: scroll;
    border: 1px solid #777777;
}

.div1 table {
    border-spacing: 0;
}

.div1 th {
    border-left: none;
    border-right: 1px solid #bbbbbb;
    padding: 5px;
    width: 80px;
    min-width: 80px;
    position: sticky;
    top: 0;
    background: #727272;
    color: #e0e0e0;
    font-weight: normal;
}

.div1 td {
    border-left: none;
    border-right: 1px solid #bbbbbb;
    border-bottom: 1px solid #bbbbbb;
    padding: 5px;
    width: 80px;
    min-width: 80px;
}

.div1 th:nth-child(1),
.div1 td:nth-child(1) {
    position: sticky;
    left: 0;
    width: 250px;
    min-width: 250px;
}

.div1 th:nth-child(1),
.div1 th:nth-child(2),
.div1 td:nth-child(2) {
    position: sticky;
    /* 1st cell left/right padding + 1st cell width + 1st cell left/right border width */
    /* 0 + 5 + 150 + 5 + 1 */
    left: 0px;
    width: 50px;
    min-width: 50px;
}

.div1 td:nth-child(1),
.div1 td:nth-child(2),
.div1 td:nth-child(3) {
    background: #ffebb5;
}

.div1 th:nth-child(1),
.div1 th:nth-child(2),
.div1 th:nth-child(3) {
    z-index: 3;
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



            <!--   <a href="<?php echo base_url('gaji/pajak/download_excel') ?>" class=" btn btn-primary btn-sm">Download Excel</a> -->


            <div mb-2>
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                <?php $this->load->view('layouts/alert'); ?>
            </div>


            <!-- <form action="<?php echo base_url('gaji/Kar_Bpjs/kar_insert')?>" method="post"> -->

            <div class="card">



                <div class="card-body">
                <div class="div1">
    <table>
                            <thead>
                                <tr class="">
                                    <!-- <th>No </th> -->
                                    <th>Nik </th>
                                    <th>Nama</th>

                                    <th>BPJS (TK)</th>
                                    <th>BPJS (PK)</th>
                                    <th>JHT (TK)</th>
                                    <th>JHT (PK)</th>
                                    <th>JP (TK)</th>
                                    <th>JP (PK)</th>
                                    <th>JKK (PK)</th>
                                    <th>JKM (PK)</th>
                                    <th>Sembako</th>
                                    <th>Iuran Paguyuban</th>



                                </tr>
                            </thead>

                            <tbody>



                                <?php 

                            	error_reporting(0);

                            	// echo "<pre>";
                            	// print_r($data_kar);
                            		$no = 1;
                            		foreach($data_kar as $k){


                            			$kar_bpjs = $this->db->query('select * from payroll.kar_bpjs where kar_id="'.$k->kar_id.'"')->row();

                            			

                            			if($kar_bpjs){

                            				if($kar_bpjs->bpjs_k==1){
                            					$checked_bpjs_k = "checked"; 
                            					
                            				}else{
                            					$checked_bpjs_k = "";
                            					$checked_bpjs_k_value = 0; 
                            				}

                            				if($kar_bpjs->bpjs_pk==1){
                            					$checked_bpjs_pk = "checked"; 
                            				
                            				}else{
                            					$checked_bpjs_pk = "";
                            					$checked_bpjs_pk_value = 0;
                            				}


                            				if($kar_bpjs->jht_k==1){
                            					$checked_jht_k = "checked"; 
                            					
                            				}else{
                            					$checked_jht_k = "";
                            					$checked_jht_k_value = 0;
                            				}

                            				if($kar_bpjs->jht_pk==1){
                            					$checked_jht_pk = "checked"; 
                            					
                            				}else{
                            					$checked_jht_pk = "";
                            					
                            				}


                            				if($kar_bpjs->jkk_pk==1){
                            					$checked_jkk_pk = "checked"; 
                            					
                            				}else{
                            					$checked_jkk_pk = "";
                            					
                            				}



                            				if($kar_bpjs->jkm_pk==1){
                            					$checked_jkm_pk = "checked"; 
                            					
                            				}else{
                            					$checked_jkm_pk = "";
                            					
                            				}


                            				if($kar_bpjs->jp_k==1){
                            					$checked_jp_k = "checked"; 
                            					
                            				}else{
                            					$checked_jp_k = "";
                            					
                            				}

                            				if($kar_bpjs->jp_pk==1){
                            					$checked_jp_pk = "checked"; 
                            					
                            				}else{
                            					$checked_jp_pk = "";
                            					
                            				}






                            				if($kar_bpjs->status==1){
                            					$checked_status = "checked"; 
                            					
                            				}else{
                            					$checked_status = "";
                            					
                            				}

											if($kar_bpjs->sembako==1){
                            					$checked_sembako = "checked"; 
                            					
                            				}else{
                            					$checked_sembako = "";
                            					
                            				}


											if($kar_bpjs->iuran_paguyuban==1){
                            					$checked_iuran_paguyuban = "checked"; 
                            					
                            				}else{
                            					$checked_iuran_paguyuban = "";
                            					
                            				}




                            			}else{

                            				$checked_bpjs_k = "";
                            				

                            				$checked_bpjs_pk = "";
                            				

                            				$checked_jht_pk = "";
                            				

                            				$checked_jht_k = "";
                            				

                            				$checked_jp_pk = "";
                            				

                            				$checked_jp_k = "";
                            			    

                            			    $checked_jkm_pk = "";

                            			    $checked_jkk_pk = "";
                            				

                            				
                            				

                            			    $checked_status = "";

											$checked_sembako = "";
											$checked_iuran_paguyuban = "";
                            				




                            			}


                                ?>



                                <tr>
                                    <!-- <td><?php echo $no++;?></td> -->
                                    <td><?php echo $k->kar_nik?></td>
                                    <td><?php echo $k->kar_nm?> </td>


                                    <input type="hidden" value="<?php echo $k->kar_id;?>"
                                        name="kar[<?php echo $k->kar_id;?>]">






                                    <td>
                                        <form action="<?php echo base_url('gaji/Kar_Bpjs/update')?>" method="post">
                                            <input type="hidden" name="kar_id_bpjs_tk" value="<?php echo $k->kar_id;?>">
                                            <select onchange="submit()" name="bpjs_tk">

                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    <?php if($kar_bpjs->bpjs_k==1){echo 'selected';}else{echo '';}?>>
                                                    Aktif
                                                </option>
                                                <option value="0"
                                                    <?php if($kar_bpjs->bpjs_k==0){echo 'selected';}else{echo '';}?>>
                                                    Tidak
                                                    Aktif</option>

                                            </select>
                                        </form>
                                    </td>


                                    <td>
                                        <form action="<?php echo base_url('gaji/Kar_Bpjs/update')?>" method="post">
                                            <input type="hidden" name="kar_id_bpjs_pk" value="<?php echo $k->kar_id;?>">
                                            <select onchange="submit()" name="bpjs_pk">

                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    <?php if($kar_bpjs->bpjs_pk==1){echo 'selected';}else{echo '';}?>>
                                                    Aktif
                                                </option>
                                                <option value="0"
                                                    <?php if($kar_bpjs->bpjs_pk==0){echo 'selected';}else{echo '';}?>>
                                                    Tidak
                                                    Aktif</option>

                                            </select>
                                        </form>
                                    </td>






                                    <td>
                                        <form action="<?php echo base_url('gaji/Kar_Bpjs/update')?>" method="post">
                                            <input type="hidden" name="kar_id_jht_tk" value="<?php echo $k->kar_id;?>">
                                            <select onchange="submit()" name="jht_tk">

                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    <?php if($kar_bpjs->jht_k==1){echo 'selected';}else{echo '';}?>>
                                                    Aktif
                                                </option>
                                                <option value="0"
                                                    <?php if($kar_bpjs->jht_k==0){echo 'selected';}else{echo '';}?>>
                                                    Tidak
                                                    Aktif</option>

                                            </select>
                                        </form>
                                    </td>


                                    <td>
                                        <form action="<?php echo base_url('gaji/Kar_Bpjs/update')?>" method="post">
                                            <input type="hidden" name="kar_id_jht_pk" value="<?php echo $k->kar_id;?>">
                                            <select onchange="submit()" name="jht_pk">

                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    <?php if($kar_bpjs->jht_pk==1){echo 'selected';}else{echo '';}?>>
                                                    Aktif
                                                </option>
                                                <option value="0"
                                                    <?php if($kar_bpjs->jht_pk==0){echo 'selected';}else{echo '';}?>>
                                                    Tidak
                                                    Aktif</option>

                                            </select>
                                        </form>
                                    </td>








                                    <td>
                                        <form action="<?php echo base_url('gaji/Kar_Bpjs/update')?>" method="post">
                                            <input type="hidden" name="kar_id_jp_tk" value="<?php echo $k->kar_id;?>">
                                            <select onchange="submit()" name="jp_tk">

                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    <?php if($kar_bpjs->jp_k==1){echo 'selected';}else{echo '';}?>>
                                                    Aktif
                                                </option>
                                                <option value="0"
                                                    <?php if($kar_bpjs->jp_k==0){echo 'selected';}else{echo '';}?>>
                                                    Tidak
                                                    Aktif</option>

                                            </select>
                                        </form>
                                    </td>




                                    <td>
                                        <form action="<?php echo base_url('gaji/Kar_Bpjs/update')?>" method="post">
                                            <input type="hidden" name="kar_id_jp_pk" value="<?php echo $k->kar_id;?>">
                                            <select onchange="submit()" name="jp_pk">

                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    <?php if($kar_bpjs->jp_pk==1){echo 'selected';}else{echo '';}?>>
                                                    Aktif
                                                </option>
                                                <option value="0"
                                                    <?php if($kar_bpjs->jp_pk==0){echo 'selected';}else{echo '';}?>>
                                                    Tidak
                                                    Aktif</option>

                                            </select>
                                        </form>
                                    </td>





                                    <td>
                                        <form action="<?php echo base_url('gaji/Kar_Bpjs/update')?>" method="post">
                                            <input type="hidden" name="kar_id_jkk_pk" value="<?php echo $k->kar_id;?>">
                                            <select onchange="submit()" name="jkk_pk">

                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    <?php if($kar_bpjs->jkk_pk==1){echo 'selected';}else{echo '';}?>>
                                                    Aktif
                                                </option>
                                                <option value="0"
                                                    <?php if($kar_bpjs->jkk_pk==0){echo 'selected';}else{echo '';}?>>
                                                    Tidak
                                                    Aktif</option>

                                            </select>
                                        </form>
                                    </td>





                                    <td>

                                        <form action="<?php echo base_url('gaji/Kar_Bpjs/update')?>" method="post">
                                            <input type="hidden" name="kar_id_jkm_pk" value="<?php echo $k->kar_id;?>">
                                            <select onchange="submit()" name="jkm_pk">

                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    <?php if($kar_bpjs->jkm_pk==1){echo 'selected';}else{echo '';}?>>
                                                    Aktif</option>
                                                <option value="0"
                                                    <?php if($kar_bpjs->jkm_pk==0){echo 'selected';}else{echo '';}?>>
                                                    Tidak Aktif</option>

                                            </select>
                                        </form>
                                    </td>

                                    <td>

                                        <form action="<?php echo base_url('gaji/Kar_Bpjs/update')?>" method="post">
                                            <input type="hidden" name="kar_id_sembako" value="<?php echo $k->kar_id;?>">

                                            <select onchange="submit()" name="sembako">



                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    <?php if($kar_bpjs->sembako==1){echo 'selected';}else{echo '';}?>>
                                                    Beras</option>
                                                <option value="2"
                                                    <?php if($kar_bpjs->sembako==2){echo 'selected';}else{echo '';}?>>
                                                    Uang</option>
                                                <option value="0"
                                                    <?php if($kar_bpjs->sembako==0){echo 'selected';}else{echo '';}?>>
                                                    Tidak Ada</option>

                                            </select>

                                        </form>

                                    </td>
                                    <td>

                                        <form action="<?php echo base_url('gaji/Kar_Bpjs/update')?>" method="post">
                                            <input type="hidden" name="kar_id_iuran" value="<?php echo $k->kar_id;?>">

                                            <select onchange="submit()" name="iuran_paguyuban">



                                                <option value="1"
                                                    <?php if($kar_bpjs->iuran_paguyuban==1){echo 'selected';}else{echo '';}?>>
                                                    IKUT</option>
                                                <option value="0"
                                                    <?php if($kar_bpjs->iuran_paguyuban==0){echo 'selected';}else{echo '';}?>>
                                                    Tidak Ikut</option>


                                            </select>

                                        </form>

                                    </td>




                                </tr>


                                <?php			
                            		}
                            	?>

                            </tbody>





                        </table>
                    </div>
                </div>
            </div>

            <br>

            <!--  <button type="submit" class="btn btn-primary btn-sm" >Simpan</button> -->

            <!-- </form> -->
        </div>
    </div>
</div>