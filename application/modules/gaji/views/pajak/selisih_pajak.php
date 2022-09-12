<table border="1">
    <thead>
        <th>No</th>
        <th>Nama</th>
        <th>Pajak</th>
        <th>Pajak Testing</th>
    </thead>

    <tbody>
        <?php
        $no = 1;
        foreach ($data_kar as $k) {

            if($k->pph_dibayar != $k->nominal){
                $colom = 'style="
                background: red;
            "';
            }else{
                $colom = '';
            }
        ?>

          <tr>
             <td <?php echo $colom;?>><?php echo $no++;?></td>
             <td><?php echo $k->kar_nm;?></td>
             <td><?php echo $k->pph_dibayar;?></td>
             <td><?php echo $k->nominal;?></td>
          </tr>

        <?php
        }
        ?>
    </tbody>
</table>