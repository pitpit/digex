<?php

$app = new Silex\Application();

require __DIR__ . '/common.php';

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallback' => $app['config']['translator']['locale_fallback']
));

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) use($app) {
    $translator->addLoader('yaml', new Symfony\Component\Translation\Loader\YamlFileLoader());

    foreach ($app['config']['translator']['locales'] as $locale => $filename) {
        $translator->addResource('yaml', __DIR__ . '/trans/' . $filename, $locale);
    }

    return $translator;
}));

$app->register(new Silex\Provider\FormServiceProvider());

$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
    'twig.options' => array(
        'cache' => __DIR__ . '/cache/' . (isset($env) ? $env : 'prod') . '/twig',
        'debug' => $app['debug']
    )
));

$app->before(function () use ($app) {
    $app['twig']->addGlobal('_locale', $app['request']->getLocale());
});

//Register your controllers here...
$app->mount('/', new Digitas\Demo\Controller\DefaultControllerProvider());

return $app;
