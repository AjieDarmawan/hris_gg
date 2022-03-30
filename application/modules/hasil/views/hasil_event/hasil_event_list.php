<div class="container pt-5">
        <h3><?= $title ?></h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a>Rangking </a></li>
                <li class="breadcrumb-item active" aria-current="page">List Data</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
               
                <div mb-2>
                    <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                    
                    <?php $this->load->view('layouts/alert'); ?>

                    <?php 
                        // echo "<pre>";
                        // print_r($hasil);
                    ?>


                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="tabledivisi">
                                <thead>
                                    <tr class="table-success">
                                        <th></th>
                                      
                                        <th>Nama </th>
                                      
                                        <th>Email</th>
                                        <th>Sekolah</th>
                                        <th>Skor</th>
                                        <th>Durasi Pengerjaan</th>
                                        <th>Waktu Pengerjaan</th>
                                       
                                        
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    <?php 
                                        $no=1;
                                        foreach($hasil as $h){
                                     ?>    
                                      <tr>   
                                         <td><?php echo $no++; ?></td>
                                         <td><?php echo $h['email']; ?></td>
                                         <td><?php echo $h['nama']; ?></td>
                                         <td><?php echo $h['asal_sekolah']; ?></td>
                                         <td><?php echo $h['skor']; ?></td>
                                         <td><?php echo $h['waktu']; ?></td>
                                         <td><?php echo $h['waktu_pengerjaan']; ?></td>
                                         
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


    <script src="<?php echo base_url();?>assets/template/assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?php echo base_url();?>assets/template/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="<?php echo base_url();?>assets/template/assets/js/scripts.bundle.js"></script>
 
 