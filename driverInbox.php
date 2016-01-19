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

  </head>

  <body>
 
    
    <div class="container" >
            <div class="jumbotron" style="background-color:white;">
                
                    <div class="panel panel-primary" >
                    <div class="panel-heading">Inbox</div>
						<table class="table table-condensed">
							<th>Message</th>
							
							<?php
								$messages =getAvailableMessages($driver_id);

								$count=sizeof($messages);
                echo "<script>document.getElementById('inboxCount').innerHTML=Inbox ( ".$count." )</script>";
								foreach ($messages as $message) {
							?>
										<tr>
											<td><?php echo $message[1] ?></td>
											<td align="center"><button href="#" class="btn btn-sm btn-success" onclick=""  > OK</button></td>
										</tr>
							<?php		
															
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




