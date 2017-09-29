<?php //echo '<pre>'; ?>
<?php //print_r($categories); ?>
<?php //echo '</pre>'; ?>
<?php $this->load->start_inline_styling(); ?>
<style type="text/css">
body {
	padding-bottom: 200px;
}
#navbar-bottom {
	padding-top: 15px;
}
</style>
<?php $this->load->end_inline_styling(); ?>

<form action="<?php echo site_url('billing/check'); ?>" method="post">
<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			<label for="table"><?php echo lang('title_table_no') ?></label>
			<select name="billing" id="table-no" class="form-control input-lg">
				<option value="" data-billing-date="" data-billing-no=""><?php echo lang('title_select_table') ?>...</option>
				<?php foreach ($tables as $key => $table) : ?>
					<?php if ($table->used == 'Y') : ?>
					<option value="<?php echo $table->billing_date.','.$table->billing_no; ?>" data-billing-date="<?php echo $table->billing_date; ?>" data-billing-no="<?php echo $table->billing_no; ?>"<?php echo ($table->table_no == $current_table_no) ? ' selected="selected"' : NULL ?>><?php echo $table->table_no.' ('.$table->total_customer.' customers, '.number_format($table->total_price).' '.lang('money_type').')'.(!is_today($table->billing_date) ? ' on '.$table->billing_date : NULL) ?></option>
					<?php endif ?>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="col-xs-offset-3 col-xs-3">
		<div class="form-group">
			<label for="table"><?php echo lang('title_tools') ?></label>
			<a href="<?php echo site_url('billing/reprint/'.$current_table_no); ?>" class="btn btn-default btn-lg btn-default btn-lg btn-block<?php echo count($current_orderings) <= 0 ? ' disabled' : NULL ?>"><span class="glyphicon glyphicon-print" aria-hidden="true"></span><span class="hidden-xs"> <?php echo lang('title_reprint') ?></span></a>
		</div>
	</div>
</div>

<table class="table table-striped">
	<thead>
		<tr class="row">
			<th class="col-xs-1 col-sm-1 text-center"><?php echo lang('title_menu') ?></th>
			<th><?php echo lang('title_title') ?></th>
			<th class="col-sm-2 hidden-xs"><?php echo lang('title_price') ?> (<?php echo lang('money_type_symbol') ?>)</th>
			<th class="col-xs-2 col-sm-1 text-center"><?php echo lang('title_quantity') ?></th>
			<th class="col-xs-3 col-sm-2 text-right"><?php echo lang('title_total') ?> (<?php echo lang('money_type_symbol') ?>)</th>
		</tr>
	</thead>
	<tfoot>
		<tr class="row">
			<th class="col-xs-1 col-sm-1 text-center"><?php echo lang('title_menu') ?></th>
			<th><?php echo lang('title_title') ?></th>
			<th class="col-sm-2 hidden-xs"><?php echo lang('title_price') ?> (<?php echo lang('money_type_symbol') ?>)</th>
			<th class="col-xs-2 col-sm-1 text-center"><?php echo lang('title_quantity') ?></th>
			<th class="col-xs-3 col-sm-2 text-right"><?php echo lang('title_total') ?> (<?php echo lang('money_type_symbol') ?>)</th>
		</tr>
	</tfoot>
	<tbody>
		<?php $i = 1; ?>
		<?php $total_price = 0; ?>
		<?php foreach ($current_orderings as $menu) : ?>
		<tr class="row">
			<td class="text-center"><?php echo $i++ ?>.</td>
			<td><?php echo lang_filter($menu, 'name'); ?></td>
			<td class="hidden-xs"><?php echo number_format($menu->price); ?></td>
			<td class="text-center"><?php echo number_format($menu->quantity); ?></td>
			<td class="text-right">
				<?php $total_price += $menu->quantity * $menu->price; ?>
				<?php echo number_format($menu->quantity * $menu->price, 2); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<nav id="navbar-bottom" class="navbar navbar-default navbar-fixed-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-6 col-sm-9">
				<div class="form-group">
					<small><?php echo lang('title_total_price') ?>:</small><br>
					<span class="number-highlight"><?php echo lang('money_type_symbol') ?> <?php echo number_format($total_price, 2); ?></span>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="form-group">
					<button type="button" id="btn-checking" class="btn btn-default btn-lg btn-danger btn-lg btn-block"<?php echo count($current_orderings) <= 0 ? ' disabled="disabled"' : NULL ?>><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <?php echo lang('title_payment') ?></button>
				</div>
			</div>
		</div>
	</div>
</nav>

