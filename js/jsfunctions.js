function httpRequest() { //this function will create the XHR object in different browsers and IE versions
	try {
		object = new XMLHttpRequest();
	} catch(err1) {
		try {
			object = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (err2) {
			try {
				object = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (err3) {
				object = false;
			}
		}
	}
	return object;
}

function signIn(){ 
	var signrequest = new httpRequest(); //we create the XHR objetct
	signrequest.onreadystatechange = function(){ 
		if(signrequest.readyState == 4 && signrequest.status == 200){ //readyState 4 = request finished and response ready, 
			//status 200 = success request
			document.getElementById(state).innerHTML = signrequest.responseText;
		} 
	}

	signrequest.open('POST', URL, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.send("name=" + name, );	

}



function product(txt){
	var pxml = new httpRequest();
	if(txt==""){
		document.getElementById('productcontent').innerHTML = "";
		return;
	}
	pxml.onreadystatechange = function(){
		if(pxml.readyState == 4 && pxml.status == 200){
			document.getElementById('productcontent').innerHTML = pxml.responseText;
		}
	}
	pxml.open('GET', 'products.php?p='+ txt, true);
	pxml.send();
}

function getdata(url, nombre){
	document.getElementById('loader').style.display = 'block';
	var req = httpRequest();
	req.onreadystatechange=function(){
		if(req.readyState == 0)
			alert('Request not initialized');
		if(req.readyStatec == 1)
			alert('Server connection established');
		if(req.readyState==2)
			alert('Request Received');
		if(req.readyState==3)
			alert('Processing Request');
 	 	if (req.readyState==4 && req.status==200){
 	 		    document.getElementById("display").innerHTML=req.responseText;
 	 		    document.getElementById('loader').style.display = 'none';
 	    }
    	if(req.status == 404){
    		document.getElementById("display").innerHTML = "File not found";	
    	}
  	}
	// req.open("GET", 'vr.txt?i=' + Math.random(), true)
	req.open("post", url +"?val=" +  Math.random(), true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.send("nombre=" + nombre);	
	//document.getElementById('display').innerHTML = req.responseText;
}

function hints(text){
	if(text.length == 0){
		document.getElementById('hints').innerHTML=="";
		return;
	}
	var hintreq = new httpRequest();
	hintreq.onreadystatechange = function(){
		if(hintreq.readyState == 4 && hintreq.status == 200){
			document.getElementById('hints').innerHTML= hintreq.responseText;
		}
	}
	hintreq.open('GET', 'js/hint.php?q=' + text, true);
	hintreq.send();
}


function voto(voto){
	var votohttp = new httpRequest();
	votohttp.onreadystatechange = function(){
		if(votohttp.readyState == 4 && votohttp.status == 200){
			document.getElementById('votos').innerHTML = votohttp.responseText;
		}
	}
	votohttp.open('GET','votos.php?v=' + voto, true);
	votohttp.send();
}