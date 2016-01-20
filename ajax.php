<?php
include "header.php";
if (isset($_POST['driverId'])) {
   $requestId = $_SESSION['requestId'];
    $driverId = $_POST['driverId'];
    //$bid = $_POST['bid'];
    //$driverId = $_POST['driverId'];
    $id = $_SESSION['userId'];
    $name = $_SESSION['name'];
    
    $queryup = mysql_query("UPDATE `taxiapp`.`hire_request` SET `completed` = '1' WHERE `hire_request`.`request_id` = '$requestId'");
    
    $query = mysql_query("SELECT `driver_id`,`name`,`request_id`,`bid`,`contact_no` FROM driverbid NATURAL JOIN driver WHERE request_id = '$requestId' AND driver_id = '$driverId'");
      while($row = mysql_fetch_array($query)){ // display all rows  from query
		$driverName = $row['name'];
		$driverId = $row['driver_id'];
		$bid = $row['bid'];
        $contact_no = $row['contact_no'];
       
    }
    
    $result = mysql_query("INSERT INTO `taxiapp`.`tour` ( `charge`, `driver_id`, `request_id`) VALUES ( '$bid', '$driverId', '$requestId')");
    
    $result2 = mysql_query("INSERT INTO `taxiapp`.`driver_inbox` (`driver_id`, `message`) VALUES ('$driverId', '$name has accept your request for a taxi ride. Contact: $id')");
    
    echo $contact_no;
}

?>