<?php 
	$userrank = $this->session->userdata('rank');
	$branch = $this->session->userdata('branchno');
	$branchname = $this->session->userdata('branch');
 ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/list.css'); ?>">
<script src="<?php echo base_url('Assets/js/list.js'); ?>"></script>
	<!--<link rel="stylesheet" type="text/css" href="../../../Assets/css/list.css">
	<script src="../../../Assets/js/list.js"></script>-->


 <?php $centerList=$this->db->query("SELECT cb.ControlNo AS BranchControl, cc.ControlNo AS CenterControl, cc.CenterNo FROM caritasbranch_has_caritascenters cbhcc 
LEFT JOIN caritasbranch cb ON cbhcc.CaritasBranch_ControlNo=cb.ControlNo
LEFT JOIN caritascenters cc ON cbhcc.CaritasCenters_ControlNo=cc.ControlNo"); 
?>

<?php $branchList=$this->db->query(" SELECT cb.ControlNo AS BranchControl, BranchName FROM caritasbranch_has_caritascenters cbhcc 
LEFT JOIN caritasbranch cb ON cbhcc.CaritasBranch_ControlNo=cb.ControlNo
GROUP BY BranchControl"); ?>

<script type="text/javascript">
function getCenterList(){
	var branchControl=parseInt(document.getElementById('branchList').value);
	
	removeOptions(document.getElementById("centers"));
	<?php foreach($centerList->result() as $row){
	echo 'if(branchControl=='.$row->BranchControl.'){';
		echo 'var select = document.getElementById("centers");';
		echo 'select.options[select.options.length] = new Option('.$row->CenterNo.', '.$row->CenterControl.');';
	echo '}';
} ?>

function removeOptions(selectbox)
{
    var i;
    for(i=selectbox.options.length-1;i>=0;i--)
    {
        selectbox.remove(i);
    }
}
}
</script>


<body onload="hide()">

	<div class="content2">

		<h2 class="hTitle">REPORTS</h2>


		
			<form action="getSpecifiedReport" method="post" name="getSpecifiedReport" class="basic-grey">

				<label>
					<span>Report Type :</span>


					<select style="width: 562px;" name="reporttype" onchange="show(this.value)">
						<option value=" " selected></option>
						<option value="daily">Daily</option>
						<!--<option value="weekly">Weekly</option>
						<option value="monthly">Monthly</option>-->
						<option value="yearly">Yearly Trend Report</option>
						<option value="yearlyCompare">Yearly Trend Comparison</option>



					</select>
				</label>

				<div id="daily">
					<label>
						<span>Branch: </span>
						<select id="branchList" name="dcbranchControl" style="width: 135px;" onchange="getCenterList()">
							<option value=" " selected></option>
								<?php if($userrank=='mispersonnel') {?>
								<?php
								foreach ($branchList->result() as $row) { 
									echo "<option value='".$row->BranchControl."'>".$row->BranchName."</option>" ;
								} ?>
								<?php }else{ 
									echo "<option value='".$branch."'>".$branchname."</option>" ;
								 } ?>
						</select>
					</label>

					<label> 
						<span>Center: </span>
						<select id="centers" name="dccenterControl" style="width: 135px;"></select>
					</label>

					<label>
						<span>Date: </span></label>
					        <select name="dcmonth" style="width:80px;"></label>
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

					        <select name="dcday" style="width:50px;">
						        <option value="" selected="selected"></option>
						        <?php  for ($i=1; $i < 32 ; $i++) { ?>
							        <?php if ($i<10) { ?>
							        <option value="<?php echo '0'.$i ?>"><?php echo '0'.$i ?></option>		
							       	<?php } else{ ?>
							       	<option value="<?php echo $i ?>"><?php echo $i ?></option>
							      	<?php } ?>
						      <?php  } ?>
					        </select>

					        <select name="dcyear" style="width:80px;">
						        <option value="" selected="selected"></option>
						        <?php  for ($y=2011; $y <= 2014 ; $y++) { ?>
							       <option value="<?php echo $y ?>"><?php echo $y ?></option>
						        <?php  } ?>
					        </select>
					        	<label>
						<span></span>
					     <input type="submit" class="button" value="Send" />
					

					
				</div>

			<!--	<div id="weekly">
					<label>
						<span>Start Date: </span></label>
						<input type="text" style="width: 135px;" placeholder="MM/DD/YYYY"/>
						
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						End Date: 
						<input type="text" style="width: 135px;" placeholder="MM/DD/YYYY"/>

					<label>
						<span></span>
					     <input type="submit" class="button" value="Send" />
					</label>
				</div>

				<div id="monthly">
					
				<form action="mismonthly" method="post" class="basic-grey">
					<label>
						<span>Month:  </span></label>
						 <select name="month" style="width:130px;"/>
						        <option value="" selected="selected"></option>
						        <option value="January">January</option>
						        <option value="February">February</option>
						        <option value="March">March</option>
						        <option value="April">April</option>
						        <option value="May">May</option>
						        <option value="June">June</option>
						        <option value="July">July</option>
						        <option value="August">August</option>
						        <option value="September">September</option>
						        <option value="October">October</option>
						        <option value="November">November</option>
						        <option value="December">December</option>
					        </select>
						
						&nbsp&nbsp&nbsp&nbsp&nbsp

						<span>Year:  </span>
					  
					  		<select name="year" style="width:80px;">
						        <option value="" selected="selected" ></option>
						        <?php  for ($y=2011; $y <= 2014 ; $y++) { ?>
							       <option value="<?php echo $y ?>"><?php echo $y ?></option>
						        <?php  } ?>
					        </select>
					        
					    </label>
				

					<label>
						<span></span>
					     <input type="submit" class="button" value="Send" />
					</label>
			</form>
			</div>-->

			<div id="yearly">
					<label style="margin-top: 0px;">
						<span>Year:  </span></label>
						<select name="yearlyyear" style="width: 80px;">
							<option selected> </option>
							<option value="2010">2010</option>
							<option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
						</select> 
					<br><br>
					<label>
						<span></span>
					     <input type="submit" class="button" value="Send" />
					</label>
			</div>


			<div id="yearlyCompare">
				<form class="basic-grey">
					<label style=margin-top: 0px;>
						<span>Year:  </span></label>
						<select name="yearlyyear1" style="width: 80px;">
							<option selected> </option>
							<option value="2010">2010</option>
							<option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
						</select> 

						&nbsp&nbsp&nbsp
						and
						&nbsp&nbsp&nbsp

						<select name="yearlyyear2" style="width: 80px;">
							<option selected> </option>
							<option value="2010">2010</option>
							<option value="2011">2011</option>
							<option value="2012">2012</option>
							<option value="2013">2013</option>
							<option value="2014">2014</option>
						</select>
					</label>
					<br><br>
					<label>
						<span></span>
					     <input type="submit" class="button" value="Send" />
					</label>
			</div>

			</form>
		

		
	<br><br><br>
	</div>

</body>