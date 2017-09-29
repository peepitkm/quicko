<!-- switches -->
<!--graph-->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/graph.css') ?>">
	<script src="<?php echo base_url('assets/js/chart.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.flot.min.js') ?>"></script>
<!--//graph-->
<div class="switches">
	<div class="col-4">
		<div class="col-md-4 switch-right">
			<div class="switch-right-grid">
				<div class="switch-right-grid1">
					<h3>TODAY'S STATS</h3>
					<p>Duis aute irure dolor in reprehenderit.</p>
					<ul>
						<li>Earning: $400 USD</li>
						<li>Items Sold: 20 Items</li>
						<li>Last Hour Sales: $34 USD</li>
					</ul>
				</div>
			</div>
			<div class="sparkline">
				<canvas id="line" height="150" width="480" style="width: 480px; height: 150px;"></canvas>
					<script>
							var lineChartData = {
								labels : ["Mon","Tue","Wed","Thu","Fri","Sat","Mon"],
								datasets : [
									{
										fillColor : "#fff",
										strokeColor : "#F44336",
										pointColor : "#fbfbfb",
										pointStrokeColor : "#F44336",
										data : [20,35,45,30,10,65,40]
									}
								]
								
							};
							new Chart(document.getElementById("line").getContext("2d")).Line(lineChartData);
					</script>
			</div>
		</div>
		<div class="col-md-4 switch-right">
			<div class="switch-right-grid">
				<div class="switch-right-grid1">
					<h3>MONTHLY STATS</h3>
					<p>Duis aute irure dolor in reprehenderit.</p>
					<ul>
						<li>Earning: $5,000 USD</li>
						<li>Items Sold: 400 Items</li>
						<li>Last Hour Sales: $2,434 USD</li>
					</ul>
				</div>
			</div>
			<div class="sparkline">
				<canvas id="bar" height="150" width="480" style="width: 480px; height: 150px;"></canvas>
					<script>
						var barChartData = {
							labels : ["Mon","Tue","Wed","Thu","Fri","Sat","Mon","Tue","Wed","Thu"],
							datasets : [
								{
									fillColor : "#8BC34A",
									strokeColor : "#8BC34A",
									data : [25,40,50,65,55,30,20,10,6,4]
								},
								{
									fillColor : "#8BC34A",
									strokeColor : "#8BC34A",
									data : [30,45,55,70,40,25,15,8,5,2]
								}
							]
							
						};
							new Chart(document.getElementById("bar").getContext("2d")).Bar(barChartData);
					</script>
			</div>
		</div>
		<div class="col-md-4 switch-right">
			<div class="switch-right-grid">
				<div class="switch-right-grid1">
					<h3>ALLTIME STATS</h3>
					<p>Duis aute irure dolor in reprehenderit.</p>
					<ul>
						<li>Earning: $80,000 USD</li>
						<li>Items Sold: 8,000 Items</li>
						<li>Last Hour Sales: $75,434 USD</li>
					</ul>
				</div>
			</div>
			<div class="sparkline">
				
					<script>
						$(document).ready(function () {
						
							// Graph Data ##############################################
							var graphData = [{
									// Returning Visits
									data: [ [4, 4500], [5,3500], [6, 6550], [7, 7600],[8, 4500], [9,3500], [10, 6550], ],
									color: '#FFCA28',
									points: { radius: 7, fillColor: '#fff' }
								}
							];
						
							// Lines Graph #############################################
							$.plot($('#graph-lines'), graphData, {
								series: {
									points: {
										show: true,
										radius: 1
									},
									lines: {
										show: true
									},
									shadowSize: 0
								},
								grid: {
									color: '#fff',
									borderColor: 'transparent',
									borderWidth: 10,
									hoverable: true
								},
								xaxis: {
									tickColor: 'transparent',
									tickDecimals: false
								},
								yaxis: {
									tickSize: 1200
								}
							});
						
							// Graph Toggle ############################################
							$('#graph-bars').hide();
						
							$('#lines').on('click', function (e) {
								$('#bars').removeClass('active');
								$('#graph-bars').fadeOut();
								$(this).addClass('active');
								$('#graph-lines').fadeIn();
								e.preventDefault();
							});
						
							$('#bars').on('click', function (e) {
								$('#lines').removeClass('active');
								$('#graph-lines').fadeOut();
								$(this).addClass('active');
								$('#graph-bars').fadeIn().removeClass('hidden');
								e.preventDefault();
							});
						
						});
					</script>
					<div id="graph-wrapper">
						<div class="graph-container">
							<div id="graph-lines"> </div>
							<div id="graph-bars"> </div>
						</div>
					</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- //switches -->