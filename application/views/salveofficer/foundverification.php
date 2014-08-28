<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">

<div class="content2">
	<form action="gotoprofile" method="get" class="basic-grey">
		
		
		<?php
		foreach ($data as $r) {
		 $controlno = $r->ControlNo;
		 $fn =	$r->FirstName;
		 $mn = $r->MiddleName;
		 $ln= $r->LastName;
		 $branch = $r->BranchName;
		 $center = $r->CenterNo;
		 $stat = $r->Status;
		 $date = $r->DateUpdated;
		?>
		<h1><br>
			<!-- <img src="../../../Assets/images/alert.png" class="alertpng"> -->
			<img src="<?php echo base_url('Assets/images/alert.png'); ?>" class="alertpng">
			<!--<img src="<?php echo base_url('Assets/images/alert.png'); ?>" class="caritaslogo">-->
			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			<!--Member Already Exists!-->
			 <?php echo $fn." ".$mn." ".$ln ?> is already in the system. 

			<span><br></span>
		</h1>


		 <br> <br>
		 <label>
		 	<span>Branch:</span>
			<input id="" type="text" name="" value="<?php echo $branch ?>" disabled/>
		 </label>

		 <label>
		 	<span>Center:</span>
			<input id="" type="text" name="" value="<?php echo $center; ?>" disabled/>
		 </label>
		 <label>
		 	<span>Status:</span>
			<input id="" type="text" name="" value="<?php echo $stat; ?>" style="width: 30%;" disabled/> since <input id="" type="text" style="width: 30%;" name="" value="<?php echo $date; ?>" disabled/>
		 </label>
		 
		<br><br>
		<input type="hidden" name="name" value="<?php echo $controlno; ?>">
		<?php } ?>
		
			<input type='submit' name="submitvalue" value="View Profile" class="button00">
			<input type='submit' name="submitvalue" value="Cancel" class="button001">
		

		

	</form>
	<br><br>

</div>