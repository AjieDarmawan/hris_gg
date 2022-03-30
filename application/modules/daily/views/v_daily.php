<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Daily Activity </h3>
                        <div class="card-toolbar">

                        </div>
                    </div>
                    <!--begin::Form-->
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home">
                                    <span class="nav-icon">
                                        <i class="flaticon2-chat-1"></i>
                                    </span>
                                    <span class="nav-text">Aktifitas Rutin</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                                    aria-controls="profile">
                                    <span class="nav-icon">
                                        <i class="flaticon2-layers-1"></i>
                                    </span>
                                    <span class="nav-text">Aktifitas Lainnya</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <!--  satu -->
                                <form action="<?php echo base_url('daily/daily_simpan')?>" method="post">
                                    <input type="hidden" name="status" value="1">

                                    <div class="form-group row">

                                        <div class="col-4 form-group">
                                            <label for="example-week-input" class="col-form-label">Tanggal </label>
                                            <input type="text" class="form-control" readonly name="tanggal_1"
                                                value="<?php echo date('d-m-Y')?>" id="kt_datepicker_3" />
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="example-week-input"
                                                    class="col-4 col-form-label">Start</label>
                                                <input class="form-control" name="start_1" data-default-time="09:00:00"
                                                    id="kt_timepicker_1_validate" placeholder="Select time"
                                                    type="text" />
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="example-week-input" class="col-4 col-form-label">End</label>
                                                <input class="form-control" name="end_1" data-default-time="17:00:00"
                                                    id="kt_timepicker_1_validate" placeholder="Select time"
                                                    type="text" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Aktifitas <span class="text-danger">*</span></label>


                                        <select onchange="aksi()" class="form-control aksi" id="kt_select2_4" required
                                            name="aktifitas_1">
                                            <option value="">--Pilih--</option>
                                            <?php 
                                                foreach($wfh_master as $w){
                                                    ?>

                                            <option value="<?php echo $w->wfh_id?>"><?php echo $w->wfh_aktifitas?>
                                            </option>
                                            <?php      
                                                }
                                            ?>
                                        </select>

                                    </div>


                                    <div class="form-group row">
                                        <div class="col-4 form-group">
                                            <label for="example-week-input" class="col-form-label">Aksi </label>
                                            <select name="aksi_1" class="form-control" id="car_models">
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="example-week-input" class=" col-form-label">Satuan</label>
                                                <select class="form-control" name="satuan_1" id="satuan">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="example-week-input" class="col-form-label">Value</label>
                                                <input type="number" name="value_1" class="form-control" id=""
                                                    type="text" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Lokasi <span class="text-danger">*</span></label>
                                        <select required name="lokasi_1" class="form-control">
                                            <option value="">--Pilih--</option>
                                            <option value="Rumah">Rumah</option>
                                            <option value="Kantor">Kantor</option>
                                            <option value="Kampus">Kampus</option>
                                        </select>

                                    </div>


                                    <div class="form-group">
                                        <label>Keterangan <span class="text-danger">*</span></label>
                                        <textarea name="keterangan_1" class="form-control"></textarea>

                                    </div>


                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-2"></div>
                                            <div class="col-8">
                                                <button type="submit" class="btn btn-success mr-2">Create
                                                    Report</button>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- end satu -->
                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <form action="<?php echo base_url('daily/daily_simpan')?>" method="post">
                                    <input type="hidden" name="status" value="2">
                                    <!-- dua -->
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="example-week-input" class=" col-form-label">Target
                                                    Start</label>
                                                <input class="form-control" name="target_start_2"
                                                    data-default-time="09:00:00" id="kt_timepicker_1_validate"
                                                    placeholder="Select time" type="text" />
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="example-week-input" class=" col-form-label">Target
                                                    End</label>
                                                <input class="form-control" name="target_end_2"
                                                    data-default-time="17:00:00" id="kt_timepicker_1_validate"
                                                    placeholder="Select time" type="text" />
                                            </div>
                                        </div>

                                        <div class="col-4 form-group">
                                            <label for="example-week-input" class="col-form-label">Target Value </label>
                                            <input type="number" value="0" class="form-control" name="target_value_2" />
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <div class="col-4 form-group">
                                            <label for="example-week-input" class="col-form-label">Tanggal </label>
                                            <input type="text" class="form-control" name="tanggal_2" readonly
                                                value="<?php echo date('d-m-Y')?>" id="kt_datepicker_3" />
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="example-week-input"
                                                    class="col-4 col-form-label">Start</label>
                                                <input class="form-control" name="start_2" data-default-time="09:00:00"
                                                    id="kt_timepicker_1_validate" placeholder="Select time"
                                                    type="text" />
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="example-week-input" class="col-4 col-form-label">End</label>
                                                <input class="form-control" name="end_2" data-default-time="17:00:00"
                                                    id="kt_timepicker_1_validate" placeholder="Select time"
                                                    type="text" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Aktifitas <span class="text-danger">*</span></label>
                                        <input type="text" name="aktifitas_2" class="form-control" name="">
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-4 form-group">
                                            <label for="example-week-input" class="col-form-label">Aksi </label>
                                            <select class="form-control" name="aksi_2">
                                                <option value="Followup">Followup</option>
                                                <option value="Pickup">Pickup</option>
                                                <option value="Layanan">Layanan</option>
                                                <option value="Maintenance">Maintenance</option>
                                                <option value="Develop">Develop</option>
                                                <option value="Posting">Posting</option>
                                                <option value="Like">Like</option>
                                                <option value="Share">Share</option>
                                                <option value="Retweet">Retweet</option>
                                                <option value="Subscribe">Subscribe</option>
                                                <option value="Klik">Klik</option>
                                                <option value="Proses">Proses</option>
                                                <option value="Comment">Comment</option>
                                                <option value="Training">Training</option>
                                                <option value="Marketing">Marketing</option>
                                                <option value="Diskusi">Diskusi</option>
                                                <option value="Briefing">Briefing</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="example-week-input" class=" col-form-label">Satuan</label>
                                                <select name="satuan_2" class="form-control">
                                                    <option value="Qty">Qty</option>
                                                    <option value="Persentase">Persentase</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="example-week-input" class="col-form-label">Value</label>
                                                <input type="number" name="value_2" value="0" class="form-control" id=""
                                                    type="text" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Lokasi <span class="text-danger">*</span></label>
                                        <select required name="lokasi_2" class="form-control">
                                            <option value="">--Pilih--</option>
                                            <option value="Rumah">Rumah</option>
                                            <option value="Kantor">Kantor</option>
                                            <option value="Kampus">Kampus</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>Keterangan <span class="text-danger">*</span></label>
                                        <textarea name="keterangan_2" class="form-control"></textarea>
                                    </div>


                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-2"></div>
                                            <div class="col-8">
                                                <button type="submit" class="btn btn-success mr-2">Create
                                                    Report</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- end dua -->
                                </form>
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
                        <h3 class="card-title">Daily Report</h3>
                        <div class="card-toolbar">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-8">
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Nomor</td>
                                    <td>Nama</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>



                            <tbody>
                                <?php 
                                    foreach($get_harian_groupby as $g){
                                  ?>
                                <tr>
                                    <td><?php echo $g->wfd_nomor;?></td>
                                    <td><?php echo $g->wfd_nama;?></td>
                                    <td>
                                        <a href="<?php echo base_url('daily/detail_lihat/'.$g->wfd_nomor)?>"
                                            target="_blank" title="Detail Report"><span style="cursor:pointer"
                                            class="btn btn-primary btn-sm">(<?php echo count($get_harian) ?>)</span></a>
                                        <a href="<?php echo base_url('daily/hapus_daily/'.$g->wfd_nomor)?>"
                                            class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"
                                            data-confirm="Are you sure to delete this item?"><span
                                                style="cursor:pointer" class="label label-danger"><i
                                                    class="fa fa-trash"></i></span></a>


                                        <?php 
                                            if($g->wfd_lock=='Y'){
                                         ?>      
                                             <a href="<?php echo base_url('daily/update_lock/1/'.$g->wfd_nomor)?>"
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('Yakin Nomor Report <?php echo $g->wfd_nomor;?> akan di UnPublish? ?')"
                                            data-confirm="Yakin Nomor Report <?php echo $g->wfd_nomor;?> akan di UnPublish?">
                                            <i class="text-dark-50 ki ki-bold-check-1"></i>
                                                
                                                </a>
                                         <?php
                                            }else{
                                            ?>    

                                             <a href="<?php echo base_url('daily/update_lock/2/'.$g->wfd_nomor)?>" 
                                            class="btn btn-default btn-sm"
                                            onclick="return confirm('Yakin Nomor Report <?php echo $g->wfd_nomor;?> akan di Publish? ?')"
                                            data-confirm="Yakin Nomor Report <?php echo $g->wfd_nomor;?> akan di Publish?">
                                            <i class="text-dark-50 ki ki-bold-check-1"></i>
                                                
                                                </a>



                                        <?php        
                                            }
                                        ?>

                                       
                                       


                                    </td>
                                </tr>


                                <?php 
                                    }
                                ?>

                            </tbody>
                            <tfoot>
                            
                            </tfoot>

                           

                        </table>

                        <div class="">
                                  
                                  <div class="alert alert-primary" >
                                  <h4><i class="icon fa fa-primary"></i> Keterangan :</h4>
                                  1. <strong>"Aktifitas Rutin"</strong> (data aktifitas yang sudah tersistem dan sudah memiliki target perdivisi).<br>
                                  2. <strong>"Aktifitas Lainnya"</strong> (data aktifitas yang belum ada di sistem dan targetnya di tentukan sendiri). <br>
                                  3. <strong>Tombol Detail</strong> (untuk melihat seluruh aktifitas yang akan dilaporkan perharinya), berserta info jumlah aktifitas.<br>
                                  4. <strong>Tombol Hapus</strong> (untuk menghapus report), <strong>*ketika report di publish tidak bisa dihapus</strong>.<br>
                                  5. <strong>Tombol Publish</strong> (untuk menpublish report) <strong>*jika belum dipublish report hanya bisa dilihat oleh karyawan itu sendiri</strong>. Pastikan cheklist sudah berwarna hijau <span class="label label-success"><i class="fa fa-check"></i></span> (Publish)<br>
                                  </div>
                          </div>   





                    </div>
                </div>
                <!--end::Card-->
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

<script>
function aksi() {
    var wfh_id = $(".aksi option:selected").val();

    //alert(wfh_id);

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url('daily/ajax_aktifitas')?>',
        data: {
            wfh_id: wfh_id
        },
        dataType: "html",
        success: function(data) {
            console.log(data);
            $('#car_models').html(data);

        },

    });

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url('daily/ajax_aktifitas_satuan')?>',
        data: {
            wfh_id: wfh_id
        },
        dataType: "html",
        success: function(data) {
            console.log(data);
            $('#satuan').html(data);

        },

    });








}
</script>