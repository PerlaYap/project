<?php 

	foreach ($profile as $p) {
		   $fname = $p->FirstName;
           $mname = $p->MiddleName;
           $lname = $p->LastName;
           $controlno = $p->ControlNo;

	}

		$name = $fname." ".$mname." ".$lname;



 ?>
<form action='termination_reason' method='post'>
	<input type='hidden' name='controlno' value='<?php echo $controlno ?>'>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/terminate.css'); ?>">

<br>
			<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>

			<h3>
				CARITAS SALVE CREDIT COOPERATIVE <br> 
				Membership Withdrawal <br> 
			</h3>

<div class="basic-grey">
	<br>
	<label>
		<span>Name :</span>
		<input id="name" type="text" name="fname" value="<?php echo $name ?>" style="width: 562px;" disabled/>
	</label>

	<label>
		<span>Life Status: </span>
		<input type='radio' name='lifestatus' value='deceased'> Deceased 
	</label>

	<label><span></span>
		<input type='radio' name='lifestatus' checked value='living'> Living
	</label>   

	<label>
		<span>Reason for Termination:</span>
		<input type='text' name='term_reason' required>
	</label>

	<br>

	<input type='submit' value='Submit' class="button" style="margin-left: 605px;">




</div>


</form>