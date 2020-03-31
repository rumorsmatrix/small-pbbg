<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Server as Server;
use Illuminate\Database\Capsule\Manager as Capsule;

// eloquent setup
$capsule = new Capsule;
$db_config = include(__DIR__ . '/../config/db.php');
$capsule->addConnection($db_config);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// websocket server setup
$server = new Server('wss://philcooper.org:8080', __DIR__ . '/rumorsmatrix.pem');
$server->startListening();


