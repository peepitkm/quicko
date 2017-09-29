<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function get_ordering_price_by_time($date = NULL)
	{
		$query = $this->db->query(" SELECT
									DATE_FORMAT(o.ordering_time, '%H:00' ) AS ordering_timestamp,
									SUM(i.quantity*i.price) AS total_price
									FROM orderings o
									JOIN ordering_items i ON o.date = i.date AND o.billing_no = i.billing_no AND o.ordering_no = i.ordering_no
									WHERE o.date = '{$date}'
									GROUP BY ordering_timestamp");
		return $query->result();
	}

	

	/*
		
		$today_top_menus_query = $this->db->query("	SELECT m.name_en, m.name_th, m.name_jp, COUNT(i.menu_id) AS amount
													FROM ordering_items i
													JOIN menus m ON i.menu_id = m.id
													WHERE i.date = '{$date}'
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
														AND time between '00:00' AND '15:00'");

		$today_dinner_income_query = $this->db->query("	SELECT SUM(price*quantity) as total_price
														FROM ordering_items
														WHERE date = '{$date}'
														AND time between '15:01' AND '23:59'");

		$monthly_income_query	= $this->db->query("SELECT SUM(total_price) as total_price
											FROM billings
											WHERE YEAR(date) = '{$year}'
											AND MONTH(date) = '{$month}'");

		$monthly_lunch_income_query = $this->db->query("	SELECT SUM(price*quantity) as total_price
														FROM ordering_items
														WHERE YEAR(date) ='{$year}'
														AND MONTH(date) = '{$month}'
														AND  time between '00:00' AND '15:00'");
		$monthly_dinner_income_query = $this->db->query("	SELECT SUM(price*quantity) as total_price
														FROM ordering_items
														WHERE YEAR(date) ='{$year}'
														AND MONTH(date) = '{$month}'
														AND  time between '15:01' AND '23:59'");
		$monthly_customer_query = $this->db->query("SELECT SUM(total_customer) as total_customer
													FROM billings 
													WHERE YEAR(date) ='{$year}'
														AND MONTH(date) = '{$month}'");
	*/

}

/* End of file Statistics_model.php */
/* Location: ./application/models/Statistics_model.php */