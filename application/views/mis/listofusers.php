
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>

<script type="text/javascript"> function send(control_no){ window.location.href= "updateuser?name="+ control_no; } </script>




<body>
	<div class="content2">  

	<?php	

	

		$user = $this->db->query("SELECT CONCAT(FirstName,' ', MiddleName, ' ', LastName) AS Name, Rank, BranchName, p.ControlNo FROM caritaspersonnel p, caritasbranch_has_caritaspersonnel bp,caritasbranch cb 
 where p.ControlNo = bp.CaritasPersonnel_ControlNo AND bp.CaritasBranch_ControlNo = cb.ControlNo");
		

	?> 

		<div class = "mainincome">
			<form action="updateuser" method="post">
				
				<?php	foreach ($user->result() as $row){ ?> 
				<div class="subheadername"><b><?php echo $row->Name; ?></b></div>
					<div class="subskew"></div>
				<br><br>
				<p class="info"><b>Rank: </b>  <?php echo $row->Rank; ?>  </p>
				<p class="info"><b>Branch: </b>  <?php echo $row->BranchName; ?>  </p>
				
			<input type="text" class="editbtn" value="Edit User" onclick="send('<?php echo $row->ControlNo ?>')" style="margin-left: 720px;"/>
	<?php  }?>
	
		</div>

	<br><br><br>
	</div>

</body>
