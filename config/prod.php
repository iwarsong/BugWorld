<?php

use Silex\Provider\MonologServiceProvider;
use QuickBug\Kernel;

// configure your app for the production environment
$app['var.path'] = dirname(__DIR__) . '/var';

$app['twig.path'] = array(dirname(__DIR__).'/templates');
$app['twig.options'] = array('cache' => $app['var.path'] . '/cache/twig');

$app['asset_version'] = 2;

if (file_exists(__DIR__ . '/paramaters.php')) {
    $app['paramaters'] = include __DIR__ . '/paramaters.php';
}

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => $app['var.path'] . '/logs/app.log',
));

$kernel = new Kernel($app['paramaters']);
$kernel->boot();