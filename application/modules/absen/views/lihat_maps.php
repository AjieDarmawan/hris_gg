
<div id="googleMap" style="width:100%;height:600px;"></div>

<div class="container">
    <form method="post">
         <label>Ubah Titik Kordinat</label>

         <input name="lat" value="<?php echo $lat?>">
         <input name="long" value="<?php echo $long;?>">
         <input type="submit" value="CEK" name="CEK"/>
         <input type="submit" value="simpan" name="simpan" class="btn btn-primary btn-sm"/>
         <a  class="btn btn-primary btn-sm" href="<?php echo base_url('absen/Cb/kantor')?>">Kembali</a>

    </form>
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