<?php
	date_default_timezone_set('Asia/Manila');

	$branch = $this->session->userdata('branch');
	$SOofficer = $this->session->userdata('firstname');
	$branchno = $this->session->userdata('branchno');
	$SOpersonnel =$this->session->userdata('personnelno');

	$weekday = date('l');

	$getcenter = $this->db->query("SELECT `CaritasCenters_ControlNo`, cc.`CenterNo` FROM `caritasbranch_has_caritascenters` , `caritascenters` cc WHERE `CaritasBranch_ControlNo` =$branchno and `CaritasCenters_ControlNo` = cc.`ControlNo` and cc.`Dayoftheweek`='$weekday'");



if (!empty($_POST)) {
	
	$center = $_POST['center'];

	$getMember = $this->db->query("SELECT * FROM (SELECT mem.`ControlNo`,CONCAT(`FirstName`,' ',  `MiddleName`,' ', `LastName`)as Name,  `LoanExpense`, `Savings`, `CapitalShare`,`pastdue`,`CaritasCenters_ControlNo` FROM `caritascenters_has_members` cm, `membersname`mem, `members` m WHERE mem.`ControlNo` = cm.`Members_ControlNo` and cm.`Members_ControlNo` = m.`ControlNo`)member join (SELECT `LoanApplication_ControlNo`,`status`, `Members_ControlNo`,`AmountRequested`, `Interest`, `LoanType` FROM `loanapplication_has_members` lhm , `loanapplication` l WHERE lhm.`LoanApplication_ControlNo` = l.`ControlNo`) loan on member.ControlNo = loan.Members_ControlNo where member.`CaritasCenters_ControlNo`= $center and `status`='Current' order by Name");

	$getSavingsOnly = $this->db->query("SELECT * FROM (SELECT mem.`ControlNo`,CONCAT(`FirstName`,' ', `MiddleName`,' ', `LastName`)as Name,`Approved`, `Savings`,`CaritasCenters_ControlNo`,`LoanExpense` FROM `caritascenters_has_members` cm, `membersname`mem, `members` m WHERE mem.`ControlNo` = cm.`Members_ControlNo` and cm.`Members_ControlNo` = m.`ControlNo`)member where member.`CaritasCenters_ControlNo`= $center and `LoanExpense` = 0 and `Approved`= 'YES'");

	}
 ?>
<!DOCTYPE HTML> 



<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/dailycollection.css'); ?>">
<script src="<?php echo base_url('Assets/js/dailycollection.js'); ?>"></script>

<script type="text/javascript">

