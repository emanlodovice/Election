<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}

	require("database_connect.php");

	$user_id = $_SESSION['user_id'];

	$old_pass = $_POST['old_pass'];
	$new_pass = $_POST['new_pass'];
	$re_pass = $_POST['re-new_pass'];

	if ($new_pass != $re_pass) {
		$_SESSION['profile_error'] = "Error in changing password!";
		header("location:profile.php?user_id=".$user_id);
	}	else {
		$correctPass = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE user_id = '$user_id' AND password = PASSWORD('$old_pass')"));
		if (!$correctPass) {
			$_SESSION['profile_error'] = "Error in changing password!";
			header("location:profile.php?user_id=".$user_id);
		}	else {
			mysql_query("UPDATE users SET password = PASSWORD('$new_pass') WHERE user_id = '$user_id'");
			$_SESSION['profile_error'] = "Successful!";
			header("location:profile.php?user_id=".$user_id);
		}
	}

?>