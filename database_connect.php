<?php
	$con = mysql_connect("localhost", "root", "");
	if (!$con) {
		die("Could not connect to server. " . mysql_error());
	}
	mysql_select_db("Election") or die("Could not connect to database. " . mysql_error());
	
?>