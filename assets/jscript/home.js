function searchElection(title) {
	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	}	else {
		request = new ActiveXObject("Microsoft.XMLHttp");
	}

	request.onreadystatechange = function() {
		if (request.readyState == 4 && request.status == 200) {
			document.getElementById("content").innerHTML = request.responseText;
		}	else {
			document.getElementById("content").innerHTML = "searching..";
		}
	}
	request.open("GET", "searchElection.php?title="+title, true);
	request.send();
}


function search(title) {
	var elections = document.getElementsByClassName("election");
	
	for(ctr = 0; ctr < elections.length; ctr++) {
		var name = elections[ctr].attributes.name.value.substring(0,title.length);
		if(name.toLowerCase() == title.toLowerCase()) {
			elections[ctr].style.display = "block";
		}	else {
			elections[ctr].style.display = "none";
		}
	}
}

function vote(election_id) {
	document.getElementById("vote_container").style.visibility = "visible";
	var withpass = document.getElementsByName("with_password"+election_id)[0].value;
	var password = "";
	if (withpass == 1) {
		password = document.getElementsByName("password"+election_id)[0].value;
	}

	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	}	else {
		request = new ActiveXObject("Microsoft.XMLHttp");
	}

	request.onreadystatechange = function() {
		if (request.readyState == 4 && request.status == 200) {
			document.getElementById("vote").innerHTML = request.responseText;
		}	else {
			document.getElementById("vote").innerHTML = "loading";
		}
	}
	request.open("GET", "vote.php?election_id="+election_id+"&with_password="+withpass+"&password="+password, true);
	request.send();
}

function votePrivateElection() {
	document.getElementById("vote_container").style.visibility = "visible";
	var title = document.getElementsByName("vote_election_title")[0].value;
	var password = document.getElementsByName("vote_election_password")[0].value;
	
	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	}	else {
		request = new ActiveXObject("Microsoft.XMLHttp");
	}

	request.onreadystatechange = function() {
		if (request.readyState == 4 && request.status == 200) {
			document.getElementById("vote").innerHTML = request.responseText;
		}	else {
			document.getElementById("vote").innerHTML = "loading";
		}
	}
	request.open("GET", "votePrivateElection.php?title="+title+"&password="+password, true);
	request.send();
}

function hideVote() {
	document.getElementById("vote_container").style.visibility = "hidden";
}

function show_vote_election() {
	document.getElementById("vote_election").style.height = "150px"
	document.onClick = function(e) {
		alert("hey");
	}
}

function hide_vote_election() {
	document.getElementById("vote_election").style.height = "0px"
	document.getElementsByName("vote_election_title")[0].value = "";
	document.getElementsByName("vote_election_password")[0].value = "";
}