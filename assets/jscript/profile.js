function show_edit(firstname, lastname, year, program, address, contact_number, id) {
	document.getElementsByName("firstname")[0].value = firstname;
	document.getElementsByName("lastname")[0].value = lastname;
	document.getElementsByName("year")[0].value = year;
	document.getElementsByName("program")[0].value = program;
	document.getElementsByName("address")[0].value = address;
	document.getElementsByName("contact_number")[0].value = contact_number;
	document.getElementById("edit_profile_container").style.visibility = "visible";
	document.getElementById("pic_preview").style.backgroundImage = "url(assets/images/profile/"+id+".png)";
}

function hide_edit() {
	document.getElementById("edit_profile_container").style.visibility = 'hidden';
}

function change_preview (url) {
	if (url.files && url.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			document.getElementById("pic_preview").style.backgroundImage = "url(" + e.target.result + ")";
		}

		reader.readAsDataURL(url.files[0]);
	}
}

function show_alert(message) {
	document.getElementById("alert_container").style.visibility = 'visible';
	document.getElementById("alert").innerHTML = "<center>"+message+"</center>";
}

function hide_alert(){
	document.getElementById("alert_container").style.visibility = 'hidden';
}

function show_login() {
	document.getElementById("login_info_container").style.visibility = 'visible';
}

function hide_login() {
	document.getElementById("login_info_container").style.visibility = 'hidden';
	document.getElementsByName("old_pass")[0].value = "";
	document.getElementsByName("new_pass")[0].value = "";
	document.getElementsByName("re-new_pass")[0].value = "";
}
