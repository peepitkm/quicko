<?php $this->load->css('assets/css/graph.css') ?>
<?php $this->load->css('assets/css/jquery.treegrid.css') ?>
<?php $this->load->js('assets/js/chart.js'); ?>
<?php $this->load->js('assets/js/jquery.flot.min.js'); ?>
<?php $this->load->js('assets/js/jquery.treegrid.min.js') ?>
<?php $this->load->js('assets/js/jquery.treegrid.bootstrap3.js'); ?>

<h1>Today Summary</h1>
<div id="today-panel" class="row">
	<div class="col-sm-12 col-sm-6">
		<div id="chart-bar" style="height:241px; padding:15px 0">
			<canvas id="bar" width="450"></canvas>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default today-income-panel">
					<div class="panel-heading bg-primary-800">Today Income</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-6">
								<small>Lunch:</small><br>
								<span class="number-highlight"><?php echo to_number_format($today_lunch_income->total_price) ?></span>
							</div>
							<div class="col-xs-6 text-right">
								<small>Customer:</small><br>
								<span class="number-highlight"><?php echo to_number_format($today_customer->total_customer) ?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<small>Dinner:</small><br>
								<span class="number-highlight"><?php echo to_number_format($today_dinner_income->total_price) ?></span>
							</div>
							<div class="col-xs-6 text-right">
								<small>Total:</small><br>
								<span class="number-highlight"><?php echo to_number_format($today_income->total_price) ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default monthly-income-panel">
					<div class="panel-heading">Monthly Income</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-6">
								<small>Lunch:</small><br>
								<span class="number-highlight"><?php echo to_number_format($monthly_lunch_income->total_price) ?></span>
							</div>
							<div class="col-xs-6 text-right">
								<small>Customer:</small><br>
								<span class="number-highlight"><?php echo to_number_format($monthly_customer->total_customer) ?></span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								<small>Dinner:</small><br>
								<span class="number-highlight"><?php echo to_number_format($monthly_dinner_income->total_price) ?></strong>
							</div>
							<div class="col-xs-6 text-right">
								<small>Total:</small><br>
								<span class="number-highlight"><?php echo to_number_format($monthly_income->total_price) ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="col-sm-6 col-sm-6">
		<div class="panel panel-default topten-menu-panel">
			<div class="panel-heading">Top 10 Menus</div>
			<table class="table">
				<thead>
					<tr>
						<th width="10%" class="text-center">No.</th>
						<th>Lunch</th>
						<th width="10%" class="text-center">#</th>
						<th>Dinner</th>
						<th width="10%" class="text-center">#</th>
						<th>Drink</th>
						<th width="10%" class="text-center">#</th>
					</tr>
				</thead>
				<tbody>
					<?php for($i = 0; $i < 10; $i++) : ?>
					<tr>
						<td width="5%" class="text-center"><?php echo $i+1 ?>.</td>
						<td class="text-ellipsis"><?php echo isset($lunch_top_menus[$i]) ? lang_filter($lunch_top_menus[$i], 'name') : NULL ?></td>
						<td class="text-center"><?php echo isset($lunch_top_menus[$i]) ? $lunch_top_menus[$i]->amount : '-' ?></td>
						<td class="text-ellipsis"><?php echo isset($dinner_top_menus[$i]) ? lang_filter($dinner_top_menus[$i], 'name') : NULL ?></td>
						<td class="text-center"><?php echo isset($dinner_top_menus[$i]) ? $dinner_top_menus[$i]->amount : '-' ?></td>
						<td class="text-ellipsis"><?php echo isset($drink_top_menus_query[$i]) ? lang_filter($drink_top_menus_query[$i], 'name') : NULL ?></td>
						<td class="text-center"><?php echo isset($drink_top_menus_query[$i]) ? $drink_top_menus_query[$i]->amount : '-' ?></td>
					</tr>
					<?php endfor; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<h1>Today Billing</h1>
