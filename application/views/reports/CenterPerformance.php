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
      $userrank = $this->session->userdata('rank');
  $name = $this->session->userdata('firstname');
   
  ?>

<head>
        <style type="text/css" media="print">
      .dontprint{
        display: none;
      }
      @page { size: portrait; 
              size: 8.5in 11in;
              margin: 0.5in;
        }

      </style>
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
              $pdnum = $pd->PastDue;
              $loan = $pd->Loan;
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
		AS OF THE END OF THE MONTH OF <b><?php  echo $currentmonth." ".$currentyear ?> </b>

	</h3>

    <div id="chart_div" style="width: 900px; height: 500px; margin-left:auto; margin-right: auto;"></div>

    <style type="text/css">
      .hdrx{
        padding: 5px 15px 5px 15px;
        font-weight: bold;
        font-size: 15px;s
      }
    </style>
    
    <table border=1 style="border-collapse: collapse; margin-left: auto; margin-right: auto">
      <tr>
          <td class='hdrx'>CENTER</td>
          <td class='hdrx'>No. of Past Due Payments</td>
          <td class='hdrx'>No. of On-Time Payment</td>
      </tr>
      <?php
      foreach ($pastdues as $data){ ?>
      <tr>
          <td class='hdrtxt'><?php echo $data->CenterNo; ?></td>
          <td class='hdrtxt'><?php echo $data->PastDue; ?></td>
          <td class='hdrtxt'><?php echo $data->Loan; ?></td>
      </tr>
      <?php } ?>

    </table>


   <!--  <br><br>
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
    </table> -->

   <!--  <table class="signature" style="margin-left:31.5%; margin-right:auto;">
      <tr>
        <td class="sigBy">Prepared by:</td>
      </tr>
      <tr>
        <td class="sigName">Marvin Lao*</td>
      </tr>
      <tr>
        <td class="sigPosition">Branch Manager*</td>
      </tr>
      <tr>
        <td class="sigPosition">November 21, 2014*</td>
      </tr>
    </table>

    <table class="signature" style="margin-left: 53%; margin-right:auto; margin-top: -111px;">
      <tr>
        <td class="sigBy">Received by:</td>
      </tr>
      <tr>
        <td class="sigName">Name</td>
      </tr>
      <tr>
        <td class="sigPosition"> Position</td>
      </tr>
      <tr>
        <td class="sigPosition">November 21, 2014</td>
      </tr>
    </table>-->

<table style="margin-left: 140px;" >
      <tr>
        <td class="BM1" style="font-size: 13px;"><?php echo $name; ?></td>
      </tr>
        <?php if($userrank=='branchmanager'){?>
      <tr>
        <td class="BM2">Signature Above Printed Name of Branch Manager</td>
      </tr>
      <?php }else{ ?>
      <tr>
        <td class="BM2">Signature Above Printed Name of Salve Officer</td>
      </tr>
      <?php } ?>
      <tr>
        <td class="BM1" style="font-size: 13px;"><?php echo $datetoday ?></td>
      </tr>
      <tr>
        
        <td class="BM2">Date</td>
      </tr>
    </table>

    <table style="margin-left: 750px; margin-top: -132px;" >
      <tr>
        <td class="BM1" style="font-size: 13px;">Marvin Lao</td>
      </tr>
      <tr>
        <td class="BM2">Signature Above Printed Name of MIS</td>
      </tr>
      <tr>
        <td class="BM1"style="font-size: 13px;"><?php echo $datetoday ?></td>
      </tr>
      <tr>
        <td class="BM2">Date</td>
      </tr>
    </table>

    <br><br>
	<div class='dontprint' style="width: 100%; text-align: center;">
		<button onclick="window.print()">Print</button> 
	</div>
</body>