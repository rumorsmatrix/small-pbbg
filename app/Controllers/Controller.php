<?php

namespace App\Controllers;
use App\Models\User;

class Controller {

	protected $route_parameters = [];
	protected $user = null;

	public function __construct($route_parameters = [], User $user = null)
	{
		$this->route_parameters = $route_parameters;
		$this->user = $user;
	}

	public function getRouteParameter(string $parameter) : ?string
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

	public function auth($admin_level = 0)
	{
		if (!$this->user) return false;
		return ($this->user->admin >= $admin_level);
	}

}
