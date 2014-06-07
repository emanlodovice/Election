<?php
	session_start();
	if(isset($_SESSION['user_id'])) {
		header("location:home.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>ELECTION</title>
<link rel="stylesheet" type="text/css" href="assets/css/index.css">
</head>
<body>

	<div id = 'container'>
		<div id="banner">
			<div id="sitename">OASYS</div>
		</div>
		
		<div id="overlay">
			<div id="signUpForm">
				<form action="addUser.php" method="post">
					<h8> Sign Up </h8><br/>
					<h5>First Name</h5><input type="text" id="signUpInput" name="firstName" onchange="verifyPassword()"><br/>
					<h5>Last Name</h5><input type="text" id="signUpInput" name="lastName" onchange="verifyPassword()"><br/>
					<!--<h5>Program</h5><input type="text" id="signUpInput" name="program"><br/>
					<h5>Year</h5><select id = "signUpInput" name = "year">
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
									<option>6</option>
								</select>
					<h5>Contact Number</h5><input type="text" id="signUpInput" name="contactNumber"><br/>
					<h5>Address</h5><input type="text" id="signUpInput" name="address"><br/> -->
					<div ><h5 id="verifEmail"></h5></div>
					<h5>Email</h5><input type="email" id="signUpInput" name="email" onchange="validateEmail(this.value); verifyPassword();"><br/>
					<h5>Password</h5><input type="password" id="signUpInput" name="password" onchange="verifyPassword()"><br/>
					<h5>Re-password</h5><input type="password" id="signUpInput" name="rePassword" onkeyup="verifyPassword()" ><br/>
					<div>
					<input type="submit" id="signUpButton" value="sign up" disabled="true">
				
					<input type="button" id="cancel" value="cancel"  onclick="cancelSignUp()">
					</div>
					</form>
			 </div>
		</div>
	
		<div id = 'content'>
			<div id = 'login'>
				<form action="attempLogin.php" method="post">
					<h2>Login </h2>
					<h3>Email&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</h3><input type="email" class="loginInput" name="email" required/><br/>
					<h3>Password&nbsp&nbsp</h3><input type="password" class="loginInput" name="password" required><br/>
					<div id = "loginButtonDiv"> <input type="submit" id="passButton" value="Log In"> </div>
				</form>
			</div>
			<div id = 'signup'>
				<h2>Sign Up </h2>
				<h5>Host Elections For Free</h5>
				<div id = "signupButtonDiv"> <input type="button" id="bSignUp" value="Sign Up" onClick="popup()"> </div>
			</div>
		</div>
		<br>
		<div id = "footer">
			<p>Copyright 2013 <br>Group Name | Election System</p>
		</div>
	</div>
	
<script type="text/javascript" src="assets/jscript/index.js"></script>
</body>


</html>