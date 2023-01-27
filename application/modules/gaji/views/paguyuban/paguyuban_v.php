<div class="container pt-5">
    <h3><?= $title ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a>Paguyuban</a></li>
            <li class="breadcrumb-item active" aria-current="page">List Data</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload_excel">Upload
                Excel</button>

            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                data-target="#upload_excel_pinjam">Upload Excel Pinjam</button>
            <a href="<?php echo base_url('gaji/paguyuban/data_list')?>" class="btn btn-primary btn-sm">Data
                Paguyuban</a>
            <br>
            <div mb-2>
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                <?php $this->load->view('layouts/alert'); ?>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tablekaryawan">
                            <thead>
                                <tr class="table-success">
                                    <th></th>
                                    <th>Nik </th>
                                    <th>Nama</th>
                                    <th>Bulan</th>
                                    <th>Angsuran Ke</th>
                                    <th>Di Bayarkan</th>


                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/template/assets/plugins/global/plugins.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/template/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/template/assets/js/scripts.bundle.js"></script>



<!--begin::Page Vendors(used by this page)-->
<script src="<?php echo base_url(); ?>assets/template/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->


<script>
//setting datatables
$('#tablekaryawan').DataTable({
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
    },
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
        //panggil method ajax list dengan ajax
        "url": '<?php echo base_url('gaji/paguyuban/ajax_list') ?>',
        "type": "POST"
    }
});
</script>


<script type="text/javascript">
// function reload_table()
//         {
//             table.ajax.reload(null,false); //reload datatable ajax 
//         } 


var table;
$(document).ready(function() {




    $(document).on("click", ".hapus_dokumen", function() {
        var id = $(this).attr("id");

        //  alert(id);
        swal({
            title: "Yakin Hapus Data ini  ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
            closeOnConfirm: false
        }, function() {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>gaji/paguyuban/hapus",
                dataType: "JSON",
                data: "id=" + id,
                success: function(data) {
                    // reload_table();

                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }

            });
            swal("Deleted!", "Data berhasil dihapus .", "success");

        });
    });

});
</script>


<!-- Modal -->
<div id="upload_excel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">


            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                    <h4 class="modal-title" id="modalLabel"><i class="fa fa-plus" aria-hidden="true"></i> Form Upload
                        Paguyuban</h4>

                </div>
                <div class="modal-body">
                    <form role="form" action="<?php echo base_url('gaji/paguyuban/upload_excel') ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div>
                                <div class="">
                                    <label>Bulan</label>
                                    <input type="month" name="bulan">
                                </div>

                                <input class="form-control form-control-sm" id="formFileSm" name="file" type="file">
                                Upload Data Listrik
                                <label>Format Excel</label>
                                <a href="<?php echo base_url('assets/berkas/paguyuban.xlsx')?>" class="">Format Excel .
                                    xls</a>
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


<!-- Modal -->
<div id="upload_excel_pinjam" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">


            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                    <h4 class="modal-title" id="modalLabel"><i class="fa fa-plus" aria-hidden="true"></i> Form Upload
                        Pinjam Nama Paguyuban</h4>

                </div>
                <div class="modal-body">
                    <form role="form" action="<?php echo base_url('gaji/paguyuban/insert_paguyuban_pinjam') ?>"
                        method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Nama Yg di Pinjam </label>
                                <select name="kar_id_yg_dipinjam_namanya" required class="form-control">
                                    <option value="">--Pilih--</option>
                                    <?php
                                        foreach ($kar_data as $r) {
                                        ?>

                                    <option value="<?php echo $r->kar_id ?>"><?php echo $r->kar_nm ?></option>

                                    <?php
                                        }
                                        ?>
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Nama Yg Pinjam </label>
                                <select name="kar_id_pinjam" required class="form-control">
                                    <option value="">--Pilih--</option>
                                    <?php
                                        foreach ($kar_data as $r) {
                                        ?>

                                    <option value="<?php echo $r->kar_id ?>"><?php echo $r->kar_nm ?></option>

                                    <?php
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Angsuran Ke ..</label>
                                <input type="number" maxlength="10" class="form-control" required="" id="t_struktural"
                                    name="angsuran">
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Bulan</label>
                                <input type="month" class="form-control" required="" id="t_fungsional"
                                    name="bulan">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Nominal</label>
                                <input type="number" class="form-control" required="" id="t_umum" name="dibayarkan">
                            </div>







                        </div>







                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="bsave" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>


        </div>

    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>