function sbudisable(size){

	for (var i = 1; i <= size; i++) {
		var loanpayment = document.getElementById('loanpayment'+i);
		var test = document.getElementById('inputSBU'+i);
		var test2 = document.getElementById('SBUhid'+i);

		if (loanpayment.value=="0") {
			test.value = loanpayment.value;	
			test2.value = test.value;
			test.disabled=true;	
		}else{
			test.value='50';
			test2.value='50';
			test.disabled=false;
		};
		

	};
	
}
function putinput(size){
	for (var i = 1; i <= size; i++) {
		var test = document.getElementById('inputSBU'+i);
		var inputv = document.getElementById('SBUhid'+i);
		inputv.value=test.value;
	};
}
</script>


	<div class="content">
		<br><br>
		<form action="" method="post" name=""  class="basic-grey">
			<h1><br>Daily Collection
				<span>Collection for the month of <b><?php echo date("F, Y") ; ?></b><br></span>
			</h1>

			<label>
				<span>Branch: </span></label>
				<input  id="name" type="text" value="<?php echo $branch; ?>" name="fname" placeholder="" style="width: 570px;" disabled/>
				&nbsp&nbsp&nbsp&nbsp



			<label>
				<span>SO: </span>
					<input  id="name" value="<?php echo $SOofficer; ?>" type="text" name="fname" placeholder="" style="width: 570px;" disabled/>
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			</label>

			<label><span>
				Date: </span>
					<input  id="name" value="<?php echo date("F j, Y  (l) h:i:s A") ; ?>" type="text" name="fname" placeholder="" style="width: 570px;" disabled/>
					<input  id="name" value="<?php echo date("m-j-Y"); ?>" type="hidden" name="date" disabled/>
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			</label>
				
			<label><span>
				Center: </span>
					<select required="" name="center" style="width:80px; margin-top:-2px;" onchange="this.form.submit()">
						<?php if (empty($_POST)) { ?>
						<option value="" selected="selected"></option>	
					<?php	} ?>
					<?php	foreach ($getcenter->result() as $center) { ?>

					<?php if (!empty($_POST)) { 
						if ($_POST['center']==$center->CaritasCenters_ControlNo) {?>
								<option value="<?php echo $center->CaritasCenters_ControlNo; ?>" selected><?php echo $center->CenterNo; ?></option>			
					<?php	}
						else{?>
								<option value="<?php echo $center->CaritasCenters_ControlNo; ?>" ><?php echo $center->CenterNo; ?></option>		
				<?php		}
						//echo $_POST['center'];
					}else{ ?>
						<option value="<?php echo $center->CaritasCenters_ControlNo; ?>"><?php echo $center->CenterNo; ?></option>
					<?php }
					 ?>
					
					
					<?php }?>
					</select> 
		
			
			</label>
		</form>

		<div id="dailycollect">
			<?php if (!empty($_POST)) { ?>
			<!-- <a href="#" class="previous"> << Previous Month </a><a href="#"class="next"> Next Month >> </a> -->

			<form action="recordcollection" name="loancollection" method="post">

	<!-------------------------------------- GENERAL HIDDEN VALUES -------------------------------------------------->
			<input type ='hidden' name='sopersonnel' value='<?php echo $SOpersonnel; ?>'/>
			<input  id="name" value="<?php echo date("Y-m-j") ; ?>" type="hidden" name="date" />
			<input type='hidden' name='branchcontrolno' value='<?php echo $branchno ?>' />
			<input type='hidden' name='centercontrolno' value='<?php echo $mem->CaritasCenters_ControlNo ?>' />

	<!-------------------------------------- GENERAL HIDDEN VALUES -------------------------------------------------->	


			<TABLE class="loancollection">
				<tr>
					<th colspan="6" style="background-color:#828285; color:#e8e8e9;">DAILY LOAN COLLECTION</th>
				</tr>

			<?php 
				$hasmember = $getMember->result();
			if (!empty($hasmember)) { ?>
				
			
				<tr class="headr">
					<th style="width: 20px;">#</th>
					<th style="width: 280px;">Member</th>
					<th style="width: 140px;">Active Release</th>
					<th style="width: 140px;">Past Due</th>
					<!-- <th>SBU</th> -->
					<th style="width: 140px;">Loan Received</th>
					<!-- <th>Withdrawal</th> -->
					<th style="width: 140px;">Loan Balance</th>
					<!-- <th>SBU <br>Total</th> -->
				</tr>


				
				<?php 

				$num=0;
				$activereleasetotal=0;
				$totalpastdue =0;
				$totalsbucollected =0;
				$totalloanrecieved ="";
				$totalwithdrawal =0;
				$totalloanbalance =0;
				$totalsbu =0;
				$y =0;
				$elsize = count($hasmember);

				foreach ($hasmember as $mem) {


					$activerelease =$mem->AmountRequested + $mem->Interest;
					$pastdue =$mem->pastdue;
					$y+=1;

					
				 ?>
	<!-------------------------------------- HIDDEN VALUES -------------------------------------------------->

			<input type='hidden' name='loanappcontrolno[]' value='<?php echo $mem->LoanApplication_ControlNo ?>' />
			<input type='hidden' name='memberid[]' value='<?php echo $mem->Members_ControlNo; ?>'> 

	<!-------------------------------------- HIDDEN VALUES -------------------------------------------------->		
			

				<tr class="row">
					<td class="num" ><?php echo $y; ?>  </td>
					<td class="collectmember"><?php echo $mem->Name; ?></td>
					<td class="ploan"><?php echo $activerelease; ?></td>
					<td class="pd"><?php echo $pastdue; ?></td>
					
					<td class="payment">


						<select id='<?php echo "loanpayment".$y; ?>' name='loanpayment[]' onChange="sbudisable(<?php echo "$elsize"; ?>);" required>

							<?php $loantype = $mem->LoanType;
								if ($loantype =='23-Weeks') {
									$amounttopay = $activerelease/23;
								}else if ($loantype =='40-Weeks') {
										$amounttopay = $activerelease/40;
								}
							 ?>
							
							<option value='0' selected >Unpaid</option>

							<option value='<?php echo $amounttopay;?>'><?php echo $amounttopay; ?></option>
							<?php if ($pastdue >0) { ?>
								<?php for ($k=2; $k <= $pastdue/$amounttopay+1; $k++) { ?>
								<option value='<?php echo $amounttopay*$k; ?>'><?php echo $amounttopay*$k; ?></option>		
							<?php	} ?>
							<?php } ?>

						</select>
						<input type='hidden' name='amounttopay[]' value="<?php echo $amounttopay; ?>"/>
					</td>	
						
					<td class="balance"><?php echo $mem->LoanExpense ?></td>
					<!-- <td class="savings"><?php echo $mem->Savings ?></td> -->

				</tr>
				
				


				<?php
					$activereleasetotal +=$activerelease;
					$totalpastdue +=$pastdue;
					$totalloanbalance +=$mem->LoanExpense;
			} ?>

				

				<tr class="rowtotal">
					<td class="num">  </td>
					<td class="collectmember"style="text-align:right;"><b>TOTAL: &nbsp&nbsp&nbsp&nbsp&nbsp</b></td>
					<td class="ploan" ><b><?php echo $activereleasetotal; ?> </b></td>
					<td class="pd" ><b><?php echo $totalpastdue; ?> </b></td>
					<!-- <td class="sbu"> <b><?php echo $totalsbucollected; ?></b></td> -->
					<td id="payment"><b></b></td>	
					<!-- <td class="withdraw"><b> <?php echo $totalwithdrawal; ?> </b></td> -->
					<td class="balance"><b><?php echo $totalloanbalance; ?></b></td>
					<!-- <td class="savings"><b> <?php echo $totalsbu; ?></b></td> -->

				</tr>

			<?php } else{ ?>
					<tr>
					<th style="width: 20px; text-indent:3px;"></th>
					<th style="width: 350px;"></th>
					<th style="width: 150px;"></th>
					<th style="width: 150px;"></th>
					<th style="width: 200px;"></th>
				</tr>
				<tr>

					<td colspan="5"><center>NO MEMBER FOUND!</center></td>
				</tr>
				<?php } ?>


			</TABLE>

			
		 <!-- Change to Button to Submit Date, BranchControl, CenterControl> -->
		
			
				<div class="basic-grey" style="margin-top:-8px; margin-left: 94px; width: 799px;"></label>
					<!-- <input  type="submit" class="button" value="Submit" style="margin-left: 550px; margin-top:0px; position:absolute;"/> -->

					<input  type="button" name="gotosavings" class="button" value="Go to Savings" style="margin-left: 660px;" onclick="GoToSavings()"/>

				</div>
				
			
				<br><br>
		
		
		</div>

		<div id="savingscollect" style="display:none;">
				<!-- ------------------------------------------ -->
				<!-- ---- SAVINGS ACCOUNT WITH CURRENT LOAN ---- -->	
				<!-- ------------------------------------------ -->

			<TABLE class="loancollection">
				<tr>
					<th colspan="5" style="background-color:#828285; color:#e8e8e9;">SAVINGS ACCOUNT WITH CURRENT LOAN</th>
				</tr>
				<tr>
					<th style="width: 20px; text-indent:3px;">#</th>
					<th style="width: 350px;">MEMBER</th>
					<th style="width: 150px;">SBU</th>
					<th style="width: 150px;">WITHDRAWAL</th>
					<th style="width: 200px;">PREVIOUS SBU TOTAL</th>
				</tr>

				<?php $g=0;
						$sizev = count($hasmember);
						$totalsave = 0;
				foreach ($hasmember as $mem) { 
						$g+=1;
						$maxwithdrawal = $mem->Savings - $mem->AmountRequested*0.4;
				?>
				
					<tr>
						<td style="text-indent: 3px;"><?php echo $g?></td>
						<td style="text-indent: 8px;"><?php echo $mem->Name; ?></td>
						<td style="text-align:center"><input type="number" required class="inputSBU" id="<?php echo "inputSBU".$g; ?>" onChange="putinput(<?php echo "$sizev"; ?>);" disabled='true' name="f[]"/></td>
						<input type='hidden' id="<?php echo "SBUhid".$g; ?>" name='sbu[]' />	
						<td style="text-align:center"><input type="number" min='0' max='<?php echo $maxwithdrawal; ?>' name='withdrawal[]' class="inputSBU" placeholder="Click to Edit" /></td>
						<td style="text-align:center"><?php echo $mem->Savings; ?></td>
					</tr>	
						<?php $totalsave +=$mem->Savings; ?>
				<?php } ?>

				<tr class="border"colspan"6"><td style="height:1px; padding:0px;"></td> </tr>

				<tr>
					<td colspan="2" style="text-align: right;"> <b>TOTAL:</b> &nbsp&nbsp</td>
					<td style="text-align:center"><b></b></td>
					<td style="text-align:center"><b></b></td>
					<td style="text-align:center"><b><?php echo $totalsave; ?></b></td>
				</tr>

			</TABLE>

			<br><br>
				<!-- ------------------------------------------ -->
				<!-- ----------SAVINGS ACCOUNT ONLY------------- -->	
				<!-- ------------------------------------------ -->
			<TABLE class="loancollection">
				<tr>
					<th colspan="5" style="background-color:#828285; color:#e8e8e9;">SAVINGS ACCOUNT ONLY</th>
				</tr>
				<?php 
						$num = 0;
						$getsav=$getSavingsOnly->result();
						if (!empty($getsav)) {
							$totsavings = 0;
				?>			
				
				<tr>
					<th style="width: 20px; text-indent:3px;">#</th>
					<th style="width: 350px;">MEMBER</th>
					<th style="width: 150px;">SBU</th>
					<th style="width: 150px;">WITHDRAWAL</th>
					<th style="width: 200px;">PREVIOUS SBU TOTAL</th>
				</tr>
				

				<?php foreach ($getsav as $savmem) { 

						$name=$savmem->Name;
						$sbutot = $savmem->Savings;
						$memberno2 = $savmem->ControlNo;
	?>

	<!-------------------------------------- HIDDEN VALUES -------------------------------------------------->		

			<input type="hidden" value="<?php echo $memberno2 ?>" name="memberno2[]" />
			

	<!-------------------------------------- HIDDEN VALUES -------------------------------------------------->		


					<tr>
					<td style="text-indent: 3px;"><?php echo $num+=1; ?></td>
					<td style="text-indent: 8px;"><?php echo $name;  ?></td>
					<td style="text-align:center"><input type="number" value="50" required name="saveonly[]" class="inputSBU" placeholder="Click to Edit"/></td>
					<td style="text-align:center"><input type="number"  name="withdrawonly[]" min="0" max="<?php echo $sbutot ?>" class="inputSBU" placeholder="Click to Edit"/></td>
					<td style="text-align:center"><?php echo $sbutot;  ?></td>
					</tr>

					<?php $totsavings +=$sbutot; ?>
				
				<?php } ?>
				
				<tr class="border"colspan"6"><td style="height:1px; padding:0px;"></td> </tr>

				<tr>
					<td colspan="2" style="text-align: right;"> <b>TOTAL:</b> &nbsp&nbsp</td>
					<td style="text-align:center"><b></b></td>
					<td style="text-align:center"><b></b></td>
					<td style="text-align:center"><b><?php echo $totsavings; ?></b></td>
				</tr>
				<?php } else{?>
				
				<tr>
					<th style="width: 20px; text-indent:3px;"></th>
					<th style="width: 350px;"></th>
					<th style="width: 150px;"></th>
					<th style="width: 150px;"></th>
					<th style="width: 200px;"></th>
				</tr>
				<tr>

					<td colspan="5"><center>NO MEMBER FOUND!</center></td>
				</tr>
	

				<?php } ?>

			</TABLE>


			
			

				<div class="basic-grey" style="margin-top:-8px; margin-left: 94px; width: 799px;">
					<input  type="submit" class="button" name="submitbtn" value="Submit" style="margin-left: 505px; margin-top:0px; position:absolute;"/>

					<input  type="button" class="button" value="Go to Daily Collection" style="margin-left: 616px; z-index:1;" onclick="GoToDailyCollection()"/>
				</div>
				
			
				<br><br>

		</div>
		
		
		<?php } ?>
		</form>		
		<br><br><br><br>	
	</div>