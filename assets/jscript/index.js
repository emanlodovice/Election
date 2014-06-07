
document.getElementById("container").style.minHeight = window.innerHeight + "px";
document.getElementById("banner").style.height = (window.innerHeight / 4.7) + "px";
content = document.getElementById("content");
content.style.height = ((window.innerHeight / 4) * 2.7) + "px";
content.style.borderRadius = (window.innerHeight / 30) + "px";
document.getElementById("signUpForm").style.width = (window.innerWidth / 3) + "px";

var baseUrl = "http://localhost/election/";
var verif = 0;

function popup() {
	ls = document.getElementById("overlay");
	ls.style.visibility = "visible";
	document.getElementsByClassName("loginInput")[0].tabIndex="-1";
	document.getElementsByClassName("loginInput")[1].tabIndex="-1";
	document.getElementById("passButton").tabIndex="-1";
	document.getElementById("bSignUp").tabIndex="-1";
}

function verifyPassword() {
	var pass = document.getElementsByName("password")[0].value;
	var repass = document.getElementsByName("rePassword")[0].value;
	var nameLength = document.getElementsByName("firstName")[0].value.length;
	var lastLength = document.getElementsByName("lastName")[0].value.length;
	var emailLength = document.getElementsByName("email")[0].value.length;

	if  ((pass == repass) && (pass.length > 0) && (repass.length > 0) && (nameLength > 0) && (lastLength > 0) && (emailLength > 0) && (verif == "")) {
		document.getElementById("signUpButton").disabled = false;
	}	else {
		document.getElementById("signUpButton").disabled = true;
	}
}

function validateEmail(email) {
	
	if (email.length > 0) {
		if (window.XMLHttpRequest) {
			xmlhttp=new  XMLHttpRequest();
		}	else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("verifEmail").innerHTML= xmlhttp.responseText;
				verif = xmlhttp.responseText;
			}	else {
				document.getElementById("verifEmail").innerHTML= "Checking email...";
			}
		}
		
	}
	xmlhttp.open("GET", "verify_email.php?email="+email, true);	
	xmlhttp.send();
}

function cancelSignUp() {
	document.getElementById("overlay").style.visibility="hidden";
	document.getElementsByClassName("loginInput")[0].tabIndex="0";
	document.getElementsByClassName("loginInput")[1].tabIndex="0";
	document.getElementById("passButton").tabIndex="0";
	document.getElementById("bSignUp").tabIndex="0";
}