<!-- Modal -->
<div id="modal-payment" class="modal fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><?php echo lang('title_billing_payment') ?></h4>
				</div>
			<div id="calculator-wrapper" class="modal-body">
				<div class="row">
					<div class="col-xs-6 col-sm-6">
						<div class="form-group">
							<label for="table"><?php echo lang('title_total_price') ?> (<?php echo lang('money_type_symbol') ?>):</label>
							<input type="text" name="total_price" id="billing-total-price" class="form-control input-lg text-right" value="<?php echo number_format($total_price); ?>" readonly="readonly">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6">
						<div class="form-group">
							<label for="table"><?php echo lang('title_cash_return') ?> (<?php echo lang('money_type_symbol') ?>):</label>
							<input type="text" name="cash_return" id="billing-cash-return" class="form-control input-lg text-right" readonly="readonly">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6">
						<label><?php echo lang('title_cash_payment') ?> (<?php echo lang('money_type_symbol') ?>):</label>
					</div>
					<div class="col-xs-6 col-sm-6 text-right">
						<span id="billing-cash-payment-temp"></span>
					</div>
				</div>
				
				<table width="100%" cellspacing="1">
					<tr>
						<td width="75%" colspan="3">
							<input type="text" name="cash_payment" id="billing-cash-payment" class="form-control input-lg text-right">
						</td>
						<td width="25%">
							<button type="button" class="bs2 btn btn-warning btn-lg btn-block" data-method="reset" data-key="8">C</button>
						</td>
					</tr>
					<tr>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block">1,000</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block">5,000</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block">10,000</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-constant="DIV" data-key="47">&divide;</button</td>
					</tr>
					<tr>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-key="55">7</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-key="56">8</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-key="57">9</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-constant="MULT" data-key="42">&times;</button></td>
					</tr>
					<tr>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-key="52">4</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-key="53">5</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-key="54">6</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-constant="MIN" data-key="45">-</button></td>
					</tr>
					<tr>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-key="49">1</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-key="50">2</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-key="51">3</button></td>
						<td width="25%"><button type="button" class="bs2 btn btn-default btn-lg btn-block" data-constant="SUM" data-key="43">+</button></td>
					</tr>
					<tr>
						<td width="25%"><a href="#" class="bs2 btn btn-default btn-lg btn-block" data-key="46">.</a></td>
						<td width="25%"><a href="#" class="bs2 btn btn-default btn-lg btn-block" data-key="48">0</a></td>
						<td width="25%"></td>
						<td width="25%"><a href="#" class="bs2 btn btn-default btn-lg btn-block btn-primary" data-method="calculate" data-key="61">=</a></td>
					</tr>
				</table>
			</div> <!-- /.modal-body -->
			<div class="modal-footer">
				<div class="row">
					<div class="col-xs-5">
						<button type="button" class="bs2 btn btn-default btn-lg btn-block" disabled="disabled"><i class="glyphicon glyphicon-credit-card"></i> <?php echo lang('title_credit_payment') ?></button>
					</div>
					<div class="col-xs-7">
						<button type="submit" id="billing-payment-submit" class="bs2 btn btn-danger btn-lg btn-block" disabled="disabled"><i class="glyphicon glyphicon-yen"></i> <?php echo lang('title_cash_payment') ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>

<?php $this->load->js('assets/js/calculator.js'); ?>
<?php $this->load->start_inline_scripting(); ?>
<script type="text/javascript">
$(document).ready(function() {
	$("#billing-total-price").number(true);
	$("#billing-cash-return").number(true);
	/* changing table no. */
	$("#table-no").change(function(){
		var option = $(this).find("option:selected");
		var segment = option.data("billing-no");
		if (option.data("billing-date") != "") {
			var today = new Date();
			var billing_date = new Date(option.data("billing-date"));
			// console.log(today.toDateString());
			// console.log(billing_date.toDateString());
			if(today.toDateString() != billing_date.toDateString()) {
				// console.log("today != billing_date");
				segment += "/" + option.data("billing-date");
			}
		}
		window.location = "<?php echo site_url('billing/number'); ?>/" + segment;
	});
	$("#billing-cash-payment").change(function(){
		var total_price = $("#billing-total-price").val();
		var cash_payment = $(this).val();
		var cash_return = parseInt(cash_payment, 10) - parseInt(total_price, 10);
		$("#billing-cash-return").val(cash_return);
		$("#billing-payment-submit").prop("disabled", cash_return < 0);
	});
	// submit button
	$("#btn-checking").click(function(e){
		var table_no = $("#table-no").val();
		var total_customer = $("#total-customer").val();
		if (table_no == "" || total_customer == "") {
			alert("Please enter <Table No.> and <Tota Customer>");
			e.preventDefault();
		}else{
			$("#modal-payment").modal();
		}
	});
});
</script>
<?php $this->load->end_inline_scripting(); ?>
