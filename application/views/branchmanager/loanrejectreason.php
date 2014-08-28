<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/salveofficer.css'); ?>">
<script src="<?php echo base_url('Assets/js/salveofficer.js'); ?>"></script>

<?php
 ?>
			<div class="content">
				<br>
				<div class="basic-grey">
					<h1>Reason
				        <span>This is to inform the Salve Officer the reason for loan rejection</span>
				    </h1>

				    <form action='rejectloan' method='POST'>
				    <label>
				        <span>Reason: </span>
				        <textarea id="message" name="message" placeholder="Type Something..." style="width: 562px;resize:none;"></textarea>
				        
				    </label>
				   
				    
				    <label>
				        <span></span>
					        
						        <input type='hidden' name='loanID' value="<?php echo $loanControl; ?>">
								<input type="submit" class="button" value="OK" />
					        </form>
				    </label>

				</div>

		<br><br><br>
		</div>
