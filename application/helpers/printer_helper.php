<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'third_party/escpos-php/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

function nathai_print_billing ($table, $current_orderings, $cash_payment, $cash_return)
{
	try {
		// Enter the share name for your USB printer here
		$connector = new WindowsPrintConnector("EPSON TM-T88V Receipt");;
		/* Print a "Hello world" receipt" */
		$printer = new Printer($connector);

		$printer->setTextSize(2, 2);
		$printer->text("  Na.Thai Restaurunt\n");
		$printer->setTextSize(1, 1);
		$printer->text("   2-27-12 Nishi-Asakusa, Taito-ku, Tokyo\n\n");
		$printer->text("                  Receipt\n");
		$printer->text("            ".date("Y-m-d H:i:s")."\n\n");
		$printer->text(sprintf("Billing No: %02d\n", $table->billing_no));
		$printer->text(sprintf("Table No: %-3s       Number of Customer: %2d", $table->table_no, $table->total_customer)."\n");
		$printer->text("------------------------------------------\n");
		
		$total = 0;
		foreach ($current_orderings as $key => $ordering) {
			$total += $ordering->quantity * $ordering->price;
			$printer->setTextSize(1, 1);
			$printer->text(sprintf("%2s. %-23s x%2s %10s", $key + 1, substr($ordering->name_en, 0, 20), $ordering->quantity, number_format($ordering->quantity * $ordering->price, 2))."\n");
		}
		$printer->setTextSize(1, 1);
		$printer->text("------------------------------------------\n");
		$printer->text(sprintf("                         Total: %10s\n", number_format($total, 2)));
		$printer->text(sprintf("                  Cash Payment: %10s\n", $cash_payment));
		$printer->text(sprintf("                   Cash Return: %10s\n\n", $cash_return));
		$printer->text("                 Thank you\n\n");
		$printer->cut();

		/* Close printer */
		$printer->close();
	} catch (Exception $e) {
		echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
	}
}