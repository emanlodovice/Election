<?php
	require("database_connect.php");
	$title = $_GET['title'];
	$election_id = $_GET['election_id'];

	$query = "SELECT * FROM parties WHERE election_id = '$election_id' AND title = '$title'";
	$row = mysql_fetch_array(mysql_query($query));
	
	if ($row) {
		echo "Party Name is not available.";
	}	else{
		echo "";
	}
?>