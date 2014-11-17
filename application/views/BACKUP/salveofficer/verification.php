


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
      changeYear: true,
      maxDate: "-18y",
      minDate: "-70y",
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

				<input type="text" id="datepicker" name="birthday" readonly='true' placeholder="YYYY-MM-DD" >
					        

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
			&#169; 2014 Microfinance Cooperative Information Management System <br>

			<a href="<?php echo site_url('general/gotoaboutus'); ?>">ABOUT US</a> | <a href="<?php echo site_url('general/gotocontactus'); ?>">CONTACT US</a> | <a href="<?php echo site_url('general/gotofaq'); ?>">FAQs</a> | <a href="#">HELP</a>

		</p>

		<br><br><br>
	</div>