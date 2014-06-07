<?php

	require("database_connect.php");

	$election_id = $_GET['election_id'];
	$status = $_GET['status'];

	$query = "UPDATE elections set status = '$status' WHERE election_id = '$election_id'";
	mysql_query($query);
?>