<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Edit Soal</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->

                    <?php


                // echo "<pre>";
                // print_r($soal);



                    $pilihan = json_decode($soal->pilihan);

                    //  echo "<pre>";
                    //  print_r($pilihan);

                    foreach ($pilihan as $p) {
                        if ($p->code == 1) {

                            $jawaban_a  = $p->name;
                        } elseif ($p->code == 2) {

                            $jawaban_b  = $p->name;
                        } elseif ($p->code == 3) {


                            $jawaban_c  = $p->name;
                        } elseif ($p->code == 4) {

                            $jawaban_d  = $p->name;
                        } elseif ($p->code == 5) {

                            $jawaban_e  = $p->name;
                        }
                    }


                    $Path_img_jawaban_a = base_url("assets/file_upload/soalonline/jawaban_a/" . $jawaban_a);
                    $Path_jawaban_a = FCPATH . 'assets/file_upload/soalonline/jawaban_a/' . $jawaban_a;

                    if ($jawaban_a) {
                        if (file_exists($Path_jawaban_a)) {
                            $Path2_jawaban_a = " <img widht='50' height='50' src='" . $Path_img_jawaban_a . "'>";
                            $type_a = 'gambar';
                        } else {
                            $Path2_jawaban_a =  $jawaban_a;
                            $type_a = 'text';
                        }
                    } else {
                        $Path2_jawaban_a =  $jawaban_a;
                        $type_a = 'text';
                    }



                    $Path_img_jawaban_b = base_url("assets/file_upload/soalonline/jawaban_b/" . $jawaban_b);
                    $Path_jawaban_b = FCPATH . 'assets/file_upload/soalonline/jawaban_b/' . $jawaban_b;


                    if ($jawaban_b) {
                        if (file_exists($Path_jawaban_b)) {
                            $Path2_jawaban_b = "<img widht='50' height='50' src='" . $Path_img_jawaban_b . "'>";
                            $type_b = 'gambar';
                        } else {
                            $Path2_jawaban_b =  $jawaban_b;
                            $type_b = 'text';
                        }
                    } else {
                        $Path2_jawaban_b =  $jawaban_b;
                        $type_b = 'text';
                    }




                    $Path_img_jawaban_c = base_url("assets/file_upload/soalonline/jawaban_c/" . $jawaban_c);
                    $Path_jawaban_c = FCPATH . 'assets/file_upload/soalonline/jawaban_c/' . $jawaban_c;


                    if ($jawaban_c) {

                        if (file_exists($Path_jawaban_c)) {

                            $Path2_jawaban_c = " <img widht='50' height='50' src='" . $Path_img_jawaban_c . "'>";
                            $type_c = 'gambar';
                        } else {
                            $Path2_jawaban_c =  $jawaban_c;
                            $type_c = 'text';
                        }
                    } else {
                        $Path2_jawaban_c =  $jawaban_c;
                        $type_c = 'text';
                    }




                    $Path_img_jawaban_d = base_url("assets/file_upload/soalonline/jawaban_d/" . $jawaban_d);
                    $Path_jawaban_d = FCPATH . 'assets/file_upload/soalonline/jawaban_d/' . $jawaban_d;


                    if ($jawaban_d) {
                        if (file_exists($Path_jawaban_d)) {
                            $Path2_jawaban_d = " <img widht='50' height='50' src='" . $Path_img_jawaban_d . "'>";
                            $type_d = 'gambar';
                        } else {
                            $Path2_jawaban_d =  $jawaban_d;
                            $type_d = 'text';
                        }
                    } else {
                        $Path2_jawaban_d =  $jawaban_d;
                        $type_d = 'text';
                    }





                    $Path_img_jawaban_e = base_url("assets/file_upload/soalonline/jawaban_e/" . $jawaban_e);
                    $Path_jawaban_e = FCPATH . 'assets/file_upload/soalonline/jawaban_e/' . $jawaban_e;


                    if ($jawaban_e) {
                        if (file_exists($Path_jawaban_e)) {
                            $Path2_jawaban_e = " <img widht='50' height='50' src='" . $Path_img_jawaban_e . "'>";
                            $type_e = 'gambar';
                        } else {
                            $Path2_jawaban_e =  $jawaban_e;
                            $type_e = 'text';
                        }
                    } else {
                        $Path2_jawaban_e =  $jawaban_e;
                        $type_e = 'text';
                    }

                    ?>
                    <form action="<?php echo base_url('master/Soal/update_simpan') ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group mb-8">

                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Pertanyaan_img</label>
                                <div class="col-10">
                                    <?php
                                    error_reporting(0);
                                    $gm_img = base_url("assets/file_upload/soalonline/soal/" .$soal->img);
                                    echo "<img widht='50' height='50' src='" . $gm_img . "'>";
                                    ?>
                                    <input type="file" name="pertanyaan_img">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Pertanyaan</label>
                                <div class="col-10">
                                    <textarea class="form-control" name="pertanyaan" type="text" id="pertanyaan" rows="14" cols="50"><?php echo $soal->pertanyaan; ?></textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban A</label>
                                <div class="col-8">
                                    <textarea class="form-control" rows="4" name="jawaban_a" type="text" id="jawaban_a"><?php
                                                                                                                        if ($type_a == 'text') {
                                                                                                                            echo $Path2_jawaban_a;
                                                                                                                        }
                                                                                                                        ?> </textarea>
                                </div>
                                <div class="col-2">
                                    <?php
                                    if ($type_a == 'gambar') {
                                        echo $Path2_jawaban_a;
                                    }
                                    ?>
                                    <input type="file" name="img_jawaban_a">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban B</label>
                                <div class="col-8">
                                    <textarea class="form-control" rows="4" name="jawaban_b" type="text" id="jawaban_b"><?php
                                                                                                                        if ($type_b == 'text') {
                                                                                                                            echo $Path2_jawaban_b;
                                                                                                                        }
                                                                                                                        ?></textarea>
                                </div>
                                <div class="col-2">
                                    <?php
                                    if ($type_b == 'gambar') {
                                        echo $Path2_jawaban_b;
                                    }
                                    ?>
                                    <input type="file" name="img_jawaban_b">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban C</label>
                                <div class="col-8">
                                    <textarea class="form-control" name="jawaban_c" type="text" id="jawaban_c"><?php
                                                                                                                if ($type_c == 'text') {
                                                                                                                    echo $Path2_jawaban_c;
                                                                                                                }
                                                                                                                ?></textarea>
                                </div>
                                <div class="col-2">
                                    <?php
                                    if ($type_c == 'gambar') {
                                        echo $Path2_jawaban_c;
                                    }
                                    ?>
                                    <input type="file" name="img_jawaban_c">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban D</label>
                                <div class="col-8">
                                    <textarea class="form-control" name="jawaban_d" type="text" id="jawaban_d"><?php
                                                                                                                if ($type_d == 'text') {
                                                                                                                    echo $Path2_jawaban_d;
                                                                                                                }
                                                                                                                ?></textarea>
                                </div>
                                <div class="col-2">
                                    <?php
                                    if ($type_d == 'gambar') {
                                        echo $Path2_jawaban_d;
                                    }
                                    ?>
                                    <input type="file" name="img_jawaban_d">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban E</label>
                                <div class="col-8">
                                    <textarea class="form-control" name="jawaban_e" type="text" id="Soal"><?php
                                                                                                            if ($type_e == 'text') {
                                                                                                                echo $Path2_jawaban_e;
                                                                                                            }
                                                                                                            ?></textarea>
                                </div>
                                <div class="col-2">
                                    <?php
                                    if ($type_e == 'gambar') {
                                        echo $Path2_jawaban_e;
                                    }
                                    ?>
                                    <input type="file" name="img_jawaban_e">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Pembahasan</label>
                                <div class="col-8">
                                    <textarea class="form-control" rows="14" cols="50" name="pembahasan" type="text" id="pembahasan"><?php echo $soal->pembahasan; ?></textarea>
                                </div>
                                <div class="col-2">
                                    <?php
                                    error_reporting(0);
                                    $pm_img = base_url("assets/file_upload/soalonline/pembahasan/" . $soal->pembahasan_img);
                                    echo "<img widht='50' height='50' src='" . $pm_img . "'>";
                                    ?>
                                    <input type="file" name="pembahasan_img">
                                </div>
                            </div>

                            <input type="hidden" name="soal_id" value="<?php echo $soal->id; ?>">

                            <input type="hidden" name="id_materi" value="<?php echo $id_materi; ?>">


                            <?php 

                                // echo "<pre>";
                                // print_r($soal);
                            ?>
                            
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban</label>
                                <div class="col-8">
                                    <select name="jawaban_benar" class="form-control">
                                            <option class="">--Pilih--</option>
                                            <option class="1" <?php if($soal->jawaban=='1'){echo "selected";}?> >A</option>
                                            <option class="2" <?php if($soal->jawaban=='2'){echo "selected";}?>>B</option>
                                            <option class="3" <?php if($soal->jawaban=='3'){echo "selected";}?>>C</option>
                                            <option class="4" <?php if($soal->jawaban=='4'){echo "selected";}?>>D</option>
                                            <option class="5" <?php if($soal->jawaban=='5'){echo "selected";}?>>E</option>
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