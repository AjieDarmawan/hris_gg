<table border="1">
    <thead>
        <th>No</th>
        <th>Nama</th>
        <th>Final Gaji</th>
        <th>Final Gaji Testing</th>
        <th>Selisih</th>
        <th>Pajak</th>
    </thead>

    <tbody>
        <?php
        error_reporting(0);
        $no = 1;
        foreach ($data_kar as $k) {

            $pajak = $this->db->query('select pph_dibayar from payroll.pajak where kar_id = "'.$k->kar_id.'" and bulan = "09-2022" ')->row();


            if($pajak->pph_dibayar<='12000'){
                $pengurang_pajak = (int)$pajak->pph_dibayar;
            }else{
                $pengurang_pajak = 0;
            }

            if($k->kar_nik=='SG.0441.2017'){
                $yg_diterima = $k->total_terima - $pengurang_pajak - 42172;
             }else{
                $yg_diterima = $k->total_terima - $pengurang_pajak;
             }

           


            if($yg_diterima != $k->nominal){
                $colom = 'style="
                background: red;
            "';
            }else{
                $colom = '';
            }

            

            if($k->kar_nm!=''){
                ?>

<tr>
             <td <?php echo $colom;?>><?php echo $no++;?></td>
             <td><?php echo $k->kar_nm;?></td>
             <td><?php echo $yg_diterima;?></td>
             <td><?php echo $k->nominal;?></td>
             <td><?php echo $yg_diterima - $k->nominal;?></td>

             <td><?php echo number_format($pajak->pph_dibayar);?></td>

             
          </tr>

            <?php    
            }
        ?>

          

        <?php
        }
        ?>
    </tbody>
</table>