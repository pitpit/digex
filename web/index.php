<?php

umask(0000);  //This will let the permissions be 0777

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../app/app.php';
$app->run();