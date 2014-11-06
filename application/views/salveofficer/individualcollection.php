
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/dailycollection.css'); ?>">
<script src="<?php echo base_url('Assets/js/dailycollection.js'); ?>"></script>
<script type="text/javascript">
	function changesbu(){
		var loanpayment = document.getElementById('loanreceivable');
		var deposit = document.getElementById('deposit');

		if (loanpayment.value=='0') {
			deposit.value = loanpayment.value;
			deposit.readOnly = true;
		}else{
			deposit.readOnly = false;
		} ;
	}

</script>


<?php date_default_timezone_set('Asia/Manila');
	
	$branch = $this->session->userdata('branch');
	$SOofficer = $this->session->userdata('firstname');
	$branchno = $this->session->userdata('branchno');
	$SOpersonnel =$this->session->userdata('personnelno');

	$weekday = date('l');

	$getcenter = $this->db->query("SELECT `CaritasCenters_ControlNo`, cc.`CenterNo` FROM `caritasbranch_has_caritascenters` , `caritascenters` cc WHERE `CaritasBranch_ControlNo` =$branchno and `CaritasCenters_ControlNo` = cc.`ControlNo`");



 ?>
<div class="content">

	<br><br>

	<form action="" method="post" class="basic-grey">
		
		<h1><br>Individual Collection</h1>

		<label>
			<span>Member Type: </span></label>
			<select name='membertype' onchange="this.form.submit()">
				<?php if (empty($_POST)) { ?>
					<option></option>
					<option value="saver"> Saver </option>
					<option value="borrower"> Borrower </option>	
				<?php } else{ ?>
					<?php if ($_POST['membertype'] == "saver") { ?>
						<option value="saver" selected> Saver </option>
						<option value="borrower"> Borrower </option>
					<?php } else{ ?>
						<option value="borrower" selected> Borrower </option>
						<option value="saver" > Saver </option>
					<?php } ?>
				<?php } ?>
				
				
			</select>


								<?php if (!empty($_POST)) {	
									if ($_POST['membertype'] == "saver") { ?>
										
											<input type='hidden' name='membertype' value='saver'>
			<label>
				<span>Center No. :</span>
				<select name="center" onchange="this.form.submit()">
					
					<?php if (empty($_POST['center'])) { ?>
						<option value="" selected="selected"></option>	
					<?php	} ?>
					<?php	foreach ($getcenter->result() as $center) { ?>

					<?php if (!empty($_POST['center'])) { 
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
			
					<?php	if (!empty($_POST['center'])) {
					$centerselected = $_POST['center'];
					$getSavingsOnly = $this->db->query("SELECT * FROM 
						(SELECT mem.`ControlNo`,CONCAT(`LastName`, ', ',`FirstName`,' ', `MiddleName` )as Name,`Approved`, `Savings`,`CaritasCenters_ControlNo`,`LoanExpense` FROM `caritascenters_has_members` cm, `membersname`mem, `members` m WHERE mem.`ControlNo` = cm.`Members_ControlNo` and cm.`Members_ControlNo` = m.`ControlNo`Order by LastName,FirstName)member where member.`CaritasCenters_ControlNo`= $centerselected and `LoanExpense` = 0 and `Approved`= 'YES' ");

					$getsav = $getSavingsOnly->result(); ?>
					<?php if (!empty($getsav)) { ?>
					
			
					<input type='hidden' name='membertype' value='saver'>
					<input type='hidden' name='center' value='<?php echo $centerselected ?>'>  
				
			<label>
				<span>Member:</span>
				<select name='member' onchange="this.form.submit()">
					<<!-- option></option>
					<?php //foreach ($getsav as $save) { ?>
						<option value="<?php //echo $save->ControlNo ?>"><?php // echo $save->Name; ?></option>
					<?php // } ?> -->

					<?php if (empty($_POST['member'])) { ?>
						<option value="" selected="selected"></option>	
					<?php	} ?>
					<?php	foreach ($getsav as $save) { ?>
					<?php if (!empty($_POST['member'])) { 
							if ($_POST['member']==$save->ControlNo) {?>
									<option value="<?php echo $save->ControlNo; ?>" selected><?php echo $save->Name; ?></option>			
						<?php	}
							else{?>
									<option value="<?php echo $save->ControlNo; ?>" ><?php echo $save->Name; ?></option>		
						<?php		}
						}else{ ?>
							<option value="<?php echo $save->ControlNo; ?>"><?php echo $save->Name; ?></option>
						<?php }
						 ?>
						<?php }?>
				</select>
			</label>

	</form>	 
				
			

								<?php if (!empty($_POST['member'])) { ?>

								<?php foreach ($getsav as $s) {
									$member = $s->ControlNo;
									if ($member == $_POST['member'] ) {
										$mem = $s->ControlNo;
										$m_name =$s->Name;
										$totsave = $s->Savings;
									}
									
								} ?>
	<br>
	<form action='addsavingorwithdrawal' method='post' class="basic-grey">
			<input type='hidden' name='memberid' value='<?php echo $mem; ?>'>
			<input  id="name" value="<?php echo date("Y-m-j") ; ?>" type="hidden" name="date" />
			<input type ='hidden' name='sopersonnel' value='<?php echo $SOpersonnel; ?>'/>
				

		<h1><br>SAVINGS</h1>

		<label>
			<span>Current Savings Total:</span>
			<input type="text" disabled value=" <?php echo $totsave; ?>">
		</label>

		<label>
			<span>Deposit::</span>
			<input type='number' name= 'sbu'> 
		</label>

		<label>
			<span>Withdrawal:</span>
			 <input type='number' name='withdrawal' min="0" max="<?php echo $totsave ?>"> <br><br>
		</label>

		<input type='submit' value='Submit' class="button">
	</form>	
			<?php } ?>
			<?php }else{ ?>
				No Saver in the current selected center.
			<?php } ?>

			
			
			<?php }	?>
				<?php }else{ ?>

		<br>
		<form action="" method="post" class="basic-grey">
				<input type='hidden' name='membertype' value='borrower'>
				
				<label>
					<span>Center No. :</span></label>
					<select name="center" onchange="this.form.submit()">
						
						<?php if (empty($_POST['center'])) { ?>
							<option value="" selected="selected"></option>	
						<?php	} ?>
						<?php	foreach ($getcenter->result() as $center) { ?>

						<?php if (!empty($_POST['center'])) { 
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

				
			
									<?php if (!empty($_POST['center'])) {
										$centerselected = $_POST['center'];
										$getMember = $this->db->query("SELECT * FROM 
											(SELECT mem.`ControlNo`,CONCAT(`LastName`, ', ',`FirstName`,' ', `MiddleName` )as Name,  `LoanExpense`, `Savings`, `CapitalShare`,`pastdue`,`CaritasCenters_ControlNo` FROM `caritascenters_has_members` cm, `membersname`mem, `members` m WHERE mem.`ControlNo` = cm.`Members_ControlNo` and cm.`Members_ControlNo` = m.`ControlNo` Order by LastName, FirstName)member join 
											(SELECT `LoanApplication_ControlNo`,`status`, `Members_ControlNo`,`AmountRequested`, `Interest`, `LoanType` FROM `loanapplication_has_members` lhm , `loanapplication` l WHERE lhm.`LoanApplication_ControlNo` = l.`ControlNo`) loan on member.ControlNo = loan.Members_ControlNo where member.`CaritasCenters_ControlNo`= $centerselected and `status`='Current' ");
										$borrower = $getMember->result();
										if (!empty($borrower)) { ?>
											
												<input type='hidden' name='membertype' value='borrower'>
												<input type='hidden' name='center' value='<?php echo $centerselected ?>'> 
						
				<label>
						<span>Member:</span>
						<select name='member2' onchange="this.form.submit()">
							<!-- option></option>
							<?php //foreach ($getsav as $save) { ?>
								<option value="<?php //echo $save->ControlNo ?>"><?php // echo $save->Name; ?></option>
							<?php // } ?> -->
								<?php if (empty($_POST['member2'])) { ?>
								<option value="" selected="selected"></option>	
							<?php	} ?>
							<?php	foreach ($borrower as $bow) { ?>
								<?php if (!empty($_POST['member2'])) { 
								if ($_POST['member2']==$bow->ControlNo) {?>
										<option value="<?php echo $bow->ControlNo; ?>" selected><?php echo $bow->Name; ?></option>			
							<?php	}
							else{?>
										<option value="<?php echo $bow->ControlNo; ?>" ><?php echo $bow->Name; ?></option>		
							<?php		}
							}else{ ?>
								<option value="<?php echo $bow->ControlNo; ?>"><?php echo $bow->Name; ?></option>
							<?php }
							 ?>
								<?php }?>
						</select>
				</label>

					
				
				</form>

					<?php if (!empty($_POST['member2'])) { ?>

					<?php foreach ($borrower as $b) {
						$member = $b->Members_ControlNo;
					if ($member == $_POST['member2'] ) {
						$mem = $b->ControlNo;
						$m_name =$b->Name;
						$activerelease = $b->AmountRequested + $b->Interest;
						$pastdue = $b->pastdue;
						$loanappcontrol = $b->LoanApplication_ControlNo;
						$loantype = $b->LoanType;
						$loanbalance = $b->LoanExpense;
						$p_save = $b->Savings;
						$maxwithdrawal = $b->Savings - $b->AmountRequested*0.4;

						if ($loantype == '23-Weeks') {
							$amounttopay = $activerelease/23;
						}elseif ($loantype == '40-Weeks') {
							$amounttopay = $activerelease/40;
						}


						
					}
					
				} ?>

				<br>
					<form action='individualloanpay' method='post' class="basic-grey">
						<input type='hidden' name='memberid' value='<?php echo $mem; ?>'>
						<input  id="name" value="<?php echo date("Y-m-j") ; ?>" type="hidden" name="date" />
						<input type ='hidden' name='sopersonnel' value='<?php echo $SOpersonnel; ?>'/><input type='hidden' name='amounttopay' value="<?php echo $amounttopay; ?>"/>
						<input type='hidden' value='<?php echo $loanappcontrol ?>' name='loanappcontrolno'>
					
					<h1><br><br>LOAN COLLECTION </h1>
						

						<label>
							<span>Active Release:</span>
							<input type="text" disabled value="<?php echo $activerelease ?>">
						</label>
						<label>
							<span>Past Due:</span>
							<input type="text" disabled value="<?php echo $pastdue ?>">
						</label>
						<label>
							<span>Loan Balance:</span>
							<input type="text" disabled value="<?php echo $loanbalance ?>">
						</label>
						<label>
							<span>Loan Receivable:</span>
							<input type='number' min='0' max='<?php echo $loanbalance ?>' id='loanreceivable' name='loan' required onChange="changesbu()" >
						</label>

					<h1><br><br>SAVINGS </h1>
					
						<label>
							<span>Current Total Savings:</span>
							<input type="text" disabled value="<?php echo $p_save ?>">
						</label>

						<label>
							<span>Deposit</span>
							<input type='number' name='sbu' id='deposit' readOnly='true' >
						</label>

						<label>
							<span>Withdrawal: </span>
							<input type='number' name='withdrawal' min='0' max='<?php echo $maxwithdrawal; ?>'><br>
						</label>						



					
					<input type='submit' value='Submit' class="button">
				</form>	
						
					<?php } ?>





				<?php }	else{ ?>

					<script language="javascript">
						alert("No Member Found")
					</script>';
				<?php }		
			} ?>

	<?php }

	} ?>
	
<br><br>


</div>
<br><br>