<?php 

$manager = $this->db->query("SELECT CONCAT(FirstName, ' ', MiddleName, ' ', LastName) AS Name, ControlNo FROM CaritasPersonnel p 
WHERE p.ControlNo  NOT IN (SELECT CaritasPersonnel_ControlNo FROM CaritasBranch_has_CaritasPersonnel) AND Rank = 'branchmanager'");

$salveofficer =$this->db->query("SELECT CONCAT(FirstName, ' ', MiddleName, ' ', LastName) AS Name, ControlNo FROM CaritasPersonnel p WHERE 
p.ControlNo  NOT IN (SELECT CaritasPersonnel_ControlNo FROM CaritasBranch_has_CaritasPersonnel) AND Rank = 'salveofficer'");
?>
		<div class="content">
			<br>
			<!-- form action="function " -->
				<form action="addbranch" method="post" name="addbranchprocess" enctype="multipart/form-data" class="basic-grey">
					<h1>New Branch
				        <span>Fill in all the necessary information</span>
				    </h1>

				    <label>
				        <span>ID Number :</span> </label>

				        <input type="text" name="branchid" style="width:562px;" >

				    </label>

					<label>
				        <span>Branch Name :</span> </label>

				        <input type="text" name="branchname" style="width:562px;" >

				    
				    
				    <label>
				        <span>Contact Number:</span> </label>

				        <input type="text" name="contactno" style="width:562px;" >

					<label>
				        <span>Address :</span> </label>

				        <input type="text" name="address" style="width:562px;" >

						
					<label>
						<span>Branch Manager: </span></label>
					        
					        
				        <select required name="manager" style="width:197px;">
				    			<option value=""></option>
				 
				    		<?php foreach ($manager->result() as $row) { ?>
				 <option value='<?php echo$row->ControlNo?>'><?php echo $row->Name?></option> ;
				    		 <?php } ?>
						</select>

   					<label>
						<span>Salve Officer: </span></label>
			
				 <br><br>
				    <label>	
				    
				    	<?php foreach ($salveofficer->result() as $off) { ?>
				    	
				    	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				    	
				 <input type='checkbox' name='officer[]' value='<?php echo $off->ControlNo; ?>'/><?php echo $off->Name;?>
				    	
				    	<br>
				    		
				    	 </label>
				    	
						<?php } ?>
				
					<br><br>
				     <label>
				        <span></span>
				        <input type="submit" class="button" value="Submit" />
				    </label>  
				</form>
			<br><br>
		</div>

