<?php
include"header.php";

$driverId=$_POST['driver_id'];
$driverInboxId=$_POST['driver_inbox_id'];
$status = "";
echo $driverId." ".$driverInboxId;
$query = mysql_query("UPDATE driver_inbox SET is_viewed = TRUE WHERE driver_id = '$driverId' AND driver_inbox_id = '$driverInboxId'");
	header('location:homeDriver.php');
?>

