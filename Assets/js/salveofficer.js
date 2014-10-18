household=0;
org=0;

	function addHousehold(){
		if(household==household){
			document.getElementById('household').innerHTML +="<label> <span>Name :</span></label><input id='hhname' type='text' name='hfname_1[]' placeholder='First Name' style='width: 207px;'/> <input id='hhname' type='text' name='hmname_1[]' placeholder='Middle Name' style='width: 150px;'/> <input id='hhname' type='text' name='hlname_1[]' placeholder='Last Name' style='width: 176px;'/> <label><span>Relationship :</span> <select name='relation[]' style='width: 550px; height: 35px;' required> <option> </option> <option>Grandparent</option><option>Father</option><option>Mother</option><option>Child</option><option>In-Law</option></select> </label><label><span>Occupation :</span>  <input id='occupation' type='text' name='occupy[]'  style='width: 550px;'/>    </label><label><span>Civil Status :</span> </label>  <select id='civilstat'  name='c_stat[]'  style='width: 145px;'><option value=''></option><option value='Single'>Single</option><option value='Married'>Married</option> </select> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Age :  <input id='age' type='text' name='age_1[]'  style='width: 150px;'/> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Gender : <select name='genders[]' style='width:80px'><option value=''></option><option value='Male'>Male</option><option value='Female'>Female</option></select>   <label><span></span>------------------------------------------------------------------------------------------------------------------------------  </label>"; 
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
			document.getElementById('material').innerHTML +="<label><span></span></label><input type='text' name='' id='' style='width: 250px;'/> &nbsp&nbsp&nbsp      Qty :      <input type='text' name='' id='' style='width: 26px;'/>        &nbsp&nbsp&nbsp      Unit Price :        <input type='text' name='' id='' style='width: 80px;' placeholder='Peso'/>"; 
			material+=1;
		}
				
	}

