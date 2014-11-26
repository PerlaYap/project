<style type="text/css" media="print">
  .dontprint{
    display: none;
  }

  @page { 
    size: portrait;
    margin: 1 in;
  }
</style>	



<title>Past Due Matured Accounts</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>"> 



	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		Past Due Members of Center No. <?php echo $ctrno; ?> <br>
		<?php echo $branch ?> Branch <br>
		<?php echo $datetoday ?>
	</h3>
	<br>


	<table border="1" style="border-collapse: collapse; margin-left: auto; margin-right: auto;">
		<tr>
			<td class="pastdue" width="10px"><b>#</b></td>
			<td class="pastdue" width="200px" style="text-align: left;"><b>NAME</b></td>
			<td class="pastdue" width="120px"><b>PAST DUE AMOUNT</b></td>
			<td class="pastdue" width="120px"><b>NO. OF PAST DUE</b></td>
			<td class="pastdue" width="120px"><b>TOTAL PAST DUE</b></td>
			<td class="pastdue" width="150px;"><b>CONTACT NO.</b></td>
			<td class="pastdue" width="300px;"><b>ADDRESS</b></td>
		</tr>
		<tr>
			<td class="pastdue">1</td>
			<td class="pastdue" style="text-align: left;">Lyka Ellace C. Dado</td>
			<td class="pastdue">150.00</td>
			<td class="pastdue">5</td>
			<td class="pastdue">750.00</td>
			<td class="pastdue">09060001122</td>
			<td class="pastdue" style="text-align: left;">19 Sanggunian Village Caranglaan District</td>
		</tr>
		
	</table>

	<br><br>
	<br><br>
	<br><br>
	<table style="margin-left: 270px;" >

			<tr>
				<td class="BM1" style="font-size: 13px;">NAME</td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of POSITION</td>
			</tr>
			
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				
				<td class="BM2">Date</td>
			</tr>
		</table>

	<table style="margin-left: 720px; margin-top: -207px;" >
			
			<tr>
				<td class="BM1" style="font-size: 13px;">NAME</td>
			</tr>
			<tr>
				<td class="BM2">Signature Above Printed Name of POSITION</td>
			</tr>
			
			<tr>
				<td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
			</tr>
			<tr>
				<td class="BM2">Date</td>
			</tr>
		</table>


		<br><br><br>
			<div class='dontprint' style="width: 100%; text-align: center;">
				<button onclick="window.print()">Print</button>
			</div>

		<br><br><br>

	