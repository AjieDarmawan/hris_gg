<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 

  <!-- AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAv55eTFQnFNA_nnzzDlGwJ0xJLg7shyow&callback=initMap" 
          type="text/javascript"></script>
</head> 
<body>
  <div id="map" style="width: 1100px; height: 600px;"></div>

  <script type="text/javascript">
    var locations = [
      ['Ajie', -6.5776589, 106.8528452],
      ['Aprea', -6.5776588, 106.8528448],
      ['Cronulla Beach', -34.028249, 151.157507, 3],
      ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
      ['Maroubra Beach', -33.950198, 151.259302, 1]
    ];
    
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    
    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    
    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
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