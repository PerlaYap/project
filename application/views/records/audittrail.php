<TITLE> Audit Trail</TITLE>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('Assets/css/reports.css'); ?>">
<script src="<?php echo base_url('Assets/js/general.js'); ?>"></script>

<head>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">

  // Load the Visualization API and the controls package.
  // Packages for all the other charts you need will be loaded
  // automatically by the system.
  google.load('visualization', '1.0', {'packages':['controls']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawDashboard);

  function drawDashboard() {
    // Everything is loaded. Assemble your dashboard...

    // Create our data table.
           var data = google.visualization.arrayToDataTable([

      [' ','Name',  'Position', 'Date/Time', 'Activity'],
      <?php 

      $y = 0;
      $len = count($logs);

      foreach ($logs as $log) { 

        		$name = $log->Name;
        		$rank = $log->Rank;
        		$datetime = $log->datetime;
        		$activity = $log->Activity;

        		if ($rank =='salveofficer') {
        			$rank_1 ='Salve Officer';
        		}elseif ($rank=='branchmanager') {
        			$rank_1='Branch Manager';
        		}elseif ($rank=='mispersonnel') {
        			$rank_1='MIS Personnel';
        		}
        		?>
        		<?php if ($y == $len-1) { ?>
        		['<?php echo $y+1 ?>','<?php echo $name ?>',  '<?php echo $rank_1 ?>', '<?php echo $datetime ?>', '<?php echo $activity ?>']		
        		<?php } else { ?>
        		['<?php echo $y+1 ?>','<?php echo $name ?>',  '<?php echo $rank_1 ?>', '<?php echo $datetime ?>', '<?php echo $activity ?>'],		
        			<?php } ?>
        	<?php $y++; } ?>
    ]);


     // Create a dashboard.
        var dashboard = new google.visualization.Dashboard(
            document.getElementById('dashboard_div'));

        //category picker
          var categoryPicker = new google.visualization.ControlWrapper({
      'controlType': 'CategoryFilter',
      'containerId': 'categoryPicker_div',
      'options': {
        'filterColumnIndex': 2,
        'ui': {
          'labelStacking': 'horizontal',
          'label': 'Position:',
          'allowTyping': false,
          'allowMultiple': false
        }
      }
    });

          // string filter (NAME)
        var stringfilter = new google.visualization.ControlWrapper({
      'controlType': 'StringFilter',
      'containerId': 'stringFilter_control_div',
       'state':{
      	'value':''
      },
      'options': {
        'filterColumnIndex': 1,
        'matchType': 'any',
        'ui':{
        	'label':'Name:'
        }
      }

    });

        // String filter (Date)

        var stringfilter_date = new google.visualization.ControlWrapper({
      'controlType': 'StringFilter',
      'containerId': 'stringFilter_datecontrol_div',
      'options': {
        'filterColumnIndex': 3,
        'matchType': 'any',
        'ui':{
        	'label':'Date:'
        }
      }
    });


          //table
       var table = new google.visualization.ChartWrapper({
      'chartType': 'Table',
      'containerId': 'table_div',
      'options': {
      }
    });




        dashboard.bind([stringfilter ,categoryPicker, stringfilter_date],table);
    dashboard.draw(data);

  }
</script>
  </head>




<body>
	<!-- <a href="<?php echo site_url('login/homepage'); ?>"> <img src="../../../Assets/images/caritaslogo.png" class="caritaslogo"></a> -->
	 <a href="<?php echo site_url('login/homepage'); ?>"> 
	 	<img src="<?php echo base_url('Assets/images/caritaslogo.png'); ?>" class="caritaslogo"></a> 

	
	<h3>
		CARITAS SALVE CREDIT COOPERATIVE <br> 
		AUDIT TRAIL<br> 
	</h3>

	<br>

	  <!--Div that will hold the dashboard-->
    <div id="dashboard_div">
      <!--Divs that will hold each control and chart-->
      <div id="categoryPicker_div"></div>
      <div id="stringFilter_control_div"></div>
      <div id="stringFilter_datecontrol_div"></div>
      <div id="table_div"></div>
      
    </div>

</body>