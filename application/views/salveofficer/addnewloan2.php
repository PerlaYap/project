<!DOCTYPE HTML>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<!--<link rel="stylesheet" type="text/css" href="../../../Assets/css/salveofficer.css">-->
<script src="<?php echo base_url('Assets/js/newloan.js'); ?>"></script>
<script src="<?php echo base_url('Assets/js/jquery-1.11.1.js'); ?>"></script>



<?php 
$branchno = $this->session->userdata('branchno');

$householdlist=$this->db->query("SELECT mhm.HouseholdNo, concat(hn.LastName,', ',hn.FirstName,' ', hn.MiddleName) AS Name
	FROM members_has_membershousehold mhm 
	LEFT JOIN householdname hn ON  mhm.HouseholdNo=hn.HouseholdNo
	RIGHT JOIN (SELECT ControlNo FROM members mem WHERE mem.MemberID='$mid')A ON A.ControlNo=mhm.ControlNo"); ?>

<?php $savings=$this->db->query("SELECT Savings FROM Members WHERE MemberId='$mid'");
foreach ($savings->result() as $row) {
	$savings=$row->Savings;
}
?>

<?php $loanCount=$this->db->query("SELECT count(LoanApplication_ControlNo) AS LoanNumber 
	FROM loanapplication_has_members lhmem
	RIGHT JOIN Members mem ON lhmem.Members_ControlNo=mem.ControlNo
	WHERE MemberID='$mid'");
foreach ($loanCount->result() as $row) {
	$loanCount=$row->LoanNumber;
}
?>

<?php $loanbusiness=$this->db->query("SELECT lb.ControlNo, lb.BusinessName FROM loanbusiness_has_loanapplication lhl 
	RIGHT JOIN (SELECT LoanApplication_ControlNo AS ControlNo FROM loanapplication_has_members lhm WHERE Members_ControlNo=(SELECT ControlNo FROM Members WHERE MemberID='$mid')) A ON A.ControlNo=lhl.LoanApplication_ControlNo
	LEFT JOIN loanbusiness lb ON lhl.LoanBusiness_ControlNo=lb.ControlNo GROUP BY BusinessName"); ?>

<?php $membercomaker=$this->db->query("SELECT Alpha.ControlNo, CONCAT(LastName,', ',FirstName,' ', MiddleName) AS Name, MemberID FROM (SELECT A.ControlNo, Status FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo)A
	LEFT JOIN (SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus ORDER BY ControlNo ASC, DateUpdated DESC)A GROUP BY ControlNo)B
	ON A.ControlNo=B.ControlNo WHERE Status!='Terminated' AND Status!='Terminated Voluntarily')Alpha
LEFT JOIN
(SELECT MemberControl, BranchControl FROM (SELECT A.Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
	LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
	ON A.Members_ControlNo=B.Members_ControlNo)Alpha
LEFT JOIN (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo)A
	LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
	ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)Beta
ON Alpha.CenterControl=Beta.CenterControl)Beta
ON Alpha.ControlNo=Beta.MemberControl
LEFT JOIN membersname mn ON mn.ControlNo=Alpha.ControlNo
LEFT JOIN Members mem ON mem.ControlNo=Alpha.ControlNo
WHERE BranchControl='$branchno' ORDER BY Name ASC"); ?>

<?php $memberinfo=$this->db->query("SELECT cb.ControlNo AS BranchControl, cb.BranchName,cc.ControlNo AS CenterControl, cc.CenterNo, B.FirstName, B.MiddleName, B.LastName, B.ControlNo, B.MemberID FROM caritasbranch_has_caritascenters cbhcc 
	LEFT JOIN caritasbranch cb ON cbhcc.CaritasBranch_ControlNo=cb.ControlNo
	LEFT JOIN caritascenters cc ON cbhcc.CaritasCenters_ControlNo=cc.ControlNo
	RIGHT JOIN (SELECT chm.CaritasCenters_ControlNo AS CenterControl ,A.ControlNo, MemberID, FirstName, MiddleName, LastName FROM caritascenters_has_members chm 
		RIGHT JOIN (SELECT mem.ControlNo, MemberID, FirstName, MiddleName, LastName FROM membersname memn RIGHT JOIN Members mem ON mem.ControlNo=memn.ControlNo WHERE mem.MemberID='$mid') A ON A.ControlNo=chm.Members_ControlNo) B ON cbhcc.CaritasCenters_ControlNo=B.CenterControl
"); 

$capitalshare = $this->db->query("SELECT `MemberID` ,`totcapitalshare` FROM `totalcapitalshare` t join members m on t.Members_ControlNo = m.ControlNo where `MemberID` = '$mid'");

if (!empty($capitalshare->result())) {
	foreach ($capitalshare->result() as $cap) {
		$totcapitalshare = $cap->totcapitalshare;
	}
}else{
	$totcapitalshare = 0;
}

foreach ($memberinfo->result() as $row) {
	$firstName=$row->FirstName;
	$lastName=$row->LastName;
	$middleName=$row->MiddleName;
	$branchControl=$row->BranchControl;
	$branchName=$row->BranchName;
	$centerControl=$row->CenterControl;
	$centerNo=$row->CenterNo;
	$memberControl=$row->ControlNo;
	$memberID=$row->MemberID;
}

$getPic =$this->db->query("SELECT * FROM MembersPicture WHERE ControlNo = '$memberControl' ");
?>

<?php $dayoftheweek=$this->db->query("SELECT DayoftheWeek FROM caritascenters WHERE ControlNo='$centerControl'"); 
foreach ($dayoftheweek->result() as $row){
	$dayoftheweek=$row->DayoftheWeek;
}
?>

<?php $businessExpense=$this->db->query("SELECT ExpenseType FROM BusinessExpenseType ORDER BY ExpenseType ASC"); 
$countBex=$businessExpense->num_rows;
?>

<?php $familyExpense=$this->db->query("SELECT ExpenseType FROM FamilyExpenseType ORDER BY ExpenseType ASC"); 
$countFex=$familyExpense->num_rows;
?>

<?php $sourceIncome=$this->db->query("SELECT IncomeType FROM IncomeType ORDER BY IncomeType ASC"); 
$countSinc=$sourceIncome->num_rows;
?>

<script>
function number_format(number, decimals, dec_point, thousands_sep) {
  //  discuss at: http://phpjs.org/functions/number_format/
  // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: davook
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Theriault
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Michael White (http://getsprink.com)
  // bugfixed by: Benjamin Lupton
  // bugfixed by: Allan Jensen (http://www.winternet.no)
  // bugfixed by: Howard Yeend
  // bugfixed by: Diogo Resende
  // bugfixed by: Rival
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
  //  revised by: Luke Smith (http://lucassmith.name)
  //    input by: Kheang Hok Chin (http://www.distantia.ca/)
  //    input by: Jay Klehr
  //    input by: Amir Habibi (http://www.residence-mixte.com/)
  //    input by: Amirouche
  //   example 1: number_format(1234.56);
  //   returns 1: '1,235'
  //   example 2: number_format(1234.56, 2, ',', ' ');
  //   returns 2: '1 234,56'
  //   example 3: number_format(1234.5678, 2, '.', '');
  //   returns 3: '1234.57'
  //   example 4: number_format(67, 2, ',', '.');
  //   returns 4: '67,00'
  //   example 5: number_format(1000);
  //   returns 5: '1,000'
  //   example 6: number_format(67.311, 2);
  //   returns 6: '67.31'
  //   example 7: number_format(1000.55, 1);
  //   returns 7: '1,000.6'
  //   example 8: number_format(67000, 5, ',', '.');
  //   returns 8: '67.000,00000'
  //   example 9: number_format(0.9, 0);
  //   returns 9: '1'
  //  example 10: number_format('1.20', 2);
  //  returns 10: '1.20'
  //  example 11: number_format('1.20', 4);
  //  returns 11: '1.2000'
  //  example 12: number_format('1.2000', 3);
  //  returns 12: '1.200'
  //  example 13: number_format('1 000,50', 2, '.', ' ');
  //  returns 13: '100 050.00'
  //  example 14: number_format(1e-8, 8, '.', '');
  //  returns 14: '0.00000001'

  number = (number + '')
  .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
  prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
  sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
  dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
  s = '',
  toFixedFix = function(n, prec) {
  	var k = Math.pow(10, prec);
  	return '' + (Math.round(n * k) / k)
  	.toFixed(prec);
  };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
  .split('.');
  if (s[0].length > 3) {
  	s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
  	.length < prec) {
  	s[1] = s[1] || '';
  s[1] += new Array(prec - s[1].length + 1)
  .join('0');
}
return s.join(dec);
}


$(document).ready(function(){
	icalculateSum();
	fcalculateSum();
	bcalculateSum();
	total();
	maxLoan();
	materialSum();

	$("input#loanamount").on("keydown keyup",function(){
		maxLoan();
	});

	$(".unitprice_1").on("keydown keyup",function(){
		materialSum();
	});

	/*$(".quantity_1").on("keydown keyup",function(){
		materialSum();
	});*/

	$(".incomeCIinput").on("keydown keyup",function(){
		icalculateSum();
		total();
	});

	$(".familyCIinput").on("keydown keyup",function(){
		fcalculateSum();
		total();
	});

	$(".businessCIinput").on("keydown keyup",function(){
		bcalculateSum();
		total();
	});

	$(".bexpense").on("keydown keyup",function(){
		bcalculateSum();
		total();
	});
});

function maxLoan(){
	var enteredLoan=parseFloat($("input#loanamount").val());
	var maxLoan=0;
	var savings=0;
	savings+=parseFloat(<?php echo $savings ?>);
	if(<?php echo $loanCount?>==0){
		maxLoan+=4000;
	}
	else{
		if(enteredLoan>50999)
			maxLoan=(savings/.50);
		else
			maxLoan=(savings/.40);
	}
	$("input#maxLoan").val(number_format(maxLoan,2));
	
	if(enteredLoan>maxLoan){
		document.getElementById("loanamount").style.border="thin solid red";
	}
	else{
		document.getElementById("loanamount").style.border="";
	}
}


function icalculateSum(){
	var sum=0;

	$(".incomeCIinput").each(function(){
		if(!isNaN(this.value) && this.value.length !=0){
			sum+=parseFloat(this.value);
		}
	});

	$("input#isubtotal").val(number_format(sum,2));
}

function fcalculateSum(){
	var sum=0;

	$(".familyCIinput").each(function(){
		if(!isNaN(this.value) && this.value.length !=0){
			sum+=parseFloat(this.value);
		}
	});

	$("input#fsubtotal").val(number_format(sum,2));
}

function bcalculateSum(){
	var sum=0;

	$(".businessCIinput").each(function(){
		if(!isNaN(this.value) && this.value.length !=0){
			sum+=parseFloat(this.value);
		}
	});

	$("input#bsubtotal").val(number_format(sum,2));
}

function materialSum(){
	var sum=0;
	var unitprice=[];
	//var quantity=[];

	$(".unitprice_1").each(function(){
		if(!isNaN(this.value) && this.value.length !=0){
			unitprice.push(this.value);
		}
	});

	/*$(".quantity_1").each(function(){
		if(!isNaN(this.value) && this.value.length !=0){
			quantity.push(this.value);
		}
	})
  */
	//if(unitprice.length==quantity.length){
		for(var a=0; a<unitprice.length; a++){
			sum+=unitprice[a];
		}
	//}

	$("input#materialtotal").val(number_format(sum));
}

function total(){
	var income= 0;
	var expense= 0;
	var difference=0;

	income+=parseFloat($("input#isubtotal").val().replace(',',''));
	
	expense+=parseFloat($("input#bsubtotal").val()) + parseFloat($("input#fsubtotal").val().replace(',',''));

	difference+=parseFloat(income)-parseFloat(expense);

	$("input#incometotal").val(number_format(income,2));
	$("input#expensetotal").val(number_format(expense,2));
	$("input#difference").val(number_format(difference,2));
}

(function($) {
	$.fn.currencyFormat = function() {
		this.each( function( i ) {
			$(this).change( function( e ){
				if( isNaN( parseFloat( this.value ) ) ) return;
				this.value = number_format(this.value,2);
			});
		});
            return this; //for chaining
        }
    })( jQuery );

    // apply the currencyFormat behaviour to elements with 'currency' as their class
    $( function() {
    	$('.incomeCIinput').currencyFormat();
    	$('.familyCIinput').currencyFormat();
    	$('.incomeCIinput').currencyFormat();
    });

    </script>

    



    <div class="content2">

    	<br>
    	<form action="addnewloanprocess1" method="post" name="addnewloanprocess1" class="basic-grey" onSubmit="return check();">
    		<br>
    		

    		
    		<style type="text/css">
    		p.reqd{
    			color: #c43434;
    			font: 12px Georgia, "Times New Roman", Times, serif;
    			display: inline;
    			vertical-align: super;
    		}

    		</style>








    		<h1>New Loan Application
    			<!--     <span>Please fill in the following fields.</span> -->
    		</h1>
    		
    		<label>
    			<span>Name :</span></label>
    			<input  id="name" type="text" readOnly="true" style="width: 180px;" value="<?php echo $firstName ?>"/>
    			<input  id="name" type="text" readOnly="true" style="width: 170px;" value="<?php echo $middleName ?>"/>
    			<input  id="name" type="text" readOnly="true" style="width: 175px;" value="<?php echo $lastName ?>"/>
    			
    			
    			<label>
    				<span>Member ID :</span> </label>
    				<input type="text" readOnly="true" name="memberid" style="width:260px;" value="<?php echo $memberID ?>" >

    				&nbsp &nbsp 
    				Loan Date  :  
    				<input type="text" readOnly="true" name="loandate" style="width:207px;" value="<?php echo $date ?>" >

    				<label>
    					<span>Caritas Salve Branch :</span> </label>

    					<input type="text" readOnly="true" name="branch" style="width:400px;" value="<?php echo $branchName ?>">

    					&nbsp &nbsp &nbsp &nbsp
    					Center No. :  
    					<input type="text" readOnly="true" style="width:53px;" value="<?php echo $centerNo ?>" >
    					<input type="hidden" name="centercontrol" value="<?php echo $centerControl?>" />


    					<br><br><br><br>
    					<h1 style="border-top: 1px solid #DADADA; padding-top: 15px;" >Loan Information
    						<span>Please add the requested loan information. </span>
    						<!--  <span>Pakiautomatic yung pagcalculate kung yung loan amount ay nageexceed sa maximum. Pakiayus din yung values sa capital shares, 100-5000 siya. pakicheck din kung mageexceed na siya sa 5000 kung bibili man siya, bawal na siya dapat bumili kung ganun</span> -->
    					</h1>

    					<label>
    						<span>Current Capital Share:</span> 
    						<input type='text' value='<?php echo number_format($totcapitalshare,2) ?>'>
    					</label>

    					<label>
    						<span>Cost of Shares for Purchase:<p class="reqd">*</p></span>
    						<?php $r_cap = 5000 - $totcapitalshare;
    						$r_size = $r_cap/100;
    						?>

    						<select required="true" name="capitalshare" style="width:580px;">
    							<option></option>
    							<?php if ($r_size>0){ ?>
    							<?php for ($k=1; $k <=$r_size ; $k++) { ?>
    							<option value='<?php echo 100*$k ?>'><?php echo$k." - ".number_format(100*$k,2) ?></option>
    							<?php } ?>
    							<?php }else{ ?>
    							<option value='0'>0.00</option>
    							<?php } ?>
    						</select>
    					</label>  

    					<label>
    						<?php $maxloan_1 = 0;
    						if ($loanCount==0) {
    							$maxloan_1 += 4000;
    						}else{
    							$maxloan_1 = ($savings/0.4);
    						}
    						?>

    						<span>Amount Requested:<p class="reqd">*</p></span></label>
    						<input required="true" type="number" max='<?php echo $maxloan_1; ?>' min='0' title="Maximum Loan Amount: <?php echo $maxloan_1 ?>" id="loanamount" name="amountreq" style="width: 210px;" placeholder="Pesos" />	

    						&nbsp&nbsp&nbsp&nbsp
    						Max Loan Amount :
    						<input type="text" readOnly="true" id="maxLoan" name="" style="width: 210px; color:#962a2a" />
    						
    						
    						<label>
    							<span>Loan Duration: <p class="reqd">*</p></span></label>
    							<select required="true" name="loantype" style="width:220px;">
    								<option value="" selected="selected"></option>
    								<option value="23-Weeks">23-weeks</option>
    								<option value="40-Weeks">40-weeks</option>
    							</select>

    							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
    							Day of Payment :
    							<input type="text" readOnly="true" id="day" name="paymentday" style="width: 210px;" value="<?php echo $dayoftheweek ?>"/>
    							


    							<br><br><br><br>
    							<h1 style="border-top: 1px solid #DADADA; padding-top: 15px;" >Business Information

    								<span>Please add your current business information.</span>
    							</h1>
    							
    							<label>
    								<span>Business:<p class="reqd">*</p></span>
    								<select required="true" style="width:572px;" name="loanbusiness" id="selectMenu" onchange="showBusiness(this.value)">
    									<option value="existingbusiness" selected>Existing Business</option>
    									<option value="newbusiness">New Business</option>

    									<?php
    									foreach ($loanbusiness->result() as $row) { 
    										echo "<option value='".$row->ControlNo."'>".$row->BusinessName."</option>" ;
    									} ?>
    								</select>
    							</label>
    							
    							<div id="newbusiness">
    								<label>
    									<span>Name:<p class="reqd">*</p></span> 
    									<input id="business" type="text" name="businessname" style="width:562px;" /> 
    								</label>

    								<label>
    									<span>Type:<p class="reqd">*</p></span> </label>
    									<!--        <input id="business" type="text" name="type" style="width:220px;" /> -->
    									<select required="true" id="business" name="type" style="width:220px;">
    										<option value=" "></option>
    										<option value="Alcohol/Tobacco Sales">Alcohol/Tobacco Sales</option>
    										<option value="Bakery">Bakery</option>
    										<option value="Barber Shop">Barber Shop</option>
    										<option value="Caterer">Caterer</option>
    										<option value="Farming(Animal Production)">Farming(Animal Production)</option>
    										<option value="Farming(Crop Production)">Farming(Crop Production)</option>
    										<option value="Fishing/Hunting">Fishing/Hunting</option>
    										<option value="Florist">Florist</option>
    										<option value="Laundry">Laundry</option>
    										<option value="Motor Vehicle Repair">Motor Vehicle Repair</option>
    										<option value="Nail Salon">Nail Salon</option>
    										<option value="Others">Others</option>
    										<option value="Repair/Maintenance">Repair/Maintenance</option>
    										<option value="Retail Sales">Retail Sales</option>
    										<option value="Specialty Food(Fruit/Vegetables)">Specialty Food(Fruit/Vegetables)</option>
    										<option value="Specialty Food(Meat)">Specialty Food(Meat)</option>
    										<option value="Specialty Food(Seafood)">Specialty Food(Seafood)</option>
    										<option value="Taxi Services">Taxi Services</option>
    										<option value="Used Motor Vehicle Sales">Used Motor Vehicle Sales</option>
    										<option value="Used Scraps Sales">Used Scraps Sales</option>
    									</select>


    									
    									&nbsp&nbsp
    									Date Established:<p class="reqd">*</p>
    									
    									<select name="month" style="width:85px">
    										<option>Month</option>
    										<option value="01">January</option>
    										<option value="02">February</option>
    										<option value="03">March</option>
    										<option value="04">April</option>
    										<option value="05">May</option>
    										<option value="06">June</option>
    										<option value="07">July</option>
    										<option value="08">August</option>
    										<option value="09">September</option>
    										<option value="10">October</option>
    										<option value="11">November</option>
    										<option value="12">December</option>
    									</select>
    								</select>
    								<select name="day" style="width:55px">
    									<option>Day</option>
    									<?php  for ($i=1; $i < 32 ; $i++) { ?>
    									<?php if ($i<10) { ?>
    									<option value="<?php echo '0'.$i ?>"><?php echo '0'.$i ?></option>		
    									<?php } else{ ?>
    									<option value="<?php echo $i ?>"><?php echo $i ?></option>]
    									<?php } ?>
    									<?php  } ?> 
    								</select>
    								<select name="year" style="width:67px">
    									<option>Year</option>
    									<?php  for ($y=1990; $y < 2014 ; $y++) { ?>
    									<option value="<?php echo $y ?>"><?php echo $y ?></option>
    									<?php  } ?>
    								</select>
    								

    								<label>
    									<span>Address:<p class="reqd">*</p></span> 
    									<input id="baddress" type="text" name="businessaddress" style="width:562px;" /> 
    								</label>

    								<label>
    									<span>Contact:<p class="reqd">*</p></span> 
    									<input id="business" type="text" name="contact" style="width:562px;" placeholder="7 or 11 digit number" /> 
    								</label>
    							</div>

    							<br><br><br><br>
    							<h1 style="border-top: 1px solid #DADADA; padding-top: 15px;" >Material Inventory
    								<span>Please indicate the general materials needed in the business.</span>
    							</h1>

    							

    							<label>
    								<span>Material Type:<p class="reqd">*</p></span></label>
    								<!--  <input required="true" type="text" name="materials" class="material_1" style="width: 250px;"/> -->
    								<select required="true" name="materials" class="material_1" style="width:220px;">
    									<option value=" "></option>
    									<option value="Advertising">Advertising</option>
    									<option value="Business Goods">Business Goods</option>
    									<option value="Business Supplies">Business Supplies</option>
    									<option value="Construction Materials">Construction Materials</option>
    									<option value="Employee Salary">Employee Salary</option>
    									<option value="Labor Cost">Labor Cost</option>
    									<option value="Office Supplies">Office Supplies</option>
    									<option value="Others">Others</option>
    									<option value="Monthly Rent">Monthly Rent</option>
    									<option value="Taxes">Taxes</option>
    									<option value="Transportation Service">Transportation Service</option>
    									<option value="Utilities">Utilities</option>
    								</select>
    								&nbsp&nbsp&nbsp
    								<!--Qty:<p class="reqd">*</p>
    								<input required="true" type="text" name="quantity" class="quantity_1" style="width: 26px;"/>
                    
    								&nbsp&nbsp&nbsp-->
    								Unit Price:<p class="reqd">*</p>
    								<input required="true"  type="text" name="unitprice" class="unitprice_1" style="width: 80px;" placeholder="Peso"/> &nbsp&nbsp 
    								
    								<input type="button" class="addmore2" value="+" onclick="addMaterial()"/>

    								<div id="inventory"></div>

    							</label>				    
    							&nbsp&nbsp&nbsp   &nbsp&nbsp&nbsp	   &nbsp&nbsp&nbsp		   &nbsp&nbsp&nbsp	   &nbsp&nbsp&nbsp	 &nbsp&nbsp&nbsp		   &nbsp&nbsp&nbsp	   &nbsp&nbsp&nbsp		

    							Subtotal: <input id="materialtotal" type="text" name="" style="width:100px;" disabled/>
    							<br><br><br><br>
    							<h1 style="border-top: 1px solid #DADADA; padding-top: 15px;" >Household Co-Maker Information
				        <!-- <span>yung business rule dito yung 1st-3rd loan cycle ni member, co-maker yung hihingin, yung comaker dapat member ng company at 3 times lang siya pwede maging comaker at kung 4th loan cycle na, dapat guarantor na, yung guarantor pwede siya relative/ friend/ any individual na malapit sa bahay ni member, basta kilala siya ni member by 2 years; ayusin natin yung fixed values ng relationship part
				    </span> -->
				</h1>

        <!--
				<label>
					<span>Household Co-Maker :</span>
					<select required="true" id="comaker" name="comaker" style="width:572px;" onchange="showCoMaker(this.value)" >
						<option value="newhousehold">New Household</option>
						<?php
						foreach ($householdlist->result() as $row) { 
							echo "<option value='".$row->HouseholdNo."'>".$row->Name."</option>" ;
						} ?>
					</select>
				</label>


				<div id="newhousehold">
					<label>
						<span>Name :</span> </label>
						<input id="household" type="text" name="hfname" placeholder="First Name" style="width: 176px;"/>
						<input id="household" type="text" name="hmname" placeholder="Middle Name" style="width: 170px;"/>
						<input id="household" type="text" name="hlname" placeholder="Last Name" style="width: 176px;"/>
						
						<label>
							<span>Relationship :</span> </label>
							<select name="hrelation" style="width:405px;">
								<option value=" "></option>
								<option value="Aunt/Uncle">Aunt/Uncle</option>
								<option value="Cousin">Cousin</option>
								<option value="Grandparent">Grandparent</option>
								<option value="In-Law">In-Law</option>
								<option value="Others">Others</option>
								<option value="Sibling">Sibling</option>
								<option value="Spouse">Spouse</option>
								<option value="Parent">Parent</option>

							</select>
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
							Gender : 
							<select name="hgender" style="width:80px;">
								<option value=""></option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
							
							<label>
								<span>Occupation :</span> </label>
								<input id="household" type="text" name="hoccupation" style="width:233px;" /> 
								
								&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								Age :
								<input id="household" type="text" name="hage" style="width:70px;" placeholder="Years Old" /> 

								&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								Civil Status : 
								<select name="hcivil" style="width:78px;">
									<option value=""></option>
									<option value="Single">Single</option>
									<option value="Married">Married</option>
								</select>
								
							</div>
            -->

							<br><br><br><br>
							<h1 style="border-top: 1px solid #DADADA; padding-top: 15px;" >Member Co-Maker Information
								<span>tanggalin nalang natin ito, since ilalagay ito sa taas.</span>
							</h1>

							<label>
								<span>Member Co-Maker:</span> 
								<!--<input id="" type="text" name="mcomakerid" style="width:562px;" />-->
								<select required="true" name='mcomakerid' style="width: 562px;" >
									<option></option>
									<?php foreach ($membercomaker->result() as $memid) { ?>
									<option value="<?php echo $memid->MemberID ?>"> <?php echo $memid->Name ?></option>
									<?php } ?>
									
								</select>	 
							</label>

							<label>
								<span>Relationship :</span> 
								<input type='hidden' name='mrelationship'>
								<select name="mrelationship" style="width:405px;">
									<option value="Friend">Friend</option>
									<option value="Cousin">Cousin</option>
									<option value="Grandparent">Grandparent</option>
									<option value="In-Law">In-Law</option>
									<option value="Others">Others</option>
									<option value="Sibling">Sibling</option>
									<option value="Spouse">Spouse</option>
									<option value="Parent">Parent</option>
									<option value="Aunt">Aunt</option>
									<option value="Uncle">Uncle</option>
								</select>
								
							</select>
						</label>

				 <!--	<label>
				    	<span>Valid ID: </span></label><br>
				    	<input type="file" name="file" id="file" multiple/>
				    <br><br>

				   <label>
				    	<span>Barangay Clearance :</span>
				    	<input type="file" name="file" id="file" multiple/>
				    </label>-->
				    
				    <br><br>































				    <h1 style="border-top: 1px solid #DADADA; padding-top: 15px;" >Credit Investigation
				    	<span>Please place monetary values of the following.</span>
				    </h1>

				    <!--<input id="" type="text" name="" style="width:200px;" />-->
				    <table class="creditinvestigation" border="1">
				    	<tr class="hdrrr">
				    		<td class="CIheader">SOURCE OF INCOME</td>
				    		<td class="CIheader2">MONTHLY INCOME</td>
				    	</tr>

				    	<?php $a=0;
				    	foreach ($sourceIncome->result() as $row) { ?>
				    	<tr class="hoverthis">
				    		<td class="CIdetail00"><?php echo $row->IncomeType ?><input name='incomedrop<?php echo number_format($a, 2) ?>' value='<?php echo $row->IncomeType ?>' type='hidden'/></td>
				    		<td class="CIdetail002"><input class="incomeCIinput" type="text" name="income<?php echo number_format($a, 2)?>"  placeholder="0"/></td>
				    	</tr>
				    	<?php $a++; } ?>
				    	
				    	<tr class="hoverthis">
				    		<td class="CItotal">Sub-total</td>
				    		<td class="CItotal2"><input id="isubtotal" type="text" name="bsubtotal" disabled/></td>
				    	</tr>

				    </table>

				    <br><br>
				    
				    <table class="creditinvestigation" border="1">
				    	<tr class="hdrrr">
				    		<td class="CIheader">FAMILY EXPENSE</td>
				    		<td class="CIheader2">MONTHLY EXPENSE</td>
				    	</tr>

				    	<?php $a=0;
				    	foreach ($familyExpense->result() as $row) { ?>
				    	<tr class="hoverthis">
				    		<td class="CIdetail00"><?php echo $row->ExpenseType ?><input name="fexpensedrop<?php echo number_format($a, 2) ?>" value="<?php echo $row->ExpenseType ?>" type="hidden"/></td>
				    		<td class="CIdetail002"><input class="familyCIinput" type="text" name="fexpense<?php echo number_format($a, 2) ?>" placeholder="0"/></td>
				    	</tr>
				    	<?php $a++; } ?>
				    	
				    	<tr class="hoverthis">
				    		<td class="CItotal">Sub-total</td>
				    		<td class="CItotal2"><input id="fsubtotal" type="text" name="fsubtotal" disabled/></td>
				    	</tr>

				    </table>

				    <br><br>
				    
				    <table class="creditinvestigation" border="1">
				    	<tr class="hdrrr">
				    		<td class="CIheader">BUSINESS EXPENSE</td>
				    		<td class="CIheader2">MONTHLY EXPENSE</td>
				    	</tr>

				    	<?php $a=0;
				    	foreach ($businessExpense->result() as $row) { ?>
				    	<tr class="hoverthis">
				    		<td class="CIdetail00"><?php echo $row->ExpenseType ?><input name="bexpensedrop<?php echo number_format($a, 2) ?>" value="<?php echo $row->ExpenseType ?>" type="hidden"></td>
				    		<td class="CIdetail002"><input class="businessCIinput" type="text" name="bexpense<?php echo number_format($a, 2) ?>"  placeholder="0"/></td>
				    	</tr>
				    	
				    	<?php $a++; } ?>
				    	
				    	<tr class="hoverthis">
				    		<td class="CItotal">Sub-total</td>
				    		<td class="CItotal2"><input id="bsubtotal" type="text" name="bsubtotal" disabled/></td>
				    	</tr>

				    </table>

				    <br>

				    <table class="creditinvestigation" border="1">
				    	<tr class="hoverthis">
				    		<td class="CItotal">Total Income</td>
				    		<td class="CItotal2"><input id="incometotal" type="text" name="itotal" disabled/></td>
				    	</tr>

				    	<tr class="hoverthis">
				    		<td class="CItotal">Total Expense</td>
				    		<td class="CItotal2"><input id="expensetotal" type="text" name="etotal" disabled/></td>
				    	</tr>
				    	<tr class="hoverthis">
				    		<td class="CItotal">Net Worth</td>
				    		<td class="CItotal2"><input id="difference" type="text" name="difference" disabled/></td>
				    	</tr>

				    </table>
				    

				    <br><br>

				    <label>
				    	<span></span>
				    	<input type="submit" style="margin-left: 450px;" class="button" value="Send" />
				    </label>  
				</form>

				<br><br>
			</div>





