<?php

return [

	// web routes ---------------------------------------------
	['GET', '/', 		'Home@index'],
	['GET', '/test', 	'Home@test'],


	// AJAX routes ---------------------------------------------
	['GET', '/ajax/test', 'Ajax\Content@test'],
	['GET', '/ajax/dashboard', 'Ajax\Content@dashboard'],


	// API routes: Officers -----------------------------------
	['GET', '/api/officer/[i:officer_id]', 'Api\Officer@Officer'],
	['GET', '/api/officer/[i:officer_id]/current_task',	'Api\Officer@CurrentTask'],

];

