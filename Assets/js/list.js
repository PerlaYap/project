function hide(){
	document.getElementById('daily').style.display = "none";
	document.getElementById('yearly').style.display = "none";
	document.getElementById('yearlyCompare').style.display = "none";
	
}

function hideDCS(){
	document.getElementById('dcs').style.display = "none";
}

function show(date){
	
	hide();

	if (date=="daily"){
		document.getElementById('daily').style.display = "";
	}else if (date=="yearly"){
		document.getElementById('yearly').style.display = "";
	}else if (date=="yearlyCompare"){
		document.getElementById('yearlyCompare').style.display = "";
	}
}

function showTable(){
	document.getElementById('table').style.display = "";
}

function openPop(){
	var Sel_Ind = document.getElementById('myURLs').selectedIndex;
	var popUrl = document.getElementById('myURLs').options[Sel_Ind].value;
	winpops=window.open(popUrl,"","width=400,height=338,resizable,")
}


function showDCS(date){
	
	hideDCS();

	if (date=="dcs"){
		document.getElementById('dcs').style.display = "";
	}
}
