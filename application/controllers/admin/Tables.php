<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tables extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// pre
		$this->load->helper('url');
		// set template
		$this->output->set_template('default');
		// load template components
	}

	public function index()
	{

		$this->load->model('tables_model', 'table');
		$data = array(
			'tables'=> $this->table->order_by('ISNULL(ordered), ordered')->get_all()
		);
		$this->load->view('admin/tables', $data);
	}

	public function add()
	{
		$this->load->model('tables_model', 'table');

		$post = $this->input->post();
		if(empty($post)){
			redirect('admin/tables');
		}

		$table_no 			= $this->input->post('table_no');
		$table_description 	= $this->input->post('table_description');

		if($table_no==""&&$table_description==""){
			redirect('admin/tables');
		}

		if($this->table->get_by('table_no',$table_no)==0){
			$this->table->insert(array(
		   		'table_no' 		=> $table_no,
		   		'description' 	=> $table_description
	 		));
		}
		
 		redirect('admin/tables');
	}

	public function delete(){
		$this->load->model('tables_model', 'table');

		$post = $this->input->post();
		if(empty($post)){
			redirect('admin/tables');
		}
		$table_no 			=  $this->input->post('table_no');

		$this->table->delete($table_no,true);

		redirect('admin/tables');
	}

	public function edit(){
		$this->load->model('tables_model', 'table');

		$post = $this->input->post();
		if(empty($post)){
			redirect('admin/tables');
		}
		$table_no 				= $this->input->post('table_no');
		$table_no_old			= $this->input->post('table_no_old');
		$table_description		= $this->input->post('table_description');
		$table_description_old	= $this->input->post('table_description_old');


		if($table_no == $table_no_old && $table_description == $table_description_old){
			redirect('admin/tables');
		}
		else if($table_no != $table_no_old&&$this->table->get_by('table_no',$table_no)!=0){
			//change table_no but there is already in the list
			redirect('admin/tables');
		}
		$this->table->update($table_no_old, array(
			'table_no'		=> $table_no,
			'description'	=> $table_description
		));

		redirect('admin/tables');
	}

	public function ajax_get_table()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("405 Method Not Allowed", 405);
		}

		$table_no = $this->input->post('table_no');
		$this->load->model('tables_model', 'table');
		
		$data = array(
			'table' => $this->table->get($table_no)
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

		$this->load->model('tables_model', 'table');
		
		$table_no 		= $this->input->post('table_no');
		$table_no_swap	= $this->input->post('table_no_swap');
		$ordered		= $this->input->post('ordered');
		$ordered_swap	= $this->input->post('ordered_swap');
		
		/*
		echo '<pre>';
		echo $table_no."! ".$table_no2."! ".$table_ordered1."! ".$table_ordered2;
		echo '</pre>';
		die();
		*/
		//update table_no1
		$this->db->trans_begin();
		echo $this->table->update($table_no, array(
			'ordered'		=> $ordered
		));
		//update table_no2
		echo $this->table->update($table_no_swap, array(
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

		$this->load->model('tables_model', 'table');
		
		$table_no 	= $this->input->post('table_no');
		$showed		= $this->input->post('showed');
		
		$this->table->update($table_no, array(
			'showed'		=> $showed
		));

		
	}


}

/* End of file Dashboard.php*/
/* Location: ./application/controllers/Dashboard.php */