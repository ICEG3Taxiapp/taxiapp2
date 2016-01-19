<?php
include"header.php";

$driverId=$_POST['driver_id'];
$driverInboxId=$_POST['driver_inbox_id'];
$status = "";
echo $driverId." ".$driverInboxId;
mysql_query("START TRANSACTION");
$query = mysql_query("UPDATE driver_inbox SET is_viewed = TRUE WHERE driver_id = '$driverId' AND driver_inbox_id = '$driverInboxId'");
if ($query) {
		mysql_query("COMMIT");
	} else {        
		mysql_query("ROLLBACK");
	}
	header('location:homeDriver.php');
?>

