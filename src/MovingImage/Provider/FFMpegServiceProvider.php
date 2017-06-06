<?php

namespace MovingImage\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use MovingImage\Service\FFMpegService;
use FFMpeg\FFMpeg;

class FFMpegServiceProvider implements ServiceProviderInterface
{

    /**
     * {@inheritdoc}
     */
    public function boot(Container $app)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function register(Container $app)
    {
        $app['FFMpegService'] = new FFMpegService(
            FFMpeg::create(),
            $app['movingimage.video.path'],
            $app['movingimage.images.path']
        );
    }
}
