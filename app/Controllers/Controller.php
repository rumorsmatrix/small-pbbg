<?php

namespace App\Controllers;
use App\User;

class Controller {

	protected $route_parameters = [];
	public $user = null;

	public function __construct($route_parameters = [])
	{
		$this->route_parameters = $route_parameters;
		$this->user = (new User)->where('id', 1)->first();
	}

	public function getRouteParameter(string $parameter) : string
	{
		return (!empty($this->route_parameters[$parameter]) ? $this->route_parameters[$parameter] : null);
	}

	public function view($view, $data = [])
	{
		$data['user'] = $this->user;

		$view_class = "\App\Views\\" . $view;
		return (new $view_class($data))();
	}

}
