<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}
	$user_id = $_SESSION['user_id'];

	require("database_connect.php");
?>

<html>
<head>
	<title>Election</title>
	<link rel = "stylesheet" type = "text/css" href = "assets/css/manageElections.css">
</head>

<body>
	
	<div id = "container">
		<div id="container">
		<div id="header"> 
			<div id="greeting">Hello, <a href="profile.php?user_id=<?=$user_id?> class = 'link'" class = 'link'><?php echo $_SESSION['user_firstname']." ".$_SESSION['user_lastname'];?></a>!</div>

			<div id="logoutspace"> 
				<a href="logout.php"><button id="logout">Log Out</button></a><br/>
			</div>
		</div>

		<div id="banner">
			<div id="sitename">OASYS</div>

			<div id="searchone">
				<input type="text" name="electionTitle" id="title" onkeyup="search(this.value)">
			</div>

			<div id="searchtwo">
				SEARCH
			</div>
		</div>
	<ul>
      <li><a href="home.php">View Elections</a></li>
      <li><a href="iamVoting.php">Elections I'm Voting</a></li>
      <li id='first'>Manage Elections</li>
      <li><a href="profile.php?user_id=<?=$user_id?>">My Profile</a></li>
    </ul>
		<button id= "createElection" onclick="show_add_election()" tabindex='-1'>Create Election</button><br/><br/>
		<div id="add_election">
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
				<h4> Description<br/>
					<Textarea cols = '30' rows = '5' resize="false" name="description" onkeyup = "verifyNewElection()"></Textarea>
				</h4>
				<h4> Last Day of Voting
					<input type="date" name="lastdate" onchange="verifyNewElection()">
				</h4>
				<h4> Positions </h4>
				<input type="hidden" id="posCount" name="posCount" value="0">
				<div id = "positions">
				</div>
				<input id="addPosition" type="button" id="addPosition" name="addPosition" value="Add Position" onClick="add_position()"><br/><br>
				<input id="cancel" type="button" value = "Cancel" onclick="hide_add_election()">
				<input id="create" type="submit" value="Create" name="create_election" disabled> 
			</form>
		</div> <br>
		<script type="text/javascript" src = "assets/jscript/manageElection.js"></script>
		<div id = "password_container" class = 'pop-up'>
			<div class = 'pop-up-content'>
				<div class = "close" onclick='hidePassword()'></div>
				<div id = "password" class = 'pop-up-content-value'>
					<center>
					<h3>Generate Passwords</h3>
						<input type="hidden" name = "election_id" value = "">
						<input type="number" name = "count" value = "1">
						<input type="button" id = "generatePasswordsButton" value = "Generate Passwords" onclick="generatePassword()">
					<h3>Available Passwords</h3>
					<div id = "availablePasswords">
					</div>
					<input type = "button" id = "okButton" name = "OK" onclick = "hidePassword()" value = "ok">
				</center>
				</div>
				<div class = 'clear'></div>
			</div>
		</div>

		<div id = "loading_container" class = 'pop-up'>
			<div id = "loading">
				<center>
					<h5><img src = "assets/images/loading.gif">loading...</h5>
				</center>
			</div>
		</div>

		<div id = "delete_party_container" class = 'pop-up'>
			<div class = 'pop-up-content'>
				<div class = 'close' onclick = 'hide_deleteParty()'></div>
				<div id = "delete_party" name = "" class = 'pop-up-content-value'>
					<h3>Delete a Candidate/Party</h3>
					<div id = "delete_candidates">
					</div>
					<input type = "button" value = "cancel" class = 'button' onclick="hide_deleteParty()">
				</div>
				<div class = 'clear'></div>
			</div>
		</div>

		<div id = "party_container" class = 'pop-up'>
			<div class = 'pop-up-content'>
				<div class = 'close' onclick = "hide_addParty()"></div>
				<div id = "party" name = "" class = 'pop-up-content-content'>
					<form action = "addParty.php" method = "post"> 
						<p id = "partyTitle">CREATE A NEW PARTY</p>
						<p id = "verifyPartyName"></p>
						<p id = "partyDetails">Party Name<input type = "text" name = "party_name" onchange="check_party_name(this.value)"></p>
						<p id = "partyTitle"> CANDIDATES</p>
						<div id = "candidate_positions">
						</div>
						<input type = "button" value = "cancel"  class = 'button' onclick="hide_addParty()">
						<input type = "submit" value = "create" disabled class = 'button' id = "bCreateParty">
					</form>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div id = "verify_delete_container" class = 'pop-up'>
			<div id = "verify_delete"  class = 'pop-up-content'>
				<center> <h2>Are you sure you want to delete this election?</h2>
					<form action="deleteElection.php" method="post">
						<input type="hidden" name="delete_election_id" value="">
						<input type="submit" value="Yes" class = 'button'>
						<input type="button" name="cancel_delete" value="No" class = 'button' onclick="hide_verify_delete()">
					</form>
				</center>
			</div>
		</div>

		<div id = "verify_delete_party_container" class = 'pop-up'>
			<div id = "verify_delete_party" class = 'pop-up-content'>
				<center> <h2>Are you sure you want to delete this party?</h2>
					<input type="hidden" name="delete_party_id" value="">
					<input type="hidden" name="delete_party_election_id" value="">
					<input type="button" value="Yes" class = 'button' onclick="doDeleteParty()">
					<input type="button" name="cancel_delete" value="No" class = 'button' onclick="hide_verify_delete_party()">
				</center>
			</div>
		</div>

		<div id = "verify_delete_candidate_container" class = 'pop-up'>
			<div id = "verify_delete_candidate" class = 'pop-up-content'>
				<center> <h2>Are you sure you want to delete this candidate?</h2>
					<input type="hidden" name="delete_candidate_id" value="">
					<input type="hidden" name="delete_candidate_party_id" value="">
					<input type="hidden" name="delete_candidate_election_id" value="">
					<input type="button" value="Yes" class = 'button' onclick="doDeleteCandidate()">
					<input type="button" name="cancel_delete" value="No" class = 'button' onclick="hide_verify_delete_candidate()">
				</center>
			</div>
		</div>

		<div id = "election_settings_container" class = 'pop-up'>
			<div class = 'pop-up-content'>
				<div class = "close" onclick = "hide_edit_election()"></div>
				<div id = "election_settings" class = 'pop-up-content-content'>
					<form action = "editElection.php" method = "post">
						<input type="hidden" name="edit_election_id" value="">
						<h4>Last day of Voting <input type = "date" name = "edit_lastdate"></h4>
						<h4>Password Protected <input type = "radio" name = "edit_password" value = "1">yes <input type = "radio" name = "edit_password" value = "0"> no</h4>
						<h4>Privacy <input type = "radio" name = "edit_privacy" value = "0"> public <input type = "radio" name = "edit_privacy" value = "1" private> private</h4>
						<input type="button" value="Cancel" class = 'button' onclick = "hide_edit_election()">
						<input type="submit" value="Save" class = 'button'>
					</form>
				</div>
				<div class = "clear"></div>
			</div>
		</div>

		<div id = "content">
			<br> <br> 
			<h1> &nbsp &nbsp YOUR ELECTIONS </h1>
			<?php 
				$query = "SELECT * FROM elections WHERE user_id = '$user_id' order by election_id desc";
				$result = mysql_query($query);
				$election = mysql_fetch_array($result);
				if (!$election) { 
			?>
					<div id ="no_election">
						<h1>You are not hosting any election yet!</h1>
					</div>
			<?php
				}

				while($election) {
					$election_id = $election['election_id'];
			?>

				<div class = "election" name = "<?=$election['title']?>">
					<div class = "date">
						<?php 
							$date = new DateTime($election['lastdate']);
							echo date_format($date, "d")."<br/>".date_format($date, "M");
						?>
					</div>
					<div class = "election_detail">
						<?php
							$voteCount = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) FROM votes WHERE election_id = '$election_id'"));
						?>
						<div class = "description">
							<a href = "electionDetail.php?election_id=<?=$election_id?>"><b><?=$election['title']?>| <?=$voteCount['COUNT(DISTINCT user_id)']?> vote(s)</b></a><br/>
							a <?php if($election['privacy'] == 1) echo "private"; else echo "public"; if ($election['password'] == 1) echo " and password protected";?> election<br/> 
						<?=$election['description']?></div>
						<div class = "actions">
							<div>
						<?php if($election['password'] == 1) echo "<input type = 'button' class = 'button' value = 'Passwords' tabindex = '-1' onclick='showPassword(" . $election_id . ")'>";
							$status = "";
							echo "<input type = 'button' name = 'add_party" . $election_id . "' class = 'button' tabindex = '-1' value = 'Add Party' onclick='addParty(" . $election_id . ")'>";
							echo "<input type = 'button' name = 'delete_party" . $election_id . "' class = 'button' tabindex = '-1' value = 'Delete Party' onclick='deleteParty(" . $election_id . ")'>";
							if($election['status'] == 1) {
								 $status = "Close Election";
								 echo "<script> addPartyVisibility(".$election_id.", 'none'); </script>";
							}
							else {
								$status = "Open Election";
								echo "<script> addPartyVisibility(".$election_id.",'inline-block'); </script>";
							}
							echo "</div>";
							echo "<div>";
							echo "<input type = 'button' class = 'button' value = 'Settings' tabindex = '-1' onclick = 'edit_election(".$election_id.",".$election['password'].",".$election['privacy'].")'>";
							echo "<input type = 'button' class = 'button' value = 'Delete' tabindex = '-1' onclick = 'verify_delete(".$election_id.")'>";
							echo "<input type = 'button' class = 'button' name = 'status" . $election_id . "' tabindex = '-1' value = '" . $status . "' onclick='changeElectionStatus(" . $election_id . ")'>";
							echo "</div>";
						?> 
						</div>
					</div>
					<br/>
					<div class = 'clear'></div>
				</div>

			<?php
					$election = mysql_fetch_array($result);
				}
			?>
			<div class='clear'></div>
		</div>

		<div id = "footer">
     		Copyright 2013 | Group Name | Election System
    	</div>
	</div>

</body>
</html>