<?php

class Product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer/Product_model', 'Product_model');
	}

	public function index()
	{
		$data["page_title"] = "List product";
		$data["categories"] = $this->Product_model->getCategories();
		$data["products"] = $this->Product_model->getAllProducts();

		if ($this->input->post("keyword")) {
			$data["products"] = $this->Product_model->getSearchResult();
		}

		$this->load->view("customer/products/product_view", $data);
	}

	public function detail($slug)
	{
		// Получение данных о товаре
		$getTitle = $this->Product_model->getTitleBySlug($slug);
		$data["page_title"] = $getTitle["name"];
		$data["product"] = $this->Product_model->getProductBySlug($slug);
		$data["products"] = $this->Product_model->getLatestProduct();

		// Загрузка комментариев
		$data["comments"] = $this->Product_model->getCommentsByItemId($data["product"]["item_id"]);

		// Обработка формы добавления комментария
		if ($this->input->post("submit_comment")) {
			$commentData = [
				"item_id" => $data["product"]["item_id"],
				"user_name" => $this->input->post("user_name"),
				"comment" => $this->input->post("comment")
			];
			$this->Product_model->addComment($commentData);
			redirect("product/detail/" . $slug);
		}

		// Загрузка представления
		$this->load->view("customer/products/detail_view", $data);
	}
}
