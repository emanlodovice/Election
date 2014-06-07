<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}

	require("database_connect.php");

	$party_id = $_GET['party_id'];
	$election_id = $_GET['election_id'];

	mysql_query("DELETE FROM parties WHERE party_id = '$party_id' AND election_id = '$election_id'");

?>