household=0;
org=0;

	function addHousehold(){
		if(household==household){

			document.getElementById('household').innerHTML +="<label>   <span>Name :</span></label>   <input id='hhname' type='text' name='hfname' placeholder='First Name' style='width: 207px;' required/>  <input id='hhname' type='text' name='hmname' placeholder='Middle Name' style='width: 150px;' required/>      <input id='hhname' type='text' name='hlname' placeholder='Last Name' style='width: 176px;' required/>  <label> <span>Relationship :</span> <select name='relationship' style='width: 550px; height: 35px;' required>	<option> </option>	<option>Spouse</option><option>Child</option><option>Grandparent</option><option>Parent</option><option>Sibling</option><option>Uncle</option><option>Aunt</option><option>In-Law</option></select>   <!--<input id='relationship' type='text' name='relationship'  style='width: 560px;'/>--> </label><label><span>Occupation :</span>    <input id='occupation' type='text' name='occupation'  style='width: 550px;' required/>    </label>  <label> <span>Civil Status :</span> </label><select name='c_status' id='selectMenu' onchange='toggle(this.options[this.options.selectedIndex].value)' style='width:145px;' required><option value='' selected='selected'></option><option value='Single'>Single</option><option value='Married'>Married</option></select>       <!-- <input id='civilstat' type='text' name='c_status'  style='width: 140px;'/> -->   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Gender :  <select name='pine' style='width:150px;' required> <option value='' selected='selected'></option>  <option value='male'>Male</option>    <option value='female'>Female</option> </select> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Age : <input id='age' type='text' name='age'  style='width: 50px;' required/><label><span></span>------------------------------------------------------------------------------------------------------------------------------</label>"; 
			household+=1;
		}
				
	}

	function addOrganization(){
		if(org==org){
			document.getElementById('organizations').innerHTML +="<label><span></span></label> <input id='affiliations' type='text' name='organization[]' style='width: 260px;' /> Position : <input id='affiliations' type='text' name='position[]' style='width: 188px;'/>"; 
			org+=1;
		}
				
	}

	function addMaterial(){
		if(material==material){
			document.getElementById('material').innerHTML +="Material Type:<p class='reqd'>*</p><select required='true' name='materials' class='material_1' style='width:220px;'> <option value=' '></option> <option value='Advertising'>Advertising</option> <option value='Business Goods'>Business Goods</option> <option value='Business Supplies'>Business Supplies</option> <option value='Construction Materials'>Construction Materials</option><option value='Employee Salary'>Employee Salary</option> <option value='Labor Cost'>Labor Cost</option> <option value='Office Supplies'>Office Supplies</option> <option value='Others'>Others</option> <option value='Monthly Rent'>Monthly Rent</option> <option value='Taxes'>Taxes</option><option value='Transportation Service'>Transportation Service</option><option value='Utilities'>Utilities</option></select>&nbsp&nbsp&nbspUnit Price:<p class='reqd'>*</p><input required='true'  type='text' name='unitprice' class='unitprice_1' style='width: 80px;' placeholder='Peso'/> &nbsp&nbsp "; 
			material+=1;
		}
				
	}

