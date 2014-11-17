<?php 

	date_default_timezone_set('Asia/Manila');
  
    $datetoday = date('F d, Y');
    $day = date('l');
 	$branchno = $this->session->userdata('branchno');

	$getcenter = $this->db->query("SELECT `CaritasCenters_ControlNo`, cc.`CenterNo` FROM `caritasbranch_has_caritascenters` , `caritascenters` cc WHERE `CaritasBranch_ControlNo` =$branchno and `CaritasCenters_ControlNo` = cc.`ControlNo` and cc.`Dayoftheweek`='$day'");

 ?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/list.css'); ?>">
<script src="<?php echo base_url('Assets/js/list.js'); ?>"></script>

<script type="text/javascript">
	function showdcform(centercontrol){
		if (centercontrol > 0) {
			var text = document.getElementById('cars').options[document.getElementById('cars').selectedIndex].text;
			window.open("dailycollectionindividual?center="+centercontrol+"&name="+text);		
		}else{
			alert("No Center Selected.");
		} ;
	
}

</script>

<!--	<link rel="stylesheet" type="text/css" href="../../../Assets/css/list.css">
	<script src=""></script>-->



<body onload="hideDCS()">

	<div class="content2">

		<h2 class="hTitle">DOWNLOADS</h2>

		<form class="basic-grey">
			<label>
				<span>Form Type:</span>
				<select style="width: 562px;" onchange="showDCS(this.value)">
						<option value=" " selected></option>
						<option value="dcs">Daily Collection Sheet</option>
				</select>
			</label>
		</form>
		<div id="dcs">

				<form class="basic-grey">

					<label>
						<span> Date:</span>
						<input type='text' name='date' value='<?php echo $datetoday ?>' disabled>
						<span>Center No. :  </span>

						<select style="width: 100px;" id='cars' onchange="showdcform(this.value)">
							<option></option>
							<?php foreach ($getcenter->result() as $ctr) { ?>
							<option value="<?php echo $ctr->CaritasCenters_ControlNo ?>"><?php echo $ctr->CenterNo; ?></option>
							<?php } ?>
						</select>
					</label>

					<!-- <label>
						<span></span>
					     <input type="submit" class="button" value="Send" onclick="window.open();"/>
					</label> -->

				</form>

		</div>




		<!-- <table>

			<tr>
				<th class="num"></th>
				<th class="docuname">DOCUMENT</th>
				<th class="lastupdate">LAST UPDATED</th>
			</tr>
			<tr>
				<td>01.</td>
				<td class="docuname"><a href="#"> Form 1 </a></td>
				<td class="lastupdate">7/9/2014</td>
			</tr>
			<tr>
				<td>02.</td>
				<td class="docuname"><a href="#"> form 2 </a></td>
				<td class="lastupdate">7/9/2014</td>
			</tr>
			<tr>
				<td>03.</td>
				<td class="docuname"><a href="#"> fOrm 3 </a></td>
				<td class="lastupdate">7/9/2014</td>
			</tr>
			<tr>
				<td>04.</td>
				<td class="docuname"><a href="#"> FORM 4 </a></td>
				<td class="lastupdate">7/9/2014</td>
			</tr>


		</table> -->

		
	<br><br><br>
	</div>

</body>