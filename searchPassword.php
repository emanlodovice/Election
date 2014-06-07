<?php
	require("database_connect.php");
	$election_id = $_GET['election_id'];

	$query = "SELECT * FROM passwords WHERE election_id = '$election_id'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);

	if (!$row) {
		echo "<center> No Available Password! </center>";
	}	else {
		$ctr = 0;
		while ($row) {
			echo  $row['password'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
			$row = mysql_fetch_array($result);
			$ctr++;
			if ($ctr == 3) {
				echo "</br>";
				$ctr = 0;
			}
		}
	}
?>