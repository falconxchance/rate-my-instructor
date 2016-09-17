<?php 


if( $requested_page == "instructor"  && !empty( $requested_ins_name ) )
{
	$ins_id = nametoid( $requested_ins_name );
	
?>


<script type="text/javascript" src="style/loader.js"></script>

  <script type="text/javascript">
  
    google.charts.load('current', {packages: ['corechart', 'bar']});
	
    google.charts.setOnLoadCallback( drawPieChartLod );
	google.charts.setOnLoadCallback( drawBarChatRate );

    function drawPieChartLod() 
	{
      // Define the chart to be drawn.
		  var data = new google.visualization.DataTable();
		 
		  data.addColumn('string', 'Level of Difficulty');
		  
		  data.addColumn('number', 'Votes');
		  
		  data.addRows(
		  
			<?php echo json_encode( CreateLodDataForPieChart( $ins_id ), JSON_NUMERIC_CHECK ); ?>
			
					);
	
			var options = {
			  'legend':'left',
			  'is3D':true,
			  'width':600,
			  'height':300
							}
	
		  // Instantiate and draw the chart.
		  var chart = new google.visualization.PieChart(document.getElementById('myPieChatLod'));
		  chart.draw(data, options);
    }
	
	
	

	function drawBarChatRate() {

      var data = google.visualization.arrayToDataTable([
        ['Rates', 'Votes', { role: 'annotation' }, { role: 'style' } ],
		
	//	 ['Bad', 3, '33.33%','color: #3d9970' ],
     //   ['Satisfactory', 3, '33.33%', 'color: #3d9970' ],
        //['Good', 1, '33.33%', 'color: #3d9970' ],
       // ['Very Good', 1, '33.33%', 'color: #3d9970' ],
      //  ['Excellent', 1, '33.33%', 'color: #3d9970' ]
		
		<?php 
		
		
		CreateRateDataForBarChart( $ins_id );
	
	
	?>
	
	
      ]);

      var options = {
		  
        chartArea: {width: '50%'},
		
		legend: {position: 'none'},
        
        hAxis: {
          title: 'Total Votes',
          minValue: 0
        },
        vAxis: {
          title: 'Rates'
        }
      };

      var chart = new google.visualization.BarChart(document.getElementById('myBarChartRate'));

      chart.draw(data, options);
    }
	
	
  </script>
  
<?php 


}



?>  
 