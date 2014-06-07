<?php
	session_start();

	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}

	require("database_connect.php");

	$user_id = $_SESSION['user_id'];
	$election_id = $_POST['delete_election_id'];

	$query = "DELETE FROM elections WHERE election_id = '$election_id' AND user_id = '$user_id'";
	mysql_query($query);

	echo "Redirecting...";
	header("location:manageElections.php");

?>