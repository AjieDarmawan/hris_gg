<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

</head>
<body>

<form method="post" action="<?php echo base_url('absen/Cb/simpan_ubah')?>"> 
<center>Ubah Data Penempatan</center>

<label>Penempatan Kantor </label>

<select id="single" class="js-states form-control" name="ktr_id">
	<?php 
		foreach($kantor as $k)
		{

			if($k->ktr_id==$ktr_id){
				$selected = 'selected';
			}else{
				$selected = '';
			}
	 ?>

	 	<option value="<?php echo $k->ktr_id?>" <?php echo $selected?>><?php echo $k->ktr_nm?></option>


    <?php			
		}
	?>

	<input type="hidden" name="kar_id" value="<?php echo $kar_id;?>">

	<br><br><br>

	<button type="submit">Simpan</button>
</select>
</form>


<br>


<hr>

<h3>Alamat Rumah</h3>


<div id="googleMap" style="width:100%;height:600px;"></div>

<div class="container">
    <form method="post">
         <label>Ubah Titik Kordinat</label>

         <input name="lat" value="<?php echo $lat?>">
         <input name="long" value="<?php echo $long;?>">
         <input type="submit" value="CEK" name="CEK"/>
         <input type="submit" value="simpan" name="simpan" class="btn btn-primary btn-sm"/>
         <a  class="btn btn-primary btn-sm" href="<?php echo base_url('absen/Cb/cek_lokasi')?>">Kembali</a>

    </form>

    <?php 
	 $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=true&key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow";

	$ch = curl_init($url);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json', // if the content type is json
            //  'bearer: '.$token // if you need token in header
        )
    );
    //  curl_setopt($ch, CURLOPT_HEADER, false);
    //curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    curl_close($ch);

    //   return $result;

    $output = json_decode($result);
	
	// echo "<pre>";
	// print_r($output->results[0]->formatted_address);

?>

<h3><?php echo $output->results[0]->formatted_address ?></h3>


</div>




<script>
function myMap() {

    var myCenter = new google.maps.LatLng(<?php echo $lat?>, <?php echo $long;?>);

    var mapProp = {
        center: myCenter,
        zoom: 18,
        mapTypeId: google.maps.MapTypeId.HYBRID
    };
    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

  

    var marker = new google.maps.Marker({
        position: myCenter,
        animation:google.maps.Animation.BOUNCE
    });

    var myCity = new google.maps.Circle({
  center:myCenter,
  radius:150,
  strokeColor:"#0000FF",
  strokeOpacity:0.8,
  strokeWeight:2,
  fillColor:"#FF0040",
  fillOpacity:0.4
});



    marker.setMap(map);
    myCity.setMap(map);

    
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow&callback=myMap">
</script>


  <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
      $("#single").select2({
          placeholder: "Select a programming language",
          allowClear: true
      });
      
    </script>

</body>
</html>