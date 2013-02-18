<?php

$app = new Silex\Application();
$app['debug'] = (isset($env) && $env === 'dev');

if (PHP_SAPI === 'cli') {
    $app->register(new Digex\Provider\ConsoleServiceProvider());
}

$app->register(new Digex\Provider\ConfigurationServiceProvider(), array(
    'config.config_dir'    => __DIR__ . '/config',
    'config.env'    => isset($env)?$env:null,
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
    'twig.options' => array(
        'cache' => __DIR__ . '/cache/' . (isset($env) ? $env : 'prod') . '/twig',
        'debug' => $app['debug'],
        // 'strict_variables' => false
    )
));

// if ($app['debug']) {
//     $app['twig']->addExtension(new Digitas\Rush\Twig\Extension\Filler());
// }

$app->register(new Digex\Provider\ModelServiceProvider());


$app->register(new Digitas\Demo\Model\DefaultModelProvider());

//Register your controllers here...
$app->mount('/', new Digitas\Demo\Controller\DefaultControllerProvider());

return $app;