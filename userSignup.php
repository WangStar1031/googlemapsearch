<?php
	function RegisterUser( $name, $eMail, $pass){
		$DBservername = '127.0.0.1';
		$DBusername = 'root';
		$DBpassword = '';
		$DBname = 'googlemapusers';
		$conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBname);
		if( $conn->connect_error){
			return -1;
		}
		$sql = "SELECT Id FROM userinfo WHERE UserName='".$name."' OR Email='".$eMail."'";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			$conn->close();
			return -1;
		}
		$sql = "INSERT INTO userinfo(UserName, Email, Password) VALUES('". $name ."','" . $eMail . "', '".$pass."')";
		if( $conn->query($sql) === TRUE){
			$sql = "SELECT Id FROM userInfo WHERE UserName='".$name."'";
			$ids = $conn->query($sql);
			if( $ids->num_rows > 0){
				$row = $ids->fetch_assoc();
				$Id = $row['Id'];
				$conn->close();
				return $Id;
			}
			$conn->close();
			return -1;
		}
		else{
			$conn->close();
			return -1;
		}
	}
	if(isset($_POST['userName'])){
		$userName = $_POST['userName'];
		$email = $_POST['eMail'];
		$password = $_POST['password'];
		$myObj = new \stdClass();
		if(RegisterUser($userName, $email, $password) != -1){
			$myObj->Result = true;
			$myObj->message = 'Success';
			echo json_encode($myObj);
		} else{
			$myObj->Result = false;
			$myObj->message = 'Failed';
			echo json_encode($myObj);
		}
	}
?>