<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}
	require("database_connect.php");
	try{
		$election_id = $_GET['election_id'];
	}	catch(Exception $e) {
		header("location:home.php");
	}
	?>

	<center>
	<div id = "generate_pass">
		<form action="generatePassword.php" method="post">
			<input type="number" name="count">
			<input type="hidden" name="election_id" value="<?=$election_id?>">
			<input type="submit" value="generate passwords">
		</form>
	</div>

	<?php
	$view = "SELECT * FROM passwords WHERE election_id = '$election_id'";
	$result = mysql_query($view);
	echo "<h3>Existing Passwords</h3>";
	while($row = mysql_fetch_array($result)) {
		echo $row['password']."<br/>";
	}
	echo "</center>";
?>
