<?php
include"header.php";
function getX($driverId){
    $xCordinates = "";
    $query = mysql_query("SELECT xCornidates FROM `driver` WHERE driver_id = '$driverId'");
    while($row = mysql_fetch_array($query)){ // display all rows  from query
                $xCordinates = $row['xCornidates'];
            }
    return $xCordinates;
}

function getY($driverId){
    $yCordinates = "";
    $query = mysql_query("SELECT yCornidates FROM `driver` WHERE driver_id = '$driverId'");
    while($row = mysql_fetch_array($query)){ // display all rows  from query
                $yCordinates = $row['yCornidates'];
            }
    return $yCordinates;
}

function getHireRequests(){
    $requests = array();
    $query = mysql_query("SELECT request_id, start_loc_long, start_loc_lat, destination_long, destination_lat, date, time, num_of_passengers, max_bid, contact_no FROM hire_request WHERE request_id NOT IN (SELECT request_id FROM tour) ");
    
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

function getAvailability($driverId){
    $status = "";
    $query = mysql_query("SELECT availability FROM `driver` WHERE driver_id = '$driverId'");
    $row = mysql_fetch_array($query);
    if($row['availability'] == 1){
		$status = "ON";
    }else{
	   $status = "OFF";
    }

    return $status;
}

function changeAvailability($driverId){
    $status = "";
    $query = mysql_query("UPDATE driver SET availability = availability XOR 1 WHERE  driver_id = '$driverId'");
    
}
function insertDriverBid($driverId,$requestId,$bid){
	echo $driverId,$requestId,$bid;
    $query = mysql_query("INSERT INTO driverbid (`bid`, `driver_id`, `request_id`) VALUES ('$bid','$driverId','$requestId')");
    
}

function hasBid($driverId,$requestId){
    $query = mysql_query("SELECT bid FROM driverbid WHERE driver_id = '$driverId' AND request_id ='$requestId' ");
    $row = mysql_fetch_array($query);
    if($row['bid'] == NULL){
		return "Bid";
    }else{
	   return "Done";
    }
}
function getBid($driverId,$requestId){
    $query = mysql_query("SELECT bid FROM driverbid WHERE driver_id = '$driverId' AND request_id ='$requestId' ");
    $row = mysql_fetch_array($query);
    if($row['bid'] == NULL){
        return "Bid";
    }else{
       return $row['bid'];
    }
}
function enableBid($driverId,$requestId){
    $query = mysql_query("SELECT bid FROM driverbid WHERE driver_id = '$driverId' AND request_id ='$requestId' ");
    $row = mysql_fetch_array($query);
    if($row['bid'] == NULL){
		return NULL;
    }else{
	   return "disabled";
    }
}

function getBidStatus($driverId,$requestId){
    $query = mysql_query("SELECT hr.completed FROM hire_request hr,driverbid db WHERE  db.request_id = hr.request_id AND db.driver_id = '$driverId' AND hr.request_id ='$requestId' ");
    $row = mysql_fetch_array($query);
    if($row['completed'] == NULL){
		return false;
    }else{
		if($row['completed'] == 1){
			return true;
		}else{
			return false;
		}
    }
}

//////// 18 / 1/ 2016

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

function getDriverData($driverId){
    $data = array();
    $query = mysql_query("SELECT d.longitude,d.lattitude,t.type,t.max_passengers FROM driver d,taxi t WHERE d.driver_id = t.driver_id  AND d.driver_id = '$driverId'");
    $row = mysql_fetch_array($query);
	$data[0] = $row['longitude'];
	$data[1] = $row['lattitude'];
	$data[2] = $row['type'];
	$data[3] = $row['max_passengers'];
    return $data;
}

function checkDriverAvaiable($driverId,$date,$startTime,$endTime){
	$query = mysql_query("SELECT  hr.date,hr.time,ADDTIME(hr.time,hr.duration) AS end_time FROM hire_request hr , driver d, tour t WHERE hr.request_id = t.request_id AND t.driver_id = d.driver_id AND d.driver_id = '$driverId'");
    $isAvailable = false;
    while($row = mysql_fetch_array($query)){ 
		if($row['date'] == $date){
			if($startTime <= $row['time'] && $row['time'] <= $endTime ){
				return $isAvailable; 
			}else if($startTime <= $row['end_time'] && $row['end_time'] <= $endTime ){
				return $isAvailable; 
			}
		}
	}
	$isAvailable = true;
	return $isAvailable;
}

function getAvailableHireRequests($driverId){
    $requests = array();
    $query = mysql_query("SELECT hr.request_id, hr.start_loc_long, hr.start_loc_lat, hr.destination_long, hr.destination_lat, hr.date, hr.time, hr.num_of_passengers, hr.max_bid , hr.contact_no ,hr.vehicle_type,ADDTIME(hr.time,hr.duration) AS end_time FROM hire_request hr WHERE completed != 1");
    
    while($row = mysql_fetch_array($query)){ // display all rows  from query
		$driverData = getDriverData($driverId);
		$unit = "K";

		if( ( distance($row['start_loc_long'],$row['start_loc_lat'],$driverData[0],$driverData[1],$unit) < 10 ) && ($row['vehicle_type'] == $driverData[2] ) && ($row['num_of_passengers'] <= $driverData[3]) && checkDriverAvaiable($driverId,$row['date'],$row['time'],$row['end_time'])){
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
			$requestRow[10] = $row['vehicle_type'];
			 
			$requests[]= $requestRow;
		}
		
		//echo $row['start_loc_long'] ," , ";
		//echo $row['start_loc_lat'] ,"  &  ";
		//echo $driverData[0]," , ";
		//echo $driverData[1],"          distance is :             ";
		//echo distance($row['start_loc_long'],$row['start_loc_lat'],$driverData[0],$driverData[1],$unit);
       
    }
    return $requests;
}

function getMyHires($driverId){
    $requests = array();
    $query = mysql_query("SELECT t.tour_id, t.request_id, hr.start_loc_long, hr.start_loc_lat, hr.destination_long, hr.destination_lat, hr.date, hr.time ,p.name , hr.contact_no, hr.num_of_passengers, t.charge  FROM hire_request hr,tour t,passenger p WHERE hr.request_id = t.request_id AND hr.contact_no = p.contact_no AND t.driver_id = '$driverId' ");
    
    while($row = mysql_fetch_array($query)){ // display all rows  from query
		$requestRow = array();
		$requestRow[0] = $row['tour_id'];
		$requestRow[1] = $row['request_id'];
		$requestRow[2] = $row['start_loc_long'];
		$requestRow[3] = $row['start_loc_lat'];
		$requestRow[4] = $row['destination_long'];
		$requestRow[5] = $row['destination_lat'];
		$requestRow[6] = $row['date'];
		$requestRow[7] = $row['time'];
		$requestRow[8] = $row['name'];
		$requestRow[9] = $row['contact_no'];
		$requestRow[10] = $row['num_of_passengers'];
		$requestRow[11] = $row['charge'];
        $requests[]= $requestRow;
    }
    return $requests;
}

function getAvailableMessages($driverId){
	$messages = array();
	$query = mysql_query("SELECT driver_inbox_id,message,is_viewed FROM driver_inbox WHERE driver_id = '$driverId' ");
    
     while($row = mysql_fetch_array($query)){ // display all rows  from query
		$data = array();
		$data[0] = $row['driver_inbox_id'];
		$data[1] = $row['message'];
		$data[2] = $row['is_viewed'];

        $messages[]= $data;
    }
    
    return $messages;
}

?>
