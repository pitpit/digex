<?php

use Digex\Application as DigexApplication;

/**
 * @author Damien Pitard <dpitard at digitas.fr>
 * @copyright Digitas France
 */
class Application extends DigexApplication
{
    public function __construct()
    {
        $this['app_dir'] = __DIR__;
        $this['vendor_dir'] = __DIR__.'/../vendor';
        
        parent::__construct();
    }
}
