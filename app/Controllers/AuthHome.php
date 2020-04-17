<?php

namespace App\Controllers;

class AuthHome extends AuthenticatedController {

	public function test()
	{
		return $this->view('Test');
	}

}
