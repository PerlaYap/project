<?php 
	$userrank = $this->session->userdata('rank');
	$branch = $this->session->userdata('branchno');
	$branchname = $this->session->userdata('branch');
 ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/list.css'); ?>">
<script src="<?php echo base_url('Assets/js/list.js'); ?>"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/blitzer/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
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

$(function() {
$( "#datepicker" ).datepicker({
	maxDate: "+0d",
});
$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
});

$(function() {
$( "#datepicker1" ).datepicker({
	maxDate: "+0d",
});
$( "#datepicker1" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
});
</script>


<body onload="hide()">

	<div class="content2">

		<h2 class="hTitle">REPORTS</h2>


		
			<form action="getSpecifiedReport" method="post" name="getSpecifiedReport" class="basic-grey">

				<label>
					<span>Report Type :</span>


					<select style="width: 562px;" name="reporttype" onchange="show(this.value)">
						<option value=" " selected></option>
						<option value="daily">Daily Members Collection</option>
						<?php if($userrank=='branchmanager'){ ?>
						<option value="dailyManager">Daily Salve Officer Collection</option>
						<option value="yearly">Yearly Trend Report</option>
						<option value="yearlyCompare">Yearly Trend Comparison</option>
						<?php } else if($userrank=="salveofficer"){ ?>
						<option value="dailySO">Daily Center Collection</option>
						
						<!--<option value="weekly">Weekly</option>
						<option value="monthly">Monthly</option>-->
						
						<?php } ?>	


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
					        <input type="text" id="datepicker" name="dcday1" placeholder="YYYY-MM-DD">
					        	<label>
						<span></span>
					     <input type="submit" class="button" value="Send" />
					

					
				</div>

				<div id="dailySM">
					<label>
						<span>Branch: </span>
						<select id="branchList" name="dcbranchControl1" style="width: 135px;" onchange="getCenterList()">
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
						<span>Date: </span></label>
					        <input type="text" id="datepicker1" name="dcday" placeholder="YYYY-MM-DD">
					        	<label>
						<span></span>
					     <input type="submit" class="button" value="Send" />
					

					
				</div>

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