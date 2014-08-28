<?php 
  $branchno = $this->session->userdata('branchno');
  $userrank = $this->session->userdata('rank');

  date_default_timezone_set('Asia/Manila');
  
    $datetoday = date('F d, Y');
    $day = date('l');
    $currentmonth = strtoupper(date("F"));
    $currentyear = date('Y');

  $month = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sept","Oct","Nov","Dec");
  $active = $this->db->query("SELECT `CaritasBranch_ControlNo`,c.`CaritasCenters_ControlNo`, mm.ControlNo, mm.Status,count(mm.Status) as Count, month(mm.DateUpdated) as Month  FROM `caritasbranch_has_caritascenters` c join caritascenters_has_members m on c.`CaritasCenters_ControlNo` = m.`CaritasCenters_ControlNo` join members_has_membersmembershipstatus mm on m.Members_ControlNo = mm.ControlNo
where CaritasBranch_ControlNo = $branchno and year(mm.DateUpdated) = $currentyear and Status !='dormant saver' group by Month");
  $dormants = $this->db->query("SELECT `CaritasBranch_ControlNo`,c.`CaritasCenters_ControlNo`, mm.ControlNo, mm.Status,count(mm.Status) as Count, month(mm.DateUpdated) as Month  FROM `caritasbranch_has_caritascenters` c join caritascenters_has_members m on c.`CaritasCenters_ControlNo` = m.`CaritasCenters_ControlNo` join members_has_membersmembershipstatus mm on m.Members_ControlNo = mm.ControlNo
where CaritasBranch_ControlNo = $branchno and year(mm.DateUpdated) = $currentyear and Status ='dormant saver' group by Month");
  $activeaccount = $active->result();
  $dormantaccount = $dormants->result();
 ?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Active'],
          <?php for ($i=0; $i < 12 ; $i++) { ?>
            <?php foreach ($activeaccount as $act) {
                $monthq = $act->Month;
                $numact = $act->Count;
                if ($monthq == $i+1) { ?>
                    ['<?php echo $month[$i] ?>',  <?php echo $numact; ?>],         
                <?php } else{ 
                  $numact = 0;
                  ?>
                  ['<?php echo $month[$i] ?>',  <?php echo $numact; ?>],         
                <?php } ; ?>
            
            
            <?php } ?>
          <?php } ?>
          
          
        ]);

        var options = {
          title: 'ACTIVE ACCOUNTS',
          hAxis: {title: 'MONTH', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'NO. OF ACCOUNTS', titleTextStyle: {color: 'black', italic: false,  bold: true}},
          backgroundColor: 'transparent',
          colors:['#2795be','#a63923' ],
          
        //if salve officer
        <?php if($userrank=='salveofficer') :?>
          'width':940,
          'height':400,
          <?php endif;?>

        //if BM
        <?php if($userrank=='branchmanager') :?>
          'width':590,
          'height':280,
          <?php endif;?>

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
    
    <!--IF salve officer -->
    <?php if($userrank=='salveofficer') :?>
      <div id="chart_div" style="width: 900px; height: 500px;" ></div>
    <?php endif;?>

    <!-- If BM ---->
    <?php if($userrank=='branchmanager') :?>
      <div id="chart_div" style="width: 700px; height: 300px;" ></div>
    <?php endif;?>
  </body>
</html>