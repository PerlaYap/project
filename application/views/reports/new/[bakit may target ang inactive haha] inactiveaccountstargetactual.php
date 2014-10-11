<TITLE> MEMBER PERFORMANCE COMPARISON</TITLE>

<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>" -->
 <link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css">  


<head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Actual', 'Target'],
          ['JAN',  200, 250 ],
          ['FEB',  280, 300],
          ['MAR',  340, 400],
          ['APR',  350, 660],
          ['MAY',  400, 700],
          ['JUN',  410, 700],
          ['JUL',  430, 720],
          ['AUG',  500, 800],
          ['SEPT',  550, 830],
          ['OCT',  600, 980],
          ['NOV',  650, 1000],
          ['DEC',  860, 1100]
        ]);

        var options = {
          colors:['#2795be', '#989a98' ],
          hAxis: {title: 'MONTH', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'NO. OF INACTIVE ACCOUNTS', titleTextStyle: {color: 'black', italic: false,  bold: true}},
          'width':1300,
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>
  </head>



<body>
	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		ACTUAL VS. TARGET INACTIVE ACCOUNTS <br>
    OF PACO BRANCH CENTER 3 <br>
		AS OF SEPTEMBER 29, 2014
	</h3>

    <div id="chart_div" style="width: 900px; height: 500px;"></div>


    <br>
  <!--  <table class="signature" style="margin-left:auto; margin-right:auto;">
      <tr>
        <td class="sigBy">Prepared by:</td>
        <td class="sig"><?php echo $user; ?></td>
        <td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
        <td class="sig2"><?php echo $datetoday; ?></td>
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
    </table>
  -->
    <br><br>
	<div style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 
	</div>
</body>