<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Bpjs.xlsx"');
header('Cache-Control: max-age=0');
?>

<table border="1" id="tablekaryawan">
    <thead>
        <tr class="">
            <th></th>
            <th>Nik </th>
            <th>Nama</th>
            <th>Total Gaji</th>

            <th>Status Perkawinan</th>
            <th>Jumlah Anak</th>

            <th>BPJS (K) 1%</th>
            <th>JHT (K) 2%</th>
            <th>JP JP (K) 1 %</th>


            <th>BPJS (PK) 4%</th>
            <th>JKK(PK) 0,24% </th>
            <th>JHT (PK) 3,70% </th>
            <th>JKM (PK) 0,30%</th>
            <th>JP (PK) 2%</th>

        </tr>
    </thead>

    <tbody>

        <?php

        // echo "<pre>";
        // print_r($bpjs);

        $no = 1;

        $tot_bpjs_k  = 0;
        $tot_jht_k  = 0;
        $tot_jp_k = 0;


        $tot_bpjs_pk = 0;
        $tot_jkk_pk = 0;
        $tot_jht_pk = 0;
        $tot_jkm_pk = 0;
        $tot_jp_pk = 0;


        foreach ($bpjs as $data_bpjs) {





            $tot_gaji = $this->db->query('select sum(gaji_pokok+t_struktural+t_fungsional+t_umum+t_kinerja) as tot from payroll.komponen_gaji where kar_id =  "' . $data_bpjs->kar_id . '"')->row();

            $total_gaji = $tot_gaji->tot;


            $bpjs_k  = $total_gaji * 1 / 100;
            $bpjs_pk = $total_gaji * 4 / 100;

            $jht_k  = $total_gaji * 2 / 100;
            $jht_pk = $total_gaji * 3.70 / 100;

            $jp_k  = $total_gaji * 1 / 100;
            $jp_pk  = $total_gaji * 2 / 100;

            $jkk_pk = $total_gaji * 0.4 / 100;
            $jkm_pk = $total_gaji * 0.30 / 100;


            $tot_bpjs_k += $bpjs_k;
            $tot_jht_k  += $jht_pk;
            $tot_jp_k += $jp_k;


            $tot_bpjs_pk += $bpjs_pk;
            $tot_jkk_pk += $jkk_pk;
            $tot_jht_pk += $tot_jht_k;
            $tot_jkm_pk += $jkm_pk;
            $tot_jp_pk += $jp_pk;
        ?>
            <tr>
                <td><?php echo $no++ ?> </td>
                <td><?php echo $data_bpjs->kar_nik ?> </td>
                <td><?php echo $data_bpjs->kar_nm ?> </td>
                <td><?php echo number_format($tot_gaji->tot) ?> </td>
                <td><?php echo $data_bpjs->kar_dtl_sts_nkh ?> </td>
                <td><?php echo $data_bpjs->kar_dtl_jml_ank ?> </td>
                <td><?php echo number_format($bpjs_k) ?> </td>
                <td><?php echo number_format($jht_k) ?> </td>
                <td><?php echo number_format($jp_k) ?> </td>

                <td><?php echo number_format($bpjs_pk) ?> </td>
                <td><?php echo number_format($jkk_pk) ?> </td>
                <td><?php echo number_format($jht_pk) ?> </td>
                <td><?php echo number_format($jkm_pk) ?> </td>
                <td><?php echo number_format($jp_pk) ?> </td>



            </tr>

        <?php
        }
        ?>

    </tbody>

    <tfoot>
        <tr>
            <td></td>
            <td colspan="5">Total </td>
            <td><?php echo number_format($tot_bpjs_k); ?></td>
            <td><?php echo number_format($tot_jht_k); ?></td>
            <td><?php echo number_format($tot_jp_k); ?></td>


            <td><?php echo number_format($tot_bpjs_pk) ?> </td>
            <td><?php echo number_format($tot_jkk_pk) ?> </td>
            <td><?php echo number_format($tot_jht_pk) ?> </td>
            <td><?php echo number_format($tot_jkm_pk) ?> </td>
            <td><?php echo number_format($tot_jp_pk) ?> </td>
        </tr>
    </tfoot>


</table>