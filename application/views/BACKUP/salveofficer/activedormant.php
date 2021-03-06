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
      ['Month', 'Active','Past Due Mature', 'Dormant Saver'],
      <?php
        for($a=0; $a<12; $a++){
          $date=$currentyear."-".($a+1)."-"."01";
          $active = $this->db->query("SELECT COUNT(A.ControlNo) AS NoActive  FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
                                    LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
                                    ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily' AND Status!='Past Due' AND Status!='dormant saver')");
          $past = $this->db->query("SELECT COUNT(A.ControlNo) AS NoActive  FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH))  ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='Past Due'");
          $dormant = $this->db->query("SELECT COUNT(A.ControlNo) AS NoActive  FROM (SELECT ControlNo FROM Members_has_MembersMembershipStatus GROUP BY ControlNo)A
                                    LEFT JOIN (SELECT * FROM (SELECT * FROM Members_has_MembersMembershipStatus WHERE DateUpdated<=LAST_DAY(DATE_ADD('$date', INTERVAL 0 MONTH)) ORDER BY ControlNo ASC, DateUpdated DESC)B GROUP BY ControlNo)C
                                    ON A.ControlNo=C.ControlNo WHERE (Status!='Terminated' AND Status!='Terminated Voluntarily') AND Status='dormant saver'");
          
          foreach($active->result() as $data){
            $count=$data->NoActive;
          }
          foreach($past->result() as $data1){
            $count1=$data1->NoActive;
          }
          foreach($dormant->result() as $data2){
            $count2=$data2->NoActive;
          }
          ?>
          ['<?php echo $month[$a]; ?>', <?php echo $count; ?>,<?php echo $count1; ?>, <?php echo $count2; ?>],
        <?php }
        ?>
              ]);

    var options = {
      title: 'Comparison of Accounts for the Year <?php echo $currentyear ?> ',
      hAxis: {title: 'MONTH', titleTextStyle: {color: 'black', italic: false, bold: true}},
      vAxis: {title: 'NO. OF ACCOUNTS', titleTextStyle: {color: 'black', italic: false,  bold: true}},
      backgroundColor: 'transparent',
      colors:['#2795be','#a63923', '#FFA500' ],

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

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
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



