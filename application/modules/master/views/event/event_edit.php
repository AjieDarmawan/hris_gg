<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Edit Event</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form action="<?php echo base_url('master/event/update_simpan')?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group mb-8">
                               
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama Event</label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $event->judul; ?>" name="judul" type="text" 
                                        id="event" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">kategori Nama</label>
                                <div class="col-10">
                                      <select name="id_kategori" class="form-control">
                                            <?php 
                                                foreach($kategori as $j) {

                                                    if($j->id_kategori==$event->id_kategori){
                                                        $selected = "selected";
                                                    }else{
                                                        $selected = "";
                                                    }
                                                    ?>
                                                    <option value="<?php echo $j->id_kategori?>" <?php echo $selected;?> ><?php echo $j->kategori_nama?></option>

                                             <?php       
                                                }
                                            ?>

                                      </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Tanggal Mulai</label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $event->tgl_mulai; ?>" name="tgl_mulai" type="date" 
                                        id="event" />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Tanggal Selesai</label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $event->tgl_selesai; ?>" name="tgl_selesai" type="date" 
                                        id="event" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Deskripsi</label>
                                <div class="col-10">
                                    <textarea class="form-control" name="desc" type="text" 
                                        id="event" ><?php echo $event->desc; ?></textarea>
                                </div>
                            </div>


                            <!-- <div class="form-group row">
                                <label class="col-2 col-form-label">Gambar</label>
                                <div class="col-10">
                                    <input class="form-control" name="file" type="file" 
                                        id="event" />
                                </div>
                            </div> -->


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Mode</label>
                                <div class="col-10">
                                     <select class="form-control" name="status">
                                         <option value="">--PILIH--</option>
                                         <option value="event" <?php  if($event->mode=="event"){echo "selected";}?>>Event</option>
                                         <option value="latihan" <?php  if($event->mode=="latihan"){echo "selected";}?>>Latihan</option>
                                     </select>
                                </div>
                            </div>

                            <input class="form-control" value="<?php echo $event->id_event; ?>" name="id_event" type="hidden" 
                                        id="materi" />
                            
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