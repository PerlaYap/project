<title>Revenues & Financial Costs</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	
<!-- 	<link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css"> -->

	
<!-- 	<img src="../../../Assets/images/caritaslogo.png" class="caritaslogo"> -->
<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		Revenues & Financial Costs <br> 
		For the Month of July 		
	</h3>

	<br>

		<!--<p style="font-size:13px;">
			Name of Branch: <b> ---- </b> 

			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

			Day:<b>---</b> 

			&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

			Date: <b>---</b>
		</p>-->
		<br>
	<table class="dailycollectionsheet" border="1" style="margin-left: auto; margin-right: auto;">
		
		<tr class="header">
			<td class="label00"colspan="3">REVENUES</td>
		</tr>
		<tr class="header">
			<td class="num1">I.</td>
			<td class="labelx"colspan="2">Interest Income for Loans </td>
		</tr>

			<tr>
				<td></td>
				<td class="sublabel"> A. Loan A - 23 Weeks</td>
				<td class="labelinput"></td>
			</tr>
			<tr>
				<td></td>
				<td class="sublabel"> B. Loan A - PDM</td>
				<td class="labelinput"></td>
			</tr>
			<tr>
				<td></td>
				<td class="sublabel"> C. Loan B - 40 Weeks</td>
				<td class="labelinput"></td>
			</tr>
			<tr>
				<td></td>
				<td class="sublabel"> D. Loan B - PDM</td>
				<td class="labelinput"></td>
			</tr>

		<tr class="header">
			<td class="num1">II.</td>
			<td class="labelx">Service Charge (2%) </td>
			<td class="labelinput"></td>
		</tr>

		<tr class="header">
			<td class="num1">III.</td>
			<td class="labelx">Membership Fee </td>
			<td class="labelinput"></td>
		</tr>

		<tr class="header">
			<td class="num1">IV.</td>
			<td class="labelx">SBU Unclaimed</td>
			<td class="labelinput"></td>
		</tr>
		<tr class="header">
			
			<td class="labeltotal" colspan="2">TOTAL REVENUE</td>
			<td class="labelinput"></td>
		</tr>

	</table>
	

	<br>

	<table class="dailycollectionsheet" border="1" style="margin-left: auto; margin-right: auto;">
		
		<tr class="header">
			<td class="label00"colspan="3">FINANCIAL COSTS</td>
		</tr>
		<tr class="header">
			<td class="num1">I.</td>
			<td class="label900" >Interest on Savings </td>
			<td class="labelinput"></td>

		</tr>

		<tr class="header">
			<td class="num1">II.</td>
			<td class="label900">Interest on Borrowings </td>
			<td class="labelinput"></td>
		</tr>

		<tr class="header">
				
			<td class="labeltotal" colspan="2">TOTAL FINANCIAL COST</td>
			<td class="labelinput"></td>
		</tr>

	</table>
	<br>
		<!-- <table class="signature" style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Prepared by:</td>
				<td class="sig">&nbsp</td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2">&nbsp</td>
			</tr>
		</table>
		<br>
		<table class="signature"  style="margin-left:auto; margin-right:auto;">
			<tr>
				<td class="sigBy">Received by:</td>
				<td class="sig">&nbsp</td>
				<td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
				<td class="sig2">&nbsp</td>
			</tr>
		</table> -->

		<table style="margin-left: 140px;" >
	      <tr>
	        <td class="BM1" style="font-size: 13px;"><?php echo $name; ?></td>
	      </tr>
	        <?php if($userrank=='branchmanager'){?>
	      <tr>
	        <td class="BM2">Signature Above Printed Name of <br> Branch Manager</td>
	      </tr>
	      <?php }else{ ?>
	      <tr>
	        <td class="BM2">Signature Above Printed Name of <br> MIS</td>
	      </tr>
	      <?php } ?>
	      <tr>
	        <td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
	      </tr>
	      <tr>
	        
	        <td class="BM2">Date</td>
	      </tr>
	    </table>

	    <table style="margin-left: 600px; margin-top: -207px;" >
	      <tr>
	        <td class="BM1" style="font-size: 13px;">Ann Evan Echavez</td>
	      </tr>
	      <tr>
	        <td class="BM2">Signature Above Printed Name of <br> General Manager</td>
	      </tr>
	      <tr>
	        <td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
	      </tr>
	      <tr>
	        <td class="BM2">Date</td>
	      </tr>
	    </table>

	<br><br>
	<div style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button>
	</div>