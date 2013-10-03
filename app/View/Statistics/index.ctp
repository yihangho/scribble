<script src="https://www.google.com/jsapi"></script>
<script>
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var dataTable = new google.visualization.DataTable();
		dataTable.addColumn('date', 'Date');
		dataTable.addColumn('number', 'Count');
		<?php foreach($statistics as $s):?>
		dataTable.addRow([new Date('<?php echo $s[0];?>'), <?php echo $s[1];?>]);
		<?php endforeach;?>
		var dataView = new google.visualization.DataView(dataTable);
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		chart.draw(dataView);
	}
</script>
<div id="chart_div" style="width: 900px; height: 500px;"></div>
