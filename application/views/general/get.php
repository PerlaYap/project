<?php

	$getmember = $this->db->query("SELECT `ControlNo`, `MemberID`, `Birthday`, `BirthPlace`, `GenderID`, `Religion`, `EducationalAttainment`, `CivilStatus`, `profilepic`, `LoanExpense`, `Savings`, `CapitalShare` FROM `members` WHERE 11")；

	$image = mysql_fetch_assoc($getmember);
	$image1 = $image['profilepic'];

	header("Content-Type: image/jpeg");


	echo $image1;


?>