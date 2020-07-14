<?php

namespace App\Controllers;

use App\Models\View_Store_Model;

class Store_Controller extends BaseController
{

	public function index()
	{
		$store_model = new View_Store_Model();
		$store = $store_model->findAll();

		echo json_encode($store);
	}

	//--------------------------------------------------------------------
}
