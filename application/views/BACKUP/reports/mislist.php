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

<style>
.ui-datepicker-calendar {
	display: none;
}
</style>
<script type="text/javascript">
$(function() {
	$('.datepicker').datepicker( {
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'MM yy',
		maxDate: "+0d",
		onClose: function(dateText, inst) { 
			var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

			$(this).datepicker('setDate', new Date(year, month, 1));
		}
	});
});

</script>


<body onload="hide()">

	<div class="content2">

		<h2 class="hTitle">REPORTS</h2>



		<form action="getSpecifiedReportMIS" method="post" name="getSpecifiedReport" class="basic-grey">

			<label>
				<span>Report Type :</span>
				<select style="width: 562px;" name="reporttype" onchange="show(this.value)">
					<option value=" " selected></option>
					<option value="collection">Collection Performance of Branches</option>
					<option value="account">Monthly Account Report</option>
					<option value="loanport">Monthly Loan Portfolio Report</option>
					<option value="saving">Monthly Savings Build-Up and Capital Shares Report</option>
				</select>
			</label>

			<label style="margin-top: 0px;">
				<span>Month and Year: </span>
				<input type="text" class="datepicker" name="monthyear">
				<label>
					<br><br>
					<label>
						<span></span>
						<input type="submit" class="button" value="Send" />
					</label>
				</label>		

			</body>