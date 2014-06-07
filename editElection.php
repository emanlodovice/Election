<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}

	require("database_connect.php");

	$election_id = $_POST['edit_election_id'];
	$lastdate = $_POST['edit_lastdate'];
	$password = $_POST['edit_password'];
	$privacy = $_POST['edit_privacy'];

	if ($lastdate != "") {
		$test = new DateTime($lastdate." 23:59:59");
		$date = date_format($test, 'Y-m-d H:i:s');
		mysql_query("UPDATE elections SET lastdate = '$date', password = '$password', privacy = '$privacy' WHERE election_id = '$election_id'");	
	}	else {
		mysql_query("UPDATE elections SET password = '$password', privacy = '$privacy' WHERE election_id = '$election_id'");	
	}

	if ($password == 0) {
		mysql_query("DELETE FROM passwords WHERE election_id = '$election_id'");
	}

	echo "Redirecting...";
	header("location:manageElections.php");
?>