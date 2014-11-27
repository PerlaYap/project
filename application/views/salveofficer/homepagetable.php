

<style type="text/css" media="print">
.dontprint{
	display: none;
	}
@page { 
    size: portrait;
    margin: 0.5in;

  }


</style>


<style type="text/css">
table{
	border-collapse: collapse;
}

.header{
	padding: 10px;
	font-weight: bold;
	font-size: 12px;
	color: black;
	text-align: center;
	width: 100px;
}

.data{
	padding: 10px;
	font-size: 12px;
	color: black;
	text-align: center;
}

.BM2{
	border-top-style: solid;
	border-top-width: 1px;
	border-top-color: black;
	height: 50px;
	width: 270px;
	vertical-align: text-top;
	color: black;
	text-align: center;
	padding:0;
}

.BM1{
	font-weight: bold;
	height: 50px;
	width: 270px;
	color:black;
	vertical-align: bottom;
	text-align: center;
}


</style>
<?php
	$userrank = $this->session->userdata('rank');
	$branchno = $this->session->userdata('branchno');
	$name = $this->session->userdata('firstname');
	$branchno = $this->session->userdata('branchno');
$getManager=$this->db->query("SELECT CONCAT(`FirstName`,' ',  `MiddleName`,' ', `LastName`) AS NAME FROM CaritasPersonnel CL 
											JOIN CARITASBRANCH_HAS_CARITASPERSONNEL BP ON CL.CONTROLNO = BP.CARITASPERSONNEL_ControlNo
											JOIN CARITASBRANCH B ON BP.CARITASBRANCH_CONTROLNO = B.CONTROLNO
											
														WHERE CL.RANK = 'BRANCHMANAGER' 
														AND B.ControlNo = $branchno ");
	foreach ($getManager->result() as $row){ 
		$Manager=$row->NAME;
	}
	 $datetoday = date('F d, Y');
$day = date('l');
$currentmonth = strtoupper(date("F"));
$currentyear = date('Y');



$month = array("January","February","March","April","May","June","July","August","September","October","November","December");



?>

<style type="text/css">
	img.caritaslogo{
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 170px;
		height: auto;
	}

	h3{
		text-align: center;
		font-size: 14px;
		margin-left:auto;
		margin-right:auto; 
		margin-top: -3px;
		font-family: Times New Roman;
		line-height: 15px;
	}	
</style>


		<a href="<?php echo site_url('login/homepage'); ?>" > 
			<img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>"  class="caritaslogo" >
		</a>
		
		<h3>
			CARITAS SALVE CREDIT COOPERATIVE <br>
			Comparison of Accounts<br>
			As of <?php echo date('F d, Y'); ?>

		</h3>


<br>
<table border=1 style="margin-left:auto; margin-right:auto;">

<!--	<tr>
		<td class="header" colspan="5"><?php echo $currentyear; ?></td>
	</tr> -->

	<tr>
		<td class="header" style="width: 150px;"> Month </td>
		<td class="header"> Active Saver </td>
		<td class="header"> Dormant Saver </td>
		<td class="header"> Borrower </td>
		<td class="header"> Past Due Matured</td>
	</tr>

	<?php
	for($a=0; $a<12; $a++){
		$date=$currentyear."-".($a+1)."-"."01";
		$borrower = $this->db->query("SELECT COUNT(MemberControl) AS NoActive FROM (SELECT Members_ControlNo AS MemberControl FROM (SELECT A.Members_ControlNo, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
                                      ON A.Members_ControlNo=B.Members_ControlNo)A
                                      LEFT JOIN (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
                                      ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)B
                                      ON A.CenterControl=B.CenterControl
                                      WHERE BranchControl='$branchno') Alpha
                                      LEFT JOIN (SELECT A.ControlNo FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('2014-11-11', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
                                      ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='Borrower')Beta
                                      ON Alpha.MemberControl=Beta.ControlNo
                                      WHERE ControlNo IS NOT NULL");
         $past = $this->db->query("SELECT COUNT(MemberControl) AS NoActive FROM (SELECT Members_ControlNo AS MemberControl FROM (SELECT A.Members_ControlNo, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
                                      ON A.Members_ControlNo=B.Members_ControlNo)A
                                      LEFT JOIN (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
                                      ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)B
                                      ON A.CenterControl=B.CenterControl
                                      WHERE BranchControl='$branchno') Alpha
                                      LEFT JOIN (SELECT A.ControlNo FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('2014-11-11', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
                                      ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='Past Due')Beta
                                      ON Alpha.MemberControl=Beta.ControlNo
                                      WHERE ControlNo IS NOT NULL");
        $dormant = $this->db->query("SELECT COUNT(MemberControl) AS NoActive FROM (SELECT Members_ControlNo AS MemberControl FROM (SELECT A.Members_ControlNo, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
                                      ON A.Members_ControlNo=B.Members_ControlNo)A
                                      LEFT JOIN (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
                                      ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)B
                                      ON A.CenterControl=B.CenterControl
                                      WHERE BranchControl='$branchno') Alpha
                                      LEFT JOIN (SELECT A.ControlNo FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('2014-11-11', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
                                      ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='dormant saver')Beta
                                      ON Alpha.MemberControl=Beta.ControlNo
                                      WHERE ControlNo IS NOT NULL");
        $activeSaver = $this->db->query("SELECT COUNT(MemberControl) AS NoActive FROM (SELECT Members_ControlNo AS MemberControl FROM (SELECT A.Members_ControlNo, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
                                      ON A.Members_ControlNo=B.Members_ControlNo)A
                                      LEFT JOIN (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
                                      ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)B
                                      ON A.CenterControl=B.CenterControl
                                      WHERE BranchControl='$branchno') Alpha
                                      LEFT JOIN (SELECT A.ControlNo FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('2014-11-11', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
                                      ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='Active Saver')Beta
                                      ON Alpha.MemberControl=Beta.ControlNo
                                      WHERE ControlNo IS NOT NULL");

		foreach($borrower->result() as $data){
			$count=$data->NoActive;
		}
		foreach($past->result() as $data1){
			$count1=$data1->NoActive;
		}
		foreach($dormant->result() as $data2){
			$count2=$data2->NoActive;
		}
		foreach($activeSaver->result() as $data2){
			$count3=$data2->NoActive;
		}
		?>
		<tr>
			<td class="data"><?php echo $month[$a]; ?></td>
			<td class="data"><?php echo $count3; ?></td>
			<td class="data"><?php echo $count2; ?></td>
			<td class="data"><?php echo $count; ?></td>
			<td class="data"><?php echo $count1; ?>	</td>


		</tr>

		<?php }
		?>
	</table>


<br>
<br>
<br>

<table style="margin-left: 50px;" >
			<tr>
				<td  class="BM1" style="font-size: 13px;"><?php echo $name; ?></td>
			</tr>
				<?php if($userrank=='branchmanager'){?>
			<tr>
				<td class="BM2">Signature Above Printed Name of <br> Branch Manager</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td class="BM2">Signature Above Printed Name of <br> Salve Officer</td>
			</tr>
			<?php } ?>
			<tr>
				<td  class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				
				<td class="BM2">Date</td>
			</tr>
		</table>

		<table style="margin-left: 380px; margin-top: -200px;" >
			
			<?php if($userrank=='branchmanager'){?>
			<tr>
				<td  class="BM1" style="font-size: 13px;">Marvin Lao</td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of MIS</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $Manager; ?></td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of <br> Branch Manager</td>
			</tr>
			<?php } ?>
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				<td class="BM2">Date</td>
			</tr>
		</table>

		
<div class='dontprint' style="width: 100%; text-align: center;">
	<button onclick="window.print()">Print</button> 
</div>