<div class="table-responsive">
	<table id="treegrid-billing" class="table table-hover tree">
		<colgroup>
			<col width="3%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="8%">
			<col width="8%">
			<col width="8%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="13%">
		</colgroup>
		<thead>
			<tr>
				<th></th>
				<th class="text-left"><?php echo lang('title_billing_no')?></th>
				<th class="text-left"><?php echo lang('title_table_no')?></th>
				<th class="text-center"><?php echo lang('title_customer')?></th>
				<th class="text-center"><?php echo lang('title_start')?></th>
				<th class="text-center"><?php echo lang('title_end')?></th>
				<th class="text-center"><?php echo lang('title_duration')?></th>
				<th class="text-right"><?php echo lang('title_total_price')?> (<?php echo lang('money_type_symbol') ?>)</th>
				<th class="text-right"><?php echo lang('title_vat')?> (<?php echo lang('money_type_symbol') ?>)</th>
				<th class="text-right"><?php echo lang('title_total')?> (<?php echo lang('money_type_symbol') ?>)</th>
				<th></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th></th>
				<th class="text-left"><?php echo lang('title_billing_no')?></th>
				<th class="text-left"><?php echo lang('title_table_no')?></th>
				<th class="text-center"><?php echo lang('title_customer')?></th>
				<th class="text-center"><?php echo lang('title_start')?></th>
				<th class="text-center"><?php echo lang('title_end')?></th>
				<th class="text-center"><?php echo lang('title_duration')?></th>
				<th class="text-right"><?php echo lang('title_total_price')?> (<?php echo lang('money_type_symbol') ?>)</th>
				<th class="text-right"><?php echo lang('title_vat')?> (<?php echo lang('money_type_symbol') ?>)</th>
				<th class="text-right"><?php echo lang('title_total')?> (<?php echo lang('money_type_symbol') ?>)</th>
				<th></th>
			</tr>
		</tfoot>
		<tbody>
			<?php $treegrid = 1; ?>
			<?php foreach ($billings as $key => $billing) : ?>
			<tr class="treegrid-<?php echo $treegrid; ?>">
				<td></td>
				<td class="text-left"><?php echo lang('title_no')?> <?php echo $billing->billing_no ?></td>
				<td><?php echo $billing->table_no; ?></td>
				<td class="text-center"><?php echo $billing->total_customer ?></td>
				<td class="text-center"><?php echo $billing->start ?></td>
				<td class="text-center"><?php echo $billing->end ?></td>
				<td class="text-center"><?php echo to_duration_format($billing->end, $billing->start) ?></td>
				<td class="text-right"><?php echo to_money_format($billing->total_price) ?></td>
				<td class="text-right"><?php echo to_money_format($billing->total_vat) ?></td>
				<td class="text-right"><?php echo to_money_format($billing->total_vat + $billing->total_price) ?></td>
				<td>
					<button class="btn btn-default btn-xs btn-block reprint" type="button" data-billing-date="<?php echo $billing->date; ?>" data-billing-no="<?php echo $billing->billing_no; ?>"><span class="glyphicon glyphicon-print" aria-hidden="true"></span><span class="hidden-sm"> <?php echo lang('title_reprint')?></span></button>
				</td>
			</tr>
			<?php $treegrid_parent = $treegrid++; ?>
			<tr class="treegrid-<?php echo $treegrid++; ?> treegrid-child treegrid-parent-<?php echo $treegrid_parent; ?>">
				<td></td>
				<td colspan="9">
					<table class="table table-hover">
						<colgroup>
							<col width="5%">
							<col width="50%">
							<col width="15%">
							<col width="15%">
							<col width="15%">
						</colgroup>
						<thead>
							<tr>
								<th><?php echo lang('title_no')?></th>
								<th><?php echo lang('title_menu')?></th>
								<th class="text-center"><?php echo lang('title_quantity')?></th>
								<th class="text-right"><?php echo lang('title_price')?>(<?php echo lang('money_type_symbol') ?>)</th>
								<th class="text-right"><?php echo lang('title_total')?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($billing->orderings as $key => $ordering) : ?>
							<tr>
								<td><?php echo ++$key; ?>.</td>
								<td><?php echo lang_filter($ordering, 'name'); ?></td>
								<td class="text-center"><?php echo $ordering->quantity; ?></td>
								<td class="text-right"><?php echo to_money_format($ordering->price); ?></td>
								<td class="text-right"><?php echo to_money_format($ordering->quantity * $ordering->price); ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</td>
				<td></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<!--
