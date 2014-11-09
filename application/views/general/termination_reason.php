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
Name: <?php echo $name ?>

Life Status: <input type='radio' name='lifestatus' value='deceased'>Deceased    <input type='radio' name='lifestatus' checked value='living'>Living

Reason for termination:
<input type='textbox' name='term_reason' required>

<input type='submit' value='Submit'>

</form>