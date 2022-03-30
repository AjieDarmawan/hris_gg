<div class="container pt-5">
    <h3><?= $title ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a>Soal</a></li>
            <li class="breadcrumb-item active" aria-current="page">List Data</li>
        </ol>
    </nav>

    <!-- <div align="right">
        <a href="" class="btn btn-info btn-sm">Download Template</a>
    </div> -->
    <div class="row">

    

    <br><br>
        <div class="col-md-12">
          <?php 
             $sql = $this->db->query('select * from materi where materi_id="'.base64_decode($id).'"')->row();


            //  echo "<pre>";
            //  print_r();

            if($sql->publish==1){
                ?>

            <?php    
            }else{
            ?>
                     <a class="btn btn-primary mb-2" href="<?= base_url('master/Soal/tambah/'.$id); ?>">Tambah</a>
           <?php     
            }
          ?>

       
            <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                Upload Soal
            </button>  -->


            <div>
                <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                <?php $this->load->view('layouts/alert'); ?>
            </div>

            <?php 
                echo "https://live.ai.web.id/tryout/preview/soal/".$id;
            ?>
          
            <div class="card">
                <div class="card-body">
                <a href="https://live.ai.web.id/tryout/preview/soal/<?php echo $id;?>" target="_blank" class="btn btn-primary btn-sm">Preview Soal</a>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tableSoal">
                            <thead>
                                <tr class="table-success">
                                    <th></th>

                                    <th>Soal Id</th>

                                    <th>Materi</th>
                                    <th>Image</th>
                                    <th >Pertanyaan</th>

                                    <th>A</th>
                                    <th>B</th>
                                    <th>C</th>
                                    <th>D</th>
                                    <th>E</th>
                                    <th>Pemabahasan</th>
                                    <th>Pembahasan IMG</th>
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


<script>
    //setting datatables
    $('#tableSoal').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            //panggil method ajax list dengan ajax
            "url": '<?php echo base_url('master/Soal/ajax_list/'.$id) ?>',
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
                    url: "<?php echo base_url(); ?>master/Soal/hapus",
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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form action="<?php echo base_url('master/Soal/simpan_upload_soal') ?>" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Soal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-10">
                    
                        <input type="file" required name="file">

                        <br><br>

                        <select name="materi_id" class="form-control">
                            <?php 
                                foreach($materi as $m){
                                    ?>
                                    <option value="<?php echo $m->materi_id?>"><?php echo $m->materi_nama?></option>
                             <?php       
                                }
                            ?>
                        </select>
                  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>