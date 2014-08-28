<html>
<head>
  <style>
  p {
    font-family:Arial,Tahoma,sans-serif;
    font-size: 15px;

    background-color: transparent;
  }
  </style>
  <!--<TITLE>Report on Student Population for Thesis 1 and Thesis 2</TITLE>-->
  <!--Load the AJAX API-->

  <?php
  $n = $this->session->userdata('controlno');
  $m = $this->session->userdata('request');

  $control_no =$n;
  $type=$m;

  if($type==1){
    $getTarget = $this->db->query("SELECT loanapp.`ControlNo`, `ApplicationNumber`, `AmountRequested`, `Interest`, `DateApplied`, `DayoftheWeek`, `Status`, `LoanType`, `Comments`, `DateReleased`, loanmem.Members_ControlNo, mem.LoanExpense, mem.pastdue 
      FROM `loanapplication` loanapp join `loanapplication_has_members` loanmem on loanmem.LoanApplication_ControlNo = loanapp.ControlNo join `members` mem on mem.ControlNo = loanmem.Members_ControlNo WHERE mem.ControlNo ='$control_no' and loanapp.Status ='Current'");

    foreach($getTarget->result() as $tt){

      $amt = $tt->AmountRequested;
      $int = $tt->Interest;
      $exp = $tt->LoanExpense;
      $pd = $tt->pastdue;
    }

    if (count($getTarget->result())>0) {
     $target = $amt+$int;
     $remaining = $exp-$pd;
     $collected = $target-$exp;
     $pd1 = $pd;
   }else{
    $target ="0";
    $remainin ="0";
    $collected="0";
    $pd1 = "0";
  }
}

else if($type==2){
  $getTarget = $this->db->query("SELECT Alpha.ControlNo, (AmountRequested+Interest) AS TotalPayment, SUM(Beta.Amount) AS PastDue, SUM(Charlie.Amount) AS Payment FROM (SELECT ControlNo, AmountRequested, Interest, DateApplied, Members_ControlNo FROM (SELECT * FROM(SELECT * FROM LoanApplication la LEFT JOIN loanapplication_has_members lhm ON lhm.LoanApplication_ControlNo=la.ControlNo
    WHERE Status='Full Payment' ORDER BY Members_ControlNo, DateApplied DESC)A GROUP BY Members_ControlNo)B WHERE Members_ControlNo='$control_no')Alpha 
  LEFT JOIN (SELECT * FROM Transaction trans WHERE transactiontype='Past Due')Beta ON Beta.LoanAppControlNo=Alpha.ControlNo
  LEFT JOIN (SELECT * FROM Transaction trans WHERE transactiontype='Loan')Charlie ON Charlie.LoanAppControlNo=Alpha.ControlNo
  WHERE Beta.ControlNo IS NOT NULL OR Charlie.ControlNo IS NOT NULL");

  foreach($getTarget->result() as $tt){

    $amt = $tt->TotalPayment;
    $exp = $tt->Payment;
    $pd = $tt->PastDue;
  }

  if (count($getTarget->result())>0) {
   $target = $amt;
   $remaining = 0;
   $collected = $exp;
   $pd1 = $pd;
 }else{
  $target ="0";
  $remainin ="0";
  $collected="0";
  $pd1 = "0";
}
}
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">


      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        var n, t;
        var s= (n*100)/t;



        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([

          ['AMOUNT LEFT', <?php echo $remaining ?> /*s*/],
          ['AMOUNT COLLECTED',<?php echo $collected ?> /*s*/],
          ['PAST DUE',<?php echo $pd1 ?> /*s*/],



          ]);

        
        // Set chart options
        var options = {
         'width':930,
         'height':700,
         'colors': ['#cec5c5', '#327e3e','#a23232' ],
         pieStartAngle: 135,
         backgroundColor: 'transparent',
       };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      </script>
    </head>

    <body>


      <!--Div that will hold the pie chart-->
      <div id="chart_div" style="margin-left:-40px; background-color: transparent; "></div>


   <!-- <div style="position: absolute; margin-left: 150px; margin-top: -200px; line-height: 0.3;">
  
          <p><b>STUDENT POPULATION IN THESIS 1:</b> <u>----</u> </p>
          <p><b>STUDENT POPULATION IN THESIS 2:</b> <u>----</u> </p>
        </div>-->

      <!--<div style=" position:absolute; margin-top: -660px; margin-left: 50px; index-z:1;">
        <p style=" text-align:center; font-size: 20px; font-family:Arial,Tahoma,sans-serif;"> 
          LOAN COLLECTION
        </p>

        <p style="text-align: center; font-style: italic; margin-top: -20px;"> 
          As of <?php echo date("Y/m/d") ?>
        </p>
      </div>-->

    </body>
    </html>