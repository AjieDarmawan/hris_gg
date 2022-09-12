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

             
            <a class="btn btn-primary btn-sm" href="<?php echo base_url('gaji/bpjs/croscek') ?>">Data Crosceek</a>
  
            <?php 
            $bulan_where = date('m-Y');
                $cek_bpjs = $this->db->query('select * from payroll.bpjs where bulan="'.$bulan_where.'" limit 1')->row();
                if($cek_bpjs){
                        ?>
                                 <button class="btn btn-success btn-sm" disabled  >Sudah DI Acc Divisi Keuangan</button>
                        <?php
                }else{
                    ?>
                                  <a href="<?php echo base_url('gaji/bpjs/bpjs_insert')?>" onclick="return confirm('Apakah Kamu Yakin?')" class="btn btn-success btn-sm">Mengetahui Divisi Keuangan</a>

                    <?php
                    

                }
            
            ?>



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
                                    <th>Total Gaji BPJS</th>
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
                                    <th>JP (PK)  2%</th>
                                   

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
            "url": '<?php echo base_url('gaji/bpjs/ajax_list') ?>',
            "type": "POST"
        }
    });
</script>

