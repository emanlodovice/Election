
var titleStatus = "status";

function verifyNewElection() {
	var isEmpty = true;
	if(document.getElementsByName("title")[0].value.length > 0 && document.getElementsByName("lastdate")[0].value.length > 0 && document.getElementsByName("description")[0].value.length > 0 && titleStatus == "") {
		var count = document.getElementById("posCount").value;
		for (ctr = 0; ctr < count; ctr++) {
			if (document.getElementsByName("position" + ctr)[0].value.length > 0) {
				isEmpty = false;
				break;
			}
		}
		if(isEmpty) {
			document.getElementsByName("create_election")[0].disabled=true;
		}	else {
			document.getElementsByName("create_election")[0].disabled=false;
		}
	}	else {
		document.getElementsByName("create_election")[0].disabled=true;
	}
}

function checkTitle(title) {
	if (title.length > 0) {
		if (window.XMLHttpRequest) {
			request = new XMLHttpRequest();
		}	else {
			request = new ActiveXObject("Microsoft.XMLHttp");
		}

		request.onreadystatechange = function() {
			if(request.readyState == 4 && request.status == 200) {
				document.getElementById("verifyTitle").innerHTML = request.responseText;
				if(request.responseText == "") {
					titleStatus = "";
				}	else {
					titleStatus = "status";
				}
			}	else {
				document.getElementById("verifyTitle").innerHTML = "Checking title...";
			}
		}
		request.open("GET","verify_title.php?title="+title, true);
		request.send();
	}
}

function add_position() {
	var container = document.getElementById("positions");
	var posCount = document.getElementById("posCount");
	var count = posCount.value;
	var position = document.createElement("input");
	position.type="text";
	position.name="position" + count;
	position.id="position";
	position.placeholder="position name";
	position.addEventListener("keyup",verifyNewElection);
	count++;
	posCount.value=count;
	var height = 450 + (count * 27);
	document.getElementById("add_election").style.height = height+"px";
	container.appendChild(position);
	container.appendChild(document.createElement("br"));
	
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

function showPassword(election_id) {
	document.getElementById("password_container").style.visibility = "visible";
	document.getElementsByName("election_id")[0].value = election_id + "";

	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	}	else {
		request = new ActiveXObject("Microsoft.XMLHttp");
	}

	request.onreadystatechange = function() {
		if (request.readyState == 4 && request.status == 200) {
			document.getElementById("availablePasswords").innerHTML = request.responseText;
		}	else {
			document.getElementById("availablePasswords").innerHTML = "<img src = 'assets/images/loading.gif'> <h5>searching..</h5>";
		}
	}
	request.open("GET", "searchPassword.php?election_id="+election_id, true);
	request.send();
}

function generatePassword() {
	var election_id = document.getElementsByName("election_id")[0].value;
	var count = document.getElementsByName("count")[0].value;

	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	}	else {
		request = new ActiveXObject("Microsoft.XMLHttp");
	}

	request.onreadystatechange = function() {
		if (request.readyState == 4 && request.status == 200) {
			showPassword(election_id);
		}	else {
			document.getElementById("availablePasswords").innerHTML = "<img src = 'assets/images/loading.gif'> <h5>searching..</h5>";
		}
	}
	request.open("GET", "generatePassword.php?election_id="+election_id+"&count="+count, true);
	request.send();
}

function hidePassword(key) {
	document.getElementById("password_container").style.visibility = "hidden";
}

function changeElectionStatus(election_id) {
	var status = document.getElementsByName("status" + election_id)[0];
	if (status.value == "Open Election") {
		updateElectionStatus(1, election_id);
		status.value = "Close Election";
		addPartyVisibility(election_id, "none");
	}	else {
		updateElectionStatus(0, election_id);
		status.value = "Open Election";
		addPartyVisibility(election_id, "inline-block");
	}
}

function updateElectionStatus(status, election_id) {
	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	}	else {
		request = new ActiveXObject("Microsoft.XMLHttp");
	}

	request.onreadystatechange = function() {
		if (request.readyState == 4 && request.status == 200) {
			document.getElementById("loading_container").style.visibility = "hidden";
		}	else {
			document.getElementById("loading_container").style.visibility = "visible";
		}
	}
	request.open("GET", "updateElectionStatus.php?election_id="+election_id+"&status="+status, true);
	request.send();
}


function deleteParty(election_id) {
	document.getElementById("delete_party").attributes.name.value = election_id;
	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	}	else {
		request = new ActiveXObject("Microsoft.XMLHttp");
	}

	request.onreadystatechange = function() {
		if (request.readyState == 4 && request.status == 200) {
			document.getElementById("delete_candidates").innerHTML = request.responseText;
			document.getElementById("loading_container").style.visibility = "hidden";
			document.getElementById("delete_party_container").style.visibility = "visible";
		}	else {
			document.getElementById("loading_container").style.visibility = "visible";
		}
	}
	request.open("GET", "seeCandidates.php?election_id="+election_id, true);
	request.send();
}

function hide_deleteParty() {
	document.getElementById("delete_party_container").style.visibility = "hidden";
}

function verifyDeleteParty(party_id, election_id) {
	document.getElementsByName("delete_party_id")[0].value = party_id;
	document.getElementsByName("delete_party_election_id")[0].value = election_id;
	document.getElementById("verify_delete_party_container").style.visibility = "visible";
}

function verifyDeleteCandidate(candidate_id, election_id, party_id) {
	document.getElementsByName("delete_candidate_id")[0].value = candidate_id;
	document.getElementsByName("delete_candidate_election_id")[0].value = election_id;
	document.getElementsByName("delete_candidate_party_id")[0].value = party_id;
	document.getElementById("verify_delete_candidate_container").style.visibility="visible";

}

