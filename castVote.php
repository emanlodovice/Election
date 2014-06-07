<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}

	require("database_connect.php");

	@$election_id = $_GET['election_id'];
	@$password = $_GET['password'];
	$user_id = $_SESSION['user_id'];

	$q = "SELECT * FROM votes WHERE election_id = '$election_id' AND user_id = '$user_id'";
	$row = mysql_fetch_array(mysql_query($q));
	if (!$row) {

		$query = "SELECT * FROM positions WHERE election_id = '$election_id'";
		$result = mysql_query($query);

		while($r = mysql_fetch_array($result)) {
			$position_id = $r['position_id'];
			$candidate_id = $_POST[$position_id];
			if ($candidate_id != "") {
				$q = "INSERT INTO votes VALUES ('$election_id', '$candidate_id', '$user_id', '$position_id')";
				mysql_query($q);
			}
		}

		$q = "DELETE FROM passwords WHERE election_id = '$election_id' AND password = '$password'";
		mysql_query($q);
	}
	echo "Redirecting...";
	header("location:iamVoting.php");
?>