<div class="row">
	<div class="col-md-offset-2 col-md-8 col-xs-12">
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="col-xs-1 text-center">#</th>
					<th>Date</th>
					<th class="col-xs-3 col-sm-3 text-right">Total</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="col-xs-1 text-center">#</th>
					<th>Date</th>
					<th class="col-xs-3 col-sm-3 text-right">Total</th>
				</tr>
			</tfoot>
			<tbody>
				<?php $i = 1; ?>
				<?php foreach ($statistics as $key => $statistic) : ?>
				<tr>
					<td class="text-center"><?php echo $i++ ?>.</td>
					<td><?php echo $statistic->date; ?></td>
					<td class="text-right">
						<?php echo number_format($statistic->total, 2); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
-->

<?php $this->load->start_inline_scripting(); ?>
<script type="text/javascript">
	<?php
		$data['line_lables'] = array();
		$data['line_data'] = array();

		for($time = 10; $time < 24; $time++){
			$data['line_lables'][]	= sprintf('%02d:00', $time);
			$data['line_data'][]	= 0;
		}
		
		foreach ($statistics as $statistic) {
			if($key = array_search($statistic->ordering_timestamp, $data['line_lables'])){
				$data['line_data'][$key] = floatval($statistic->total_price);
			}
		}
	?>
	var bar = new Chart.Bar(document.getElementById("bar"), {
		data: {
			labels : <?php echo json_encode($data['line_lables']) ?>,
			datasets : [
				{
					label: "Income",
					backgroundColor: "#FC6E51",
					data: <?php echo json_encode($data['line_data']) ?>
				}
			]
		},
		options: {
			legend: {
				display: false
			},
			scales: {
				yAxes: [{
					ticks: {
						max:20000,
						beginAtZero: true
					}
				}]
			}
		}
	});

	// treegrid initial
	$("#treegrid-billing").treegrid({
		initialState: 'collapsed'
	});
	// treegrid with expand all and collapse all event
	$("#treegrid-toggle").on("click", function(){
		var e = $("#treegrid-billing");
		var state = $(this).data("state");
		if (state == "collapse-all") {
			e.treegrid("expandAll");
			$(this).data("state", "expand-all");
			$(this).find("span.glyphicon").removeClass("glyphicon-chevron-right");
			$(this).find("span.glyphicon").addClass("glyphicon-chevron-down");
			$(this).find("span.hidden-xs").text(" <?php echo lang('title_collapse_all')?>");
		}else{
			e.treegrid("collapseAll");
			$(this).data("state", "collapse-all");
			$(this).find("span.glyphicon").removeClass("glyphicon-chevron-down");
			$(this).find("span.glyphicon").addClass("glyphicon-chevron-right");
			$(this).find("span.hidden-xs").text(" <?php echo lang('title_expand_all')?>");
		}
	});

	/* re-print */
	$("button.reprint").on("click", function(){
		$.ajax({
			url: "<?php echo site_url('home/ajax_reprint') ?>",
			type: "POST",
			data: {billing_date : $(this).data('billing-date'), 'billing_no' : $(this).data('billing-no')},
			success: function(result){
				$.notify({
					// options
					message: " (" + result.code + ") Billing No." + result.billing.billing_no + " was printed.",
					type: 'danger'
				},{
					// settings
					allow_dismiss: false,
					placement: {
						from: "bottom",
						align: "center"
					},
					animate: {
						enter: 'animated bounceIn',
						exit: 'animated faceOutDown'
					},
					delay: 3500
				});
			}
		});
	});
	// print html to printer via brower
	$("#print-all").on("click", function(){
		w = window.open();
		w.document.write($("#treegrid-billing").html());
		w.print();
		w.close();
	});
</script>
<?php $this->load->end_inline_scripting(); ?>