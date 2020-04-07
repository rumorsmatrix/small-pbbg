<?php

use Illuminate\Database\Capsule\Manager as Capsule;
require __DIR__ . '/vendor/autoload.php';

// eloquent setup
$capsule = new Capsule;
$db_config = include(__DIR__ . '/config/db.php');
$capsule->addConnection($db_config);
$capsule->setAsGlobal();
$capsule->bootEloquent();
