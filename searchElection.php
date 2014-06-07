<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}
	require("database_connect.php");
	$title = $_GET['title'];
	$user_id = $_SESSION['user_id'];

	$query = "SELECT * FROM elections WHERE title LIKE '$title%' AND privacy = '0' AND status = '1'";
	$result = mysql_query($query);
	while($election = mysql_fetch_array($result)) {
		$election_id = $election['election_id'];

		$checkVote = "SELECT * FROM votes WHERE election_id = '$election_id' AND user_id = '$user_id'";
		$r = mysql_query($checkVote);
		$vote = mysql_fetch_array($r);
		if (!$vote) { 
			$manager_id = $election['user_id'];
			$manager = "SELECT firstname,lastname FROM users WHERE user_id='$manager_id'";
			$res = mysql_query($manager);
			$managerDetail = mysql_fetch_array($res)
			$name = $name = $managerDetail['firstname']." ".$managerDetail['lastname'];
			echo "<div class = 'election'>
					<h3>".$election['title']."</h3> by ". $name ."
					<button>vote</button>
				  </div>";
		 }   
	}

?>