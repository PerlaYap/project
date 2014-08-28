
<?php 
  $branchno = $this->session->userdata('branchno');
  $branchname = $this->session->userdata('branch');
  date_default_timezone_set('Asia/Manila');
  
    $datetoday = date('F d, Y');
    $day = date('l');
    $currentmonth = date("m");
    $currentyear = date('Y');
    $m = date('F');


$targetactual = $this->db->query("SELECT sum(collected) as actual, sum(amounttopay) as target, CaritasCenters_ControlNo, CenterNo FROM (SELECT t.`LoanAppControlNo`,sum(t.`Amount`) as collected,t.`Members_ControlNo`,t.`DateTime`,  ((l.AmountRequested+l.interest)/l.loantype*4)as amounttopay, l.Status, l.LoanType ,cm.CaritasCenters_ControlNo FROM `transaction` t join `loanapplication` l on `LoanAppControlNo` = l.controlno join `caritascenters_has_members`cm on cm.Members_ControlNo = t.Members_ControlNo
where `TransactionType` = 'Loan' and month(`DateTime`) =$currentmonth and year(`DateTime`)=$currentyear and cm.CaritasCenters_ControlNo in (SELECT CaritasCenters_ControlNo FROM `caritasbranch_has_caritascenters` WHERE `CaritasBranch_ControlNo` = $branchno) group by LoanAppControlNo order by LoanAppControlNo)x join caritascenters cc on x.CaritasCenters_ControlNo = cc.ControlNo
group by CaritasCenters_ControlNo");

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
            ['<?php echo $rec->CenterNo ?>',  <?php echo $rec->target ?>, <?php echo $rec->actual ?>],  
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
  </body>
</html>