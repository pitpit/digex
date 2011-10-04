<?php

namespace Digitas;

use Digex\StandardControllerProvider;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;

/**
 * @author Damien Pitard <dpitard at digitas dot fr>
 * @copyright Digitas France
 */
class MainControllerProvider extends StandardControllerProvider
{
    public function connect(Application $app)
    {
        $controllers = new ControllerCollection();
        $controllers->get('/', function() use ($app) {
            return $app['twig']->render('homepage.html.twig');
        });

        return $controllers;
    }
}
