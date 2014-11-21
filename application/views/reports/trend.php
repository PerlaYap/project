<style type="text/css" media="print">
  .dontprint{
    display: none;
  }

  @page { 
    size: portrait;
    margin: 0.5in;
  }
</style>




<title>Yearly Trend</title>



 <?php  
  $branch = $this->session->userdata('branchno');
  $user = strtoupper($this->session->userdata('firstname'));
  $datetoday = date('F d, Y');

  $month = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec");

 if($type==1){
 $lineBranch=$this->db->query("SELECT  Month(DateApplied) AS Month, Count(ControlNo) AS NumberofLoan FROM loanapplication la LEFT JOIN loanapplication_has_members lhm ON lhm.LoanApplication_ControlNo=la.ControlNo 
WHERE YEAR(DateApplied)='$years' AND (Status='Full Payment' OR Status='Current' OR Status='Active') AND CaritasBranch_ControlNo='$branch'
GROUP BY Month(DateApplied)");

 $arrayline= array();
 for($a=1; $a<13;$a++){
  $arrayline[$a]=0;
 }

foreach($lineBranch->result() as $row){
  $arrayline[$row->Month]=$row->NumberofLoan;
}}
else if($type==2){
$lineBranch1=$this->db->query("SELECT  Month(DateApplied) AS Month, Count(ControlNo) AS NumberofLoan FROM loanapplication la LEFT JOIN loanapplication_has_members lhm ON lhm.LoanApplication_ControlNo=la.ControlNo 
WHERE YEAR(DateApplied)='$years' AND (Status='Full Payment' OR Status='Current' OR Status='Active') AND CaritasBranch_ControlNo='$branch'
GROUP BY Month(DateApplied)");
$lineBranch2=$this->db->query("SELECT  Month(DateApplied) AS Month, Count(ControlNo) AS NumberofLoan FROM loanapplication la LEFT JOIN loanapplication_has_members lhm ON lhm.LoanApplication_ControlNo=la.ControlNo 
WHERE YEAR(DateApplied)='$years1' AND (Status='Full Payment' OR Status='Current' OR Status='Active') AND CaritasBranch_ControlNo='$branch'
GROUP BY Month(DateApplied)");

 $arrayline= array();
 for($a=1; $a<13;$a++){
  $arrayline[$a]=0;
 }

if(!empty($lineBranch1)){
foreach($lineBranch1->result() as $row){
  $arrayline[$row->Month]=$row->NumberofLoan;
}
}


 $arrayline1= array();
 for($a=1; $a<13;$a++){
  $arrayline1[$a]=0;
 }

if(!empty($lineBranch2)){
foreach($lineBranch2->result() as $row){
  $arrayline1[$row->Month]=$row->NumberofLoan;
}}
}
?>

<?php $branchname=$this->db->query("SELECT BranchName FROM caritasbranch WHERE ControlNo='$branch'"); 
foreach($branchname->result() as $row){
  $branchName=$row->BranchName;
}
?>



<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>"> 


<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([

          <?php 
          if($type==1){?>
            ['Month', '<?php echo $years ?>'],
            <?php for($a=1;$a<13;$a++){ 
              echo "['".$month[$a-1]."',".$arrayline[$a]."],";
            }
          } else if($type==2){ ?>
          ['Month', '<?php echo $years ?>', '<?php echo $years1 ?>'],
          <?php for($a=1;$a<13;$a++){
              echo "['".$month[$a-1]."',".$arrayline[$a].",".$arrayline1[$a]."],";
          }} ?>
        ]);

        var options = {
          //title: 'DORMANT & ACTIVE ACCOUNTS',
          hAxis: {title: 'MONTH', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'NO. OF LOAN APPLICATIONS', titleTextStyle: {color: 'black', italic: false,  bold: true}},
          backgroundColor: 'transparent',
          colors:['#2795be','#a63923' ],          
          'width':1000,
          'height':500,
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
          },
          
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
      <?php if ($type==1) echo $years; 
      else if($type==2) echo $years." and ".$years1; ?>Yearly Trend <br> 
      <?php echo $branchName ?> Branch
    </h3>

    <br>
      <div id="chart_div" style="margin-right: auto; margin-left: 165px;" ></div>

      <?php if($type==1){ ?>
      <table border="1" class="reportTable">
          <tr>
              <td class="thReport"> MONTH</td>
              <td class="thReport"> NO. OF LOAN APPLICATIONS</td>
          </tr>

          <?php for($a=1;$a<13;$a++){ ?>
          <tr>
              <td class="tdReport"><?php echo $month[$a-1]; ?></td>
              <td class="tdReport"><?php echo $arrayline[$a]; ?></td>
          </tr>
          <?php } ?>
      </table>
      <?php } else if($type==2){ ?>

       <table border="1" class="reportTable" style="margin-left: 355px;">
          <tr>
              <td class="thReport" colspan="2"><?php echo $years; ?></td>
          </tr>
          <tr>
              <td class="thReport"> MONTH</td>
              <td class="thReport"> NO. OF LOAN APPLICATIONS</td>
          </tr>

          <?php for($a=1;$a<13;$a++){ ?>
          <tr>
              <td class="tdReport"><?php echo $month[$a-1]; ?></td>
              <td class="tdReport"><?php echo $arrayline[$a]; ?></td>
          </tr>
          <?php } ?>
      </table>

      <table border="1" class="reportTable" style="margin-left: 635px; margin-top:-449px; position:absolute;">
          <tr>
              <td class="thReport" colspan="2"  style="border-left: hidden;"><?php echo $years1; ?></td>
          </tr>
          <tr>
              <td class="thReport" style="border-left: hidden;"> MONTH</td>
              <td class="thReport"> NO. OF LOAN APPLICATIONS</td>
          </tr>
          <?php for($a=1;$a<13;$a++){ ?>
          <tr>
              <td class="tdReport" style="border-left: hidden;"><?php echo $month[$a-1]; ?></td>
              <td class="tdReport"><?php echo $arrayline1[$a]; ?></td>
          </tr>
          <?php } ?>
          
      </table>
      <?php } ?>

      <br><br><br>
     <!--  <table class="signature" style="margin-left:auto; margin-right:auto;">
      <tr>
        <td class="sigBy">Prepared by:</td>
        <td class="sig"><?php echo $user; ?></td>
        <td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
        <td class="sig2"><?php echo $datetoday; ?></td>
      </tr>
    </table>
    <table class="signature"  style="margin-left:auto; margin-right:auto;">
      <tr>
        <td class="sigBy">Received by:</td>
        <td class="sig">&nbsp</td>
        <td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
        <td class="sig2">&nbsp</td>
      </tr>
    </table> -->

     <table class="signature" style="margin-left:31.5%; margin-right:auto;">
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
    </table>
    <br>
     
        
      <br><br>

      <div style="width: 100%; text-align: center;">
        <button onclick="window.print()" class="dontprint">Print</button>
      </div>

  </body>
</html>