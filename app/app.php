<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

if (PHP_SAPI === 'cli') {
    $app->register(new \Digex\Provider\ConsoleServiceProvider());
}

$app->register(new \Digex\Provider\ConfigurationServiceProvider(), array(
    'config.config_dir'    => __DIR__ . '/config',
));

$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => $app['config']['db']['driver'],
        'dbname'    => $app['config']['db']['name'],
        'host'      => $app['config']['db']['host'],
        'user'      => $app['config']['db']['user'],
        'password'  => $app['config']['db']['password'],
    )
));

$app->register(new \Digex\Provider\DoctrineORMServiceProvider(), array(
    'em.options' => array(
        'proxy_dir'         => __DIR__ . '/cache/proxies',
        'proxy_namespace'   => 'DoctrineORMProxy',
        'entities'          => $app['config']['em']['entities']
    ),
    'em.fixtures'              => $app['config']['em']['fixtures'],
));

$app->register(new \Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new \Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallback' => $app['config']['translator']['locale_fallback']
));

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) use ($app) {
    $translator->addLoader('yaml', new \Symfony\Component\Translation\Loader\YamlFileLoader());

    foreach($app['config']['translator']['locales'] as $locale => $filename) {
        $translator->addResource('yaml', __DIR__ . '/trans/' . $filename, $locale);
    }

    return $translator;
}));

$app->register(new \Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
    'cache' => __DIR__ . '/cache/twig'
));

/*
//Form support, see http://silex.sensiolabs.org/doc/providers/form.html
$app->register(new \Silex\Provider\FormServiceProvider());
*/

/*
//Log support, see http://silex.sensiolabs.org/doc/providers/monolog.html
$app->register(new \Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile'       => __DIR__ . '/logs/app.log',
    'monolog.name'          => 'app'
));
 */

/*
//Mailing support, see http://silex.sensiolabs.org/doc/providers/swiftmailer.html
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
 */

if (PHP_SAPI !== 'cli') {

    //Set locale
    $app->before(function() use ($app) {
        $locale = $app['request']->get('_locale');
        if ($locale) {
            if (!isset($app['config']['translator']['locales'][$locale]) && $locale != $app['config']['translator']['locale_fallback']) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException(sprintf('Locale "%s" is not supported', $locale));
            }
            $app['twig']->addGlobal('locale', $locale);
        }
    });

    //Register your controllers here...
    $app->mount('/', new \Digitas\Demo\Controller\DefaultControllerProvider());

}

return $app;