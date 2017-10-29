<?php
	function setUserLocation( $userId, $Lat, $Lang){
		$DBservername = 'localhost';
		$DBusername = 'root';
		$DBpassword = '';
		$DBname = 'googlemapusers';
		$conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBname);
		if( $conn->connect_error){
			return NULL;
		}
		$sql = "UPDATE userInfo SET Lat='".$Lat."', Lang='".$Lang."', UpdatedTime=NOW() WHERE Id='".$userId."'";
		$conn->query($sql);
		$conn->close();
		return 1;
	}
	if(isset($_POST['userId'])){
		$userId = $_POST['userId'];
		$Lat = $_POST['Lat'];
		$Lang = $_POST['Lang'];
		$myObj = setUserLocation($userId, $Lat, $Lang);
		if( $myObj != NULL){
			echo "updated";
		} else{
			echo NULL;
		}
	}
?>