

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


</style>
<?php
	$userrank = $this->session->userdata('rank');
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

	<tr>
		<td class="header" colspan="5"><?php echo $currentyear; ?></td>
	</tr>

	<tr>
		<td class="header" style="width: 150px;"> Month </td>
		<td class="header"> Borrower </td>
		<td class="header"> Past Due Matured </td>
		<td class="header"> Active Saver </td>
		<td class="header"> Dormant Saver</td>
	</tr>

	<?php
	for($a=0; $a<12; $a++){
		$date=$currentyear."-".($a+1)."-"."01";
		$active = $this->db->query("SELECT COUNT(A.ControlNo) AS NoActive  FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
			LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
			ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily' AND Status!='Past Due' AND Status!='dormant saver')");
		$past = $this->db->query("SELECT COUNT(A.ControlNo) AS NoActive  FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
			LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH))  ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
			ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='Past Due'");
		$dormant = $this->db->query("SELECT COUNT(A.ControlNo) AS NoActive  FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
			LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
			ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='dormant saver'");

		foreach($active->result() as $data){
			$count=$data->NoActive;
		}
		foreach($past->result() as $data1){
			$count1=$data1->NoActive;
		}
		foreach($dormant->result() as $data2){
			$count2=$data2->NoActive;
		}
		?>
		<tr>
			<td class="data"><?php echo $month[$a]; ?></td>
			<td class="data"><?php echo $count; ?></td>
			<td class="data"><?php echo $count1; ?></td>
			<td class="data"></td>
			<td class="data"><?php echo $count2; ?>	</td>


		</tr>

		<?php }
		?>
	</table>


<br>
<br>
<br>

<table style="margin-left: 300px;" >
			<tr>
				<td style="font-size: 13px;"><?php echo $name; ?></td>
			</tr>
				<?php if($userrank=='branchmanager'){?>
			<tr>
				<td class="BM2">Signature Above Printed Name of Branch Manager</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td class="BM2">Signature Above Printed Name of Salve Officer</td>
			</tr>
			<?php } ?>
			<tr>
				<td style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				
				<td class="BM2">Date</td>
			</tr>
		</table>

		<table style="margin-left: 750px; margin-top: -132px;" >
			
			<?php if($userrank=='branchmanager'){?>
			<tr>
				<td style="font-size: 13px;">Marvin Lao</td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of MIS</td>
			</tr>
			<?php }else{ ?>
			<tr>
				<td style="font-size: 13px;"><?php echo $Manager; ?></td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of Branch Manager</td>
			</tr>
			<?php } ?>
			<tr>
				<td style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				<td class="BM2">Date</td>
			</tr>
		</table>

		
<div class='dontprint' style="width: 100%; text-align: center;">
	<button onclick="window.print()">Print</button> 
</div>