<div class="container pt-5">
        <h3><?= $title ?></h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a>Materi</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Data</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary mb-2" href="<?= base_url('master/users/tambah'); ?>">Tambah</a>
                <div mb-2>
                    <!-- Menampilkan flashh data (pesan saat data berhasil disimpan)-->
                    
                    <?php $this->load->view('layouts/alert'); ?>


                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="tabledivisi">
                                <thead>
                                    <tr class="table-success">
                                        <th></th>
                                      
                                        <th>NAMA</th>
                                        <th>Role</th>
                                        <th>Status</th>
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


    <script src="<?php echo base_url();?>assets/template/assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?php echo base_url();?>assets/template/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="<?php echo base_url();?>assets/template/assets/js/scripts.bundle.js"></script>
 
 
   
    <!--begin::Page Vendors(used by this page)-->
		<script src="<?php echo base_url();?>assets/template/assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Page Vendors-->
		<!--begin::Page Scripts(used by this page)-->


    <script>
        //setting datatables
        $('#tabledivisi').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                //panggil method ajax list dengan ajax
                "url": '<?php echo base_url('master/users/ajax_list')?>',
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

       


      $(document).on("click",".hapus_dokumen",function(){
              var id=$(this).attr("id");

            //  alert(id);
              swal({
                  title: "Yakin Hapus Data ini  ?",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonColor: "#DD6B55",
                  confirmButtonText: "Ya, Hapus!",
                  closeOnConfirm: false
              }, function () {

                  $.ajax({
                      type : "POST",
                      url  : "<?php echo base_url();?>master/users/hapus",
                      dataType: "JSON",
                      data : "id="+id,
                      success:function(data){
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

  