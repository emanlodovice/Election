<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header('location:index.php');
	}
	require("database_connect.php");

	$election_title = $_GET['title'];
	$password = $_GET['password'];
	$election = mysql_fetch_array(mysql_query("SELECT * FROM elections WHERE title = '$election_title'"));
	if (!$election) {
		echo "Wrong election title or password <br/><br/>";
		echo "<input type='button' class = 'button' value = 'Cancel' onclick='hideVote()'>";
	}	else {
		$election_id = $election['election_id'];
		$res = mysql_fetch_array(mysql_query("SELECT * FROM passwords WHERE election_id = '$election_id' AND password = '$password'"));
		if(($election['password'] == 1) && (!$res)) {
			echo "Wrong election title or password <br/><br/>";
			echo "<input type='button' class = 'button' value = 'Cancel' onclick='hideVote()'>";

		}	else {

			echo "<form action='castVote.php?election_id=".$election_id."&password=".$password."' method='post'>";
				echo "<center><h3>".$election['title']."</h3>";
				$q = "SELECT positions.position_id, positions.title AS position, candidates.candidate_id, candidates.name, parties.title AS party FROM positions JOIN candidates, parties WHERE positions.election_id = '$election_id' AND candidates.position_id = positions.position_id AND parties.party_id = candidates.party_id order by positions.position_id asc";
				$result = mysql_query($q);
				$row = mysql_fetch_array($result);
				$prevPos = null;
				while($row) {
					if ($prevPos != $row['position_id']) {
						$prevPos = $row['position_id'];
						echo $row['position'];
						echo "<select name = ".$row['position_id'].">";
						echo "<option value='' disabled='disabled'>Candidates</option>";
					}
					echo "<option value = '" . $row['candidate_id'] . "'>" . $row['name'] . "(" . $row['party'] . ")" . "</option>";
					$row = mysql_fetch_array($result);
					if ($prevPos != $row['position_id'] || (!$row)) {
						echo "</select><br/>";
					}
				}
			echo "<br/><br/>";
			echo "<input type='submit' value = 'Vote' class = 'button'>";
			echo "<input type='button' value='cancel' onclick='hideVote()' class ='button'>";
			echo "</form>";
		}
	}
?>
