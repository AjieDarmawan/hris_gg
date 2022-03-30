<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Identitas Karyawan</h3>
                        <div class="card-toolbar">

                        </div>
                    </div>
                    <!--begin::Form-->
                    <form id="form2" action="<?php echo base_url('master/karyawan/simpan')?>" method="post">
                        <div class="card-body">

                    

                            <div class="form-group row">
                                <label class="col-4 col-form-label">Nik Kantor <span class="text-danger">*</span> </label>

                               
                                <div class="col-8">
                                    <input class="form-control" required name="nik_kantor" type="text"
                                        id="nik_kantor" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-4 col-form-label">Nik KTP<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <input class="form-control" required name="nik_ktp" type="number" id="nik_ktp" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-4 col-form-label">Nama Karyawan<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <input class="form-control" type="text" required name="nama_karyawan"
                                        id="nama_karyawan" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-4 col-form-label">Email<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <input class="form-control" type="email" required name="email" id="email" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-url-input" class="col-4 col-form-label">No Wa<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <input type="text" class="form-control" required name="no_wa" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-tel-input" class="col-4 col-form-label">No HP<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <input class="form-control" type="number" required name="no_hp" id="no_hp" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-tel-input" class="col-4 col-form-label">Alamat<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <textarea class="form-control alamat" type="text" required name="alamat"
                                        id="memo"> </textarea>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="example-password-input" class="col-4 col-form-label">Tempat Lahir<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <input class="form-control" type="text" required name="tempat_lahir"
                                        id="tempat_lahir" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-number-input" class="col-4 col-form-label">Tanggal Lahir<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <input class="form-control" type="date" required name="tanggal_lahir"
                                        id="tanggal_lahir" />
                                </div>
                            </div>




                            <div class="form-group row">
                                <label for="example-number-input" class="col-4 col-form-label">Sts Nikah<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <!-- <select class="form-control" required name="status_perkawinan" id="status_perkawinan">
                                        <option value="">--Pilih--</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                    </select> -->
                                    <div class="radio-inline">
                                        <label class="radio radio-outline radio-success">
                                            <input type="radio" value="Belum Menikah" required
                                                name="status_perkawinan" />
                                            <span></span>Belum Menikah </label>
                                        <label class="radio radio-outline radio-success">
                                            <input type="radio" value="Menikah" required name="status_perkawinan" />
                                            <span></span>Menikah </label>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-datetime-local-input" class="col-4 col-form-label">Jenis
                                    Kelamin<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <!-- <select class="form-control" required name="jenis_kelamin" id="jenis_kelamin">
                                        <option value="">--Pilih--</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select> -->

                                    <div class="radio-inline">
                                        <label class="radio radio-outline radio-success">
                                            <input type="radio" value="L" required name="jenis_kelamin" />
                                            <span></span>Laki-Laki</label>
                                        <label class="radio radio-outline radio-success">
                                            <input type="radio" value="P" required name="jenis_kelamin" />
                                            <span></span>Perempuan</label>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-month-input" class="col-4 col-form-label">Agama<span class="text-danger">*</span> </label>
                                <div class="col-8">
                                    <select class="form-control" required name="agama" id="agama">
                                        <option value="">--Pilih--</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                        <option value="Kristen Katolik">Kristen Katolik</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Hindu">Hindu</option>
                                    </select>
                                </div>
                            </div>




                        </div>

                </div>
                <!--end::Card-->


                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Education</h3>
                        <div class="card-toolbar">

                        </div>
                    </div>
                    <!--begin::Form-->

                    <div class="card-body">


                        <div class="form-group row">
                            <label for="example-week-input" class="col-4 col-form-label">Pendidikan<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <select class="form-control" required name="pendidikan" id="pendidikan">
                                    <option value="">--Pilih--</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="SMK">SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-time-input" class="col-4 col-form-label">Sekolah Terakhir<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <input class="form-control" type="text" required name="sekolah_terakhir"
                                    id="sekolah_terakhir" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-time-input" class="col-4 col-form-label">Tahun Masuk<span class="text-danger">*</span> </label>
                            <div class="col-8">
                              

                                <select class="form-control" required name="tahun_masuk">
                                    <option>--Pilih--</option>
                                        <?php 

                                            $tahun = date('Y');
                                            for ($i = 2000; $i <= $tahun; $i++) {
                                             ?>
                                             <option value="<?php echo $i;?>" ><?php echo $i;?> </option>
                                        <?php 
                                            }
                                        ?>

                                </select>



                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-time-input" class="col-4 col-form-label">Tahun Keluar<span class="text-danger">*</span> </label>
                            <div class="col-8">
                               
                                <select class="form-control" required name="tahun_keluar">
                                    <option>--Pilih--</option>
                                        <?php 

                                            $tahun = date('Y');
                                            for ($i = 2000; $i <= $tahun; $i++) {
                                             ?>
                                             <option value="<?php echo $i;?>" ><?php echo $i;?> </option>
                                        <?php 
                                            }
                                        ?>

                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-time-input" class="col-4 col-form-label">Jurusan<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <input class="form-control" type="text" required name="jurusan" id="jurusan" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-time-input" class="col-4 col-form-label">Nilai<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <input class="form-control" type="text" required name="nilai" id="nilai" />
                            </div>
                        </div>


                    </div>

                </div>
                <!--end::Card-->

            </div>


            <div class="col-md-6">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">

                    <!--begin::Form-->

                    <div class="card-header">
                        <h3 class="card-title">Status Karyawan</h3>
                        <div class="card-toolbar">

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-8">

                        </div>






                        <div class="form-group row">
                            <label class="col-4 col-form-label">Kantor<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <select class="form-control" id="kt_select2_3" required name="ktr_id">
                                    <option value="">--Pilih--</option>
                                    <?php 
                                               foreach($kantor as $d){
                                                           ?>
                                    <option value=<?php echo $d->ktr_id?>><?php echo $d->kantor_nama?></option>
                                    <?php  
                                                 }
                                               ?>
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="example-search-input" class="col-4 col-form-label">Divisi<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <select class="form-control" id="kt_select2_2" required name="div_id">
                                    <option value="">--Pilih--</option>
                                    <?php 
                                               foreach($divisi as $d){
                                                           ?>
                                    <option value=<?php echo $d->div_id?>><?php echo $d->divisi_nama?></option>
                                    <?php  
                                                 }
                                               ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-email-input" class="col-4 col-form-label">Jabatan<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <select class="form-control" id="kt_select2_1" required name="jbt_id">
                                    <option value="">--Pilih--</option>
                                    <?php 
                                                
                                               foreach($jabatan as $j){
                                                           ?>
                                    <option value=<?php echo $j->jbt_id?>><?php echo $j->jabatan_nama?></option>
                                    <?php  
                                                 }
                                               ?>
                                </select>
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="example-email-input" class="col-4 col-form-label">Level<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <select class="form-control" id="kt_select2_4" required name="lvl_id">
                                    <option value="">--Pilih--</option>
                                    <?php 
                                                
                                               foreach($level as $j){
                                                           ?>
                                    <option value=<?php echo $j->lvl_id?>><?php echo $j->lvl_nm?></option>
                                    <?php  
                                                 }
                                               ?>
                                </select>
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="example-number-input" class="col-4 col-form-label">Tanggal Join<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <input class="form-control" type="date" required name="tanggal_join"
                                    id="tanggal_join" />
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-password-input" class="col-4 col-form-label">No KK </label>
                            <div class="col-8">
                                <input class="form-control" type="number" value="hunter2" required name="no_kk"
                                    id="no_kk" />
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-password-input" class="col-4 col-form-label">No NPWP </label>
                            <div class="col-8">
                                <input class="form-control" type="number" value="hunter2" required name="no_npwp"
                                    id="no_npwp" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-password-input" class="col-4 col-form-label">No Kpj </label>
                            <div class="col-8">
                                <input class="form-control" type="number" value="hunter2" required name="no_kpj"
                                    id="no_kpj" />
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="example-password-input" class="col-4 col-form-label">No BPJS </label>
                            <div class="col-8">
                                <input class="form-control" type="number" value="hunter2" required name="no_bpjs"
                                    id="no_bpjs" />
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="example-password-input" class="col-4 col-form-label">BANK  </label>
                            <div class="col-8">
                                <input class="form-control" type="number" value="hunter2" required name="bank"
                                    id="bank" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-password-input" class="col-4 col-form-label">No Rekening  </label>
                            <div class="col-8">
                                <input class="form-control" type="number" value="hunter2" required name="no_rekening"
                                    id="no_rekening" />
                            </div>
                        </div>


                    </div>

                </div>
                <!--end::Card-->





                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">

                    <!--begin::Form-->

                    <div class="card-header">
                        <h3 class="card-title">Keluarga Yang dapat dihubungi</h3>
                        <div class="card-toolbar">

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-8">

                        </div>




                        <div class="form-group row">
                            <label for="example-url-input" class="col-4 col-form-label">Nama Keluarga<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <input class="form-control" type="text" required name="nama_keluarga"
                                    id="nama_keluarga" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-tel-input" class="col-4 col-form-label">Hubungan Keluarga<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <input class="form-control" type="text" required name="hubungan_keluarga"
                                    id="hubungan_keluarga" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-password-input" class="col-4 col-form-label">No Hp Keluarga<span class="text-danger">*</span> </label>
                            <div class="col-8">
                                <input class="form-control" type="number" value="hunter2" required name="no_hp_keluarga"
                                    id="no_hp_keluarga" />
                            </div>
                        </div>




                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <!--end::Card-->

            </div>



        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->



<script>
$(function() {
    $("#form2").validate({
        rules: {
            email: {
                required: true
            },

            no_wa: {
                required: true
            },


        },
        messages: {
            email: {
                required: '<b><p style="color:red">X Harus diisi</p></b>',
            },

            no_wa: {
                required: '<b><p style="color:red">X Harus diisi</p></b>',
            },


        }
    });
});
</script>