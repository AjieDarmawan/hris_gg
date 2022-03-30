<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Kantor</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form action="<?php echo base_url('master/kantor/simpan')?>" method="post">
                        <div class="card-body">
                            <div class="form-group mb-8">
                               
                            </div>
                        
                        
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama kantor</label>
                                <div class="col-10">
                                    <input class="form-control" name="kantor_nama" type="text" 
                                        id="kantor" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Kode kantor</label>
                                <div class="col-10">
                                    <input class="form-control" name="kode_kantor" type="text" 
                                        id="kantor" />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Koordinator</label>
                                <div class="col-10">
                                    <input class="form-control" name="koordinator" type="text" 
                                        id="kantor" />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Lattitude</label>
                                <div class="col-10">
                                    <input class="form-control" name="lat" type="text" 
                                        id="kantor" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Langitude</label>
                                <div class="col-10">
                                    <input class="form-control" name="long" type="text" 
                                        id="kantor" />
                                </div>
                            </div>
                            
                           
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