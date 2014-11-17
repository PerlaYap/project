<!--<link rel="stylesheet" type="text/css" href="../../../Assets/css/general.css">
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
 $bday = date('F d, Y', strtotime($mem->Birthday)) ;
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

$getPic =$this->db->query("SELECT * FROM MembersPicture WHERE ControlNo = '$control_no' ");

$getDoc =$this->db->query("SELECT * FROM MembersSignature WHERE ControlNo = '$control_no' ");
?>

<?php $getLoanInfo = $this->db->query("SELECT loanapplication_ControlNo AS LoanControl, ApplicationNumber, AmountRequested, Interest, DateApplied, DayoftheWeek, Status, LoanType FROM loanapplication_has_members lhm
  LEFT JOIN loanapplication la ON lhm.LoanApplication_ControlNo=la.ControlNo
  WHERE lhm.Members_ControlNo='$control_no' and Status='Current'");
  ?>

  <?php $savings = $this->db->query("SELECT m.savings, mm.status, m.ControlNo FROM  loanapplication_has_members lm, members m, members_has_membersmembershipstatus mm WHERE lm.Members_ControlNo = m.ControlNo AND m.ControlNo = mm.ControlNo AND m.ControlNo = '$control_no' "); 

  foreach($savings->result() as $save){


   $actual = $save->savings;
   $status = $save->status;
 }

 $date = $this->db->query("SELECT TIMESTAMPDIFF(WEEK, NOW(),(SELECT DateEntered FROM CaritasCenters_has_Members cm, Members m WHERE cm.Members_ControlNo='$control_no' AND cm.Members_ControlNo = m.ControlNo)) AS diff");

 foreach($date->result() as $dt){

   $diff = $dt->diff;

 }

 $expected = $diff*50;
 ?>
 <!--Performance -->

 <?php $pastDuePerformance = $this->db->query("SELECT Members_ControlNo AS MemberControl, Count(loanapplication_ControlNo) AS LoanCount, SUM(CapitalShare) AS TotalShare, TotalPastDue,TotalLoanTrans, Percent, PastDue23a, PastDue40a, PastDue23b, PastDue40b, PastDue23c, PastDue40c, PastDue23d, PastDue40d, PastDue23e, PastDue40e,
  IFNULL(ROUND((((PastDue23a+PastDue40a)/TotalTransa)*100),2),0) AS Percenta,IFNULL(ROUND((((PastDue23b+PastDue40b)/TotalTransb)*100),2),0) AS Percentb, IFNULL(ROUND((((PastDue23c+PastDue40c)/TotalTransc)*100),2),0) AS Percentc, IFNULL(ROUND((((PastDue23d+PastDue40d)/TotalTransd)*100),2),0) AS Percentd, IFNULL(ROUND((((PastDue23e+PastDue40e)/TotalTranse)*100),2),0) AS Percente
  FROM (SELECT * FROM loanapplication_has_members lhm WHERE Members_ControlNo='$control_no') A 
  LEFT JOIN LoanApplication la ON la.ControlNo=A.LoanApplication_ControlNo
  LEFT JOIN
  (SELECT MemberControl,TotalPastDue,TotalLoanTrans, ROUND(((TotalPastDue/TotalLoanTrans)*100),2) AS Percent FROM
    (SELECT Members_ControlNo AS MemberControl, Count(ControlNo) AS TotalLoanTrans FROM transaction trans WHERE (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$control_no') A
    CROSS JOIN
    (SELECT Count(ControlNo) AS TotalPastDue FROM transaction trans WHERE transactiontype='Past Due' AND Members_ControlNo='$control_no') B) C ON C.MemberControl=A.Members_ControlNo
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23a FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested<=4000 AND loantype='23-Weeks') A 
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Beta1
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40a FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested<=4000 AND loantype='40-Weeks') A
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Charlie1
CROSS JOIN
(SELECT Count(ControlNo) AS TotalTransa FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested<=4000 AND (loantype='40-Weeks' OR loantype='23-Weeks')) A
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$control_no') Delta1
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23b FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>4000 AND AmountRequested<=8000 AND loantype='23-Weeks') A 
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Beta2
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40b FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>4000 AND AmountRequested<=8000 AND loantype='40-Weeks') A
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Charlie2
CROSS JOIN
(SELECT Count(ControlNo) AS TotalTransb FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>4000 AND AmountRequested<=8000 AND (loantype='40-Weeks' OR loantype='23-Weeks')) A
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$control_no') Delta2
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23c FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>8000 AND AmountRequested<=16000 AND loantype='23-Weeks') A 
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Beta3
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40c FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>8000 AND AmountRequested<=16000 AND loantype='40-Weeks') A
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Charlie3
CROSS JOIN
(SELECT Count(ControlNo) AS TotalTransc FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>8000 AND AmountRequested<=16000 AND (loantype='40-Weeks' OR loantype='23-Weeks')) A
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$control_no') Delta3
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23d FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>16000 AND AmountRequested<=32000 AND loantype='23-Weeks') A 
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Beta4
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40d FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>16000 AND AmountRequested<=32000 AND loantype='40-Weeks') A
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Charlie4
CROSS JOIN
(SELECT Count(ControlNo) AS TotalTransd FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>16000 AND AmountRequested<=32000 AND (loantype='40-Weeks' OR loantype='23-Weeks')) A
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$control_no') Delta4
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue23e FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>32000 AND loantype='23-Weeks') A 
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Beta5
CROSS JOIN
(SELECT Count(ControlNo) AS PastDue40e FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>32000 AND loantype='40-Weeks') A
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND transactiontype='Past Due' AND Members_ControlNo='$control_no')Charlie5
CROSS JOIN
(SELECT Count(ControlNo) AS TotalTranse FROM transaction trans 
  RIGHT JOIN (SELECT ControlNo AS LoanControl FROM LoanApplication la WHERE AmountRequested>32000 AND (loantype='40-Weeks' OR loantype='23-Weeks')) A
  ON A.LoanControl=trans.LoanAppControlNo  WHERE ControlNo IS NOT NULL AND (transactiontype='Past Due' OR transactiontype='Loan') AND Members_ControlNo='$control_no') Delta5
