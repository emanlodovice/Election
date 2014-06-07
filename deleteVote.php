<?php
	session_start();

	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}

	require("database_connect.php");

	$election_id = $_POST['delete_election_id'];
	$voter_id = $_POST['delete_user_id'];

	mysql_query("DELETE FROM votes WHERE election_id ='$election_id' AND user_id = '$voter_id'");

	echo $election_id." ".$voter_id;

	header("location:electionDetail.php?election_id=".$election_id);

?>