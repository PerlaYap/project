


<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/branchmanager.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js') ?>"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/blitzer/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">

<script>
 $(function() {
$( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
});
</script>

	
<div class="content3">
	<br>
	
		<form action="verifymember" method="POST" class="basic-grey">
			<h1>
				<br>Verification
				<span><br></span>
			</h1>
			<label>
				<span>Name:</span></label> 
				<input type='text' name="firstname" required placeholder="First Name" style="width: 200px;">
				<input type='text' name="middlename" required placeholder="Middle Name" style="width: 150px;">
				<input type='text' name="lastname" required placeholder="Last Name" style="width: 150px;">
				<br><br>
			
			<label>
				<span>Birthdate :</span> </label>
				<input type="text" id="datepicker" name="birthday">
					        <!--<select name="month" style="width:130px;" required>
						        <option value="" selected="selected"></option>
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

					        <select name="day" style="width:80px;" required>
						        <option value="" selected="selected"></option>
						        <?php  for ($i=1; $i < 32 ; $i++) { ?>

							        <?php if ($i<10) { ?>
							        		
							        <option value="<?php echo '0'.$i ?>"><?php echo '0'.$i ?></option>		

							       	<?php } else{ ?>

							       	<option value="<?php echo $i ?>"><?php echo $i ?></option>

							      	<?php } ?>
						      <?php  } ?>
						        
					
						        
					        </select>

					        <select name="year" style="width:100px;" required>
						        <option value="" selected="selected"></option>
						        <?php  $yend =date('Y')-17;
						        		$ystart = $yend-50;
						        for ($y=$ystart; $y < $yend ; $y++) { ?>

							       <option value="<?php echo $y ?>"><?php echo $y ?></option>

						        <?php  } ?>
					        </select>-->

					        <br><br><br>
					       <label><span></span>
								<input type="submit" value="Verify" style="margin-left: 425px;" class="button">
					       </label>
					       <br>
					        
</form>				

</div>

<div style="margin-top: 450px;">

		<style type="text/css">
			p.footertext{
				color: #a7321a;
				line-height: 15px;
				font-size: 13px;
				text-align: center;
				margin-right: auto;
				margin-left: auto;
				bottom: 0;
			}
		</style>

		<p class="footertext">
			&#169; 2014 Microfinance Information Management System <br>

			<a href="<?php echo site_url('general/gotoaboutus'); ?>">ABOUT US</a> | <a href="<?php echo site_url('general/gotocontactus'); ?>">CONTACT US</a> | <a href="<?php echo site_url('general/gotofaq'); ?>">FAQs</a> | <a href="#">HELP</a>

		</p>

		<br><br><br>
	</div>