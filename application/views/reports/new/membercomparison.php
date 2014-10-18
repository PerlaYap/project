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
          ['MEMBER', 'NO. OF LOAN', 'ON-TIME PAYMENTS', 'PAST DUE PAYMENTS'],
          ['Lyka Dado',  5, 23, 10],
          ['Perla Yap',  3, 10, 2],
          ['Lyka Dado',  5, 23, 10],


        ]);

        var options = {
          colors:['#a83a47', '#a8a23a', '562b30'],
          hAxis: {title: '', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'MEMBER', titleTextStyle: {color: 'black', italic: false,  bold: true}},
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>


</head>


<body>
	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		MEMBER PERFORMANCE COMPARISON OF <b>PACO</b> BRANCH, CENTER <b>3</b><br>
		AS OF SEPTEMBER 29, 2014

	</h3>

     <div id="chart_div" style="width: 900px; height: 500px;"></div>

    <br>
    <table class="signature" style="margin-left:auto; margin-right:auto;">
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

    <br><br>
	<div style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 
	</div>
</body>