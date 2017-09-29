<h1>
	<?php echo lang('title_panel_menus')?>
	<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-menu-add" data-backdrop="static" data-keyboard="false"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Menu</button>
</h1>
<hr>
<div id="ordering-panel">
	<div class="row">
		<div class="col-xs-12">
			<ul id="ordering-menu-categories" class="nav nav-pills" role="tablist">
				<?php $active = true; ?> 
				<?php foreach ($categories as $key => $category) : ?>
				<li role="presentation"<?php echo ($active) ? ' class="active"' : NULL; $active = false; ?>>
					<a href="#category-<?php echo empty($category->id)?'0':$category->id ?>" role="tab" data-toggle="tab">
					<?php echo lang_filter($category, 'name'); ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="tab-content">
		<?php $active = true; ?> 
		<?php foreach ($categories as $uselesskey => $category) : ?>
		<div role="tabpanel" class="tab-pane<?php echo ($active) ? ' active' : NULL; $active = false; ?>" id="category-<?php echo (empty($category->id))?'0':$category->id ?>">
			<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="3%">#</th>
						<th width="8%"><?php echo lang('title_menu_no')?></th>
						<th><?php echo lang('title_name_english')?></th>
						<th><?php echo lang('title_name_thai')?></th>
						<th><?php echo lang('title_name_japanese')?></th>
						<th><?php echo lang('title_name_kitchen')?></th>

						<th width="8%"><?php echo lang('title_price')?>(<?php echo lang('money_type_symbol') ?>)</th>
						<th width="8%"><?php echo lang('title_type')?></th>

						<th width="8%"><?php echo lang('title_showed')?></th>
						<th width="8%"><?php echo lang('title_ordered')?></th>
						<th width="8%"><?php echo lang('title_action')?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($category->menus as $key =>$menu) : ?>
					<tr data-menu-id="<?php echo $menu->id;?>">
						<td><?php echo $key+1;?></td>
						<td ><?php echo $menu->menu_no ?>.</td>
					
						<td ><?php echo $menu->name_en ?></td>
						<td ><?php echo $menu->name_th ?></td>
						<td ><?php echo $menu->name_jp ?></td>
						<td ><?php echo $menu->name_kitchen ?></td>

						<td ><?php echo $menu->price ?></td>
						<td ><?php echo lang('title_type_'.$menu->type) ?></td>

						<td>
							<input class="showed" type="checkbox"<?php echo ($menu->showed)?' checked="checked"':NULL;?>>
						</td>
						<td>
							<button type="button" class="btn btn-default btn-xs move"<?php echo ($key==0)?' disabled="disabled"':NULL;?>>
								<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
							</button>
							<button type="button" class="btn btn-default btn-xs move"<?php echo ($key==count($category->menus)-1)?' disabled="disabled"':NULL;?>>
								<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
							</button>
						</td>

						<td>
							<button type="button" class="btn btn-default btn-xs edit" data-toggle="modal" data-target="#modal-menu-edit" data-backdrop="static" data-keyboard="false">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"><span>
							</button>
							<button type="button" class="btn btn-default btn-xs delete" data-toggle="modal" data-target="#modal-menu-delete" data-backdrop="static" data-keyboard="false">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"><span>
							</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>

<!-- #form-model-add -->
<form id="form-model-add" action="<?php echo site_url('admin/menus/add'); ?>" method="post">
	<div class="modal fade" id="modal-menu-add" tabindex="-1" role="dialog" aria-labelledby="modal-label-add">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="modal-label-add"><?php echo lang('title_add_menu')?></h4>
	      </div>
	      <div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_menu_no')?></label>
							<input type="text" name="menu_no" id="menu-add-menuno" class="form-control numberic-no" maxlength="10">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_english')?></label>
							<input type="text" name="name_en" id="menu-add-nameen" class="form-control">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_thai')?></label>
							<input type="text" name="name_th" id="menu-add-nameth" class="form-control">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_japanese')?></label>
							<input type="text" name="name_jp" id="menu-add-namejp" class="form-control">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_kitchen')?></label>
							<input type="text" name="name_kitchen" id="menu-add-namekitchen" class="form-control">
						</div>
						
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_price')?>(<?php echo lang('money_type_symbol') ?>)</label>
							<input type="text" name="price" id="menu-add-price" class="form-control numberic-price">
							<!--<p class="help-block">In length of 0 to 999,999.99</p>-->
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_type')?></label>
							<select name="type" class="form-control" id="menu-add-type">
								<option value="food"><?php echo lang('title_type_food')?></option>
								<option value="dessert"><?php echo lang('title_type_dessert')?></option>
								<option value="drink"><?php echo lang('title_type_drink')?></option>
								<option value="other"><?php echo lang('title_type_other')?></option>
							</select>
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_category')?></label>
							<select name="category_id" class="form-control" id="menu-add-category">
								<?php foreach ($categories as $key => $category) : ?>
								<option value="<?php echo $category->id;?>"><?php echo lang_filter($category, 'name'); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>	
	      </div>
	      <div class="modal-footer">
	        <button id="cancel-button" type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('title_cancel')?></button>
	        <button type="submit" class="btn btn-primary"><?php echo lang('title_add')?></button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<!-- /#form-model-add -->

