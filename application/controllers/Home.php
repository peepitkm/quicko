<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'third_party/escpos-php/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_template('default');

		$this->load->model('billings_model', 'billing');
	}

	public function index()
	{
		$this->load->model('billings_model', 'billing');
		// $date = '2016-07-07';
		// $month = '07';
		// $year = '2016';
		$date = date('Y-m-d');
		$month = date('m');
		$year = date('Y');

		$query = $this->db->query(" SELECT
									DATE_FORMAT(o.ordering_time, '%H:00' ) AS ordering_timestamp,
									SUM(i.quantity*i.price) AS total_price
									FROM orderings o
									JOIN ordering_items i ON o.date = i.date AND o.billing_no = i.billing_no AND o.ordering_no = i.ordering_no
									WHERE o.date = '{$date}'
									GROUP BY ordering_timestamp");

		$today_top_menus_query = $this->db->query("	SELECT m.name_en, m.name_th, m.name_jp, SUM(i.quantity) AS amount
													FROM ordering_items i
													JOIN menus m ON i.menu_id = m.id
													WHERE i.date = '{$date}'
													GROUP BY i.menu_id
													ORDER BY amount DESC
													LIMIT 10");
		// lunch
		$lunch_top_menus_query = $this->db->query("	SELECT m.name_en, m.name_th, m.name_jp, SUM(i.quantity) AS amount
													FROM ordering_items i
													JOIN menus m ON i.menu_id = m.id
													WHERE i.date = '{$date}' AND m.type != 'drink'
													AND time between '00:00' AND '16:00'
													GROUP BY i.menu_id
													ORDER BY amount DESC
													LIMIT 10");
		// dinner
		$dinner_top_menus_query = $this->db->query("	SELECT m.name_en, m.name_th, m.name_jp, SUM(i.quantity) AS amount
													FROM ordering_items i
													JOIN menus m ON i.menu_id = m.id
													WHERE i.date = '{$date}' AND m.type != 'drink'
													AND time between '16:01' AND '23:59'
													GROUP BY i.menu_id
													ORDER BY amount DESC
													LIMIT 10");
		// drink
		$drink_top_menus_query = $this->db->query("	SELECT m.name_en, m.name_th, m.name_jp, SUM(i.quantity) AS amount
													FROM ordering_items i
													JOIN menus m ON i.menu_id = m.id
													WHERE i.date = '{$date}' AND m.type = 'drink'
													AND time between '16:01' AND '23:59'
													GROUP BY i.menu_id
													ORDER BY amount DESC
													LIMIT 10");
		$today_customer_query = $this->db->query("	SELECT SUM(total_customer) as total_customer
													FROM billings 
													WHERE date = '{$date}'");

		$today_income_query	= $this->db->query("SELECT SUM(total_price) as total_price
											FROM billings
											WHERE date ='{$date}' ");

		$today_lunch_income_query = $this->db->query("	SELECT SUM(price*quantity) as total_price
														FROM ordering_items
														WHERE date = '{$date}'
														AND time between '00:00' AND '16:00'");

		$today_dinner_income_query = $this->db->query("	SELECT SUM(price*quantity) as total_price
														FROM ordering_items
														WHERE date = '{$date}'
														AND time between '16:01' AND '23:59'");

		$monthly_income_query	= $this->db->query("SELECT SUM(total_price) as total_price
											FROM billings
											WHERE YEAR(date) = '{$year}'
											AND MONTH(date) = '{$month}'");

		$monthly_lunch_income_query = $this->db->query("	SELECT SUM(price*quantity) as total_price
														FROM ordering_items
														WHERE YEAR(date) ='{$year}'
														AND MONTH(date) = '{$month}'
														AND  time between '00:00' AND '16:00'");
		$monthly_dinner_income_query = $this->db->query("	SELECT SUM(price*quantity) as total_price
														FROM ordering_items
														WHERE YEAR(date) ='{$year}'
														AND MONTH(date) = '{$month}'
														AND  time between '16:01' AND '23:59'");
		$monthly_customer_query = $this->db->query("SELECT SUM(total_customer) as total_customer
													FROM billings 
													WHERE YEAR(date) ='{$year}'
														AND MONTH(date) = '{$month}'");




		$data = array(
			'billings'				=> $this->billing->order_by('id', 'DESC')->get_billing_with_ordering($date, TRUE),
			'statistics'			=> $query->result(),
			'today_top_menus'		=> $today_top_menus_query->result(),
			'lunch_top_menus'		=> $lunch_top_menus_query->result(),
			'dinner_top_menus'		=> $dinner_top_menus_query->result(),
			'drink_top_menus_query'	=> $drink_top_menus_query->result(),
			'today_customer'		=> $today_customer_query->row(),
			'today_income'			=> $today_income_query->row(),
			'today_lunch_income'	=> $today_lunch_income_query->row(),
			'today_dinner_income'	=> $today_dinner_income_query->row(),
			'monthly_income'		=> $monthly_income_query->row(),
			'monthly_lunch_income'	=> $monthly_lunch_income_query->row(),
			'monthly_dinner_income'	=> $monthly_dinner_income_query->row(),
			'monthly_customer'		=> $monthly_customer_query->row()
		);

		$this->load->view('home', $data);
	}

	public function ajax_reprint()
	{
		if (!$this->input->is_ajax_request()) {
			show_error("405 Method Not Allowed", 405);
		}

		$billing_date 	= $this->input->post('billing_date');
		$billing_no		= $this->input->post('billing_no');

		$billing = $this->billing->get_one_billing_with_ordering($billing_date, $billing_no, NULL, TRUE);

		try {
			// Enter the share name for your USB printer here
			$connector = new WindowsPrintConnector("EPSON TM-T88V Receipt");;
			/* Print a "Hello world" receipt" */
			$printer = new Printer($connector);

			$printer->setTextSize(2, 2);
			$printer->text("  Na.Thai Restaurant\n");
			$printer->setTextSize(1, 1);
			$printer->text("   Tokyo, Taito-ku, Nishi-Asakusa 2-27-12\n");
			$printer->text("              Tel. 03-5246-4858\n\n");
			$printer->text(sprintf("Order No: %02d           %s\n", $billing->billing_no, date("Y-m-d H:i:s")));
			$printer->text("Table No: ");
			$printer->setTextSize(2, 1);
			$printer->text(sprintf("%-3s", $billing->table_no));
			$printer->setTextSize(1, 1);
			$printer->text("            Customer: ");
			$printer->setTextSize(2, 1);
			$printer->text(sprintf("%2d", $billing->total_customer));
			$printer->text("\n");
			$printer->setTextSize(1, 1);
			$printer->text("------------------------------------------\n");
			
			$total = 0;
			foreach ($billing->orderings as $key => $ordering) {
				$total += $ordering->quantity * $ordering->price;
				$printer->setTextSize(1, 1);
				if ($ordering->quantity > 0) {
					$printer->text(sprintf("%2s. %-20s @%-5s x%-2s %6s", $key + 1, substr($ordering->name_en, 0, 20), number_format($ordering->price), $ordering->quantity, number_format($ordering->quantity * $ordering->price))."\n");
				}
			}
			$printer->setTextSize(1, 1);
			$printer->text("------------------------------------------\n");
			$printer->text("          Total:");
			$printer->setTextSize(2, 1);
			$printer->text(sprintf("%13s\n\n", number_format($total)));
			$printer->cut();

			/* Close printer */
			$printer->close();
			// remove list of ordering before callback sending
			unset($billing->orderings);
			$data = array('code' => 200, 'message' => 'OK', 'billing' => $billing);
		} catch (Exception $e) {
			$data = array('code' => 500, 'message' => $e->getMessage());
		}

		$this->output->set_content_type('application/json');
		$this->output->set_template('ajax');
    	$this->output->set_output(json_encode($data));
	}
}
