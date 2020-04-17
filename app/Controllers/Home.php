<?php

namespace App\Controllers;

class Home extends Controller {

	public function index()
	{
		return $this->view('Dashboard');
	}

	public function login()
	{
		return $this->view('Login');
	}

	public function black_market()
	{
		return $this->view('BlackMarket');
	}

}
