<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billing extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// set template
		$this->output->set_template('default');
		// load components
		$this->load->css('assets/css/jquery.treegrid.css');
		$this->load->js('assets/js/jquery.treegrid.min.js');
		$this->load->js('assets/js/jquery.treegrid.bootstrap3.js');
	}

	public function index()
	{
		$this->date(date('Y-m-d'));
	}

	public function date($date = NULL)
	{
		$this->load->model('billings_model', 'billing');

		$data = array(
			'billings' => $this->billing->get_billing_with_ordering($date, TRUE)
		);
		$this->load->view('admin/billing', $data);
	}

}

/* End of file Billing.php */
/* Location: ./application/controllers/Billing.php */