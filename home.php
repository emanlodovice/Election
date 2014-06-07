<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("location:index.php");
	}
	require("database_connect.php");
	date_default_timezone_set("America/Los_Angeles");
	$currentDate = date("Y-m-d H:i:s");
  $user_id = $_SESSION['user_id'];
?>

<html>
<head>
	<title>Election</title>
	<link rel="stylesheet" type="text/css" href="assets/css/home1.css">
</head>

<body>
	<div id="container">
		<div id="header"> 
			<div id="greeting">Welcome, <a href="profile.php?user_id=<?=$user_id?>" class = 'link'><?php echo $_SESSION['user_firstname']." ".$_SESSION['user_lastname'];?></a>!</div>

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
      <li id='first'>View Elections</li>
      <li><a href="iamVoting.php">Elections I'm Voting</a></li>
      <li><a href="manageElections.php">Manage Elections</a></li>
      <li><a href="profile.php?user_id=<?=$user_id?>">My Profile</a></li>
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
            $managerDetail = mysql_fetch_array(mysql_query("SELECT firstname,lastname FROM users WHERE user_id='$manager_id'"));
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
                <div class = "description" name="<?=$election['title']?>">
                  <b><?=$election['title']?></b> <br/>
                  posted by <?=$name?> | <?=$voteCount['COUNT(DISTINCT user_id)']?> vote(s)<br/>
                  <?=$election['description']?><br/>
                </div>

                <div class = "password">
                    <?php if ($election['password'] == 1) { ?>
                      Password<input type="password" name="password<?=$election_id?>"><br/>
                    <?php
                      }
                    ?>
                      <input type="hidden" value="<?=$election['password']?>" name="with_password<?=$election_id?>">
                      <input class ="voteButton" type="button" value="vote" onclick="vote(<?=$election_id?>)">
                  </form>
                </div>
              </div>
              <br/>
              <div class = 'clear'></div>
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