<?php

namespace Digitas\Total\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Damien Pitard <dpitard at digitas dot fr>
 * @copyright Digitas France
 */
class DefaultControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $models = $app['models_factory'];

        $controllers->get('/', function() use ($app, $models) {

            return $app['twig']->render('Demo/hello.html.twig', $models->get('hello'));
        });

        return $controllers;
    }
}
