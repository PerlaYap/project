
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/tables.css'); ?>">
<?php 
  $branchno = $this->session->userdata('branchno');
  $branchname = $this->session->userdata('branch');
  date_default_timezone_set('Asia/Manila');
  
    $datetoday = date('F d, Y');
    $day = date('l');
    $currentmonth = date("m");
    $currentyear = date('Y');
    $m = date('F');


$targetactual = $this->db->query("SELECT BigOne.CenterControl, CenterNo, Target, Actual FROM 
(SELECT CenterControl, CenterNo, IFNULL(SUM(MonthlyPayment),0) AS Target FROM (SELECT MemberControl, Alpha.CenterControl, BranchControl, CenterNo FROM (SELECT A.Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo ORDER BY Members_ControlNo ASC)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members WHERE DateEntered<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.Members_ControlNo=B.Members_ControlNo)Alpha
LEFT JOIN
(SELECT A.CaritasCenters_ControlNo AS CenterControl, B.CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters WHERE Date<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)Beta
ON Alpha.CenterControl=Beta.CenterControl
LEFT JOIN CaritasCenters cc ON cc.ControlNo=Alpha.CenterControl)Alpha
LEFT JOIN
(SELECT ControlNo, DateReleased, DateEnd,
ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month(NOW()) AND YEAR(DateEnd)=YEAR(NOW()),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment,
Members_ControlNo
FROM 
(SELECT ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
FROM loanapplication 
WHERE (Status='Current' OR Status='Full Payment') AND 
(CAST(DATE_FORMAT(NOW() ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<=NOW() 
AND NOW()<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha
LEFT JOIN loanapplication_has_members lhm ON lhm.LoanApplication_ControlNo=Alpha.ControlNo)Beta
ON Alpha.MemberControl=Beta.Members_ControlNo
WHERE BranchControl='$branchno' GROUP BY CenterControl)BigOne
LEFT JOIN
(SELECT CenterControl, IFNULL(SUM(Amount),0) AS Actual FROM (SELECT MemberControl, Alpha.CenterControl, BranchControl FROM (SELECT A.Members_ControlNo AS MemberControl, CaritasCenters_ControlNo AS CenterControl FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo ORDER BY Members_ControlNo ASC)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members WHERE DateEntered<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.Members_ControlNo=B.Members_ControlNo)Alpha
LEFT JOIN
(SELECT A.CaritasCenters_ControlNo AS CenterControl, B.CaritasBranch_ControlNo AS BranchControl FROM (SELECT CaritasCenters_ControlNo FROM caritasbranch_has_caritascenters GROUP BY CaritasCenters_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritasbranch_has_caritascenters WHERE Date<LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)) ORDER BY CaritasCenters_ControlNo ASC, Date DESC)A GROUP BY CaritasCenters_ControlNo)B
ON A.CaritasCenters_ControlNo=B.CaritasCenters_ControlNo)Beta
ON Alpha.CenterControl=Beta.CenterControl
LEFT JOIN CaritasCenters cc ON cc.ControlNo=Alpha.CenterControl)Alpha
LEFT JOIN
(SELECT Members_ControlNo AS MemberControl, SUM(Amount) AS Amount 
FROM Transaction WHERE (TransactionType='Loan' OR TransactionType='Past Due') 
AND (MONTH(DateTime)=MONTH(NOW()) AND YEAR(DateTime)=YEAR(NOW())) GROUP BY Members_ControlNo)Beta
ON Alpha.MemberControl=Beta.MemberControl WHERE BranchControl='$branchno' GROUP BY CenterControl)BigTwo
ON BigOne.CenterControl=BigTwo.CenterControl");

 ?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Center', 'Target', 'Actual'],
          <?php foreach ($targetactual->result() as $rec) { ?>
            ['<?php echo $rec->CenterNo ?>',  <?php echo $rec->Target ?>, <?php echo $rec->Actual ?>],  
          <?php } ?>
          
          
        ]);

        var options = {
          title: 'Target vs. Actual of All Centers in <?php echo $branchname ?> Branch for the Month of <?php echo $m ?>',
          hAxis: {title: 'CENTER', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'LOAN COLLECTION', titleTextStyle: {color: 'black', italic: false,  bold: true}},
          backgroundColor: 'transparent',
          colors:['9c9e9c','#a63923' ],
          'width':940,
          'height':400,
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
     <script type="text/javascript">
            function openWin() {
              myWindow = window.open("targettable", "myWindow", "width=800, height=500");    // Opens a new window
            }
        </script>

    <input type="button" onclick="openWin()" class="table1"/>
  </body>
</html>