<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}
	require("database_connect.php");
	date_default_timezone_set("America/Los_Angeles");
	$currentDate = date("Y-m-d H:i:s");
?>

<html>
<head>
	<title>Election</title>
	<link rel="stylesheet" type="text/css" href="assets/css/home1.css">
</head>

<body>
	<div id="container">
		<div id="header"> 
			<div id="greeting">Welcome, <a href="#user">User</a>!</div>

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
      <li id='first'>View Elections</li>
      <li><a href="iamVoting.php">Elections I'm Voting</a></li>
      <li><a href="manageElections.php">Manage Elections</a></li>
      <li><a href="#myProfile">My Profile</a></li>
    </ul>

		<div id="content">
      <br>
			<h1> &nbsp &nbsp ONGOING ELECTIONS </h1>
			<div id="elections">
				<?php
          $user_id = $_SESSION['user_id'];
          $query = "SELECT * FROM elections WHERE privacy = '0' AND status = '1' AND lastdate >= '$currentDate' AND election_id NOT IN (SELECT DISTINCT election_id FROM votes WHERE user_id = '$user_id') order by lastdate asc";
          $result = mysql_query($query);
          $hasElection = false;
          while($election = mysql_fetch_array($result)) {
            $election_id = $election['election_id'];
            $hasElection = true;
            $manager_id = $election['user_id'];
            $manager = "SELECT firstname,lastname FROM users WHERE user_id='$manager_id'";
            $res = mysql_query($manager);
            $managerDetail = mysql_fetch_array($res);
            $name = $managerDetail['firstname']." ".$managerDetail['lastname'];
        ?>
            <div class = "election" name="<?=$election['title']?>">
              <div class = "date">
                <?php 
                  $date = new DateTime($election['lastdate']);
                  echo date_format($date, "d")."<br/>".date_format($date, "M");
                  $voteCount = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT user_id) FROM votes WHERE election_id = '$election_id'"));
                ?>
              </div>

              <div class = "election_detail">
                <div class = "description">
                  <?=$election['description']?> <br/>
                  posted by <?=$name?> | <?=$voteCount['COUNT(DISTINCT user_id)']?> vote(s)<br/>
                </div>

                <div class = "password">
                  <form action="<?='vote.php?election_id='.$election_id.'&password='.$election['password'];?>" method="post">
                    <?php if ($election['password'] == 1) { 
                      echo 'Password<input type="password" name="election_password"><br/>'; }
                    ?>
                      <input id ="voteButton" type="submit" value="vote">
                  </form>
                </div>
              </div>
            </div>

        <?php

          }
          if (!$hasElection)
            echo "<h2>No Elections</h2>";
        ?>
            </div>

      <script type="text/javascript" src="assets/jscript/home.js"></script>
    </div>

    <div id = "footer">
      Copyright 2013 | Group Name | Election System
    </div>
  </div>
</body>
</html>