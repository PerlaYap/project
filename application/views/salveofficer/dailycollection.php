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

	$getMember = $this->db->query("SELECT * FROM (SELECT mem.`ControlNo`,CONCAT(`LastName`, ', ', `FirstName`,' ',  `MiddleName`)as Name,  `LoanExpense`, `Savings`, `CapitalShare`,`pastdue`,`CaritasCenters_ControlNo` FROM `caritascenters_has_members` cm, `membersname`mem, `members` m WHERE mem.`ControlNo` = cm.`Members_ControlNo` and cm.`Members_ControlNo` = m.`ControlNo`)member join (SELECT `LoanApplication_ControlNo`,`status`, `Members_ControlNo`,`AmountRequested`, `Interest`, `LoanType` FROM `loanapplication_has_members` lhm , `loanapplication` l WHERE lhm.`LoanApplication_ControlNo` = l.`ControlNo`) loan on member.ControlNo = loan.Members_ControlNo where member.`CaritasCenters_ControlNo`= $center and `status`='Current' order by Name");

	$getSavingsOnly = $this->db->query("SELECT * FROM (SELECT mem.`ControlNo`,CONCAT(`LastName`, ', ', `FirstName`,' ',  `MiddleName`)as Name,`Approved`, `Savings`,`CaritasCenters_ControlNo`,`LoanExpense` FROM `caritascenters_has_members` cm, `membersname`mem, `members` m WHERE mem.`ControlNo` = cm.`Members_ControlNo` and cm.`Members_ControlNo` = m.`ControlNo`)member where member.`CaritasCenters_ControlNo`= $center and `LoanExpense` = 0 and `Approved`= 'YES' order by Name");

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
		<form action="" method="post" name=""  class="basic-grey" style="width: 954px; margin-top:-23px;">
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

		<table border=1 style="border-collapse:collapse; margin-left:auto; margin-right:auto; table">
			<tr> 
				<td class="header" colspan="9">DAILY COLLECTION</td> 
			</tr>
			<tr>
				<td rowspan="2" class="hdrDC" style="width: 10px;"><b>#</b></td>
				<td rowspan="2" class="hdrDC" style="width:260px; "><b>MEMBER NAME</b></td>
				<td colspan="4" class="hdrDC"><b>LOAN</b></td>
				<td colspan="2" class="hdrDC"><b>SAVINGS</b></td>
				<td rowspan="2" class="hdrDC"><b>WITHDRAWAL</b></td>
			</tr>
			<tr>
				<td class="hdrDC">Active Release</td>
				<td class="hdrDC">Past Due</td>
				<td class="hdrDC">Payment</td>
				<td class="hdrDC">Loan Balance</td>

				<td class="hdrDC">Savings Build-Up</td>
				<td class="hdrDC">Savings Collection</td>
			</tr>

			<tr class="dcHover">
				<td class="dcData">1</td>
				<td class="dcData1">Cara Ruiz Manalo</td>
				<td class="dcData">4,000.00</td>
				<td class="dcData">250</td>
				<td class="dcData">	<input type="text" class="dcInput"/>	</td>
				<td class="dcData">4,000.00</td>
				<td class="dcData">5,050.00</td>
				<td class="dcData">	<input type="text" class="dcInput"/>	</td>
				<td class="dcData2">	<input type="text" class="dcInput"/>	</td>
			</tr>

			<tr class="dcHover">
				<td class="dcData">2</td>
				<td class="dcData1">Jolo Manaois Navidad</td>
				<td class="dcData">-</td>
				<td class="dcData">-</td>
				<td class="dcData">	<input type="text" class="dcInput" disabled/>	</td>
				<td class="dcData">-</td>
				<td class="dcData">6,100.00</td>
				<td class="dcData">	<input type="text" class="dcInput"/>	</td>
				<td class="dcData2">	<input type="text" class="dcInput"/>	</td>
			</tr>

			<tr>
				<td colspan="9" style="height:4px; padding:0;"></td>
			</tr>

			<tr class="dcHover">
				<td class="dcData" colspan="2" style="text-align: right;"><b>Total:</b></td>
				<td class="dcData"><b>4,000.00</b</td>
				<td class="dcData"><b>250.00</b></td>
				<td class="dcData"><b>500.00</b></td>
				<td class="dcData"><b>4,000.00</b></td>
				<td class="dcData"><b>11,150.00</b></td>
				<td class="dcData"><b>100.00</b></td>
				<td class="dcData2"><b>0.00</b></td>
			</tr>
			



		</table>

<br><br>
<br><br>
<br><br>