<?php
	require("database_connect.php");
	
	$email = $_GET['email'];
	
	$sql = "SELECT * FROM users WHERE email = '$email'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result); 

	$response="";
	if ($row) {
		$response = "Email not available!";
	}	
		
	echo $response;
	mysql_close($con);
?>