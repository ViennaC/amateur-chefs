var xhr;
if (window.ActiveXObject) {
    xhr = new ActiveXObject ("Microsoft.XMLHTTP");
}
else if (window.XMLHttpRequest) {
    xhr = new XMLHttpRequest ();
}

function callServer() {
	var username = document.getElementById("username").value;
	if (username == null || username == "") {
		return;
	}
	var url = "./checkingUsername.php?username=" + escape(username);
	xhr.open ("GET", url, true); 

	xhr.onreadystatechange = updatePage; 

	xhr.send(null);  
} 	

function updatePage() {
    if (xhr.readyState == 4) { 
        if (xhr.status == 200) { 
            var response = xhr.responseText.trim();
	    if (response == 'true') {
		    alert('That username is already taken.');
            }
        } 
    } 
} 
