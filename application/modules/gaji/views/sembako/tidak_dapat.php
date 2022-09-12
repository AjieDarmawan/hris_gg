<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tablekaryawan">
                <thead>
                    <tr class="table-success">
                        <th></th>

                        <th>Nik</th>
                        <th>Nama</th>
                        <th>Tgl Join</th>
                        <th>Divisi</th>
                        <th>Kantor</th>
                        <th>Harga</th>

                    </tr>
                </thead>

                <tbody>
                   
                        <?php
                       
                        $no=1;
                        $tot_harga=0;
                        foreach ($tidak_dapat as $m) {
                            error_reporting(0);

                            $tot_harga += 110000;

                            $div = $this->db->query('select d.div_nm,kt.ktr_nm from kar_master as k inner 
                            join div_master as d  on d.div_id = k.div_id 
                            inner join ktr_master as kt  on k.ktr_id = kt.ktr_id where k.kar_id ="'.$m->kar_id.'"')->row();
                        ?>
                         <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $m->kar_nik?></td>
                            <td><?php echo $m->kar_nm?></td>
                            <td><?php echo date('d-M-Y',strtotime($m->kar_dtl_tgl_joi))?>
                            <td><?php echo $div->div_nm?></td>
                            <td><?php echo $div->ktr_nm?></td>

                            
                            <td><?php echo number_format(110000)?></td>    
                            </tr>
                           
                        <?php
                        }
                        ?>
                   
                </tbody>

                <tfoot>
                                <tr>
                                <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total Harga</td>
                                    <td><?php echo number_format($tot_harga);?></td>
                                </tr>
                            </tfoot>


            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>