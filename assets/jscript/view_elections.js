var colors = new Array("#D9001C" , "#219E00" , "#001C97" , "#E3D900" , "#8FBC00", "#E34500", "#90B1D9", "#CFD748");

function modifybars (candidate_id, count, vote, totalVote) {
	var bar = document.getElementById(candidate_id);
	var percentage = (vote / totalVote) * 100;
	bar.style.background = colors[count % 8];
	bar.style.width = percentage + '%';
}


function verifyDelete(election_id, voter_id) {
	document.getElementsByName("delete_election_id")[0].value = election_id;
	document.getElementsByName("delete_user_id")[0].value = voter_id;
	document.getElementById("verify_delete_container").style.visibility = "visible";
}

function hide_verify_delete() {
	document.getElementById("verify_delete_container").style.visibility = "hidden";
}