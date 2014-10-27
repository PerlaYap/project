
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>

<script type="text/javascript"> function send(control_no){ window.location.href= "updateuser?name="+ control_no; } </script>




<body>
	<div class="content2">  

		<?php	

		

		$user = $this->db->query("SELECT CONCAT(LastName,', ', FirstName, ' ', MiddleName) AS Name, Rank, BranchName, ControlNo 
			FROM CaritasPersonnel cp
			LEFT JOIN 
			(SELECT CaritasPersonnel_ControlNo AS PersonnelControl, BranchName 
				FROM CaritasBranch_has_Caritaspersonnel cbhcp LEFT JOIN CaritasBranch cb ON cb.ControlNo=cbhcp.CaritasBranch_ControlNo)A
		ON cp.ControlNo=A.PersonnelControl ORDER BY Name");
		

		?> 

		<div class = "mainincome">
			<form action="updateuser" method="post">
				
				<?php	foreach ($user->result() as $row){ ?> 
				<div class="subheadername"><b><?php echo strtoupper($row->Name); ?></b></div>
				<div class="subskew"></div>
				<br><br>
				<p class="info"><b>Rank: </b>  <?php echo strtoupper($row->Rank); ?>  </p>
				<p class="info"><b>Branch: </b>  
					<?php 
					if($row->BranchName!=null){
						echo strtoupper($row->BranchName);
					}
					else{
						echo "UNASSIGNED";
					}
					?>
				</p>
				
				<input type="button" class="editbtn" value="Edit User" onclick="send('<?php echo $row->ControlNo ?>')" style="width: 140px;"/>
				<?php  }?>
				
			</div>

			<br><br><br>
		</div>

	</body>
