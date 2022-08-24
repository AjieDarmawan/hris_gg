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

             
            <a class="btn btn-primary btn-sm" href="<?php echo base_url('gaji/pajak/croscek') ?>">Data Crosceek</a>
          


            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tablekaryawan">
                            <thead>
                                <tr class="table-success">
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
                                    <th>Pajak Setahun THR</th>
                                    <th>Selisih Thr - P</th>
                                    <th>Pajak Perbulan</th>
                                    <th>PPh Di bayar</th>
                                    
                                   
                                   

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
            "url": '<?php echo base_url('gaji/pajak/ajax_list') ?>',
            "type": "POST"
        }
    });
</script>

