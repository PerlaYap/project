
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>

<script type="text/javascript"> function send(control_no){ window.location.href= "updatebranch?name="+ control_no; } </script>




<body>
	<div class="content2">  

	<?php	
	//	$branch = $this->db->query("select b.ControlNo, BranchID, BranchName, BranchAddress, ContactNo
	//	from caritasbranch b, branchaddress a, branchcontact c
	//	where b.ControlNo = a.ControlNo and a.ControlNo = c.ControlNo  Order by BranchName");

	

		$branch = $this->db->query("SELECT * from (select b.ControlNo, BranchID, BranchName, BranchAddress, ContactNo
		from caritasbranch b, branchaddress a, branchcontact c
		where b.ControlNo = a.ControlNo and a.ControlNo = c.ControlNo 
		Order by BranchName)x 
		join (SELECT cb.ControlNo,CONCAT(FirstName, ' ', MiddleName, ' ', LastName) AS Manager 
		FROM CaritasBranch cb, CaritasBranch_has_CaritasPersonnel cp, CaritasPersonnel cl
		WHERE cb.ControlNo = cp.CaritasBranch_ControlNo AND cp.CaritasPersonnel_ControlNo = cl.ControlNo
		AND cl.Rank = 'branchmanager')y on x.ControlNo = y.ControlNo");
         
		
       /* join
        (SELECT ch.ControlNo, COUNT(bc.CaritasCenters_ControlNo) AS Center 
		FROM  CaritasBranch ch, CaritasBranch_has_CaritasCenters bc, CaritasCenters_has_Members cc
		WHERE  bc.CaritasBranch_ControlNo = ch.ControlNo AND bc.CaritasCenters_ControlNo = cc.CaritasCenters_ControlNo)z on x.ControlNo = z.ControlNo
		 join
		(SELECT rh.ControlNo,COUNT(Members_ControlNo) AS Member
		FROM  CaritasBranch rh, CaritasBranch_has_CaritasCenters bc, CaritasCenters_has_Members cc
		WHERE bc.CaritasBranch_ControlNo = rh.ControlNo AND bc.CaritasCenters_ControlNo = cc.CaritasCenters_ControlNo)a on x.ControlNo = a.ControlNo"); 

		*/

	?> 

		<div class = "mainincome">
			<form action="updatebranch" method="post">
				
				<?php	foreach ($branch->result() as $row){ ?> 
				<div class="subheadername"><b><?php echo $row->BranchName; ?></b></div>
					<div class="subskew"></div>
				<br><br>
				<p class="info"><b>Branch control no: </b>  <?php echo $row->ControlNo; ?>  </p>
				<p class="info"><b>Branch ID: </b>  <?php echo $row->BranchID; ?>  </p>
				<p class="info"><b>Address: </b><?php echo $row->BranchAddress; ?>  </p>
				<p class="info"><b>Contact No.: </b><?php echo $row->ContactNo; ?>  </p>
				<p class="info"><b>Branch Manager: </b> <?php echo  $row->Manager; ?></p> 
<?php

$control = $row->ControlNo;

$count1 = $this->db->query("SELECT COUNT(bc.CaritasCenters_ControlNo) AS Center 
		FROM   CaritasBranch_has_CaritasCenters bc, CaritasCenters_has_Members cc
		WHERE  bc.CaritasBranch_ControlNo = '$control' AND bc.CaritasCenters_ControlNo = cc.CaritasCenters_ControlNo");

foreach ($count1->result() as $ct){ 


?>
				
				<p class="info"><b>Total Number of Centers: </b> <?php echo $ct->Center; ?></p>
<?php  }

$count2 = $this->db->query("SELECT COUNT(Members_ControlNo) AS Member
		FROM CaritasBranch_has_CaritasCenters bc, CaritasCenters_has_Members cc
		WHERE bc.CaritasBranch_ControlNo = '$control' AND bc.CaritasCenters_ControlNo = cc.CaritasCenters_ControlNo");

foreach ($count2->result() as $ctt){ 


?>

				<p class="info"><b>Total Number of Members: </b> <?php echo $ctt->Member; ?></p> 
	<?php  } ?>			

		

			</form>

			
				
			<input type="text" class="editbtn" value="Edit Branch" onclick="send('<?php echo $row->ControlNo ?>')" style="margin-left: 720px;"/>
	<?php  }?>
	
		</div>

	<br><br><br>
	</div>

</body>
