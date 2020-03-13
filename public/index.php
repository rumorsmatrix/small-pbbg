<?php

	$relative_path_to_remove = 'small/';

	$request = [
		'url' => str_replace($relative_path_to_remove, '', $_SERVER['REDIRECT_URL']),
		'method' => $_SERVER['REQUEST_METHOD'],
		'params' => $_REQUEST,
		'cookies' => (!empty($_COOKIES) ? $_COOKIES : []),
	];

	include('../engine.php');

?>
