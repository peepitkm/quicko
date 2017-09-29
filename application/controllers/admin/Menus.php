<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// pre
		$this->load->helper('url');
		// set template
		$this->output->set_template('default');
		// load template components
		$this->load->js('assets/js/jquery.number.js');
	}

	public function index()
	{

		$this->load->model('categories_model','category');
		$this->load->model('menus_model', 'menu');
		$categories = $this->category->order_by('ISNULL(ordered), ordered')->get_all_category_with_menu('ISNULL(ordered), ordered');
		$uncategory = $this->menu->order_by('ISNULL(ordered), ordered')->get_many_by('category_id', NULL);
		
		array_push($categories, ((object)array(
			'id'		=> NULL,
			'name_en'	=> lang('title_uncategory'),
			'name_th'	=> lang('title_uncategory'),
			'name_jp'	=> lang('title_uncategory'),
			'parent_id' => NULL,
			'ordered'	=> NULL,
			'showed'	=> 1,
			'menus'		=> $uncategory
		)));

		$data = array(
			'categories' => $categories
		);

		$this->load->view('admin/menus', $data);
	}

	public function add()
	{
		$this->load->model('menus_model', 'menu');

		$post = $this->input->post();

		if(empty($post)){
			redirect('admin/menus');
		}

		$menu_no		= $this->input->post('menu_no');
		$name_en 		= $this->input->post('name_en');
		$name_th 		= $this->input->post('name_th');
		$name_jp		= $this->input->post('name_jp');
		$name_kitchen 	= $this->input->post('name_kitchen');
		$price 			= $this->input->post('price');
		$type			= $this->input->post('type');
		$category_id 	= $this->input->post('category_id');

		if(empty($menu_no)&&empty($name_en)&&empty($name_th)&&empty($name_jp)&&empty($name_kitchen)&&empty($price)){
			redirect('admin/menus');
		}

		$this->db->trans_begin();
		$this->menu->insert(array(
			'menu_no'		=> $menu_no,
	   		'name_en' 		=> $name_en,
	   		'name_th' 		=> $name_th,
	   		'name_jp'		=> $name_jp,
	   		'name_kitchen' 	=> $name_kitchen,
	   		'price' 		=> $price,
	   		'type'			=> $type,
	   		'category_id'	=> empty($category_id)? NULL : $category_id,
	   		'ordered'		=> NULL
 		));

		if($this->db->trans_status() === false){
			$this->db->trans_rollback();
		}
		else{
			$this->db->trans_commit();
		}

 		redirect('admin/menus');
	}

	public function delete()
	{

		$this->load->model('menus_model', 'menu');

		$post = $this->input->post();
		if(empty($post)){
			redirect('admin/menus');
		}

		$id = $this->input->post('id');

		// deelete
		$this->menu->delete($id);
		//
		redirect('admin/menus');
		
	}

	public function edit()
	{
		$this->load->model('menus_model', 'menu');

		$post = $this->input->post();
		if(empty($post)){
			redirect('admin/menus');
		}
	
		$id 				= $this->input->post('id');
		$menu_no			= $this->input->post('menu_no');
		$menu_no_old		= $this->input->post('menu_no_old');
		$name_en 			= $this->input->post('name_en');
		$name_en_old		= $this->input->post('name_en_old');
		$name_th 			= $this->input->post('name_th');
		$name_th_old		= $this->input->post('name_th_old');
		$name_jp 			= $this->input->post('name_jp');
		$name_jp_old		= $this->input->post('name_jp_old');
		$name_kitchen		= $this->input->post('name_kitchen');
		$name_kitchen_old	= $this->input->post('name_kitchen_old');
		$price 				= $this->input->post('price');
		$price_old			= $this->input->post('price_old');
		$type 				= $this->input->post('type');
		$type_old			= $this->input->post('type_old');
		$category_id 		= $this->input->post('category_id');
		$category_id_old 	= $this->input->post('category_id_old');

		//pre
		$price 				= str_replace(',', '', $price);

		$this->menu->update($id, array(
			'menu_no'		=> $menu_no,
			'name_en'		=> $name_en,
			'name_th'		=> $name_th,
			'name_jp'		=> $name_jp,
			'name_kitchen'	=> $name_kitchen,
			'price'			=> $price,
			'type'			=> $type,
			'category_id'	=> empty($category_id)? NULL : $category_id
		));

		redirect('admin/menus');
	}
	public function ajax_get_menu()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("405 Method Not Allowed", 405);
		}

		$menu_id = $this->input->post('menu_id');
		$this->load->model('menus_model', 'menu');

		$data = array(
			'menu' 	=> $this->menu->get($menu_id)
		);
		$this->output->set_content_type('application/json');
		$this->output->set_template('ajax');
    	$this->output->set_output(json_encode($data));	
	}

	public function ajax_update_ordered()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("405 Method Not Allowed", 405);
		}

		$this->load->model('menus_model', 'menu');
		
		$menu_id 		= $this->input->post('menu_id');
		$menu_id_swap		= $this->input->post('menu_id_swap');
		$ordered	= $this->input->post('ordered');
		$ordered_swap	= $this->input->post('ordered_swap');

		//update category_id1
		$this->db->trans_begin();
		$this->menu->update($menu_id, array(
			'ordered'		=> $ordered
		));
		//update category_id2
		$this->menu->update($menu_id_swap, array(
			'ordered'		=> $menu_id_swap
		));

		if($this->db->trans_status() === false){
			$this->db->trans_rollback();
		}
		else{
			$this->db->trans_commit();
		}
	}

	public function ajax_update_showed()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("405 Method Not Allowed", 405);
		}

		$this->load->model('menus_model', 'menu');
		
		$menu_id 	= $this->input->post('menu_id');
		$showed		= $this->input->post('showed');

		$this->menu->update($menu_id, array(
			'showed'		=> $showed
		));
	}

}

/* End of file Dashboard.php*/
/* Location: ./application/controllers/Dashboard.php */