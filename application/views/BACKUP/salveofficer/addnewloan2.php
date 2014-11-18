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
WHERE BranchControl='$branchno'"); ?>

<?php $memberinfo=$this->db->query("SELECT cb.ControlNo AS BranchControl, cb.BranchName,cc.ControlNo AS CenterControl, cc.CenterNo, B.FirstName, B.MiddleName, B.LastName, B.ControlNo, B.MemberID FROM caritasbranch_has_caritascenters cbhcc 
LEFT JOIN caritasbranch cb ON cbhcc.CaritasBranch_ControlNo=cb.ControlNo
LEFT JOIN caritascenters cc ON cbhcc.CaritasCenters_ControlNo=cc.ControlNo
RIGHT JOIN (SELECT chm.CaritasCenters_ControlNo AS CenterControl ,A.ControlNo, MemberID, FirstName, MiddleName, LastName FROM caritascenters_has_members chm 
RIGHT JOIN (SELECT mem.ControlNo, MemberID, FirstName, MiddleName, LastName FROM membersname memn RIGHT JOIN Members mem ON mem.ControlNo=memn.ControlNo WHERE mem.MemberID='$mid') A ON A.ControlNo=chm.Members_ControlNo) B ON cbhcc.CaritasCenters_ControlNo=B.CenterControl
"); 

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

		$(".quantity_1").on("keydown keyup",function(){
			materialSum();
		});

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

		$("input#maxLoan").val(maxLoan.toFixed(2));
	}

	function icalculateSum(){
	var sum=0;

	$(".incomeCIinput").each(function(){
		if(!isNaN(this.value) && this.value.length !=0){
			sum+=parseFloat(this.value);
		}
	});

	$("input#isubtotal").val(sum.toFixed(2));
	}

	function fcalculateSum(){
	var sum=0;

	$(".familyCIinput").each(function(){
		if(!isNaN(this.value) && this.value.length !=0){
			sum+=parseFloat(this.value);
		}
	});

	$("input#fsubtotal").val(sum.toFixed(2));
	}

	function bcalculateSum(){
	var sum=0;

	$(".businessCIinput").each(function(){
		if(!isNaN(this.value) && this.value.length !=0){
			sum+=parseFloat(this.value);
		}
	});

	$("input#bsubtotal").val(sum.toFixed(2));
	}

	function materialSum(){
	var sum=0;
	var unitprice=[];
	var quantity=[];

	$(".unitprice_1").each(function(){
		if(!isNaN(this.value) && this.value.length !=0){
			unitprice.push(this.value);
		}
	});

	$(".quantity_1").each(function(){
		if(!isNaN(this.value) && this.value.length !=0){
			quantity.push(this.value);
		}
	})

	if(unitprice.length==quantity.length){
		for(var a=0; a<unitprice.length; a++){
			sum+=(unitprice[a]*quantity[a]);
		}
	}

	$("input#materialtotal").val(sum.toFixed(2));
	}

	function total(){
		var income= 0;
		var expense= 0;
		var difference=0;

			income+=parseFloat($("input#isubtotal").val());
		
			expense+=parseFloat($("input#bsubtotal").val()) + parseFloat($("input#fsubtotal").val());

			difference+=parseFloat(income)-parseFloat(expense);

	$("input#incometotal").val(income.toFixed(2));
	$("input#expensetotal").val(expense.toFixed(2));
	$("input#difference").val(difference.toFixed(2));
	}

	(function($) {
        $.fn.currencyFormat = function() {
            this.each( function( i ) {
                $(this).change( function( e ){
                    if( isNaN( parseFloat( this.value ) ) ) return;
                    this.value = parseFloat(this.value).toFixed(2);
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
					<h1>New Loan Application
				        <span>Please fill all the texts in the fields.</span>
				    </h1>

				    z
				    
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

				  	<label>
				    		<span>
				    		</span>
				    		-------------------------------------------------  LOAN INFORMATION  -------------------------------------------------

				    </label>

				    <label>
				        <span>Amount of Shares :</span> 
				       	<select required="true" name="capitalshare" style="width:580px;">
						    <option value="100" selected="selected">100</option>
						    <option value="200">200</option>
						    <option value="300">300</option>
						    <option value="400">400</option>
						    <option value="500">500</option>
					    </select>
				    </label>  

				    <label>
				        <span>Amount Requested :</span></label>
					 	<input required="true" type="text" id="loanamount" name="amountreq" style="width: 210px;" placeholder="Pesos" />	

					 	&nbsp&nbsp&nbsp&nbsp
				        Max Loan Amount :
				        <input type="text" readOnly="true" id="maxLoan" name="" style="width: 210px; color:#962a2a" />
				
				    <label>
				        <span>Loan Type :</span></label>
				        <select required="true" name="loantype" style="width:220px;">
						    <option value="" selected="selected"></option>
						    <option value="23-Weeks">23-weeks</option>
						    <option value="40-Weeks">40-weeks</option>
					    </select>

					    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
					    Day of Payment :
					    <input type="text" readOnly="true" id="day" name="paymentday" style="width: 210px;" value="<?php echo $dayoftheweek ?>"/>
					<label>
				    		<span>
				    		</span>
				    		----------------------------------------------  BUSINESS INFORMATION  ----------------------------------------------

				    </label>

				    <label>
				        <span>Business :</span>
				        <select required="true" style="width:572px;" name="loanbusiness" id="selectMenu" onchange="showBusiness(this.value)">
						    <option value=" "></option>
						    <option value="newbusiness">New Business</option>
						     <?php
				    		foreach ($loanbusiness->result() as $row) { 
				    			echo "<option value='".$row->ControlNo."'>".$row->BusinessName."</option>" ;
				    		 } ?>
					    </select>
				    </label>
				   
				    <div id="newbusiness">
				    <label>
				    	<span>Name :</span> 
				        <input id="business" type="text" name="businessname" style="width:562px;" /> 
				    </label>

					<label>
				    	<span>Type :</span> </label>
				        <input id="business" type="text" name="type" style="width:220px;" /> 
				    
				    	&nbsp&nbsp
						Date Established :
				    	
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
				    	<span>Address :</span> 
				        <input id="baddress" type="text" name="businessaddress" style="width:562px;" /> 
				    </label>

				    <label>
				    	<span>Contact :</span> 
				        <input id="business" type="text" name="contact" style="width:562px;" placeholder="7 or 11 digit number" /> 
				    </label>
				</div>

				    <label>
				    		<span>
				    		</span>
				    		------------------------------------------------  MATERIAL INVENTORY  -----------------------------------------------

				    </label>

				    <label>
				        <span>Name :</span></label>
				        <input required="true" type="text" name="materials" class="material_1" style="width: 250px;"/>

				        &nbsp&nbsp&nbsp
				        Qty :
					    <input required="true" type="text" name="quantity" class="quantity_1" style="width: 26px;"/>

				        &nbsp&nbsp&nbsp
				        Unit Price :
						<input required="true"  type="text" name="unitprice" class="unitprice_1" style="width: 80px;" placeholder="Peso"/> &nbsp&nbsp 
						
						<input type="button" class="addmore2" value="+" onclick="addMaterial()"/>

				        <div id="inventory"></div>

				    </label>				    
			   &nbsp&nbsp&nbsp   &nbsp&nbsp&nbsp	   &nbsp&nbsp&nbsp		   &nbsp&nbsp&nbsp	   &nbsp&nbsp&nbsp	 &nbsp&nbsp&nbsp		   &nbsp&nbsp&nbsp	   &nbsp&nbsp&nbsp		

			   Subtotal: <input id="materialtotal" type="text" name="" style="width:100px;" disabled/>
				    <label>
				    		<span>
				    		</span>
				    		---------------------------------------------  CO-MAKER INFORMATION  ---------------------------------------------

				    </label>

				    <label>
				        <span>Co-Maker :</span>
				        <select required="true" id="comaker" name="comaker" style="width:572px;" onchange="showCoMaker(this.value)" >
						    <option value=" " selected=""></option>
						    <?php
				    		foreach ($householdlist->result() as $row) { 
				    			echo "<option value='".$row->HouseholdNo."'>".$row->Name."</option>" ;
				    		 } ?>
						    <option value="newhousehold">New Household</option>
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
						        <!--<input id="household" type="text" name="hrelation" style="width:400px;" /> -->
						        <select name="hrelation" style="width:405px;">
						        	<option value=" " selected=" "></option>
						        	<option value="Aunt">Aunt</option>
						        	<option value="Cousin">Cousin</option>
						        	<option value="Grandparent">Grandparent</option>
						        	<option value="In-Law">In-Law</option>
						        	<option value="Parent">Parent</option>
						        	<option value="Sibling">Sibling</option>
						        	<option value="Spouse">Spouse</option>
						        	<option value="Uncle">Uncle</option>

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

					  
					  <label>
				    		<span>
				    		</span>
				    		------------------------------------------- MEMBER CO-MAKER INFORMATION  -----------------------------------

				    </label>

					   		<label>
						    	<span>Co-Maker:</span> 
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
						        <select name="mrelationship" style="width:405px;">
						        	<option value=" " selected=" "></option>
						        	<option value="Aunt">Aunt</option>
						        	<option value="Child">Child</option>
						        	<option value="Cousin">Cousin</option>
						        	<option value="Grandparent">Grandparent</option>
						        	<option value="In-Law">In-Law</option>
						        	<option value="Spouse">Spouse</option>
						        	<option value="Parent">Parent</option>
						        	<option value="Uncle">Uncle</option>
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
				    <span></span>
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
						<td class="CIdetail00"><?php echo $row->IncomeType ?><input name='incomedrop<?php echo $a ?>' value='<?php echo $row->IncomeType ?>' type='hidden'/></td>
						<td class="CIdetail002"><input class="incomeCIinput" type="text" name="income<?php echo $a ?>"  placeholder="0"/></td>
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
						<td class="CIdetail00"><?php echo $row->ExpenseType ?><input name="fexpensedrop<?php echo $a ?>" value="<?php echo $row->ExpenseType ?>" type="hidden"/></td>
						<td class="CIdetail002"><input class="familyCIinput" type="text" name="fexpense<?php echo $a ?>" placeholder="0"/></td>
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
						<td class="CIdetail00"><?php echo $row->ExpenseType ?><input name="bexpensedrop<?php echo $a ?>" value="<?php echo $row->ExpenseType ?>" type="hidden"></td>
						<td class="CIdetail002"><input class="businessCIinput" type="text" name="bexpense<?php echo $a ?>"  placeholder="0"/></td>
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







	<div style="margin-top: 3350px;">

		<style type="text/css">
			p.footertext{
				color: #a7321a;
				line-height: 15px;
				font-size: 13px;
				text-align: center;
				margin-right: auto;
				margin-left: auto;
				bottom: 0;
				position: relative;
			}
		</style>

		<p class="footertext">
			&#169; 2014 Microfinance Cooperative Information Management System <br>

			<a href="<?php echo site_url('general/gotoaboutus'); ?>">ABOUT US</a> | <a href="<?php echo site_url('general/gotocontactus'); ?>">CONTACT US</a> | <a href="<?php echo site_url('general/gotofaq'); ?>">FAQs</a> | <a href="#">HELP</a>

		</p>

		<br><br>
	</div>