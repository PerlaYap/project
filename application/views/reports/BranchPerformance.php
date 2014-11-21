<TITLE> Branch Performance</TITLE>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
<head>
<?php
$name=$this->session->userdata('firstname');
$date = date('F d, Y');
  $userrank = $this->session->userdata('rank');
  
   $datetoday = date('F d, Y');
?>
<style type="text/css" media="print">
.dontprint{
  display: none;
}
@page { size: landscape; }

</style>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Branch', 'Past Due','On Time'],
          <?php $y = 0;
                $len = count($pastduesbranch);
          foreach ($pastduesbranch as $pdb) { 
            $bname = $pdb->BranchName;
            $num = $pdb->PastDue;
            $loan = $pdb->Loan;
            ?>
            <?php if ($y == $len-1) { ?>
                ['<?php echo $bname ?>', <?php echo $num; ?>,<?php echo $loan; ?> ]
            <?php } else { ?>
              ['<?php echo $bname ?>', <?php echo $num; ?>,<?php echo $loan; ?> ],
           <?php } ?>
            
          <?php $y++; } ?>
         

          
        ]);

        var options = {
          //title: 'Company Performance',
          hAxis: {title: 'Branch', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'No. of Past Due', titleTextStyle: {color: 'black', italic: false,  bold: true}},
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
		COLLECTION PERFORMANCE OF BRANCHES <br> 
		FOR THE MONTH OF <b> <?php echo $month." " .$year ?> </b>

	</h3>

    <div id="chart_div" style="width: 1300px; height: 500px; margin-left:auto; margin-right: auto;"></div>

    
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
          <td class='hdrx'>No. of On-Time Payment</td>
          <td class='hdrx'>No. of Past Due</td>
      </tr>
      <?php
      foreach ($pastduesbranch as $data){ ?>
      <tr>
          <td class='hdrtxt'><?php echo $data->BranchName; ?></td>
          <td class='hdrtxt'><?php echo $data->Loan; ?></td>
          <td class='hdrtxt'><?php echo $data->PastDue; ?></td>
      </tr>
      <?php } ?>

    </table>

    <br><br>

   <!-- <table class="signature" style="margin-left:auto; margin-right:auto;">
      <tr>
        <td class="sigBy">Prepared by:</td>
        <td class="sig"><?php echo $name; ?></td>
        <td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
        <td class="sig2"><?php echo $date; ?></td>
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
    </table>-->

    <!-- <table class="signature" style="margin-left:31.5%; margin-right:auto;">
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

<table style="margin-left: 300px;" >
      <tr>
        <td style="font-size: 13px;"><?php echo $name; ?></td>
      </tr>
        <?php if($userrank=='branchmanager'){?>
      <tr>
        <td class="BM2">Signature Above Printed Name of Branch Manager</td>
      </tr>
      <?php }else{ ?>
      <tr>
        <td class="BM2">Signature Above Printed Name of MIS</td>
      </tr>
      <?php } ?>
      <tr>
        <td style="font-size: 13px;"><?php echo $datetoday ?></td>
      </tr>
      <tr>
        
        <td class="BM2">Date</td>
      </tr>
    </table>

    <table style="margin-left: 750px; margin-top: -132px;" >
      <tr>
        <td style="font-size: 13px;">Ann Evan Echavez</td>
      </tr>
      <tr>
        <td class="BM2">Signature Above Printed Name of General Manager</td>
      </tr>
      <tr>
        <td style="font-size: 13px;"><?php echo $datetoday ?></td>
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