<?php

/**
 * @author Damien Pitard <dpitard at digitas dot fr>
 * @copyright Digitas France
 */

// This will let the permissions be 0777
//umask(0000); 

require_once __DIR__ . '/../app/autoload.php';
require_once __DIR__ . '/../app/Application.php';

$app = new Application(new Silex\Application());
$app->run();