<?php 
     $n = $this->session->userdata('controlno');
     $control_no =$n;

     $savings = $this->db->query("SELECT t.LoanAppControlNo, t.Amount, t.DateTime, t.Members_ControlNo, t.TransactionType FROM `transaction` t where t.TransactionType = 'Savings' and t.Members_ControlNo = $control_no ORDER BY `t`.`DateTime` ASC");
 ?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Savings'],
          <?php foreach ($savings->result() as $s) { ?>
            ['<?php echo $s->DateTime ?>',  <?php echo $s->Amount ?>],  
          <?php } ?>
        ]);

        var options = {
          title: 'Current Savings Performance',
          hAxis: {title: 'DATE', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'SAVINGS AMOUNT', titleTextStyle: {color: 'black', italic: false,  bold: true}},
          backgroundColor: 'transparent',
          'width':900,
          'height':500,
          colors:['#162953'],
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
          }

        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px; overflow: auto;"></div>
  </body>
</html>