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
          ['Month', 'Accounts'],
          ['JAN',  1000],
          ['FEB',  1170],
          ['MAR',  660],
          ['APR',  1030],
          ['MAY',  1000],
          ['JUN',  1170],
          ['JUL',  660],
          ['AUG',  1030],
          ['SEPT',  1000],
          ['OCT',  1170],
          ['NOV',  660],
          ['DEC',  1030]
        ]);

        var options = {
          colors:['#2795be' ],
          hAxis: {title: 'MONTH', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'NO. OF PAST DUE ACCOUNTS', titleTextStyle: {color: 'black', italic: false,  bold: true}},
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
		PAST DUE MATURED ACCOUNTS OF <b>PACO</b> BRANCH, CENTER <b>3</b><br>
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