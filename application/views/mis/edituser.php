<?php 
$control_no = $_GET['name'];

$getOfficer = $this->db->query("SELECT FirstName, MiddleName,  LastName, PersonnelID, Rank,  BranchName, Password, IsActive  
	FROM caritaspersonnel p, caritasbranch_has_caritaspersonnel bp,caritasbranch cb , users u
 where p.ControlNo = '$control_no' AND p.ControlNo = bp.CaritasPersonnel_ControlNo and bp.CaritasBranch_ControlNo = cb.ControlNo AND p.PersonnelID = u.username");
		

	
	foreach ($getOfficer->result() as $off) {

?>

<div class="content">
				<br>
				<form action="edituser" method="post" name="edituser" class="basic-grey">
					<h1>Edit User
				      
				    </h1>
	
					 <label>
				        <span>Control Number:</span></label>
						 <input type='text' name='controlno' readonly value="<?php echo $control_no; ?>">

				    <label>
				        <span>Name :</span></label>
				        
				        <input id="name" readonly type="text" name="fname" value="<?php echo $off->FirstName; ?>" style="width: 170px;"  />
				        <input id="name" readonly type="text" name="mname" value="<?php echo $off->MiddleName; ?>" style="width: 175px;" />
				    	<input id="name" readonly type="text" name="lname" value="<?php echo $off->LastName; ?>" style="width: 180px;" />
				   

				    <label>
				        <span>Personnel ID :</span> </label>
				        <input id="personnelid" type="text" name="username"  value="<?php echo $off->PersonnelID; ?>" />
				        	
				       <!-- <label>
				        <span>Password :</span> </label>
				        <input id="password" type="password" name="password"  value="<?php echo $off->Password; ?>" /> -->		    

				    <label>
				        <span>Position :</span> </label>
					     <select name="position" id="position" style="width:350px;">
						     <?php if ($off->Rank =='salveofficer'){ ?>

										<option value="salveofficer" selected="selected"> Salve Officer </option>
										<option value="branchmanager"> Branch Manager </option>
										<option value="mispersonnel"> MIS Personnel </option>
										<?php } else if($off->Rank =='branchmanager'){?>
										<option value="salveofficer"> Salve Officer </option>
										<option value="branchmanager" selected='selected'> Branch Manager </option>
										<option value="mispersonnel"> MIS Personnel </option>
										<?php } else{?>
										<option value="salveofficer"> Salve Officer </option>
										<option value="branchmanager" > Branch Manager </option>
										<option value="mispersonnel" selected='selected'> MIS Personnel </option>
										<?php } ?>
					
								</select>

				    <br><br>
				     <label>
				        <span></span>
				    <?php    if ($off->IsActive==1) { ?>
	
											<input type='hidden' name='active' value='0'>

										<input type='submit' value='Disable' class='button'/>
										
							<?php			}else{ ?> 
											
											<input type='hidden' name='active' value='1'>
										<input type='submit' value='Enable' class='button'/>
									
								<?php		}
								 } ?>

&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

				        <input type="submit" class="button" value="Save" />
				    </label>  
				</form>
			<br><br>
		</div>
	</body>
</html>