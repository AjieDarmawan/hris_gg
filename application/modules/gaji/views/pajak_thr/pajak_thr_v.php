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
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload_excel">Upload Excel</button>
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
                                 
                                    <th>Nominal</th>
                                 
                                  

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
            "url": '<?php echo base_url('gaji/pajak_thr/ajax_list') ?>',
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
                    url: "<?php echo base_url(); ?>gaji/pajak_thr/hapus",
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
                    <h4 class="modal-title" id="modalLabel"><i class="fa fa-plus" aria-hidden="true"></i> Form Upload Pajak THR</h4>

                </div>
                <div class="modal-body">
                    <form role="form" action="<?php echo base_url('gaji/pajak_thr/upload_excel') ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                               

                                <input class="form-control form-control-sm" id="formFileSm" name="file" type="file">
                                Upload Data Komponen Pajak THR
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




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

    function myFunction(kar_id,gaji_pokok2,t_fungsional2,t_struktural2,t_umum2,t_kinerja2){

      
       // alert(kar_id);

  
            $("#gaji_pokok").val(gaji_pokok2);
            $("#t_fungsional").val(t_fungsional2);
            $("#t_struktural").val(t_struktural2);
            $("#t_umum").val(t_umum2);
            $("#t_kinerja").val(t_kinerja2);
            $("#kar_id2").val(kar_id);
    }
 
      

   
</script>