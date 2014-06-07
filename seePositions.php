<?php
	require("database_connect.php");

	$election_id = $_GET['election_id'];

	$query = "SELECT * FROM positions WHERE election_id = '$election_id'";
	$result = mysql_query($query);

	while ($row = mysql_fetch_array($result)) {
		echo "<h5>".$row['title']."<input type='text' name='".$row['position_id']."'></h5>";
	}
	echo "<input type='hidden' name='election_id' value = '".$election_id."'>";

?>