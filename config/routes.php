<?php

return [

	// web routes ---------------------------------------------
	['GET', '/', 'Home@index'],
	['GET', '/dashboard', 'Home@index'],
	['GET', '/test', 'Home@test'],
	['GET', '/black-market', 'Home@black_market'],


	// AJAX routes ---------------------------------------------
	['GET', '/ajax/test', 'Ajax\Content@test'],
	['GET', '/ajax/dashboard', 'Ajax\Content@dashboard'],
	['GET', '/ajax/black-market', 'Ajax\Content@black_market'],


	// API routes: Officers -----------------------------------
	['GET', '/api/officer/[i:officer_id]', 'Api\Officer@Officer'],
	['GET', '/api/officer/[i:officer_id]/current_task',	'Api\Officer@CurrentTask'],

];

