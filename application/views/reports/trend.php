<title>Yearly Trend</title>



 <?php  
 $branch = $this->session->userdata('branchno');

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

    <style type="text/css" media="print">
    .dontprint{
      display: none;
    }


<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          <?php 
          if($type==1){
          echo "['Month', '".$years."'],";
          echo "['Jan',".$arrayline[1]."],";
          echo "['Feb',".$arrayline[2]."],";
          echo "['Mar',".$arrayline[3]."],";
          echo "['Apr',".$arrayline[4]."],";
          echo "['May',".$arrayline[5]."],";
          echo "['Jun',".$arrayline[6]."],";
          echo "['Jul',".$arrayline[7]."],";
          echo "['Aug',".$arrayline[8]."],";
          echo "['Sept',".$arrayline[9]."],";
          echo "['Oct',".$arrayline[10]."],";
          echo "['Nov',".$arrayline[11]."],";
          echo "['Dec',".$arrayline[12]."],";}

          else if($type==2){ ?>


          ['Month', '<?php echo $years ?>', '<?php echo $years1 ?>'],
          ['Jan',  <?php echo $arrayline[1] ?>, <?php echo $arrayline1[1] ?>],
          ['Feb',  <?php echo $arrayline[2] ?>, <?php echo $arrayline1[2] ?>],
          ['Mar',  <?php echo $arrayline[3] ?>, <?php echo $arrayline1[3] ?>],
          ['Apr',  <?php echo $arrayline[4] ?>, <?php echo $arrayline1[4] ?>],
          ['May',  <?php echo $arrayline[5] ?>, <?php echo $arrayline1[5] ?>],
          ['Jun',  <?php echo $arrayline[6] ?>, <?php echo $arrayline1[6] ?>],
          ['Jul',  <?php echo $arrayline[7] ?>, <?php echo $arrayline1[7] ?>],
          ['Aug',  <?php echo $arrayline[8] ?>, <?php echo $arrayline1[8] ?>],
          ['Sept', <?php echo $arrayline[9] ?>, <?php echo $arrayline1[9] ?>],
          ['Oct',  <?php echo $arrayline[10] ?>, <?php echo $arrayline1[10] ?>],
          ['Nov',  <?php echo $arrayline[11] ?>, <?php echo $arrayline1[11] ?>],
          ['Dec',  <?php echo $arrayline[12] ?>, <?php echo $arrayline1[12] ?>],
         <?php } ?>
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
      <BR>

         <br>
    <table class="signature"  style="margin-left:auto; margin-right:auto;">
      <tr>
        <td class="sigBy">Received by:</td>
        <td class="sig">&nbsp</td>
        <td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
        <td class="sig2">&nbsp</td>
      </tr>
    </table>
    <br>
     <table class="signature" style="margin-left:auto; margin-right:auto;">
      <tr>
        <td class="sigBy">Prepared by:</td>
        <td class="sig">&nbsp</td>
        <td class="sigBy"> &nbsp&nbsp&nbspDate:</td>
        <td class="sig2">&nbsp</td>
      </tr>
    </table>
        
      <br><br>

      <div class='dontprint' style="width: 100%; text-align: center;">
        <button onclick="window.print()">Print</button>
      </div>

  </body>
</html>