WHERE (la.Status!='Rejected' AND la.Status!='Pending')");

foreach ($pastDuePerformance->result() as $row) {
	$pdmemberControl = $row->MemberControl;
	$pdloanCount = $row->LoanCount;
  $pdtotalShare=$row->TotalShare;
  $pdtotalPastDue=$row->TotalPastDue;
  $pdtotalLoanTrans=$row->TotalLoanTrans;
  $pdpercent=$row->Percent;
  if (empty($pdpercent)) {
    $pdpercent = 0;
  }
  $pd23a=$row->PastDue23a;
  $pd23b=$row->PastDue23b;
  $pd23c=$row->PastDue23c;
  $pd23d=$row->PastDue23d;
  $pd23e=$row->PastDue23e;
  $pd40a=$row->PastDue40a;
  $pd40b=$row->PastDue40b;
  $pd40c=$row->PastDue40c;
  $pd40d=$row->PastDue40d;
  $pd40e=$row->PastDue40e;
  $pdpercenta=$row->Percenta;
  $pdpercentb=$row->Percentb;
  $pdpercentc=$row->Percentc;
  $pdpercentd=$row->Percentd;
  $pdpercente=$row->Percente;

}
?>

<?php $getCapitalShare = $this->db->query("SELECT  IFNULL(DateReleased,'0000-01-01') AS Date, ApplicationNumber, CapitalShare FROM loanapplication_has_members lhm 
  LEFT JOIN (SELECT * FROM LoanApplication la WHERE Status!='Rejected' AND Status!='Pending')A ON lhm.LoanApplication_ControlNo=A.ControlNo
  WHERE Members_ControlNo='$control_no' AND ControlNo IS NOT NULL");
  ?>

  <?php $getTotalCapitalShare = $this->db->query("SELECT  SUM(CapitalShare) AS TotalShare FROM loanapplication_has_members lhm 
    LEFT JOIN (SELECT * FROM LoanApplication la WHERE Status!='Rejected' AND Status!='Pending')A ON lhm.LoanApplication_ControlNo=A.ControlNo
    WHERE Members_ControlNo='$control_no' AND ControlNo IS NOT NULL");

  foreach ($getTotalCapitalShare->result() as $row) {
   $totalShare=$row->TotalShare;
 }
 ?>


 <body onload="TabInfo();">


  <div class="content33">

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

     <?php if ($userrank=='branchmanager'): ?>
      
     <form action='terminate' method='post'>
      <input type='hidden'  name='controlno' value='<?php echo $control_no ?>' >
      <input type="submit" class="editbtn" value="Withdraw" />
    </form>
    <?php endif ?>
    <br>
    <form action='editprofile' method='post'>
      <input type='hidden'  name='controlno' value='<?php echo $control_no ?>' >
      <input type="submit" class="editbtn1" value="Edit Profile" />
    </form>

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
   <p class="info"><b>Year  entered in the Business: </b><?php echo $yearen; ?> </p>

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
         <div class = "otherinfo">

           <div class="subheadername" style="width: 160px;">Supporting Documents</div>
           <div class="subskew"></div>
           <br><br>

           <p class="info"><b>Valid ID: </b></p>

           <?php foreach ($getPic->result() as $pic) { 

             header('Content-Type: image; charset=UTF-8');

             ?> 

             <div style="width: 324px; height: 204px">
              <img src="<?php echo base_url($pic->Picture); ?>" class="user" style="width: 100%;max-height: 100%"> 
            </div>

            <?php } ?>

            <br><br> <br><br>

            <p class="info"><b>Barangay Clearance: </b></p>

            <?php foreach ($getDoc->result() as $doc) { 

             header('Content-Type: image; charset=UTF-8');

             ?> 

             <div style="width: 768px; height: 960px">
              <img src="<?php echo base_url($doc->Signature); ?>" class="user" style="width: 100%;max-height: 100%"> 
            </div>
            <br><br>
            <?php } ?>


          </ul>
        </div>

		<!--		<br><br><br><br>	

				<?php if ($userrank =="branchmanager") { ?>
					<input type="submit" class="deactivatebtn" value="Deactivate Account" />
				<?php } ?>

				

				<br><br><br>
			-->
   </div> 

   <!-------------------->
			<!---------LOAN----------->
			<!-------------------->



			


			<div id="divloan" style="display: none;">
       <?php $love="";
       $hasloan = $getLoanInfo->result();
       if (!empty($hasloan)) { ?>


       <?php foreach ($hasloan as $row) {
         $amount = $row->AmountRequested + $row->Interest; 
         $love = $row->LoanControl;
         ?>

         <div class = "personalinfo">

           <div class="headername"><b>Active Loan Release: Php </b><?php echo number_format($amount, 2); ?></div>
           <div class="skew"></div>
           <br><br>

           <p class="info"><b>Loan Application No.: </b> <?php echo $row->ApplicationNumber ?> </p>
           <p class="info"><b>Date Loan: </b> <?php echo $row->DateApplied ?></p>
           <p class="info"><b>Loan Type: </b> <?php echo $row->LoanType ?></p>
           <p class="info"><b>Day of Payment: </b> <?php echo $row->DayoftheWeek ?></p>


           <input type="button" class="editbtn" value="View Transaction Log" style="margin-left: 720px;" onclick="showTransactionLog()"/>

         </div>
         <?php } ?>
         <?php 	} else{ ?>
         <br><br><p class='noresultfound'>- No Active Loan -</p><br><br>
         <?php } ?>
         <?php 			
         $gettransaction = $this->db->query("SELECT transaction.`ControlNo`, `Amount`, `DateTime`, `Members_ControlNo`, `Passbook_ControlNo`, `CaritasPersonnel_ControlNo`, `TransactionType`, `LoanAppControlNo`, concat(LastName,', ', FirstName,' ', MiddleName) as name FROM `transaction` join `caritaspersonnel` p on transaction.CaritasPersonnel_ControlNo = p.ControlNo WHERE `LoanAppControlNo`='$love' and (`TransactionType` ='Loan' or `TransactionType` ='Past Due')  and `Members_ControlNo`='$control_no' order by DateTime "); ?>

         <div id="TransactionLog">
          <br>

          <form>

           <?php 	/*echo '<p style="text-align:center;">VIEW TRANSACTION <b>FROM:</b> <input type="text" class="viewtrans"  placeholder="calendar format"/> &nbsp &nbsp<b>TO:</b>  <input type="text" class="viewtrans" placeholder="calendar format"/>';*/ ?>

         </form>
         <?php /*	echo '<input value="Go" type="submit" class="go"/></p>';*/?>


         <br><br>
         <?php 
         if(!empty($gettransaction->result())){
          ?>
          <table class="TransLog" >
            <tr class="t">
              <th style="width: 300px;">DATE</th> 
              <!-- <th style="width: 100px;">TIME</th>	 -->
              <th style="width: 200px;">LOAN PAYMENT</th>
              <th style="width: 200px;">PAST DUE</th>
              <!-- /*echo '<th>CREDIT</th>';*/ -->
              <th style="width: 200px;">BALANCE</th>
              <th style="width: 300px;">SALVE OFFICER</th> 

            </tr>
<!-- 
            <tr>
              <td class="tdate" style="text-indent: 10px;">2014-08-05</td>
              <td class="val">02:13pm</td>
              <td class="val">200</td>
              <td class="val"></td>
              <td class="val">4400</td>
              <td class="val">Lyka Dado</td>
            </tr>

            <tr>
              <td class="tdate" style="text-indent: 10px;">2014-08-12</td>
              <td class="val">04:13pm</td>
              <td class="val"></td>
              <td class="val">200</td>
              <td class="val">4400</td>
              <td class="val">Lyka Dado</td>
            </tr>

            <tr>
              <td class="tdate" style="text-indent: 10px;">2014-08-19</td>
              <td class="val">03:23pm</td>
              <td class="val">200</td>
              <td class="val"></td>
              <td class="val">4200</td>
              <td class="val">Lyka Dado</td>
            </tr>

            <tr>
              <td class="tdate" style="text-indent: 10px;">2014-08-26</td>
              <td class="val">03:54pm</td>
              <td class="val"></td>
              <td class="val">200</td>
              <td class="val">4200</td>
              <td class="val">Lyka Dado</td>
            </tr> -->


            <?php
            $total=$amount;
            foreach ($gettransaction->result() as $transact) {

             $type=$transact->TransactionType; ?>

             <tr>
              <td class="tdate"><?php echo $transact->DateTime ?></td>
              <?php if ($type=="Loan ") { ?>

              <td class="val"> <?php echo $transact->Amount ?></td>
              <td class="val"></td>
              <?php }else{ ?>
              <td class="val"></td>
              <td class="val"><?php echo $transact->Amount ?></td>

              <?php	} ?>

              <!-- /*echo '<td class="val"></td>';*/ -->
              <?php
              $f = $transact->TransactionType;
              if ( $f=='Loan ') {
                $total -= $transact->Amount;
              }
              ?>
              <td class="val"><?php echo $total ?></td>
              <td class="val"><?php echo $transact->name ?></td>
            </tr>
            <?php } ?> 


          </table>
          <?php 
        }else{ ?>
        <p class='noresultfound'>No Transaction Record Found!</p><br><br>
        <?php 	}		?>
      </div>




      <br>
    </div>

  </div>

  <!-------------------->
			<!---------SAVINGS ----------->
			<!-------------------->

			<div id="divsavings" style="display: none;">

				<?php $getsavingstransaction = $this->db->query("SELECT Amount, DateTime, Members_ControlNo, TransactionType, CONCAT(LastName,', ', FirstName, ' ', MiddleName) AS Name FROM Transaction trans
          LEFT JOIN CaritasPersonnel cp ON trans.CaritasPersonnel_ControlNo=cp.ControlNo
          WHERE (`TransactionType` ='Savings' OR `TransactionType` ='Withdrawal') AND Members_ControlNo='$control_no'
          ORDER BY DateTime "); 

       $gettotsavings = $this->db->query("SELECT `Savings` FROM `members` where `ControlNo` = $control_no");

       foreach ($gettotsavings->result() as $s) {
        $totalsavings  = $s->Savings;
      }
      ?>

      <div class="BG">

       <br><br><br>
       <div id="TransactionLog">

        <div class="headername"><b>Savings Build Up: Php </b><?php echo number_format($totalsavings, 2); ?> </div>
        <div class="skew"></div>
        <br>
						<!-- <form>

							<p style="text-align:center;">VIEW SAVINGS LOG <b>FROM:</b> <input type="text" class="viewtrans"  placeholder="calendar format"/> &nbsp &nbsp<b>TO:</b>  <input type="text" class="viewtrans" placeholder="calendar format"/> 

							</form>
							<input value="Go" type="submit" class="go"/></p> -->
              <br><br>
              <table class="TransLog" >
               <tr class="t">
                <th style="width:200px;">DATE</th>
                <th style="width:150px;">DEPOSIT</th>
                <th style="width:200px;">WITHDRAWAL</th>

                <!-- <th>CREDIT</th> -->
                <th style="width:200px;">BALANCE</th>
                <th style="width:200px;">TRANS CODE</th>
                <th style="width:200px;">SALVE OFFICER</th>

              </tr>

              <?php $totsavings=0; ?>
              <?php foreach ($getsavingstransaction->result() as $save) { ?>
              <?php $fa =$save->TransactionType; ?>
              <?php $wordDate=date('F d, Y', strtotime($save->DateTime)); ?>

              <tr>
                <td class="val"><?php echo $wordDate; ?></td>
                <?php if ($fa =="Withdrawal ") {?>
                <td class="val"></td>
                <td class="val"><?php echo $save->Amount; ?></td>


                <?php } else{ ?>

                <td class="val"><?php echo $save->Amount; ?></td>
                <td class="val"></td>
                <?php } ?>


                <!-- <td class="val">100</td> -->
                <?php 
                if ($fa=="Withdrawal ") {

                 $totsavings =$totsavings - $save->Amount;
               }else{

                 $totsavings =$totsavings + $save->Amount;
               }

               ?>
               <td class="val"><?php echo $totsavings; ?></td>
               <?php if ($fa=="Withdrawal ") { ?>
               <td class="val">WL</td>	
               <?php } elseif ($fa=="Savings") { ?>
               <td class="val">DP</td>	
               <?php }?>


               <td class="val"><?php echo $save->Name ;?></td>


             </tr>	

             <?php } ?>


           </table>
           <br><br><br><br>
           <div>
             <!-- <label>TRANSACTION CODE TABLE:</label> -->
             <table style="table-collapse: collapse;">
              <tr  class='t'>
               <td colspan='2' style="font-size:12px;">TRANSACTION CODE TABLE:</td>
             </tr>
             <tr class="t">
               <th style="font-size:12px; width: 80px;">CODE</th>
               <th style="font-size:12px;width: 200px;">DESCRIPTION</th>
             </tr>
             <tr>
               <td style="font-size:12px; text-align: center">DP</td>
               <td style="font-size:12px; text-indent: 7px;">Deposit-Cash</td>
             </tr>

             <tr>
               <td style="font-size:12px; text-align: center">WL</th>
                 <td style="font-size:12px; text-indent: 7px;">Withdrawal- Cash</td>
               </tr>

               <tr>
                 <td style="font-size:12px; text-align: center">IE</td>
                 <td style="font-size:12px; text-indent: 7px;">Interest Earned</td>
               </tr>
             </table>
           </div>

         </div>
         <br><br>
       </div>
     </div>
     <!-------------------->
			<!---------PERFORMANCE----------->
			<!-------------------->

			

			<div id="divperformance" style="display: none;"><div class="BG">
       <br><br>

       <div class = "personalinfo">

         <div class="headername">Over-all Performance</div>
         <div class="skew"></div>
         <br>

         <br>
         <p class="info">Total Amount of Capital Shares: <b>Php <?php echo $pdtotalShare ?></b> </p>
         <p class="info">Number of Loan Cycle: <b><?php echo $pdloanCount ?></b> </p>
         <p class="info">Overall Percentage of Past Due: <b><?php echo $pdpercent."% " ?>
          <?php 
          
            if($pdpercent<=5) echo "EXCELLENT MEMBER";
            else if($pdpercent <=10 AND $pdpercent>5) echo "Very Good Member";
            else if($pdpercent<=20 AND $pdpercent>10) echo "Good Member";
            else echo "Poor Member";
            ?>

          </b> </p>
          <p class="info">Accumulated no. of Past Due: <b><?php echo $pdtotalPastDue." Past Dues Out of ".$pdtotalLoanTrans." Loan Transactions" ?></b> </p>

          <br>

          <p style="text-align:center; font-size: 13px; color:#696666; margin-right: 50px;"><b>Number of Past Due in accordance to amount loaned</p>

          <table class="perfass3">
            <tr class="nohover">
             <th rowspan="2" class="bordr" style="width: 200px" >AMOUNT</th>
             <th colspan ="2" class="bordr">NO. OF PAST DUE</th>
             <th rowspan="2" class="bordr" style="width: 200px" >Past Due <br> Percent</th>
           </tr>

           <tr class="nohover">
            <td class="wk" style="width: 150px"> 23 Week</td>
            <td class="wk" style="width: 150px"> 40 Week</td>
          </tr>

          <tr class="hoverthis">
           <td class="sbu">4,000 and Less</td>
           <td class="sbu"> <?php echo $pd23a ?> </td>
           <td class="sbu"> <?php echo $pd40a ?> </td>
           <td class="sbu"> <?php echo $pdpercenta ?>%</td>
         </tr>
         <tr class="hoverthis">
           <td class="sbu">4,001 - 8,000</td>
           <td class="sbu"> <?php echo $pd23b ?> </td>
           <td class="sbu"> <?php echo $pd40b ?> </td>
           <td class="sbu"> <?php echo $pdpercentb ?>%</td>
         </tr>
         <tr class="hoverthis">
           <td class="sbu">8,001 - 16,000</td>
           <td class="sbu"> <?php echo $pd23c ?> </td>
           <td class="sbu"> <?php echo $pd40c ?> </td>
           <td class="sbu"> <?php echo $pdpercentc ?>%</td>
         </tr>
         <tr class="hoverthis">
           <td class="sbu">16,001 - 32,000</td>
           <td class="sbu"> <?php echo $pd23d ?> </td>
           <td class="sbu"> <?php echo $pd40d ?> </td>
           <td class="sbu"> <?php echo $pdpercentd ?>%</td>
         </tr>
         <tr class="hoverthis">
           <td class="sbu">32,001 Above</td>
           <td class="sbu"> <?php echo $pd23e ?> </td>
           <td class="sbu"> <?php echo $pd40e ?> </td>
           <td class="sbu"> <?php echo $pdpercente ?>%</td>
         </tr>							

       </table>

       <br><br>

       <div class="innerinfo">
         <p>
          The Member has a total of <?php echo "Php ".$pdtotalShare ?> worth share as of <?php echo date('F d, Y') ?>. Also, the member shows a <?php echo $pdpercent ?>% of commiting a past due from his overall loans.
        </p>
      </div>
				    	<!-- 	COMMENTS 
				    	<h2 style='color:red'>note here (A BOX PARANG ALERT) -> this box will only appear kung nagaapply ng new loan</h2>-->
            </div>

				<!-- <div class = "personalinfo">

					<div class="headername">Capital Share: <b><?php // echo $totalShare ?></b> Php</div>
						<div class="skew"></div>
					<br>

					<br>
					<table class="perfass2">
            <tr class="nohover">
              <th>Date</th>
              <th>Application No.</th>
              <th>Capital Share</th>
            </tr>
 
            <?php // foreach ($getCapitalShare->result() as $row) { ?>
            <tr class="hoverthis">
              <td class="sbu"><?php // echo date('F d, Y',strtotime($row->Date)) ?></td>
              <td class="sbu"><?php // echo $row->ApplicationNumber ?></td>
              <td class="sbu"> <?php // echo $row->CapitalShare ?></td>
            </tr>          
          <?php // } ?>
          </table>
				    

				    <br>
          </div> -->
          <?php if (!empty($hasloan)) { ?>


          <div class = "personalinfo">

           <div class="headername">Loan Collection as of <?php echo date("Y/m/d") ?> </div>
           <div class="skew"></div>

           <br>
           <?php $this->session->set_userdata('controlno', $control_no); ?>
           <?php $this->session->set_userdata('request', 1); ?>
           <iframe src="<?php echo base_url('general/loancollectionpiechart') ?>"  frameBorder="0" class="frame"></iframe>

           <br>
         </div>
         <?php } ?>

         <div class = "personalinfo">

           <div class="headername"><?php if (!empty($hasloan)) { ?> LOAN & <?php } ?> SAVINGS PROGRESS</div>
           <div class="subskew"></div>
           <br><br>
           <?php if (!empty($hasloan)) { ?>
           <iframe src="<?php echo base_url('general/loanperformance') ?>" width="900px;" height="600px;" frameBorder="0" scrolling="no"></iframe>
           <?php } ?>
           <br>
           <iframe src="<?php echo base_url('general/savingsperformance') ?>"  width="900px;" height="600px;" frameBorder="0" scrolling="no"></iframe>



					<!--<table class="perfass">
						<tr class="nohover">
							<th class="bordr" style="width: 100px;" >WEEK NO.</th>
							<th class="bordr" style="width: 150px;">DATE </th>
							<th class="bordr" style="width: 170px;">LOAN</th>
							<th class="bordr" style="width: 180px;">SAVINGS BUILD-UP </th>
							<th class="bordr" style="width: 170px;">WITHDRAWALS </th>
							<th class="bordr" style="width: 170px;">LOAN REMAINING</th>
						</tr>

						
						<tr class="hoverthis">
							<td class="wk1"> 1 </td>
							<td class="wk1"> July 23, 2014 </td>
							<td class="wk1"> 200 </td>
							<td class="wk1"> 50 </td>
							<td class="wk1"> - </td>
							<td class="wk1"> 4000 </td>
						</tr>-->

            <!-------------------------------------------->

          </table>

        </div>

	<!--			<div class = "personalinfo">

					<div class="subheadername">Violations</div>
						<div class="subskew"></div>
					<br>

					<br> -->
         <!---LIST OF VIOLATIONS -->
		<!--				<ul class="affiliatedOrgs">
							
							<li>You are cleared!</li>
							<li> <h1 style='color:red'>WHAT WOULD BE THE DETAILS HERE?</h1> </li>
							
						</ul>
				    

				    <br>
          </div> -->

	<!--			<div class = "personalinfo">

					<div class="subheadername">Overview</div>
						<div class="subskew"></div>
					<br>

					<br>
					<p class="info">Insert note here..</p>
								    

				    <br>
          </div> -->

          <div class = "personalinfo">

           <div class="headername">Savings Summary As Of <?php echo date("Y/m/d") ?></div>
           <div class="subskew"></div>
           <br>




           <?php $savings = $this->db->query("SELECT m.savings, m.ControlNo FROM  members m WHERE m.ControlNo = '$control_no' "); 

           foreach($savings->result() as $save){

            $actual = $save->savings;


          }

          $date = $this->db->query("SELECT TIMESTAMPDIFF(WEEK,(SELECT DateEntered FROM CaritasCenters_has_Members cm, Members m WHERE cm.Members_ControlNo='$control_no' AND cm.Members_ControlNo = m.ControlNo),NOW()) AS diff");

          foreach($date->result() as $dt){

           $diff = $dt->diff;

         }

         $expected = $diff*50;
         ?>



         <p class="info00">Actual Amount of Savings: P<b> <?php echo number_format($actual, 2);?></b></p>
         <p class="info00">Expected Amount of Savings: P<b> <?php echo number_format($expected, 2);?></b></p>

         <br>




         <div class="innerinfo">
          <p class="info01">
            <?php 
            if(!$actual ==0){
              if ($actual < $expected){
                $kulang = $expected-$actual;
                echo 'This member needs to save P'.number_format($kulang, 2).' more! ';

              } else{

                echo ' The savings deposited in the account of the member has met 
                the expected amount of savings! ';
              }
            }
            ?>


          </p>
        </div>



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