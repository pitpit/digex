<?php

namespace Digitas\Demo\Model;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * @author Damien Pitard <dpitard at digitas dot fr>
 * @copyright Digitas France
 */
class DefaultModelProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $models = $app['models_factory'];

        $models->set('layout', function() {

            return array(
                'project_name' => 'Project Name',
                'menu' => array(
                    array(
                        'label' => 'menu 1',
                        'link' => '#',
                        'active' => true
                    ),
                    array(
                        'label' => 'menu 2',
                        'link' => '#',
                        'active' => false
                    ),
                    array(
                        'label' => 'menu 3',
                        'link' => '#',
                        'active' => false
                    ),
                ),
            );
        });

        $models->set('hello', function() use ($models) {

            return array_merge($models->get('layout'), array(
                'title' => 'A title',
                'head' => 'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.',
                'articles' => array(
                    array(
                        'title' => 'Heading',
                        'head' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.'
                    ),
                    array(
                        'title' => 'Heading',
                        'head' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.'
                    ),
                    array(
                        'title' => 'Heading',
                        'head' => 'Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.'
                    )
                )
            ));
        });
    }

    public function boot(Application $app) {}
}