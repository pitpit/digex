<?php

$app = new Silex\Application();

require __DIR__ . '/common.php';

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app['locale'] = $app['config']['translator']['default'];

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallback' => $app['config']['translator']['default']
));

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('yaml', new Symfony\Component\Translation\Loader\YamlFileLoader());

    $filename = __DIR__ . '/trans/' . $app['locale'] . '.yml';
    if (file_exists($filename)) {
        $translator->addResource('yaml', $filename, $app['locale']);
    }

    return $translator;
}));

$app->register(new Silex\Provider\FormServiceProvider());

$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Digex\Provider\AnnotationValidatorServiceProvider());

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\SecurityServiceProvider());

$app['security.firewalls'] = array(
    'unsecured' => array(
        'pattern' => '^/admin/login$',
        'anonymous' => true,
    ),
    'admin' => array(
        'pattern' => '^/admin',
        'form' => array(
            'login_path' => '/admin/login',
            'check_path' => '/admin/login_check'
        ),
        'logout' => array(
            'logout_path' => '/admin/logout',
        ),
        'users' => array(
            'admin' => array('ROLE_ADMIN', $app['config']['security']['admin_password']),
        )
    ),
);

$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN' => array('ROLE_USER', 'ROLE_ALLOWED_TO_SWITCH')
);

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
    'twig.options' => array(
        'cache' => __DIR__ . '/cache/' . (isset($env) ? $env : 'prod') . '/twig',
        'debug' => $app['debug']
    )
));

$app->before(function () use ($app) {

    if (!in_array($app['locale'], $app['config']['translator']['allowed'])) {
        throw new \Exception(sprintf('Locale "%s" is not allowed. see "translator.allowed" in app/config.yml.', $app['locale']));
    }

    $app['twig']->addGlobal('app', $app);

    //you should prefer to user {{ app.local }} in twig
    //but it's here for BC
    $app['twig']->addGlobal('_locale', $app['request']->getLocale());
});

//Register your controllers here...
$app->mount('/', new Digitas\Demo\Controller\DefaultControllerProvider());
$app->mount('/admin', new Digitas\Admin\Controller\SecurityControllerProvider());
$app->mount('/admin', new Digitas\Admin\Controller\DefaultControllerProvider());

return $app;
