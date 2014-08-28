
function changeName(name){
	document.getElementById("changename").innerHTML = name;

}

function GoToSavings(){
	document.getElementById("dailycollect").style.display="none";
	document.getElementById("savingscollect").style.display="";

}

function GoToDailyCollection(){
	document.getElementById("dailycollect").style.display="";
	document.getElementById("savingscollect").style.display="none";

}