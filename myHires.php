

<?php
	include "tableaccess.php";
	$driver_id = $_SESSION['userId'];
	$driver_name = $_SESSION['name'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <script type="text/javascript" src="js/Functions.js"></script>
    <title>Taxi-app Driver Home</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/style.css">


<script type="text/javascript">
	var map;
  var markers = [];
  var gLocation; //geo location of the customer
  var labels ='Taxi';
  var startImage = 'Images/start3.png';
  var endImage = 'Images/end.png';
  var markerStart;
  var markerEnd;
  var directionsDisplay;
  var directionsService = new google.maps.DirectionsService();
   function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer({
    polylineOptions: {
      strokeColor: "purple"
    }
  });
    directionsDisplay.setMap(map);
    var mapProp = {
    center:new google.maps.LatLng(document.getElementById("startLat").value, document.getElementById("startLong").value),
    zoom:12,
    mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
    var centerControlDiv = document.createElement('div');
    centerControlDiv.index = 1;
    centerControlDiv.style['padding-top'] = '10px';
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
    var infowindowStart = new google.maps.InfoWindow({
      content: 'Start'
    });
    var infowindowEnd = new google.maps.InfoWindow({
      content: 'End'
    });
    markerStart = new google.maps.Marker({
      position: new google.maps.LatLng(document.getElementById("startLat").value, document.getElementById("startLong").value),
      map: map,
      icon: startImage
      });
    markerStart.setVisible(false);
    infowindowStart.open(map, markerStart);
    markerEnd = new google.maps.Marker({
      position: new google.maps.LatLng(document.getElementById("endLat").value, document.getElementById("endLong").value),
      map: map,
      icon: endImage
      });
    markerEnd.setVisible(false);
      infowindowEnd.open(map, markerEnd);
      markers.push(markerStart);
      markers.push(markerEnd);
      calcRoute(document.getElementById("startLat").value, document.getElementById("startLong").value,document.getElementById("endLat").value, document.getElementById("endLong").value);
  }
  function calcRoute(startLat,startLong,endLat,endLong) {
        var start = new google.maps.LatLng(startLat, startLong);
        //var end = new google.maps.LatLng(38.334818, -181.884886);
        var end = new google.maps.LatLng(endLat, endLong);
        var bounds = new google.maps.LatLngBounds();
        bounds.extend(start);
        bounds.extend(end);
        map.fitBounds(bounds);
        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(map);
                var distance = response.routes[0].legs[0].distance.value;
                var distanceKm = (distance/1000).toFixed(0);
                var distanceM = (distance%1000).toFixed(0);
                var duration = response.routes[0].legs[0].duration.value;
                var durationHrs = (duration/3600).toFixed(0);
                var durationMins = (duration%3600/60).toFixed(0);
                document.getElementById('distance_duration').innerHTML ="Distance: "+distanceKm+"Km "+distanceM+"m. Duration: "+durationHrs+"Hrs "+durationMins+ "mins.";
            } else {
                alert("Directions Request from " + start.toUrlValue(6) + " to " + end.toUrlValue(6) + " failed: " + status);
            }
        });

        
    }
    
  function myFunction(requestId) {
		var bid = prompt("Please enter your Bid", "0.00");
		if (bid != null) {
			
			//window.location="MakeBid.php?driverId=<?php echo $driver_id ?>&requestId = 'requestId'&requestId = bid"
			//insertDriverBid(<?php echo $driver_id ?>,requestId,bid);
			
		}
		//document.write(requestId);
		
	}
  function sendData(startLat,startLong,endLat,endLong){
    document.getElementById("startLat").value=String(startLat);
    document.getElementById("startLong").value=String(startLong);
    document.getElementById("endLat").value=String(endLat);
    document.getElementById("endLong").value=String(endLong);
    
  }
  function bidData(requestId){
    document.getElementById("requestId").value=String(requestId);
    document.getElementById("hireId").value=String(requestId);
  }
  
  
</script>

  </head>

  <body>
 
    
    <div class="container" >
            <div class="jumbotron" style="background-color:white;">
                
                    <div class="panel panel-primary" >
                    <div class="panel-heading">My Hires</div>
						
							
							
							<?php
								$hireRequests =getMyHires($driver_id);
								
								if(sizeof($hireRequests) > 0){
							?>
							<table class="table table-condensed">
								<th>Tour ID</th>
								<th>Date</th>
								<th>Time</th>
								<th>Passenger Name</th>
								<th>Contact No</th>
								<th>No of Passengers</th>
								<th>Charges</th>
							
							<?php	
									foreach ($hireRequests as $request) {
							?>
										<tr >
											<td><?php echo $request[0] ?></td>
											<td><?php echo $request[6] ?></td>
											<td><?php echo $request[7] ?></td>
											<td><?php echo $request[8] ?></td>
											<td><?php echo $request[9] ?></td>
											<td><?php echo $request[10] ?></td>
											
											
											<td align="center"><button href="#" class="btn btn-sm btn-success" onclick="bidData(<?php echo $request[0]?>)" <?php echo enableBid($driver_id,$request[1])?> data-toggle="modal" data-target="#basicModal2"> <?php echo getBid($driver_id,$request[1])?></button></td>
											<td><a href="#" class="btn btn-sm btn-success" onclick="sendData(<?php echo $request[3]?>,<?php echo $request[2]?>,<?php echo $request[5]?>,<?php echo $request[4]?>);setTimeout(initialize, 500);" data-toggle="modal" data-target="#basicModal">Map</a></td>
										 </tr>
							<?php	
									}	
															
								}else{
									echo  "<p style=\"font-color: #ff0000;\">No Tours arranged at the moment.Please check available hire requests and bid there </p>";
								}
							?>
						
						</table>
                    </div>
                    <br>
                        </div>
                <!--Modal for map -->
                <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">close x</button>
                        <h4 class="modal-title" id="myModalLabel">Route for the request</h4>
                      </div>
                    <div class="modal-body">
                    <input type="hidden" id="startLat" name="test" value="initial" />
                    <input type="hidden" id="startLong" name="test1" value="initial" />
                    <input type="hidden" id="endLat" name="test2" value="initial" />
                    <input type="hidden" id="endLong" name="test3" value="initial" />
                    <pre id="distance_duration"></pre>
                    
                    
                    <div id="googleMap" style="width:500px;height:400px; margin:auto; border: 5px solid #73AD21; padding: 15px;"></div>
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                 <!--Modal for bid -->
                <div class="modal fade" id="basicModal2" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">close x</button>
                        <h4 class="modal-title" id="myModalLabel">Bid</h4>
                      </div>
                    <div class="modal-body">
                    
                    <pre id="bid">Place your bid</pre>
                    <div class="container" style="width:250px;">
                      <form method="POST" action="CallFunction.php" method ="post">
                          <div style="padding-top:10px;"></div>
                          <input type="hidden" name="hireId" id="hireId" class="form-control" value =""/>
                          <input type="text" name="bid" id="bid" class="form-control"/>
                          <input type="hidden" name="driver_id" value="<?=$driver_id?>" />
                          <input type="hidden" id="requestId" name="requestId" value="" />
                          <button  type="submit">Bid</button>
                            
                      </form>
                     </div>
                    
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

        </div>

		 



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    
  </body>
</html>




