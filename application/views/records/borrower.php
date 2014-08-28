<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>



		<script type="text/javascript">

			function send(control_no){
				
				window.location.href= "profiles?name="+ control_no;
			} 

			</script>


		<?php 

$borrower = $this->db->query("SELECT c.CenterNo, mn.FirstName, mn.MiddleName, mn.LastName, b.BranchName, bc.CaritasBranch_ControlNo, cm.CaritasCenters_ControlNo, m.ControlNo, max(l.DateApplied) AS Date, m.MemberID
			FROM   caritasbranch b, caritasbranch_has_caritascenters bc, caritascenters c, caritascenters_has_members cm, members m, membersname mn, members_has_membersmembershipstatus ms, loanapplication_has_members lm, loanapplication l
			WHERE b.ControlNo = bc.CaritasBranch_ControlNo AND bc.CaritasCenters_ControlNo = c.ControlNo AND c.ControlNo = cm.CaritasCenters_ControlNo AND cm.Members_ControlNo = m.ControlNo AND m.ControlNo = mn.ControlNo AND mn.ControlNo = ms.ControlNo AND ms.ControlNo = lm.Members_ControlNo AND lm.loanapplication_controlno = l.ControlNo AND ms.Status = 'Borrower' Order by c.CenterNo");




		?>

<div class="content2">
		<h2 class="hTitle">BORROWER ACCOUNTS</h2>
			<div class="center">
				
				
				<table class="center">
					<tr class="header">
						<th class="tablecount"> </th>
					
						<th class="tablename">NAME</th>
						<th class="tablecenter">MEMBER ID</th>
						<th class="tablecenter">BRANCH</th>
						<th class="tablecenter">CENTER</th>
						<th class="tablecenter">LOAN STARTED</th>

					</tr>
					<?php $number=0;  

					 	 foreach ($borrower->result() as $tt) { 
					 	 	$number+=1; ?>
 					<tr class="account">
 						<td><?php echo $number; ?></td>
 						<td><a href="javascript:void(0)" onclick="send('<?php echo $tt->ControlNo ?>')"><?php echo $tt->LastName.", ".$tt->FirstName." ".$tt->MiddleName; ?></a></td>
 						<td><?php echo $tt->MemberID; ?></td>
 						<td><?php echo $tt->BranchName; ?></td>
 						<td><?php echo $tt->CenterNo; ?></td>
 						<td><?php echo $tt->Date; ?></td>

 					</tr>

 					<?php } ?>

 	
					
				</table> 

