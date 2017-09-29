<?php 

class Categories_model extends MY_Model {


	public function get_all_category_with_menu() {
		// load menu model
		$this->load->model('menus_model', 'menu');
		// get all category
		$categories = $this->order_by('ordered')->get_all();
		// by menus into each categories
		foreach ($categories as $key => $category) {
			$category->menus = $this->menu->order_by('ordered')->get_many_by('category_id', $category->id);
		}
		return $categories;
	}

}