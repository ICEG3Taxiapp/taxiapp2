<?php
/**
 * Created by PhpStorm.
 * User: manesh
 * Date: 12/16/15
 * Time: 12:42 PM
 */
ini_set('display_errors','On');
session_start();
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
    <title>Sign up</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
</head>

<body>
<div class="container-fluid" style="align-items: center">
    <div style="padding-top:40px;padding-left: 540px;padding-bottom: 50px">
        <h2 style="display:inline; font-family:serif; padding-right:50px;" class="form-signup-heading" style="alignment">Sign up as a driver</h2>
        <img src="Images/car.gif"  height="50" width="50">
    </div>

    <div class="col-md-9" style="padding-left: 450px">
        <form class="form-group" id="sign_up_form" action="driverSignUp.php" method="POST">
            <label for="id" class="control-label">Enter Your ID</label>
            <input type="text" name="id" id="id" class="form-control" placeholder="User ID" required autofocus>
            <label for="name" class="control-label" style="padding-top: 20px">Enter Your Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required autofocus>
            <label for="contactNo" class="control-label" style="padding-top: 20px">Enter Your Contact No</label>
            <input type="text" name="contactNo" id="contactNo" class="form-control" placeholder="Contact No" onfocusout ="validateNumber()" required autofocus>
            <label for="nic" class="control-label" style="padding-top: 20px">Enter Your NIC No</label>
            <input type="text" name="nic" id="nic" class="form-control" placeholder="NIC No" onfocusout="validateNIC()" required autofocus>
            <label for="password" class="control-label" style="padding-top: 20px">Enter Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autofocus>
            <label for="reenterPassword" class="control-label" style="padding-top: 20px">Re-enter Password</label>
            <input type="password" name="repeatPassword" id="repeatPassword" class="form-control" placeholder="Re-enter password" required autofocus>
            <label for="vehicleNo" class="control-label" style="padding-top: 20px">Enter Your Vehicle Registration No</label>
            <input type="text" name="vehicleNo" id="vehicleNo" class="form-control" placeholder="Vehicle No" required autofocus>
            <label for="vehicleType" class="control-label" style="padding-top: 20px">Select Your Vehicle Type</label>
<!--            <input type="text" name="vehicleType" id="vehicleType" class="form-control" placeholder="Vehicle Type" required autofocus>-->
            <div class="dropdown" >
                    <select name="vehicleType" id="vehicleType" onfocus="clearNumPassengers()" required>
                        <option value="3 Wheeler">3 Wheeler</option>
                        <option value="Car">Car</option>
                        <option value="Van">Van</option>
                    </select>
            </div>

            <label for="maxPassenger" class="control-label" style="padding-top: 20px">Enter Maximum Number of Passengers</label>
            <input type="text" name="maxPassengers" id="maxPassengers" class="form-control" placeholder="Maximum Passengers" onfocusout="validateMaxPassengers()" required autofocus>
             <label for="showMap" class="control-label" style="padding-top: 20px">Select Default Location To Filter Hire Requests</label>
            <button name="showMap" type="button" id="showMap" class="btn btn-primary btn-block" onclick="setTimeout(initialize, 500);" data-toggle="modal" data-target="#basicModal">Map</button>
            <input type="hidden" id="startLat" name="startLat" value="initial" />
            <input type="hidden" id="startLong" name="startLong" value="initial" />
            <br>
            <div class=container-fluid style="padding-left: 150px">
                <div class="col-md-4">
                    <button class="btn btn-success" id="submitButton" type="submit" disabled>Submit</button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>
  <!--Modal for map -->
                <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">close x</button>
                        <h4 class="modal-title" id="myModalLabel">Default Location</h4>
                      </div>
                    <div class="modal-body">
                    <pre id="distance_duration">Select the default location to filter hire requests</pre>
                    
                    
                    <div id="googleMap" style="width:500px;height:400px; margin:auto; border: 5px solid #73AD21; padding: 15px;"></div>
                    </div>
                      <div class="modal-footer">
                        <a href="#" type="button" class="btn btn-primary" data-dismiss="modal" onclick="addDataToForm(markerStart.getPosition().lat(),markerStart.getPosition().lng());">Ok</a>
                      </div>
                    </div>
                  </div>
                </div>
<script>
    function validateNumber() {
        var num = (document.getElementById("contactNo").value);
        if(num.length == 10){
            if(isNaN(num)){
                alert("Number should contain digits only!");
                document.getElementById("contactNo").value="";
            }
        }
        else {
            alert("Wrong number. Number should contain 10 digits!");
            document.getElementById("contactNo").value="";
        }

    }
    function validateNIC(){
        var nic = (document.getElementById("nic").value);
        if(nic.length == 10){
            var num = nic.substring(0,9);
            var letter = nic.substring(9,10);
            if(isNaN(num)){
                alert("NIC number should contain 9 digits followed by a letter!");
                document.getElementById("nic").value="";
            }
            else if(!(letter == "V" || letter == "v" || letter == "X" || letter == "x")){
                alert("NIC contains wrong letter!");
                document.getElementById("nic").value="";
            }
        }
        else {
            alert("Wrong NIC number!");
            document.getElementById("nic").value="";
        }
    }
    function validateMaxPassengers(){
        var num = (document.getElementById("maxPassengers").value);
        var vehicle = (document.getElementById("vehicleType").value);
        if((vehicle == "Car") && (num < 1 || num > 4)){
            alert("Number of passengers does not match with the vehicle!");
            document.getElementById("maxPassengers").value="";
        }
        else if((vehicle == "Van") && (num < 1 || num > 20)) {
            alert("Number of passengers does not match with the vehicle!");
            document.getElementById("maxPassengers").value="";
        }
        else if((vehicle == "3 Wheeler") && (num < 1 || num > 3)) {
            alert("Number of passengers does not match with the vehicle!");
            document.getElementById("maxPassengers").value="";
        }
    }
    function clearNumPassengers(){
        document.getElementById("maxPassengers").value="";
    }
    var check="false";
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
        center:new google.maps.LatLng(6.933279, 79.849905),
        zoom:13,
        mapTypeId:google.maps.MapTypeId.ROADMAP
      };
      map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
        var infowindowStart = new google.maps.InfoWindow({
            content: 'Default Location'
        });
       
        markerStart = new google.maps.Marker({
            position: new google.maps.LatLng(6.913279, 79.899905),
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
                document.getElementById("submitButton").disabled = false;
                addDataToForm(markerStart.getPosition().lat(),markerStart.getPosition().lng());
                
            } else {
                document.getElementById("submitButton").disabled = true;
                alert("Please select markers properly!!!");
            }
        });
    
    }
    function addDataToForm(startLat,startLong){
        document.getElementById("startLat").value=String(startLat);
        document.getElementById("startLong").value=String(startLong);
    }
    
    </script>

</body>
</html>