<style type="text/css" media="print">
  .dontprint{
    display: none;
  }

  @page { 
    size: Landscape;
    margin: 1 in;
  }
</style>

<?php 
$n = $this->session->userdata('branchno');
$user = $this->session->userdata('firstname');
$control_no =$n;

date_default_timezone_set('Asia/Manila');

    $currentmonth = strtoupper(date("F"));
    $currentyear = date('Y');
    $datetoday = date('F d, Y');
    $branch = strtoupper($this->session->userdata('branch'));

    $membertype = $this->db->query("SELECT CenterNo, y.* from caritascenters cc join (SELECT borrower.CenterControl, numsaver, numborrower from (SELECT c.CaritasCenters_ControlNo as centercontrol, m.ControlNo as member, m.Status, count(m.ControlNo) as numsaver from caritascenters_has_members c join members_has_membersmembershipstatus m on m.ControlNo = c.Members_ControlNo where c.CaritasCenters_ControlNo in (SELECT CaritasCenters_ControlNo from caritasbranch_has_caritascenters where CaritasBranch_ControlNo = $control_no) and m.Status = 'Active Saver' group by centercontrol)saver right join (SELECT c.CaritasCenters_ControlNo as centercontrol, m.ControlNo as member, m.Status, count(m.ControlNo) as numborrower from caritascenters_has_members c join members_has_membersmembershipstatus m on m.ControlNo = c.Members_ControlNo where c.CaritasCenters_ControlNo in (SELECT CaritasCenters_ControlNo from caritasbranch_has_caritascenters where CaritasBranch_ControlNo = $control_no) and m.Status = 'Borrower' group by centercontrol)borrower on saver.centercontrol = borrower.centercontrol)y on y.CenterControl = cc.ControlNo");
    $mem_type = $membertype->result();


 ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
 <!-- <link rel="stylesheet" type="text/css" href="../../../Assets/css/reports.css">  -->


<head>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Center', 'Borrower', 'Saver'],
          <?php foreach ($mem_type as $mem) {
            $borrower = $mem->numborrower;
            $saver = $mem->numsaver;
            if ($saver==NULL) {
              $saver = 0;
            };
           ?>

          ['<?php echo $mem->CenterControl ?>', <?php echo $borrower ?>,<?php echo $saver ?>],
          <?php } ?>
        ]);

        var options = {
         // title: 'Target vs. Actual of All Centers in Paco Branch for the Month of July',
          hAxis: {title: 'BRANCH or CENTER', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'NO. OF MEMBERS', titleTextStyle: {color: 'black', italic: false,  bold: true}},
          backgroundColor: 'transparent',
          colors:['9c9e9c','#a63923' ],
          'width':1000,
          'height':500,
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
    NUMBER OF BORROWERS AND SAVERS <br> 
    <?php echo $branch ?> BRANCH AS OF <?php echo $currentmonth.",".$currentyear ?></b>

  </h3>

    <div id="chart_div" style="width: 1300px; height: 500px; margin-left:160PX;; margin-right: auto;"></div>

    <br>
   
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
          <td class='hdrx'>NO. OF BORROWERS</td>
          <td class='hdrx'>NO. OF SAVERS</td>
      </tr>
      <tr>
          <td class='hdrtxt'>2</td>
          <td class='hdrtxt'>100</td>
          <td class='hdrtxt'>150</td>
      </tr>

    </table>


    <br><br>

    <table class="signature" style="margin-left:auto; margin-right:auto;">
      <tr>
        <td class="sigBy">Prepared by:</td>
        <td class="sig"><?php echo $user ?></td>
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
    <button onclick="window.print()" class="dontprint">Print</button> 
  </div>
</body>