
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/list.css'); ?>">
<script src="<?php echo base_url('Assets/js/list.js'); ?>"></script>
 <!--	<link rel="stylesheet" type="text/css" href="../../../Assets/css/list.css">
	<script src="../../../Assets/js/list.js"></script>-->
 
<?php
$branchno = $this->session->userdata('branchno');

$getmember = $this->db->query("SELECT bc.`CaritasCenters_ControlNo`, `CenterNo`, cm.Members_ControlNo, CONCAT(LastName,', ', FirstName, ' ', MiddleName) as Name , `Approved` 
	FROM `caritasbranch_has_caritascenters` bc join `caritascenters` c on bc.`CaritasCenters_ControlNo` = c.`ControlNo` join `caritascenters_has_members` cm on cm.`CaritasCenters_ControlNo` = c.`ControlNo` join `membersname` mn on mn.ControlNo = cm.Members_ControlNo join `members` m on mn.ControlNo = m.ControlNo  
	WHERE `CaritasBranch_ControlNo` = $branchno and `Approved` ='YES' and cm.Members_ControlNo IN (SELECT MemberControl FROM (SELECT ControlNo AS MemberControl FROM Members_has_Membersmembershipstatus)A LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipstatus ORDER BY DateUpdated DESC)A GROUP BY ControlNo)B ON A.MemberControl=B.ControlNo where Status!='Terminated' and Status!='Terminated Voluntarily' group by MemberControl) ORDER BY `CenterNo`, LastName   ASC");
/*members_has_membersmembershipstatus ms on m.ControlNo = ms.ControlNo*/
 ?>

 			<script type="text/javascript">

			function send(control_no){
				
				window.location.href= "profiles?name="+ control_no;
			} 
			</script>

<body onload="hide()">

	<div class="content2">

		<h2 class="hTitle">MEMBERS</h2>

			
		<div id="table">
			<table>

				<tr>
					<th class="num"></th>
					<th class="docuname">NAME</th>
					<th class="lastupdate">CENTER</th>
				</tr>

				<?php $num = 0;
				foreach ($getmember->result() as $member) { ?>
	
				<tr>
					<td><?php echo $num+=1; ?></td>
					<td class="docuname"><a href="javascript:void(0)" onclick="send('<?php echo $member->Members_ControlNo ?>')"> <?php echo $member->Name ?> </a></td>
					<td class="lastupdate"><?php echo $member->CenterNo ?></td>
				</tr>

				<?php } ?>



			</table>
		</div>

		
	<br><br><br>
	</div>



</body>