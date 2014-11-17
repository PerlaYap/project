<title>Portfolio-At-Risk</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	
<!-- 	<link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css"> -->

	<!-- <img src="../../../Assets/images/caritaslogo.png" class="caritaslogo"> -->
	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	<h3>CARITAS SALVE CREDIT COOPERATIVE <br> Portfolio-At-Risk</h3>

		<p style="font-size:13.5px; text-align:center; margin-top: -1px;">
			Branch: <b>______</b> <br>
			Month of <b>______</b>
		</p>

	<br>
	<table class="portfolioatrisk" border="1">

		<tr class="header">
			<td rowspan="3">CTR</td>
			<td rowspan="2" colspan="2">Total Loan Balance<br>of Past Due</td>
			<td rowspan="2">Past Due</td>
			<td colspan="10">Portfolio At Risk (No. of Days Aging) </td>
			<td rowspan="2" colspan="2">Total</td>
		</tr>

			<tr>
				<td colspan="2"> 1-30 </td>
				<td colspan="2"> 31-60</td>
				<td colspan="2"> 61-90 </td>
				<td colspan="2"> 91-180 </td>
				<td colspan="2"> 181-365 </td>
			</tr>

			<tr>
				<td class="pax">Pax</td>
				<td class="amt">Amount</td>
				<td class="amt">Amount</td>
				<td class="pax">Pax</td>
				<td class="amt">Amount</td>
				<td class="pax">Pax</td>
				<td class="amt">Amount</td>
				<td class="pax">Pax</td>
				<td class="amt">Amount</td>
				<td class="pax">Pax</td>
				<td class="amt">Amount</td>
				<td class="pax">Pax</td>
				<td class="amt">Amount</td>
				<td class="pax">Pax</td>
				<td class="amt">Amount</td>
			</tr>

			<tr>
				<td class="ltr">A</td>
				<td class="ltr">B</td>
				<td class="ltr">C</td>
				<td class="ltr">D</td>
				<td class="ltr">E</td>
				<td class="ltr">F</td>
				<td class="ltr">G</td>
				<td class="ltr">H</td>
				<td class="ltr">I</td>
				<td class="ltr">J</td>
				<td class="ltr">K</td>
				<td class="ltr">L</td>
				<td class="ltr">M</td>
				<td class="ltr">N</td>
				<td class="ltr">O</td>
				<td class="ltr">P</td>
			</tr>

		<tr class="date">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

	</table>

	<p style="font-size: 11.3px; margin-left: 6%;"><i>
		*One day missed payments, Total Loan Balance is considered At Risk! <br>
		*Breakdown the amount of Past Due according to the no. of days uncollected (D=F+H+J+L+N ; B=E+G+I+K+M) <br>
		*Total amount (D=F+N+J+L+M); Total pax (O=E+G+I+K+M)
	</i></p>

	<br>
		<table class="signature" style="margin-left:auto; margin-right:auto;">
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
		</table>

	<br><br>

	<div style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button>
	</div>