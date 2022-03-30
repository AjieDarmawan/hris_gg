<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Jurusan</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form action="<?php echo base_url('master/jurusan/simpan')?>" method="post">
                        <div class="card-body">
                            <div class="form-group mb-8">
                               
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jenis Nama</label>
                                <div class="col-10">
                                      <select name="id_jenis" class="form-control">
                                            <?php 
                                                foreach($jenis as $j) {
                                                    ?>
                                                    <option value="<?php echo $j->id_jenis?>"><?php echo $j->jenis_nama?></option>

                                             <?php       
                                                }
                                            ?>

                                      </select>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama jurusan</label>
                                <div class="col-10">
                                    <input class="form-control" name="jurusan" type="text" 
                                        id="jurusan" />
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