<?php //echo '<pre>'; ?>
<?php //print_r($categories); ?>
<?php //echo '</pre>'; ?>
<?php $this->load->css('assets/fancybox/source/jquery.fancybox.css'); ?>
<?php $this->load->start_inline_styling(); ?>
<style type="text/css">
body {
	padding-bottom: 58px;
}
#navbar-bottom {
	padding-top: 15px;
	padding-bottom: 15px;
}
#ordering-panel {
	padding-top: 5px;
	padding-bottom: 5px;
	margin-top: 51px;
}
#ordering {
	margin-top: 137px;
}
</style>
<?php $this->load->end_inline_styling(); ?>

<form id="table-form" action="<?php echo site_url('ordering/order'); ?>" method="post">
<div id="ordering-panel" class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-6 col-md-4">
				<div class="form-group">
					<label for="table"><?php echo lang('title_table_no') ?>.</label>
					<select name="table_no" id="table-no" class="form-control input-lg">
						<option value=""><?php echo lang('title_select_table') ?>...</option>
						<?php foreach ($tables as $key => $table) : ?>
							<option value="<?php echo $table->table_no; ?>" data-customer="<?php echo $table->total_customer; ?>" data-billing="<?php echo $table->billing_no; ?>"><?php echo $table->table_no.($table->used == 'Y' ? ' ('.$table->total_customer.' customers, '.number_format($table->total_price).' '.lang('money_type').')' : NULL); ?></option>
						<?php endforeach; ?>
					</select>
					<input type="hidden" id="billing-no" name="billing_no" value="<?php echo $table->billing_no; ?>">
				</div>
			</div>
			<div class="col-xs-6 col-md-offset-5 col-md-3">
				<div class="form-group">
					<label for="table"><?php echo lang('title_number_of_customer') ?>:</label>
					<div class="input-group">
						<span class="input-group-btn">
							<button class="bs2 btn btn-default input-lg minus" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
						</span>
						<input type="text" pattern="[\d\.]*" name="total_customer" id="total-customer" class="form-control input-lg text-center quantity unsigned" inputmode="numeric" readonly="readonly">
						<span class="input-group-btn">
							<button class="bs2 btn btn-default input-lg plus" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<ul id="ordering-menu-categories" class="nav nav-pills" role="tablist">
					<?php $active = true; ?> 
					<?php foreach ($categories as $key => $category) : ?>
					<li role="presentation"<?php echo ($active) ? ' class="active"' : NULL; $active = false; ?>>
						<a href="#category-<?php echo $category->id; ?>" role="tab" data-toggle="tab">
						<?php echo lang_filter($category, 'name'); ?>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<div id="ordering" class="tab-content">
	<?php $active = true; ?> 
	<?php foreach ($categories as $key => $category) : ?>
	<div role="tabpanel" class="tab-pane<?php echo ($active) ? ' active' : NULL; $active = false; ?>" id="category-<?php echo $category->id; ?>">
		<div class="row menu-wrapper">
			<?php foreach ($category->menus as $menu) : ?>
			<div class="col-xs-6 col-sm-3 col-lg-2">
				<div class="menu">
					<a class="menu-picture" href="<?php echo base_url('assets/foods/padthai.jpg') ?>"><img src="<?php echo base_url('assets/icons/1467702376_image.png') ?>"></a>
					<div class="menu-number">No.<?php echo $menu->id; ?></small></div>
					<div class="menu-title text-ellipsis"><?php echo lang_filter($menu, 'name'); ?></div>
					<div class="menu-price"><?php echo lang('money_type_symbol') ?> <?php echo number_format($menu->price); ?></div>
					<div class="input-group">
						<span class="input-group-btn">
							<button class="bs2 btn btn-default minus" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
						</span>
						<input type="number" name="quantities[]" class="form-control text-center quantity" readonly="readonly" data-id="<?php echo $menu->id; ?>">
						<span class="input-group-btn">
							<button class="bs2 btn btn-default plus" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
						</span>
					</div>
					<input type="hidden" name="ids[]" value="<?php echo $menu->id; ?>">
					<input type="hidden" name="kitchens[]" value="<?php echo $menu->name_kitchen; ?>">
					<input type="hidden" name="prices[]" value="<?php echo $menu->price; ?>">
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endforeach; ?>
</div>

<nav id="navbar-bottom" class="navbar navbar-default navbar-fixed-bottom">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-6 col-md-10">
				<div class="checkbox">
					<label>
						<input id="with-payment" type="checkbox" name="with_payment" value="Y"> <?php echo lang('title_payment') ?>
					</label>
				</div>
			</div>
			<div class="col-xs-6 col-md-2">
				<button type="submit" id="btn-ordering" class="bs2 btn btn-success btn-lg btn-block"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> <span class="span-text"><?php echo lang('title_order') ?>...</span></button>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</nav>

<?php $this->load->js('assets/js/bootstrap-autohidingnavbar/src/jquery.bootstrap-autohidingnavbar.js'); ?>
<?php $this->load->js('assets/fancybox/source/jquery.fancybox.js'); ?>
<?php $this->load->js('assets/js/detectmobilebrowser.js'); ?>
<?php $this->load->js('assets/js/jquery.nicescroll/jquery.nicescroll.min.js'); ?>
<?php $this->load->start_inline_scripting(); ?>
<script type="text/javascript">
$(document).ready(function() {
	// nanoScroller
	if(!$.browser.mobile) {
		console.log('You are not using a mobile device!');
		$("#ordering-menu-categories").niceScroll({
			cursorborder: false
		});
	}

	// bootstrap auto-hiding navbar
	$("#ordering-panel").autoHidingNavbar({
		showOnUpscroll: false,
		showOnBottom: false,
		animationDuration: 10,
		navbarOffset: 70
	});

	// fancybox of menu picture
	$(".menu-picture").fancybox();

	// plus/minus item button
	$(".minus").click(function(){
		var e_order = $(this).parent().parent();
		var e_item = e_order.find(".quantity");
		var items = e_item.val() === "" ? 0 : parseInt(e_item.val(), 10);
		e_item.val(items === 1 ? "" : items - 1 );
	});
	$(".plus").click(function(){
		var e_order = $(this).parent().parent();
		var e_item = e_order.find(".quantity");
		var items = e_item.val() === "" ? 0 : parseInt(e_item.val(), 10);
		e_item.val(items === -1 ? "" : items + 1 );
	});

	//init
	$("#table-no").change(function(){
		var option = $(this).find("option:selected");
		$("#total-customer").val(option.data("customer"));
		$("#billing-no").val(option.data("billing"));
	});
	$("#with-payment").change(function(){
		$("#btn-ordering .span-text").text(function(i, text){
			return text === "Order..." ? "Pay Cash" : "Order...";
		});
	});

	// submit
	$("#btn-ordering").click(function(e){
		var table_no = $("#table-no").val();
		var total_customer = $("#total-customer").val();
		if (table_no == "" || total_customer == "") {
			alert("Please enter <Table No.> and <Number of Customer> before take an order !!!");
			e.preventDefault();
		}
	});
});
</script>
<?php $this->load->end_inline_scripting(); ?>