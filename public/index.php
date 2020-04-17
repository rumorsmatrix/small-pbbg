<?php

use \App\Models\User;

require_once('../bootstrap.php');

$router = new AltoRouter();
$router->setBasePath('/small');

// load and map routes
$routes = require __DIR__ . '/../config/routes.php';
foreach ($routes as $route) {
	list($method, $url, $callback) = $route;
	$router->map($method, $url, $callback);
}

// match current request url
$match = $router->match();

// return response from callback or via a Controller class
if (is_array($match) && is_callable($match['target'])) {
	call_user_func_array( $match['target'], $match['params'] );

} elseif (is_array($match) && is_string($match['target']) && strpos($match['target'], '@') > 0) {
	list($class, $method) = explode("@", $match['target']);

	// do some authentication
	$user = null;

	if (isset($_COOKIE['session_id'])) {
		$session = (new \App\Models\Session)
			->where('session_id', $_COOKIE['session_id'])
			->get()
			->first();

		if ($session) $user = $session->getUser();
	}

	try {
		$controller_class =  "\App\Controllers\\" . $class;
		$controller = new $controller_class($match['params'], $user);

	} catch (\Exception $e) {
		if ($e->getMessage() == 'NOT_AUTH') {
			header( $_SERVER["SERVER_PROTOCOL"] . ' 403 Forbidden');
			die();

		} else {
	        header($_SERVER["SERVER_PROTOCOL"] . ' 500');
    	    header('Content-Type: text/plain');
        	echo "Something went terribly wrong during routing.";
		}
	}


	$result = $controller->$method();

	// vary result output based on type returned -- kind of ugly but I like it
	if (is_string($result)) {
		echo $result;

	} elseif (is_int($result)) {
		header($_SERVER["SERVER_PROTOCOL"] . ' ' . $result);

	} elseif (is_array($result)) {
		header('Content-Type: application/json');
		echo json_encode($result, JSON_PRETTY_PRINT);

	} else {
		header($_SERVER["SERVER_PROTOCOL"] . ' 500');
		header('Content-Type: text/plain');
		echo "Something went terribly wrong.";
	}

} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}

