<?php

use Digex\Application as DigexApplication;
use Silex\Application as SilexApplication;
use Silex\ControllerProviderInterface;

/**
 * @author Damien Pitard <dpitard at digitas.fr>
 * @copyright Digitas France
 */
class Application extends DigexApplication
{
    public function configure(SilexApplication $app)
    {
        $app['app_dir'] = __DIR__;
        $app['vendor_dir'] = __DIR__.'/../vendor';
        
        $app->register(new \Digex\Provider\LazyRegisterServiceProvider());
        
        $app->mount('/', new \Digitas\Demo\Controller\DefaultControllerProvider());
    }
}
