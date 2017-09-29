<?php 

class Billings_model extends MY_Model {

	protected $billing_date = NULL;

	public function __construct()
    {
        parent::__construct();
        $billing_date = date('Y-m-d');
    }

	public function get_next_billing_no($today)
	{
		$sql = "SELECT COUNT(*) as today_billing FROM billings WHERE date = '{$today}'";
		$query = $this->db->query($sql);
		$row = $query->row();
		return $row->today_billing + 1;
	}

	public function get_billing($date, $billing_no)
	{
		$sql = "SELECT * FROM billings WHERE date = '{$date}' AND billing_no = '{$billing_no}'";
		$query = $this->db->query($sql);
		return $query->row();
	}

	public function get_current_total_price($today, $billing_no)
	{
		$sql = "SELECT SUM(quantity * price) as total_price".
				" FROM ordering_items".
				" WHERE date = '{$today}' AND billing_no = '{$billing_no}'";
		$query = $this->db->query($sql);
		$row = $query->row();
		return $row->total_price;
	}

	public function update_after_ordering($today, $billing_no, $data = array())
	{
		$this->db->where('date', $today);
		$this->db->where('billing_no', $billing_no);
		return $this->db->update($this->_table, $data);
	}

	public function get_billing_with_ordering($date, $summary = FALSE)
	{
		// load menu model
		$this->load->model('orderings_model', 'ordering');
		$billings = $this->get_many_by('date', $date);
		foreach ($billings as $key => $billing) {
			$billing->orderings = $this->ordering->get_current_ordering($date, $billing->billing_no, NULL, $summary);
		}
		return $billings;
	}

	public function get_one_billing_with_ordering($date, $billing_no, $summary = FALSE)
	{
		// load menu model
		$this->load->model('orderings_model', 'ordering');
		$billing = $this->get_by(array('date'=>$date, 'billing_no' => $billing_no));
		$billing->orderings = $this->ordering->get_current_ordering($date, $billing->billing_no, NULL, $summary);
		return $billing;
	}
	
}