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
$datetoday = date('F d, Y');
$day = date('l');
$currentmonth = strtoupper(date("F"));
$currentyear = date('Y');

$month = array("January","February","March","April","May","June","July","August","September","October","November","December");



?>

<< ACCOUNT PERFORMANCE >>
<table border=1>

	<tr>
		<td class="header" colspan="4"><?php echo "Year ".$currentyear; ?></td>
	</tr>

	<tr>
		<td class="header" style="width: 150px;"> Month </td>
		<td class="header"> Active </td>
		<td class="header"> Past Due Mature </td>
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
			<td class="data"><?php echo $count2; ?></td>

		</tr>

		<?php }
		?>
	</table>
