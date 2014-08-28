<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>-->

<link rel="stylesheet" type="text/css" href="../../../Assets/css/salveofficer.css">
<script src="../../../Assets/js/salveofficer.js"></script>



<?php
 ?>
			<div class="content">
				<br>
				<div class="basic-grey">
					<h1>Reason
				        <span>This is to inform the Salve Officer the reason for rejection</span>
				    </h1>

				    <form action='rejectmember' method='POST'>
				    	<?php $memberno = $controlno; ?>
				    <label>
				        <span>Reason: </span>
				        <textarea id="message" name="message" placeholder="Type Something..." style="width: 562px;resize:none;"></textarea>
				        
				    </label>
				   
				    
				    <label>
				        <span></span>
					        
						        <input type='hidden' name='controlno' value="<?php echo $memberno; ?>">
								<input type="submit" class="button" value="OK" />
							<!-- 	<input type="submit" class="button1" value="Back" /> -->
					       
					        </form>
					       <!--  <form action='' method='' style="margin-top: -50px; margin-left: 220px;">
						        <input type='hidden' name='controlno' value="">
								
					        </form> -->
				    </label>

				</div>

		<br><br><br>
		</div>
