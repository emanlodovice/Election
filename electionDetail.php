<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}
	require("database_connect.php");

	$user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Elections</title>
	<link rel = "stylesheet" type = "text/css" href = "assets/css/viewElection.css">
</head>

<body>
	<script type="text/javascript" src = "assets/jscript/view_elections.js"></script>
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
	<ul>
      <li><a href="home.php">View Elections</a></li>
      <li><a href="iamVoting.php">Elections I'm Voting</a></li>
      <li id='first'><a href="manageElections.php">Manage Elections</a></li>
      <li><a href="profile.php?user_id=<?=$user_id?>">My Profile</a></li>
	</ul>

	<div id = "verify_delete_container">
		<div id = "verify_delete">
			<center> <h2>Are you sure you want to delete this vote?</h2>
				<form action="deleteVote.php" method="post">
					<input type="hidden" name="delete_election_id" value="">
					<input type="hidden" name="delete_user_id" value="">
					<input type="submit" class = 'button' value="Yes">
					<input type="button" class = 'button' name="cancel_delete" value="No" onclick="hide_verify_delete()">
				</form>
			</center>
		</div>
	</div>

	<?php
		$election_id = $_GET['election_id'];

		$electionQuery = "SELECT * FROM elections WHERE election_id = '$election_id'";
		$election = mysql_query($electionQuery);
		$election_detail = mysql_fetch_array($election);
		echo "<center><h1>".$election_detail['title']."</h1></center>";

		$positionQuery = "SELECT * FROM positions WHERE election_id = '$election_id'";
		$position = mysql_query($positionQuery);
	?>

	<div id = "content">
	<?php
		while ($position_detail = mysql_fetch_array($position)) {
			$position_id = $position_detail['position_id'];
			$totalVotesQuery = "SELECT COUNT(*) FROM votes WHERE election_id = '$election_id' AND position_id = '$position_id'";
			$tcount = mysql_fetch_array(mysql_query($totalVotesQuery));
			$totalCount = $tcount['COUNT(*)'];
	?>
		<div class = "positions">
			<h3><?=$position_detail['title']?></h3>
	<?php
		$candidateQuery = "SELECT * FROM candidates WHERE position_id = '$position_id'";
		$candidate = mysql_query($candidateQuery);
		$ctr = 0;
		$winner = null;
		$winner_vote = -1;
		while ($candidate_detail = mysql_fetch_array($candidate)) {
			$candidate_id = $candidate_detail['candidate_id'];
	?>
			<div class = "candidate">
				<div class = "names">
					<?php
						$party_id = $candidate_detail['party_id'];
						$partyQuery = "SELECT * FROM parties WHERE party_id = '$party_id'";
						$party_detail = mysql_fetch_array(mysql_query($partyQuery));
						echo $candidate_detail['name']." (".$party_detail['title'].")";
					?>
				</div>
				<div class = "graph">
					<?php 
						$voteQuery = "SELECT COUNT(*) FROM votes WHERE election_id = '$election_id' AND candidate_id = '$candidate_id'";
						$count = mysql_fetch_array(mysql_query($voteQuery));
					?>
					<div class = "bar" id = "<?=$candidate_id?>">
						<h5><?=$count['COUNT(*)']?> votes</h5>
					</div>
					<?php
						if ($winner == null) {
							$winner[0] = $candidate_detail['name']." from ".$party_detail['title'];
							$winner_vote = $count['COUNT(*)'];
						}	else {
							if ($winner_vote < $count['COUNT(*)']) {
								empty($winner);
								$winner[0] = $candidate_detail['name']." from ".$party_detail['title'];
								$winner_vote = $count['COUNT(*)'];
							}	else if ($winner_vote == $count['COUNT(*)']) {
								$winner[count($winner)] = $candidate_detail['name']." from ".$party_detail['title'];
							}
						}
					?>
				</div>
				<script >modifybars("<?=$candidate_id?>", "<?=$ctr?>", "<?=$count['COUNT(*)']?>", "<?=$totalCount?>"); </script>
			</div>
	<?php
			$ctr++;
		}
	?>	<div class = "winner">
			<?php 
				if (count ($winner) > 0) {
					if (count($winner) == 1) {
						if ($election_detail['status'] == 0) {
							echo "<b>Winner</b> <br/>";
						}	else {
							echo "<b>Leading</b> <br/>";
						}
					echo $winner[0]."<br>";
					}	else {
						echo "<b>Tie Between</b><br/>";
						for ($ctr = 0; $ctr < count($winner); $ctr++) {
							echo $winner[$ctr]."<br/>";
						}
					}
				}	else {
					echo "<b>No Candidates</b>";
				}
			?>
		</div>
	</div><br/><br/><br/><br/>
	<?php
		}
	?>
	<div id = "voter_container">
		<h2> Voters </h2>
		<?php 
			$voteRes = mysql_query("SELECT * FROM users WHERE user_id IN (SELECT DISTINCT user_id FROM votes WHERE election_id = '$election_id')");
			$voter = mysql_fetch_array($voteRes);

			if (!$voter) {
				echo "<h3>No one voted yet!";
			}

			while($voter) {
				$voter_id = $voter['user_id'];
		?>
				<div class = "voter">
					<div class = "voter_name">
						<a href="profile.php?user_id=<?=$voter['user_id']?>" class = 'link'><?=$voter['firstname']." ".$voter['lastname']?></a>
					</div>
		<?php
				if ($election_detail['user_id'] == $user_id) {
		?>
					<div class = "action">
						<input type="button" class = 'button' value = "Delete" onclick="verifyDelete(<?=$election_id?>, <?=$voter_id?>)">
					</div>
				
		<?php
				}
		?>
				</div>
		<?php
				$voter = mysql_fetch_array($voteRes);
			}
		?>
	</div>
		<div class = 'clear'></div>
	</div>
	
	<div id = "footer">
    	Copyright 2013 | Group Name | Election System
    </div>
</div>
</body>
</html>