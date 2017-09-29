<h3><?php echo lang_filter($category, 'name');?></h3>
<!--Modal modify-->
<div class="panel-wrapper">
	<form id="form-category-modify" action="<?php echo site_url('admin/categories/modify/'.$category->id); ?>" method="post">
		<input type="hidden" name="category_id" value="<?php echo $category->id?>">
		<?php $old_menu_ids = array() ?>
		<select multiple="multiple" size="10" name="menu_ids[]" id="category_duallistbox" class="duallist">	
			<optgroup label="Uncategory">
				<?php foreach ($uncategory_menus as $key => $menu) : ?>
				<option value="<?php echo $menu->id;?>">
					<?php echo $menu->id.'. '.lang_filter($menu, 'name'); ?>
				</option>
				<?php endforeach; ?>
			</optgroup>
			<optgroup label="Category">
				<?php foreach ($menus as $key => $menu) : ?>

				<option value="<?php echo $menu->id;?>" <?php if($category->id==$menu->category_id){ echo 'selected = "selected"'; $old_menu_ids[] = $menu->id; }?>>
					<?php echo $menu->id.'. '.lang_filter($menu, 'name'); ?>
				</option>
				<?php endforeach; ?>
			</optgroup>
		</select>
		<input type="hidden" name="old_menu_ids" value=<?php echo json_encode($old_menu_ids) ?>>
		<br>		
		<a href=<?php echo site_url('admin/categories') ?> class="btn btn-default">Cancel</a>
		<button type="button" class="btn btn-primary submit">Save</button>
	</form>
</div>

<?php $this->load->start_inline_scripting(); ?>
<script type="text/javascript">
	// DualListBox initial
	var duallist = $('.duallist').bootstrapDualListbox({
		 moveOnSelect: false
	});
	// To refresh all list and submit
	$(".submit").click(function(){
		duallist.bootstrapDualListbox('refresh', true);
		$("#form-category-modify").submit();
	});
</script>
<?php $this->load->end_inline_scripting(); ?>