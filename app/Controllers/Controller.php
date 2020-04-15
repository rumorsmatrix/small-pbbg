<?php

namespace App\Controllers;
use App\Models\User;

class Controller {

	protected $route_parameters = [];
	protected $user = null;

	public function __construct($route_parameters = [])
	{
		$this->route_parameters = $route_parameters;

		// TODO: perform authentication vs. cookies etc. and see if user can view this page etc. here
		// ...probably make an Auth model that has a bunch of static methods for dealing with password hashes etc
		// ...actually maybe this should be done in the index boostrap/routing bit and the user passed here for checking

		// put the user on this model for access later on
		$this->user = (new User)->where('id', 1)->first();
	}

	public function getRouteParameter(string $parameter) : string
	{
		return (!empty($this->route_parameters[$parameter]) ? $this->route_parameters[$parameter] : null);
	}

	private function compileDataForView($data = [])
	{
		// pre-populate with things the view might need
		$data['route_parameters'] = $this->route_parameters;
		$data['user'] = $this->user;

		return $data;
	}

	public function view($view, $data = [])
	{
		$data = $this->compileDataForView($data);

		// instantiate and then execute the view's __invoke method
		$view_class = "\App\Views\\" . $view;
		return (new $view_class($data))();
	}

	public function template($template, $data = [])
	{
		$data = $this->compileDataForView($data);
		$view = new \App\Views\View($data);
		return $view->includeTemplate($template);
	}

}
