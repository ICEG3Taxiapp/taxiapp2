 <?php
include "header.php";
$driver_id = $_SESSION['userId'];
$driver_name = $_SESSION['name'];
$sql = "SELECT * FROM driver WHERE driver_id='$driver_id'";
$result= mysql_query($sql);
$longLat = mysql_fetch_array($result);
if(mysql_num_rows($result)>0){
  $startLong= $longLat['longitude'];
  $startLat= $longLat['lattitude'];
}
else{
  $startLat= 6.9383911;
  $startLong= 80.070661;
  echo "<script>alert('Your default locations are not set. Please select properly!!!');</script>";
  //echo "<script>window.top.location.assign('homeDriver.php')</script>";
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
    <link rel="icon" href="../../favicon.ico">
    <script type="text/javascript" src="js/Functions.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
</head>
<body>
  <div class="container" style="position:absolute; top:2%; left:8%;">
  <div class="">
      <h4 class="modal-title" id="myModalLabel">Default Location</h4>
      </div>
    <div class="span12">
    <pre id="distance_duration">Your default location is shown on the map. If you want to change it drag the marker and press OK. </pre>
    
    
    <div id="googleMap" style="width:500px;height:400px; margin:auto; border: 5px solid #73AD21; padding: 15px;"></div>
    </div>
      <div class="btn-group " style="position:absolute; right:10%;">
        <button type="button" class="btn btn-primary" onclick="window.location.assign('changeLocation.php?startLat='+markerStart.getPosition().lat()+'&startLong='+markerStart.getPosition().lng())">Ok</button>
        <button type="button" class="btn btn-danger" onclick="window.top.location.assign('homeDriver.php')">Cancel</button>
       </div>
    </div>
  <script>
 var map;
    var markers = [];
    var gLocation; //geo location of the customer
    var labels ='Taxi';
    var markerStart;
    var markerEnd;
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    function initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer({
    polylineOptions: {
      strokeOpacity: 0.00001,
      strokeWeight: 0
    },
    preserveViewport: true
  });
    directionsDisplay.setMap(map);
      var mapProp = {
        center:new google.maps.LatLng(<?php echo $startLat ?>, <?php echo $startLong ?>),
        zoom:13,
        mapTypeId:google.maps.MapTypeId.ROADMAP
      };
      map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
        var infowindowStart = new google.maps.InfoWindow({
            content: 'Default Location'
        });
       
        markerStart = new google.maps.Marker({
            position: new google.maps.LatLng(<?php echo $startLat ?>, <?php echo $startLong ?>),
            map: map,
            draggable: true
          });
            infowindowStart.open(map, markerStart);
        markerEnd = new google.maps.Marker({
            position: new google.maps.LatLng(6.9383911, 80.070661),
            map: map
          });
        
        google.maps.event.addListener(markerStart, 'dragend', function() { calcRoute(markerStart.getPosition().lat(),markerStart.getPosition().lng(),6.9383911, 80.070661); } );
        markerEnd.setVisible(false);
        markers.push(markerStart);
        markers.push(markerEnd);
    }
    function calcRoute(startLat,startLong,endLat,endLong) {
        var start = new google.maps.LatLng(startLat, startLong);
        var end = new google.maps.LatLng(endLat, endLong);
        /*var bounds = new google.maps.LatLngBounds();
        bounds.extend(start);
        bounds.extend(end);
        map.fitBounds(bounds);*/
        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(map);
                directionsDisplay.setOptions( { suppressMarkers: true } );
                
            } else {
                alert("Please select markers properly!!!");
            }
        });
    
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
 </body>