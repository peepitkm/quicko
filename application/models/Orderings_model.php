<?php 

class Orderings_model extends MY_Model {

	public function get_next_ordering_no($date, $billing_no)
	{
		$sql = "SELECT COUNT(*) as date_ordering FROM orderings WHERE billing_no = '{$billing_no}' AND date = '{$date}'";
		$query = $this->db->query($sql);
		$row = $query->row();
		return $row->date_ordering + 1;
	}

	public function get_current_ordering($date, $billing_no, $ordering_no = NULL, $summary = FALSE)
	{
		if ($summary) {
			$this->db->select('i.date, i.billing_no, i.ordering_no, m.category_id, m.name_th, m.name_en, m.name_jp, m.name_kitchen, SUM(i.quantity) AS quantity ,i.price, m.type');
		}else{
			$this->db->select('i.date, i.billing_no, i.ordering_no, m.category_id, m.name_th, m.name_en, m.name_jp, m.name_kitchen, i.quantity ,i.price, m.type');
		}
		$this->db->join('menus m', 'i.menu_id = m.id');
		$this->db->where('i.date', $date);
		$this->db->where('i.billing_no', $billing_no);
		if ($ordering_no) {
			$this->db->where('i.ordering_no', $ordering_no);
		}
		if ($summary) {
			$this->db->order_by('m.type');
			$this->db->group_by('i.menu_id');
		}
		$query = $this->db->get('ordering_items i');
		return $query->result();
	}
	
}