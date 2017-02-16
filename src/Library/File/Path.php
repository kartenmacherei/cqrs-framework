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

    /**
     * @param Path $path
     *
     * @return bool
     */
    public function contains(Path $path)
    {
        return (strstr($this->asString(), $path->asString()) !== false);
    }

    /**
     * @param Path $path
     *
     * @return bool
     */
    public function startsWith(Path $path)
    {
        return (substr($this->asString(), 0, strlen($path->asString())) === $path->asString());
    }

    /**
     * @param int $index
     *
     * @return string
     */
    public function segment($index)
    {
        $segments = explode('/', trim($this->path, '/'));
        return $segments[$index];
    }
}
