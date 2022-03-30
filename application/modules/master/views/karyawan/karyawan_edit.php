<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Edit karyawan</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form action="<?php echo base_url('master/karyawan/update_simpan')?>" method="post">
                        <div class="card-body">
                            <div class="form-group mb-8">

                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama karyawan</label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $karyawan->karyawan_nama;?>" name="karyawan" type="text" id="karyawan" />
                                </div>
                            </div>

                            <input type="hidden" name="karyawan_id" value="<?php echo $karyawan->jbt_id?>" >

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama Divisi</label>
                                <div class="col-10">
                                    <select class="form-control" id="kt_select2_1" name="div_id">
                                        <?php 
                                               foreach($divisi as $d){
                                                        if($d->div_id==$karyawan->div_id){
                                                            $selected = "selected";
                                                        }else{
                                                            $selected = "";
                                                        }

                                                           ?>
                                                    <option value=<?php echo $d->div_id?> <?php echo $selected;?> ><?php echo $d->divisi_nama?></option>
                                                <?php  
                                                 }
                                               ?>
                                    </select>
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