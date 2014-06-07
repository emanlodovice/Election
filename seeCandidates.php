<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}

	require("database_connect.php");

	$election_id = $_GET['election_id'];

	$result = mysql_query("SELECT parties.party_id, parties.title, candidates.candidate_id, candidates.name, positions.title AS position
							FROM parties
							JOIN candidates, positions
							WHERE parties.party_id = candidates.party_id
							AND candidates.position_id = positions.position_id
							AND parties.election_id = '$election_id'
							ORDER BY parties.party_id");

	$previous_party_id = null;
	$candidate = mysql_fetch_array($result);
	if (!$candidate) {
		echo "<center>No candidates yet!</center>";
	}
	while ($candidate) {
		if ($candidate['party_id'] != $previous_party_id) {
			$previous_party_id = $candidate['party_id'];
			echo "<div class = 'election_party'>";
			echo "<div class = 'election_party_name'><h4>".$candidate['title']."</h4></div><div class = 'delete_party_delete'><input type='button' value = 'Delete Party' class = 'button' onclick='verifyDeleteParty(".$candidate['party_id'].",".$election_id.")'></div>";
		}	
			echo "<div class = 'election_candidate'>";
			echo "<div class = 'election_candidate_name'>".$candidate['name']." for ".$candidate['position']."</div>";
			echo "<div class = 'election_candidate_delete'><input type = 'button' value = 'Delete Candidate' class = 'button' onclick = 'verifyDeleteCandidate(".$candidate['candidate_id'].",".$election_id.",".$candidate['party_id'].")'></div>";
			echo "</div>";
		$candidate = mysql_fetch_array($result);
		if ($candidate['party_id'] != $previous_party_id) {
			echo "</div>";
		}
	}
	
?>