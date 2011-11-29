<?php

/**
 * @author Damien Pitard <dpitard at digitas dot fr>
 * @copyright Digitas France
 */

//require_once __DIR__.'/../vendor/silex/autoload.php';
require_once 'phar://'.__DIR__.'/../vendor/silex.phar/autoload.php';
//require_once __DIR__.'/../vendor/digex/autoload.php';
require_once 'phar://'.__DIR__.'/../vendor/digex.phar/autoload.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespace('Digitas', __DIR__.'/../src');
$loader->register();