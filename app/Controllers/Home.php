<?php

namespace App\Controllers;

class Home extends Controller {

	public function index()
	{
		return $this->view('Dashboard');
	}

	public function test()
	{
		return (($this->user->id === 1)
			? $this->view('Test')
			: 404
		);
	}

}
