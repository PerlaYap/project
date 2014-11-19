<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/tables.css'); ?>">

<html>


  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Year', 'Target', 'On-Time', 'Past Due', 'Advance'],
          ['52',  1000, 600, 100, 300,],
          ['53',  1000, 600, 100, 300,],
          ['54',  1000, 600, 100, 300,],
          ['55',  1000, 600, 100, 300,],
        ]);

        var options = {
          title: 'Target vs Actual Comparison of Collections per Center',
          hAxis: {title: 'Year', titleTextStyle: {color: 'red'}},
          backgroundColor: 'transparent',
          'width':940,
          'height':400,
          hAxis: {title: 'CENTER', titleTextStyle: {color: 'black', italic: false, bold: true}},
          vAxis: {title: 'LOAN COLLECTION', titleTextStyle: {color: 'black', italic: false,  bold: true}},
          bar: { groupWidth: '50%' },
          colors:['d2ca4c','419fb3', 'b34141','a8a6a6' ],

          
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

        chart.draw(data, options);

      }
    </script>
  </head>

  


  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
        <script type="text/javascript">
            function openWin() {
              myWindow = window.open("targettable", "myWindow", "width=800, height=500");    // Opens a new window
            }
        </script>

    <input type="button" onclick="openWin()" class="table" />

  </body>


</html>
