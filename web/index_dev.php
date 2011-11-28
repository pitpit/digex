<?php

/**
 * @author Damien Pitard <dpitard at digitas.fr>
 * @version $Id$
 */

// This will let the permissions be 0777
//umask(0000); 

require_once __DIR__ . '/../src/autoload.php';

$app = new Silex\Application();
$app['app_dir'] = __DIR__.'/../app';
$app['vendor_dir'] = __DIR__.'/../vendor/silex/vendor';
$app['env'] = 'dev';

$mainControllerProvider = new Digitas\MainControllerProvider();
$app->register($mainControllerProvider);
$app->mount('/', $mainControllerProvider);

$app->run();
