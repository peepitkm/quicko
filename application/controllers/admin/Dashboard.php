<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_template('default');
	}

	public function index()
	{
		$data = array(
			
		);
		$this->load->view('admin/dashboard', $data);
	}

	public function report()
	{
		$this->load->model('billings_model', 'billing');

		$monthly_income_query	= $this->db->query("SELECT YEAR(date) as year, MONTH(date) as month, SUM(total_price) as total FROM billings GROUP BY year, month");
		$result = $monthly_income_query->result();
		foreach ($result as $key => $value) {
			$value->lunch = $this->db->query("SELECT SUM(price*quantity) as total_price
											FROM ordering_items
											WHERE YEAR(date) ='{$value->year}'
											AND MONTH(date) = '{$value->month}'
											AND  time between '00:00' AND '16:00'")->row()->total_price;

			$value->dinner = $this->db->query("SELECT SUM(price*quantity) as total_price
											FROM ordering_items
											WHERE YEAR(date) ='{$value->year}'
											AND MONTH(date) = '{$value->month}'
											AND  time between '16:01' AND '23:59'")->row()->total_price;
			$value->customer = $this->db->query("SELECT SUM(total_customer) as total_customer
												FROM billings 
												WHERE YEAR(date) ='{$value->year}'
												AND MONTH(date) = '{$value->month}'")->row()->total_customer;
		}

		$data = array(
			'monthly_incomes' => $result
		);
		$this->load->view('admin/report', $data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */