<?php
	require("database_connect.php");
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$pass = $_POST['password'];
	
	$sql = "INSERT INTO users (email, firstname, lastname, password) VALUES ('$email', '$firstName', '$lastName', password('$pass'))";
	$result =mysql_query($sql);
	mysql_close($con);
	header("location:index.php");
?>