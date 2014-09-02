<TITLE> Center Performance</TITLE>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
<!--  <link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css">  -->

<?php 
  date_default_timezone_set('Asia/Manila');

    $currentmonth = strtoupper(date("F"));
    $currentyear = date('Y');
    $branch = strtoupper($this->session->userdata('branch'));
    $user = strtoupper($this->session->userdata('firstname'));
    $datetoday = date('F d, Y');
  ?>

<head>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Center', 'Past Due', 'On-Time'],
          /*['20',  30, 40],*/
          <?php  $i=0;
                  $len = count($pastdues);
          foreach ($pastdues as $pd) {
              $center = $pd->CenterNo;
              $pdnum = $pd->pastdue;
              $loan = $pd->loan;
           ?>
           <?php if ($i == $len-1) {?>
              ['<?php echo $center ?>',  <?php echo $pdnum ?>,<?php echo $loan ?>]
          <?php }  else{ ?>
              ['<?php echo $center ?>',  <?php echo $pdnum ?>,<?php echo $loan ?>],
          <?php } 
              $i++;
          ?>

          
          <?php  } ?>
          
        ]);

        var options = {
          //title: 'Company Performance',
          hAxis: {title: 'Center No.', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'No. of Accounts', titleTextStyle: {color: 'black', italic: false,  bold: true}},
          colors:['#a83a47', '#a8a23a'],
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

</head>


<body>
	<a href="<?php echo site_url('login/homepage'); ?>"> <img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a>
	
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		COLLECTION PERFORMANCE PER CENTER OF <?php echo $branch; ?> BRANCH <br> 
		FOR THE MONTH OF <b><?php  echo $currentmonth." ".$currentyear ?> </b>

	</h3>

    <div id="chart_div" style="width: 900px; height: 500px; margin-left:auto; margin-right: auto;"></div>

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