<!--Modal delete-->
<form id="form-table-delete" action="<?php echo site_url('admin/menus/delete'); ?>" method="post">
	<div class="modal fade" id="modal-menu-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><?php echo lang('title_delete_menu')?></h4>
	      </div>
	      <div class="modal-body">

				<div class="row">
					<input type="hidden" name="id" id="menu-delete-id">
					<div class="col-md-6">
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_menu_no')?></label>
							<input type="text" name="menu_no" id="menu-delete-menuno" class="form-control numberic-no" readonly="readonly">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_english')?></label>
							<input type="text" name="name_en" id="menu-delete-nameen" class="form-control" readonly="readonly">
						</div>
							<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_thai')?></label>
						<input type="text" name="name_th" id="menu-delete-nameth" class="form-control" readonly="readonly">
						</div>
							<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_japanese')?></label>
						<input type="text" name="name_jp" id="menu-delete-namejp" class="form-control" readonly="readonly">
						</div>
							<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_kitchen')?></label>
							<input type="text" name="name_kitchen" id="menu-delete-namekitchen" class="form-control" readonly="readonly">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_price')?>(<?php echo lang('money_type_symbol') ?>)</label>
							<input type="text" name="price" id="menu-delete-price" class="form-control numberic-price" readonly="readonly">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_type')?></label>
							<select name="type" class="form-control" id="menu-delete-type" disabled>
							<option value="food"><?php echo lang('title_type_food')?></option>
							<option value="dessert"><?php echo lang('title_type_dessert')?></option>
							<option value="drink"><?php echo lang('title_type_drink')?></option>
							<option value="other"><?php echo lang('title_type_other')?></option>
							</select>
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_category')?></label>
							<select name="category_id" class="form-control" id="menu-delete-category" disabled>
							<?php foreach ($categories as $key => $category) : ?>
								<option value="<?php echo $category->id;?>"><?php echo lang_filter($category, 'name'); ?></option>
							<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
			
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('title_cancel')?></button>
	        <button type="submit" class="btn btn-primary"><?php echo lang('title_delete')?></button>
	      </div>
	    </div>
	  </div>
	</div>
</form>

<!--Modal edit-->
<form id="form-table-edit" action="<?php echo site_url('admin/menus/edit'); ?>" method="post">
	<div class="modal fade" id="modal-menu-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><?php echo lang('title_edit_menu')?></h4>
	      </div>
	      <div class="modal-body">
	      		<input type="hidden" name="id" id="menu-edit-id">
	      		<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_menu_no')?></label>
							<input type="text" name="menu_no" id="menu-edit-menuno" class="form-control numberic-no">
							<input type="hidden" name="menu_no_old" id="menu-edit-menuno-old" class="form-control">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_english')?></label>
							<input type="text" name="name_en" id="menu-edit-nameen" class="form-control">
							<input type="hidden" name="name_en_old" id="menu-edit-nameen-old" class="form-control">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_thai')?></label>
							<input type="text" name="name_th" id="menu-edit-nameth" class="form-control">
							<input type="hidden" name="name_th_old" id="menu-edit-nameth-old" class="form-control">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_japanese')?></label>
							<input type="text" name="name_jp" id="menu-edit-namejp" class="form-control">
							<input type="hidden" name="name_jp_old" id="menu-edit-namejp-old" class="form-control">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_name_kitchen')?></label>
							<input type="text" name="name_kitchen" id="menu-edit-namekitchen" class="form-control">
							<input type="hidden" name="name_kitchen_old" id="menu-edit-namekitchen-old" class="form-control">
						</div>

					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_price')?>(<?php echo lang('money_type_symbol') ?>)</label>
							<input type="text" name="price" id="menu-edit-price" class="form-control numberic-price">
							<input type="hidden" name="price_old" id="menu-edit-price-old" class="form-control">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_type')?></label>
							<select name="type" class="form-control" id="menu-edit-type">
							<option value="food"><?php echo lang('title_type_food')?></option>
							<option value="dessert"><?php echo lang('title_type_dessert')?></option>
							<option value="drink"><?php echo lang('title_type_drink')?></option>
							<option value="other"><?php echo lang('title_type_other')?></option>
							</select>
							<input type="hidden" name="type_old" id="menu-edit-type-old" class="form-control">
						</div>
						<div class="form-group">
							<label for="tableName"><?php echo lang('title_category')?></label>
							<select name="category_id" class="form-control" id="menu-edit-category">
							<?php foreach ($categories as $key => $category) : ?>
								<option value="<?php echo $category->id;?>"><?php echo lang_filter($category, 'name');?></option>
							<?php endforeach; ?>
							</select>
							<input type="hidden" name="category_id_old" id="menu-edit-category-old" class="form-control">
						</div>
					</div>

				</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('title_cancel')?></button>
	        <button type="submit" class="btn btn-primary"><?php echo lang('title_save')?></button>
	      </div>
	    </div>
	  </div>
	</div>
