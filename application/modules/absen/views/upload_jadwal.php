<div class="container pt-5">
    <h3><?= $title ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a>Absen</a></li>
            <li class="breadcrumb-item active" aria-current="page">List Data</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">

            <div class="col-md-4">
                <form action="<?php echo base_url('absen/simpan_upload_jadwal') ?>" method="post" enctype="multipart/form-data">
                    <input type="file" required name="file">

                    <input type="month" required value="<?php echo date('Y-m')?>" class="col-md-4" name="bulan">

                    <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                </form>
            </div>

            <div mb-2>
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->

                <?php $this->load->view('layouts/alert'); ?>


            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tableAbsen">
                            <thead>
                                <tr class="table-success">
                                    <th>No</th>
                                    <th>NAMA</th>
                                    <th></th>

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