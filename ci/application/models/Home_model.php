<?php
class Home_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function getItems()
	{
		$res = $this->db->get('items');
		return $res->result_array();
	}

	public function getItemById($id)
	{
		$query = $this->db->get_where('items', array('id' => $id));
		return $query->result_array();
	}

	public function addImages($data)
	{
		$insert = $this->db->insert("Images",$data);
		if($insert)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}

	public function getFilteredItems($category = null, $price_min = null, $price_max = null)
	{
		$this->db->select('*');
		$this->db->from('items');

		if ($category) {
			$this->db->where('catid', $category);
		}

		if ($price_min) {
			$this->db->where('pricesale >=', $price_min);
		}

		if ($price_max) {
			$this->db->where('pricesale <=', $price_max);
		}

		return $this->db->get()->result_array();
	}

	public function getCategories()
	{
		$this->db->select('id, category');
		$this->db->from('categories');
		return $this->db->get()->result_array();
	}
}
