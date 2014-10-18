<TITLE> Audit Trail</TITLE>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>



<body>
	<!-- <a href="<?php echo site_url('login/homepage'); ?>"> <img src="../../../Assets/images/caritaslogo.png" class="caritaslogo"></a> -->
	 <a href="<?php echo site_url('login/homepage'); ?>"> 
	 	<img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a> 

	
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		AUDIT TRAIL<br> 
	</h3>

	<br>

	<style type="text/css">
		p.filter{
			font-size: 14px;
			margin-left: 145px;
			
		}

		select.filtercategory, #filtername, #filterposition{
			background: #FFF url('down-arrow.png') no-repeat right;
		    background: #FFF url('down-arrow.png') no-repeat right);
		    appearance:none;
		    -webkit-appearance:none;
		    -moz-appearance: none;
		    text-indent: 0.01px;
		    text-overflow: '';
		    width: 100px;
		    height: 25px;
		}

		.date{
			position: absolute;
			margin-top: -40px;
			margin-left: 310px;
			border:0;			
		}

		.filterbtn{
			margin-top: -36px;
			margin-left: 210px;
		}

		.user{
			position: absolute;
			margin-top: -42px;
			margin-left: 310px;
			border:0;
		}

		#filterposition{
			width: 150px;
		}

		#filtername{
			width: auto;

		}

	</style>

	<p class="filter">FILTER: 
		<select class="filtercategory" onchange="changeCategory(this.value)">
			<option selected value="x">Category</option>
			<option value="date">Date</option>
			<option value="user">User</option>
		</select>

		<div id="date" class="date" style="display: none;">
			<input type="text" style="width: 200px; height: 25px;"/>
			<input type="button" value="Go" class="filterbtn" style="height: 28px;"/>
		</div>



		<div id="user" class="user" style="display: none;" onchange="enableName(this.value)">
			<select id="filterposition">
				<option selected value="x">Position</option>
				<option value="so">Salve Officer</option>
				<option value="bm">Branch Manager</option>
			</select>

			<select id="filtername" disabled>
				<option selected value="x">Name</option>
				<option value="a">Lyka Ellace Centino Dado</option>
			</select>
			<input type="button" value="Go"  style="height: 28px;"/>
			
		</div>

		

	</p> 

	<br>

    <table class="dailycollectionsheet" border="1" style="margin-left:auto; margin-right: auto;">
		<tr class="header">
			<td class="num"><b>#</b></td>
			<td style="width: 220px;"><b>NAME</b></td>
			<td style="width: 150px;"><b>POSITION</b></td>
			<td style="width: 180px;"><b>DATE</b></td>
			<td style="width: 100px;"><b>TIME</b></td>
			<td style="width: 320px;"><b>ACTIVITY</b></td>
		</tr>

		<tr>
			<td>1</td>
			<td>Lyka Dado</td>
			<td>Salve Officer</td>
			<td>01/20/2014</td>
			<td>12:22pm</td>
			<td style="text-align: left;">Log in</td>
			
			
			
		</tr>

		

	</table>

    <br>
    

    <br><br>
	<!--<div style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 
	</div>-->
</body>