<?php

namespace Kartenmacherei\CQRSFramework\Library\File;

class Path
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $segments;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->segments = explode('/', trim($this->path, '/'));
    }

    /**
     * @return string
     */
    public function asString() : string
    {
        return $this->path;
    }

    /**
     * @param Path $path
     *
     * @return bool
     */
    public function equals(Path $path) : bool
    {
        return $this->asString() === $path->asString();
    }

    /**
     * @param Path $path
     *
     * @return bool
     */
    public function contains(Path $path) : bool
    {
        return (strstr($this->asString(), $path->asString()) !== false);
    }

    /**
     * @param Path $path
     *
     * @return bool
     */
    public function startsWith(Path $path) : bool
    {
        return (substr($this->asString(), 0, strlen($path->asString())) === $path->asString());
    }

    /**
     * @param int $index
     *
     * @return bool
     */
    public function hasSegment(int $index) : bool
    {
        return isset($this->segments[$index]);
    }

    /**
     * @param int $index
     *
     * @return string
     */
    public function segment(int $index) : string
    {
        return $this->segments[$index];
    }
}
