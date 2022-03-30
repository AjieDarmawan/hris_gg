<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Tambah materi</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->

                    <?php 
                        $id_event = base64_decode($id);
                    
                    ?>
                   


                    <form action="<?php echo base_url('master/materi/upload_soal') ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group mb-8">

                         


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Upload Soal</label>
                                <div class="col-10">
                                    <input type="file" required name="file">
                                </div>
                            </div>




                            <!--begin: Code-->
                            <div class="example-code mt-10">
                                <div class="example-highlight">
                                    <pre style="height:400px">


                                </div>
                            </div>
                            <!--end: Code-->
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-10">
                                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--end::Card-->

            </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->


<script>
    function jurusan(){
        var x = document.getElementById("jenis").value;

       // alert(x)

        $.ajax({
            type: "POST",
            data: {'id_jenis':x},
            url: "<?php echo base_url('master/materi/ajax_jurusan')?>",
            success: function(result){
                $("#show").html(result); 

                }
            });
    }
</script>