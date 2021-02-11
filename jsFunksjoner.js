function updateTrainerSelect(){

	var spillElement = document.getElementById("spillSel"); 
	var tekst = spillElement.options[spillElement.selectedIndex].text;
	params = "spill=" + tekst;

	request = new ajaxRequest();

	request.open("POST", "trenerSelect.php", true);

	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.setRequestHeader("Content-length", params.length);
	request.setRequestHeader("Connection", "close");

	request.onreadystatechange = function(){
		if(this.readyState == 4){
			if(this.status == 200){
				if(this.responseText != null){
					document.getElementById("trenerSel").innerHTML = this.responseText;
				}
				else alert("Ajax error: No data receieved");
			}
			else alert("Ajax error: " + this.statusText);
		}
	}

	request.send(params);
}


function ajaxRequest(){
	try{
		var request = new XMLHttpRequest();
	}
	catch(e1){
		try{
			request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e2){
			try{
				request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e3){
				request =  false;
			}
		}
	}

	return request;
}