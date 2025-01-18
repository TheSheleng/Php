<?php
class Home extends CI_Controller
{
	public function index()
	{
		$this->load->view('page1');
	}

	public function __construct()
	{
		parent::__construct();
		$this->load->model('home_model');
	}

	public function ItemsList()
	{
		$data['title']='List Of Items';
		$data['items']=$this->home_model->getItems();
		$this->load->view('items',$data);
	}

	public function getItemInfo()
	{
		$send=$this->input->post('send');
		if(!$send)
			$this->load->view('form_item_id');
		else
		{
			$id=$this->input->post('itemid');
			$item=$this->home_model->getItemById($id);
			$data['item']=$item;
			$data['title']='Description Of Items '.$id;
			$this->load->view('item_info',$data);
		}
	}

	function getItemInfo2()
	{
		if (!$this->input->post('send'))
		{
			$data['list']=$this->home_model->getItems() ;
			$this->load->view('form_item_id2',$data);
		}
		else
		{
			$id=$this->input->post('itemid');
			$item=$this->home_model->getItemById($id);
			$data['item']=$item;
			$data['title']='Description Of Items '.$id;
			$this->load->view('item_info',$data);
		}
	}

	public function selectImages()
	{
		$send=$this->input->post('send');
		if(!$send)
			$this->load->view('form_upload');
		else
		{
			$config['upload_path'] = './assets/images/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = 2048;
			$config['max_width'] = 1024;
			$config['max_height'] = 768;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('image'))
			{
				//receive data about upload
				$info = array('upload_data' => $this->upload->data());
				//path to the uploaded images folder
				$path='assets/images/';
				//create array $data for model method
				$data=array('itemid'=>1,
					'imagepath'=>$path.$info['upload_data']['file_name']);
				$itemid=$this->home_model->addImages($data);
				//create array for upload form with success message
				If($itemid != false)
				{
					$info = array('result' =>
						'Successfuly Inserted New Image With Id='.$itemid);
					$this->load->view('form_upload', $info);
				}
			}
		}
	}

	public function selectMultipleImages()
	{
		$send = $this->input->post('send');
		if (!$send) {
			$this->load->view('form_upload_multiple');
		} else {
			$config['upload_path'] = './assets/images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg'; // Додано `|`
			$config['max_size'] = 2048;
			$config['max_width'] = 1024;
			$config['max_height'] = 768;

			$this->load->library('upload', $config);

			$number_of_files = count($_FILES['upfile']['name']); // Виправлено
			$files = $_FILES['upfile'];

			$error = [];
			$success = [];
			$final_files_data = [];

			for ($i = 0; $i < $number_of_files; $i++) {
				$_FILES['upfile']['name'] = $files['name'][$i];
				$_FILES['upfile']['type'] = $files['type'][$i];
				$_FILES['upfile']['tmp_name'] = $files['tmp_name'][$i];
				$_FILES['upfile']['error'] = $files['error'][$i];
				$_FILES['upfile']['size'] = $files['size'][$i];

				if ($_FILES['upfile']['error'] != 0) { // Виправлено
					$error['msg'.$i] = 'Not uploaded file: ' . $files['name'][$i];
					continue;
				}

				if (!$this->upload->do_upload('upfile')) {
					$error['msg'.$i] = 'Upload error for file: ' . $files['name'][$i];
				} else {
					$final_files_data[] = $this->upload->data();
					$info = end($final_files_data); // Останній файл
					$path = 'assets/images/';
					$data = [
						'itemid' => 1,
						'imagepath' => $path . $info['file_name']
					];

					$itemid = $this->home_model->addImages($data);
					$success['msg'.$i] = 'Successfully inserted new image with ID = ' . $itemid;
				}
			}

			var_dump($success);
			echo '<br/>';
			var_dump($error);

			$result['error'] = $error;
			$result['success'] = $success;
			$this->load->view('form_upload_multiple', $result);
		}
	}

	function registration()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login', 'User name',
			'trimrequiredmin_length[5]max_length[12]is_unique[customers.login]',
			array('required' => 'You have not filled %s.',
				'is_unique' => 'Value %s already exists.')
		);
		$this->form_validation->set_rules('pass1', 'Password',
			'trimrequiredmin_length[5]max_length[12]');
		$this->form_validation->set_rules('pass2', 'Password Confirmation',
			'requiredmatches[pass1]');
		$this->form_validation->set_rules('email', 'Email',
			'requiredvalid_email');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('form_validation');
		}
		else
		{
			$data['success']='Form data passed the validation';
			$this->load->view('form_validation',$data);
		}
	}

	function showMap()
	{
		$this->load->library('googlemaps');
		$config['center'] = '51.5137415,-0.5514789';
		$config['zoom'] = 'auto';
		$this->googlemaps->initialize($config);
		$marker = array();
		$marker['position'] = '51.5137415,-0.5514789';
		$this->googlemaps->add_marker($marker);
		$data['map'] = $this->googlemaps->create_map();
		$this->load->view('view_map', $data);
	}

	public function Catalog()
	{
		$category = $this->input->get('category');
		$price_min = $this->input->get('price_min');
		$price_max = $this->input->get('price_max');

		$data['title'] = 'Catalog';
		$data['items'] = $this->home_model->getFilteredItems($category, $price_min, $price_max);
		$data['categories'] = $this->home_model->getCategories();

		$this->load->view('catalog', $data);
	}

}
