var container = document.getElementById("positions");
var posCount = document.getElementById("posCount");
var count = 0;
var titleStatus = "status";

function verifyNewElection() {
	var isEmpty = true;
	if(document.getElementsByName("title")[0].value.length > 0 && titleStatus == "") {
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
	var position = document.createElement("input");
	position.type="text";
	position.name="position" + count;
	position.id="position";
	position.placeholder="position name";
	position.addEventListener("keyup",verifyNewElection);
	count++;
	posCount.value=count;
	container.appendChild(position);
	container.appendChild(document.createElement("br"));
}