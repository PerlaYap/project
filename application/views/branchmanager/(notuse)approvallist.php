
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/branchmanager.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js') ?>"></script>

<!---->
<?php
$getMember =$this->db->query("SELECT  mem.ControlNo, Picture, MemberID, concat(memname.LastName,', ',memname.FirstName,' ', memname.MiddleName) AS Name,ContactNo,Birthday,BirthPlace, GenderID, Religion, EducationalAttainment,CivilStatus, MFI,Address,AddressDate, Status, Type,BusinessType,CompanyName,CompanyContact,YearEntered, LoanExpense,Savings, CapitalShare 
                                FROM 
                                Members mem 
                                LEFT JOIN MembersName memname ON mem.ControlNo=memname.ControlNo
                                LEFT JOIN (SELECT ControlNo, Status FROM members_has_membersmembershipstatus ORDER BY DateUpdated DESC LIMIT 1) mhmstatus ON mem.ControlNo=mhmstatus.ControlNo
                                LEFT JOIN MembersPicture mempic ON mem.ControlNo=mempic.ControlNo
                                LEFT JOIN (SELECT ControlNo, Type FROM members_has_membertype ORDER BY DateUpdated DESC LIMIT 1) mhmtype ON mem.ControlNo=mhmtype.ControlNo
                                LEFT JOIN MembersContact memcontact ON mem.ControlNo=memcontact.ControlNo
                                LEFT JOIN membersmfi mfi ON mem.ControlNo=mfi.ControlNo
                                LEFT JOIN membersaddress madd ON mem.ControlNo=madd.ControlNo
                                LEFT JOIN sourceofincome soi ON mem.ControlNo=soi.ControlNo
                                WHERE mem.Approved ='P'");

 ?>


		<script type="text/javascript">

			function send(control_no){
				window.location.href= "forapprovals?name="+ control_no;
			}

		</script>
		
	


		<div class="content3">
			<h1>Pending Accounts</h1>
			<div class="grid grid-pad">


				<?php foreach ($getMember->result() as $result) {?>
				<div class="col-1-4">
					<div class="content1">
						<div class="red-accent"></div>
						<br>
						<p class="col-name2"><br><?php echo $result->Name; ?></p>
						<p class="col-branch">Paco - 33</p>
						<br><br>
						<a href="javascript:void(0)" onclick="send('<?php echo $result->ControlNo ?>')"class='col-button'>View Profile</a>


					</div>
					<br><br><br>
				</div> 


<?php } ?>



				</div>
			</div>

			
		</div>
		<br><br>

	


	<!-- UPDATE `microfinance2`.`members` SET `Approved` = 'YES' WHERE `members`.`ControlNo` = 2; -->
