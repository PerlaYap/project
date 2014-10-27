<?php 

$control_no = $_GET['name']; 


$getBranch = $this->db->query("SELECT BranchName, BranchID, BranchAddress, ContactNo, cb.ControlNo, CONCAT(LastName, ', ', FirstName, ' ', MiddleName) AS Manager  FROM caritasbranch cb, branchaddress ba, branchcontact bc, CaritasBranch_has_CaritasPersonnel cp, CaritasPersonnel cl
	where cb.ControlNo='$control_no' and cb.ControlNo = ba.ControlNo and ba.ControlNo = bc.ControlNo AND 
	cb.ControlNo = cp.CaritasBranch_ControlNo AND cp.CaritasPersonnel_ControlNo = cl.ControlNo
	AND cl.Rank = 'branchmanager' "); 




	?>

	<div class="content">
		<br>
		<form action="editbranch" method="post" name="editbranch" class="basic-grey">
			<h1>Edit Branch


			</h1>

			<label><span>Name :</span></label>
			<?php	foreach ($getBranch->result() as $bra) { ?>
			<input id="name"  type="text" name="branchcontrol" value="<?php echo $bra->ControlNo; ?>" style="width: 180px;" />   
			<input id="name"  type="text" name="branch" value="<?php echo $bra->BranchName; ?>" style="width: 180px;" />   

			<br>
			<label><span>Branch ID :</span></label>

			<input id="personnelid"  type="text" name="id"  value="<?php echo $bra->BranchID; ?>" />

			<br>
			<label><span>Contact Number :</span></label>

			<input id="contact" type="text" name="contact"  value="<?php echo $bra->ContactNo; ?>" />

			<br>  
			<label><span>Address :</span> </label>

			<input id="address" type="text" name="address"  value="<?php echo $bra->BranchAddress; ?>" />


			<br>
			<label><span>Branch Manager: </span></label>

			<select name="manager" style="width:197px;">

				<option value= "<?php echo $bra->ControlNo;?>" selected="selected"><?php echo $bra->Manager; ?></option>
				<?php } 

				$control = $bra->ControlNo;

				$getManager = $this->db->query("SELECT CONCAT(LastName, ', ', FirstName, ' ', MiddleName) AS Name, ControlNo FROM CaritasPersonnel p,
					CaritasBranch_has_CaritasPersonnel cp 
					WHERE cp.CaritasBranch_ControlNo = '$control' AND p.ControlNo  NOT IN (SELECT CaritasPersonnel_ControlNo FROM CaritasBranch_has_CaritasPersonnel) AND Rank = 'branchmanager' ");

				foreach ($getManager->result() as $mng) { ?>			    

					<option value="<?php echo $mng->ControlNo; ?>"><?php echo $mng->Name; ?></option>

					<?php } ?>		    		
				</select>

				<br>

				<?php

				$getBranch2 = $this->db->query("SELECT  cb.ControlNo, CONCAT(LastName, ', ', FirstName, ' ', MiddleName) AS Officer FROM caritasbranch cb, CaritasBranch_has_CaritasPersonnel cp, CaritasPersonnel cl
					where cb.ControlNo='$control_no' AND cb.ControlNo = cp.CaritasBranch_ControlNo AND cp.CaritasPersonnel_ControlNo = cl.ControlNo
					AND cl.Rank = 'salveofficer' "); 

					?>


					<label>
						<span>Salve Officer: </span></label><br><br>
						<?php
						foreach ($getBranch2->result() as $bra2) {
							?>

							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp				

							<input type='checkbox' name='officer[]' value="<?php echo $bra2->ControlNo;?>" checked="checked"?><?php echo $bra2->Officer;
							?>
							<br>
							<?php
						}


						$getOfficer = $this->db->query("SELECT CONCAT(LastName, ', ', FirstName, ' ', MiddleName) AS Name, ControlNo FROM CaritasPersonnel p
							WHERE  p.ControlNo  NOT IN (SELECT CaritasPersonnel_ControlNo FROM CaritasBranch_has_CaritasPersonnel) AND Rank = 'salveofficer'");

						foreach($getOfficer->result() as $off){

							?>

							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							<input type='checkbox' name='officer[]' value="<?php echo $off->ControlNo;?>"?><?php echo $off->Name;?>
							<br>
							<?php } ?>			    	


							<br><br>
							<label>
								<span></span>
								<input type="submit" class="button" value="Save" />
							</label>  
						</form>	

					</div>	
