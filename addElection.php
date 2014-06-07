<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}
	
	require("database_connect.php");
	$user_id = $_SESSION['user_id'];
	$title = $_POST['title'];
	$password = $_POST['security'];
	$privacy = $_POST['privacy'];
	$posCount = $_POST['posCount'];
	$description = $_POST['description'];
	$lastdate = $_POST['lastdate'];
	$test = new DateTime($lastdate." 23:59:59");
	$date = date_format($test, 'Y-m-d H:i:s');

	
	$sql="INSERT INTO elections (user_id, title, status, password, privacy, description, lastdate) VALUES ('$user_id', '$title', '0', '$password', '$privacy', '$description', '$date')";
	mysql_query($sql);
	$election_id = mysql_insert_id();
	for ($ctr = 0; $ctr < $posCount; $ctr++) {
		$title = $_POST['position'.$ctr];
		if($title != "") {
			$addPos = "INSERT INTO positions (election_id, title) VALUES ('$election_id', '$title')";
			mysql_query($addPos);
		}
	}
	
	header("location:manageElections.php");
?>