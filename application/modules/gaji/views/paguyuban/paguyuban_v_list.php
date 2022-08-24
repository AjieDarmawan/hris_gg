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
                                    <th>Keperluan</th>
                                    <th>Tanggal Pinjaman</th>
                                    <th>Jumlah Pinjaman</th>
                                    <th>Sisa Pinjaman</th>
                                    <th>Pinjaman Bulan Berjalan</th>
                                    <th>Tgl Di Transfer</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pg as $p) {
                                ?>

                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td><?php echo $p->pg_kar_nik?></td>
                                    <td><?php echo $p->pg_kar_nm?></td>
                                    <td><?php echo $p->pg_ket?></td>

                                    <td><?php echo TanggalIndo($p->pg_tanggal)?></td>
                                    <td><?php echo $p->pg_pinjaman?></td>
                                    <td><?php echo $p->pg_sisa?></td>
                                    <td><?php echo $p->pg_ke?></td>
                                    <td><?php echo TanggalIndo($p->pg_tanggal_transfer)?></td>
                                </tr>

                                <?php
                                }
                                ?>
                            </tbody>
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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>