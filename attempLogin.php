<?php session_start();
	if (isset($_SESSION['user_id'])) {
		header("location:home.php");
	}
?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="assets/css/attempLogin.css">
</head>
<body>
	<?php
		
		require("database_connect.php");
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$sql = "SELECT user_id, firstname, lastname FROM users WHERE email = '$email' AND password = PASSWORD('$password')";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		if($row) {
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['user_firstname'] = $row['firstname'];
			$_SESSION['user_lastname'] = $row['lastname'];
			header("location:home.php");
		}	else {
			?>
			<div id = "container">
				<div id="signUpForm">
					<form action="attempLogin.php" method="post">
						<h8>Your email or password is incorrect</h8><br/>
						<h3>Email&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</h8><input type="email" name = "email" id = "loginInput" value="<?=$email?>"><br/>
						<h3>Password&nbsp</h8><input type="password" name = "password" id = "loginInput"><br/>
						<input type="submit" value="Login" id="passButton">
					</form> 
				</div>
			</div>
			<script type="text/javascript">
				document.getElementById("signUpForm").style.visibility;
			
			</script>
			<?php
		}
		mysql_close($con);
	?>
</body>
</html>