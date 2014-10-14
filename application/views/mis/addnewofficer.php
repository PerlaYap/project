<?php 

$branch = $this->session->userdata('branch');
$centers = $this->db->query("SELECT caritasbranch.ControlNo as branchCNo, BranchName, caritascenters.ControlNo as CenterCNo, CenterNo, Members_ControlNo

FROM caritasbranch, caritasbranch_has_caritascenters cc, caritascenters, caritascenters_has_members cm

WHERE caritasbranch.ControlNo = cc.CaritasBranch_ControlNo AND caritascenters.ControlNo = cc.CaritasCenters_ControlNo AND caritascenters.ControlNo = cm.CaritasCenters_ControlNo AND
BranchName='$branch'
group by CenterNo");

$branches = $this->db->query("SELECT * FROM `caritasbranch` WHERE 1 ORDER BY `caritasbranch`.`BranchName` ASC");

?>
	
			<div class="content">
				<br>
				<form action="addnewofficerprocess" method="post" name="addnewofficerprocess" enctype="multipart/form-data" class="basic-grey">
					<h1>New User
				        <span>Fill in all the necessary information.</span>
				    </h1>
	
				    <label>
				        <span>Name :</span></label>
				        <input id="name" type="text" required name="fname" placeholder="First Name" style="width: 180px;"/>
				        <input id="name" type="text" required name="mname" placeholder="Middle Name" style="width: 170px;"/>
				        <input id="name" type="text" required name="lname" placeholder="Last Name" style="width: 175px;"/>
				   

				    <label>
				        <span>Personnel ID :</span> </label>
				        <input id="personnelid" required type="text" name="username"/>
				        			    

				    <label>
				        <span>Password :</span> </label>
				        <input id="password" type="password" required name="password" style="width: 208px;" />
				        &nbsp&nbsp&nbsp&nbsp&nbsp
				        <label>
				        <span>Confirm Password :</span> </label>
				        <input id="password" type="password" name="password" style="width: 208px;" required />
				        &nbsp&nbsp&nbsp&nbsp&nbsp
				      

				    <label>
				        <span>Position :</span> </label>
					        <select name="position" required style="width:300px;">
						        <option value="" selected="selected"></option>
						        <option value="salveofficer">Salve Officer</option>
						        <option value="branchmanager">Branch Manager</option>
						        <option value="mis">MIS Personnel</option>
					        </select>

				 <input id="active" hidden type="text" name="active" value="1"/>
				
				    <br><br>
				     <label>
				        <span></span>
				        <input type="submit" class="button" value="Submit" />
				    </label>  
				</form>
			<br><br>
		</div>
	</body>
</html>