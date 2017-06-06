<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

$app->post('/screen-shot', function (Request $request) use ($app) {
    $app['FFMpegService']->generateImage($request->get('videoId'), $request->get('offset', 0));
    return $app['twig']->render('index.html.twig', array(
        'url' => $request->getBaseUrl() . $app['url_generator']->generate('screen-shot-download',
                ['videoId' => $request->get('videoId'), 'offset' => $request->get('offset')]
            )));
})
    ->bind('screen-shot');


$app->get('/screen-shot/{videoId}/{offset}', function ($videoId, $offset) use ($app) {
    $response = new BinaryFileResponse($app['FFMpegService']->getImagePath($videoId, $offset));
    $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

    return $response;
})
    ->bind('screen-shot-download');

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/' . $code . '.html.twig',
        'errors/' . substr($code, 0, 2) . 'x.html.twig',
        'errors/' . substr($code, 0, 1) . 'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
