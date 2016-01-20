<?php
//echo $_GET["reqId"];
include "header.php";

function getBids(){
    $bids = array();
     //$id = $_SESSION['userId'];
    $reqId = $_GET["reqId"];
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
<html>
    <head>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
<body>
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
                                            <button type="button" value="<?php echo $bid[2] ?>" class="btn-success">Accept Ride</button> 
                                        </td>
									 </tr>
									
						
						<?php
							}
						?>
                    
                    </table>
    
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
                    window.top.location.assign("seeBids.php");
        });
    });

});
        </script>
    
    </body>
</html>