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

            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload_excel">Upload Excel</button>
            <br>

             
            <a class="btn btn-primary btn-sm" href="<?php echo base_url('gaji/pajak/croscek') ?>">Data Crosceek</a>
          
            <?php 
            $bulan_where = date('m-Y');
                $cek_sembako = $this->db->query('select * from payroll.pajak where bulan="'.$bulan_where.'" limit 1')->row();
                if($cek_sembako){
                        ?>
                             <button class="btn btn-success btn-sm" disabled  >Sudah DI Acc Divisi Perpajakan</button>
                        <?php
                }else{
                    ?>
                         <a href="<?php echo base_url('gaji/pajak/pajak_insert')?>"  onclick="return confirm('Apakah Kamu Yakin?')" class="btn btn-success btn-sm">Mengetahui Divisi Perpajakan</a>
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
                                    <th>Npwp</th>
                                    <th>Total Gaji</th>
                                     <th>Dinas Luar Kota</th>
                                    <th>Tunjangan Lain</th>
                                    <th>Insentif</th>
                                    <th>Total gaji + insentif</th>
                                    <th>Status Perkawinan</th>
                                    <th>Jumlah Anak</th>

                                    <th>Status Pajak</th>

                                    <th>Tgl Join</th>
                                    <th>Hari THR</th>
                                    <th>Nominal THR</th>
                                    <th>Perhitungan Bulan</th>
                                  
                                    <th>Gaji Total 1 Tahun</th>
                                    <th>Jabatan</th>
                                    <th>PTKP</th>
                                    <th>Jht & Jp / Setahun</th>
                                    <th>Gaji Pajak Setahun</th>
                                    <th>Pajak Setahun</th>
                                    <th>Pajak Setahun THR</th>
                                    <th>Selisih Thr - P</th>
                                    <th>Pajak Perbulan</th>
                                    <th>Pajak Insentif</th>
                                    <th>Pajak Gaji</th>
                                    <th>Pajak BONUS</th>
                                    <th>Pajak THR</th>
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


<!-- Modal -->
<div id="upload_excel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">


            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </button>
                    <h4 class="modal-title" id="modalLabel"><i class="fa fa-plus" aria-hidden="true"></i> Form Upload Insentif</h4>

                </div>
                <div class="modal-body">
                    <form role="form" action="<?php echo base_url('gaji/pajak/pajak_insert_testing') ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div>
                              
                                <input class="form-control form-control-sm" id="formFileSm" name="file" type="file">
                                Upload Data Listrik
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
