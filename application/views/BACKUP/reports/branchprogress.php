<title>Daily Collection Sheet</title>
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">-->
	
<link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css">

	
<!-- 	<img src="../../../Assets/images/caritaslogo.png" class="caritaslogo"> -->
<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		PACO BRANCH PROGRESS <br>
		For the Month of July 2014
	</h3>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Type', 'No. of Borrowers', { role: 'style' }],
          ['Active Savers',  1000, '#327a9c'],
          ['Dormant',  1170, '#727475'],
          ['Borrowers',  660, '#1c7936'],
          ['Past Due Matured',  1030, '#9b4343']
        ]);

        var options = {
          //title: 'Company Performance',
          backgroundColor: 'transparent',
          'colors': ['#cec5c5', '#327e3e','#a23232' ],
          legend: { position: "none" },
          hAxis: {title: 'No. of Members', titleTextStyle: {color: 'black', italic: false, bold: true}},
          
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  
  
    <div id="chart_div" style="width: 900px; height: 500px; margin-left: auto; margin-right: auto;"></div>
    <br>
    <table class="signature" style="margin-left:auto; margin-right:auto;">
      <tr>
        <td class="sigBy">Prepared by:</td>
        <td class="sig">&nbsp</td>
        <td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
        <td class="sig2">&nbsp</td>
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
    <br><br><br>
	<div style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button>
	</div>