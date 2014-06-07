<?php 
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}
?>

<html>
<head>
<title>Election </title>
</head>

<body>
	<div id="add_election">
		<center><h2>Create Election</h2>
		<form action="addElection.php" method="post">
			
			<h4>Election Title<input type="text" id="election_title" name="title" onkeyup="checkTitle(this.value); verifyNewElection();" onchange="checkTitle(this.value); verifyNewElection();"><p id = "verifyTitle"></p></h4>
			<h4>Privacy 
				<input type="radio" name="privacy" value="0" checked>public
				<input type="radio" name="privacy" value="1">private
			</h4>
			<h4> Password Protected
				<input type="radio" name="security" value="1" checked> yes
				<input type="radio" name="security" value="0"> no
			</h4>
			<div id = "positions">
				<h4> Positions </h4>
				<input type="hidden" id="posCount" name="posCount">
			</div>
			<input type="button" id="addPosition" name="addPosition" value="add position" onClick="add_position()"><br/>

			<input type="submit" value="create election" name="create_election" disabled>
		</form>
		</center>
	</div>

<script type="text/javascript" src="assets/jscript/manage_elections.js"></script>
</body>

</html>