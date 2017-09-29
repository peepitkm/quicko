<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'third_party/escpos-php/autoload.php';

//use Mike42\Escpos\Printer;
//use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Ordering extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->set_template('default');
	}

	public function index()
	{
		$this->load->model('tables_model', 'table');
		$this->load->model('categories_model', 'category');
		$data = array(
			'tables'	=> $this->table->order_by('ordered')->get_all(),
			'categories' => $this->category->get_all_category_with_menu()
		);
		$this->load->view('ordering', $data);
	}

	public function order()
	{
		// requried post parameter...
		$post = $this->input->post();
		if (empty($post)) {
			redirect('ordering');
		}

		// load model
		$this->load->model('tables_model', 'table');
		$this->load->model('billings_model', 'billing');
		$this->load->model('orderings_model', 'ordering');
		$this->load->model('ordering_items_model', 'ordering_item');

		// single-values
		$billing_no		= $this->input->post('billing_no');
		$table_no		= $this->input->post('table_no');
		$total_customer	= $this->input->post('total_customer');
		$with_payment	= $this->input->post('with_payment');

		// multi-values
		$ids 			= $this->input->post('ids');
		$kitchens		= $this->input->post('kitchens');
		$prices			= $this->input->post('prices');
		$quantities 	= $this->input->post('quantities');

		//echo '<pre>';
		//print_r($ids);
		//print_r($quantities);
		//echo '</pre>';

		// transaction begin
		$this->db->trans_begin();

		// today in MySQL date format
		$today = date('Y-m-d');
		$time = date('H:i:s');

		// get next billing number for today
		if (empty($billing_no)) {
			$billing_no = $this->billing->get_next_billing_no($today);
			// create new billing
			$this->billing->insert(array(
				'date'			=> $today,
				'billing_no'	=> $billing_no,
				'table_no'		=> $table_no,
				'start'			=> $time
			));
		}

		// create new ordering
		$ordering_no = $this->ordering->get_next_ordering_no($today, $billing_no);
		$ordering_id = $this->ordering->insert(array(
			'date'				=> $today,
			'billing_no'		=> $billing_no,
			'ordering_no'		=> $ordering_no,
			'total_customer'	=> $total_customer,
			'ordering_time'		=> $time
		));

		// make a order items
		$total_price = $this->billing->get_current_total_price($today, $billing_no);
		$ordering_items = array();
		foreach ($quantities as $key => $quantity) {
			if (!empty($quantity)) {
				$total_price += $quantity * $prices[$key];
				$ordering_items[] = array(
					'date'			=> $today,
					'billing_no'	=> $billing_no,
					'ordering_no'	=> $ordering_no,
					'menu_id'		=> $ids[$key],
					'quantity'		=> $quantity,
					'price'			=> $prices[$key],
					'time'			=> $time
				);
			}
		}

		// add item into database
		$this->ordering_item->insert_many($ordering_items);

		// update table
		$this->table->update($table_no, array(
			'billing_date'		=> $today,
			'billing_no'		=> $billing_no,
			'table_no'			=> $table_no,
			'total_customer'	=> $total_customer,
			'total_price'		=> $total_price,
			'used'				=> 'Y'
		));

		// update billing
		$this->billing->update_after_ordering($today, $billing_no, array(
			'total_customer'	=> $total_customer,
			'total_price'		=> $total_price
		));

		// end transactions
		if ($this->db->trans_status() === TRUE) {
			// commit this transactions
			$this->db->trans_commit();

			// get current order
			$current_orderings = $this->ordering->get_current_ordering($today, $billing_no, $ordering_no);
			// call seft-function
			// $this->print_ordering($billing_no, $ordering_no, $table_no, $total_customer, $total_price, $current_orderings);
			if (!empty($with_payment) && $with_payment == 'Y') {
				// today in MySQL date format
				$table = $this->table->get($table_no);
				$current_orderings = $this->ordering->get_current_ordering($today, $table->billing_no, NULL, TRUE);
				// start transaction of payment
				$this->db->trans_begin();
				$this->billing->update_by(array(
					'date' => $today,
					'billing_no' => $billing_no
				), array(
					'end'=> $time,
					'payment_cash' => $cash_payment,
					'payment_return' => $cash_return,
					'payment_date' => date('Y-m-d H:i:s')
				));
				// do payment update and make this table is free.
				$this->table->update($table_no, array(
					'billing_no' => NULL, 
					'total_customer' => NULL, 
					'total_price' => NULL, 
					'used' => 'N'
				));
				if ($this->db->trans_status() === TRUE) {
					$this->db->trans_commit();
					// call seft-function
					// $this->print_billing($table, $current_orderings);
				} else {
					$this->db->trans_rollback();
				}
			}
		} else {
			// rollback this transactions
			$this->db->trans_rollback();
		}

		redirect ('ordering');
	}

	private function print_ordering($billing_no, $ordering_no, $table_no, $total_customer, $total_price, $current_orderings)
	{
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
			$printer->text(sprintf("Order No: %02d-%02d        %s\n", $billing_no, $ordering_no, date("Y-m-d H:i:s")));
			$printer->text("Table No: ");
			$printer->setTextSize(2, 1);
			$printer->text(sprintf("%-3s", $table_no));
			$printer->setTextSize(1, 1);
			$printer->text("            Customer: ");
			$printer->setTextSize(2, 1);
			$printer->text(sprintf("%2d", $total_customer));
			$printer->text("\n");
			$printer->setTextSize(1, 1);
			$printer->text("------------------------------------------\n");

			$total = 0;
			foreach ($current_orderings as $key => $ordering) {
				$total += $ordering->quantity * $ordering->price;
				$printer->setTextSize(1, 1);
				$printer->text(sprintf("%2s. %-20s @%-5s x%-2s %6s", $key + 1, substr($ordering->name_en, 0, 20), number_format($ordering->price), $ordering->quantity, number_format($ordering->quantity * $ordering->price))."\n");
			}
			$printer->setTextSize(1, 1);
			$printer->text("------------------------------------------\n");
			$printer->text(sprintf("This Bill Total: %25s\n", number_format($total, 2)));
			$printer->text("          Total:");
			$printer->setTextSize(2, 1);
			$printer->text(sprintf("%13s\n\n", number_format($total_price)));
			$printer->cut();

			foreach ($current_orderings as $key => $ordering) {
				if ($ordering->type !== 'drink'){
					$printer->setTextSize(1, 1);
					$printer->text(date("Y-m-d H:i:s")."\n");
					$printer->setTextSize(2, 2);
					$printer->text(sprintf("%3s, %-12s >%2s", $table_no, substr($ordering->name_kitchen, 0, 12), $ordering->quantity)."\n");
					$printer->cut();
				}
			}

			/* Close printer */
			$printer->close();
		} catch (Exception $e) {
			echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
		}
	}

	private function print_billing($table, $current_orderings)
	{
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
			$printer->text("                  Receipt\n\n");
			$printer->text(sprintf("Billing No: %02d         %s\n", $table->billing_no, date("Y-m-d H:i:s")));
			$printer->text("Table No: ");
			$printer->setTextSize(2, 1);
			$printer->text(sprintf("%-3s", $table->table_no));
			$printer->setTextSize(1, 1);
			$printer->text("            Customer: ");
			$printer->setTextSize(2, 1);
			$printer->text(sprintf("%2d", $table->total_customer));
			$printer->text("\n");
			$printer->setTextSize(1, 1);
			$printer->text("------------------------------------------\n");
			
			$total = 0;
			foreach ($current_orderings as $key => $ordering) {
				$total += $ordering->quantity * $ordering->price;
				$printer->setTextSize(1, 1);
				if ($ordering->quantity > 0) {
					$printer->text(sprintf("%2s. %-20s @%-5s x%-2s %6s", $key + 1, substr($ordering->name_en, 0, 20), number_format($ordering->price), $ordering->quantity, number_format($ordering->quantity * $ordering->price))."\n");
				}
			}
			$printer->setTextSize(1, 1);
			$printer->text("------------------------------------------\n");
			$printer->text(sprintf("                         Total: %10s\n", number_format($total)));
			$printer->text(sprintf("                  Cash Payment: %10s\n", number_format($total)));
			$printer->text(sprintf("                   Cash Return: %10s\n\n", number_format(0)));
			$printer->text("                 Thank you\n\n");
			$printer->cut();

			/* Close printer */
			$printer->close();
		} catch (Exception $e) {
			echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
		}
	}
}

/* End of file Ordering.php */
/* Location: ./application/controllers/Ordering.php */