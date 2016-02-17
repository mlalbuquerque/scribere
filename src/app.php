<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use App\Helper\PrinterHelperFactory;

$app = new Application();
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());

$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
    return $twig;
}));

$app['printer_helper'] = $app->share(function () {
    return PrinterHelperFactory::build();
});

return $app;
