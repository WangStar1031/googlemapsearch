<?php
	$DBservername = 'localhost';
	$DBusername = 'root';
	$DBpassword = '';
	$DBname = 'googlemapusers';
	function RegisterUser( $name, $eMail, $pass){
		$conn = new mysqli($DBservername, $DBusername, $DBpassword, $DBname);
		if( $conn->connect_error){
			return -1;
		}
		$sql = "SELECT Id FROM userInfo WHERE UserName='".$name."' OR Email='".$eMail."'";
		$result = $conn->query($sql);
		if( $result->num_rows > 0){
			$conn->close();
			return -1;
		}
		$sql = "INSERT INTO users(UserName, Email, Password) VALUES('". $name ."','" . $eMail . "', '".$pass."')";
		if( $conn->query($sql) === TRUE){
			$sql = "SELECT Id FROM userInfo WHERE UserName='".$name."'";
			$ids = $conn->query($sql);
			if( $ids->num_rows > 0){
				$Id = $ids['Id'];
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
	if(isset($_POST['userName']) && !isset($userName)){
		$userName = $_POST['userName'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		if(RegisterUser($userName, $email, $password) != -1){
			
		} else{

		}
	}
	if( isset($_POST[]))


?>