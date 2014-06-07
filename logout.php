<?php
	session_start();
	echo $_SESSION['user_id']."<br>";
	if (isset($_SESSION['user_id'])) {
		unset($_SESSION['user_id']);
	}
	header("location:index.php");
?>