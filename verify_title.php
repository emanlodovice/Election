<?php
	require("database_connect.php");
	$title = $_GET["title"];

	$query = "SELECT election_id FROM elections WHERE title = '$title'";
	$row = mysql_fetch_array(mysql_query($query));
	
	if ($row) {
		echo "Title is not available.";
	}	else{
		echo "";
	}
?>