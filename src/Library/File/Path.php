<?php

namespace Kartenmacherei\CQRSFramework\Library\File;

class Path
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function asString()
    {
        return $this->path;
    }

    /**
     * @param Path $path
     * @return bool
     */
    public function equals(Path $path)
    {
        return $this->asString() === $path->asString();
    }

    public function contains(Path $path)
    {
        return (strstr($this->asString(), $path->asString()) !== false);
    }

    public function startsWith(Path $path)
    {
        return (substr($this->asString(), 0, strlen($path->asString())) === $path->asString());
    }
}
