<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Edit materi</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form action="<?php echo base_url('master/materi/update_simpan')?>" method="post">
                        <div class="card-body">
                            <div class="form-group mb-8">
                               
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">No Urut </label>
                                <div class="col-10">
                                    <select class="form-control" name="no_urut">
                                        <option value="1" <?php if($materi->no_urut==1){echo "selected";} ?>>1</option>
                                        <option value="2"<?php if($materi->no_urut==2){echo "selected";} ?>>2</option>
                                        <option value="3"<?php if($materi->no_urut==3){echo "selected";} ?>>3</option>
                                        <option value="4"<?php if($materi->no_urut==4){echo "selected";} ?>>4</option>
                                        <option value="5"<?php if($materi->no_urut==5){echo "selected";} ?>>5</option>
                                        <option value="6"<?php if($materi->no_urut==6){echo "selected";} ?>>6</option>
                                        <option value="7"<?php if($materi->no_urut==7){echo "selected";} ?>>7</option>
                                        <option value="8"<?php if($materi->no_urut==8){echo "selected";} ?>>8</option>
                                        <option value="9"<?php if($materi->no_urut==9){echo "selected";} ?>>9</option>
                                        <option value="10"<?php if($materi->no_urut==10){echo "selected";} ?>>10</option>
                                        <option value="11"<?php if($materi->no_urut==11){echo "selected";} ?>>11</option>
                                        <option value="12"<?php if($materi->no_urut==12){echo "selected";} ?>>12</option>
                                        <option value="13"<?php if($materi->no_urut==13){echo "selected";} ?>>13</option>
                                        <option value="14"<?php if($materi->no_urut==14){echo "selected";} ?>>14</option>
                                        <option value="15"<?php if($materi->no_urut==15){echo "selected";} ?>>15</option>
                                        <option value="16"<?php if($materi->no_urut==16){echo "selected";} ?>>16</option>
                                        <option value="17"<?php if($materi->no_urut==17){echo "selected";} ?>>17</option>
                                        <option value="18"<?php if($materi->no_urut==18){echo "selected";} ?>>18</option>
                                        <option value="19"<?php if($materi->no_urut==19){echo "selected";} ?>>19</option>
                                        <option value="20"<?php if($materi->no_urut==20){echo "selected";} ?>>20</option>

                                    </select>
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama materi</label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $materi->materi_nama; ?>" name="materi" type="text" 
                                        id="materi" />
                                </div>
                            </div>

                                <?php 
                                    error_reporting(0);
                                    $jenis_nama = $this->db->query('select jenis_nama from jenis where id_jenis="'.$materi->id_jenis.'"')->row();
                                    $jurusan_nama = $this->db->query('select jurusan_nama from jurusan where id_jurusan="'.$materi->id_jurusan.'"')->row();
                                ?>
                          

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jenis</label>
                                <div class="col-10">
                                    <select class="form-control" id="jenis" onchange="jurusan()" required name="id_jenis">
                                    <option value="<?php echo $materi->id_jenis;?>"><?php echo $jenis_nama->jenis_nama;?></option>
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
                                        <option value="<?php echo $materi->id_jurusan;?>"><?php echo $jurusan_nama->jurusan_nama;?></option>
                                        <?php
                                        foreach ($jurusan as $j) {

                                            
                                            if($j->id_jurusan==$materi->id_jurusan){
                                                $selected = "selected";
                                            }else{
                                                $selected = "";
                                            }
                                        ?>
                                            <option value="<?php echo $j->id_jurusan ?>" <?php echo $selected;?> ><?php echo $j->jurusan_nama ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Tanggal Mulai</label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $materi->tgl_mulai; ?>" required name="tgl_mulai" type="date" id="event" />
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-2 col-form-label">Tanggal Selesai</label>
                                <div class="col-10">
                                    <input class="form-control" value="<?php echo $materi->tgl_mulai; ?>" required name="tgl_selesai" type="date" id="event" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Waktu Pengerjaan</label>
                                <div class="col-10">
                                    <input type="number" class="form-control" value="10" required name="waktu">
                                </div>
                            </div>



                            <input class="form-control" value="<?php echo $materi->materi_id; ?>" name="materi_id" type="hidden" 
                                        id="materi" />

                                        <input class="form-control" value="<?php echo $id_event; ?>" name="id_event" type="hidden" 
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