

<?php $branch = $this->session->userdata('branchno'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>

<script type="text/javascript"> function send(control_no){ window.location.href= "updatecenter?name="+ control_no; } </script>


		<div class="content2">
		

		<?php	
			$center = $this->db->query("SELECT cc.ControlNo, CenterNo, ContactNo, CenterAddress 
				FROM CaritasCenters cc, CenterContact ct, CenterAddress ca, CaritasBranch_has_CaritasCenters cb
			WHERE  cc.ControlNo = ct.ControlNo  AND ct.ControlNo = ca.ControlNo  AND cc.ControlNo = cb.CaritasCenters_ControlNo
			AND cb.CaritasBranch_ControlNo = '$branch' Order by CenterNo");

		?>
		
		<div class = "mainincome">
		<form action="updatecenter" method="post">
			
			<?php	foreach ($center->result() as $row){ ?> 
			<div class="subheadername"><b>Center Number: </b> <?php echo $row->CenterNo; ?></div>
				<div class="subskew"></div>
				<br><br>

				<p class="info"><b>Address: </b> <?php echo $row->CenterAddress; ?>  </p>
				<p class="info"><b>Contact No.: </b> <?php echo $row->ContactNo; ?>  </p>

<?php 
$control = $row->ControlNo;

$count = $this->db->query("SELECT COUNT(*) as Member
		FROM CaritasCenters_has_Members CM 
		JOIN CaritasBranch_has_CaritasCenters BC ON CM.CARITASCENTERS_CONTROLNO = BC.CARITASCENTERS_CONTROLNO

		  WHERE CM.MEMBERS_CONTROLNO IN (SELECT MM.CONTROLNO FROM members_has_membersmembershipstatus MM
										WHERE  MM.CONTROLNO IN (SELECT M.CONTROLNO FROM MEMBERS M
																WHERE M.APPROVED = 'YES'
															
																)
										AND MM.STATUS !='Terminated' OR MM.Status!='Terminated Voluntarily' 
										
										) 
								AND CM.CARITASCENTERS_CONTROLNO = '$control' AND BC.CARITASBRANCH_CONTROLNO = '$branch' 
								
								"); 
			
foreach ($count->result() as $ctt){ 
?>
			<p class="info"><b>Total # of Members: </b>  <?php echo $ctt->Member; ?>  </p>
   					
   			<?php } ?>	

<?php

$coordinator = $this->db->query("SELECT CONCAT(FirstName,' ', MiddleName, ' ', LastName) AS Name, Members_ControlNo FROM membersname m, CaritasCenters_has_Coordinator cc
	WHERE cc.CaritasCenters_ControlNo = '$control' AND cc.Members_ControlNO = m.ControlNo");

foreach ($coordinator->result() as $cr){ 
?>

   			<p class="info"><b>Coordinator </b>  <?php echo $cr->Name; ?>  </p>

<?php } ?>	
				<input type="text" class="editbtn" value="Edit Center" 
				onclick="send('<?php echo $row->ControlNo ?>')" style="margin-left: 720px;"/>
		<?php } ?>
   		</form>
 	</div>
 	<br><br>
	</div>