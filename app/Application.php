<?php

use Digex\Application as DigexApplication;

/**
 * @author Damien Pitard <dpitard at digitas.fr>
 * @copyright Digitas France
 */
class Application extends DigexApplication
{    
    public function configure()
    {
        $this['app_dir'] = __DIR__;
        $this['vendor_dir'] = __DIR__.'/../vendor';
    }
    
    public function getControllers()
    {
        return array(
            //register you controllers here
            //...
            '/' => new \Digitas\Demo\Controller\DefaultControllerProvider(),
        );
    }
    
    public function getServices()
    {
        return array(
            new \Digex\Provider\LazyRegisterServiceProvider(),
            
            //register you providers here
            //...
        );
    }
}
