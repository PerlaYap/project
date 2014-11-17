<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>


		<script type="text/javascript">

			function send(control_no){
				
				window.location.href= "profiles?name="+ control_no;
			} 

			</script>





		<div class="content2">
			<label>
				<h1 class="membersbybranch">
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
					SEARCH: 
				</h1></label>
				<form action="search" method="post" name="search">

					<select name="keyword" class="search" onchange="changeSearch(this.value)" style="width: 150px;"  >
						
						<option value="center" selected>Center</option> 
				<!--	<option value="amount">Loan Amount</option> -->
						<option value="range">Loan Range</option>  
						<option value="location">Location</option> 
						<option value="name">Name</option>
						<option value="year">Year Entered</option> 

					</select>


		
				<div id="normalsearch">
						<input type="text" name="searchvalue" class="searchmember" /> 
						<input type="submit" class="membersbybranch3" value="Submit" />
					</div>

					
					<div id="searchrange" style="display:none;">
						<input type="text" name="searchvalue2" placeholder="eg. 5000" class="searchmember10" />

							<h1 class="membersbybranch10">TO</h1>

					<input type="text" name="searchvalue3" placeholder="10000" class="searchmember3"/>	
						<input type="submit" class="membersbybranch2" value="Submit" />
					</div>

						
				</form>
		
		<div class="center">

				<?php 
				
 	$option = $this->security->xss_clean($this->input->post('keyword')); 

				if ($searchval) {

					if ($option == 'name'){?>
				
				
				<table class="center">
					<tr class="header">
						<th class="tablecount"> </th>
					
						<th class="tablename">NAME</th>
						<th class="tablebranch">BRANCH</th>
						<th class="tablecenter">CENTER</th>

					</tr>
					<?php $number=0; ?>
					<?php foreach ($searchval as $search) {?>
					<?php $number+=1; ?>
 					<tr class="account">
 						<td><?php echo $number; ?></td>
 						<td><a href="javascript:void(0)" onclick="send('<?php echo $search->ControlNo ?>')"><?php echo $search->LastName.", ".$search->FirstName." ".$search->MiddleName; ?></a></td>
 						<td><?php echo $search->BranchName; ?></td>
 						<td><?php echo $search->CenterNo; ?></td>

 					</tr>

 					<?php } ?>

 	
					
				</table> 


					
					<?php } else if ($option == 'location'){?>
				
				
				<table class="center">
					<tr class="header">
						<th class="tablecount"> </th>
					
						<th class="tablename2">NAME</th>
						<th class="tablelocation">LOCATION</th>
						<th class="tablebranch2">BRANCH</th>

					</tr>
					<?php $number=0; ?>
					<?php foreach ($searchval as $search) {?>
					<?php $number+=1; ?>
 					<tr class="account">
 						<td><?php echo $number; ?></td>
 						<td><a href="javascript:void(0)" onclick="send('<?php echo $search->ControlNo ?>')"><?php echo $search->LastName.", ".$search->FirstName." ".$search->MiddleName; ?></a></td>
 						<td><?php echo $search->Address; ?></td>
 						<td><?php echo $search->BranchName; ?></td>

 					</tr>

 					<?php } ?>

 	
					
				</table> 

					<?php } else if ($option == 'center'){?>
				
				
				<table class="center">
					<tr class="header">
						<th class="tablecount"> </th>
					
						<th class="tablename">NAME</th>
						<th class="tablebranch">BRANCH</th>
						<th class="tablecenter">CENTER</th>

				</tr>
					<?php $number=0; ?>
					<?php foreach ($searchval as $search) {?>
					<?php $number+=1; ?>
 					<tr class="account">
 						<td><?php echo $number; ?></td>
 						<td><a href="javascript:void(0)" onclick="send('<?php echo $search->ControlNo ?>')"><?php echo $search->LastName.", ".$search->FirstName." ".$search->MiddleName; ?></a></td>
 						<td><?php echo $search->BranchName; ?></td>
 						<td><?php echo $search->CenterNo; ?></td>

 					</tr>

 					<?php } ?>

 	
					
				</table> 

				<?php } else if ($option == 'year'){?>
				
				
				<table class="center">
					<tr class="header">
						<th class="tablecount"> </th>
					
						<th class="tablename">NAME</th>
						<th class="tablebranch">BRANCH</th>
						<th class="tableyear">DATE ENTERED</th>

				</tr>
					<?php $number=0; ?>
					<?php foreach ($searchval as $search) {?>
					<?php $number+=1; ?>
 					<tr class="account">
 						<td><?php echo $number; ?></td>
 						<td><a href="javascript:void(0)" onclick="send('<?php echo $search->ControlNo ?>')"><?php echo $search->LastName.", ".$search->FirstName." ".$search->MiddleName; ?></a></td>
 						<td><?php echo $search->BranchName; ?></td>
 						<td><?php echo $search->Date; ?></td>

 					</tr>

 					<?php } ?>

 	
					
				</table> 

					<?php } else if ($option == 'amount'){?>
			


				<h1 class="membersbybranch">
	
				<table class="center">
					<tr class="header">
						<th class="tablecount"> </th>
					
						<th class="tablename">NAME</th>
						<th class="tablebranch">BRANCH</th>
						<th class="tableyear">AMOUNT LOANED</th>


				</tr>
					<?php $number=0; ?>
					<?php foreach ($searchval as $search) {?>
					<?php $number+=1; ?>
 					<tr class="account">
 						<td><?php echo $number; ?></td>
 						<td><a href="javascript:void(0)" onclick="send('<?php echo $search->ControlNo ?>')"><?php echo $search->LastName.", ".$search->FirstName." ".$search->MiddleName; ?></a></td>
 						<td><?php echo $search->BranchName; ?></td>
 						<td>P<?php echo $search->AmountRequested; ?></td>

 					</tr>

 					<?php } ?>

 					</table>

 				<?php	 } else if ($option == 'range'){?>
				
				
				<table class="center">
					<tr class="header">
						<th class="tablecount"> </th>
					
						<th class="tablename">NAME</th>
						<th class="tablebranch">BRANCH</th>
						<th class="tableyear">AMOUNT LOANED</th>


				</tr>
					<?php $number=0; ?>
					<?php foreach ($searchval as $search) {?>
					<?php $number+=1; ?>
 					<tr class="account">
 						<td><?php echo $number; ?></td>
 						<td><a href="javascript:void(0)" onclick="send('<?php echo $search->ControlNo ?>')"><?php echo $search->LastName.", ".$search->FirstName." ".$search->MiddleName; ?></a></td>
 						<td><?php echo $search->BranchName; ?></td>
 						<td>P<?php echo $search->AmountRequested; ?></td>

 					</tr>

 					<?php } ?>

 					</table>




			<?php	}


		} else { ?>

						<p class="noresultfound"> - No Result(s) Found - <br><br> </p>

					<?php } ?>
				
					</table>


			</div>




		</div>
