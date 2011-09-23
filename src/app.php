<?php

/**
 * Reusable application (needed to make tests work)
 * 
 * @author Damien Pitard <dpitard at digitas.fr>
 * @version $Id$
 */

require_once __DIR__ . '/autoload.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app = new Application();

/**
 * Autoload
 */

$app->register(new Digex\Extension\ApplicationExtension(), array(
    'app_dir' => __DIR__.'/../app',
    'vendor_dir' => __DIR__.'/../vendor',
));

/**
 * Handle homepage
 */
$app->get('/', function() use ($app) {

    $html = $app['twig']->render('homepage.html.twig');

    $app['monolog']->addDebug('Testing the Monolog logging.');
            
    
    return new Response($html);
})->bind('homepage');

return $app;