<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title></title>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow&callback=intiMap" type="text/javascript"></script>

</head>

<body>

	<?php 
	// echo "<pre>";
	// print_r($absen);
	?>

    <div id="map" style="width: 1400px; height: 800px;"></div>

    <script type="text/javascript">
        var locations = [
            [ '<?php echo str_replace(" ", "", $absen->kar_nm) ?>',  <?php echo $absen->lat_kar ?>, <?php echo $absen->long_kar?>, 1],
            ['Kantor',  <?php echo $absen->lat_unit ?>, <?php echo $absen->long_unit?>, 2],

        ];

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: new google.maps.LatLng(<?php echo $absen->lat_kar ?>, <?php echo $absen->long_kar?>),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        // make new array for icons
        var icons = [
          "https://3.top4top.net/p_1390st3q12.png",
          "https://6.top4top.net/p_1390latqo1.png"
        ]

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
               
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    </script>
</body>

</html>