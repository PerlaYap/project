<title>MONTHLY PAST DUE MATURE REPORT</title>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
	
	<?php //$month = $_POST['month'];
			//$year = $_POST['year'];

			$month = 7;
			$year = 2014;

			$prev = $year-1;
			$prev2 = $year-2;

			if ($month == 1){
				$yue = 'January';
				$month=13;
				$year=-1;
			} else if ($month == 2){
				$yue = 'February';
			} else if ($month == 3){
				$yue = 'March';
			} else if ($month == 4){
				$yue = 'April';
			} else if ($month == 5){
				$yue = 'May';
			} else if ($month == 6){
				$yue = 'June';
			} else if ($month == 7){
				$yue = 'July';
			} else if ($month == 8){
				$yue = 'August';
			} else if ($month == 9){
				$yue = 'September';
			} else if ($month == 10){
				$yue = 'October';
			} else if ($month == 11){
				$yue = 'November';
			} else{
				$yue = 'December';
			}


$getbranch = $this->db->query("SELECT b.branchname, b.ControlNo FROM caritasbranch b
	Order by b.branchname"); ?>
	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	<!-- <img src="<?php // echo base_url ('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"> -->
	<h3>CARITAS SALVE CREDIT COOPERATIVE <br> MONTHLY PAST DUE MATURE REPORT <br> AS OF THE END OF THE MONTH OF <b>
		<?php echo $yue ?> <?php echo $year ?></b></h3>
<br>
	<table class="misreport" border="1">
		<tr>
			<td class="label"><b>PDM <?php echo $prev; ?>-Beg</b></td>
			<td class="number1"></td>
		
		</tr>
		<tr>
			<td class="label"><b>PDM <?php echo $prev2; ?>-Beg</b></td>
			<td class="number1"></td>
	
		</tr>
		<tr>
			<td class="label">Collection-<?php echo $prev; ?></td>
			<td class="number1"></td>

		</tr>
		<tr>
			<td class="label">Collection-<?php echo $prev2; ?></td>
			<td class="number1"></td>
		
		</tr>
		<tr>
			<td class="label"><b>PDM <?php echo $prev; ?>-End</b></td>
			<td class="number1"></td>
	
		</tr>
		<tr>
			<td class="label"><b>PDM <?php echo $prev2; ?>-End</b></td>
			<td class="number1"></td>
		
		</tr>
		<tr>
			<td class="label2">Total PDM</td>
			<td class="number2"></td>

		</tr>
		<tr>
			<td class="label"><b>RR-Current</b></td>
			<td class="number1"></td>

		</tr>
		<tr>
			<td class="label"><b>RR-Cumulative</b></td>
			<td class="number1"></td>

		</tr>
		<tr>
			<td class="label"><b>No. of Borrower At-Risk</b></td>
			<td class="number1"></td>
	
		</tr>
		<tr>
			<td class="label"><b>Past Due - Current</b></td>
			<td class="number1"></td>
	
		</tr>
		<tr>
			<td class="label"><b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp w/ PDM <?php echo $year; ?></b></td>
			<td class="number1"></td>
	
		</tr>
		<tr>
			<td class="label"><b>PD-Loan Balance</b></td>
			<td class="number1"></td>
	
		</tr>
		<tr>
			<td class="label"><b>PAR</b></td>
			<td class="number1"></td>

		</tr>
		<tr>
			<td class="label"><b>PAR w/ PDM</b></td>
			<td class="number1"></td>

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