function doDeleteParty() {
	var party_id = document.getElementsByName("delete_party_id")[0].value;
	var election_id = document.getElementsByName("delete_party_election_id")[0].value;
	if (party_id != "" && election_id != "") {
		hide_deleteParty();
		if (window.XMLHttpRequest) {
			request = new XMLHttpRequest();
		}	else {
			request = new ActiveXObject("Microsoft.XMLHttp");
		}

		request.onreadystatechange = function() {
			if (request.readyState == 4 && request.status == 200) {
				document.getElementById("loading_container").style.visibility = "hidden";
				hide_verify_delete_party();
				deleteParty(election_id);
			}	else {
				document.getElementById("loading_container").style.visibility = "visible";
			}
		}
		request.open("GET","deleteParty.php?party_id="+party_id+"&election_id="+election_id, true);
		request.send();
	}
}

function doDeleteCandidate() {
	var candidate_id = document.getElementsByName("delete_candidate_id")[0].value;
	var election_id = document.getElementsByName("delete_candidate_election_id")[0].value;
	var party_id = document.getElementsByName("delete_candidate_party_id")[0].value;
	document.getElementById("verify_delete_candidate_container").style.visibility="visible";
	if (candidate_id != "" && election_id != "" && party_id != "") {
		hide_deleteParty();
		if (window.XMLHttpRequest) {
			request = new XMLHttpRequest();
		}	else {
			request = new ActiveXObject("Microsoft.XMLHttp");
		}

		request.onreadystatechange = function() {
			if (request.readyState == 4 && request.status == 200) {
				document.getElementById("loading_container").style.visibility = "hidden";
				hide_verify_delete_candidate();
				deleteParty(election_id);
			}	else {
				document.getElementById("loading_container").style.visibility = "visible";
			}
		}
		request.open("GET","deleteCandidate.php?party_id="+party_id+"&election_id="+election_id+"&candidate_id="+candidate_id, true);
		request.send();
	}
}

function hide_verify_delete_party() {
	document.getElementById("verify_delete_party_container").style.visibility = "hidden";
}

function hide_verify_delete_candidate() {
	document.getElementById("verify_delete_candidate_container").style.visibility="hidden";
}

function addParty(election_id) {
	document.getElementById("party").attributes.name.value = election_id;
	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest();
	}	else {
		request = new ActiveXObject("Microsoft.XMLHttp");
	}

	request.onreadystatechange = function() {
		if (request.readyState == 4 && request.status == 200) {
			document.getElementById("candidate_positions").innerHTML = request.responseText;
			document.getElementById("loading_container").style.visibility = "hidden";
			document.getElementById("party_container").style.visibility = "visible";
		}	else {
			document.getElementById("loading_container").style.visibility = "visible";
		}
	}
	request.open("GET", "seePositions.php?election_id="+election_id, true);
	request.send();
}

function addPartyVisibility(election_id, display) {
	document.getElementsByName("add_party"+election_id)[0].style.display = display;
	document.getElementsByName("delete_party"+election_id)[0].style.display = display;
}

function hide_addParty() {
	document.getElementById("party_container").style.visibility = "hidden";
}

function check_party_name(title) {
	var election_id = document.getElementById("party").attributes.name.value;
	if (title.length > 0) {
		if (window.XMLHttpRequest) {
			request = new XMLHttpRequest();
		}	else {
			request = new ActiveXObject("Microsoft.XMLHttp");
		}

		request.onreadystatechange = function() {
			if(request.readyState == 4 && request.status == 200) {
				document.getElementById("verifyPartyName").innerHTML = request.responseText;
				if(request.responseText == "") {
					document.getElementById("bCreateParty").disabled = false;
				}	else {
					document.getElementById("bCreateParty").disabled = true;
				}
			}	else {
				document.getElementById("verifyPartyName").innerHTML = "Checking party name ...";
			}
		}
		request.open("GET","verifyPartyName.php?title="+title+"&election_id="+election_id, true);
		request.send();
	}
}

function verify_delete(election_id) {
	document.getElementById("verify_delete_container").style.visibility = "visible";
	document.getElementsByName("delete_election_id")[0].value = election_id;
}

function hide_verify_delete() {
	document.getElementById("verify_delete_container").style.visibility = "hidden";
}

function show_add_election() {
	document.getElementById("add_election").style.height = "450px";
}

function hide_add_election() {
	document.getElementById("add_election").style.height = "0px";
	var posCount = document.getElementById("posCount").value = "0";
	document.getElementsByName("title")[0].value = "";
	document.getElementsByName("description")[0].value = "";
	document.getElementsByName("lastdate")[0].value = "";
	document.getElementById("positions").innerHTML = "";
}

function edit_election(election_id, password, privacy) {
	document.getElementsByName("edit_election_id")[0].value=election_id;	
	document.getElementById("election_settings_container").style.visibility = "visible";
	if (password == 1) {
		document.getElementsByName("edit_password")[0].checked = true;
		document.getElementsByName("edit_password")[1].checked = false;
	}	else {
		document.getElementsByName("edit_password")[1].checked = true;
		document.getElementsByName("edit_password")[0].checked = false;
	}

	if (privacy == 1) {
		document.getElementsByName("edit_privacy")[1].checked = true;
		document.getElementsByName("edit_privacy")[0].checked = false;
	}	else {
		document.getElementsByName("edit_privacy")[0].checked = true;
		document.getElementsByName("edit_privacy")[1].checked = false;
	}
}

function hide_edit_election() {
	document.getElementById("election_settings_container").style.visibility = "hidden";
	document.getElementsByName("edit_lastdate")[0].value="";	
}

