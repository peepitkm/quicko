<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// pre
		$this->load->helper('url');
		// set template
		$this->output->set_template('default');
		// load template components
		$this->load->css('assets/css/bootstrap-duallistbox.css');//duallistbox
		$this->load->js('assets/js/jquery.bootstrap-duallistbox.js');//duallistbox
	}

	public function index()
	{

		$this->load->model('categories_model','category');
		$data = array(
			'categories' 	=> $this->category->order_by('ISNULL(ordered), ordered')->get_all()
		);
		$this->load->view('admin/categories', $data);
	}

	public function add()
	{
		$this->load->model('categories_model', 'category');

		$post = $this->input->post();

		if(empty($post)){
			redirect('admin/categories');
		}

		$name_en 	= $this->input->post('name_en');
		$name_th 	= $this->input->post('name_th');
		$name_jp	= $this->input->post('name_jp');

		if(empty($name_en)&&empty($name_th)&&empty($name_jp)){
			redirect('admin/categories');
		}

		$this->db->trans_begin();
		$this->category->insert(array(
	   		'name_en' 	=> $name_en,
	   		'name_th' 	=> $name_th,
	   		'name_jp'	=> $name_jp
 		));

		if($this->db->trans_status() === false){
			$this->db->trans_rollback();
		}
		else{
			$this->db->trans_commit();
		}

 		redirect('admin/categories');
	}

	public function delete()
	{

		$this->load->model('categories_model', 'category');
		$this->load->model('menus_model', 'menu');

		$post = $this->input->post();
		if(empty($post)){
			redirect('admin/categories');
		}
		$category_id 		= $this->input->post('category_id');
		$category_id_new	= $this->input->post('category_id_new');
		$menu_ids 			= $this->input->post('menu_id');

		//echo count($menu_ids).' '.$category_id.' '.$category_id_new."!\n";
		
		$this->db->trans_begin();
		
		if(isset($menu_ids)){

			//update menu
			if($category_id_new==0)
				$category_id_new = NULL;
			foreach ($menu_ids as $key => $menu_id) {
				$this->menu->update($menu_id, array(
					'category_id'	=> $category_id_new,
					'ordered'		=> NULL
				));
			}
		}
		//echo $this->db->trans_status()."!!!\n";

		//delete category
		$this->category->delete($category_id);

		//echo $this->db->trans_status() ."!!!!\n";
		if($this->db->trans_status() === false){
			$this->db->trans_rollback();
		}
		else{
			$this->db->trans_commit();
		}
		//echo $this->db->trans_status() ."!!!!!\n";
		
		redirect('admin/categories');
		
	}

	public function edit()
	{
		$this->load->model('categories_model', 'category');

		$post = $this->input->post();
		if(empty($post)){
			redirect('admin/categories');
		}

		$category_id 		= $this->input->post('category_id');
		$name_en 			= $this->input->post('name_en');
		$name_en_old		= $this->input->post('name_en_old');
		$name_th 			= $this->input->post('name_th');
		$name_th_old		= $this->input->post('name_th_old');
		$name_jp 			= $this->input->post('name_jp');
		$name_jp_old		= $this->input->post('name_jp_old');


		if($name_en == $name_en_old && $name_th == $name_th_old && $name_jp == $name_jp_old){
			redirect('admin/categories');
		}

		$this->db->trans_begin();

		$this->category->update($category_id, array(
			'name_en'		=> $name_en,
			'name_th'		=> $name_th,
			'name_jp'		=> $name_jp
		));

		if($this->db->trans_status() === false){
			$this->db->trans_rollback();
		}
		else{
			$this->db->trans_commit();
		}

		redirect('admin/categories');

	}

	public function modify($id = NULL){

		if (empty($id)) {
			redirect();
		}
		$post = $this->input->post();
		if(!empty($post)){
			
			$this->load->model('menus_model', 'menu');
			$category_id 		= $this->input->post('category_id');
			$new_menu_ids 		= $this->input->post('menu_ids');
			$old_menu_ids		= $this->input->post('old_menu_ids');	
			$old_menu_ids		= json_decode($old_menu_ids);
			/*
			echo '<pre>';
			print_r($old_menu_ids);
			print_r($new_menu_ids);
			echo '</pre>';
			*/
			//die();
			$this->db->trans_begin();

			//release menu_old didn't select
			foreach ($old_menu_ids as $key => $old) {
				if(is_array($new_menu_ids) && !in_array($old, $new_menu_ids)){
					$this->menu->update($old, array(
						'category_id' => NULL,
						'ordered'		=> NULL
					));
				}
			}

			foreach ($new_menu_ids as $key => $new) {
				if(is_array($old_menu_ids) && !in_array($new, $old_menu_ids)){
					$this->menu->update($new, array(
						'category_id' => $category_id,
						'ordered'		=> NULL
					));
				}
			}

			if($this->db->trans_status() === false){
				$this->db->trans_rollback();
			}
			else{
				$this->db->trans_commit();
			}
			
			redirect('admin/categories/modify/'.$category_id);
		}
		else{

			$this->load->model('categories_model','category');
			$this->load->model('menus_model', 'menu');
			$data = array(
				'category' 			=> $this->category->get($id),

				'menus'		 		=> $this->menu->get_many_by('category_id IS NOT',NULL),
				'uncategory_menus' 	=> $this->menu->get_many_by('category_id',NULL)
			);
			$this->load->view('admin/category_modify', $data);
		}
	
	}

	public function ajax_get_category()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("405 Method Not Allowed", 405);
		}

		$category_id = $this->input->post('category_id');
		$this->load->model('categories_model', 'category');
		
		$data = array(
			'category' => $this->category->get($category_id)
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

		$this->load->model('categories_model', 'category');
		
		$category_id 		= $this->input->post('category_id');
		$category_id_swap	= $this->input->post('category_id_swap');
		$ordered			= $this->input->post('ordered');
		$ordered_swap		= $this->input->post('ordered_swap');
		
		//update category_id1
		echo $category_id+" "+$ordered;

		$this->db->trans_begin();
		$this->category->update($category_id, array(
			'ordered'		=> $ordered
		));
		//update category_id2
		$this->category->update($category_id_swap, array(
			'ordered'		=> $ordered_swap
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

		$this->load->model('categories_model', 'category');
		
		$category_id 	= $this->input->post('category_id');
		$showed		= $this->input->post('showed');
		
		$this->category->update($category_id, array(
			'showed'		=> $showed
		));
		
	}

}

/* End of file Categories.php*/
/* Location: ./application/controllers/Categories.php */