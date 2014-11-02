<?php 

$branch = $this->session->userdata('branchno');
$branchname = $this->session->userdata('branch');

$coordinator = $this->db->query("SELECT CONCAT(FirstName,' ', MiddleName, ' ', LastName) AS Name, cm.CaritasCenters_ControlNo, bm.CaritasBranch_ControlNo 
	FROM membersname m, CaritasCenters_has_Members cm, CaritasBranch_has_CaritasCenters bm
	WHERE m.ControlNo = cm.Members_ControlNo AND cm.CaritasCenters_ControlNo = bm.CaritasCenters_ControlNo AND
	bm.CaritasBranch_ControlNo = '$branch' AND m.ControlNo NOT IN (SELECT Members_ControlNo FROM CaritasCenters_has_Coordinator)");

?>
		<div class="content">
			<br>
						<form action="addcenter" method="post" name="addcenterprocess" enctype="multipart/form-data" class="basic-grey">
					<h1>New Center
				        <span>Fill in all the necessary information</span>
				         <input id="name" hidden type="text" name="branch" value="<?php echo $branch; ?>"/>
				         <input id="name" hidden type="text" name="branchname" value="<?php echo $branchname; ?>"/>
				    </h1>

 
				    <label>
				        <span>Center Number: </span> </label>

				        <input type="text" name="centerno" style="width:562px;" readonly value='<?php echo rand(1,100) ?>' >

				  
				    
				    <label>
				        <span>Contact Number: </span> </label>

				        <input type="text" name="contactno" style="width:562px;" >

					<label>
				        <span>Address: </span> </label>

				        <input type="text" name="address" style="width:562px;" >	

				    <label>
				        <span>Payment Day: </span> </label>

				        	<select name="day" style="width:150px;">
				    			<option value="" selected="selected"></option>
						        <option value="Monday">Monday</option>
						        <option value="Tuesday">Tuesday</option>	
						        <option value="Wednesday">Wednesday</option>
						        <option value="Thursday">Thursday</option>
						        <option value="Friday">Friday</option>
						      </select>
						    <br>
				     

				     <label> 
				     
				        <span></span></label>  
				        <input type="submit" class="button" value="Submit" />
				   
				</form>
			<br><br>
		</div>

