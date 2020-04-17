<?php

namespace App\Controllers;
use App\Models\User;

class AuthenticatedController extends Controller {

	protected $route_parameters = [];
	protected $user = null;

	public function __construct($route_parameters = [], User $user = null)
	{
		parent::__construct($route_parameters, $user);

		if (!$this->auth()) {
				throw new \Exception("NOT_AUTH");
		}
	}

}
