<h1>
	<?php echo lang('title_panel_categories')?>
	<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-category-add" data-backdrop="static" data-keyboard="false"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Category</button>
</h1>
<hr>
<div class="panel-wrapper">
<table id="tables" class="table table-striped">
	<thead>
		<tr>
			<th width="5%">#</th>
			<th><?php echo lang('title_name_english')?></th>
			<th><?php echo lang('title_name_thai')?></th>
			<th><?php echo lang('title_name_japanese')?></th>
			
			<th width="10%"><?php echo lang('title_showed')?></th>
			<th width="10%"><?php echo lang('title_ordered')?></th>
			<th width="10%"><?php echo lang('title_action')?></th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($categories as $key => $category) : ?>
		<tr data-category-id="<?php echo $category->id?>" >
			<td><?php echo $key+1 ?></td>
			<td><a href="<?php echo site_url('admin/categories/modify/'.$category->id);?>"><?php echo $category->name_en ?></a></td>
			<td><a href="<?php echo site_url('admin/categories/modify/'.$category->id);?>"><?php echo $category->name_th ?></a></td>
			<td><a href="<?php echo site_url('admin/categories/modify/'.$category->id);?>"><?php echo $category->name_jp ?></a></td>
			<td><input class="showed" type="checkbox"<?php echo ($category->showed)?' checked="checked"':NULL;?>></td>
			<td>
				<button type="button" class="btn btn-default btn-xs move"<?php echo ($key==0)?' disabled="disabled"':NULL;?>>
					<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
				</button>
				
				<button type="button" class="btn btn-default btn-xs move"<?php echo ($key==count($categories)-1)?' disabled="disabled"':NULL;?>>
					<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
				</button>
			</td>
			<td>
				<button type="button" class="btn btn-default btn-xs edit" data-toggle="modal" data-target="#modal-category-edit" data-backdrop="static" data-keyboard="false">
					<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				</button>
				
				<button type="button" class="btn btn-default btn-xs delete" data-toggle="modal" data-target="#modal-category-delete" data-backdrop="static" data-keyboard="false">
					<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
				</button>
				
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>

<!-- modal-category-add -->
<form id="form-category-add" action="<?php echo site_url('admin/categories/add'); ?>" method="post">
<div class="modal fade" id="modal-category-add" tabindex="-1" role="dialog" aria-labelledby="category-add-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="category-add-label"><?php echo lang('title_add_category')?></h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="tableName"><?php echo lang('title_name_english')?></label>
					<input type="text" name="name_en" id="category-add-name-en" class="form-control">
				</div>
				<div class="form-group">
					<label for="tableName"><?php echo lang('title_name_thai')?></label>
					<input type="text" name="name_th" id="category-add-name-th" class="form-control">
				</div>
				<div class="form-group">
					<label for="tableName"><?php echo lang('title_name_japanese')?></label>
					<input type="text" name="name_jp" id="category-add-name-jp" class="form-control">
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

<!-- modal-category-edit -->
<form id="form-category-edit" action="<?php echo site_url('admin/categories/edit'); ?>" method="post">
	<div class="modal fade" id="modal-category-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><?php echo lang('title_edit_category')?></h4>
	      </div>
	      <div class="modal-body">

			  <div class="form-group">
			    <label for="tableName"><?php echo lang('title_name_english')?></label>
			    <input type="text" name="name_en" id="category-edit-name-en" class="form-control">
			    <input type="hidden" name="name_en_old" id="category-edit-name-en-old" class="form-control">
			  </div>
			  <div class="form-group">
			    <label for="tableName"><?php echo lang('title_name_thai')?></label>
			    <input type="text" name="name_th" id="category-edit-name-th" class="form-control">
			    <input type="hidden" name="name_th_old" id="category-edit-name-th-old" class="form-control">
			  </div>
			  <div class="form-group">
			    <label for="tableName"><?php echo lang('title_name_japanese')?></label>
			    <input type="text" name="name_jp" id="category-edit-name-jp" class="form-control">
			    <input type="hidden" name="name_jp_old" id="category-edit-name-jp-old" class="form-control">
			  </div>

			  <input type="hidden" name="category_id" id="category-edit-id">
						
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('title_cancel')?></button>
	        <button type="submit" class="btn btn-primary"><?php echo lang('title_save')?></button>
	      </div>
	    </div>
	  </div>
	</div>
</form>

<!--Modal delete-->
<form class="form-inline" id="form-category-delete" action="<?php echo site_url('admin/categories/delete'); ?>" method="post">
	<div class="modal fade" id="modal-category-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
		
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><?php echo lang('title_delete_category')?></h4>
	      </div>
	      <div class="modal-body">

			  <div class="form-group">
			    <label for="tableName"><?php echo lang('title_delete')?></label>
			    <select id="category-delete-name-en" class="form-control" disabled>
					<?php foreach ($categories as $key => $category) : ?>
					<option value="<?php echo $category->id;?>"><?php echo lang_filter($category, 'name');?></option>
					<?php endforeach; ?>
			    </select>
			  </div>
			  <div class="form-group">
			  	<label for="tableName"><?php echo lang('title_delete_move_to')?></label>
			  	<select name="category_id_new" id="category-delete-option" class="form-control">
			  		<option value="0"><?php echo lang('title_uncategory')?></option>
					<?php foreach ($categories as $key => $category) : ?>
					<option value="<?php echo $category->id;?>"><?php echo lang_filter($category, 'name');?></option>
					<?php endforeach; ?>
			  	</select>
			  </div>
			  <div id="category-delete-hidden"></div>
						
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('title_cancel')?></button>
	        <button type="submit" class="btn btn-primary"><?php echo lang('title_delete')?></button>
	      </div>
		
	    </div>
	  </div>
	</div>
</form>

<?php $this->load->start_inline_scripting(); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('input.showed').click(function(){
		var category_id = $(this).parent().parent().data("category-id");
		var showed = this.checked;
		//alert(showed);
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/categories/ajax_update_showed'); ?>",
			data: { "category_id": category_id,
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

		var category_id = td.data("category-id");
		var category_id_swap = td_swap.data("category-id");
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


		td.data("category-id",category_id_swap);
		td_swap.data("category-id",category_id);

		//alert(current+"!!"+above);
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/categories/ajax_update_ordered'); ?>",
			data: { "category_id":category_id,
					"category_id_swap":category_id_swap,
					"ordered":index_swap+1,
					"ordered_swap":index+1 }
			//,success: function(result){alert(result);}
		
		});	
	});


	$("#cancel-button").click(function(){// clear value
		$('#category-add-name-en').val('');
		$('#category-add-name-th').val('');
		$('#category-add-name-jp').val('');
	}); 

	$(".edit").click(function() {//load value
		var id = $(this).parent().parent().data("category-id");
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/categories/ajax_get_category'); ?>",
			data: {"category_id":id},
			success: function(data){
				$('#category-edit-name-en').val(data.category.name_en);
				$('#category-edit-name-en-old').val(data.category.name_en);
				$('#category-edit-name-th').val(data.category.name_th);
				$('#category-edit-name-th-old').val(data.category.name_th);
				$('#category-edit-name-jp').val(data.category.name_jp);
				$('#category-edit-name-jp-old').val(data.category.name_jp);
				$('#category-edit-id').val(data.category.id);
			}
		});
	});

	$(".delete").click(function() {//load value
		var id = $(this).parent().parent().data("category-id");
		$('#category-delete-name-en').val(id);
	});




});

</script>
<?php $this->load->end_inline_scripting(); ?>