<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

$app['movingimage.api.username'] = 'arge1234@superrito.com';
$app['movingimage.api.password'] = 'GaSq7=t!';

$app->register(new SilexGuzzle\GuzzleServiceProvider(), array(
    'guzzle.base_uri' => "https://api-qa1.video-cdn.net/v1/",
    'guzzle.timeout' => 300,
));

$app['movingimage.video.path'] = __DIR__ . '/../var/files/video';
$app['movingimage.images.path'] = __DIR__ . '/../var/files/images';
$app->register(new MovingImage\Provider\FFMpegServiceProvider());

return $app;
