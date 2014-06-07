<?php
	session_start();
	if (!$_SESSION['user_id']) {
		header("location:index.php");
	}

	require("database_connect.php");
	$user_id = $_SESSION['user_id'];
	$election_id = $_POST['election_id'];
	$partyName = $_POST['party_name'];


	$party_id = null;
	if ($partyName != "") {
		$q = "INSERT INTO parties (title, election_id) VALUES ('$partyName', '$election_id')";
		$res = mysql_query($q);
		$party_id = mysql_insert_id();
	}

	$positionsQuery = "SELECT * FROM positions WHERE election_id = '$election_id'";
	$positions = mysql_query($positionsQuery);
	$hasValues = false;

	while($row = mysql_fetch_array($positions)) {
		$position_id = $row['position_id'];
		$name = $_POST[$position_id];
		if ($name != "") {
			$q = "INSERT INTO candidates (name, position_id, party_id) VALUES ('$name', '$position_id', '$party_id')";
			mysql_query($q);
			$hasValues = true;
		}
	}

	if ($hasValues == false) {
		if ($party_id != null) {
			$q = "DELETE FROM parties WHERE party_id = '$party_id'";
			mysql_query($q);
		}
	}

	echo "Redirecting...";
	header("location:manageElections.php");
?>