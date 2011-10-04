<?php

/**
 * @author Damien Pitard <dpitard at digitas.fr>
 * @version $Id$
 */

require_once __DIR__.'/../vendor/silex/autoload.php';
require_once __DIR__.'/../vendor/digex/autoload.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespace('Digitas', __DIR__);
$loader->register();