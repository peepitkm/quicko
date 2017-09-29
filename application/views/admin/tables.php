<!-- Button trigger modal -->
<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-table-add" data-backdrop="static" data-keyboard="false">
  +
</button>
<h3><?php echo lang('title_panel_tables')?></h3>

<div class="panel-wrapper">
<div class="table-responsive">
<table class="table table-striped">
	<thead>
		<tr>
			<th>#</th>
			<th><?php echo lang('title_table_no')?></th>
			<th><?php echo lang('title_showed')?></th>
			<th><?php echo lang('title_ordered')?></th>
			<th><?php echo lang('title_action')?></th>
		</tr>
	</thead>

	<tbody>
		<?php foreach ($tables as $key => $table) : ?>
		<tr data-table-no="<?php echo $table->table_no;?>">
			<td>
				<?php echo $key+1 ?>
			</td>
			<td>
				<?php echo $table->table_no?>
			</td>
			<td>
				<input class="showed" type="checkbox"<?php echo ($table->showed)?' checked="checked"':NULL;?>>
			</td>
			<td>
				<button type="button" class="btn btn-default btn-xs move"<?php echo ($key==0)?' disabled="disable"':NULL;?>>
					<span class="glyphicon glyphicon-arrow-up" aria-hidden="true" ></span>
				</button>
				<button type="button" class="btn btn-default btn-xs move"<?php echo ($key==count($tables)-1)?' disabled="disabled"':NULL;?>>
					<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
				</button>
			</td>
			<td>
				<button type="button" class="btn btn-default btn-xs edit" data-toggle="modal" data-target="#modal-table-edit" data-backdrop="static" data-keyboard="false">
					<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				</button>
				<button  type="button" class="btn btn-default btn-xs delete" data-toggle="modal" data-target="#modal-table-delete" data-backdrop="static" data-keyboard="false">
					<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
				</button>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>
</div>

<!-- Modal add-->
<form id="form-table-add" action="<?php echo site_url('admin/tables/add'); ?>" method="post">
	<div class="modal fade" id="modal-table-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><?php echo lang('title_add_table')?></h4>
	      </div>
	      <div class="modal-body">

			  <div class="form-group">
			    <label for="tableName"><?php echo lang('title_table_no')?></label>
			    <input type="text" name="table_no" id="table-add-name" class="form-control"  maxlength="3">
			  </div>
			  <div class="form-group">
			    <label for="tableName"><?php echo lang('title_table_description')?></label>
			    <textarea name="table_description" id="table-add-description" class="form-control"></textarea>
			  </div>
						
	      </div>
	      <div class="modal-footer">
	        <button id="cancle-button" type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('title_cancel')?></button>
	        <button type="submit" class="btn btn-primary"><?php echo lang('title_add')?></button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<!--/Modal add-->

<!--Modal delete-->
<form id="form-table-delete" action="<?php echo site_url('admin/tables/delete'); ?>" method="post">
	<div class="modal fade" id="modal-table-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Delete Table</h4>
	      </div>
	      <div class="modal-body">

			  <div class="form-group">
			    <label for="tableName"><?php echo lang('title_table_no')?></label>
			    <input type="text" name="table_no" id="table-delete-name" class="form-control"  maxlength="3" readonly="readonly">
			  </div>
			  <div class="form-group">
			    <label for="tableName"><?php echo lang('title_table_description')?></label>
			    <textarea name="table_description" id="table-delete-description" class="form-control" readonly="readonly">
			    </textarea>
			  </div>
						
	      </div>
	      <div class="modal-footer">
	        <button id="cancel-button" type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('title_cancel')?></button>
	        <button type="submit" class="btn btn-primary"><?php echo lang('title_delete')?></button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<!--/Modal delete-->

<!--Modal edit-->
<form id="form-table-edit" action="<?php echo site_url('admin/tables/edit'); ?>" method="post">
	<div class="modal fade" id="modal-table-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><?php echo lang('title_edit_table')?></h4>
	      </div>
	      <div class="modal-body">

			  <div class="form-group">
			    <label for="tableName"><?php echo lang('title_table_no')?></label>
			    <input type="text" name="table_no" id="table-edit-name" class="form-control"  maxlength="3">
			    <input type="hidden" name="table_no_old" id="table-edit-name-old" class="form-control"  maxlength="3">
			  </div>
			  <div class="form-group">
			    <label for="tableName"><?php echo lang('title_table_description')?></label>
			    <textarea name="table_description" id="table-edit-description" class="form-control">
			    </textarea>
			    <textarea name="table_description_old" id="table-edit-description-old" class="form-control" style="display:none;">
			    </textarea>
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
<!--/Modal edit-->



<?php $this->load->start_inline_scripting(); ?>
<script type="text/javascript">
$(document).ready(function() {

	$('input.showed').click(function(){
		var table_no = $(this).parent().parent().data("table-no");
		var showed = this.checked;
		//alert(showed);
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/tables/ajax_update_showed'); ?>",
			data: { "table_no": table_no,
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

		var table_no = td.data("table-no");
		var table_no_swap = td_swap.data("table-no");
		//alert(table_no+" "+table_no_swap);
		var temp = td.find("td:eq(1)").html();
		td.find("td:eq(1)").html(td_swap.find("td:eq(1)").html());
		td_swap.find("td:eq(1)").html(temp);

		td.data("table-no",table_no);
		td_swap.data("table-no",table_no_swap);

		//alert(current+"!!"+above);
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/tables/ajax_update_ordered'); ?>",
			data: { "table_no":table_no,
					"table_no_swap":table_no_swap,
					"ordered":index_swap+1,
					"ordered_swap":index+1 }
			//,success: function(result){alert(result);}
		
		});	
	});

	$("#cancle-button").click(function() {// clear value
		$('#table-add-name').val('');
		$('#table-add-description').val('');
	}); 

	$(".delete").click(function() {//load value
		var id = $(this).parent().parent().data("table-no");
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/tables/ajax_get_table'); ?>",
			data: {"table_no":id},
			success: function(data){
				$('#table-delete-name').val(data.table.table_no);
				$('#table-delete-description').val(data.table.description);
			}
		});
	});

	$(".edit").click(function() {//load value
		var id = $(this).parent().parent().data("table-no");
		$.ajax({
			type: "post",
			url: "<?php echo site_url('admin/tables/ajax_get_table'); ?>",
			data: {"table_no":id},
			success: function(data){
				$('#table-edit-name').val(data.table.table_no);
				$('#table-edit-name-old').val(data.table.table_no);
				$('#table-edit-description').val(data.table.description);
				$('#table-edit-description-old').val(data.table.description);
			}
		});
	});


});
</script>
<?php $this->load->end_inline_scripting(); ?>