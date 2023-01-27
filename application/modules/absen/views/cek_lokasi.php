
<!-- Menghubungkan dengan view template master -->



<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Data Karyawan</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
  body {
      /* font: 20px Montserrat, sans-serif; */
     /* line-height: 1.8;

      padding: : 10px;*/

    }
  p {font-size: 16px;}
 .margin {margin-bottom: 45px;}
 .bg-1 {
   background-color: #1abc9c; /* Green */
   color: #ffffff;
 }

  .navbar {
    background-color: black;
    padding-top: 15px;
    padding-bottom: 15px; */
   border: 0;
    border-radius: 0;
    margin-bottom: 0;
    font-size: 12px;
    letter-spacing: 5px;
  }
  .navbar-nav  li a:hover {
    color: #1abc9c !important;
  }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
    </div>
    <!-- <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">WHO</a></li>
        <li><a href="#">WHAT</a></li>
        <li><a href="#">WHERE</a></li>
      </ul>
    </div> -->
  </div>
</nav>



<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
       <center><h3> Data Karyawan</h3><center>
     <!--  <div style="overflow-y: auto;"> -->
      <div class="table-responsive">
      <table id="example" class="table-striped table-bordered table " >
            
                <thead>
                   <tr>
                    <th>No</th>
					<th>Nama</th>
          <th>Kar ID</th>
					<th>Divisi</th>
					<th>Penempatan</th>
					<th>Lat Kantor</th>
					<th>Long Kantor</th>

					<th>Lat Rumah</th>
					<th>Long Rumah</th>
				<!-- 	<th>Lihat Maps</th> -->
					<th>Ubah</th>
	

                   </tr>
                 </thead>
                 <tbody>
                          	<?php
			$no=1; 
			foreach($absen as $a){
		   ?>		

		   <tr>

		   	<td><?php echo $no++;?></td>
		    <td><?php echo $a->kar_nm;?></td>
        <td><?php echo $a->kar_id;?></td>
		   	<td><?php echo $a->div_nm;?></td>
		   	<td><?php echo $a->ktr_nm;?></td>
		   	<td><?php echo $a->ktr_lat;?></td>
		   	<td><?php echo $a->ktr_long;?></td>

		   	<td><?php echo $a->kar_lat;?></td>
		   	<td><?php echo $a->kar_long;?></td>
		   <!-- 	<td><a href="<?php echo base_url('absen/cb/lihat_maps/'.$a->ktr_id)?>">Lihat Maps</a></td> -->
		   	<td><a href="<?php echo base_url('absen/cb/ubah/'.$a->kar_id)?>">Ubah</a></td>
		   	</tr>
		   <?php
			}?>
		
                      
                 </tbody>

            </table>
          </div>



  <!-- <h3 class="margin">Where To Find Me?</h3><br>
  <div class="row">
    <div class="col-sm-4">
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      <img src="birds1.jpg" class="img-responsive margin" style="width:100%" alt="Image">
    </div>
    <div class="col-sm-4">
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      <img src="birds2.jpg" class="img-responsive margin" style="width:100%" alt="Image">
    </div>
    <div class="col-sm-4">
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      <img src="birds3.jpg" class="img-responsive margin" style="width:100%" alt="Image">
    </div>
  </div> -->
</div>

<!-- Footer -->
<!-- <footer class="container-fluid bg-4 text-center">
  <p>Bootstrap Theme Made By <a href="https://www.w3schools.com">www.w3schools.com</a></p>
</footer> -->


<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<!-- <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script> -->
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#example').DataTable( {
        responsive: true
    } );

    new $.fn.dataTable.FixedHeader( table );
});
</script>

</body>
</html>
