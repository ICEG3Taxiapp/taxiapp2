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
      <script>
    function sendData(tourId){
        document.getElementById("tourId").value=String(tourId);
        //alert(tourId);
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
     <div class="container">
       <br> 
</div>
	<br>
<?php
         
function getTours(){
    $tours = array();
     $id = $_SESSION['userId'];
    //SELECT request_id FROM `hire_request` WHERE contact_no = "$id"
    $query = mysql_query("select driver.name,driver.contact_no,hire_request.date,hire_request.time,hire_request.num_of_passengers,tour.charge,tour.tour_id,tour.TCompleted FROM tour INNER JOIN hire_request ON tour.request_id = hire_request.request_id INNER JOIN driver ON driver.driver_id = tour.driver_id WHERE tour.request_id IN (SELECT hire_request.request_id FROM `hire_request` WHERE contact_no = '$id')");
    
    while($row = mysql_fetch_array($query)){ // display all rows  from query
		$tourRow = array();
		$tourRow[0] = $row['contact_no'];
		$tourRow[1] = $row['date'];
		$tourRow[2] = $row['time'];
        $tourRow[3] = $row['num_of_passengers'];
        $tourRow[4] = $row['charge'];
        $tourRow[5] = $row['tour_id'];
        $tourRow[6] = $row['name'];
        $tourRow[7] = $row['TCompleted'];
        if($tourRow[7] == 1){
            $tourRow[7] = "disabled";
        }else{
            $tourRow[7] = "";
        }
        $tours[]= $tourRow;
       
    }
    return $tours;
}
?>
    
    <div class="container">

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
										<td align="center"><button href="#" class="btn btn-sm btn-warning" onclick="sendData(<?php echo $tour[5]?>)" data-toggle="modal" data-target="#basicModal3" <?php echo $tour[7]?> > Give Feedback</button></td>
									 </tr>
									
						
						<?php
							}
						?>
                    
                    </table>
                    </div>
                    <br>
                
            </div>
        </div>
        
        <!--Modal for bid -->
                <div class="modal fade" id="basicModal3" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">close x</button>
                        <h4 class="modal-title" id="myModalLabel">Feedback </h4>
                      </div>
                    <div class="modal-body">
                    
                    <pre id="bid">Give your feedback on tour</pre>
                    <div class="container" style="width:500px;">
                      <form method="POST" action="addFeedback.php" method ="post" id ="myform">
                          <input type="hidden" name="tourId" id="tourId" class="form-control" value =""/>
                          <select name="rating" id="rating" class="form-control">
                          <option value="5">5</option>
                          <option value="4">4</option>
                          <option value="3">3</option>
                          <option value="2">2</option>
                            <option value="1">1</option>
                            </select>
                          <textarea style="width:480px;" name="feedBack" form="myform">Enter your feedback...</textarea>
                          <button  type="submit">Done</button>
                            
                      </form>
                     </div>
                    
                    </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

	
</body>

</html>
