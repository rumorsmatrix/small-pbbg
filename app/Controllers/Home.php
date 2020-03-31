<?php

namespace App\Controllers;

class Home extends Controller {

	public function index()
	{
		return $this->view('Test');
	}

}
