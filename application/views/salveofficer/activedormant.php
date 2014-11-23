<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/tables.css'); ?>">


<?php 
$branchno = $this->session->userdata('branchno');
$userrank = $this->session->userdata('rank');

date_default_timezone_set('Asia/Manila');

$datetoday = date('F d, Y');
$day = date('l');
$currentmonth = strtoupper(date("F"));
$currentyear = date('Y');

$month = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec");

?>
<html>
<head>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
  
  var data = google.visualization.arrayToDataTable([
      ['Month', 'Active Saver', 'Dormant Saver', 'Borrower', 'Past Due Mature'],
      <?php
        for($a=0; $a<12; $a++){
          $date=$currentyear."-".($a+1)."-"."01";
          $borrower = $this->db->query("SELECT COUNT(MemberControl) AS NoActive FROM (SELECT Members_ControlNo AS MemberControl FROM (SELECT A.Members_ControlNo, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
                                      ON A.Members_ControlNo=B.Members_ControlNo)A
                                      LEFT JOIN (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
                                      ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)B
                                      ON A.CenterControl=B.CenterControl
                                      WHERE BranchControl='$branchno') Alpha
                                      LEFT JOIN (SELECT A.ControlNo FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('2014-11-11', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
                                      ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='Borrower')Beta
                                      ON Alpha.MemberControl=Beta.ControlNo
                                      WHERE ControlNo IS NOT NULL");
         $past = $this->db->query("SELECT COUNT(MemberControl) AS NoActive FROM (SELECT Members_ControlNo AS MemberControl FROM (SELECT A.Members_ControlNo, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
                                      ON A.Members_ControlNo=B.Members_ControlNo)A
                                      LEFT JOIN (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
                                      ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)B
                                      ON A.CenterControl=B.CenterControl
                                      WHERE BranchControl='$branchno') Alpha
                                      LEFT JOIN (SELECT A.ControlNo FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('2014-11-11', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
                                      ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='Past Due')Beta
                                      ON Alpha.MemberControl=Beta.ControlNo
                                      WHERE ControlNo IS NOT NULL");
          $dormant = $this->db->query("SELECT COUNT(MemberControl) AS NoActive FROM (SELECT Members_ControlNo AS MemberControl FROM (SELECT A.Members_ControlNo, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
                                      ON A.Members_ControlNo=B.Members_ControlNo)A
                                      LEFT JOIN (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
                                      ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)B
                                      ON A.CenterControl=B.CenterControl
                                      WHERE BranchControl='$branchno') Alpha
                                      LEFT JOIN (SELECT A.ControlNo FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('2014-11-11', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
                                      ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='dormant saver')Beta
                                      ON Alpha.MemberControl=Beta.ControlNo
                                      WHERE ControlNo IS NOT NULL");
          $activeSaver = $this->db->query("SELECT COUNT(MemberControl) AS NoActive FROM (SELECT Members_ControlNo AS MemberControl FROM (SELECT A.Members_ControlNo, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
                                      ON A.Members_ControlNo=B.Members_ControlNo)A
                                      LEFT JOIN (SELECT A.CaritasCenters_ControlNo AS CenterControl, CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
                                      ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)B
                                      ON A.CenterControl=B.CenterControl
                                      WHERE BranchControl='$branchno') Alpha
                                      LEFT JOIN (SELECT A.ControlNo FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
                                      LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('2014-11-11', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
                                      ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='Active Saver')Beta
                                      ON Alpha.MemberControl=Beta.ControlNo
                                      WHERE ControlNo IS NOT NULL");
       
          foreach($borrower->result() as $data){
            $count=$data->NoActive;
          }
          foreach($past->result() as $data1){
            $count1=$data1->NoActive;
          }
          foreach($dormant->result() as $data2){
            $count2=$data2->NoActive;
          }
          foreach($activeSaver->result() as $data2){
            $count3=$data2->NoActive;
          }
          ?>
          ['<?php echo $month[$a]; ?>', <?php echo $count3; ?>,<?php echo $count2; ?>, <?php echo $count; ?>,<?php echo $count1; ?>],
        <?php }
        ?>
              ]);

    var options = {
      title: 'Comparison of Accounts for the Year <?php echo $currentyear ?> ',
      hAxis: {slantedText:true, slantedTextAngle:45, title: 'MONTH', titleTextStyle: {color: 'black', italic: false, bold: true} },
      vAxis: {title: 'NO. OF ACCOUNTS', titleTextStyle: {color: 'black', italic: false,  bold: true}},
      backgroundColor: 'transparent',
      colors:['#2795be', '#FFA500','#00b200', '#a63923' ],


        //if salve officer
        <?php if($userrank=='salveofficer') :?>
        'width':930,
        'height':400,
        <?php endif;?>

        //if BM
        <?php if($userrank=='branchmanager') :?>
        'width':590,
        'height':280,
        <?php endif;?>

        annotations: {
          textStyle: {
            fontName: 'Times-Roman',
            fontSize: 18,
            bold: true,
            italic: true,
              color: '#871b47',     // The color of the text.
              auraColor: '#d799ae', // The color of the text outline.
              opacity: 0.8          // The transparency of the text.
            }
          },
          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      </script>
    </head>
    <body>

      <!--IF salve officer -->
      <?php if($userrank=='salveofficer') :?>
      <div id="chart_div" style="width: 900px; height: 500px;" ></div>


        <script type="text/javascript">
            function openWin() {
              myWindow = window.open("accountstable", "myWindow", "width=800, height=500");    // Opens a new window
            }
        </script>

      <input type="button" onclick="openWin()" class="table"/>
    <?php endif;?>

    <!-- If BM ---->
    <?php if($userrank=='branchmanager') :?>
    <div id="chart_div" style="width: 700px; height: 300px;" ></div>


       <script type="text/javascript">
            function openWin() {
              myWindow = window.open("accountstable", "myWindow", "width=800, height=500");    // Opens a new window
            }
        </script>

    <input type="button" onclick="openWin()" class="table1"/>
    <p style="position:absolute; font-family:Calibri, sans-serif; font-size: 12px; margin-left: 520px;margin-top:-100px; "> See Table</p>
  <?php endif;?>
</body>
</html>



