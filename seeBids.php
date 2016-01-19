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
    <title>passengerProfile</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
     
    <script>
    function sendBidData(requestId){
        var reqId = requestId;
        alert(reqId);
        $(document).ready(function(){
        data =  {
                'requestId': reqId
                };
            $.post('GlobalUpdate.php', data, function (response) {
                alert(reqId);
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
       <br> <br> <br> 
  <ul class="nav nav-pills" role="tablist">
    <li><a href="passengerProfile.php">Home</a></li>
    <li class="active"><a href="#">See Driver Bids</a></li>     
  </ul>
</div>
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
        
 <div class="container">
            <div class="jumbotron">
                
                    <br>
                    <br>
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
                                            <form action="modelView.php" method="post">
                                            <input type="hidden" name="reqId" value="<?php echo $request[0]?>">
                                            <button type ="submit" href="#" onclick="sendBidData(<?php echo $request[0]?>)" class="btn btn-info btn-lg" data-toggle="modal" data-target="#basicModal2">See Bids</button>
                                            </form>
                                        </td>
									 </tr>
									
						
						<?php
							}
						?>
                    
                    </table>
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
                    <div class="panel-heading">Hire Request</div>
                    <table class="table table-striped">
						<th>Driver Name</th>
						<th>Bid</th>
						<?php
							$hireBids = getBids();
							
							foreach ($hireBids as $bid) {
						?>
								
									<tr>
										<td><?php echo $bid[0] ?></td>
										<td><?php echo $bid[1] ?></td>
										<td>
                                            <form>
                                            <button type="submit" value="<?php echo $bid[2] ?>" class="btn-success">Accept Ride</button> 
                                            </form>
                                        </td>
									 </tr>
									
						
						<?php
							}
						?>
                    
                    </table>
                        </div>
                        <?php
                            echo $_SESSION['requestId'];
                        ?>
            </div>
        </div>
        
        <script>
            $(document).ready(function(){
                $('.btn-success').click(function(){
                    var clickBtnValue = $(this).val();
                    var ajaxurl = 'ajax.php',
                    data =  {
                                'driverId': clickBtnValue
                            };
                    $.post(ajaxurl, data, function (response) {
                    alert("You have suuccessfully booked a taxi");
        });
    });

});
        </script>
    
                    
                    </div>
                    </div>
                  </div>
                </div>
         
</body>

</html>