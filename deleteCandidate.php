<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}

	require("database_connect.php");

	$election_id = $_GET['election_id'];
	$party_id = $_GET['party_id'];
	$candidate_id = $_GET['candidate_id'];

	mysql_query("DELETE FROM candidates WHERE candidate_id = '$candidate_id' AND party_id = '$party_id'");

	$remaining = mysql_fetch_array(mysql_query("SELECT * FROM candidates WHERE party_id = '$party_id'"));

	if (!$remaining) {
		mysql_query("DELETE FROM parties WHERE party_id = '$party_id' AND election_id = '$election_id'");
	}

?>