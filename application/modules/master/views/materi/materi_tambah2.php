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
                   


                    <form action="<?php echo base_url('master/materi/simpan') ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group mb-8">

                            <div align="right">
                                <a href="<?php echo base_url('assets/file_upload/doc/Soal_Tryout.xlsx')?>" class="btn btn-info btn-sm">Download Template Soal</a>
                            </div>



                            </div>

                            <input type="hidden" name="id_event" value="<?php echo $id_event; ?>">



                            <div class="form-group row">
                                <label class="col-2 col-form-label">No Urut </label>
                                <div class="col-10">
                                    <select class="form-control" name="no_urut">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>

                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama Materi</label>
                                <div class="col-10">
                                    <input class="form-control" required name="Materi" type="text" id="materi" />
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jenis</label>
                                <div class="col-10">
                                    <select class="form-control" id="jenis" onchange="jurusan()" required name="id_jenis">
                                        <option value="">--Pilih--</option>
                                        <?php
                                        foreach ($jenis as $j) {
                                        ?>
                                            <option value="<?php echo $j->id_jenis ?>"><?php echo $j->jenis_nama ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jurusan</label>
                                <div class="col-10">
                                    <select class="form-control" id="show" required name="id_jurusan">
                                       
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Tanggal Mulai</label>
                                <div class="col-10">
                                    <input class="form-control" required name="tgl_mulai" type="date" id="event" />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Tanggal Selesai</label>
                                <div class="col-10">
                                    <input class="form-control" required name="tgl_selesai" type="date" id="event" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Waktu Pengerjaan</label>
                                <div class="col-10">
                                    <input type="number" class="form-control" value="10" required name="waktu">
                                </div>
                            </div>



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