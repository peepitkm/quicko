<h1>Monthly Report</h1>
<hr>
<div class="panel-wrapper">
	<div class="table-responsive">
		<table id="tables" class="table table-striped">
			<thead>
				<tr>
					<th class="text-center">Monthly</th>
					<th class="text-right">Lunch Customer</th>
					<th class="text-right">Lunch Income</th>
					<th class="text-right">Dinner Customer</th>
					<th class="text-right">Dinner Income</th>
					<th class="text-right">Total Customer</th>
					<th class="text-right">Total Income</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($monthly_incomes as $key => $income) : ?>
				<tr>
					<td class="text-center"><?php echo $income->year . ' / ' . $income->month ?></td>
					<td class="text-right"><?php echo number_format($income->lunch_customer) ?></td>
					<td class="text-right"><?php echo lang('money_type_symbol') ?> <?php echo number_format($income->lunch, 2) ?></td>
					<td class="text-right"><?php echo number_format($income->dinner_customer) ?></td>
					<td class="text-right"><?php echo lang('money_type_symbol') ?> <?php echo number_format($income->dinner, 2) ?></td>
					<td class="text-right"><?php echo number_format($income->total_customer) ?></td>
					<td class="text-right"><?php echo lang('money_type_symbol') ?> <?php echo number_format($income->total, 2) ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
