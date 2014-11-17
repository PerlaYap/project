
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>

<!--<script type="text/javascript"> function send(control_no){ window.location.href= "updateuser?name="+ control_no; } </script>

-->

<?php


$control_no = $_GET['name'];
/*SQL QUERIES*/


$getOfficer = $this->db->query("SELECT * FROM caritaspersonnel p, caritasbranch_has_caritaspersonnel bp,caritasbranch cb 
 where '$control_no' = p.ControlNo AND p.ControlNo = bp.CaritasPersonnel_ControlNo AND bp.CaritasBranch_ControlNo = cb.ControlNo");
		

	foreach ($getOfficer->result() as $off) {

			$lastname = $off->LastName;
			$middlename = $off->MiddleName;
			$firstname = $off->FirstName;
			$offid = $off->PersonnelID;
			$rank = $off->Rank;
			$branch = $off->BranchName
			
			}


 ?>


<body onload="TabInfo();">


		<div class="content">

	
	
				<form action='userprofile' method='post'>

					<div class="headername"><b><?php echo $lastname  ?></b>, <?php echo $firstname." ".$middlename ; ?></div>
						<div class="skew"></div>
					<br>

					<p class="info"><b>User's ID: </b><?php echo $offid; ?></p>
					<p class="info"><b>Branch: </b> <?php echo $branch; ?></p>
					<p class="info"><b>Rank: </b><?php echo $rank; ?></p>
					
				
		
				<input type="text" class="editbtn" value="Edit Profile" onclick="send('<?php echo $row->ControlNo ?>')" style="margin-left: 720px;"/>
						
					</form>
				    

				    <br>
				</div>
		

				