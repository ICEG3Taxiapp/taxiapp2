<?php
include "header.php";
if (isset($_POST['requestId'])) {
        //$_SESSION['requestId'] = $_POST['requestId'];
    }
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <title>passengerProfile</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
     
<script>
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
        
      function sendData(startLat,startLong,endLat,endLong){
        document.getElementById("startLat").value=String(startLat);
        document.getElementById("startLong").value=String(startLong);
        document.getElementById("endLat").value=String(endLat);
        document.getElementById("endLong").value=String(endLong);
        
      } 

        function sendBidData(requestId){
            var reqId = requestId;
            //alert(reqId);
            $(document).ready(function(){
            data =  {
                    'requestId': reqId
                    };
                $.post('GlobalUpdate.php', data, function (response) {
                    //alert(reqId);
                    document.getElementById("myO").data = "modelView.php?reqId="+reqId;
            });
        });
        }

      </script>

    </head>
    
    
    <body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <img src="images/car.gif"  height="50" width="50">
          <a class="navbar-brand" href="#">Taxi-App Welcome <?php echo $_SESSION['name'] ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="passengerProfile.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="seeBids.php">My reqests</a></li>
            <li><a href="seeTours.php">My Tours</a></li>
          </ul>
        <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" action="footer.php">
            <button type="submit" class="btn btn-danger">Sign Out</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
    <br>
    <br>
    <br>
	<br>
<?php
    /*$id = $_SESSION['userId'];
    $query = mysql_query("SELECT `name`,`request_id`,`bid` FROM driverbid NATURAL JOIN driver WHERE request_id IN (SELECT request_id FROM hire_request NATURAL JOIN passenger WHERE `passenger`.`contact_no` = '$id')");
    @$exist = mysql_num_rows($query);
        if($exist > 0){
            
            $dynamicList = "";
            while($row = mysql_fetch_array($query)){ // display all rows  from query
                $name = $row['name'];
                $bid = $row['bid'];
                $request_id = $row['request_id'];
                 $dynamicList .= "<tr><td>$name</td>
                                    <td>$bid</td>
                                    <td>
                                        <button type='submit' name='Accept'>Accept</button>
                                    </td>
                                    </tr>";
            }
        }*/
         
function getBids(){
    $bids = array();
     //$id = $_SESSION['userId'];
    $reqId = $_SESSION['requestId'];
    $query = mysql_query("SELECT `driver_id`,`name`,`request_id`,`bid` FROM driverbid NATURAL JOIN driver WHERE request_id = $reqId");
    
    while($row = mysql_fetch_array($query)){ // display all rows  from query
		$bidRow = array();
		$bidRow[0] = $row['name'];
		$bidRow[1] = $row['bid'];
		$bidRow[2] = $row['driver_id'];
        
		 
        $bids[]= $bidRow;
       
    }
    return $bids;
}
?>
    
        
<?php
function getMyRequests(){
    $requests = array();
    $id = $_SESSION['userId'];
   $query = mysql_query("SELECT request_id, start_loc_long, start_loc_lat, destination_long, destination_lat, date, time, num_of_passengers, max_bid, contact_no FROM hire_request WHERE request_id NOT IN (SELECT request_id FROM tour) AND contact_no = '$id'");
    
    while($row = mysql_fetch_array($query)){ // display all rows  from query
		$requestRow = array();
		$requestRow[0] = $row['request_id'];
		$requestRow[1] = $row['start_loc_long'];
		$requestRow[2] = $row['start_loc_lat'];
		$requestRow[3] = $row['destination_long'];
		$requestRow[4] = $row['destination_lat'];
		$requestRow[5] = $row['date'];
		$requestRow[6] = $row['time'];
		$requestRow[7] = $row['num_of_passengers'];
		$requestRow[8] = $row['max_bid'];
		$requestRow[9] = $row['contact_no'];
		 
        $requests[]= $requestRow;
        
       
    }
    return $requests;
}
?>
        
 <div class="container" >
                
                    
                    <br>
                    <div class="panel panel-primary">
                    <div class="panel-heading">Hire Request</div>
                    <table class="table table-striped">
						<th>Hire ID</th>
						<th>Date</th>
                        <th>Time</th>
                        <th>No of Passengers</th>
						<?php
							$hireRequests =getMyRequests();
							
							foreach ($hireRequests as $request) {
						?>
								
									<tr>
										<td><?php echo $request[0] ?></td>
										<td><?php echo $request[5] ?></td>
										<td><?php echo $request[6] ?></td>
										<td><?php echo $request[7] ?></td>
                                        <td align="center">
                                            <button type ="button" href="#" onclick="sendBidData(<?php echo $request[0]?>)" class="btn btn-info btn-lg" data-toggle="modal" data-target="#basicModal2">See Bids</button>
                                        </td>
                                        <td><a href="#" class="btn btn-lg btn-success" onclick="sendData(<?php echo $request[2]?>,<?php echo $request[1]?>,<?php echo $request[4]?>,<?php echo $request[3]?>);setTimeout(initialize, 500);" data-toggle="modal" data-target="#basicModal">Map</a></td>
									 </tr>
									
						
						<?php
							}
						?>
                    
                    </table>
                    </div>
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
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">close x</button>
                        <h4 class="modal-title" id="myModalLabel">See my requests</h4>
                      </div>
                    <div class="modal-body">
                    <div class="container">
                
                    <br>
                    <br>
                    <br>
                    <div class="panel panel-primary" style="width:75%;">
                    <div class="panel-heading">My Requests</div>
                    <object id="myO" type="text/html" data=""  style="width:100%; overflow:auto;border:5px "></object>
            </div>
        </div>
    
                    
                    </div>
                    </div>
                </div>
         
</body>

</html>