<?php
/**
 * Created by PhpStorm.
 * User: dineth
 * Date: 12/16/15
 * Time: 10:55 PM
 */
include "header.php";
$driver_id = $_SESSION['userId'];
$startLat=$_GET['startLat'];
$startLong=$_GET['startLong'];

$insertQueryDriver = "UPDATE `driver` SET `longitude`='$startLong',`lattitude`='$startLat' WHERE `driver_id`='$driver_id'";
$resultDriver = mysql_query($insertQueryDriver);

Print '<script>alert("Successfully changed the location!!");</script>'; // prompts user
Print '<script>window.top.location.assign("homeDriver.php");</script>'; // redirects to the login page
