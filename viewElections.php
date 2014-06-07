<?php
	session_start();
	if (!$_SESSION['user_id']) {
		header("location:index.php");
	}

	require("database_connect.php");
?>

	

<?php


	$query = "SELECT * FROM elections WHERE privacy = '0'";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) {
		echo "<h4>Title: ".$row['title']."</h4>";
		if ($row['password'] == 1) {
			echo "<form action = 'generatePassword.php' method = 'post'>
					<input type='hidden' name='election_id' value='".$row['election_id']."'>
					Number of Password<input type='number' name='count'>
					<input type='submit' value='generate pass'>
				</form>";
		}
	}

?>