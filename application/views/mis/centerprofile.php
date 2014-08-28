
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>




<?php

$control_no = $_GET['name'];
/*SQL QUERIES*/


$getCenter = $this->db->query("SELECT CenterNo, ContactNo, CenterAddress FROM caritascenters cc, centeraddress ca,
centercontact ct WHERE cc.ControlNo = ca.ControlNo AND ca.ControlNo = ct.ControlNo");
		

	foreach ($getCenter->result() as $cen) {

			$number = $cen->CenterNo;
			$contact = $cen->ContactNo;
			$address = $cen->CenterAddress;
		
			}


 ?>


<body onload="TabInfo();">


		<div class="content">

			<div class="tabs">
				<input type="button" value="Information" class="profile" onclick="TabInfo()" id="info"/>
				<input type="button" value="Loan" class="loan" onclick="TabLoan()" id="loan"/>
				<input type="button" value="Savings" class="savings" onclick="TabSavings()" id="savings"/>
				<input type="button" value="Performance" class="performance" onclick="TabPerf()" id="performance"/>	
			</div>
			<div class="line"></div>
 			


			<!-------------------->
			<!-------------------->
			<!-------------------->

			<div id="divprofile" style="display: none;">

				<!--------------------------------------------------------------------> 
		
				<div class = "personalinfo">

					<div class="headername"><b>Center Number: </b><?php echo $number; ?></div>
						<div class="skew"></div>
					<br>
					
	
					<p class="info"><b>Contact Number: </b> <?php echo $contact; ?></p>
					<p class="info"><b>Address: </b> <?php echo $address; ?></p>
					
					<form action='editprofile' method='post'>
						<input type='hidden'  name='number' value='<?php echo $control_no ?>' >
						<input type="submit" class="editbtn" value="Edit Account" />
					</form>
				    

				    <br>
				</div>
		

				