<?php

namespace App\Controllers;

class Controller {

	protected $route_parameters = [];

	public function __construct($route_parameters = [])
	{
		$this->route_parameters = $route_parameters;
	}

	public function getRouteParameter(string $parameter) : string
	{
		return (!empty($this->route_parameters[$parameter]) ? $this->route_parameters[$parameter] : null);
	}




}
