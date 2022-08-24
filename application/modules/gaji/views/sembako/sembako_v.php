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

            <div mb-2>
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                <?php $this->load->view('layouts/alert'); ?>
            </div>

            <?php
            $menikah = $this->db->query('select count(k.kar_nm) as total , k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
            inner join kar_detail as d on k.kar_id = d.kar_id where kar_dtl_sts_nkh="K" and kar_dtl_typ_krj != "Resign" 
            and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE() and kar_nik not in ("SG.0060.2010","SG.0035.2007","SG.0410.2017","SG.0205.2014","SG.0247.2015","SG.0186.2014","SG.0273.2015")')->row();

            $belum_menikah = $this->db->query('select count(k.kar_nm) as total , k.kar_nm,DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) as waktu,CURDATE() from kar_master as k
            inner join kar_detail as d on k.kar_id = d.kar_id where kar_dtl_sts_nkh="TK" and kar_dtl_typ_krj != "Resign" 
            and DATE_ADD(d.kar_dtl_tgl_joi, INTERVAL "3" MONTH) <=  CURDATE()')->row();
            ?>

            <a class="btn btn-primary btn-sm" href="<?php echo base_url('gaji/sembako/belum_menikah') ?>">List Data Belum Menikah</a>
            <a class="btn btn-success btn-sm" href="<?php echo base_url('gaji/sembako/menikah') ?>">List Data Menikah</a>
            <br>
            Jumlah Belum Menikah : <?php echo $belum_menikah->total; ?> <br>
            Jumlah Sudah Menikah : <?php echo $menikah->total; ?>




            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tablekaryawan">
                            <thead>
                                <tr class="table-success">
                                    <th></th>
                                    <th>Nik </th>
                                    <th>Nama</th>
                                    <th>Tgl Join</th>
                                    <th>Status Pernikahan</th>
                                    <th>Harga</th>

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
            "url": '<?php echo base_url('gaji/sembako/ajax_list') ?>',
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
                    url: "<?php echo base_url(); ?>gaji/sembako/hapus",
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