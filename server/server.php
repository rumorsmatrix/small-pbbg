<?php

require_once __DIR__ . '/../bootstrap.php';

// websocket server setup
$server = new App\Server('wss://philcooper.org:8080', __DIR__ . '/rumorsmatrix.pem');
$server->startListening();

