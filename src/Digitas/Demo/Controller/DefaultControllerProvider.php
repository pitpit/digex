<?php

namespace Digitas\Demo\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * @author Damien Pitard <dpitard at digitas dot fr>
 * @copyright Digitas France
 */
class DefaultControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        //dispatch
        $controllers->get('/', function() use ($app) {

            return $app->redirect($app['url_generator']->generate('homepage', array('locale' => $app['locale_fallback'])));
        });

        //homepage
        $controllers->get('/{_locale}', function($_locale) use ($app) {

            return $app['twig']->render('Demo/homepage.html.twig');
        })->bind('homepage');

        return $controllers;
    }
}
