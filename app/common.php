<?php

$app['debug'] = (isset($env) && $env === 'dev');

$app->register(new Digex\Provider\ConfigurationServiceProvider(), array(
    'config.config_dir'    => __DIR__ . '/config',
    'config.env'    => isset($env)?$env:null,
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ . '/logs/' . (isset($env) ? $env : 'prod') . '.log',
    'monolog.name' => 'default'
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => $app['config']['db']['driver'],
        'dbname'    => isset($app['config']['db']['name']) ? $app['config']['db']['name'] : null,
        'path'    => isset($app['config']['db']['path']) ? $app['config']['db']['path'] : null,
        'host'      => $app['config']['db']['host'] ? $app['config']['db']['host'] : null,
        'user'      => $app['config']['db']['user'] ? $app['config']['db']['user'] : null,
        'password'  => $app['config']['db']['password'] ? $app['config']['db']['password'] : null
    )
));

$app->register(new Digex\Provider\DoctrineORMServiceProvider(), array(
    'em.options' => array(
        'proxy_dir'         => __DIR__ . '/cache/' . (isset($env) ? $env : 'prod') . '/proxies',
        'proxy_namespace'   => 'DoctrineORMProxy',
        'entities'          => $app['config']['em']['entities']
    ),
    'em.fixtures'              => $app['config']['em']['fixtures'],
));

//enable several annotation services in class
$loader = require __DIR__.'/../vendor/autoload.php';
Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$app->register(new Digex\Provider\AnnotationReaderServiceProvider());

/** CUSTOMIZE HERE **/