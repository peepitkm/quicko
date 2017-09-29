<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'third_party/escpos-php/autoload.php';

// use Mike42\Escpos\Printer;
// use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Billing extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// set template
		$this->output->set_template('default');
		$this->load->js('assets/js/jquery.number.js');
		// load model
		$this->load->model('tables_model', 'table');
		$this->load->model('billings_model', 'billing');
		$this->load->model('orderings_model', 'ordering');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->number();
	}

	public function table($table_no = NULL)
	{
		$today = date('Y-m-d');
		$current_orderings = array();

		if (!empty($table_no)) {
			$table = $this->table->get($table_no);
			if (isset($table->billing_no)) {
				$current_orderings = $this->ordering->get_current_ordering($today, $table->billing_no);
			}
		}

		$data = array(
			'tables'		=> $this->table->get_all(),
			'current_orderings'	=> $current_orderings
		);

		$this->load->view('billing', $data);
	}

	public function number($billing_no = NULL, $billing_date = NULL, $table_no = NULL)
	{
		$today = date('Y-m-d');
		$orderings = array();

		if (!empty($billing_no) && !empty($billing_date)) {
			$billing = $this->billing->get_billing($billing_date, $billing_no);
			$orderings = $this->ordering->get_current_ordering($billing_date, $billing_no);
		}else if (!empty($billing_no)) {
			$billing = $this->billing->get_billing($today, $billing_no);
			$orderings = $this->ordering->get_current_ordering($today, $billing_no);
		}

		$data = array(
			'tables'			=> $this->table->get_all(),
			'current_table_no'	=> isset($billing) ? $billing->table_no : NULL,
			'current_orderings'	=> $orderings
		);

		$this->load->view('billing', $data);
	}

	public function check()
	{
		// requried post parameter...
		$post = $this->input->post();
		if (empty($post)) {
			redirect('billing');
		}

		// single-values
		$billing		= $this->input->post('billing');
		$total_price	= $this->input->post('total_price');
		$cash_payment	= $this->input->post('cash_payment');
		$cash_return	= $this->input->post('cash_return');

		if (empty($billing)) {
			redirect('billing');
		}

		// today in MySQL date format
		$today = date('Y-m-d');
		$time = date('H:i:s');

		list($billing_date, $billing_no) = explode(',', $billing);
		$cash_payment = str_replace(',', '', $cash_payment);
		$cash_return = str_replace(',', '', $cash_return);

		// query a billing by expected date
		if (!empty($billing_date) && $billing_date != $today && !empty($billing_no)) {
			$billing = $this->billing->get_billing($billing_date, $billing_no);
			$orderings = $this->ordering->get_current_ordering($billing_date, $billing_no, NULL, TRUE);
		}else if (!empty($billing_no)) {
			$billing = $this->billing->get_billing($today, $billing_no);
			$orderings = $this->ordering->get_current_ordering($today, $billing_no, NULL, TRUE);
		}

		// start transaction of payment
		$this->db->trans_begin();
		$this->billing->update_by(array(
			'date' => empty($billing_date) ? $today : $billing_date,
			'billing_no' => $billing_no
		), array(
			'end' => $time,
			'payment_cash' => $cash_payment,
			'payment_return' => $cash_return,
			'payment_date' => date('Y-m-d H:i:s')
		));
		// get table information
		$table = $this->table->get($billing->table_no);
		// do payment update and make this table is free.
		$this->table->update($billing->table_no, array(
			'billing_date' => NULL,
			'billing_no' => NULL, 
			'total_customer' => NULL, 
			'total_price' => NULL, 
			'used' => 'N'
		));
		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			// print receipt
			/*
			try {
				// Enter the share name for your USB printer here
				$connector = new WindowsPrintConnector("EPSON TM-T88V Receipt");;
				// Print a "Hello world" receipt"
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
				foreach ($orderings as $key => $ordering) {
					$total += $ordering->quantity * $ordering->price;
					$printer->setTextSize(1, 1);
					if ($ordering->quantity > 0) {
						$printer->text(sprintf("%2s. %-20s @%-5s x%-2s %6s", $key + 1, substr($ordering->name_en, 0, 20), number_format($ordering->price), $ordering->quantity, number_format($ordering->quantity * $ordering->price))."\n");
					}
				}
				$printer->setTextSize(1, 1);
				$printer->text("------------------------------------------\n");
				$printer->text(sprintf("                         Total: %10s\n", number_format($total)));
				$printer->text(sprintf("                  Cash Payment: %10s\n", number_format($cash_payment)));
				$printer->text(sprintf("                   Cash Return: %10s\n\n", number_format($cash_return)));
				$printer->text("                 Thank you\n\n");
				$printer->cut();

				// Close printer
				$printer->close();
			} catch (Exception $e) {
				echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
			}
			*/

		} else {
			$this->db->trans_rollback();
		}

		redirect('billing');
	}

	public function reprint($table_no = NULL)
	{
		if (empty($table_no)) {
			redirect('billing');
		}

		// today in MySQL date format
		$today = date('Y-m-d');
		$current_orderings = array();

		$table = $this->table->get($table_no);
		$current_orderings = $this->ordering->get_current_ordering($today, $table->billing_no, NULL, TRUE);
		
		/*
		try {
			// Enter the share name for your USB printer here
			$connector = new WindowsPrintConnector("EPSON TM-T88V Receipt");;
			// Print a "Hello world" receipt"
			$printer = new Printer($connector);

			$printer->setTextSize(2, 2);
			$printer->text("  Na.Thai Restaurant\n");
			$printer->setTextSize(1, 1);
			$printer->text("   Tokyo, Taito-ku, Nishi-Asakusa 2-27-12\n\n");
			$printer->text(sprintf("Order No: %02d           %s\n", $table->billing_no, date("Y-m-d H:i:s")));
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
			$printer->text("          Total:");
			$printer->setTextSize(2, 1);
			$printer->text(sprintf("%13s\n\n", number_format($total)));
			$printer->cut();

			// Close printer
			$printer->close();
		} catch (Exception $e) {
			echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
		}
		*/

		redirect ('billing/number/'.$table->billing_no);
	}
}
