<?php
	function getUserLocation( $userId){
		$DBservername = 'localhost';
		$DBusername = 'root';
		$DBpassword = '';
		$DBname = 'googlemapusers';
		$conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBname);
		if( $conn->connect_error){
			return NULL;
		}
		if($userId == 0){
			$sql = "SELECT Id,UserName,Lat,Lang,UpdatedTime,NOW() FROM userInfo";
			$result = $conn->query($sql);
			if( $result->num_rows > 0){
				$retVal = array();
				while (($row=$result->fetch_assoc())) {
					$UpdatedTime = $row['UpdatedTime'];
					$now = $row['NOW()'];
					$timeSpend = strtotime($now) - strtotime($UpdatedTime);
					if( $timeSpend > 24 * 60 * 60)
						continue;
					$myObj = new \stdClass();
					$myObj->Id = $row['Id'];
					$myObj->Name = $row['UserName'];
					$myObj->Lat = $row['Lat'];
					$myObj->Lang = $row['Lang'];
					array_push($retVal, $myObj);
				}
				$conn->close();
				return $retVal;
			}
		} else{
			$sql = "SELECT Id,UserName,Lat,Lang FROM userInfo WHERE Id='".$userId."'";
			$result = $conn->query($sql);
			if( $result->num_rows > 0){
				$row = $result->fetch_assoc();
				$myObj = new \stdClass();
				$myObj->Id = $row['Id'];
				$myObj->Name = $row['UserName'];
				$myObj->Lat = $row['Lat'];
				$myObj->Lang = $row['Lang'];
				$conn->close();
				return $myObj;
			}
		}
		$conn->close();
		return NULL;
	}
	if(isset($_POST['userId'])){
		$userId = $_POST['userId'];
		$myObj = getUserLocation($userId);
		if( $myObj != NULL){
			echo json_encode($myObj);
		} else{
			echo NULL;
		}
	}
?>