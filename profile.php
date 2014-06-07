<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}
	require("database_connect.php");

	$user_id = $_SESSION['user_id'];
	$toView_Id = $_GET['user_id'];

	$about_user = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE user_id = '$toView_Id'"));

?>

<!DOCTYPE html>
<html>
<head>
	<title>Elections</title>
	<link rel = "stylesheet" type = "text/css" href = "assets/css/profile.css">
</head>

<body>
	<script type="text/javascript" src="assets/jscript/profile.js"></script>
<div id = "container">
	<div id="header"> 
		<div id="greeting"> Hello,  <a href="profile.php?user_id=<?=$user_id?>" class = 'link'><?php echo $_SESSION['user_firstname']." ".$_SESSION['user_lastname'];?></a>! </div>
		<div id="logoutspace"> 
			<a href="logout.php"><button id="logout">Log Out</button></a><br/>
		</div>
	</div>
	<div id="banner">
		<div id="sitename">OASYS</div>
	</div>

	<div id = 'edit_profile_container' class = 'pop-up'>
		<div class = 'pop-up-content'>
			<div class = 'close' onclick = "hide_edit()"></div>
			<div id ='edit_profile' class = 'pop-up-content-value'>
				<form action = 'editProfile.php' method = 'post' enctype = 'multipart/form-data'>
					<div id = 'pic_preview'></div><br/>
					<div class = 'clear'></div>
					<div class = 'label'>Profile Picture</div><div class = 'value'><input type = 'file' name = 'picture' id = 'profile_pic' onchange="change_preview(this)"></div>
					<div class = 'clear'></div>
					<div class = 'label'>First Name</div><div class = 'value'><input type = 'text' name = 'firstname'></div>
					<div class = 'clear'></div>
					<div class = 'label'>Last Name</div><div class = 'value'><input type = 'text' name = 'lastname'></div>
					<div class = 'clear'></div>
					<div class = 'label'>Year</div><div class = 'value'><input type = 'number' name = 'year' min = '1' max = '10'></div>
					<div class = 'clear'></div>
					<div class = 'label'>Program</div><div class = 'value'><input type = 'text' name = 'program'></div>
					<div class = 'clear'></div>
					<div class = 'label'>Address</div><div class = 'value'><input type = 'text' name = 'address'></div>
					<div class = 'clear'></div>
					<div class = 'label'>Contact Number</div><div class = 'value'><input type = 'text' name = 'contact_number'><br><input type = 'button' class = 'button' value = 'Cancel' onclick = "hide_edit()"><input type = 'submit' class = 'button' value = 'Save'></div>
					<div class = 'clear'></div>
				</form>
			</div>
			<div class = 'clear'></div>
		</div>
	</div>

	<div id = 'login_info_container' class = 'pop-up'>
		<div class = 'pop-up-content'>
			<div class = 'close' onclick = "hide_login()"></div>
			<div id = 'login_info' class = 'pop-up-content-value'>
				<form action = 'changePassword.php' method = 'post'>
					<div class = 'label'>Old Password</div><div class = 'value'><input type = 'password' name = 'old_pass' required></div>
					<div class = 'clear'></div>
					<div class = 'label'>New Password</div><div class = 'value'><input type = 'password' name = 'new_pass' required></div>
					<div class = 'clear'></div>
					<div class = 'label'>Re-New Password</div><div class = 'value'><input type = 'password' name = 're-new_pass' required></div>
					<div class = 'clear'></div>
					<center><input type = 'button' class = 'button' value = 'Cancel' onclick = "hide_login()"><input type = 'submit' class = 'button' value = 'Save'></center>
				</form>
			</div>
			<div class = 'clear'></div>
		</div>
	</div>


	<div id = 'alert_container' onclick ='hide_alert()'>
		<div id = 'alert' >
		</div>
	</div>

	<ul>
      <li><a href="home.php">View Elections</a></li>
      <li><a href="iamVoting.php">Elections I'm Voting</a></li>
      <li><a href="manageElections.php">Manage Elections</a></li>
      <li id='first'><a href="profile.php?user_id=<?=$user_id?>">My Profile</a></li>
	</ul>

	<?php 
		if ($user_id == $toView_Id) {
			echo "<input type = 'button' id = 'edit' onclick='show_edit(\"".$about_user['firstname']."\",\"".$about_user['lastname']."\",\"".$about_user['year_level']."\",\"".$about_user['program']."\",\"".$about_user['address']."\",\"".$about_user['contact_number']."\",\"".$toView_Id."\")' tabindex='-1' value = 'Edit Profile'>";
			echo "<input type = 'button' id = 'edit' onclick='show_login()' tabindex='-1' value = 'Change Password'><br/><br/><br/>";
		}
		if (isset($_SESSION['profile_error'])) {
			echo "<script>show_alert('".$_SESSION['profile_error']."')</script>";
			unset($_SESSION['profile_error']);
		}
	?>
	<div id = 'content'>
		<div id = 'detail'>
			<div class = 'label_value_container'>
				<div class = 'label'><h3>First Name</h3></div>
				<div class = 'value'><h2><?=$about_user['firstname']?></h2></div>
			</div>
			<div class = 'label_value_container'>
				<div class = 'label'><h3>Last Name</h3></div>
				<div class = 'value'><h2><?=$about_user['lastname']?></h2></div>
			</div>
			<div class = 'label_value_container'>
				<div class = 'label'><h3>Year Level</h3></div>
				<div class = 'value'><h2><?=$about_user['year_level']?></h2></div>
			</div>
			<div class = 'label_value_container'>
				<div class = 'label'><h3>Program</h3></div>
				<div class = 'value'><h2><?=$about_user['program']?></h2></div>
			</div>
			<div class = 'label_value_container'>
				<div class = 'label'><h3>Address</h3></div>
				<div class = 'value'><h2><?=$about_user['address']?></h2></div>
			</div>
			<div class = 'label_value_container'>
				<div class = 'label'><h3>Contact Number</h3></div>
				<div class = 'value'><h2><?=$about_user['contact_number']?></h2></div>
			</div>
			<div class = 'label_value_container'>
				<div class = 'label'><h3>Email Address</h3></div>
				<div class = 'value'><h2><?=$about_user['email']?></h2></div>
			</div>
		</div>
		<div id = 'picture'>
			<?php if (file_exists("assets/images/profile/".$toView_Id.".png")) { ?>
			<img src = "assets/images/profile/<?=$toView_Id?>.png" width = "100%" height = "100%">
			<?php } else {?>
				<img src = "assets/images/profile/0.png" width = "100%" height = "100%">
			<?php }?>
		</div>
		<div class = 'clear'>
		</div>
	</div>

	<div id = "footer">
     	Copyright 2013 | Group Name | Election System
    </div>
    
</div>
</body>
</html>