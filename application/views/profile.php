<!-- <link rel="stylesheet" type="text/css" href="../../../Assets/css/general.css">
<script src="../../../Assets/js/general.js"></script>-->


<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/general.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>
<style>
      #map-canvas {
        height: 75%;
        margin:0;
		position:absolute;
		width:500px; 
	

      }
      .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        padding: 0 11px 0 13px;
        width: 200px;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 400;
        text-overflow: ellipsis;
      }

      #pac-input:focus {
        border-color: #4d90fe;
        margin-left: -1px;
        padding-left: 14px;  /* Regular padding-left + 1. */
        width: 401px;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
}

    </style>
    <title>Places search box</title>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
    <script>
// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.

function initialize() {

  var markers = [];
 

  var map = new google.maps.Map(document.getElementById('map-canvas'), {
    mapTypeId: google.maps.MapTypeId.ROADMAP, 
     });

  var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(14.592463, 121.002376),
      new google.maps.LatLng(14.595, 121.003));
  map.fitBounds(defaultBounds);

  // Create the search box and link it to the UI element.
  var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var searchBox = new google.maps.places.SearchBox(
    /** @type {HTMLInputElement} */(input));

  // [START region_getplaces]
  // Listen for the event fired when the user selects an item from the
  // pick list. Retrieve the matching places for that item.
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }
    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }

    // For each place, get the icon, place name, and location.
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      var marker = new google.maps.Marker({
        map: map,
        icon: image,
        title: place.name,
        position: place.geometry.location
      });

      markers.push(marker);

      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);
  });
  // [END region_getplaces]

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <style>
      #target {
        width: 345px;
      }
    </style>


<?php

$userrank = $this->session->userdata("rank");
$control_no = $_GET['name'];
/*SQL QUERIES*/


