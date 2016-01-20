<?php
    include "header.php";
    $rating = $_POST["rating"];
    $feedBack = $_POST["feedBack"];
    $tourId = $_POST["tourId"];
    
    mysql_query("UPDATE `taxiapp`.`tour` SET `feedback` = '$feedBack', `rating` = $rating WHERE tour_id = $tourId");
    $queryF = mysql_query("SELECT driver_id FROM `tour` WHERE tour_id = $tourId");
     while($row = mysql_fetch_array($queryF)){ // display all rows  from query
		$driverId = $row['driver_id'];
    }
    mysql_query("INSERT INTO `taxiapp`.`driver_inbox` (`driver_id`, `message`) VALUES ('$driverId', 'Passnger has rated you rating = .$rating.')");
    
?>