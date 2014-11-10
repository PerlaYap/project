<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>



		<script type="text/javascript">

			function send(control_no){
				
				window.location.href= "profiles?name="+ control_no;
			}
			function report(control_no) {
              myWindow = window.open("terminationreport?name="+control_no, "myWindow", "width=1000, height=800");    
            } 

			</script>


			<?php 
$branchno = $this->session->userdata('branchno');
if($branchno!=1){
$terminate = $this->db->query("SELECT Alpha.MembersControl, CONCAT(LastName,', ', FirstName,' ', MiddleName) AS Name, MemberID, Status, BranchName, CenterNo, DateUpdated
FROM (SELECT A.ControlNo AS MembersControl, C.Status, DATE_FORMAT(DateUpdated,'%b %d %Y') AS DateUpdated
FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo ORDER BY ControlNo)A
LEFT JOIN
(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms 
WHERE DateUpdated<=LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY DateUpdated DESC)B GROUP BY ControlNo)C
ON A.ControlNo=C.ControlNo)Alpha
LEFT JOIN
(SELECT Members_ControlNo, BranchControl, CenterControl, CenterNo, BranchName
FROM (SELECT cchm.Members_ControlNo, A.CaritasCenters_ControlNo,A.DateEntered FROM CaritasCenters_has_Members cchm
LEFT JOIN
(SELECT * FROM CaritasCenters_has_Members WHERE DateEntered<=LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo GROUP BY Members_ControlNo)Alpha
LEFT JOIN (SELECT CenterControl, BranchControl, BranchName, CenterNo FROM 
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters 
WHERE Date<=LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY Date)A
ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo
LEFT JOIN CaritasCenters cc ON B.CenterControl=cc.ControlNo)Beta
ON Alpha.CaritasCenters_ControlNo=Beta.CenterControl) Beta
ON Alpha.MembersControl=Beta.Members_ControlNo 
LEFT JOIN Members mem ON mem.ControlNo=Alpha.MembersControl
LEFT JOIN MembersName mn ON mn.ControlNo=Alpha.MembersControl
WHERE Alpha.Status IS NOT NULL AND Status='Terminated Voluntarily' AND BranchControl='$branchno' order by CenterNo, Name");}
else{
$terminate = $this->db->query("SELECT Alpha.MembersControl, CONCAT(LastName,', ', FirstName,' ', MiddleName) AS Name, MemberID, Status, BranchName, CenterNo, DateUpdated
FROM (SELECT A.ControlNo AS MembersControl, C.Status, DATE_FORMAT(DateUpdated,'%b %d %Y') AS DateUpdated
FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo ORDER BY ControlNo)A
LEFT JOIN
(SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus mhms 
WHERE DateUpdated<=LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY DateUpdated DESC)B GROUP BY ControlNo)C
ON A.ControlNo=C.ControlNo)Alpha
LEFT JOIN
(SELECT Members_ControlNo, BranchControl, CenterControl, CenterNo, BranchName
FROM (SELECT cchm.Members_ControlNo, A.CaritasCenters_ControlNo,A.DateEntered FROM CaritasCenters_has_Members cchm
LEFT JOIN
(SELECT * FROM CaritasCenters_has_Members WHERE DateEntered<=LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY DateEntered DESC)A
ON A.Members_ControlNo=cchm.Members_ControlNo GROUP BY Members_ControlNo)Alpha
LEFT JOIN (SELECT CenterControl, BranchControl, BranchName, CenterNo FROM 
(SELECT cbhcc.CaritasCenters_ControlNo AS CenterControl, A.CaritasBranch_ControlNo AS BranchControl 
FROM caritasbranch_has_caritascenters cbhcc
LEFT JOIN (SELECT * FROM caritasbranch_has_caritascenters 
WHERE Date<=LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY Date)A
ON cbhcc.CaritasCenters_ControlNo=A.CaritasCenters_ControlNo GROUP BY A.CaritasCenters_ControlNo)B
LEFT JOIN CaritasBranch cb ON B.BranchControl=cb.ControlNo
LEFT JOIN CaritasCenters cc ON B.CenterControl=cc.ControlNo)Beta
ON Alpha.CaritasCenters_ControlNo=Beta.CenterControl) Beta
ON Alpha.MembersControl=Beta.Members_ControlNo 
LEFT JOIN Members mem ON mem.ControlNo=Alpha.MembersControl
LEFT JOIN MembersName mn ON mn.ControlNo=Alpha.MembersControl
WHERE Alpha.Status IS NOT NULL AND Status='Terminated Voluntarily' order by CenterNo, Name");}
?>

<div class="content2">
		<h2 class="hTitle">WITHDRAWN ACCOUNTS</h2>
			<div class="center">
				
				<?php if (!empty($terminate->result())): ?>
				<table class="center">
					<tr class="header">
						<th class="tablecount"> </th>
					
						<th class="tablename">NAME</th>
						<th class="tablecenter">REPORT</th>
						<th class="tablecenter">MEMBER ID</th>
						<th class="tablecenter">BRANCH</th>
						<th class="tablecenter">CENTER</th>
						<th class="tablecenter">DATE TERMINATED</th>

					</tr>
					<?php $number=0;  

					 	 foreach ($terminate->result() as $tt) { 
					 	 	$number+=1; ?>
 					<tr class="account">
 						<td><?php echo $number; ?></td>
 						<td><a href="javascript:void(0)" onclick="send('<?php echo $tt->MembersControl ?>')"><?php echo $tt->Name; ?></a></td>
 						<td><a href="javascript:void(0)" onclick="report('<?php echo $tt->MembersControl ?>')">view</a></td>
 						<td><?php echo $tt->MemberID; ?></td>
 						<td><?php echo $tt->BranchName; ?></td>
 						<td><?php echo $tt->CenterNo; ?></td>
 						<td><?php echo $tt->DateUpdated; ?></td>

 					</tr>

 					<?php } ?>

 	
					
				</table> 
				<?php endif ?>
				<?php if (empty($terminate->result())): ?>
					<p class="noresultfound"><br>- No Account Withdrawn - <br><br> </p>
				<?php endif ?>

