<?php
include "header.php";
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
    <title>passengerProfile</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/style.css">
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
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
          </ul>
        <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" action="footer.php">
            <button type="submit" class="btn btn-danger">Sign Out</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
     <div class="container">
       <br> 
  <ul class="nav nav-pills" role="tablist">
    <li><a href="passengerProfile.php">Home</a></li>
    <li><a href="seeBids.php">See Driver Bids</a></li>
    <li class="active"><a href="#">See my Tours</a></li> 
  </ul>
</div>
	<br>
<?php
         
function getTours(){
    $tours = array();
     $id = $_SESSION['userId'];
    //SELECT request_id FROM `hire_request` WHERE contact_no = "$id"
    $query = mysql_query("select driver.name,driver.contact_no,hire_request.date,hire_request.time,hire_request.num_of_passengers,tour.charge,tour.tour_id FROM tour INNER JOIN hire_request ON tour.request_id = hire_request.request_id INNER JOIN driver ON driver.driver_id = tour.driver_id WHERE tour.request_id IN (SELECT hire_request.request_id FROM `hire_request` WHERE contact_no = '0717673721')");
    
    while($row = mysql_fetch_array($query)){ // display all rows  from query
		$tourRow = array();
		$tourRow[0] = $row['contact_no'];
		$tourRow[1] = $row['date'];
		$tourRow[2] = $row['time'];
        $tourRow[3] = $row['num_of_passengers'];
        $tourRow[4] = $row['charge'];
        $tourRow[5] = $row['tour_id'];
        $tourRow[6] = $row['name'];
		 
        $tours[]= $tourRow;
       
    }
    return $tours;
}
?>
    
    <div class="container">
            <div class="jumbotron">
                
                    <br>
                    <br>
                    <br>
                    <div class="panel panel-primary">
                    <div class="panel-heading">My Tours</div>
                    <table class="table table-striped">
						<th>Driver Name</th>
						<th>Contact Number</th>
                        <th>Date</th>
						<th>Time</th>
                        <th>No of passengers</th>
                        <th>Charge</th>
						<?php
							$hireTours =getTours();
							
							foreach ($hireTours as $tour) {
						?>
								
									<tr>
										<td><?php echo $tour[6] ?></td>
										<td><?php echo $tour[0] ?></td>
                                        <td><?php echo $tour[1] ?></td>
										<td><?php echo $tour[2] ?></td>
                                        <td><?php echo $tour[3] ?></td>
										<td><?php echo $tour[4] ?></td>
										<td>
                                            <button type="submit" value="" class="btn-success">Accept Ride</button>                                             </td>
									 </tr>
									
						
						<?php
							}
						?>
                    
                    </table>
                    </div>
                    <br>
                        </div>
                
            </div>
        </div>
        
        <script>
            $(document).ready(function(){
                $('.btn-success').click(function(){
                    var clickBtnValue = $(this).val();
                    var ajaxurl = 'ajax.php',
                    data =  {'requestId': clickBtnValue};
                    $.post(ajaxurl, data, function (response) {
                    alert("You have suuccessfully booked a taxi");
        });
    });

});
        </script>
	
</body>

</html>
