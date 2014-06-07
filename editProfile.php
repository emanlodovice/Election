<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}

	require("database_connect.php");

	$user_id = $_SESSION['user_id'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$year = $_POST['year'];
	$program = $_POST['program'];
	$address = $_POST['address'];
	$contact_number = $_POST['contact_number'];
	$pic = $_FILES['picture'];

	mysql_query("UPDATE users SET firstname = '$firstname', lastname = '$lastname', year_level = '$year', program = '$program',
	address = '$address', contact_number = '$contact_number' WHERE user_id = '$user_id'");
	if ($pic['size'] > 0 && (($pic['type'] == "image/gif") || ($pic['type'] =="image/png") || ($pic['type'] =="image/jpeg") || ($pic['type'] =="image/jpg")) && (!$pic['error'] > 0)) {
		$pic['name'] = $user_id;
		$pic['type'] = "image/png";
		echo $pic['name'];
		move_uploaded_file($pic['tmp_name'], "assets/images/profile/".$pic['name'].".png");
		$_SESSION['profile_error'] = "Success...";
	}	else {
		if ($pic['size'] > 0) {
			$_SESSION['profile_error'] = "Sorry. Editing Unsuccessful...";
		}	else {
			$_SESSION['profile_error'] = "Success...";
		}
	}

	header("location:profile.php?user_id=".$user_id);
?>