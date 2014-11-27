<style type="text/css" media="print">
  .dontprint{
    display: none;
  }

  @page { 
    size: Landscape;
    margin: 1 in;
  }
</style>

<?php 
$n = $this->session->userdata('branchno');
$user = $this->session->userdata('firstname');
$control_no =$n;

date_default_timezone_set('Asia/Manila');

    $currentmonth = strtoupper(date("F"));
    $currentyear = date('Y');
    $datetoday1 = date('F d, Y');
    $datetoday=date('Y-m-d');
    $branch = strtoupper($this->session->userdata('branch'));
      $userrank = $this->session->userdata('rank');
  $name = $this->session->userdata('firstname');
   $datetoday2 = date('F d, Y');

    $memberNo=$this->db->query("SELECT Charlie.CenterControl AS CenterControl, CenterNo, SUM(Status='Borrower') AS Borrower, SUM(Status='Active Saver') AS Saver
FROM (SELECT MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo AS MemberControl FROM CaritasCenters_has_Members GROUP BY Members_ControlNo ORDER BY Members_ControlNo ASC)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members WHERE DateEntered<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.MemberControl=B.Members_ControlNo)Alpha
LEFT JOIN
(SELECT A.ControlNo AS MemberControl, Status FROM (SELECT ControlNo FROM members_has_membersmembershipstatus GROUP BY ControlNo ORDER BY ControlNo ASC)A
LEFT JOIN (SELECT * FROM (SELECT * FROM members_has_membersmembershipstatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)A GROUP BY ControlNo)B
ON A.COntrolNo=B.ControlNo)Beta
ON Alpha.MemberControl=Beta.MemberControl
LEFT JOIN
(SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl, CenterNo FROM 
(SELECT CaritasCenters_ControlNo 
FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo ORDER BY CaritasCenters_ControlNo ASC)A
LEFT JOIN (SELECT * FROM 
(SELECT * FROM CaritasBranch_has_CaritasCenters WHERE Date<=LAST_DAY(DATE_ADD('$datetoday', INTERVAL 0 MONTH))
ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo
LEFT JOIN CaritasCenters cc ON cc.ControlNo=A.CaritasCenters_ControlNo)Charlie
ON Alpha.CenterControl=Charlie.CenterControl
WHERE BranchControl='$control_no' AND (Status='Borrower' OR Status='Active Saver')
GROUP BY Charlie.CenterControl");

 ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
 <!-- <link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css">  -->


<head>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Center', 'Borrower', 'Saver'],
          <?php foreach ($memberNo->result() as $mem) { ?>

          ['<?php echo $mem->CenterNo ?>', <?php echo $mem->Borrower ?>,<?php echo $mem->Saver ?>],
          <?php } ?>
        ]);

        var options = {
         // title: 'Target vs. Actual of All Centers in Paco Branch for the Month of July',
          hAxis: {title: 'BRANCH or CENTER', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'NO. OF MEMBERS', titleTextStyle: {color: 'black', italic: false,  bold: true}},
          backgroundColor: 'transparent',
          colors:['9c9e9c','#a63923' ],
          'width':1000,
          'height':500,
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

</head>


<body>
  <a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
  
  <h3>
    CARITAS SALVE CREDIT COOPERATIVE <br> 
    NUMBER OF BORROWERS AND SAVERS <br> 
    IN <?php echo $branch ?> BRANCH <br> AS OF THE END OF <?php echo $currentmonth." ".$currentyear ?></b>

  </h3>

    <div id="chart_div" style="width: 1300px; height: 500px; margin-left:160PX;; margin-right: auto;"></div>

    <br>
   
    <style type="text/css">
      .hdrx{
        padding: 5px 15px 5px 15px;
        font-weight: bold;
        font-size: 15px;s
      }
    </style>

    <table border=1 style="border-collapse: collapse; margin-left: auto; margin-right: auto">
      <tr>
          <td class='hdrx'>CENTER</td>
          <td class='hdrx'>NO. OF BORROWERS</td>
          <td class='hdrx'>NO. OF SAVERS</td>
      </tr>
      <?php
      foreach($memberNo->result() AS $data){ ?>
      <tr>
          <td class='hdrtxt'><?php echo $data->CenterNo; ?></td>
          <td class='hdrtxt'><?php echo $data->Borrower; ?></td>
          <td class='hdrtxt'><?php echo $data->Saver; ?></td>
      </tr>
      <?php } ?>

    </table>


    <br><br>

   <!-- <table class="signature" style="margin-left:auto; margin-right:auto;">
      <tr>
        <td class="sigBy">Prepared by:</td>
        <td class="sig"><?php echo $user ?></td>
        <td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
        <td class="sig2"><?php echo $datetoday1; ?></td>
      </tr>
    </table>
    <br>
    <table class="signature"  style="margin-left:auto; margin-right:auto;">
      <tr>
        <td class="sigBy">Received by:</td>
        <td class="sig">&nbsp</td>
        <td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
        <td class="sig2">&nbsp</td>
      </tr>
    </table>-->

    <table style="margin-left: 140px;" >
      <tr>
        <td class="BM1" style="font-size: 13px;"><?php echo $name; ?></td>
      </tr>
        <?php if($userrank=='branchmanager'){?>
      <tr>
        <td class="BM2">Signature Above Printed Name of Branch Manager</td>
      </tr>
      <?php }else{ ?>
      <tr>
        <td class="BM2">Signature Above Printed Name of Salve Officer</td>
      </tr>
      <?php } ?>
      <tr>
        <td class="BM1" style="font-size: 13px;"><?php echo $datetoday2 ?></td>
      </tr>
      <tr>
        
        <td class="BM2">Date</td>
      </tr>
    </table>

    <table style="margin-left: 6000px; margin-top: -207px;" >
      <tr>
        <td class="BM1" style="font-size: 13px;">Marvin Lao</td>
      </tr>
      <tr>
        <td class="BM2">Signature Above Printed Name of MIS</td>
      </tr>
      <tr>
        <td class="BM1" style="font-size: 13px;"><?php echo $datetoday2 ?></td>
      </tr>
      <tr>
        <td class="BM2">Date</td>
      </tr>
    </table>



    <br><br>
  <div style="width: 100%; text-align: center;">
    <button onclick="window.print()" class="dontprint">Print</button> 
  </div>
</body>