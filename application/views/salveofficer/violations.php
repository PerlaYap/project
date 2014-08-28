
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<script src="<?php echo base_url('Assets/js/branchmanager.js'); ?>"></script>

<!--<link rel="stylesheet" type="text/css" href="../../../Assets/css/salveofficer.css">
<script src="../../../Assets/js/branchmanager.js"></script>-->

<?php $violationList=$this->db->query("SELECT ViolationID, concat(Degree,'	|',Violation) AS Violation, Description FROM Violations ORDER BY Degree ASC, Violation ASC"); ?>

<?php $memberList=$this->db->query("SELECT mn.ControlNo AS MemberControl, concat(MemberID,'| ', LastName,', ',FirstName,' ',MiddleName) AS Name FROM Members mem LEFT JOIN membersname mn ON mem.ControlNo=mn.ControlNo"); ?>

<?php 
$PersonnelControl=$this->session->userdata('personnelno');
$personnelID=$this->db->query("SELECT PersonnelID FROM caritaspersonnel WHERE ControlNo=$PersonnelControl"); 

foreach ($personnelID->result() as $row) {
	$personnelId=$row->PersonnelID;
}?>

			<div class="content">
				<br>
				<form action="addviolation" method="post" name="addviolation" class="basic-grey">
				
					<h1><br>
						Violation
				        <span> <br></span>
				    </h1>

				    <label>
				        <span>Member ID: </span>
				        <select name="memberid" style="width: 562px;">
				   			<option value=" " selected></option>
				   			<?php
				    		foreach ($memberList->result() as $row) { 
				    			echo "<option value='".$row->MemberControl."'>".$row->Name."</option>" ;
				    		 } ?>			   			
				   		</select>
				    </label>

				    <label>
				        <span>Personnel Name :</span></label>
				       <input id="name" type="text" name="personnel" value="<?php echo $personnelId.' |'.$this->session->userdata('firstname'); ?>" style="width: 562px;" readOnly="true"/>
				
				   <label>
				   		<span>Violation :</span></label>
				   		<select id="violations" name="violations" style="width: 281px;">
				   			<?php
				    		foreach ($violationList->result() as $row) { 
				    			echo "<option value='".$row->ViolationID."'>".$row->Violation."</option>" ;
				    		 } ?>		   			
				   		</select>

				   		<span>Date :</span></label>
				        <select name="month" style="width:80px;">
						        <option value="" selected="selected"></option>
						        <option value="01">January</option>
						        <option value="02">February</option>
						        <option value="03">March</option>
						        <option value="04">April</option>
						        <option value="05">May</option>
						        <option value="06">June</option>
						        <option value="07">July</option>
						        <option value="08">August</option>
						        <option value="09">September</option>
						        <option value="10">October</option>
						        <option value="11">November</option>
						        <option value="12">December</option>
					        </select>

					        <select name="day" style="width:50px;">
						        <option value="" selected="selected"></option>
						        <?php  for ($i=1; $i < 32 ; $i++) { ?>
							        <?php if ($i<10) { ?>
							        <option value="<?php echo '0'.$i ?>"><?php echo '0'.$i ?></option>		
							       	<?php } else{ ?>
							       	<option value="<?php echo $i ?>"><?php echo $i ?></option>
							      	<?php } ?>
						      <?php  } ?>
					        </select>

					        <select name="year" style="width:65px;">
						        <option value="" selected="selected"></option>
						        <?php  for ($y=1980; $y < 2015 ; $y++) { ?>
							       <option value="<?php echo $y ?>"><?php echo $y ?></option>
						        <?php  } ?>
					        </select>
				   </label>

				   <label>
				   		<span>Comment: </span>
				   		<textarea name="comment" style="resize:none;"></textarea>
				   </label>

				    <br><br>
				    <label>
				        <span></span>
								<input type="submit" class="button" value="Submit" />
					       
				    </label>
				</form>
		<br><br><br>
		</div>
