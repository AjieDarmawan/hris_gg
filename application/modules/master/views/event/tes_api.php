<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
	</head>

    <?php 
    //    header('Access-Control-Allow-Origin: *'); 
    //    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    //    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

    header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
    ?>
<script>
	
  $.ajax({
        type: 'GET',
         url: "https://backendtryout.edunitas.com/api_mobile/api/event",
       // url: "https://dev-api.edunitas.com/banner",
        contentType: 'application/json',
        
        dataType:'JSON',
       
      
       
        success: function(data) {
            console.log(data);
        },
        error: function(error) {
            console.log("FAIL....=================");
        }
    });

  
</script>