<?php

namespace App\Controllers;

use App\Models\View_Commune_Model;

class Commune_Controller extends BaseController
{

	public function index()
	{
		$commune_model = new View_Commune_Model();
		$commune = $commune_model->findAll();

		echo json_encode($commune);
	}

	//--------------------------------------------------------------------
}
