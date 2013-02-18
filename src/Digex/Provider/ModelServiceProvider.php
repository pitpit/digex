<?php

namespace Digex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Digex\ModelCollection;

/**
 * @author Damien Pitard <dpitard at digitas.fr>
 * @copyright Digitas France
 */
class ModelServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['models_factory'] = $app->share(function() use ($app){

            if (!isset($app['digex.models'])) {
                $app['digex.models'] = array();
            }

            foreach($app['digex.models'] as $model) {
                // if (!$model instanceof ServiceProviderInterface) {
                //     throw new \Exception('You model class shoud extend Digex\ModelProviderInterface.');
                // }

                $app->register($model);
            }

            return new ModelCollection();
        });
    }

    public function boot(Application $app) {}
}