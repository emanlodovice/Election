<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}

	$user_id = $_SESSION['user_id'];
	require("database_connect.php");
	date_default_timezone_set("America/Los_Angeles");
	$currentDate = date("Y-m-d H:i:s");
?>

<html>
<head>
	<title>Election</title>
	<link rel="stylesheet" href="assets/css/iamvoting1.css">
</head>

<body>
	<div id="container">
		<div id="header"> 
			<div id="greeting"> Hello,  <a href="profile.php?user_id=<?=$user_id?>" class = 'link'><?php echo $_SESSION['user_firstname']." ".$_SESSION['user_lastname'];?></a>! </div>
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
		<div id="vote_container">
     		<div class = "pop-up-container">
       		 <div class = "close" onClick = "hideVote()"></div>
       		 <div id="vote"></div>
        	<div class = "clear"></div>
     	</div>
    </div>
		<ul>
	      <li><a href="home.php">View Elections</a></li>
	      <li id='first'><a href="iamVoting.php">Elections I'm Voting</a></li>
	      <li><a href="manageElections.php">Manage Elections</a></li>
	      <li><a href="profile.php?user_id=<?=$user_id?>">My Profile</a></li>
    	</ul>
    	<input type="button" id="voteElection" value="Vote" onclick="show_vote_election()">
			<div id = "vote_election">
				<h4>Election Title &nbsp&nbsp &nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type = "text" name = "vote_election_title" size = '30' required></h4>
				<h4>Election Password&nbsp<input type = "password" name = "vote_election_password" size = '30'></h4>
				<input type="button" class = "button" value = "Cancel" onclick = "hide_vote_election()">
				<input type="button" class = "button" value = "Vote" onclick = "votePrivateElection()">
			</div><br/><br/>
		<div id="content">
			
			<br><br> 
			<h1> &nbsp &nbsp VOTED ELECTIONS </h1>
			<?php
				$result = mysql_query("SELECT * FROM elections WHERE election_id IN (SELECT DISTINCT election_id FROM votes WHERE user_id = '$user_id') order by election_id desc");
				$election = mysql_fetch_array($result);

				if (!$election) {
					echo "<h2>You have not voted in any election!</h2>";
				}

				while ($election) {
					$election_id = $election['election_id'];
					$manager_id = $election['user_id'];
					$voteCount = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) FROM votes WHERE election_id = '$election_id'"));
			?>
					<div class = "election" name = "<?=$election['title']?>">
						<div class = "date">
							<?php 
								$date = new DateTime($election['lastdate']);
								echo date_format($date, "d")."<br/>".date_format($date, "M");
							?>
						</div>
						<div class="election_detail">
					<?php
						$manager = mysql_fetch_array(mysql_query("SELECT firstname, lastname, user_id FROM users WHERE user_id = '$manager_id'"));
					?>
							<div class = "description">
								<a href="electionDetail.php?election_id=<?=$election_id?>"><b><?=$election['title']?></b></a><br/>
								By <a href = "profile.php?user_id=<?=$manager['user_id']?>" class = 'link'><?=$manager['firstname']?> <?=$manager['lastname']?></a> | <?=$voteCount['COUNT(DISTINCT user_id)']?> vote(s) <br>
								<?=$election['description']?><br>
							</div>
						</div>
					</div>

			<?php
					$election = mysql_fetch_array($result);
				}
			?>
		</div>

		<div id = "footer">
      		Copyright 2013 | Group Name | Election System
    	</div>
		<script type="text/javascript" src="assets/jscript/home.js"></script>
	</div>
</body>
</html>