</form>

<?php $this->load->start_inline_scripting(); ?>
<script type="text/javascript">
$(document).ready(function() {

	$("input.numberic-no").number(true,0);	
	$("input.numberic-price").number(true,2);
	
	$('input.showed').click(function(){
		var menu_id = $(this).parent().parent().data("menu-id");
		var showed = this.checked;
		//alert(showed);
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/menus/ajax_update_showed'); ?>",
			data: { "menu_id": menu_id,
					"showed": showed ? 1 : 0 }//convert to 1 or 0 from php
			//,success: function(result){alert(result);}
		});
	});

	$('button.move').click(function(){
		
		var index = $(this).parent().parent().index();

		var num = ($(this).children().hasClass("glyphicon-arrow-up"))?Number(-1):Number(1);
		var index_swap = index+num;
		
		var tbody = $(this).parent().parent().parent();//move to "tbody"

		var td = tbody.find("tr:eq("+index+")");
		var td_swap = tbody.find("tr:eq("+index_swap+")");
		//var another_td = tbody.find("#"+index2).find("td:eq(2)");

		var menu_id = td.data("menu-id");
		var menu_id_swap = td_swap.data("menu-id");
		//alert(category_id+" "+category_id_swap);
		var temp = td.find("td:eq(1)").html();
		td.find("td:eq(1)").html(td_swap.find("td:eq(1)").html());
		td_swap.find("td:eq(1)").html(temp);

		temp = td.find("td:eq(2)").html();
		td.find("td:eq(2)").html(td_swap.find("td:eq(2)").html());
		td_swap.find("td:eq(2)").html(temp);

		temp = td.find("td:eq(3)").html();
		td.find("td:eq(3)").html(td_swap.find("td:eq(3)").html());
		td_swap.find("td:eq(3)").html(temp);


		td.data("menu-id",menu_id_swap);
		td_swap.data("menu-id",menu_id);

		//alert(current+"!!"+above);
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/menus/ajax_update_ordered'); ?>",
			data: { "menu_id":menu_id,
					"menu_id_swap":menu_id_swap,
					"ordered":index_swap+1,
					"ordered_swap":index+1 }
			//,success: function(result){alert(result);}
		
		});	
	});

	// default
	$('#menu-add-category').val("");
	$("#cancel-button").click(function(){ // clear value
		$("#menu-add-menuno").val("");
		$("#menu-add-nameen").val("");
		$("#menu-add-nameth").val("");
		$("#menu-add-namejp").val("");
		$("#menu-add-namekitchen").val("");
		$("#menu-add-price").val("");
		$('#menu-add-type').val("food");
		$('#menu-add-category').val("");
	});

	$(".edit").click(function(){
		var id = $(this).parent().parent().data("menu-id");
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/menus/ajax_get_menu'); ?>",
			data: {"menu_id":id},
			success: function(data){
				$('#menu-edit-id').val(data.menu.id);
				$("#menu-edit-menuno").val(data.menu.menu_no);
				$("#menu-edit-menuno-old").val(data.menu.menu_no);
				$("#menu-edit-nameen").val(data.menu.name_en);
				$("#menu-edit-nameen-old").val(data.menu.name_en);
				$("#menu-edit-nameth").val(data.menu.name_th);
				$("#menu-edit-nameth-old").val(data.menu.name_th);
				$("#menu-edit-namejp").val(data.menu.name_jp);
				$("#menu-edit-namejp-old").val(data.menu.name_jp);
				$("#menu-edit-namekitchen").val(data.menu.name_kitchen);
				$("#menu-edit-namekitchen-old").val(data.menu.name_kitchen);
				$("#menu-edit-price").val(data.menu.price);
				$("#menu-edit-price-old").val(data.menu.price);
				$('#menu-edit-type').val(data.menu.type);
				$("#menu-edit-type-old").val(data.menu.type);
				$('#menu-edit-category').val(data.menu.category_id);
				$('#menu-edit-category-old').val(data.menu.category_id);
			}
		});
		
	});

	$(".delete").click(function(){
		var id = $(this).parent().parent().data("menu-id");
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/menus/ajax_get_menu'); ?>",
			data: {"menu_id":id},
			success: function(data){
				$('#menu-delete-id').val(id);
				$("#menu-delete-menuno").val(data.menu.menu_no);
				$("#menu-delete-nameen").val(data.menu.name_en);
				$("#menu-delete-nameth").val(data.menu.name_th);
				$("#menu-delete-namejp").val(data.menu.name_jp);
				$("#menu-delete-namekitchen").val(data.menu.name_kitchen);
				$("#menu-delete-price").val(data.menu.price);
				$('#menu-delete-type').val(data.menu.type);
				$('#menu-delete-category').val(data.menu.category_id);
			}
		});
		
	});	

});


</script>
<?php $this->load->end_inline_scripting(); ?>