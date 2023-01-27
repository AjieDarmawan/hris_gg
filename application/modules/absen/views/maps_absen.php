<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title></title>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow&callback=intiMap" type="text/javascript"></script>

</head>

<body>

	<?php 
	
	?>

    <div id="map" style="width: 1400px; height: 800px;"></div>

    <script type="text/javascript">
      function initMap() {

//          var myCenter = new google.maps.LatLng(<?php echo $absen->lat_unit ?>, <?php echo $absen->long_unit?>);

//     var mapProp = {
//         center: myCenter,
//         zoom: 18,
//         mapTypeId: google.maps.MapTypeId.HYBRID
//     };
//     var map_kor = new google.maps.Map(document.getElementById("map"), mapProp);

  

//     var marker = new google.maps.Marker({
//         position: myCenter,
//         animation:google.maps.Animation.BOUNCE
//     });

//     var myCity = new google.maps.Circle({
//   center:myCenter,
//   radius:150,
//   strokeColor:"#0000FF",
//   strokeOpacity:0.8,
//   strokeWeight:2,
//   fillColor:"#FF0040",
//   fillOpacity:0.4
// });



//     marker.setMap(map_kor);
//     myCity.setMap(map_kor);







       
    var pointA = new google.maps.LatLng( <?php echo $absen->lat_kar ?>, <?php echo $absen->long_kar?>),
        pointB = new google.maps.LatLng(<?php echo $absen->lat_unit ?>, <?php echo $absen->long_unit?>),
        myOptions = {
            zoom: 7,
            center: pointA
        },
        map = new google.maps.Map(document.getElementById('map'), myOptions),
        // Instantiate a directions service.
        directionsService = new google.maps.DirectionsService,
        directionsDisplay = new google.maps.DirectionsRenderer({
            map: map
        }),
        markerA = new google.maps.Marker({
            position: pointA,
            title: "Karyawan",
            label: "<?php echo $absen->kar_nm ?>",
            map: map
        }),
        markerB = new google.maps.Marker({
            position: pointB,
            title: "point B",
            label: "<?php echo $absen->ktr_nm ?>",
            map: map
        });


         var myCity = new google.maps.Circle({
  center:pointB,
  radius:500,
  strokeColor:"#0000FF",
  strokeOpacity:0.8,
  strokeWeight:2,
  fillColor:"#FF0040",
  fillOpacity:0.4
});

          myCity.setMap(map);

    // get route from A to B
    calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);



}



function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
    directionsService.route({
        origin: pointA,
        destination: pointB,
        avoidTolls: true,
        avoidHighways: false,
        travelMode: google.maps.TravelMode.DRIVING
    }, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}

initMap();
    </script>
</body>

</html>