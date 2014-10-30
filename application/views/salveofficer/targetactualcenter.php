<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/tables.css'); ?>">

<html>
<?php
$branchno = $this->session->userdata('branchno');
$userrank = $this->session->userdata('rank');

$collection=$this->db->query("SELECT CenterNo, SUM(Target) AS Target, SUM(IF(CurrentAmount<Target, CurrentAmount, Target)) AS ActualReceive, SUM(IF(Collection-Target-LastAmount<0, 0, IF(CurrentAmount<=Target,0, IF(CurrentAmount>=Collection-LastAmount, Collection-Target-LastAmount, CurrentAmount-Target)))) AS PastDue,
SUM(IF(CurrentAmount+LastAmount<Collection,0, CurrentAmount+LastAmount-Collection)) AS Advance  FROM
(SELECT CurrentTotal.ControlNo, TRUNCATE(WeeklyPayment*TodayMonth,2) AS Collection, MonthlyPayment AS Target, TRUNCATE(IFNULL(LastAmount,0),2) AS LastAmount,
TRUNCATE(IFNULL(CurrentAmount,0),2) AS CurrentAmount
FROM (SELECT ControlNo, WeeklyPayment, IF(LoanType='23-Weeks',IF(TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)>23,23,TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)), IF(TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)>40,40,TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0))) AS TodayMonth
FROM (SELECT ControlNo, DateReleased, DateEnd, LoanType, WeeklyPayment, 
ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month(NOW()) AND YEAR(DateEnd)=YEAR(NOW()),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment
FROM 
(SELECT (AmountRequested+Interest) AS ActiveLoan, ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
FROM loanapplication 
WHERE (Status='Current' OR Status='Full Payment') AND 
(CAST(DATE_FORMAT(NOW() ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<=NOW() 
AND NOW()<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha)Alpha)CurrentTotal
LEFT JOIN
(SELECT ControlNo,
ROUND(((TRUNCATE(DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL 0 MONTH)),DateReleased)/7,0)-TRUNCATE((IF(Month(DateEnd)=Month(NOW()) AND YEAR(DateEnd)=YEAR(NOW()),DATEDIFF(DateEnd,DateReleased)/7,DATEDIFF(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),DateReleased)/7)),0))* WeeklyPayment),2) AS MonthlyPayment
FROM 
(SELECT ControlNo, IF(LoanType='23-Weeks',(AmountRequested+Interest)/23, (AmountRequested+Interest)/40) AS WeeklyPayment, LoanType, DateReleased, 
DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH) AS DateEnd
FROM loanapplication 
WHERE (Status='Current' OR Status='Full Payment') AND 
(CAST(DATE_FORMAT(NOW() ,CONCAT(YEAR(DateReleased),'-',MONTH(DateReleased),'-01')) as DATE)<=NOW() 
AND NOW()<=LAST_DAY(DATE_ADD((IF(LoanType='23-Weeks', DATE_ADD(DateReleased, INTERVAL 161 DAY), DATE_ADD(DateReleased,INTERVAL 280 DAY))), INTERVAL 0 MONTH))))Alpha)TargetCollection
ON CurrentTotal.ControlNo=TargetCollection.ControlNo
LEFT JOIN
(SELECT LoanAppControlNo, SUM(Amount) AS LastAmount FROM Transaction 
WHERE TransactionType='Loan' AND DateTime<=LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)) GROUP BY LoanAppControlNo)LastCollection
ON CurrentTotal.ControlNo=LastCollection.LoanAppControlNo
LEFT JOIN 
(SELECT LoanAppControlNo, SUM(Amount) AS CurrentAmount FROM Transaction 
WHERE TransactionType='Loan' AND MONTH(DateTime)=MONTH(NOW()) AND YEAR(DateTime)=YEAR(NOW())
GROUP BY LoanAppControlNo)CurrentCollection
ON CurrentTotal.ControlNo=CurrentCollection.LoanAppControlNo)Alpha
LEFT JOIN (SELECT LoanApplication_ControlNo AS LoanControl, CaritasBranch_ControlNo AS BranchControl, CenterNo FROM loanapplication_has_members lhm
LEFT JOIN
(SELECT A.Members_ControlNo, CenterNo FROM (SELECT Members_ControlNo FROM caritascenters_has_members GROUP BY Members_ControlNo)A
LEFT JOIN (SELECT * FROM (SELECT * FROM caritascenters_has_members ORDER BY Members_ControlNo ASC, DateEntered DESC)A GROUP BY Members_ControlNo)B
ON A.Members_ControlNo=B.Members_ControlNo
LEFT JOIN caritascenters cc ON B.CaritasCenters_ControlNo=cc.ControlNo)cc
ON lhm.Members_ControlNo=cc.Members_ControlNo)Beta
ON Alpha.ControlNo=Beta.LoanControl WHERE BranchControl='$branchno' GROUP BY CenterNo");
?>

  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Year', 'Target', 'On-Time', 'Past Due', 'Advance'],
          <?php foreach($collection->result() AS $data){ ?>
          ['<?php echo $data->CenterNo ?>', <?php echo $data->Target ?>,<?php echo $data->ActualReceive ?>, <?php echo $data->PastDue ?>, <?php echo $data->Advance ?>,],
          <?php } ?>
       ]);

        var options = {
          title: 'Comparison of Center Performances',
          hAxis: {title: 'Year', titleTextStyle: {color: 'red'}},
          backgroundColor: 'transparent',
          'width':940,
          'height':400,
          hAxis: {title: 'CENTER', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'LOAN COLLECTION', titleTextStyle: {color: 'black', italic: false,  bold: true}},
          bar: { groupWidth: '50%' },
          colors:['d2ca4c','419fb3', 'b34141','a8a6a6' ],

          
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

    <input type="button" onclick="openWin()" class="table" />

  </body>


</html>
