<?php 
//$control_no =  $number;
/*nagset muna ako ng number dito kasi walang control number na nageget sya..
	Mas maganda kung may list ka muna ng lahat ng pangalan ng user, tapos pagnaclick yung name ng user, isesend yung controlno ng user and pupunta sa page na ito*/ 

$control_no = $_GET['name'];
$branch = $this->session->userdata('branchno');

$coordinator = $this->db->query("SELECT CONCAT(m.FirstName,' ', m.MiddleName, ' ', m.LastName) AS Name, m.ControlNo AS Control
				 FROM membersname m, CaritasCenters_has_Coordinator cc, CaritasBranch_has_CaritasCenters bc
				WHERE m.ControlNo = cc.Members_ControlNo AND cc.CaritasCenters_ControlNo = '$control_no' AND 
				cc.CaritasCenters_ControlNo = bc.CaritasCenters_ControlNo AND bc.CaritasBranch_ControlNo  = '$branch'");

foreach ($coordinator->result() as $coo) {
	$preselected = $coo->Name;
	$control = $coo->Control;
}

$getCenter = $this->db->query("SELECT * FROM caritascenters cc, centeraddress ca, centercontact ct
		WHERE  cc.ControlNo='$control_no' AND cc.ControlNo = ca. ControlNo AND ca.ControlNo = ct.ControlNo");
		
$getCoordinator = $this->db->query("SELECT CONCAT(FirstName,' ', MiddleName, ' ', LastName) AS Name, m.ControlNo AS Control, cm.CaritasCenters_ControlNo, bm.CaritasBranch_ControlNo 
	FROM membersname m, CaritasCenters_has_Members cm, CaritasBranch_has_CaritasCenters bm
	WHERE m.ControlNo = cm.Members_ControlNo AND cm.CaritasCenters_ControlNo = bm.CaritasCenters_ControlNo AND
	bm.CaritasBranch_ControlNo = '$branch' AND bm.CaritasCenters_ControlNo = '$control_no' AND
	 m.ControlNo NOT IN (SELECT Members_ControlNo FROM CaritasCenters_has_Coordinator)");

?>

<div class="content">
				<br>
				<form action="editcenter" method="post" name="editcenter" class="basic-grey">
					<h1>Edit Center </h1>

 					<label> 
 					<span>Control Number :</span></label>
 					<input  type="text" name="control" value="<?php echo $control_no; ?>"/>

	  				 <label>
				        <span>Center No :</span></label>
				       
				          <?php	foreach ($getCenter->result() as $ctr) { 

				          	?>
	
				        <input id="name" type="text" name="number" value="<?php echo $ctr->CenterNo; ?>" style="width: 180px;" />

				    
 					 <label>
				        <span>Contact Number :</span> </label>
				        <input id="contact" type="text" name="contact"  value="<?php echo $ctr->ContactNo; ?>" />
				    
	  
	   				 <label>
	    			 <span>Address :</span> </label>
				        <input id="address" type="text" name="address"  value="<?php echo $ctr->CenterAddress; ?>" />


				        <label>
						<span>Payment Day: </span></label>

						<select name="day" style="width:197px;">
							<?php if ($ctr->DayoftheWeek =='Monday'){ ?>
							<option value="Monday" selected="selected"> Monday </option>
										<option value="Tuesday">Tuesday</option>	
						       			 <option value="Wednesday">Wednesday</option>
						        		<option value="Thursday">Thursday</option>
						        		<option value="Friday">Friday</option>
										<?php } else if ($ctr->DayoftheWeek =='Tuesday'){?>
										<option value="Monday">Monday</option>
										<option value="Tuesday" selected='selected'> Tuesday </option>
										<option value="Wednesday">Wednesday</option>
						        		<option value="Thursday">Thursday</option>
						        		<option value="Friday">Friday</option>
										<?php } else if ($ctr->DayoftheWeek =='Wednesday') { ?>
										<option value="Monday">Monday</option>
										<option value="Tuesday">Tuesday</option>
										<option value="Wednesday" selected='selected'> Wednesday </option>
										<option value="Thursday">Thursday</option>
						        		<option value="Friday">Friday</option>
										<?php } else if ($ctr->DayoftheWeek =='Thursday'){ ?>
										<option value="Monday">Monday</option>
										<option value="Tuesday">Tuesday</option>
										<option value="Wednesday">Wednesday</option>
										<option value="Thursday" selected='selected'> Thursday </option>
										<option value="Friday">Friday</option>
										<?php } else if ($ctr->DayoftheWeek =='Friday') {  ?>
										<option value="Monday">Monday</option>
										<option value="Tuesday">Tuesday</option>
										<option value="Wednesday">Wednesday</option>
										<option value="Thursday">Thursday</option>
										<option value="Friday" selected='selected'> Friday </option>
										<?php } else {  ?>
										<option value="" selected="selected"></option>
						        		<option value="Monday">Monday</option>
						        		<option value="Tuesday">Tuesday</option>	
						        		<option value="Wednesday">Wednesday</option>
						        		<option value="Thursday">Thursday</option>
						        		<option value="Friday">Friday</option>

										<?php } ?>
										</select>
					<?php } ?>

						<label>
						<span>Coordinator: </span></label>

						<select name="coordinator" style="width:197px;">
							
			<?php if (!empty($preselected)){  ?>

					<option value= '<?php echo $control; ?>' selected="selected"> <?php echo $preselected; ?> </option>
					 
				<?php foreach ($getCoordinator->result() as $doo) {	?>  

				<option value='<?php echo $doo->Control; ?>'> <?php echo $doo->Name; ?> </option>

				<?php } } else  { ?>

					<option value="">-Select-</option>

					<?php foreach ($getCoordinator->result() as $doo) {	?>  

				<option value='<?php echo $doo->Control; ?>'> <?php echo $doo->Name; ?> </option>

				<?php } 

				 } ?>	
					</select>
			
	    <br><br>
				     <label>
				        <span></span>
				        <input type="submit" class="button" value="Save" />
				    </label>  
				</form>
			<br><br>
		</div>
