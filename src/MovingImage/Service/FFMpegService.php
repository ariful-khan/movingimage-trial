<?php

namespace MovingImage\Service;

use FFMpeg\Coordinate\TimeCode;

class FFMpegService
{
    private $ffMpeg;
    private $videoPath;
    private $imagePath;

    public function __construct($ffMpeg, $videoPath, $imagePath)
    {
        $this->ffMpeg = $ffMpeg;
        $this->videoPath = $videoPath;
        $this->imagePath = $imagePath;
    }

    public function generateImage($videoName, $offset)
    {
        $video = $this->ffMpeg->open($this->getVideoPath($videoName));
        $frame = $video->frame(TimeCode::fromSeconds($offset));
        $frame->save($this->getImagePath($videoName, $offset));
    }

    public function getImagePath($videoName, $offset)
    {
        return $this->imagePath . '/' . $videoName . '-' . $offset;
    }

    public function getVideoPath($videoName)
    {
        return $this->videoPath . '/' . $videoName;
    }
}
