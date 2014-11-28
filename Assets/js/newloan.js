// test=0;
// income=0;
material=0;

function addMaterial(){
	if(material==material){
		document.getElementById('material').innerHTML +="<label><span></span></label>Material Type:<p class='reqd'>*</p><select required='true' name='materials' class='material_1' style='width:220px;'> <option value=' '></option> <option value='Advertising'>Advertising</option> <option value='Business Goods'>Business Goods</option> <option value='Business Supplies'>Business Supplies</option> <option value='Construction Materials'>Construction Materials</option><option value='Employee Salary'>Employee Salary</option> <option value='Labor Cost'>Labor Cost</option> <option value='Office Supplies'>Office Supplies</option> <option value='Others'>Others</option> <option value='Monthly Rent'>Monthly Rent</option> <option value='Taxes'>Taxes</option><option value='Transportation Service'>Transportation Service</option><option value='Utilities'>Utilities</option></select>&nbsp&nbsp&nbspUnit Price:<p class='reqd'>*</p><input required='true'  type='text' name='unitprice' class='unitprice_1' style='width: 80px;' placeholder='Peso'/> &nbsp&nbsp "; 
		material+=1;
	}
				
}

// function addIncome(){
// 	if(income==income){
// 		document.getElementById('income').innerHTML +="<label><span></span></label><select style='width: 210px;'><option selected></option><option value=''> </option></select> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Daily Income: <input id='incometxt' class='incometxt' type='text' name='income[]' style='width:200px;' />"; 
// 	}
// }

// function addFamEx(){
// 	if(income==income){
// 		document.getElementById('famex').innerHTML +="<label><span></span></label><select style='width: 210px;'><option selected></option><option value=''> </option></select> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Daily Expense: <input id='' type='text' name='' style='width:200px;' />"; 
// 	}
// }

// function addBusEx(){
// 	if(income==income){
// 		document.getElementById('busex').innerHTML +="<label><span></span></label><select style='width: 210px;'><option selected></option><option value=''> </option></select> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Daily Expense: <input id='' type='text' name='' style='width:200px;' />"; 
// 	}
// }

// function addIncEx(){
// 	if(income==income){
// 		document.getElementById('incex').innerHTML +="<label><span></span></label><select style='width: 210px;'><option selected></option><option value=''> </option></select> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Expense: <input id='' type='text' name='' style='width:200px;' />"; 
// 	}
// }


function hideDiv(){
	document.getElementById("newbusiness").style.display = "none";
	document.getElementById("newhousehold").style.display = "none";

}

function showBusiness(divID){

	if (divID == "newbusiness"){
		var div = document.getElementById(divID);
		div.style.display = "";
	}else{
		document.getElementById("newbusiness").style.display = "none";
	}

}

function showCoMaker(divID){

	if (divID == "newhousehold"){
		var div = document.getElementById(divID);
		div.style.display = "";
	}else{
		document.getElementById("newhousehold").style.display = "none";
	}

}

	function check(){
	var difference=parseFloat(document.getElementById("difference").value);
	var totalIncome=parseFloat(document.getElementById("incometotal").value);
	var totalExpense=parseFloat(document.getElementById("expensetotal").value);
	var loanCheck=parseFloat(replace(",","",(document.getElementById("maxLoan").value));
	var loanInput=parseFloat(document.getElementById("loanamount").value);
	var materialTotal=parseFloat(document.getElementById("materialtotal").value);

	document.getElementById("loanamount").style.border="";
	document.getElementById("loanamount").style.border="";
	document.getElementById("expensetotal").style.border="";
	document.getElementById("incometotal").style.border="";
	document.getElementById("materialtotal").style.border="";

	if(totalIncome==0 && totalExpense==0){
		document.getElementById("expensetotal").style.border="thin solid red";
		document.getElementById("incometotal").style.border="thin solid red";
		alert("Credit Investigation Part Not Filled Up");
		return false;
	}else if(loanInput>loanCheck){
		document.getElementById("loanamount").style.border="thin solid red";
		alert("Loan Input greater than permitted");
		return false;
	} else if(materialTotal>loanInput){
		document.getElementById("loanamount").style.border="thin solid red";
		document.getElementById("materialtotal").style.border="thin solid red";
		alert("Loan Input and Material Total Not Equal");
		return false;
	}else if(difference<0){
		document.getElementById("expensetotal").style.border="thin solid red";
		document.getElementById("incometotal").style.border="thin solid red";
		alert("Income Problem" + difference);
		return false;
	}
	else
	return true;
	}