$getMember =$this->db->query("SELECT  mem.ControlNo, MemberID,memname.LastName,memname.FirstName, memname.MiddleName, ContactNo,Birthday,BirthPlace, GenderID, Religion, EducationalAttainment,CivilStatus, MFI,Address,AddressDate, Status, Type,BusinessType,CompanyName,CompanyContact,YearEntered, LoanExpense,Savings, CapitalShare 
                                FROM 
                                Members mem 
                                LEFT JOIN MembersName memname ON mem.ControlNo=memname.ControlNo
                                LEFT JOIN (SELECT ControlNo, Status FROM members_has_membersmembershipstatus ORDER BY DateUpdated DESC LIMIT 1) mhmstatus ON mem.ControlNo=mhmstatus.ControlNo
                                
                                LEFT JOIN (SELECT ControlNo, Type FROM members_has_membertype ORDER BY DateUpdated DESC LIMIT 1) mhmtype ON mem.ControlNo=mhmtype.ControlNo
                                LEFT JOIN MembersContact memcontact ON mem.ControlNo=memcontact.ControlNo
                                LEFT JOIN membersmfi mfi ON mem.ControlNo=mfi.ControlNo
                                LEFT JOIN membersaddress madd ON mem.ControlNo=madd.ControlNo
                                LEFT JOIN sourceofincome soi ON mem.ControlNo=soi.ControlNo
                                WHERE mem.ControlNo='$control_no'");

$getHousehold =$this->db->query("SELECT ControlNo, msmhouse.HouseholdNo, Relationship, Age, GenderID, CivilStatus, A.Name, A.Occupation
                    FROM members_has_membershousehold msmhouse
                    LEFT JOIN 
                    (SELECT memhouse.HouseholdNo AS HouseholdNo, Age, GenderID, CivilStatus,  concat(hname.LastName,', ',hname.FirstName,' ', hname.MiddleName) AS Name, Occupation FROM membershousehold memhouse
                    LEFT JOIN householdname hname ON memhouse.HouseholdNo=hname.HouseholdNo
                    LEFT JOIN householdoccupation hoccu ON memhouse.HouseholdNo=hoccu.HouseholdNo)A ON msmhouse.HouseholdNo=A.HouseholdNo
                    WHERE ControlNo='$control_no'");

$getOrganization =$this->db->query("SELECT * FROM `membersorganization` WHERE `ControlNo`='$control_no' ");

$getbranchandcenter = $this->db->query("SELECT cm.`CaritasCenters_ControlNo`, cc.`CenterNo`, cbc.`CaritasBranch_ControlNo`, b.`BranchName`
FROM `caritascenters_has_members` cm, `caritascenters` cc, `caritasbranch_has_caritascenters` cbc,
`caritasbranch` b
where `Members_ControlNo` = '$control_no' and cm.`CaritasCenters_ControlNo` = cc.`ControlNo` and
cbc.`CaritasCenters_ControlNo` = cc.`ControlNo` and
b.`ControlNo` = cbc.`CaritasBranch_ControlNo`");

foreach ($getbranchandcenter->result() as $bc) {
	$branch = $bc->BranchName;
	$center = $bc->CenterNo;
}

	foreach ($getMember->result() as $mem) {

			$lastname = $mem->LastName;
			$middlename = $mem->MiddleName;
			$FirstName = $mem->FirstName;
			$memid = $mem->MemberID;
			$mfi = $mem->MFI;
			$addresshome = $mem->Address;
			$addressdate = $mem->AddressDate;
			$contactno = $mem->ContactNo;
			$bday = $mem->Birthday;
			$bplace = $mem->BirthPlace;
			$gender_id =$mem->GenderID;
			$cstatus = $mem->CivilStatus;
			$religion = $mem->Religion;
			$btype = $mem->BusinessType;
			$companyname = $mem->CompanyName;
			$comcontact = $mem->CompanyContact;
			$yearen = $mem->YearEntered;
			$edu = $mem->EducationalAttainment;
			}
 ?>

 <?php $getLoanInfo = $this->db->query("SELECT loanapplication_ControlNo AS LoanControl, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, Status, LoanType FROM loanapplication_has_members lhm
LEFT JOIN loanapplication la ON lhm.LoanApplication_ControlNo=la.ControlNo
WHERE lhm.Members_ControlNo='$control_no' and Status='Active'");
 ?>


<body onload="TabInfo();">


		<div class="content2">

			<div class="tabs">
				<input type="button" value="Information" class="profile" onclick="TabInfo()" id="info"/>
				<input type="button" value="Loan" class="loan" onclick="TabLoan()" id="loan"/>
				<input type="button" value="Savings/Withdrawal" class="savings" onclick="TabSavings()" id="savings"/>
				<input type="button" value="Performance" class="performance" onclick="TabPerf()" id="performance"/>	
			</div>
			<div class="line"></div>
 			


			<!-------------------->
			<!-------------------->
			<!-------------------->

			<div id="divprofile" style="display: none;">

				<!--------------------------------------------------------------------> 
		
				<div class = "personalinfo">

					<div class="headername"><b><?php echo $lastname  ?></b>, <?php echo $FirstName." ".$middlename ; ?></div>
						<div class="skew"></div>
					<br>

					<p class="info1"><?php echo $memid; ?></p>
					<p class="info"><?php echo $branch." - ".$center; ?> </p>

					<br>
					<p class="info"><b>Gender: </b><?php echo $gender_id; ?></p>
					<p class="info"><b>Birthday: </b> <?php echo $bday; ?></p>
					<p class="info"><b>Birth Place: </b><?php echo $bplace; ?></p>
					<p class="info"><b>Civil Status: </b><?php echo $cstatus; ?></p>
					<p class="info"><b>Educational Attainment: </b><?php echo $edu; ?> </p>
					<p class="info"><b>Religion: </b> <?php echo $religion; ?> </p>
					
					<form>
						<input type='hidden'  name='controlno' value='<?php echo $control_no ?>' >
						<input type="submit" class="editbtn" value="Terminate" />
					</form>
					<!-- <form action='editprofile' method='post'>
						<input type='hidden'  name='controlno' value='<?php echo $control_no ?>' >
						<input type="submit" class="editbtn" value="Edit Profile" />
					</form> -->

				    

				    <br>
				</div>
		

				<!--------------------------------------------------------------------> 
				<br>
				
				<div class = "contactinfo2">
				
					<div class="subheadername">Contact Information</div>
						<div class="subskew"></div>
					<br><br>

					<p class="info"><b>Home Address: </b><?php echo $addresshome; ?></p>
					<p class="info"><b>Years of Residence: </b> <?php echo $addressdate; ?> years </p>
					<p class="info"><b>Contact No.: </b><?php echo $contactno; ?> </p>


				 	
			
				<input id="pac-input" class="controls" type="text" placeholder="Search Box">
    			<div id="map-canvas"></div>
			

				
				
				

				</div>


				<!--------------------------------------------------------------------> 
				<br>
				<div class = "mainincome">

					<div class="subheadername">Main Income</div>
						<div class="subskew"></div>
					<br><br>

					<p class="info"><b>Company Name: </b> <?php echo $companyname; ?> </p>
					<p class="info"><b>Business Type: </b> <?php echo $btype; ?> </p>
					<p class="info"><b>Contact No.: </b> <?php echo $comcontact; ?>  </p>
					<p class="info"><b>Years in the Business: </b><?php echo $yearen; ?> years  </p>

				</div>


				<!--------------------------------------------------------------------> 
				<br>
				<div class = "household">

					<div class="subheadername">Household</div>
						<div class="subskew"></div>
					<br><br>

						<?php foreach ($getHousehold->result() as $house) { ?>

						
						<div id="householdmembers">
							<p class="info"><b>Name: </b><?php echo $house->Name; ?> </p>
							<p class="info"><b>Relationship: </b> <?php echo $house->Relationship; ?> </p>
							<p class="info"><b>Gender: </b> <?php echo $house->GenderID; ?></p>
							<p class="info"><b>Age: </b> <?php echo $house->Age; ?> years old</p>
							<p class="info"><b>Civil Status: </b><?php echo $house->CivilStatus; ?> </p>
							<p class="info"><b>Occupation: </b><?php echo $house->Occupation; ?> </p>
							<br>
						</div>

						<?php } ?>
						<!-- <div id="householdmembers">
							<p class="info"><b>Name: </b> Last, First Middle Name </p>
							<p class="info"><b>Relationship: </b> Relative </p>
							<p class="info"><b>Gender: </b> Male</p>
							<p class="info"><b>Age: </b> 22 years old</p>
							<p class="info"><b>Civil Status: </b>Single </p>
							<p class="info"><b>Occupation: </b>N/A </p>
							<br>
						</div> -->

				</div>


				<!--------------------------------------------------------------------> 
				<br>
				<div class = "otherinfo">

					<div class="subheadername">Other Information</div>
						<div class="subskew"></div>
					<br><br>

					<p class="info"><b>Other Microfinance Institution/s: </b><?php echo $mfi; ?></p><br>

					<p class="info"><b>Affiliated Organization/s </b></p>
						
						<ul class="affiliatedOrgs">

							<?php foreach ($getOrganization->result() as $org) { ?>
	
								<li><?php echo $org->Organization; ?> - <?php echo $org->Position; ?></li>
							
							<?php } ?>
						
						</ul>
				</div>
				
				<br><br><br><br>	

				<?php if ($userrank =="branchmanager") { ?>
					<input type="submit" class="deactivatebtn" value="Deactivate Account" />
				<?php } ?>

				

				<br><br><br>
			
			</div>

			<!-------------------->
			<!-------------------->
			<!-------------------->



			


			<div id="divloan" style="display: none;">
				<?php foreach ($getLoanInfo->result() as $row) {
					$amount = $row->AmountRequested + $row->Interest;
				 echo '<div class = "personalinfo">';

					echo'<div class="headername"><b>Active Loan Release: </b>' .$amount. 'Php</div>';
					echo '<div class="skew"></div>';
					echo '<br><br>';
					
					echo '<p class="info"><b>Loan Application No.: </b>' .$row->ApplicationNumber. '</p>';
					echo '<p class="info"><b>Date Loan: </b>' .$row->DateApplied. '</p>';
					echo '<p class="info"><b>Loan Type: </b>' .$row->LoanType. '</p>';
					echo '<p class="info"><b>Day of Payment: </b>' .$row->DayoftheWeek. '</p>';

					echo '<!-----NOT FINAL------>';
				    echo '<input type="button" class="editbtn" value="View Transaction Log" style="margin-left: 720px;" onclick="showTransactionLog()"/>';

				echo '</div>';
				
$gettransaction = $this->db->query("SELECT `ControlNo`, `Amount`, `DateTime`, `Members_ControlNo`, `Passbook_ControlNo`, `CaritasPersonnel_ControlNo`, `TransactionType`, `LoanAppControlNo` FROM `transaction` WHERE `LoanAppControlNo`='$row->LoanControl' and (`TransactionType` ='Loan' or `TransactionType` ='Past Due')  and `Members_ControlNo`='$control_no' ");

				echo '<div id="TransactionLog">';
					echo '<br>';

					echo'<form>';

						/*echo '<p style="text-align:center;">VIEW TRANSACTION <b>FROM:</b> <input type="text" class="viewtrans"  placeholder="calendar format"/> &nbsp &nbsp<b>TO:</b>  <input type="text" class="viewtrans" placeholder="calendar format"/>';*/

					echo '</form>';
					/*	echo '<input value="Go" type="submit" class="go"/></p>';*/
					

					echo '<br><br>';
					if(!empty($gettransaction->result())){

					
					echo '<table class="TransLog" >';
						echo '<tr class="t">';
							echo '<th>DATE</th>';
							echo '<th>DESCRIPTION</th>';
							echo '<th>AMOUNT</th>';
							/*echo '<th>CREDIT</th>';*/
							echo '<th>BALANCE</th>';
						echo '</tr>';
						$total=$amount;
						foreach ($gettransaction->result() as $transact) {
							
						
						echo '<tr>';
							echo '<td class="tdate">'.$transact->DateTime.'</td>';
							echo '<td class="tdesc">'.$transact->TransactionType.'</td>';
							echo '<td class="val">'.$transact->Amount.'</td>';
							/*echo '<td class="val"></td>';*/
							$f = $transact->TransactionType;
						if ( $f=='Loan ') {
						$total -= $transact->Amount;
						}
							
							echo '<td class="val">'.$total.'</td>';
						echo '</tr>';
					}
				/*  echo '<tr>';
							echo '<td class="tdate">January 14 2013</td>';
							echo '<td class="tdesc">Savings</td>';
							echo '<td class="val"></td>';
							echo '<td class="val">200</td>';
							echo '<td class="val">3800</td>';
						echo '</tr>';*/

						/*echo '<tr class="endingbal">';
							echo '<td class="tdate"></td>';
							echo '<td class="tdesc" style="text-align:right;">Ending Balance:</td>';
							echo '<td class="val"></td>';
							echo '<td class="val"></td>';
							echo '<td class="val"><b>3800</b></td>';
						echo '</tr>';

							echo '<tr class="debit">';
								echo '<td class="tdate"></td>';
								echo '<td class="tdesc" style="text-align:right;">Total Debit:</td>';
								echo '<td class="val"><b>4000</b></td>';
								echo '<td class="val"></td>';
								echo '<td class="val"></td>';
							echo '</tr>';
							echo '<tr class="credit">';
								echo '<td class="tdate"></td>';
								echo '<td class="tdesc" style="text-align:right;">Total Credit:</td>';
								echo '<td class="val"></td>';
								echo '<td class="val"><b>200</b></td>';
								echo '<td class="val"></td>';
							echo '</tr>';
				*/

					echo '</table>';
					}else{
						echo "<p class='noresultfound'>No Transaction Record Found!</p><br><br>";
					}				
				echo '</div>';
} ?>
				
				
						
				<br>
				</div>
				
			</div>

			<!-------------------->
			<!-------------------->
			<!-------------------->

			<div id="divsavings" style="display: none;">

				<?php $getsavingstransaction = $this->db->query(" SELECT `ControlNo`, `Amount`, `DateTime`, `Members_ControlNo`, `Passbook_ControlNo`, `CaritasPersonnel_ControlNo`, `TransactionType` FROM `transaction` WHERE(`TransactionType` ='Savings' or `TransactionType` ='Withdrawal')  and `Members_ControlNo`='$control_no' order by `DateTime` ASC "); 

					$gettotsavings = $this->db->query("SELECT `Savings` FROM `members` where `ControlNo` = $control_no");

					foreach ($gettotsavings->result() as $s) {
						$totalsavings  = $s->Savings;
					}
				?>

				<div class="BG">

					<br><br><br>
					<div id="TransactionLog">
						
						<div class="headername"><b>Savings Build Up: <?php echo $totalsavings; ?> </div>
						<div class="skew"></div>
						<br>
						<!-- <form>

							<p style="text-align:center;">VIEW SAVINGS LOG <b>FROM:</b> <input type="text" class="viewtrans"  placeholder="calendar format"/> &nbsp &nbsp<b>TO:</b>  <input type="text" class="viewtrans" placeholder="calendar format"/> 

							</form>
							<input value="Go" type="submit" class="go"/></p> -->
						<br><br>
						<table class="TransLog" >
							<tr class="t">
								<th>DATE</th>
								<th>DESCRIPTION</th>
								<th>AMOUNT</th>
								<!-- <th>CREDIT</th> -->
								<th>BALANCE</th>
							</tr>
							<?php $totsavings=0; ?>
							<?php foreach ($getsavingstransaction->result() as $save) { ?>
								
							
							<tr>
								<td class="tdate"><?php echo $save->DateTime; ?></td>
								<td class="tdesc"><?php echo $save->TransactionType; ?></td>
								<td class="val"><?php echo $save->Amount; ?></td>
								<!-- <td class="val">100</td> -->
								<?php $fa =$save->TransactionType;
										if ($fa=="Withdrawal ") {
											
											$totsavings =$totsavings - $save->Amount;
										}else{
											
											$totsavings =$totsavings + $save->Amount;
										}
								
								 ?>
								<td class="val"><?php echo $totsavings; ?></td>
							</tr>	

							<?php } ?>

								<!-- <tr>
									<td class="tdate">January 14 2013</td>
									<td class="tdesc">Savings</td>
									<td class="val"></td>
									<td class="val">100</td>
									<td class="val">200</td>
								</tr> -->

								<!-- <tr class="endingbal">
									<td class="tdate"></td>
									<td class="tdesc" style="text-align:right;">Total Savings:</td>
									<td class="val"></td>
									<td class="val"></td>
									<td class="val">200</td>
								</tr>

									<tr class="debit">
										<td class="tdate"></td>
										<td class="tdesc" style="text-align:right;">Debit:</td>
										<td class="val"><b>4000</b></td>
										<td class="val"></td>
										<td class="val"></td>
									</tr>
									<tr class="credit">
										<td class="tdate"></td>
										<td class="tdesc" style="text-align:right;">Credit:</td>
										<td class="val"></td>
										<td class="val"><b>50</b></td>
										<td class="val"></td>
									</tr> -->
						</table>		
					</div>
				<br><br>
				</div>
			</div>
			<!-------------------->
			<!-------------------->
			<!-------------------->

			

			<div id="divperformance" style="display: none;"><div class="BG">
			<br><br>

				<div class = "personalinfo">

					<div class="headername">Over-all Performance</div>
						<div class="skew"></div>
					<br>

					<br>
					<p class="info">No. of Years in the Cooperative: <b>X years</b> </p>
					<p class="info">Loan Cycle: <b>X</b> </p>
					<p class="info">Current no. of Past Due: <b>XX</b> </p>
					<p class="info">Accumulated no. of Past Due: <b>XX</b> </p>

					<br>
				
					<p style="text-align:center; font-size: 13px; color:#696666; margin-right: 50px;"><b>Number of Past Due in accordance to amount loaned</p>

					<table class="perfass2">
						<tr class="nohover">
							<th rowspan="2" class="bordr" style="width: 200px" >AMOUNT</th>
							<th colspan ="2" class="bordr">NO. OF PAST DUE</th>
						</tr>

							<tr class="nohover">
								<td class="wk" style="width: 150px"> 23 Week</td>
								<td class="wk" style="width: 150px"> 40 Week</td>
							</tr>
					
						<tr class="hoverthis">
							<td class="sbu">1,000 - 4,000</td>
							<td class="sbu"> 0 </td>
							<td class="sbu"> 0 </td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">4,001 - 8,000</td>
							<td class="sbu"> 0 </td>
							<td class="sbu"> 0 </td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">8,001 - 16,000</td>
							<td class="sbu"> 0 </td>
							<td class="sbu"> 0 </td>
						</tr>
						<tr class="hoverthis">
							<td class="sbu">16,001 - 32,000</td>
							<td class="sbu"> 0 </td>
							<td class="sbu"> 0 </td>
						</tr>						

					</table>



				    <br>
				</div>

				<div class = "personalinfo">

					<div class="headername">Capital Share: <b>5,000</b> Php</div>
						<div class="skew"></div>
					<br>

					<br>
					<p class="info"><b>Don't know what details to include </b> xx</p>
					<!--<p class="info"><b>Birthday: </b> <?php echo $bday; ?></p>
					<p class="info"><b>Birth Place: </b><?php echo $bplace; ?></p>
					<p class="info"><b>Civil Status: </b><?php echo $cstatus; ?></p>
					<p class="info"><b>Educational Attainment: </b><?php echo $edu; ?> </p>
					<p class="info"><b>Religion: </b> <?php echo $religion; ?> </p>
					
					<form action='editprofile' method='post'>
						<input type='hidden'  name='number' value='<?php echo $control_no ?>' >
						<input type="submit" class="editbtn" value="Edit Account" />
					</form>-->
				    

				    <br>
				</div>

				
			
				<br><br><br>

				<p style="text-align:center; font-size: 18px; color:#696666; right-margin: 50px;"><b>TRANSACTION OVERVIEW (23-WEEKS)</b></p>
				<table class="perfass">
					<tr class="nohover">
						<th rowspan="2" style="width: 20px;" ></th>
						<th rowspan="2" style="text-indent: -20px; font-size: 12px;">MONTH</th>
						<th rowspan="2" class="bordr" >ACTIVE RELEASE</th>
						<th colspan ="4" class="bordr">LOAN</th>
						<th colspan="4" class="bordr">SAVINGS BUILD-UP </th>
						<th rowspan="2" class="bordr">Past Due</th>
						<th rowspan="2" class="bordr">Withdrawals </th>
						<th rowspan="2" class="bordr">Savings Build Up</th>
						<th rowspan="2" class="bordr">Loan Remaining</th>

					</tr>

						<tr class="nohover">
							<td class="wk">WEEK 1 <br> Jul 2</td>
							<td class="wk">WEEK 2 <br> Jul 9</td>
							<td class="wk">WEEK 3 <br> Jul 16</td>
							<td class="wk">WEEK 4 <br> Jul 23</td>

							<td class="wk">WEEK 1 <br> Jul 2</td>
							<td class="wk">WEEK 2 <br> Jul 9</td>
							<td class="wk">WEEK 3 <br> Jul 16</td>
							<td class="wk">WEEK 4 <br> Jul 23</td>

						</tr>


					<tr class="hoverthis">
						<td class="num"> 01.</td>
						<td class="collectmonth"><a href="#"><b>July</b></a></td>
						<td class="sbu" >4000</td>

							<td class="wk1">200</td>
							<td class="wk1">Late</td>
							<td class="wk1">400</td>
							<td class="wk1">Unpaid</td>

							<td class="wk1">50</td>
							<td class="wk1">100</td>
							<td class="wk1">50</td>
							<td class="wk1">-</td>
							
						<td class="sbu" >200</td>
						<td class="withdraw" >0</td>
						<td class="sav" >200</td>
						<td class="rem">3400</td>

					</tr>

			<!-------------------------------------------->
					
				<tr class="hoverthis">
						<td class="num"> 02.</td>
						<td class="collectmonth"><a href="#"><b>August</b></a></td>
						<td class="sbu" >4000</td>

							<td class="wk1">200</td>
							<td class="wk1">Unpaid</td>
							<td class="wk1">-</td>
							<td class="wk1">-</td>

							<td class="wk1">100</td>
							<td class="wk1">-</td>
							<td class="wk1">-</td>
							<td class="wk1">-</td>
							
						<td class="sbu" >400</td>
						<td class="withdraw" >0</td>
						<td class="sav" >300</td>
						<td class="rem">3200</td>

					</tr>


							
				</table>
				<br><br>

				<div class = "personalinfo">

					<div class="subheadername">Violations</div>
						<div class="subskew"></div>
					<br>

					<br>
					 	<!---LIST OF VIOLATIONS -->
						<ul class="affiliatedOrgs">
							
							<li>You are cleared!</li>
							
						</ul>
				    

				    <br>
				</div>

				<div class = "personalinfo">

					<div class="subheadername">Overview</div>
						<div class="subskew"></div>
					<br>

					<br>
					<p class="info">Insert note here..</p>
								    

				    <br>
				</div>

				<br><br><br>
			</div>
		</div>

			
	</div>

</body>



<!--<div class = "otherinfo">

					<div class="subheadername">Member Co-Maker</div>
						<div class="subskew"></div>
					<br><br>

					<p class="info"><b>Name: </b> Lname, First Middle Name </p>
					<p class="info"><b>Member ID: </b> XXXXXXX</p>
					<p class="info"><b>Relationship: </b> Relative </p>

				</div>

				<div class = "otherinfo">

					<div class="subheadername">Business</div>
						<div class="subskew"></div>
					<br><br>

					<p class="info"><b>Business Name: </b> Busines Corporation, Inc. </p>
					<p class="info"><b>Type: </b> Organization</p>
					<p class="info"><b>Date Established: </b> January 01, 2005 </p>
					<p class="info"><b>Address: </b> Paco, Manila </p>
					<p class="info"><b>Contact No.: </b> 09011111111 </p>

				</div>

				<div class = "otherinfo">

					<div class="subheadername">Material Inventory</div>
						<div class="subskew"></div>
					<br><br>

						<table class="TableUnderLoan">
							<tr>
								<th class="name">NAME</th>
								<th class="qty">QTY.</th>
								<th class="unitprice">UNIT PRICE</th>
							</tr>

							<tr>
								<td class="name">Sample Appliance 1</td>
								<td class="qty">2</td>
								<td class="unitprice">5,000.00</td>
							</tr>

							<tr>
								<td class="name">Sample Appliance 2</td>
								<td class="qty">1</td>
								<td class="unitprice">1,500.00</td>
							</tr>

							<tr>
								<td class="name">Sample Appliance 3</td>
								<td class="qty">1</td>
								<td class="unitprice">2,500.00</td>
							</tr>

							<tr>
								<td class="name"></td>
								<td class="qty"></td>
								<td class="unitprice" style="border-top:thick double #bcbaba;">9,000.00</td>
							</tr>

						</table>
						<br>

				</div>

				<div class = "otherinfo">

					<div class="subheadername">Household</div>
						<div class="subskew"></div>
					<br><br>

						<table class="TableUnderLoan2">
							<tr>
								<th class="name1">NAME</th>
								<th class="reln">RELATIONSHIP</th>
								<th class="age">AGE</th>
								<th class="cstat">CIVIL STATUS</th>
								<th class="job">OCCUPATION</th>	
							</tr>

							<tr>
								<td class="name1">Sample Name</td>
								<td class="reln">Mother</td>
								<td class="age">42</td>
								<td class="cstat">Married</td>
								<td class="job">Housewife</td>
							</tr>

							<tr>
								<td class="name1">Sample Name 2</td>
								<td class="reln">Sister</td>
								<td class="age">18</td>
								<td class="cstat">Single</td>
								<td class="job">Student</td>
							</tr>


						</table>