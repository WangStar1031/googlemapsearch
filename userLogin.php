<?php
	function UserLogin( $name, $pass){
		$DBservername = 'localhost';
		$DBusername = 'root';
		$DBpassword = '';
		$DBname = 'googlemapusers';
		$conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBname);
		if( $conn->connect_error){
			return -1;
		}
		$sql = "SELECT Id FROM userInfo WHERE (UserName='".$name."' OR Email='".$name."') AND Password='".$pass."'";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			$row = $result->fetch_assoc();
			$Id = $row['Id'];
			$conn->close();
			return $Id;
		}
		$conn->close();
		return -1;
	}
	if(isset($_POST['userName'])){
		$userName = $_POST['userName'];
		$password = $_POST['password'];
		$Id = UserLogin($userName, $password);
		$myObj = new \stdClass();
		if( $Id != -1){
			$myObj->Result = true;
			$myObj->user_id = $Id;
			$myObj->message = 'login success';
			echo json_encode($myObj);
		} else{
			$myObj->Result = false;
			$myObj->message = 'login failed';
			echo json_encode($myObj);
		}
	}
?>