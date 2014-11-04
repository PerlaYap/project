<!-- LYKA... parang report din ito :) so table din itsura -->

<title>List of Past Due Members</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">


<?php 
	$branchno = $this->session->userdata('branchno');
	$branch = $this->session->userdata('branch');
	$center = $_GET['name'];
	date_default_timezone_set('Asia/Manila');
    $datetoday = date('F d, Y');
     $day = date('l');

    $dayoftheWeek= $day;
	$date = $datetoday;
	$next="last ".$dayoftheWeek;
	$datelastweek=date('Y-m-d', strtotime($next,strtotime($date)));
	$datelastweek_1=date('F d, Y', strtotime($next,strtotime($date)));
	$date=$datelastweek;


 ?>
<?php 

$pastduecount = $this->db->query("SELECT member,centercontrol,CenterNo, LoanAppControlNo, Amount, DateTime,TransactionType, CenterNo, CONCAT(LastName,', ',FirstName,' ',MiddleName) as Name, pastdue as prev_pd, ContactNo, Address from (SELECT cm.Members_ControlNo as member, bc.caritascenters_controlno as centercontrol, c.CenterNo FROM caritasbranch_has_caritascenters bc, caritascenters_has_members cm, caritascenters c where bc.caritasbranch_controlno = '$branchno' and bc.caritascenters_controlno = cm.caritascenters_controlno and cm.caritascenters_controlno = c.controlno) s left join `transaction` t on t.Members_ControlNo = s.member join `membersname` nm on nm.ControlNo = s.member join `members` m on m.ControlNo = s.member
join `memberscontact` c on c.ControlNo = s.member join `membersaddress`ad on ad.ControlNo = s.member where DateTime ='$datelastweek' and TransactionType='Past Due' and centercontrol =$center order by Name");

 $pdcount = $pastduecount->result_array();
 		foreach ($pdcount as $pd) {
 			$ctrno = $pd['CenterNo'];
 				}				
				?>






	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	<!-- <img src="<?php // echo base_url ('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"> -->
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		Past Due Members of Center No. <?php echo $ctrno; ?> <br>
		<?php echo $branch ?> Branch <br>
		<?php echo $datetoday ?>

	</h3>

	<br><br>

	<table class="pastdue" border="1">
		<tr>
			<td style="width: 300px; text-align:left; padding: 10px 0px 10px 5px;" colspan="2">
				<b>Date of Past Due:</b> <?php echo $datelastweek_1 ?>
			</td>
		</tr>

				<?php foreach ($pdcount as $pd) { 
				$name = $pd['Name'];
				$amount = $pd['Amount'];
				$prv = $pd['prev_pd'];
				$contact = $pd['ContactNo'];
				$address = $pd['Address'];

				?>

		<tr>
			<td class="PDlabel">Name: </td>
			<td class="PDcontent"><?php echo $name;  ?></td>
		</tr>
		<tr>
			<td class="PDlabel">Past Due Amount:</td>
			<td class="PDcontent"><?php echo number_format($amount, 2) ?></td>
		</tr>
		<tr>
			<td class="PDlabel">Total Past Due:</td>
			<td class="PDcontent"><?php echo number_format($prv, 2); ?></td>
		</tr>
		<tr>
			<td class="PDlabel">Contact Number:</td>
			<td class="PDcontent"><?php echo $contact; ?></td>
		</tr>
		<tr>
			<td class="PDlabel">Permanent Address:</td> 
			<td class="PDcontent"><?php echo $address; ?></td>
		</tr>
		<tr>
			<td colspan="2" style="padding:1;"></td>
		</tr>

				<?php } ?>
	</table>

<!--	
<br>
Name: <?php echo $name;  ?><br>
Past Due Amount: <?php echo $amount; ?><br>
Total Past Due: <?php echo $prv; ?><br>
Contact Number: <?php echo $contact; ?><br>
Permanent Address: <?php echo $address; ?><br>
-->

<br><br>


	<br><br>
	<div style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 
		<button onclick="window.close()">Close</button>
	</div>
