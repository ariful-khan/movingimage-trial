<?php

namespace MovingImage\Service;

use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;

class FFMpegService
{
    private $ffMpeg;
    private $videoPath;
    private $imagePath;

    /**
     * @param FFMpeg $ffMpeg
     * @param string $videoPath
     * @param string $imagePath
     */
    public function __construct(FFMpeg $ffMpeg, string $videoPath, string $imagePath)
    {
        $this->ffMpeg = $ffMpeg;
        $this->videoPath = $videoPath;
        $this->imagePath = $imagePath;
    }

    /**
     * @param string $videoName
     * @param string $offset
     */
    public function generateImage(string $videoName, string $offset)
    {
        $video = $this->ffMpeg->open($this->getVideoPath($videoName));
        $frame = $video->frame(TimeCode::fromSeconds($offset));
        $frame->save($this->getImagePath($videoName, $offset));
    }

    /**
     * @param string $videoName
     * @param string $offset
     * @return string
     */
    public function getImagePath(string $videoName, string $offset): string
    {
        return $this->imagePath . '/' . $videoName . '-' . $offset;
    }

    /**
     * @param string $videoName
     * @return string
     */
    public function getVideoPath(string $videoName): string
    {
        return $this->videoPath . '/' . $videoName;
    }
}
