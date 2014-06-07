<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header('location:index.php');
	}
	
	require("database_connect.php");

	
	$count = $_GET['count'];
	$election_id = $_GET['election_id'];
	
	function generatePassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$toreturn = "";
		$length = strlen($alphabet) - 1;
		for($c = 0; $c < 5; $c++) {
			$index = rand(0, $length);
			$toreturn = $toreturn.$alphabet[$index];
		}
		return $toreturn;
	}

	
	
	for($ctr = 0; $ctr < $count; $ctr++) {
		while(true){
			$pass = generatePassword().$election_id;
			$query = "SELECT * FROM passwords WHERE password = '$pass'";
			$result = mysql_query($query);
			if(!mysql_fetch_array($result)) {
				$add = "INSERT INTO passwords VALUES('$election_id', '$pass')";
				mysql_query($add);
				break;	
			}
		}
	}	


?>