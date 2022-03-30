<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Soal</h3>
                        <div class="card-toolbar">
                            <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->

                   
                    <form action="<?php echo base_url('master/Soal/simpan') ?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group mb-8">

                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Pertanyaan_img</label>
                                <div class="col-10">
                                   
                                    <input type="file" name="pertanyaan_img">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Pertanyaan</label>
                                <div class="col-10">
                                    <textarea class="form-control" name="pertanyaan" type="text" id="pertanyaan" rows="14" cols="50"></textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban A</label>
                                <div class="col-8">
                                    <textarea class="form-control" rows="4" name="jawaban_a" type="text" id="jawaban_a"> </textarea>
                                </div>
                                <div class="col-2">
                                   
                                    <input type="file" name="img_jawaban_a">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban B</label>
                                <div class="col-8">
                                    <textarea class="form-control" rows="4" name="jawaban_b" type="text" id="jawaban_b"></textarea>
                                </div>
                                <div class="col-2">
                                   
                                    <input type="file" name="img_jawaban_b">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban C</label>
                                <div class="col-8">
                                    <textarea class="form-control" name="jawaban_c" type="text" id="jawaban_c"></textarea>
                                </div>
                                <div class="col-2">
                                   
                                    <input type="file" name="img_jawaban_c">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban D</label>
                                <div class="col-8">
                                    <textarea class="form-control" name="jawaban_d" type="text" id="jawaban_d"></textarea>
                                </div>
                                <div class="col-2">
                                   
                                    <input type="file" name="img_jawaban_d">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban E</label>
                                <div class="col-8">
                                    <textarea class="form-control" name="jawaban_e" type="text" id="Soal"></textarea>
                                </div>
                                <div class="col-2">
                                    
                                    <input type="file" name="img_jawaban_e">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jawaban Benar</label>
                                <div class="col-8">
                                    <select required class="form-control" name="jawaban_benar">
                                            <option value="">--Pilih--</option>
                                            <option value="1">A</option>
                                            <option value="2">B</option>
                                            <option value="3">C</option>
                                            <option value="4">D</option>
                                            <option value="5">E</option>

                                    </select>
                                </div>
                               
                            </div>


                            <div class="form-group row">
                                <label class="col-2 col-form-label">Pembahasan</label>
                                <div class="col-8">
                                    <textarea class="form-control" rows="14" cols="50" name="pembahasan" type="text" id="pembahasan"></textarea>
                                </div>
                                <div class="col-2">
                                    
                                    <input type="file" name="pembahasan_img">
                                </div>
                            </div>

                         
                            <input type="" name="materi_id" value="<?php echo base64_decode($materi_id);?>">


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