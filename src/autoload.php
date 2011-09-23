<?php

/**
 * @author Damien Pitard <dpitard at digitas.fr>
 * @version $Id$
 */

//we use the "phar::" notation to make it work on every systems
//require_once __DIR__.'/../vendor/silex/autoload.php';
require_once 'phar://' . __DIR__.'/../vendor/silex.phar/autoload.php';

//require_once __DIR__.'/../vendor/digex/autoload.php';
require_once 'phar://' . __DIR__.'/../vendor/digex.phar/autoload.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespace('Digitas', __DIR__);
$loader->register();