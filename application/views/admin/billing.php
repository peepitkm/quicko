<?php //echo '<pre>'; ?>
<?php //print_r($billings); ?>
<?php //echo '</pre>'; ?>
<?php $this->load->css('assets/css/bootstrap-datepicker.css'); ?>

<h1>
	<?php echo lang('title_panel_billing')?>
</h1>
<hr>
<div class="panel-wrapper" data-example-id="contextual-table">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<div class="form-inline">
				<div class="form-group">
					<label class="hidden-xs"><?php echo lang('title_billing_date')?>:</label>
					<div class="input-group date">
						<input type="text" class="form-control" value="<?php echo date('Y-m-d') ?>">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="pull-right">
				<button type="button" class="btn btn-default" id="treegrid-toggle" data-state="collapse-all"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <?php echo lang('title_expand_all')?></span></button>
				<button type="button" class="btn btn-default" id="print-all"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> <?php echo lang('title_print_all')?></span></button>
			</div>
		</div>
	</div>
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
					<th class="text-right"><?php echo lang('title_total_price')?>(<?php echo lang('money_type_symbol') ?>)</th>
					<th class="text-right"><?php echo lang('title_vat')?> (8%)</th>
					<th class="text-right"><?php echo lang('title_total')?></th>
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
					<th class="text-right"><?php echo lang('title_total_price')?>(<?php echo lang('money_type_symbol') ?>)</th>
					<th class="text-right"><?php echo lang('title_vat')?> (8%)</th>
					<th class="text-right"><?php echo lang('title_total')?></th>
					<th></th>
				</tr>
			</tfoot>
			<tbody>
				<?php $treegrid = 1; ?>
				<?php foreach ($billings as $key => $billing) : ?>
				<tr class="treegrid-<?php echo $treegrid; ?>">
					<td></td>
					<td class="text-left"><?php echo lang('title_no')?> <?php echo $billing->billing_no; ?></td>
					<td><?php echo $billing->table_no; ?></td>
					<td class="text-center"><?php echo $billing->total_customer; ?></td>
					<td class="text-center"><?php echo $billing->start ?></td>
					<td class="text-center"><?php echo $billing->end ?></td>
					<td class="text-center"><?php echo to_duration_format($billing->start, $billing->end) ?></td>
					<td class="text-right"><?php echo to_money_format($billing->total_price) ?></td>
					<td class="text-right"><?php echo to_money_format($billing->total_vat) ?></td>
					<td class="text-right"><?php echo to_money_format($billing->total_vat + $billing->total_price) ?></td>
					<td>
						<button class="btn btn-default btn-xs btn-block" type="button"><span class="glyphicon glyphicon-print" aria-hidden="true"></span><span class="hidden-sm"> <?php echo lang('title_reprint')?></span></button>
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
</div>

<?php $this->load->js('assets/js/bootstrap-datepicker.min.js'); ?>
<?php $this->load->start_inline_scripting(); ?>
<script type="text/javascript">
	// datepicker
	$(".date").datepicker({
		format: "yyyy-mm-dd"
	}).on("changeDate", function(e) {
        window.location = "<?php echo site_url('admin/billing/date'); ?>/" + $(".date > input").val();
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

	// print html to printer via brower
	$("#print-all").on("click", function(){
		w = window.open();
		w.document.write($("#treegrid-billing").html());
		w.print();
		w.close();
	});
</script>
<?php $this->load->end_inline_scripting(); ?>